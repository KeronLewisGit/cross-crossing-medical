<x-layouts.site title="Site map">
    <x-page-header title="Site map" lead="Every page on this website." code="MAP" label="Site map" photo="direction-sign" photo-alt="The roadside sign pointing to the centre" />
    <div class="wrap mt-12 grid gap-10 md:mt-16 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            'The centre' => [route('home') => 'Home', route('about') => 'About the centre', route('contact') => 'Contact and directions', route('services') => 'Services and departments', route('clinics') => 'Specialist clinics'],
            'Departments' => collect((array) ccmc('departments'))->mapWithKeys(fn ($d, $s) => [route('department', $s) => $d['name']])->all(),
            'Patients' => [route('appointments') => 'Request an appointment', route('new-patients') => 'New patient registration', route('department', 'dialysis').'#enquire' => 'Dialysis enquiry', route('handouts') => 'Patient handouts', route('health-checks') => 'Health self-checks'],
            'More' => [route('careers') => 'Careers', route('careers.apply') => 'Apply for a job'] + $jobs->mapWithKeys(fn ($j) => [route('careers.show', $j) => $j->title])->all() + [route('privacy') => 'Privacy notice', route('credits') => 'Photo credits'],
        ] as $heading => $links)
            <section>
                <h2 class="font-display text-xl font-medium">{{ $heading }}</h2>
                <ul class="mt-3">
                    @foreach ($links as $href => $label)<li><a class="inline-flex min-h-11 items-center text-link" href="{{ $href }}">{{ $label }}</a></li>@endforeach
                </ul>
            </section>
        @endforeach
    </div>
</x-layouts.site>
