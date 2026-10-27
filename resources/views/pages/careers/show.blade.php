@php
    $jsonLd = [[
        '@context' => 'https://schema.org', '@type' => 'JobPosting', 'title' => $job->title,
        'description' => e($job->summary), 'datePosted' => $job->created_at?->toDateString(),
        'validThrough' => $job->closes_on?->toDateString(),
        'employmentType' => strtoupper(str_replace('-', '_', $job->employment)),
        'hiringOrganization' => ['@type' => 'MedicalOrganization', 'name' => ccmc('name'), 'sameAs' => route('home')],
        'jobLocation' => ['@type' => 'Place', 'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'Oliver Avenue, Cross Crossing', 'addressLocality' => 'San Fernando', 'addressCountry' => 'TT']],
    ]];
@endphp
<x-layouts.site :title="$job->title" :description="$job->summary" :json-ld="$job->isOpen() ? $jsonLd : []">
    <x-page-header :title="$job->title" :lead="$job->summary" code="HR" :label="$job->department">
        <div class="mt-5 flex flex-wrap items-center gap-2 text-sm">
            <span class="tag !bg-white/10 !text-white !ring-white/30">{{ $job->employmentLabel() }}</span>
            @if ($job->closes_on)<span class="text-white/85">Closes {{ $job->closes_on->format('j F Y') }}</span>@endif
            @if ($job->is_demo)<span class="demo-badge">Demo vacancy</span>@endif
        </div>
    </x-page-header>
    <div class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)] lg:gap-16">
        <div class="space-y-10">
            @unless ($job->isOpen())
                <p class="rounded-xl bg-soft p-4 font-semibold">This vacancy has closed. You can still send a general application.</p>
            @endunless
            @foreach (['duties' => 'What you will do', 'requirements' => 'What you need'] as $field => $heading)
                @if ($job->lines($field))
                    <section>
                        <h2 class="display-3">{{ $heading }}</h2>
                        <ul class="check-list mt-5 measure">
                            @foreach ($job->lines($field) as $line)<li><x-icon name="check-circle" />{{ $line }}</li>@endforeach
                        </ul>
                    </section>
                @endif
            @endforeach
        </div>
        <aside>
            <div class="panel p-6 lg:sticky lg:top-28">
                <h2 class="font-display text-lg font-medium">Apply for this role</h2>
                <p class="mt-2 text-ink-2">Have your CV ready as a PDF or Word file. It takes about three minutes.</p>
                <a href="{{ $job->isOpen() ? route('careers.apply', ['job' => $job->slug]) : route('careers.apply') }}" class="btn btn-primary mt-5 w-full">{{ $job->isOpen() ? 'Apply now' : 'Send a general application' }}</a>
                <a href="{{ route('careers') }}" class="btn btn-outline mt-3 w-full">All vacancies</a>
            </div>
        </aside>
    </div>
</x-layouts.site>
