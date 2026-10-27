@php
    use App\Enums\SubmissionStatus;
    use App\Enums\SubmissionType as T;
    use App\Http\Controllers\FormController as F;
    $d = $s->details ?? [];
    $date = fn ($v) => $v ? \Illuminate\Support\Carbon::parse($v)->format('j M Y') : null;
    $weekdays = (array) ccmc('weekdays');
    // Label => value for the request's own details, in reading order. Nulls are skipped.
    $rows = match ($s->type) {
        T::Appointment => [
            'Clinic or test' => $s->subject(),
            'Seen at CCMC before' => ['yes' => 'Yes', 'no' => 'No, first visit', 'unsure' => 'Not sure'][$d['seen_before'] ?? ''] ?? null,
            'Days that suit' => collect((array) ($d['days'] ?? []))->map(fn ($k) => $weekdays[$k] ?? $k)->implode(', ') ?: null,
            'Time of day' => ccmc('time_windows.'.($d['window'] ?? '')) ?: null,
            'Earliest date' => $date($d['from_date'] ?? null) ?? 'As soon as possible',
            'Reason' => $s->message,
        ],
        T::Dialysis => [
            'Situation' => F::dialysisSituations()[$d['situation'] ?? ''] ?? (ccmc('dialysis.situations.'.($d['situation'] ?? '')) ?: null),
            'Current unit or doctor' => $d['current_unit'] ?? null,
            'Days' => ccmc('dialysis.schedules.'.($d['schedule'] ?? '')) ?: null,
            'Time' => ccmc('dialysis.shifts.'.($d['shift'] ?? '')) ?: null,
            'Visiting' => ($d['visit_from'] ?? null) ? $date($d['visit_from']).' to '.$date($d['visit_to'] ?? null) : null,
            'Message' => $s->message,
        ],
        T::Registration => $canSeePersonal ? [
            'Patient' => $d['patient_name'] ?? null,
            'Date of birth' => $date($d['patient_dob'] ?? null),
            'Sex' => ['female' => 'Female', 'male' => 'Male', 'unsaid' => 'Prefer not to say'][$d['sex'] ?? ''] ?? null,
            'Filled in by' => ($d['for_whom'] ?? 'self') === 'other' ? $s->name.(($d['relationship'] ?? null) ? ' ('.$d['relationship'].')' : '') : 'The patient',
            'Address' => trim(($d['address'] ?? '').', '.($d['town'] ?? ''), ', ') ?: null,
            'ID to bring' => F::ID_TYPES[$d['id_type'] ?? ''] ?? null,
            // The form stores a boolean; older rows may hold 'yes'.
            'Insurance' => in_array($d['insured'] ?? null, [true, 'yes'], true) ? ($d['insurer'] ?? 'Yes') : 'None or not sure',
            'Emergency contact' => trim(($d['emergency_name'] ?? '').(($d['emergency_relationship'] ?? null) ? ' ('.$d['emergency_relationship'].')' : '').' · '.format_phone((string) ($d['emergency_phone'] ?? '')), ' ·'),
            'Reminders' => ! empty($d['reminders']) ? 'Yes, please' : 'No',
        ] : ['Details' => 'Restricted to the registration and medical records team.'],
        T::Career => [
            'Applying for' => $s->subject(),
            'Experience' => F::EXPERIENCE[$d['experience'] ?? ''] ?? null,
            'Registration no.' => $d['registration'] ?? null,
            'Available for' => collect((array) ($d['availability'] ?? []))->map(fn ($k) => ccmc('availability.'.$k) ?: $k)->implode(', ') ?: null,
            'Can start' => $date($d['available_from'] ?? null),
            'Note' => $s->message,
        ],
        T::Enquiry => [
            'Topic' => F::TOPICS[$d['topic'] ?? ''] ?? null,
            'Message' => $s->message,
        ],
    };
    if (in_array($s->type, [T::Appointment, T::Dialysis], true)) {
        $rows = ['Patient' => $s->patientName().(($d['for_whom'] ?? 'self') === 'other' ? ' (requested by '.$s->name.(($d['relationship'] ?? null) ? ', '.$d['relationship'] : '').')' : ''), 'Date of birth' => $date($d['patient_dob'] ?? null)] + $rows;
    }
    $rows = array_filter($rows, fn ($v) => $v !== null && $v !== '');
    $digits = nanp_digits($s->phone);
