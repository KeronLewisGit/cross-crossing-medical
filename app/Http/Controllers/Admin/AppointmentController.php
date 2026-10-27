<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SubmissionStatus;
use App\Enums\SubmissionType;
use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

/**
 * The front desk's day sheet: what has been booked after a call back, two weeks at a time,
 * and the requests still waiting for one, grouped by the days patients said suit them.
 */
class AppointmentController extends Controller
{
    private const int DAYS = 14;

    public function __invoke(Request $request): View
    {
        $start = rescue(fn () => Carbon::createFromFormat('Y-m-d', input_string($request->query('from'))), null, false);
        $start = $start instanceof Carbon ? $start->startOfDay() : today();
        $end = $start->copy()->addDays(self::DAYS - 1);
        $types = [SubmissionType::Appointment, SubmissionType::Dialysis];

        $booked = Submission::ofTypes($types)->with('jobPosting')->whereNotNull('booked_date')
            ->where('status', '!=', SubmissionStatus::Closed)
            ->whereBetween('booked_date', [$start->toDateString(), $end->toDateString()])
            ->orderBy('booked_date')->orderBy('booked_time')->get();

        $waiting = Submission::ofTypes($types)->with('jobPosting')->whereIn('status', [SubmissionStatus::New, SubmissionStatus::Contacted])
            ->whereNull('booked_date')->oldest()->get();
        $wantDay = collect((array) ccmc('weekdays'))->map(fn (string $label, string $key) => [
            'label' => $label,
            'count' => $waiting->filter(fn (Submission $s) => in_array($key, (array) $s->detail('days'), true))->count(),
        ]);

        return view('admin.appointments', [
            'start' => $start,
            'days' => collect(range(0, self::DAYS - 1))->map(fn (int $i) => $start->copy()->addDays($i)),
            'byDay' => $booked->groupBy(fn (Submission $s) => $s->booked_date?->toDateString()),
            'bookedCount' => $booked->count(),
            'waiting' => $waiting->take(12),
            'waitingCount' => $waiting->count(),
            'wantDay' => $wantDay,
        ]);
    }
}
