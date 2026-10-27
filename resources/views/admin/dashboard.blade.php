<x-layouts.admin title="Overview">
    @if ($notifyMissing)
        <div class="mb-5 flex gap-3 rounded-xl border border-line bg-surface p-4 text-sm" role="status"><x-icon name="mail" class="h-5 w-5 flex-none text-link" /><p><strong>Nobody is emailed about new requests yet.</strong> Set <code>CCMC_NOTIFY_EMAIL</code> (and <code>CCMC_NOTIFY_HR_EMAIL</code> for applications) in <code>.env</code>.</p></div>
    @elseif ($notifyInvalid)
        <div class="mb-5 flex gap-3 rounded-xl border border-line bg-surface p-4 text-sm" role="status"><x-icon name="alert" class="h-5 w-5 flex-none text-[color:var(--critical)]" /><p>These notification addresses look wrong and are skipped: {{ implode(', ', $notifyInvalid) }}</p></div>
    @endif

    {{-- The one number this role must act on. --}}
    <section @class(['a-card overflow-hidden', 'ring-2 ring-[color:var(--critical)]' => $headlineCount > 0]) aria-labelledby="overdue-title">
        <div class="grid gap-5 p-6 md:grid-cols-[auto_1fr_auto] md:items-center md:gap-8 md:p-8">
            <p @class(['big-number font-display', 'text-[color:var(--critical-text)]' => $headlineCount > 0, 'text-[color:var(--good)]' => $headlineCount === 0])>{{ $headlineCount }}</p>
            <div>
                <h2 id="overdue-title" class="text-xl font-bold">{{ ucfirst($headlineLabel) }}</h2>
                <p class="mt-1 text-ink-2">
                    @if ($headlineCount)
                        The oldest arrived {{ $oldestOverdue?->diffForHumans() }}. Patients who hear back quickly don't ring the switchboard again.
                    @else
                        Everything is inside its response time. {{ $newCount }} {{ \Illuminate\Support\Str::plural('request', $newCount) }} still new but not yet late.
                    @endif
                </p>
                <p class="mt-2 text-sm text-ink-3">Response times: {{ collect($headlineTypes)->map(fn ($t) => $t->plural().' '.$t->responseHours().'h')->implode(', ') }}</p>
            </div>
            <a href="{{ route('admin.submissions.index', $headlineCount ? ['overdue' => 1] : ['status' => 'new']) }}" class="a-btn {{ $headlineCount ? 'a-btn-primary' : 'a-btn-ghost' }}">{{ $headlineCount ? 'Deal with them now' : 'Open new requests' }}<x-icon name="arrow-right" class="h-4 w-4" /></a>
        </div>
        <x-pulse-line :muted="$headlineCount === 0" class="{{ $headlineCount ? 'text-[color:var(--critical)]' : 'text-[color:var(--pulse)]' }}" />
    </section>

    <div @class(['mt-6 grid gap-4 sm:grid-cols-2', 'xl:grid-cols-4' => count($tiles) >= 4, 'xl:grid-cols-3' => count($tiles) === 3])>
        @foreach ($tiles as $t)
            @if (($t['format'] ?? null) === 'minutes')
                <a href="{{ $t['href'] }}" class="a-card block p-5 transition hover:shadow-lg">
                    <p class="text-sm text-ink-2">{{ $t['label'] }}</p>
                    <p class="mt-2 text-[2rem] font-semibold leading-none tracking-tight num">{{ $t['value'] === null ? '—' : ($t['value'] >= 120 ? round($t['value'] / 60, 1).' h' : $t['value'].' min') }}</p>
                    <p class="mt-3 text-sm text-ink-3">{{ $t['note'] }}</p>
                </a>
            @else
                <x-stat-tile :label="$t['label']" :value="$t['value']" :previous="$t['previous'] ?? null" :period="$t['period'] ?? null" :note="$t['note'] ?? null" :href="$t['href']" />
            @endif
        @endforeach
        @if ($recentOpens !== null)
            <a href="{{ route('admin.document-log') }}" class="a-card block p-5 transition hover:shadow-lg">
                <p class="text-sm text-ink-2">Patient documents opened</p>
                <p class="mt-2 text-[2rem] font-semibold leading-none tracking-tight num">{{ $recentOpens }}</p>
                <p class="mt-3 text-sm text-ink-3">last 7 days, every opening logged</p>
            </a>
        @endif
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1.5fr_1fr]">
        <section class="a-card min-w-0 p-5" aria-labelledby="chart-title">
            <div class="flex flex-wrap items-baseline justify-between gap-2">
                <h2 id="chart-title" class="font-semibold">Requests per day, last {{ $chartDays }} days</h2>
                <p class="text-sm text-ink-3 num">{{ $daily->sum('count') }} total</p>
            </div>
            <div class="relative mt-5" x-data="columnChart" @mouseleave="hide()">
                <svg viewBox="0 0 {{ $chartDays * 10 }} 120" class="h-44 w-full" preserveAspectRatio="none" role="img" aria-label="Column chart of requests per day">
                    @foreach ($daily as $i => $d)
                        @php($h = $d['count'] / $dailyMax * 110)
                        <rect class="bar" x="{{ $i * 10 + 1.5 }}" y="{{ 120 - max($h, 1) }}" width="7" height="{{ max($h, 1) }}" rx="1.5" fill="{{ $d['count'] ? 'var(--series-1)' : 'var(--series-track)' }}"
                            data-label="{{ $d['date']->format('D j M') }}" data-value="{{ $d['count'] }}" tabindex="0" @mouseenter="show($el)" @focus="show($el)" @blur="hide()"><title>{{ $d['date']->format('D j M') }}: {{ $d['count'] }}</title></rect>
                    @endforeach
                </svg>
                <div x-show="tip" x-cloak class="pointer-events-none absolute -translate-x-1/2 -translate-y-full rounded-md bg-sign-950 px-2.5 py-1.5 text-xs font-semibold text-white shadow" :style="tip && `left:${tip.x}px; top:${tip.y - 6}px`"><span x-text="tip?.label"></span>: <span x-text="tip?.value"></span></div>
                <div class="mt-2 flex justify-between text-xs text-ink-3"><span>{{ $daily->first()['date']->format('j M') }}</span><span>Today</span></div>
            </div>
        </section>
        <section class="a-card min-w-0 p-5" aria-labelledby="type-title">
            <h2 id="type-title" class="font-semibold">By type, last {{ $chartDays }} days</h2>
            @php($maxType = max(1, $byType->max('count')))
            <ul class="mt-3 space-y-1">
                @foreach ($byType as $row)
                    <li>
                        <a href="{{ route('admin.submissions.index', ['type' => $row['type']->value]) }}" class="block min-h-11 rounded px-1 py-1.5 hover:bg-surface-2">
                            <div class="flex justify-between text-sm"><span class="inline-flex items-center gap-2"><x-icon :name="$row['type']->icon()" class="h-4 w-4 text-ink-3" />{{ $row['type']->plural() }}</span><span class="num font-semibold">{{ $row['count'] }}</span></div>
                            <div class="meter mt-1.5"><span style="width: {{ $row['count'] / $maxType * 100 }}%"></span></div>
                        </a>
                    </li>
                @endforeach
            </ul>
            @if ($byService->isNotEmpty())
                <h3 class="mt-6 text-sm font-semibold text-ink-2">Most requested clinics and tests</h3>
                <ul class="mt-2 divide-y divide-line text-sm">
                    @foreach ($byService as $key => $total)
                        <li><a href="{{ route('admin.submissions.index', ['type' => 'appointment', 'service' => $key]) }}" class="flex min-h-11 items-center justify-between gap-3 hover:text-link"><span class="truncate">{{ \App\Models\Submission::serviceLabel($key) }}</span><span class="num font-semibold">{{ $total }}</span></a></li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-2">
        <section class="a-card min-w-0" aria-labelledby="queue-title">
            <div class="flex items-center justify-between gap-3 px-5 pb-1.5 pt-3.5"><h2 id="queue-title" class="font-semibold">Next to call (oldest new first)</h2><a class="inline-flex min-h-11 flex-none items-center text-sm text-link underline" href="{{ route('admin.submissions.index', ['status' => 'new']) }}">All new</a></div>
            @forelse ($queue as $s)
                <a href="{{ route('admin.submissions.show', $s) }}" class="flex items-center gap-3 border-t border-line px-5 py-3 hover:bg-surface-2">
                    <x-icon :name="$s->type->icon()" class="h-5 w-5 flex-none text-ink-3" />
                    <div class="min-w-0 flex-1"><p class="truncate font-semibold">{{ $s->patientName() }}@if($s->is_demo) <span class="demo-badge ml-1">Demo</span>@endif</p><p class="truncate text-sm text-ink-3">{{ $s->type->label() }}@if($s->subject()) · {{ $s->subject() }}@endif</p></div>
                    <span class="chip num" data-tone="{{ $s->isOverdue() ? 'critical' : 'neutral' }}"><x-icon name="clock" />{{ $s->created_at->diffForHumans(null, true, true) }}</span>
                </a>
            @empty
                <p class="border-t border-line px-5 py-6 text-ink-3">Nothing new waiting. Well done.</p>
            @endforelse
        </section>
        <section class="a-card min-w-0" aria-labelledby="up-title">
            <div class="p-5 pb-3"><h2 id="up-title" class="font-semibold">Booked, today to {{ today()->addDays(2)->format('l') }}</h2></div>
            @forelse ($upcoming as $s)
                <a href="{{ route('admin.submissions.show', $s) }}" class="flex items-center gap-3 border-t border-line px-5 py-3 hover:bg-surface-2">
                    <div class="w-20 flex-none text-sm"><p class="font-semibold">{{ $s->booked_date->isToday() ? 'Today' : $s->booked_date->format('D j') }}</p><p class="num text-ink-3">{{ $s->booked_time }}</p></div>
                    <div class="min-w-0 flex-1"><p class="truncate font-semibold">{{ $s->patientName() }}</p><p class="truncate text-sm text-ink-3">{{ $s->subject() }}</p></div>
                    <x-status :status="$s->status" :type="$s->type" />
                </a>
            @empty
                <p class="border-t border-line px-5 py-6 text-ink-3">Nothing booked in the next three days.</p>
            @endforelse
        </section>
    </div>
</x-layouts.admin>
