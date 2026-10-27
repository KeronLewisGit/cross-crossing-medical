{{-- Included on /services/dialysis. Works without JavaScript; the visit dates only matter for visiting patients. --}}
<section id="enquire" class="mt-20 bg-surface py-16" aria-labelledby="enq-title">
    <div class="wrap grid gap-10 lg:grid-cols-[20rem_minmax(0,1fr)] lg:gap-14">
        <div>
            <x-sign code="RD" label="Dialysis enquiry" :arrow="false" />
            <h2 id="enq-title" class="display-3 mt-5">Ask the dialysis unit to call you</h2>
            <p class="mt-3 text-ink-2">Tell us a little about the patient's situation and the sessions that would suit. The unit calls back to arrange an initial examination and review by our physicians.</p>
            <p class="mt-4 text-sm text-ink-3">Your reference arrives on screen straight away. Nothing about the patient is sent by email.</p>
        </div>
        <form method="POST" action="{{ route('dialysis.store') }}" enctype="multipart/form-data" class="panel space-y-10 p-6 md:p-9" x-data="requestForm" @submit="submit">
            @csrf
            <x-not-emergency />
            <x-form-errors />
            <fieldset class="space-y-5" x-data="{ situation: @js(old_text('situation', '')) }">
                <legend class="fieldset-title mb-5"><span class="step">1</span>The patient's situation</legend>
                <div class="grid gap-2" role="radiogroup" aria-label="Which best describes the patient?">
                    @foreach ($situations as $k => $label)
                        <label class="choice"><input type="radio" name="situation" value="{{ $k }}" x-model="situation" required @checked(old('situation') === $k)>{{ $label }}</label>
                    @endforeach
                </div>
                <x-error for="situation" />
                <x-field name="current_unit" label="Current dialysis unit or referring doctor" :optional="true" maxlength="120" />
                @if (isset($situations['visiting']))
                    <div class="grid gap-5 sm:grid-cols-2" x-show="situation === 'visiting'" x-cloak>
                        <x-field name="visit_from" label="First day in Trinidad" type="date" :min="today()->toDateString()" />
                        <x-field name="visit_to" label="Last day" type="date" :min="today()->toDateString()" />
                    </div>
                @endif
                <x-field name="referral" label="Referral letter or latest dialysis summary" type="file" :optional="true" accept=".pdf,.jpg,.jpeg,.png,.webp,.heic,.heif" hint="A photo or PDF, up to 8 MB. Kept privately for the unit." />
                <x-attached form="dialysis" field="referral" />
            </fieldset>
            <fieldset class="space-y-5">
                <legend class="fieldset-title mb-5"><span class="step">2</span>Sessions that would suit</legend>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-select name="schedule" label="Days" :options="(array) ccmc('dialysis.schedules')" :required="true" :value="old('schedule', 'either')" :placeholder="null" />
                    <x-select name="shift" label="Time" :options="(array) ccmc('dialysis.shifts')" :required="true" :value="old('shift', 'any')" :placeholder="null" />
                </div>
                <x-field name="message" label="Anything else the unit should know" type="textarea" :optional="true" rows="3" maxlength="1000" />
            </fieldset>
            <x-contact-fields :step="3" title="The patient, and who we call">
                <x-for-whom />
            </x-contact-fields>
            <x-consent purpose="so that the dialysis unit can call me back about this enquiry" />
            <x-submit label="Send the enquiry" />
        </form>
    </div>
</section>
