@php
    $phones = (array) ccmc('phones');
    $depts = (array) ccmc('departments');
    $icons = ['accident-emergency' => 'ambulance', 'cardiac' => 'heart-pulse', 'dialysis' => 'droplet', 'laboratory' => 'flask', 'imaging' => 'scan', 'surgery' => 'scalpel', 'sleep-lung' => 'moon-wave', 'vaccinations' => 'syringe', 'dental' => 'tooth'];
@endphp
<x-layouts.site>
    {{-- Hero: the building itself, the welcome, and the two things people come for. --}}
    <section class="relative overflow-hidden">
        <div class="wrap grid gap-10 pb-10 pt-10 md:pt-14 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,1fr)] lg:items-center lg:gap-14 lg:pb-16 lg:pt-16">
            <div>
                <x-sign code="CCMC" label="Oliver Avenue · San Fernando" />
                <h1 class="display-1 mt-6 max-w-[14ch]">Care around the clock in San&nbsp;Fernando.</h1>
                <p class="lead mt-5 text-ink-2">Physicians and a full nursing staff, an emergency room, a cardiac care unit, a dialysis unit, lab, X-ray and surgical suites, all in one building near Halliburton. Open 24 hours a day, 7 days a week, 365 days a year.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('appointments') }}" class="btn btn-primary">Request an appointment<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
                    <a href="{{ route('new-patients') }}" class="btn btn-outline">Register as a new patient</a>
                </div>
                <dl class="mt-10 grid max-w-lg grid-cols-3 divide-x divide-line rounded-xl border border-line bg-surface">
                    @foreach (['24' => 'hours a day', '7' => 'days a week', '365' => 'days a year'] as $n => $l)
                        <div class="px-4 py-3.5"><dt class="sr-only">Open</dt><dd><span class="font-display block text-3xl font-semibold tracking-tight text-link num">{{ $n }}</span><span class="text-sm font-semibold text-ink-3">{{ $l }}</span></dd></div>
                    @endforeach
                </dl>
            </div>
            <div class="relative">
                <div class="frame-light">
                    <x-photo key="building" alt="The front of Cross Crossing Medical Centre: a white building with blue tiled entrance canopy lettered CCMC" :eager="true" sizes="(min-width: 1024px) 36rem, 100vw" class="aspect-[3/2]" />
                </div>
                <a href="{{ route('department', 'accident-emergency') }}" class="absolute -bottom-5 left-4 right-4 flex items-center gap-3 ae-fill rounded-xl px-4 py-3 shadow-md sm:left-auto sm:right-6 sm:max-w-sm">
                    <x-icon name="ambulance" class="h-6 w-6 flex-none" />
                    <span class="text-[0.9375rem] font-bold leading-snug">Emergency? No appointment needed. Come straight to A&amp;E, open 24 hours.</span>
                    <x-icon name="arrow-right" class="h-5 w-5 flex-none" />
                </a>
            </div>
        </div>
        <x-pulse-line :draw="true" class="text-[color:var(--pulse)]" />
    </section>

    {{-- Wayfinding: where do you need to go? --}}
    <section class="wrap mt-14 grid gap-8 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,1fr)] lg:gap-12" aria-labelledby="dir-title" data-reveal>
        <div class="directory stucco on-sign shadow-md">
            <div class="flex items-center justify-between gap-3 px-5 pb-3 pt-5">
                <h2 id="dir-title" class="font-display text-[1.375rem] font-medium text-white">Where would you like to go?</h2>
                <span class="hidden text-xs font-bold uppercase tracking-[0.14em] text-white/60 sm:inline">Directory</span>
            </div>
            <a href="{{ route('department', 'accident-emergency') }}"><span class="dir-code ae">A&amp;E</span><span><span class="dir-name">Emergency room</span><span class="dir-note">Open 24 hours. Come straight in, no appointment.</span></span><x-icon name="arrow-right" class="dir-arrow" /></a>
            <a href="{{ route('appointments') }}"><span class="dir-code">APPT</span><span><span class="dir-name">Clinic or test appointment</span><span class="dir-note">Pick the clinic and the days that suit you. We call back.</span></span><x-icon name="arrow-right" class="dir-arrow" /></a>
            <a href="{{ route('new-patients') }}"><span class="dir-code">REG</span><span><span class="dir-name">New patient registration</span><span class="dir-note">Fill in your details before your first visit.</span></span><x-icon name="arrow-right" class="dir-arrow" /></a>
            <a href="{{ route('department', 'dialysis') }}"><span class="dir-code">RD</span><span><span class="dir-name">Renal Centre &amp; Dialysis Unit</span><span class="dir-note">Ask about an initial dialysis examination.</span></span><x-icon name="arrow-right" class="dir-arrow" /></a>
            <a href="{{ route('department', 'laboratory') }}"><span class="dir-code">LAB</span><span><span class="dir-name">Laboratory and X-ray</span><span class="dir-note">On site. Results are never put online.</span></span><x-icon name="arrow-right" class="dir-arrow" /></a>
            <a href="{{ route('careers') }}"><span class="dir-code">HR</span><span><span class="dir-name">Careers</span><span class="dir-note">Nurses, technicians and support staff.</span></span><x-icon name="arrow-right" class="dir-arrow" /></a>
        </div>
        <div class="lg:pt-2">
            <x-sign code="APPT" label="How a request works" :arrow="false" />
            <h2 class="display-3 mt-5">No more holding on the line to book.</h2>
            <p class="mt-3 text-ink-2">Send a request any time of day. The appointments team calls you back to agree a real day and time with the clinic.</p>
            <ol class="steps mt-7">
                <li><div><p class="font-bold">Choose the clinic or test</p><p class="text-ink-2">Cardiology, a bone density scan, an ECG, vaccinations and more.</p></div></li>
                <li><div><p class="font-bold">Tell us the days and time that suit you</p><p class="text-ink-2">Morning, afternoon or evening, and the earliest date.</p></div></li>
                <li><div><p class="font-bold">Get a reference number</p><p class="text-ink-2">On screen straight away, and by email if you give one.</p></div></li>
                <li><div><p class="font-bold">We call you back</p><p class="text-ink-2">The appointment is booked once you have agreed a time with us.</p></div></li>
            </ol>
            <div class="ae-note mt-8"><x-icon name="alert" class="h-5 w-5" /><p class="text-[0.9375rem]"><strong>Forms are not for emergencies.</strong> If you are unwell now, come to our emergency room or call {{ ccmc('ambulance') }} for an ambulance.</p></div>
        </div>
    </section>

    {{-- Departments as room plates. --}}
    <section class="wrap mt-24" aria-labelledby="dept-title">
        <div class="flex flex-wrap items-end justify-between gap-4" data-reveal>
            <div>
                <x-sign code="01" label="Departments" :arrow="false" />
                <h2 id="dept-title" class="display-2 mt-5">Everything under one roof</h2>
                <p class="lead mt-3 text-ink-2">"With all facilities within one location, you don't need to go anywhere else."</p>
            </div>
            <a href="{{ route('services') }}" class="btn btn-outline">All services<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
        </div>
        <ul class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($depts as $slug => $d)
                <li class="card-link plate p-5" data-reveal style="--reveal-delay: {{ $loop->index * 40 }}ms">
                    <div class="flex items-center justify-between gap-3">
                        <span @class(['plate-code', 'ae' => $d['emergency'] ?? false])>{{ $d['code'] }}</span>
                        <x-icon :name="$icons[$slug] ?? 'activity'" class="h-6 w-6 text-ink-3" />
                    </div>
                    <h3 class="mt-4 text-[1.1875rem] font-medium"><a href="{{ route('department', $slug) }}" class="stretch">{{ $d['name'] }}</a></h3>
                    <p class="mt-1.5 text-ink-2">{{ $d['short'] }}</p>
                </li>
            @endforeach
        </ul>
    </section>

    {{-- Tests and specialist clinics. --}}
    <section class="mt-24 bg-surface py-20" aria-labelledby="tests-title">
        <div class="wrap grid gap-12 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.1fr)] lg:gap-16">
            <div data-reveal>
                <x-sign code="02" label="Tests and scans" :arrow="false" />
                <h2 id="tests-title" class="display-2 mt-5">Tests done on site</h2>
                <p class="mt-4 text-ink-2 measure">The tests and scans the centre offers, from its own list of services. Request any of them online; we call back with a time.</p>
                <ul class="mt-8 grid gap-x-6 sm:grid-cols-2">
                    @foreach ((array) ccmc('tests') as $key => $label)
                        @continue(in_array($key, ['vaccination', 'minor-surgery'], true))
                        <li class="border-b border-line"><a href="{{ route('appointments', ['service' => $key]) }}" class="flex min-h-12 items-center justify-between gap-3 py-2 font-semibold hover:text-link">{{ $label }}<x-icon name="arrow-right" class="h-4 w-4 flex-none text-ink-3" /></a></li>
                    @endforeach
                </ul>
            </div>
            <div class="grid content-start gap-6" data-reveal>
                <div class="frame-light"><x-photo key="cardiac" alt="A patient monitor showing ECG, oxygen and blood pressure traces" sizes="(min-width: 1024px) 40rem, 100vw" class="aspect-[16/9]" /></div>
                <div class="rounded-2xl border border-line p-6">
                    <h3 class="text-[1.1875rem] font-medium">Specialist clinics</h3>
                    <p class="mt-1 text-ink-2">"We have many specialist physicians for most medical needs."</p>
                    <ul class="mt-5 flex flex-wrap gap-2">
                        @foreach ((array) ccmc('clinics') as $key => $label)
                            <li><a href="{{ route('appointments', ['service' => $key]) }}" class="tag">{{ \Illuminate\Support\Str::before($label, ' (') }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- New patients: replaces the empty "newpatient" page. --}}
    <section class="wrap mt-24 grid items-center gap-10 md:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)] lg:gap-16" aria-labelledby="reg-title">
        <div class="grid grid-cols-2 gap-4" data-reveal>
            <div class="frame-light"><x-photo key="reception" alt="Reception desk and red waiting-room chairs" sizes="(min-width: 768px) 20vw, 50vw" class="aspect-[2/3]" /></div>
            <div class="frame-light mt-10"><x-photo key="lab-coat" alt="A white coat with the CCMC logo in front of framed certificates" sizes="(min-width: 768px) 20vw, 50vw" class="aspect-[2/3]" /></div>
        </div>
        <div data-reveal>
            <x-sign code="REG" label="New patients" :arrow="false" />
            <h2 id="reg-title" class="display-2 mt-5">Register before your first visit</h2>
            <p class="lead mt-4 text-ink-2">Fill in the patient's details at home, so your first visit starts with care, not paperwork.</p>
            <ul class="check-list mt-6">
                <li><x-icon name="check-circle" />Patient details, emergency contact and insurer in one short form</li>
                <li><x-icon name="check-circle" />Add a photo of your ID and insurance card from your phone, or bring them in</li>
                <li><x-icon name="lock" />Documents are kept off the public website and opened only by the registration team</li>
                <li><x-icon name="shield" />Your consent is recorded, as the Data Protection Act requires</li>
            </ul>
            <a href="{{ route('new-patients') }}" class="btn btn-primary mt-8">Start registration<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
        </div>
    </section>

    {{-- Dialysis. --}}
    <section class="mt-24" aria-labelledby="rd-title">
        <div class="stucco on-sign text-white">
            <div class="wrap grid items-center gap-10 py-16 md:grid-cols-2 lg:gap-16 lg:py-20">
                <div data-reveal>
                    <x-sign code="RD" label="Renal Centre & Dialysis Unit" :arrow="false" />
                    <h2 id="rd-title" class="display-2 mt-5">A dedicated dialysis unit</h2>
                    <p class="lead mt-4 text-white/85">New patients start with an initial dialysis examination and review by our physicians. Send an enquiry and the unit will call you to arrange it.</p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('department', 'dialysis') }}#enquire" class="btn btn-brass">Send a dialysis enquiry<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
                        <a href="{{ route('department', 'dialysis') }}" class="btn btn-on-sign">About the unit</a>
                    </div>
                </div>
                <div class="grid grid-cols-[1.2fr_1fr] gap-4" data-reveal>
                    <div class="frame"><x-photo key="renal-sign" alt="The blue Renal Centre & Dialysis Unit sign at the centre" sizes="(min-width: 768px) 25vw, 55vw" class="aspect-[4/3]" /></div>
                    <div class="frame mt-12"><x-photo key="dialysis" alt="A haemodialysis machine beside a reclining treatment chair (illustrative)" sizes="(min-width: 768px) 20vw, 45vw" class="aspect-[4/5]" /></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Patient corner and careers. --}}
    <section class="wrap mt-24 grid gap-6 lg:grid-cols-2" aria-label="Patient corner and careers">
        <article class="card-link panel overflow-hidden" data-reveal>
            <x-photo key="consultation" alt="A doctor's hands holding a stethoscope" sizes="(min-width: 1024px) 40vw, 100vw" class="card-img aspect-[2/1]" />
            <div class="p-6 md:p-8">
                <x-sign code="PC" label="Patient corner" :arrow="false" />
                <h2 class="display-3 mt-4"><a href="{{ route('handouts') }}" class="stretch">Handouts and self-checks</a></h2>
                <p class="mt-2 text-ink-2">Blood pressure, diabetes and bone-health handouts, vaccination information, and quick checks for diabetes risk, BMI and fracture risk.</p>
                <p class="mt-5 inline-flex items-center gap-2 font-bold text-link">Open the patient corner<x-icon name="arrow-right" class="h-4 w-4" /></p>
            </div>
        </article>
        <article class="card-link panel overflow-hidden" data-reveal style="--reveal-delay: 80ms">
            <x-photo key="nursing" alt="A smiling Caribbean nurse in a white uniform on a hospital ward" sizes="(min-width: 1024px) 40vw, 100vw" class="card-img aspect-[2/1]" position="center 30%" />
            <div class="p-6 md:p-8">
                <x-sign code="HR" label="Careers" :arrow="false" />
                <h2 class="display-3 mt-4"><a href="{{ route('careers') }}" class="stretch">Work at a 24-hour centre</a></h2>
                <p class="mt-2 text-ink-2">Nurses, dialysis and lab technicians, radiographers and support staff. {{ $openJobs ? $openJobs.' '.\Illuminate\Support\Str::plural('vacancy', $openJobs).' open now' : 'Send your CV for future openings' }}.</p>
                <p class="mt-5 inline-flex items-center gap-2 font-bold text-link">See careers<x-icon name="arrow-right" class="h-4 w-4" /></p>
            </div>
        </article>
    </section>

    {{-- Find us. --}}
    <section class="wrap mt-24" aria-labelledby="visit-title">
        <div class="overflow-hidden rounded-2xl border border-line bg-surface lg:grid lg:grid-cols-[1.1fr_1fr]">
            <x-photo key="san-fernando" alt="San Fernando from the air, with San Fernando Hill and the waterfront" sizes="(min-width: 1024px) 45vw, 100vw" class="aspect-[16/9] lg:aspect-auto lg:h-full" />
            <div class="p-6 md:p-10" data-reveal>
                <x-sign code="MAP" label="Find us" :arrow="false" />
                <h2 id="visit-title" class="display-3 mt-4">Oliver Avenue, Cross Crossing</h2>
                <p class="mt-2 text-ink-2">Near Halliburton, in the suburban area of San Fernando.</p>
                <dl class="mt-6 space-y-3">
                    <div class="flex gap-3"><dt><x-icon name="phone" class="mt-0.5 h-5 w-5 text-ink-3" /><span class="sr-only">Phone</span></dt><dd class="font-semibold">@foreach ($phones as $p)<a href="{{ tel_href($p) }}" class="inline-flex min-h-11 items-center underline-offset-4 hover:underline">{{ format_phone($p) }}</a>@if(! $loop->last)<span class="px-2 text-ink-3">or</span>@endif @endforeach</dd></div>
                    <div class="flex gap-3"><dt><x-icon name="mail" class="mt-0.5 h-5 w-5 text-ink-3" /><span class="sr-only">Email</span></dt><dd><a href="mailto:{{ ccmc('email') }}" class="inline-flex min-h-11 items-center font-semibold underline-offset-4 hover:underline">{{ ccmc('email') }}</a></dd></div>
                    <div class="flex gap-3"><dt><x-icon name="clock" class="mt-0.5 h-5 w-5 text-ink-3" /><span class="sr-only">Hours</span></dt><dd class="font-semibold">Open 24 hours, every day of the year</dd></div>
                </dl>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ ccmc('map_url') }}" class="btn btn-primary" rel="noopener" target="_blank"><x-icon name="map-pin" class="h-4 w-4" />Get directions<span class="sr-only">(opens Google Maps)</span></a>
                    <a href="{{ route('contact') }}" class="btn btn-outline">Contact and map</a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.site>
