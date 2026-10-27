<x-layouts.site title="Services and departments" description="Accident and emergency, cardiac care, dialysis, laboratory, X-ray and bone density, surgical suites, sleep and lung tests, vaccinations and dental at Cross Crossing Medical Centre, San Fernando.">
    <x-page-header title="Services and departments" lead="All facilities within one location: physicians and a full nursing staff, 24 hours a day, with the lab, X-ray and surgical suites under the same roof." code="SVC" label="Services" photo="hospital-sign" photo-alt="The blue Hospital sign with brass letters on the centre's textured wall" />

    <section class="wrap mt-12 md:mt-16" aria-labelledby="depts">
        <h2 id="depts" class="sr-only">Departments</h2>
        <ul class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ((array) ccmc('departments') as $slug => $d)
                <li class="card-link plate" data-reveal style="--reveal-delay: {{ $loop->index * 40 }}ms">
                    <x-photo :key="$d['photo']" alt="" sizes="(min-width: 1024px) 24rem, (min-width: 640px) 45vw, 100vw" class="card-img aspect-[16/9]" />
                    <div class="flex flex-1 flex-col p-5">
                        <span @class(['plate-code w-fit', 'ae' => $d['emergency'] ?? false])>{{ $d['code'] }}</span>
                        <h3 class="mt-3 text-[1.1875rem] font-medium"><a href="{{ route('department', $slug) }}" class="stretch">{{ $d['name'] }}</a></h3>
                        <p class="mt-1.5 text-ink-2">{{ $d['short'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>

    <section class="wrap mt-20 grid gap-8 lg:grid-cols-2" aria-labelledby="more">
        <div class="panel p-6 md:p-8">
            <h2 id="more" class="display-3">Also at the centre</h2>
            <ul class="check-list mt-5">
                <li><x-icon name="check-circle" />A full inpatient unit for medical admissions, with 24-hour nursing and physician services</li>
                <li><x-icon name="check-circle" />Minor outpatient surgeries</li>
                <li><x-icon name="check-circle" />Paediatric and women's healthcare</li>
                <li><x-icon name="check-circle" />Drop-in visits, routine check-ups and specialist clinics</li>
            </ul>
            <a href="{{ route('clinics') }}" class="btn btn-outline mt-7">Specialist clinics<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
        </div>
        <div class="ae-note self-start p-6"><x-icon name="ambulance" class="h-6 w-6" /><div><p class="font-display text-lg font-medium">In an emergency</p><p class="mt-1 text-ink-2">Come straight to the emergency room, open 24 hours, or call {{ ccmc('ambulance') }} for an ambulance. Call ahead on <a class="text-link font-bold" href="{{ tel_href(main_phone()) }}">{{ format_phone(main_phone()) }}</a> if you can.</p></div></div>
    </section>
</x-layouts.site>
