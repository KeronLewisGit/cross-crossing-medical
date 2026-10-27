@php
    $roles = (array) ccmc('career_roles');
    $role = old('role', array_key_exists((string) request('role'), $roles) ? request('role') : null);
    $oldAvail = (array) old('availability', []);
@endphp
<x-layouts.site title="Apply for a job" description="Send your CV to Cross Crossing Medical Centre, San Fernando.">
    <x-page-header :title="$selected ? 'Apply: '.$selected->title : 'Send your application'" lead="Attach your CV and tell us what kind of work you are looking for. The HR team reviews every application." code="HR" label="Careers" />

    <div class="wrap mt-10 max-w-4xl md:mt-14">
        <form method="POST" action="{{ route('careers.store') }}" enctype="multipart/form-data" class="panel space-y-10 p-6 md:p-9" x-data="requestForm" @submit="submit">
            @csrf
            <x-form-errors />
            <fieldset class="space-y-5">
                <legend class="fieldset-title mb-5"><span class="step">1</span>The role</legend>
                @if ($jobs->isNotEmpty())
                    <x-select name="job" label="Vacancy" :options="$jobs->pluck('title', 'slug')->all()" :value="$selected?->slug" placeholder="No particular vacancy: a general application" :optional="true" />
                @endif
                <x-select name="role" label="Kind of role" :options="$roles" :value="$role" :optional="$jobs->isNotEmpty()" :required="$jobs->isEmpty()" placeholder="Choose…" hint="Needed for a general application." />
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-select name="experience" label="Experience in this kind of role" :options="\App\Http\Controllers\FormController::EXPERIENCE" :required="true" />
                    <x-field name="registration" label="Professional registration number" :optional="true" maxlength="120" hint="e.g. Nursing Council of Trinidad and Tobago" />
                </div>
                <div>
                    <p class="label" id="avail-label">Available for <span class="opt">(tick all that apply)</span></p>
                    <div class="grid gap-2 sm:grid-cols-2" role="group" aria-labelledby="avail-label">
                        @foreach ((array) ccmc('availability') as $k => $label)
                            <label class="choice"><input type="checkbox" name="availability[]" value="{{ $k }}" @checked(in_array($k, $oldAvail, true))>{{ $label }}</label>
                        @endforeach
                    </div>
                    <x-error for="availability" />
                </div>
                <x-field name="available_from" label="Earliest start date" type="date" :optional="true" :min="today()->toDateString()" class="input sm:max-w-xs" />
            </fieldset>

            <fieldset class="space-y-5">
                <legend class="fieldset-title mb-5"><span class="step">2</span>Your CV and certificates</legend>
                <x-field name="cv" label="CV" type="file" :required="true" accept=".pdf,.doc,.docx" hint="PDF or Word, up to 5 MB." />
                <x-field name="certificates[]" label="Certificates or licences" type="file" :optional="true" multiple accept=".pdf,.jpg,.jpeg,.png,.webp,.heic,.heif" hint="Up to 3 files, 8 MB each." />
                <x-error for="certificates" />
                <x-field name="message" label="A short note to HR" type="textarea" :optional="true" rows="4" maxlength="2000" />
            </fieldset>

            <x-contact-fields :step="3" title="Your details" :email-required="true" />
            <x-consent purpose="for recruitment, for up to six months, and to contact me about this or a similar role" />
            <x-submit label="Send my application" />
        </form>
    </div>
</x-layouts.site>
