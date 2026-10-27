@php
    $phones = (array) ccmc('phones');
    $book = ['cardiac' => 'cardiology', 'laboratory' => 'lab', 'imaging' => 'xray', 'sleep-lung' => 'sleep-study', 'vaccinations' => 'vaccination', 'surgery' => 'minor-surgery'][$slug] ?? null;
    $isAe = (bool) ($dept['emergency'] ?? false);
    $jsonLd = [[
        '@context' => 'https://schema.org', '@type' => 'MedicalWebPage', 'name' => $dept['name'].' · '.ccmc('name'),
        'about' => ['@type' => 'MedicalSpecialty', 'name' => $dept['name']], 'url' => route('department', $slug),
    ]];
@endphp
<x-layouts.site :title="$dept['name']" :description="$dept['short'].' Cross Crossing Medical Centre, Oliver Avenue, San Fernando. Open 24 hours.'" :json-ld="$jsonLd" :og-image="$dept['photo']">
    <x-page-header :title="$dept['name']" :lead="$dept['short']" :code="$dept['code']" label="Services" :photo="$dept['photo']" :ae="$isAe">
        <nav class="mt-6 text-sm text-white/80" aria-label="Breadcrumb"><a href="{{ route('services') }}" class="inline-flex min-h-11 items-center underline underline-offset-2 hover:text-white">All services</a> <span aria-hidden="true" class="px-1">/</span> <span aria-current="page">{{ $dept['name'] }}</span></nav>
    </x-page-header>

    @if ($isAe)
        <section class="ae-fill">
            <div class="wrap flex flex-col gap-4 py-6 md:flex-row md:items-center md:justify-between">
                <p class="font-display text-xl font-medium">Emergency? Do not fill in a form. Come straight in, or call {{ ccmc('ambulance') }} for an ambulance.</p>
                <a href="{{ tel_href($phones[0] ?? '') }}" class="btn flex-none bg-white text-[#8f1a13] hover:bg-white/90"><x-icon name="phone" class="h-4 w-4" />Call ahead {{ format_phone($phones[0] ?? '') }}</a>
            </div>
        </section>
    @endif

    <div class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1.35fr)_minmax(0,1fr)] lg:gap-16">
        <div>
            <div class="prose-copy measure text-lg">
                @foreach ($dept['body'] as $p)<p>{{ $p }}</p>@endforeach
            </div>

            <h2 class="display-3 mt-12">At a glance</h2>
            <ul class="check-list mt-5 measure">
                @foreach ($dept['points'] as $pt)<li><x-icon name="check-circle" />{{ $pt }}</li>@endforeach
            </ul>

            @if ($slug === 'laboratory')
                <div class="mt-10 rounded-2xl border border-line bg-surface p-6" id="results">
                    <h2 class="flex items-center gap-2.5 font-display text-xl font-medium"><x-icon name="lock" class="h-5 w-5 text-link" />Your results</h2>
                    <p class="mt-2 text-ink-2 measure">Test results are private, so they are never shown on this website and are not sent by email. When your results are ready, the centre will let you know. Call the lab on <a class="text-link font-bold" href="{{ tel_href($phones[0] ?? '') }}">{{ format_phone($phones[0] ?? '') }}</a> to check whether they are ready to collect, and bring photo ID when you come.</p>
                </div>
            @endif

            @if ($slug === 'dental')
                <div class="mt-10 rounded-2xl border border-line bg-surface p-6">
                    <h2 class="font-display text-xl font-medium">{{ $dept['partner'] }}</h2>
                    <p class="mt-2 text-ink-2">Call to set up an appointment:</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        @foreach ($dept['phones'] as $p)<a href="{{ tel_href($p) }}" class="btn btn-primary"><x-icon name="phone" class="h-4 w-4" />{{ format_phone($p) }}</a>@endforeach
                    </div>
                    <p class="mt-5 text-ink-2">For a dental emergency at any hour, call <a class="text-link font-bold" href="{{ tel_href($phones[0] ?? '') }}">{{ format_phone($phones[0] ?? '') }}</a> for the emergency room.</p>
                </div>
            @endif

            @if ($slug === 'vaccinations')
                <div class="mt-10 prose-copy measure">
                    <h2>How immunisations work</h2>
                    <p>Immunisations expose you to a very small, very safe amount of a virus or bacteria that has been weakened or killed. Your immune system then learns to recognise and attack the infection if you meet it later in life.</p>
                    <p>For a few weeks after birth, babies have some protection passed on from their mother. That natural protection soon goes away, which is why the childhood schedule matters.</p>
                    <p>Read more in the <a href="{{ route('handouts') }}">patient handouts library</a>.</p>
                </div>
            @endif
        </div>

        <aside class="space-y-6">
            @if (! empty($dept['photo2']))
                <figure class="frame-light">
                    <x-photo :key="$dept['photo2']" :alt="(config('photo-credits.'.$dept['photo2'].'.own') ? '' : 'Illustrative photo: ').config('photo-credits.'.$dept['photo2'].'.title')" sizes="(min-width: 1024px) 28rem, 100vw" class="aspect-[4/3]" />
                </figure>
            @endif
            <div class="panel p-6">
                @if ($isAe)
                    <h2 class="font-display text-lg font-medium">Open now</h2>
                    <p class="mt-2 flex items-center gap-2.5 font-bold"><span class="live-dot" aria-hidden="true"></span>24 hours, 7 days, 365 days</p>
                    <p class="mt-3 text-ink-2">Oliver Avenue, Cross Crossing, San Fernando, near Halliburton.</p>
                    <a href="{{ ccmc('map_url') }}" class="btn btn-outline mt-5 w-full" rel="noopener" target="_blank"><x-icon name="map-pin" class="h-4 w-4" />Directions<span class="sr-only">(opens Google Maps)</span></a>
                @elseif ($slug === 'dialysis')
                    <h2 class="font-display text-lg font-medium">New to the unit?</h2>
                    <p class="mt-2 text-ink-2">Start with an initial dialysis examination and review by our physicians.</p>
                    <a href="#enquire" class="btn btn-primary mt-5 w-full">Send an enquiry</a>
                @elseif ($slug === 'dental')
                    <h2 class="font-display text-lg font-medium">Dental emergency?</h2>
                    <p class="mt-2 text-ink-2">Emergency dental care is available 24 hours through the emergency room.</p>
                    <a href="{{ tel_href($phones[0] ?? '') }}" class="btn btn-primary mt-5 w-full"><x-icon name="phone" class="h-4 w-4" />{{ format_phone($phones[0] ?? '') }}</a>
                @else
                    <h2 class="font-display text-lg font-medium">Book with us</h2>
                    <p class="mt-2 text-ink-2">Send a request with the days that suit you, and we will call you back to agree a time.</p>
                    <a href="{{ route('appointments', array_filter(['service' => $book])) }}" class="btn btn-primary mt-5 w-full">Request an appointment</a>
                    <a href="{{ tel_href($phones[0] ?? '') }}" class="btn btn-outline mt-3 w-full"><x-icon name="phone" class="h-4 w-4" />{{ format_phone($phones[0] ?? '') }}</a>
                @endif
            </div>
        </aside>
    </div>

    @if ($slug === 'dialysis')
        @include('pages.forms.dialysis')
    @endif

    <section class="wrap mt-20" aria-labelledby="other">
        <h2 id="other" class="display-3">Other departments</h2>
        <ul class="mt-6 flex flex-wrap gap-2">
            @foreach ((array) ccmc('departments') as $s => $d)
                @continue($s === $slug)
                <li><a href="{{ route('department', $s) }}" class="tag"><span @class(['code-chip', 'ae' => $d['emergency'] ?? false])>{{ $d['code'] }}</span>{{ $d['name'] }}</a></li>
            @endforeach
        </ul>
    </section>
</x-layouts.site>
