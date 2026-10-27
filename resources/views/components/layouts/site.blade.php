@props(['title' => null, 'description' => null, 'jsonLd' => [], 'mobileBar' => true, 'ogImage' => 'building'])
@php
    $pageTitle = $title ? $title.' · '.ccmc('name') : ccmc('name').' · 24-hour care in San Fernando';
    $metaDescription = $description ?? 'Cross Crossing Medical Centre, Oliver Avenue, San Fernando: open 24 hours, 365 days a year, with an emergency room, cardiac care unit, dialysis unit, lab, X-ray, surgical suites and specialist clinics.';
    $phones = (array) ccmc('phones');
    $phone = $phones[0] ?? '';
    $address = ccmc('address');
    $nav = [
        ['route' => 'services', 'match' => ['services', 'department'], 'label' => 'Services'],
        ['route' => 'clinics', 'match' => 'clinics', 'label' => 'Clinics'],
        ['route' => 'new-patients', 'match' => 'new-patients', 'label' => 'New patients'],
        ['route' => 'handouts', 'match' => ['handouts', 'health-checks'], 'label' => 'Patient corner'],
        ['route' => 'careers', 'match' => 'careers*', 'label' => 'Careers'],
        ['route' => 'contact', 'match' => ['contact', 'about'], 'label' => 'Contact'],
    ];
    $organization = [
        '@context' => 'https://schema.org',
        '@type' => 'MedicalClinic',
        'name' => ccmc('name'),
        'alternateName' => ccmc('short_name'),
        'url' => route('home'),
        'telephone' => '+'.nanp_digits($phone),
        'faxNumber' => '+'.nanp_digits((string) ccmc('fax')),
        'email' => ccmc('email'),
        'image' => asset('img/building-960.webp'),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $address['street'].', '.$address['area'],
            'addressLocality' => $address['city'],
            'addressCountry' => $address['country_code'],
        ],
        'geo' => ['@type' => 'GeoCoordinates', 'latitude' => ccmc('geo.lat'), 'longitude' => ccmc('geo.lng')],
        'openingHoursSpecification' => [['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], 'opens' => '00:00', 'closes' => '23:59']],
        'isAcceptingNewPatients' => true,
        'sameAs' => [ccmc('facebook')],
    ];
    $notice = \App\Models\Setting::notice();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    @if (ccmc('preview'))
        <meta name="robots" content="noindex, nofollow">
    @endif
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ ccmc('name') }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('img/'.$ogImage.'-'.(photo($ogImage)['width'] >= 960 ? '960' : '480').'.webp') }}">
    <meta property="og:locale" content="en_TT">
    <meta name="twitter:card" content="summary_large_image">
    @foreach (array_merge([$organization], $jsonLd) as $ld)
        <script type="application/ld+json">{!! json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    @endforeach
</head>
<body class="min-h-screen {{ $mobileBar ? 'pb-[5.25rem] md:pb-0' : '' }}" x-data="{ menu: false }" @keydown.escape.window="menu = false">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-surface focus:px-4 focus:py-3 focus:shadow-md">Skip to content</a>

    @if (ccmc('preview'))
        <div class="bg-brass text-sm text-brass-ink">
            <p class="wrap flex items-start gap-2 py-2.5"><x-icon name="alert" class="mt-0.5 h-4 w-4 flex-none" /><span><strong class="font-extrabold">Concept preview prepared for Cross Crossing Medical Centre.</strong> This is not the centre's official website. Requests sent here do not reach the centre.</span></p>
        </div>
    @endif

    {{-- 24/7 status band: the one thing every visitor should know first. --}}
    <div class="bg-sign-950 text-[0.9375rem] text-white">
        <div class="wrap flex flex-wrap items-center gap-x-6 gap-y-1 py-2">
            <p class="flex items-center gap-2.5 font-bold"><span class="live-dot" aria-hidden="true"></span>Open now<span class="font-normal text-white/80">· 24 hours, every day of the year</span></p>
            <p class="hidden items-center gap-2 text-white/85 md:flex"><x-icon name="ambulance" class="h-4 w-4 text-white" />Emergency? Come straight to <a href="{{ route('department', 'accident-emergency') }}" class="font-bold text-white underline underline-offset-2">A&amp;E</a>, or call <a href="tel:{{ ccmc('ambulance') }}" class="font-bold text-white underline underline-offset-2">{{ ccmc('ambulance') }}</a> for an ambulance</p>
            <a href="{{ tel_href($phone) }}" class="ml-auto hidden min-h-8 items-center gap-2 font-bold sm:inline-flex"><x-icon name="phone" class="h-4 w-4" />{{ format_phone($phone) }}</a>
        </div>
    </div>

    @if ($notice)
        <div class="border-b border-line bg-soft" role="status">
            <p class="wrap flex items-start gap-2.5 py-3 font-semibold"><x-icon name="alert" class="mt-0.5 h-5 w-5 flex-none text-link" />{{ $notice }}</p>
        </div>
    @endif

    <header class="sticky top-0 z-40 border-b border-line bg-surface/95 backdrop-blur">
        <div class="wrap flex h-[4.75rem] items-center gap-2 min-[400px]:gap-3">
            <a href="{{ route('home') }}" class="mr-auto inline-flex min-h-11 flex-none items-center rounded" aria-label="Cross Crossing Medical Centre, home"><x-logo /></a>

            <nav class="hidden items-center xl:flex" aria-label="Main">
                @foreach ($nav as $item)
                    @php($current = request()->routeIs($item['match']))
                    <a href="{{ route($item['route']) }}" @class(['relative whitespace-nowrap px-3 py-2.5 text-[0.9375rem] font-bold transition-colors', 'text-link' => $current, 'text-ink-2 hover:text-ink' => ! $current]) @if($current) aria-current="page" @endif>
                        {{ $item['label'] }}
                        @if ($current)<span class="absolute inset-x-3 -bottom-[1.05rem] h-[3px] rounded-full bg-[color:var(--link)]" aria-hidden="true"></span>@endif
                    </a>
                @endforeach
            </nav>

            <button type="button" onclick="toggleTheme()" class="hidden h-11 w-11 flex-none items-center justify-center rounded-full text-ink-2 hover:bg-surface-2 hover:text-ink sm:inline-flex" aria-label="Switch light or dark theme">
                <x-icon name="moon" class="h-5 w-5 dark-hide" /><x-icon name="sun" class="hidden h-5 w-5 dark-show" />
            </button>
            <a href="{{ route('appointments') }}" class="btn btn-primary btn-sm hidden flex-none whitespace-nowrap md:inline-flex">Request an appointment<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
            <button type="button" class="inline-flex h-11 w-11 flex-none items-center justify-center rounded-full ring-1 ring-line-strong xl:hidden" @click="menu = !menu" :aria-expanded="menu.toString()" aria-controls="mobile-menu" aria-label="Menu">
                <x-icon name="menu" x-show="!menu" /><x-icon name="x" x-show="menu" x-cloak />
            </button>
        </div>
        <div id="mobile-menu" class="border-t border-line bg-surface xl:hidden" x-show="menu" x-cloak x-transition.opacity>
            <nav class="wrap grid gap-x-8 py-3 sm:grid-cols-2" aria-label="Mobile">
                <a href="{{ route('home') }}" class="rounded px-1 py-3 text-xl font-bold">Home</a>
                @foreach ($nav as $item)
                    <a href="{{ route($item['route']) }}" class="rounded px-1 py-3 text-xl font-bold" @if(request()->routeIs($item['match'])) aria-current="page" @endif>{{ $item['label'] }}</a>
                @endforeach
                <a href="{{ route('department', 'dialysis') }}" class="rounded px-1 py-3 text-xl font-bold">Dialysis unit</a>
                <a href="{{ route('department', 'accident-emergency') }}" class="rounded px-1 py-3 text-xl font-bold text-ae-text">Accident &amp; Emergency</a>
            </nav>
            <div class="wrap grid gap-3 border-t border-line py-5 sm:grid-cols-2">
                <a href="{{ route('appointments') }}" class="btn btn-primary">Request an appointment</a>
                <a href="{{ tel_href($phone) }}" class="btn btn-outline"><x-icon name="phone" class="h-4 w-4" />{{ format_phone($phone) }}</a>
                <button type="button" onclick="toggleTheme()" class="flex min-h-11 items-center gap-2 rounded px-1 text-left font-bold text-ink-2 sm:col-span-2"><x-icon name="moon" class="h-5 w-5" />Switch light or dark theme</button>
            </div>
        </div>
    </header>

    <main id="main">
        {{ $slot }}
    </main>

    <footer class="stucco on-sign mt-24 text-white/80">
        <x-pulse-line class="opacity-70" />
        <div class="wrap grid gap-12 py-14 md:grid-cols-2 lg:grid-cols-[1.35fr_1fr_1fr_1.15fr]">
            <div>
                <x-logo tone="light" />
                <p class="mt-5 max-w-xs text-white/75">A multi-speciality medical centre near Halliburton, San Fernando. Physicians and full nursing staff, 24 hours a day.</p>
                @foreach ($phones as $p)
                    <a href="{{ tel_href($p) }}" class="font-display mt-3 flex min-h-11 w-fit items-center gap-2.5 text-2xl font-semibold text-white hover:text-brass first-of-type:mt-6"><x-icon name="phone" class="h-5 w-5" />{{ format_phone($p) }}</a>
                @endforeach
                <p class="mt-1 text-sm">Fax {{ format_phone((string) ccmc('fax')) }}</p>
                <p><a class="inline-flex min-h-11 items-center hover:text-white" href="mailto:{{ ccmc('email') }}">{{ ccmc('email') }}</a></p>
            </div>
            <div>
                <h2 class="kicker font-sans text-brass">Patients</h2>
                <ul class="mt-4 space-y-0.5">
                    <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('appointments') }}">Request an appointment</a></li>
                    <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('new-patients') }}">Register as a new patient</a></li>
                    <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('department', 'dialysis') }}#enquire">Dialysis enquiry</a></li>
                    <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('handouts') }}">Patient handouts</a></li>
                    <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('health-checks') }}">Health self-checks</a></li>
                </ul>
            </div>
            <div>
                <h2 class="kicker font-sans text-brass">Departments</h2>
                <ul class="mt-4 space-y-0.5">
                    @foreach (array_slice((array) ccmc('departments'), 0, 6, true) as $slug => $d)
                        <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('department', $slug) }}">{{ $d['name'] }}</a></li>
                    @endforeach
                    <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('services') }}">All services</a></li>
                </ul>
            </div>
            <div>
                <h2 class="kicker font-sans text-brass">Find us</h2>
                <address class="mt-5 not-italic leading-relaxed">
                    {{ $address['street'] }}, {{ $address['area'] }}<br>{{ $address['city'] }}, {{ $address['country'] }}
                </address>
                <p class="mt-2 text-sm text-white/70">Near Halliburton, in the suburban area of San Fernando.</p>
                <a class="mt-1 inline-flex min-h-11 items-center gap-1.5 font-bold text-white hover:text-brass" href="{{ ccmc('map_url') }}" rel="noopener" target="_blank">Get directions<x-icon name="external" class="h-3.5 w-3.5" /><span class="sr-only">(opens Google Maps)</span></a>
                <p class="mt-3 flex items-center gap-2.5 font-bold text-white"><span class="live-dot" aria-hidden="true"></span>Open 24 hours, 7 days, 365 days</p>
                <a class="mt-2 inline-flex min-h-11 items-center gap-2 hover:text-white" href="{{ ccmc('facebook') }}" rel="noopener" target="_blank"><x-icon name="facebook" class="h-4 w-4" />facebook.com/ccmctt<span class="sr-only">(opens Facebook)</span></a>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div class="wrap flex flex-col gap-3 py-6 text-sm text-white/70 md:flex-row md:items-center md:justify-between">
                <p>© {{ date('Y') }} {{ ccmc('name') }}. This website gives general information and is not medical advice.</p>
                <p class="flex flex-wrap gap-x-5">
                    <a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('privacy') }}">Privacy</a>
                    <a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('credits') }}">Photo credits</a>
                    <a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('sitemap.page') }}">Site map</a>
                    <a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('login') }}">Staff sign in</a>
                </p>
            </div>
        </div>
    </footer>

    @if ($mobileBar)
        {{-- Thumb-reach actions on phones: call the centre, or request an appointment. --}}
        <nav aria-label="Quick actions" class="fixed inset-x-0 bottom-0 z-30 border-t border-white/10 bg-sign-950/95 px-3 pb-[max(0.75rem,env(safe-area-inset-bottom))] pt-3 backdrop-blur md:hidden">
            <div class="flex gap-2">
                <a href="{{ tel_href($phone) }}" class="btn btn-on-sign flex-1 px-2 text-[0.9375rem]"><x-icon name="phone" class="h-4 w-4" />Call</a>
                <a href="{{ route('appointments') }}" class="btn btn-brass flex-[1.6] whitespace-nowrap px-2 text-[0.9375rem]">Request appointment</a>
            </div>
        </nav>
    @endif
</body>
</html>
