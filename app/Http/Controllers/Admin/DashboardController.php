<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Enums\SubmissionStatus;
use App\Enums\SubmissionType;
use App\Http\Controllers\Controller;
use App\Models\FileAccess;
use App\Models\JobPosting;
use App\Models\Submission;
use App\Models\User;
use App\Support\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private const int CHART_DAYS = 30;

    public function __invoke(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $role = $user->role;
        $mine = fn () => Submission::visibleTo($user);
        $chartStart = today()->subDays(self::CHART_DAYS - 1);

        // The headline: what this role must act on first (Role::headlineTypes).
        $headline = Submission::ofTypes($role->headlineTypes())->overdue();
        $oldest = (clone $headline)->min('created_at');

        $dates = $mine()->where('created_at', '>=', $chartStart)->pluck('created_at')->countBy(fn (Carbon $d) => $d->toDateString());
        $daily = collect(range(0, self::CHART_DAYS - 1))->map(function (int $i) use ($chartStart, $dates) {
            $day = $chartStart->copy()->addDays($i);

            return ['date' => $day, 'count' => (int) ($dates[$day->toDateString()] ?? 0)];
        });

        // Median minutes from arrival to first contact over the last 30 days.
        $responses = $mine()->whereNotNull('first_contacted_at')->where('created_at', '>=', now()->subDays(30))->get(['created_at', 'first_contacted_at'])
            ->map(fn (Submission $s) => (int) $s->created_at->diffInMinutes($s->first_contacted_at))->sort()->values();

        $tiles = [
            ['label' => 'New requests, last 7 days', 'value' => $mine()->where('created_at', '>=', now()->subDays(7))->count(),
                'previous' => $mine()->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count(), 'period' => 'vs previous 7 days',
                'href' => route('admin.submissions.index')],
            ['label' => 'Median time to first call', 'value' => $responses->isEmpty() ? null : (int) $responses->median(), 'format' => 'minutes',
                'note' => 'last 30 days, '.$responses->count().' requests', 'href' => route('admin.submissions.index')],
        ];
        if ($user->canWork(SubmissionType::Appointment)) {
            $tiles[] = ['label' => 'Booked, next 7 days', 'value' => $mine()->ofTypes([SubmissionType::Appointment, SubmissionType::Dialysis])
                ->where('status', '!=', SubmissionStatus::Closed)->whereBetween('booked_date', [today(), today()->addDays(6)])->count(),
                'note' => 'appointments and dialysis assessments', 'href' => route('admin.appointments.index')];
        }
        if ($user->canWork(SubmissionType::Registration)) {
            $tiles[] = ['label' => 'Registrations to check', 'value' => $mine()->where('type', SubmissionType::Registration)
                ->whereIn('status', [SubmissionStatus::New, SubmissionStatus::Contacted])->count(),
                'note' => 'before the patient\'s first visit', 'href' => route('admin.submissions.index', ['type' => 'registration', 'status' => 'open'])];
        }
        if ($user->canWork(SubmissionType::Career)) {
            $tiles[] = ['label' => 'Open vacancies', 'value' => JobPosting::open()->count(),
                'note' => $mine()->where('type', SubmissionType::Career)->where('status', SubmissionStatus::New)->count().' new applications', 'href' => route('admin.jobs.index')];
        }

        return view('admin.dashboard', [
            'headlineCount' => $headline->count(),
            'headlineLabel' => $role->headline(),
            'headlineTypes' => $role->headlineTypes(),
            'oldestOverdue' => $oldest ? Carbon::parse($oldest) : null,
            'newCount' => Submission::ofTypes($role->headlineTypes())->where('status', SubmissionStatus::New)->count(),
            'tiles' => $tiles,
            'daily' => $daily,
            'dailyMax' => max(1, (int) $daily->max('count')),
            'chartDays' => self::CHART_DAYS,
            'byType' => collect($role->types())->map(fn (SubmissionType $t) => [
                'type' => $t, 'count' => $mine()->where('type', $t)->where('created_at', '>=', $chartStart)->count(),
            ])->sortByDesc('count')->values(),
            'byService' => $user->canWork(SubmissionType::Appointment)
                ? $mine()->where('type', SubmissionType::Appointment)->where('created_at', '>=', $chartStart)->whereNotNull('service_key')
                    ->selectRaw('service_key, count(*) as total')->groupBy('service_key')->orderByDesc('total')->limit(6)->pluck('total', 'service_key')
                : collect(),
            'queue' => Submission::ofTypes($role->headlineTypes())->with('jobPosting')->where('status', SubmissionStatus::New)->oldest()->limit(8)->get(),
            'upcoming' => $mine()->with('jobPosting')->whereNotNull('booked_date')->where('status', '!=', SubmissionStatus::Closed)
                ->whereBetween('booked_date', [today(), today()->addDays(2)])->orderBy('booked_date')->orderBy('booked_time')->limit(8)->get(),
            'recentOpens' => $user->hasRole(Role::Admin, Role::Records) ? FileAccess::where('created_at', '>=', now()->subDays(7))->count() : null,
            'notifyMissing' => $user->isAdmin() && Notify::recipients() === [],
            'notifyInvalid' => $user->isAdmin() ? Notify::invalid() : [],
        ]);
    }
}
