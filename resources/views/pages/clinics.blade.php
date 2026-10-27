<x-layouts.site title="Specialist clinics" description="Specialist clinics at Cross Crossing Medical Centre, San Fernando: cardiology, endocrinology, family practice, internal medicine, occupational health, orthopaedic surgery, psychiatry, rheumatology and urology.">
    <x-page-header title="Specialist clinics" lead="Many specialist physicians for most medical needs, plus routine check-ups and drop-in visits. Choose a clinic and request an appointment; we call you back with a time." code="CLN" label="Clinics" photo="consultation" photo-alt="A doctor holding a stethoscope" />

    <section class="wrap mt-12 md:mt-16" aria-label="Clinics">
        <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ((array) ccmc('clinics') as $key => $label)
                <li class="card-link plate p-5">
                    <x-icon name="stethoscope" class="h-6 w-6 text-ink-3" />
                    <h2 class="mt-3 text-[1.1875rem] font-medium"><a href="{{ route('appointments', ['service' => $key]) }}" class="stretch">{{ $label }}</a></h2>
                    <p class="mt-auto pt-3 inline-flex items-center gap-1.5 text-[0.9375rem] font-bold text-link">Request an appointment<x-icon name="arrow-right" class="h-4 w-4" /></p>
                </li>
            @endforeach
        </ul>
    </section>

    <section class="wrap mt-16 grid gap-6 lg:grid-cols-2">
        <div class="panel p-6 md:p-8">
            <h2 class="display-3">Clinic days and times</h2>
            <p class="mt-3 text-ink-2 measure">Each specialist holds clinics on set days. Tell us the days and time of day that suit you on the request form, and the appointments team will match you to the next clinic and call to confirm.</p>
            <a href="{{ route('appointments') }}" class="btn btn-primary mt-6">Request an appointment</a>
        </div>
        <div class="panel p-6 md:p-8">
            <h2 class="display-3">Seeing a doctor today?</h2>
            <p class="mt-3 text-ink-2 measure">The centre has physicians on duty 24 hours a day. If you need to be seen urgently, come in or call <a class="text-link font-bold" href="{{ tel_href(main_phone()) }}">{{ format_phone(main_phone()) }}</a>. For emergencies, go straight to <a class="text-link font-bold" href="{{ route('department', 'accident-emergency') }}">A&amp;E</a>.</p>
        </div>
    </section>
</x-layouts.site>