@endphp
<x-layouts.admin :title="$s->patientName()">
    <x-slot:actions>
        @if ($neighbours['prev'])<a href="{{ route('admin.submissions.show', $neighbours['prev']) }}" class="a-btn a-btn-ghost w-11 px-0 ring-1 ring-line" aria-label="Previous request"><x-icon name="chevron-left" /></a>@endif
        @if ($neighbours['next'])<a href="{{ route('admin.submissions.show', $neighbours['next']) }}" class="a-btn a-btn-ghost w-11 px-0 ring-1 ring-line" aria-label="Next request"><x-icon name="chevron-right" /></a>@endif
        <a href="{{ route('admin.submissions.index') }}" class="a-btn a-btn-ghost ring-1 ring-line">Inbox</a>
    </x-slot:actions>

    <div class="mb-5 flex flex-wrap items-center gap-2 text-sm">
        <span class="chip"><x-icon :name="$s->type->icon()" />{{ $s->type->label() }}</span>
        <x-status :status="$s->status" :type="$s->type" />
        <span class="kbd num !text-sm">{{ $s->reference }}</span>
        <span class="text-ink-3">Received {{ $s->created_at->format('D j M Y, H:i') }} ({{ $s->created_at->diffForHumans() }})</span>
        @if ($s->isOverdue())<span class="chip" data-tone="critical"><x-icon name="clock" />Overdue: due {{ $s->dueAt()->diffForHumans() }}</span>@elseif($s->status === SubmissionStatus::New)<span class="chip" data-tone="attention"><x-icon name="clock" />Call by {{ $s->dueAt()->format('H:i') }}</span>@endif
        @if ($s->is_demo)<span class="demo-badge">Demo data</span>@endif
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1.5fr)_minmax(0,1fr)]">
        <div class="min-w-0 space-y-6">
            <section class="a-card p-5 md:p-6" aria-labelledby="who">
                <h2 id="who" class="font-semibold">Contact</h2>
                <dl class="dl-grid mt-4">
                    <dt>Name</dt><dd class="font-semibold">{{ $s->name }}</dd>
                    <dt>Phone</dt><dd><a href="{{ tel_href($s->phone) }}" class="inline-flex min-h-11 items-center font-semibold text-link num">{{ format_phone($s->phone) }}</a></dd>
                    @if ($s->email)<dt>Email</dt><dd><a href="mailto:{{ $s->email }}" class="inline-flex min-h-11 items-center break-all text-link">{{ $s->email }}</a></dd>@endif
                    <dt>Prefers</dt><dd>{{ ['phone' => 'Phone call', 'whatsapp' => 'WhatsApp', 'email' => 'Email'][$s->contact_pref] ?? $s->contact_pref }}</dd>
                    @if ($s->consented_at)<dt>Consent</dt><dd class="text-sm text-ink-2">Given {{ $s->consented_at->format('j M Y, H:i') }}</dd>@endif
                </dl>
                <div class="mt-5 flex flex-wrap gap-2">
                    <a href="{{ tel_href($s->phone) }}" class="a-btn a-btn-primary"><x-icon name="phone" class="h-4 w-4" />Call</a>
                    @if ($digits)<a href="{{ wa_href($s->phone, 'Hello, this is Cross Crossing Medical Centre about your request '.$s->reference.'.') }}" class="a-btn a-btn-ghost ring-1 ring-line" target="_blank" rel="noopener"><x-icon name="whatsapp" class="h-4 w-4" />WhatsApp</a>@endif
                </div>
            </section>

            <section class="a-card p-5 md:p-6" aria-labelledby="req">
                <h2 id="req" class="font-semibold">{{ $s->type->label() }}</h2>
                <dl class="dl-grid mt-4">
                    @foreach ($rows as $label => $value)<dt>{{ $label }}</dt><dd class="whitespace-pre-line">{{ $value }}</dd>@endforeach
                </dl>
            </section>

            <section class="a-card p-5 md:p-6" aria-labelledby="docs">
                <h2 id="docs" class="font-semibold">Documents</h2>
                @forelse ($s->files as $f)
                    @php($can = auth()->user()->can('openFile', [$s, $f]))
                    <div class="mt-3 flex flex-wrap items-center gap-3 rounded-lg border border-line p-3">
                        <x-icon :name="$f->isRestricted() ? 'lock' : 'file'" class="h-5 w-5 flex-none text-ink-3" />
                        <div class="min-w-0 flex-1"><p class="font-semibold">{{ $f->label() }}</p><p class="truncate text-xs text-ink-3">{{ $can ? $f->original_name : 'File name hidden' }} · {{ number_format($f->size / 1024) }} KB</p></div>
                        @if ($can)
                            <a href="{{ route('admin.submissions.file', [$s, $f]) }}" class="a-btn a-btn-ghost ring-1 ring-line" target="_blank" rel="noopener"><x-icon name="eye" class="h-4 w-4" />Open</a>
                            <a href="{{ route('admin.submissions.file', [$s, $f, 'download' => 1]) }}" class="a-btn a-btn-ghost w-11 px-0 ring-1 ring-line" aria-label="Download {{ $f->label() }}"><x-icon name="download" class="h-4 w-4" /></a>
                        @else
                            <span class="chip" data-tone="muted"><x-icon name="lock" />Records team only</span>
                        @endif
                    </div>
                @empty
                    <p class="mt-2 text-sm text-ink-3">No documents attached.</p>
                @endforelse
                @if ($s->files->contains(fn ($f) => $f->isRestricted()))
                    <p class="mt-4 text-xs text-ink-3">ID and insurance cards open for the registration and medical records team only. Every opening is logged with your name and the time.</p>
                @endif
            </section>

            <section id="timeline" class="a-card p-5 md:p-6" aria-labelledby="tl">
                <h2 id="tl" class="font-semibold">Timeline</h2>
                <form method="POST" action="{{ route('admin.submissions.note', $s) }}" class="mt-4 space-y-3">
                    @csrf
                    <label for="note-body" class="sr-only">Add a note</label>
                    <textarea id="note-body" name="body" rows="3" class="a-input w-full" placeholder="What happened on the call? Keep clinical detail in the patient file, not here." required maxlength="3000"></textarea>
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <label class="flex min-h-11 items-center gap-2 text-sm"><input type="checkbox" name="contacted" value="1" class="h-5 w-5 accent-[color:var(--primary)]">I spoke to them (counts as first contact and stops the call-back clock)</label>
                        <button class="a-btn a-btn-primary">Add note</button>
                    </div>
                </form>
                <ol class="mt-6 space-y-4 border-l-2 border-line pl-5">
                    @foreach ($s->notes->sortByDesc('id') as $n)
                        <li class="relative">
                            <span @class(['absolute -left-[1.72rem] top-1 grid h-5 w-5 place-items-center rounded-full ring-4 ring-surface', 'bg-[color:var(--attention)]' => $n->kind === 'access', 'bg-[color:var(--series-1)]' => $n->kind !== 'access']) aria-hidden="true"></span>
                            <p class="text-sm"><span class="font-semibold">{{ $n->user->name ?? 'Website' }}</span> <span class="text-ink-3">· {{ $n->created_at->format('j M, H:i') }}@if($n->kind === 'access') · document opened @endif</span></p>
                            <p class="mt-0.5 whitespace-pre-line">{{ $n->body }}</p>
                        </li>
                    @endforeach
                </ol>
            </section>
        </div>

        <aside class="min-w-0 space-y-6">
            <form method="POST" action="{{ route('admin.submissions.update', $s) }}" class="a-card space-y-4 p-5 md:p-6">
                @csrf @method('PATCH')
                <h2 class="font-semibold">Status</h2>
                <div class="grid gap-2">
                    @foreach ($s->type->statuses() as $st)
                        <label class="flex min-h-11 cursor-pointer items-center gap-3 rounded-lg border border-line px-3 has-[:checked]:border-[color:var(--primary)] has-[:checked]:bg-soft"><input type="radio" name="status" value="{{ $st->value }}" class="h-5 w-5 accent-[color:var(--primary)]" @checked($s->status === $st)><x-icon :name="$st->icon()" class="h-4 w-4 text-ink-3" />{{ $st->label($s->type) }}</label>
                    @endforeach
                </div>
                <div>
                    <label for="assigned_to" class="mb-1 block text-sm font-semibold">Assigned to</label>
                    <select id="assigned_to" name="assigned_to" class="a-input w-full"><option value="">Nobody</option>@foreach ($staff as $u)<option value="{{ $u->id }}" @selected($s->assigned_to === $u->id)>{{ $u->name }} ({{ $u->role->label() }})</option>@endforeach</select>
                </div>
                @if ($s->type->hasBooking())
                    <div class="grid grid-cols-[1fr_8rem] gap-3">
                        <div><label for="booked_date" class="mb-1 block text-sm font-semibold">{{ $s->type === T::Career ? 'Interview' : 'Booked' }} date</label><input id="booked_date" name="booked_date" type="date" value="{{ $s->booked_date?->toDateString() }}" class="a-input w-full"></div>
                        <div><label for="booked_time" class="mb-1 block text-sm font-semibold">Time</label><input id="booked_time" name="booked_time" type="time" value="{{ $s->booked_time }}" class="a-input w-full"></div>
                    </div>
                    <p class="text-xs text-ink-3">Setting a date moves a new or called-back request to {{ SubmissionStatus::Booked->label($s->type) }}.</p>
                @endif
                <button class="a-btn a-btn-primary w-full">Save</button>
            </form>
            <div class="a-card p-5 text-sm text-ink-2 md:p-6">
                <h2 class="font-semibold text-ink">Good to know</h2>
                <ul class="mt-3 list-disc space-y-1.5 pl-5">
                    <li>The patient was told: "We call back, usually within {{ $s->type->responseHours() }} {{ \Illuminate\Support\Str::plural('hour', $s->type->responseHours()) }}."</li>
                    <li>Emails to the patient never include health details. Give results by phone or in person only.</li>
                    @if ($s->source_url)<li class="break-all">Sent from {{ $s->source_url }}</li>@endif
                </ul>
            </div>
        </aside>
    </div>
</x-layouts.admin>
