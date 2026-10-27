@php
    use App\Enums\SubmissionType as T;
    $next = match ($type) {
        T::Appointment => 'The appointments team will call you back, usually within 2 hours, to agree a day and time. Nothing is booked until you have spoken to us.',
        T::Registration => 'The registration team will check the details and open the patient file. Bring the original ID and insurance card to the first visit.',
        T::Dialysis => 'The dialysis unit will call you back, usually within 2 hours, to talk through the next step.',
        T::Career => 'The HR team reviews every application and will contact you if you are shortlisted.',
        default => 'We will reply as soon as we can, usually within a few hours.',
    };
@endphp
<x-layouts.site title="Thank you" :mobile-bar="false">
    <x-page-header title="Thank you. We have it." :lead="$next" code="OK" :label="$type->label()" />
    <section class="wrap mt-12 md:mt-16">
        <div class="panel max-w-xl border-l-[6px] border-l-[color:var(--pulse)] p-7 md:p-9">
            <p class="kicker text-ink-3">Your reference</p>
            <p class="font-display mt-3 text-3xl font-semibold tracking-wide num sm:text-4xl">{{ $reference }}</p>
            <p class="mt-5 text-ink-2">Write it down or take a screenshot. If you gave an email address we have sent it to you too. Quote it if you call, and we will find your request straight away.</p>
        </div>
        @if ($type === T::Appointment)
            <div class="panel mt-6 max-w-xl p-6">
                <p class="font-bold">First visit to the centre?</p>
                <p class="mt-1 text-ink-2">Save time at reception by registering the patient now.</p>
                <a href="{{ route('new-patients') }}" class="btn btn-outline btn-sm mt-4">Register as a new patient</a>
            </div>
        @endif
        @if ($type !== T::Career)
            <x-not-emergency class="mt-6 max-w-xl" />
        @endif
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ tel_href(main_phone()) }}" class="btn btn-outline"><x-icon name="phone" class="h-4 w-4" />{{ format_phone(main_phone()) }}</a>
            <a href="{{ route('home') }}" class="btn btn-primary">Back to the home page</a>
        </div>
    </section>
</x-layouts.site>
