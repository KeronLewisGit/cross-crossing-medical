@php
    $days = (array) ccmc('weekdays');
    $oldDays = (array) old('days', []);
@endphp
<x-layouts.site title="Request an appointment" description="Request a clinic appointment, test or scan at Cross Crossing Medical Centre, San Fernando. Choose the days and time that suit you and we call you back.">
    <x-page-header title="Request an appointment" lead="Choose the clinic or test and the days that suit you. The appointments team calls you back to agree a time; nothing is booked until then." code="APPT" label="Appointments" photo="consultation" photo-alt="A doctor holding a stethoscope" />

    <div class="wrap mt-10 grid gap-10 md:mt-14 lg:grid-cols-[minmax(0,1fr)_20rem] lg:gap-14">
        <form method="POST" action="{{ route('appointments.store') }}" enctype="multipart/form-data" class="panel space-y-10 p-6 md:p-9" x-data="requestForm" @submit="submit">
            @csrf
            <x-not-emergency />
            <x-form-errors />

            <fieldset class="space-y-5">
                <legend class="fieldset-title mb-5"><span class="step">1</span>What do you need?</legend>
                <x-select name="service" label="Clinic or test" :options="\App\Http\Controllers\FormController::serviceOptions()" :value="$selected" :required="true" placeholder="Choose a clinic or test…" />
                <div>
                    <p class="label" id="seen-label">Has the patient been to CCMC before?</p>
                    <div class="grid gap-2 sm:grid-cols-3" role="radiogroup" aria-labelledby="seen-label">
                        @foreach (['yes' => 'Yes', 'no' => 'No, first visit', 'unsure' => 'Not sure'] as $v => $t)
                            <label class="choice"><input type="radio" name="seen_before" value="{{ $v }}" required @checked(old('seen_before') === $v)>{{ $t }}</label>
                        @endforeach
                    </div>
                    <x-error for="seen_before" />
                </div>
                <x-field name="reason" label="Reason for the visit" type="textarea" :optional="true" rows="3" maxlength="500" hint="A few words is enough, e.g. 'follow-up for blood pressure'. Please don't include detailed medical history." />
                <x-field name="referral" label="Doctor's referral or test request" type="file" :optional="true" accept=".pdf,.jpg,.jpeg,.png,.webp,.heic,.heif" hint="A photo or PDF, up to 8 MB. Kept privately for the appointments team." />
            </fieldset>

            <fieldset class="space-y-5">
                <legend class="fieldset-title mb-5"><span class="step">2</span>When suits you?</legend>
                <div>
                    <p class="label" id="days-label">Days that suit you <span class="opt">(tick all that work)</span></p>
                    <div class="grid grid-cols-4 gap-2 sm:grid-cols-7" role="group" aria-labelledby="days-label">
                        @foreach ($days as $k => $label)
                            <label class="choice compact"><input type="checkbox" name="days[]" value="{{ $k }}" @checked(in_array($k, $oldDays, true))>{{ $label }}</label>
                        @endforeach
                    </div>
                    <x-error for="days" />
                </div>
                <div>
                    <p class="label" id="win-label">Time of day</p>
                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-4" role="radiogroup" aria-labelledby="win-label">
                        @foreach ((array) ccmc('time_windows') as $k => $label)
                            <label class="choice compact"><input type="radio" name="window" value="{{ $k }}" required @checked(old('window', 'any') === $k)>{{ $label }}</label>
                        @endforeach
                    </div>
                    <x-error for="window" />
                </div>
                <x-field name="from_date" label="Earliest date" type="date" :optional="true" :min="today()->toDateString()" :max="today()->addDays((int) ccmc('days_ahead'))->toDateString()" hint="Leave blank for 'as soon as possible'." class="input sm:max-w-xs" />
            </fieldset>

            <x-contact-fields :step="3" title="The patient, and who we call">
                <x-for-whom />
            </x-contact-fields>

            <x-consent purpose="so that the centre can call me back about this appointment" />
            <x-submit label="Send my request" />
        </form>

        <aside class="space-y-6 lg:pt-2">
            <div class="panel p-6">
                <h2 class="font-display text-lg font-medium">What happens next</h2>
                <ol class="steps mt-5 text-[0.9375rem]">
                    <li><p>You get a reference number on screen, and by email if you give one.</p></li>
                    <li><p>The appointments team calls you back, usually within 2 hours.</p></li>
                    <li><p>You agree a day and time. That is when the appointment is booked.</p></li>
                </ol>
            </div>
            <div class="panel p-6">
                <h2 class="font-display text-lg font-medium">First visit?</h2>
                <p class="mt-2 text-[0.9375rem] text-ink-2">Save time at reception by registering online first.</p>
                <a href="{{ route('new-patients') }}" class="btn btn-outline btn-sm mt-4">Register as a new patient</a>
            </div>
            <div class="panel p-6">
                <h2 class="font-display text-lg font-medium">Rather call?</h2>
                @foreach ((array) ccmc('phones') as $p)
                    <a href="{{ tel_href($p) }}" class="mt-2 flex min-h-11 items-center gap-2 font-bold text-link"><x-icon name="phone" class="h-4 w-4" />{{ format_phone($p) }}</a>
                @endforeach
                <p class="mt-2 text-sm text-ink-3">Dental appointments are with Easy Smile Dental Centre: <a class="text-link" href="{{ route('department', 'dental') }}">see dental</a>.</p>
            </div>
        </aside>
    </div>
</x-layouts.site>
