@props(['code'])
@php
    $copy = [
        '404' => ['That page has moved', 'The link may be from our old website. Everything is still here: services, clinics, new patient registration, the dialysis unit and patient handouts.'],
        '403' => ['You can\'t open that', 'Your account doesn\'t have access to this page. Ask an administrator if you need it.'],
        '413' => ['Those files are too large to send', 'The attachments add up to more than the website can take at once. Go back, attach smaller or fewer photos or PDFs and send it again, or bring the documents with you.'],
        '419' => ['Your session timed out', 'For your security the form expired. Go back, refresh the page and send it again.'],
        '429' => ['Too many tries', 'Please wait a minute and try again, or call us. We are open 24 hours.'],
        '500' => ['Something went wrong on our side', 'Please try again in a minute. If you were sending a form, call us and we will take it by phone.'],
        '503' => ['Back shortly', 'We are updating the website. The centre itself is open as usual, 24 hours a day.'],
    ][$code] ?? ['Something went wrong', 'Please try again.'];
@endphp
<x-layouts.site :title="$copy[0]" :mobile-bar="false">
    <x-page-header :title="$copy[0]" :lead="$copy[1]" :code="$code" label="Error" photo="direction-sign" photo-alt="The roadside sign pointing to Cross Crossing Medical Centre" />
    <section class="wrap mt-12 md:mt-16">
        <x-not-emergency class="max-w-3xl" />
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('home') }}" class="btn btn-primary">Go to the home page<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
            @if ($code === '404')
                <a href="{{ route('services') }}" class="btn btn-outline">All services</a>
            @endif
            <a href="{{ tel_href(main_phone()) }}" class="btn btn-outline"><x-icon name="phone" class="h-4 w-4" />{{ format_phone(main_phone()) }}</a>
        </div>
    </section>
</x-layouts.site>
