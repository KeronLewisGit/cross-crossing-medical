@props(['dob' => true, 'dobRequired' => false])
{{-- "Is this for you or someone else?" Without JavaScript every field shows; with it, the patient fields appear only for someone else. --}}
<div class="space-y-5" x-data="{ whom: '{{ old('for_whom', 'self') }}' }">
    <div>
        <p class="label" id="whom-label">Who is this for?</p>
        <div class="grid gap-2 sm:grid-cols-2" role="radiogroup" aria-labelledby="whom-label">
            <label class="choice"><input type="radio" name="for_whom" value="self" x-model="whom" @checked(old('for_whom', 'self') === 'self')>Me</label>
            <label class="choice"><input type="radio" name="for_whom" value="other" x-model="whom" @checked(old('for_whom') === 'other')>My child, or someone I care for</label>
        </div>
        <x-error for="for_whom" />
    </div>
    <div class="grid gap-5 sm:grid-cols-2" x-show="whom === 'other'" x-cloak>
        <x-field name="patient_name" label="Patient's full name" maxlength="120" hint="Only if the patient is someone else." />
        <x-field name="relationship" label="Your relationship to them" :optional="true" maxlength="60" hint="e.g. mother, son, carer" />
    </div>
    @if ($dob)
        <x-field name="patient_dob" label="Patient's date of birth" type="date" :required="$dobRequired" :optional="! $dobRequired" :max="today()->toDateString()" hint="Helps us find the right file." class="input sm:max-w-xs" />
    @endif
</div>
