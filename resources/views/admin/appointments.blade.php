<x-layouts.admin title="Appointment sheet">
    <x-slot:actions>
        <a href="{{ route('admin.appointments.index', ['from' => $start->copy()->subDays(14)->toDateString()]) }}" class="a-btn a-btn-ghost ring-1 ring-line"><x-icon name="chevron-left" class="h-4 w-4" />Earlier</a>
        <a href="{{ route('admin.appointments.index') }}" class="a-btn a-btn-ghost ring-1 ring-line">Today</a>
        <a href="{{ route('admin.appointments.index', ['from' => $start->copy()->addDays(14)->toDateString()]) }}" class="a-btn a-btn-ghost ring-1 ring-line">Later<x-icon name="chevron-right" class="h-4 w-4" /></a>
    </x-slot:actions>

    <p class="mb-5 text-sm text-ink-2">Appointments and dialysis assessments booked from website requests, {{ $start->format('j M') }} to {{ $days->last()->format('j M Y') }}: <span class="num font-semibold text-ink">{{ $bookedCount }}</span> booked. Clinic diaries stay in the centre's own system; this sheet shows what came through the website.</p>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1.6fr)_minmax(0,1fr)]">
        <section class="a-card min-w-0" aria-labelledby="sheet">
            <h2 id="sheet" class="px-5 pt-4 font-semibold">Booked</h2>
            <ol class="mt-3">
                @foreach ($days as $day)
                    @php($list = $byDay[$day->toDateString()] ?? collect())
                    <li class="border-t border-line px-5 py-3">
                        <div class="flex items-baseline justify-between gap-3">
                            <p @class(['font-semibold', 'text-link' => $day->isToday()])>{{ $day->isToday() ? 'Today' : $day->format('l j M') }}</p>
                            <p class="text-sm text-ink-3 num">{{ $list->count() ?: '' }}</p>
                        </div>
                        @foreach ($list as $s)
                            <a href="{{ route('admin.submissions.show', $s) }}" class="mt-1.5 flex min-h-11 items-center gap-3 rounded-lg px-2 hover:bg-surface-2">
                                <span class="w-12 flex-none text-sm font-semibold num">{{ $s->booked_time ?: '—' }}</span>
                                <x-icon :name="$s->type->icon()" class="h-4 w-4 flex-none text-ink-3" />
                                <span class="min-w-0 flex-1 truncate"><span class="font-semibold">{{ $s->patientName() }}</span> <span class="text-sm text-ink-3">· {{ $s->subject() }}</span></span>
                                <x-status :status="$s->status" :type="$s->type" class="hidden sm:inline-flex" />
                            </a>
                        @endforeach
                    </li>
                @endforeach
            </ol>
        </section>

        <div class="min-w-0 space-y-6">
            <section class="a-card p-5" aria-labelledby="want">
                <h2 id="want" class="font-semibold">Waiting for a date: {{ $waitingCount }}</h2>
                <p class="mt-1 text-sm text-ink-3">Days patients said suit them</p>
                @php($maxWant = max(1, $wantDay->max('count')))
                <ul class="mt-4 grid grid-cols-7 gap-1.5 text-center text-xs">
                    @foreach ($wantDay as $k => $w)
                        <li><div class="relative mx-auto h-20 w-full rounded bg-[color:var(--series-track)]"><span class="absolute inset-x-0 bottom-0 rounded bg-[color:var(--series-1)]" style="height: {{ $w['count'] / $maxWant * 100 }}%"></span></div><p class="mt-1 font-semibold">{{ $w['label'] }}</p><p class="num text-ink-3">{{ $w['count'] }}</p></li>
                    @endforeach
                </ul>
            </section>
            <section class="a-card min-w-0" aria-labelledby="wait">
                <h2 id="wait" class="px-5 pt-4 font-semibold">Oldest waiting</h2>
                @forelse ($waiting as $s)
                    <a href="{{ route('admin.submissions.show', $s) }}" class="mt-2 flex items-center gap-3 border-t border-line px-5 py-3 hover:bg-surface-2">
                        <div class="min-w-0 flex-1"><p class="truncate font-semibold">{{ $s->patientName() }}</p><p class="truncate text-sm text-ink-3">{{ $s->subject() }} · {{ collect((array) $s->detail('days'))->map(fn ($d) => ccmc('weekdays.'.$d))->implode(' ') }} · {{ ccmc('time_windows.'.$s->detail('window')) ?: '' }}</p></div>
                        <span class="chip num" data-tone="{{ $s->isOverdue() ? 'critical' : 'neutral' }}"><x-icon name="clock" />{{ $s->created_at->diffForHumans(null, true, true) }}</span>
                    </a>
                @empty
                    <p class="mt-2 border-t border-line px-5 py-6 text-ink-3">Nobody waiting for a date.</p>
                @endforelse
            </section>
        </div>
    </div>
</x-layouts.admin>
