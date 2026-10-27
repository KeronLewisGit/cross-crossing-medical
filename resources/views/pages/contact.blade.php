@php
    $phones = (array) ccmc('phones');
    $address = ccmc('address');
    $dental = ccmc('departments.dental');
    $topic = old('topic', array_key_exists((string) request('topic'), $topics) ? request('topic') : 'general');
    $lat = (float) ccmc('geo.lat'); $lng = (float) ccmc('geo.lng');
    $bbox = implode(',', [$lng - 0.008, $lat - 0.005, $lng + 0.008, $lat + 0.005]);
@endphp
<x-layouts.site title="Contact and directions" :description="'Cross Crossing Medical Centre, Oliver Avenue, Cross Crossing, San Fernando. Call '.format_phone($phones[0] ?? '').'. Open 24 hours.'">
    <x-page-header title="Contact and directions" lead="Call any time, day or night. For a question that can wait, send a message and we will reply." code="MAP" label="Contact" photo="building" photo-alt="The front of the centre on Oliver Avenue" />

    <div class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.25fr)] lg:gap-16">
        <div class="space-y-10">
            <section aria-labelledby="dir-title">
                <h2 id="dir-title" class="display-3">Phone directory</h2>
                <dl class="mt-5 divide-y divide-line border-y border-line">
                    <div class="grid gap-1 py-3.5 sm:grid-cols-[11rem_1fr]"><dt class="font-bold">Main line, 24 hours</dt><dd class="flex flex-wrap gap-x-4">@foreach ($phones as $p)<a href="{{ tel_href($p) }}" class="inline-flex min-h-11 items-center font-semibold text-link">{{ format_phone($p) }}</a>@endforeach</dd></div>
                    <div class="grid gap-1 py-3.5 sm:grid-cols-[11rem_1fr]"><dt class="font-bold">Emergency room</dt><dd class="text-ink-2">Come straight in, or call <a href="{{ tel_href($phones[0] ?? '') }}" class="font-semibold text-link">{{ format_phone($phones[0] ?? '') }}</a>. Ambulance: <a href="tel:{{ ccmc('ambulance') }}" class="font-semibold text-link">{{ ccmc('ambulance') }}</a></dd></div>
                    <div class="grid gap-1 py-3.5 sm:grid-cols-[11rem_1fr]"><dt class="font-bold">Fax</dt><dd>{{ format_phone((string) ccmc('fax')) }}</dd></div>
                    <div class="grid gap-1 py-3.5 sm:grid-cols-[11rem_1fr]"><dt class="font-bold">Email</dt><dd><a href="mailto:{{ ccmc('email') }}" class="inline-flex min-h-11 items-center font-semibold text-link">{{ ccmc('email') }}</a></dd></div>
                    <div class="grid gap-1 py-3.5 sm:grid-cols-[11rem_1fr]"><dt class="font-bold">Dental</dt><dd class="text-ink-2">{{ $dental['partner'] }}: @foreach ($dental['phones'] as $p)<a href="{{ tel_href($p) }}" class="font-semibold text-link whitespace-nowrap">{{ format_phone($p) }}</a>@if(! $loop->last) or @endif @endforeach</dd></div>
                    <div class="grid gap-1 py-3.5 sm:grid-cols-[11rem_1fr]"><dt class="font-bold">Facebook</dt><dd><a href="{{ ccmc('facebook') }}" class="inline-flex min-h-11 items-center gap-2 font-semibold text-link" rel="noopener" target="_blank"><x-icon name="facebook" class="h-4 w-4" />facebook.com/ccmctt</a></dd></div>
                </dl>
            </section>
            <section aria-labelledby="addr-title">
                <h2 id="addr-title" class="display-3">Find us</h2>
                <address class="mt-4 not-italic text-lg">{{ $address['street'] }}, {{ $address['area'] }}<br>{{ $address['city'] }}, {{ $address['country'] }}</address>
                <p class="mt-1 text-ink-2">{{ ucfirst($address['landmark']) }}.</p>
                <div class="mt-5 overflow-hidden rounded-2xl border border-line">
                    <iframe title="Map showing Cross Crossing Medical Centre" src="https://www.openstreetmap.org/export/embed.html?bbox={{ $bbox }}&amp;layer=mapnik&amp;marker={{ $lat }},{{ $lng }}" class="block aspect-[4/3] w-full" loading="lazy" referrerpolicy="no-referrer"></iframe>
                </div>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ ccmc('map_url') }}" class="btn btn-primary" target="_blank" rel="noopener"><x-icon name="map-pin" class="h-4 w-4" />Directions in Google Maps</a>
                    <a href="https://www.openstreetmap.org/?mlat={{ $lat }}&amp;mlon={{ $lng }}#map=17/{{ $lat }}/{{ $lng }}" class="btn btn-outline" target="_blank" rel="noopener">Larger map</a>
                </div>
            </section>
        </div>

        <section aria-labelledby="msg-title">
            <form method="POST" action="{{ route('contact.store') }}" class="panel space-y-8 p-6 md:p-9" x-data="requestForm" @submit="submit">
                @csrf
                <h2 id="msg-title" class="display-3">Send a message</h2>
                <x-not-emergency />
                <x-form-errors />
                <fieldset>
                    <legend class="label">What's it about?</legend>
                    <div class="grid gap-2 sm:grid-cols-2">
                        @foreach ($topics as $v => $t)
                            <label class="choice"><input type="radio" name="topic" value="{{ $v }}" required @checked($topic === $v)>{{ $t }}</label>
                        @endforeach
                    </div>
                    <x-error for="topic" />
                </fieldset>
                <x-field name="message" label="Message" type="textarea" :required="true" rows="5" maxlength="3000" hint="Please don't include medical details here. To book, use the appointment form." />
                <x-contact-fields :step="2" title="How to reach you" />
                <x-consent purpose="so that the centre can reply to my message" />
                <x-submit label="Send message" />
            </form>
        </section>
    </div>
</x-layouts.site>
