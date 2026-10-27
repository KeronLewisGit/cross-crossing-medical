<x-layouts.site title="Careers: nursing, technical and support roles" description="Work at Cross Crossing Medical Centre, a 24-hour medical centre in San Fernando. Vacancies for nurses, dialysis and lab technicians, radiographers and support staff.">
    <x-page-header title="Careers at CCMC" lead="A 24-hour centre needs people around the clock: nurses, dialysis and lab technicians, radiographers, and the reception and records team who keep it running." code="HR" label="Careers" photo="nursing" photo-alt="A smiling nurse in a white uniform on a Caribbean hospital ward" position="center 30%" />

    <div class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)] lg:gap-16">
        <section aria-labelledby="open-title">
            <h2 id="open-title" class="display-3">Open vacancies</h2>
            @if ($jobs->isEmpty())
                <div class="panel mt-6 p-6">
                    <p class="font-semibold">There are no advertised vacancies right now.</p>
                    <p class="mt-1 text-ink-2">Send your CV anyway. The HR team keeps applications on file for six months and calls when something suitable opens.</p>
                </div>
            @else
                <ul class="mt-6 space-y-4">
                    @foreach ($jobs as $job)
                        <li class="card-link plate p-5 md:p-6">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="code-chip">{{ strtoupper(\Illuminate\Support\Str::limit($job->department, 12, '')) }}</span>
                                <span class="tag">{{ $job->employmentLabel() }}</span>
                                @if ($job->closes_on)<span class="text-sm text-ink-3">Closes {{ $job->closes_on->format('j M Y') }}</span>@endif
                                @if ($job->is_demo)<span class="demo-badge">Demo</span>@endif
                            </div>
                            <h3 class="mt-3 text-[1.25rem] font-medium"><a href="{{ route('careers.show', $job) }}" class="stretch">{{ $job->title }}</a></h3>
                            <p class="mt-1.5 text-ink-2">{{ $job->summary }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
            <a href="{{ route('careers.apply') }}" class="btn btn-primary mt-8">Send a general application<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
        </section>

        <aside class="space-y-6">
            <div class="panel p-6">
                <h2 class="font-display text-lg font-medium">How to apply</h2>
                <ol class="steps mt-5 text-[0.9375rem]">
                    <li><p>Choose a vacancy, or send a general application for the kind of role you do.</p></li>
                    <li><p>Attach your CV (PDF or Word) and up to three certificates or licences.</p></li>
                    <li><p>You get a reference number by email. HR reviews every application and contacts shortlisted applicants.</p></li>
                </ol>
            </div>
            <div class="panel p-6">
                <h2 class="font-display text-lg font-medium">Who we look for</h2>
                <ul class="mt-4 flex flex-wrap gap-2">
                    @foreach ((array) ccmc('career_roles') as $k => $label)
                        @continue($k === 'other')
                        <li><a class="tag" href="{{ route('careers.apply', ['role' => $k]) }}">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
            <p class="text-sm text-ink-3">Your application is kept privately and seen only by the HR team. See the <a href="{{ route('privacy') }}" class="text-link">privacy notice</a>.</p>
        </aside>
    </div>
</x-layouts.site>
