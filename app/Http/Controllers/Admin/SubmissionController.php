<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SubmissionStatus;
use App\Enums\SubmissionType;
use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\SubmissionFile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/** The requests inbox: every web submission the signed-in role works, new first. */
class SubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $user = $this->user($request);
        $filters = $this->filters($request, $user);
        $base = Submission::visibleTo($user);

        $counts = (clone $base)->filter(array_merge($filters, ['status' => null]))
            ->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $type = SubmissionType::tryFrom((string) $filters['type']);

        return view('admin.submissions.index', [
            'submissions' => (clone $base)->with(['jobPosting', 'assignee'])->withCount('files')->filter($filters)->inboxOrder()
                ->paginate(25)->withQueryString(),
            'filters' => $filters,
            'counts' => $counts,
            'type' => $type,
            'types' => $user->role->types(),
            'staff' => User::active()->orderBy('name')->get(['id', 'name', 'role']),
        ]);
    }

    public function show(Request $request, Submission $submission): View
    {
        Gate::authorize('view', $submission);
        $submission->load(['jobPosting', 'assignee', 'notes.user', 'files']);
        $user = $this->user($request);
        // Previous / next in the same order as the inbox.
        $ids = Submission::visibleTo($user)->inboxOrder()->pluck('id');
        $pos = $ids->search($submission->id);

        return view('admin.submissions.show', [
            's' => $submission,
            'staff' => User::active()->orderBy('name')->get(['id', 'name', 'role'])
                ->filter(fn (User $u) => $u->canWork($submission->type))->values(),
            'canSeePersonal' => $user->can('viewPersonalDetails', $submission),
            'neighbours' => [
                'prev' => $pos !== false ? $ids->get($pos - 1) : null,
                'next' => $pos !== false ? $ids->get($pos + 1) : null,
            ],
        ]);
    }

    public function update(Request $request, Submission $submission): RedirectResponse
    {
        Gate::authorize('update', $submission);
        $user = $this->user($request);
        $data = $request->validate([
            'status' => ['sometimes', Rule::enum(SubmissionStatus::class)],
            'assigned_to' => ['sometimes', 'nullable', 'integer', Rule::exists('users', 'id')->where('active', true)],
            'booked_date' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'booked_time' => ['sometimes', 'nullable', 'date_format:H:i'],
        ], [], ['booked_date' => 'booked date', 'booked_time' => 'booked time']);

        if (isset($data['status']) && $submission->moveTo($status = SubmissionStatus::from($data['status']))) {
            $submission->notes()->create(['user_id' => $user->id, 'kind' => 'status', 'body' => 'Status changed to '.$status->label($submission->type).'.']);
        }
        // The form posts the id as a string; compare as integers so an unchanged choice adds no note.
        $assignTo = isset($data['assigned_to']) ? (int) $data['assigned_to'] : null;
        if (array_key_exists('assigned_to', $data) && $submission->assigned_to !== $assignTo) {
            $assignee = $assignTo ? User::find($assignTo) : null;
            if ($assignee && ! $assignee->canWork($submission->type)) {
                return back()->withErrors(['assigned_to' => "{$assignee->name} works in {$assignee->role->label()} and can't see this request."]);
            }
            $submission->assigned_to = $assignee?->id;
            $submission->notes()->create(['user_id' => $user->id, 'kind' => 'assign', 'body' => $assignee ? "Assigned to {$assignee->name}." : 'Unassigned.']);
        }
        if (array_key_exists('booked_date', $data) && $submission->type->hasBooking()) {
            $old = trim($submission->booked_date?->toDateString().' '.$submission->booked_time);
            $submission->booked_date = $data['booked_date'] ? Carbon::parse($data['booked_date']) : null;
            $submission->booked_time = $submission->booked_date ? ($data['booked_time'] ?? $submission->booked_time) : null;
            $new = trim($submission->booked_date?->toDateString().' '.$submission->booked_time);
            if ($old !== $new) {
                $submission->notes()->create(['user_id' => $user->id, 'kind' => 'status', 'body' => $submission->booked_date
                    ? 'Booked for '.$submission->booked_date->format('D j M').($submission->booked_time ? ' at '.$submission->booked_time : '').'.'
                    : 'Booking removed.']);
                // Booking a date on a new or called-back request moves it to Booked.
                if ($submission->booked_date && in_array($submission->status, [SubmissionStatus::New, SubmissionStatus::Contacted], true)) {
                    $submission->moveTo(SubmissionStatus::Booked);
                }
            }
        }
        $submission->save();

        return back()->with('status', "{$submission->reference} saved.");
    }

    public function note(Request $request, Submission $submission): RedirectResponse
    {
        Gate::authorize('update', $submission);
        $data = $request->validate(['body' => ['required', 'string', 'max:3000'], 'contacted' => ['nullable', 'boolean']]);
        $user = $this->user($request);

        $submission->notes()->create(['user_id' => $user->id, 'kind' => 'note', 'body' => $data['body']]);
        // Logging a call on a new request counts as first contact.
        if (! empty($data['contacted']) && $submission->status === SubmissionStatus::New) {
            $submission->moveTo(SubmissionStatus::Contacted);
            $submission->notes()->create(['user_id' => $user->id, 'kind' => 'status', 'body' => 'Status changed to '.SubmissionStatus::Contacted->label($submission->type).'.']);
        }
        $submission->first_contacted_at ??= ! empty($data['contacted']) ? now() : null;
        $submission->save();

        return back()->with('status', 'Note added.')->withFragment('timeline');
    }

    /**
     * Uploads stream from the private disk. ID and insurance cards: records role only.
     * Every opening is written to file_accesses and the request's timeline.
     */
    public function file(Request $request, Submission $submission, SubmissionFile $file): StreamedResponse
    {
        Gate::authorize('openFile', [$submission, $file]);
        abort_unless(Storage::disk('local')->exists($file->path), 404);

        $user = $this->user($request);
        $file->accesses()->create(['submission_id' => $submission->id, 'user_id' => $user->id, 'ip' => $request->ip()]);
        $submission->notes()->create(['user_id' => $user->id, 'kind' => 'access', 'body' => "Opened {$file->label()} ({$file->original_name})."]);
        $name = Str::slug($submission->reference.'-'.$file->label()).'.'.pathinfo($file->path, PATHINFO_EXTENSION);
        $headers = ['Cache-Control' => 'private, no-store', 'X-Robots-Tag' => 'noindex'];

        return ($file->isImage() || $file->mime === 'application/pdf') && ! $request->boolean('download')
            ? Storage::disk('local')->response($file->path, $name, $headers)
            : Storage::disk('local')->download($file->path, $name, $headers);
    }

    /** Contact and status columns only: no reasons, dates of birth, insurers or addresses leave the system. */
    public function export(Request $request): StreamedResponse
    {
        $user = $this->user($request);
        $query = Submission::visibleTo($user)->with(['jobPosting', 'assignee'])->filter($this->filters($request, $user));

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // byte-order mark so Excel reads accents correctly
            fputcsv($out, ['Reference', 'Received', 'Type', 'Status', 'Name', 'Phone', 'Email', 'Prefers', 'About', 'Booked', 'Assigned to', 'First contact', 'Minutes to first contact', 'Demo'], escape: '');
            foreach ($query->lazyByIdDesc(500) as $s) {
                /** @var Submission $s */
                fputcsv($out, array_map(self::csvSafe(...), [
                    $s->reference, $s->created_at->format('Y-m-d H:i'), $s->type->label(), $s->statusLabel(), $s->name,
                    format_phone($s->phone), $s->email, $s->contact_pref, $s->subject(),
                    $s->booked_date ? $s->booked_date->format('Y-m-d').' '.$s->booked_time : '',
                    $s->assignee->name ?? '', $s->first_contacted_at?->format('Y-m-d H:i'),
                    $s->first_contacted_at ? (string) (int) $s->created_at->diffInMinutes($s->first_contacted_at) : '',
                    $s->is_demo ? 'yes' : '',
                ]), escape: '');
            }
            fclose($out);
        }, 'ccmc-requests-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /** Text starting with = + - @ would run as a formula in Excel, so it gets a leading quote. */
    private static function csvSafe(mixed $value): string
    {
        $value = (string) $value;

        return preg_match('/^[=+\-@\t\r]/', $value) ? "'".$value : $value;
    }

    /** @return array<string, string|null> */
    private function filters(Request $request, User $user): array
    {
        $type = SubmissionType::tryFrom(input_string($request->query('type')));
        $statusIn = input_string($request->query('status'));
        $assigned = input_string($request->query('assigned'));
        $service = input_string($request->query('service'));

        return [
            'type' => $type && $user->canWork($type) ? $type->value : null,
            'status' => $statusIn === 'open' ? 'open' : SubmissionStatus::tryFrom($statusIn)?->value,
            'service' => $service !== '' && Submission::serviceLabel($service) !== null ? $service : null,
            'assigned' => match (true) {
                $assigned === 'me' => (string) $user->id,
                $assigned === 'none', ctype_digit($assigned) => $assigned,
                default => null,
            },
            'overdue' => $request->boolean('overdue') ? '1' : null,
            'q' => input_string($request->query('q')) ?: null,
        ];
    }

    private function user(Request $request): User
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        return $user;
    }
}
