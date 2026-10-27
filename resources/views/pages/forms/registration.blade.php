@php($idTypes = \App\Http\Controllers\FormController::ID_TYPES)
<x-layouts.site title="New patients: register before your first visit" description="Register as a new patient at Cross Crossing Medical Centre, San Fernando, before your first visit. Add your ID and insurance card privately from your phone.">
    <x-page-header title="New patient registration" lead="Fill in the patient's details at home and your first visit starts with care, not paperwork. It takes about five minutes." code="REG" label="New patients" photo="reception" photo-alt="The reception desk and red waiting-room chairs at the centre" />

    <div class="wrap mt-10 grid gap-10 md:mt-14 lg:grid-cols-[minmax(0,1fr)_20rem] lg:gap-14">
        <form method="POST" action="{{ route('new-patients.store') }}" enctype="multipart/form-data" class="panel space-y-10 p-6 md:p-9" x-data="requestForm" @submit="submit">
            @csrf
            <x-not-emergency />
            <x-form-errors />

            <fieldset class="space-y-5">
                <legend class="fieldset-title mb-5"><span class="step">1</span>The patient</legend>
                <x-field name="patient_name" label="Patient's full name" :required="true" autocomplete="name" maxlength="120" hint="As it appears on their ID." />
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field name="patient_dob" label="Date of birth" type="date" :required="true" :max="today()->toDateString()" />
                    <x-select name="sex" label="Sex" :optional="true" :options="['female' => 'Female', 'male' => 'Male', 'unsaid' => 'Prefer not to say']" placeholder="Choose…" />
                </div>
                <x-field name="address" label="Home address" :required="true" autocomplete="street-address" maxlength="200" />
                <x-field name="town" label="Town or village" :required="true" autocomplete="address-level2" maxlength="80" hint="e.g. Cross Crossing, Marabella, Gasparillo" class="input sm:max-w-md" />
            </fieldset>

            <fieldset class="space-y-5" x-data="{ whom: '{{ old('for_whom', 'self') }}' }">
                <legend class="fieldset-title mb-5"><span class="step">2</span>Who is filling this in?</legend>
                <div class="grid gap-2 sm:grid-cols-2" role="radiogroup" aria-label="Who is filling this in?">
                    <label class="choice"><input type="radio" name="for_whom" value="self" x-model="whom" @checked(old('for_whom', 'self') === 'self')>I am the patient</label>
                    <label class="choice"><input type="radio" name="for_whom" value="other" x-model="whom" @checked(old('for_whom') === 'other')>A parent, relative or carer</label>
                </div>
                <div class="grid gap-5 sm:grid-cols-2" x-show="whom === 'other'" x-cloak>
                    <x-field name="name" label="Your full name" maxlength="120" hint="Only if you are not the patient." />
                    <x-field name="relationship" label="Your relationship to the patient" maxlength="60" hint="e.g. mother, son, carer" />
                </div>
            </fieldset>

            <x-contact-fields :step="3" title="How we reach you" :with-name="false" />

            <fieldset class="space-y-5">
                <legend class="fieldset-title mb-5"><span class="step">4</span>Emergency contact</legend>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field name="emergency_name" label="Name" :required="true" maxlength="120" />
                    <x-field name="emergency_relationship" label="Relationship" :optional="true" maxlength="60" />
                </div>
                <x-field name="emergency_phone" label="Phone" type="tel" :required="true" inputmode="tel" maxlength="30" class="input sm:max-w-sm" />
            </fieldset>

            <fieldset class="space-y-5" x-data="{ insured: '{{ old('insured', 'no') }}' }">
                <legend class="fieldset-title mb-5"><span class="step">5</span>ID and insurance</legend>
                <x-select name="id_type" label="Type of ID the patient will bring" :options="$idTypes" :required="true" />
                <x-field name="id_card" label="Photo of the ID" type="file" :optional="true" accept=".pdf,.jpg,.jpeg,.png,.webp,.heic,.heif" hint="Take a photo with your phone, or bring it in. Up to 8 MB." />
                <div>
                    <p class="label" id="ins-label">Does the patient have health insurance?</p>
                    <div class="grid gap-2 sm:grid-cols-2" role="radiogroup" aria-labelledby="ins-label">
                        <label class="choice"><input type="radio" name="insured" value="yes" x-model="insured" required @checked(old('insured') === 'yes')>Yes</label>
                        <label class="choice"><input type="radio" name="insured" value="no" x-model="insured" @checked(old('insured', 'no') === 'no')>No, or not sure</label>
                    </div>
                    <x-error for="insured" />
                </div>
                <div class="space-y-5" x-show="insured === 'yes'" x-cloak>
                    <x-field name="insurer" label="Insurance company" maxlength="120" hint="Type the name as it appears on the card." />
                    <x-field name="insurance_card" label="Photo of the insurance card (both sides if you can)" type="file" accept=".pdf,.jpg,.jpeg,.png,.webp,.heic,.heif" hint="Up to 8 MB." />
                </div>
                <p class="flex gap-2.5 rounded-xl bg-soft p-4 text-[0.9375rem]"><x-icon name="lock" class="mt-0.5 h-5 w-5 flex-none text-link" /><span>ID and insurance photos are stored privately, off the public website. Only the registration and medical records team can open them, and every opening is logged.</span></p>
            </fieldset>

            <div class="space-y-4">
                <x-consent purpose="to open and keep a patient file, and to contact me about the patient's care" />
                <label class="flex items-start gap-3 px-1"><input type="checkbox" name="reminders" value="1" class="mt-1 h-5 w-5 flex-none accent-[color:var(--primary)]" @checked(old('reminders'))><span>Send me appointment reminders by phone, WhatsApp or email <span class="text-ink-3">(optional)</span></span></label>
            </div>
            <x-submit label="Send registration" />
        </form>

        <aside class="space-y-6 lg:pt-2">
            <div class="panel p-6">
                <h2 class="font-display text-lg font-medium">On your first visit, bring</h2>
                <ul class="check-list mt-4 text-[0.9375rem]">
                    <li><x-icon name="check-circle" />The patient's ID</li>
                    <li><x-icon name="check-circle" />Their insurance card, if insured</li>
                    <li><x-icon name="check-circle" />A list of medicines they take</li>
                    <li><x-icon name="check-circle" />Any referral letter or recent test results</li>
                </ul>
            </div>
            <div class="panel p-6">
                <h2 class="font-display text-lg font-medium">Why we ask less</h2>
                <p class="mt-2 text-[0.9375rem] text-ink-2">We only ask what we need to open a file. Your medical history is taken in person by our nurses and physicians, never through a web form.</p>
            </div>
            <div class="panel p-6">
                <h2 class="font-display text-lg font-medium">Need an appointment too?</h2>
                <a href="{{ route('appointments') }}" class="btn btn-outline btn-sm mt-3">Request an appointment</a>
            </div>
        </aside>
    </div>
</x-layouts.site>
