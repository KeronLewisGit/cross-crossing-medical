<?php

namespace App\Http\Controllers;

use App\Enums\SubmissionType;
use App\Models\JobPosting;
use App\Support\SubmissionIntake;
use App\Support\UploadStash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * The public request flows: appointment request, new-patient registration, dialysis
 * enquiry, job application and the contact form. Each validates, hands over to
 * SubmissionIntake (reference + emails) and lands on /thanks. None of them is for
 * emergencies, and every form says so.
 */
class FormController extends Controller
{
    /** Phone photos (HEIC is the iPhone default) and scans. */
    private const string DOC_MIMES = 'mimes:pdf,jpg,jpeg,png,webp,heic,heif';

    private const string CV_MIMES = 'mimes:pdf,doc,docx';

    public const int MAX_CERTIFICATES = 3;

    /** Digits and the usual separators, with at least 7 digits ("+++++++" is not a phone number). */
    public const string PHONE_REGEX = '/^(?=(?:\D*\d){7})[0-9+()\-. ]+$/';

    // ---------------------------------------------------------------- appointment

    public function appointment(Request $request): View
    {
        $service = input_string($request->query('service'));

        return view('pages.forms.appointment', [
            'services' => self::serviceOptions(),
            'selected' => array_key_exists($service, self::serviceKeys()) ? $service : null,
        ]);
    }

    public function storeAppointment(Request $request): RedirectResponse
    {
        if (SubmissionIntake::isBot($request, SubmissionType::Appointment)) {
            return to_route('thanks');
        }
        $stash = UploadStash::absorb($request, 'appointment', ['referral' => ['rules' => self::docRules(), 'max' => 1]]);
        $data = $this->check($stash, $this->contactRules() + $this->patientRules() + [
            'service' => ['required', Rule::in(array_keys(self::serviceKeys()))],
            'seen_before' => ['required', Rule::in(['yes', 'no', 'unsure'])],
            'days' => ['required', 'array', 'min:1'],
            'days.*' => [Rule::in(array_keys((array) ccmc('weekdays')))],
            'window' => ['required', Rule::in(array_keys((array) ccmc('time_windows')))],
            'from_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:today', 'before_or_equal:'.today()->addDays((int) ccmc('days_ahead'))->toDateString()],
            'referral' => ['nullable', ...self::docRules()],
            'reason' => ['nullable', 'string', 'max:500'],
            'consent' => ['accepted'],
        ], [
            'service.required' => 'Choose a clinic or test, or "Not sure".',
            'days.required' => 'Tick at least one day that suits you.',
            'from_date.before_or_equal' => 'We take requests up to '.ccmc('days_ahead').' days ahead. Choose an earlier date.',
            'from_date.after_or_equal' => 'Choose today or a later date.',
            'consent.accepted' => 'We need your consent to keep these details so we can call you back.',
        ], ['window' => 'time of day', 'from_date' => 'earliest date', 'seen_before' => 'whether you have been to CCMC before']);

        SubmissionIntake::create(SubmissionType::Appointment, $this->contactFields($data) + [
            'service_key' => $data['service'],
            'consented_at' => now(),
            'message' => $data['reason'] ?? null,
            'details' => $this->patientDetails($data) + [
                'seen_before' => $data['seen_before'],
                'days' => array_values(array_intersect(array_keys((array) ccmc('weekdays')), $data['days'])),
                'window' => $data['window'],
                'from_date' => $data['from_date'] ?? null,
            ],
        ], ['referral' => $stash->entries('referral')], $request);
        $stash->forget();

        return to_route('thanks');
    }

    // ---------------------------------------------------------------- new-patient registration

    public function registration(): View
    {
        return view('pages.forms.registration');
    }

    public function storeRegistration(Request $request): RedirectResponse
    {
        if (SubmissionIntake::isBot($request, SubmissionType::Registration)) {
            return to_route('thanks');
        }
        $stash = UploadStash::absorb($request, 'registration', [
            'id_card' => ['rules' => self::docRules(), 'max' => 1],
            'insurance_card' => ['rules' => self::docRules(), 'max' => 1],
        ]);
        // "name" is the parent or carer filling this in; for self-registration it is the patient.
        $data = $this->check($stash, array_merge($this->contactRules(), ['name' => ['nullable', 'required_if:for_whom,other', 'string', 'max:120']]) + [
            'patient_name' => ['required', 'string', 'max:120'],
            'patient_dob' => ['required', 'date_format:Y-m-d', 'before_or_equal:today', 'after:1900-01-01'],
            'sex' => ['nullable', Rule::in(['female', 'male', 'unsaid'])],
            'for_whom' => ['required', Rule::in(['self', 'other'])],
            'relationship' => ['nullable', 'required_if:for_whom,other', 'string', 'max:60'],
            'address' => ['required', 'string', 'max:200'],
            'town' => ['required', 'string', 'max:80'],
            'id_type' => ['required', Rule::in(array_keys(self::ID_TYPES))],
            'id_card' => ['nullable', ...self::docRules()],
            'insured' => ['required', Rule::in(['yes', 'no'])],
            'insurer' => ['nullable', 'required_if:insured,yes', 'string', 'max:120'],
            'insurance_card' => ['nullable', ...self::docRules()],
            'emergency_name' => ['required', 'string', 'max:120'],
            'emergency_relationship' => ['nullable', 'string', 'max:60'],
            'emergency_phone' => ['required', 'string', 'max:30', 'regex:'.self::PHONE_REGEX],
            'consent' => ['accepted'],
            'reminders' => ['nullable', 'boolean'],
        ], [
            'patient_dob.before_or_equal' => 'The date of birth cannot be in the future.',
            'relationship.required_if' => 'Tell us how you are related to the patient.',
            'insurer.required_if' => 'Tell us the name of the insurance company, or choose "No".',
            'emergency_phone.regex' => 'Enter a phone number with at least 7 digits.',
            'consent.accepted' => 'We need your consent to open a file for the patient.',
            'name.required_if' => 'Tell us your own name, as the person filling this in.',
        ], [
            'patient_name' => "patient's full name", 'patient_dob' => 'date of birth', 'id_type' => 'type of ID',
            'emergency_name' => 'emergency contact name', 'emergency_phone' => 'emergency contact phone', 'town' => 'town or village',
        ]);

        $self = $data['for_whom'] === 'self';
        // The contact is who we call: the patient, or the parent or carer filling this in.
        SubmissionIntake::create(SubmissionType::Registration, [
            'name' => $self ? trim((string) $data['patient_name']) : trim((string) $data['name']),
        ] + $this->contactFields($data) + [
            'consented_at' => now(),
            'details' => [
                'patient_name' => trim((string) $data['patient_name']),
                'patient_dob' => $data['patient_dob'],
                'sex' => $data['sex'] ?? null,
                'for_whom' => $data['for_whom'],
                'relationship' => $self ? null : ($data['relationship'] ?? null),
                'address' => $data['address'],
                'town' => $data['town'],
                'id_type' => $data['id_type'],
                'insured' => $data['insured'] === 'yes',
                'insurer' => $data['insured'] === 'yes' ? ($data['insurer'] ?? null) : null,
                'emergency_name' => $data['emergency_name'],
                'emergency_relationship' => $data['emergency_relationship'] ?? null,
                'emergency_phone' => $data['emergency_phone'],
                'reminders' => (bool) ($data['reminders'] ?? false),
            ],
        ], [
            'id_card' => $stash->entries('id_card'),
            // A card kept from a try where "insured" was ticked is not filed for an uninsured patient.
            'insurance_card' => $data['insured'] === 'yes' ? $stash->entries('insurance_card') : [],
        ], $request);
        $stash->forget();

        return to_route('thanks');
    }

    // ---------------------------------------------------------------- dialysis

    public function storeDialysis(Request $request): RedirectResponse
    {
        if (SubmissionIntake::isBot($request, SubmissionType::Dialysis)) {
            return to_route('thanks');
        }
        $situations = self::dialysisSituations();
        $stash = UploadStash::absorb($request, 'dialysis', ['referral' => ['rules' => self::docRules(), 'max' => 1]]);
        $data = $this->check($stash, $this->contactRules() + $this->patientRules() + [
            'situation' => ['required', Rule::in(array_keys($situations))],
            'current_unit' => ['nullable', 'string', 'max:120'],
            'schedule' => ['required', Rule::in(array_keys((array) ccmc('dialysis.schedules')))],
            'shift' => ['required', Rule::in(array_keys((array) ccmc('dialysis.shifts')))],
            'visit_from' => ['nullable', 'required_if:situation,visiting', 'date_format:Y-m-d', 'after_or_equal:today'],
            'visit_to' => ['nullable', 'required_if:situation,visiting', 'date_format:Y-m-d', 'after_or_equal:visit_from'],
            'referral' => ['nullable', ...self::docRules()],
            'message' => ['nullable', 'string', 'max:1000'],
            'consent' => ['accepted'],
        ], [
            'situation.required' => 'Tell us which best describes the patient.',
            'visit_from.required_if' => 'Tell us when the visit starts.',
            'visit_to.required_if' => 'Tell us when the visit ends.',
            'visit_to.after_or_equal' => 'The last day must be on or after the first day.',
            'consent.accepted' => 'We need your consent to keep these details so the unit can call you.',
        ], ['schedule' => 'preferred days', 'shift' => 'preferred time', 'visit_from' => 'first day', 'visit_to' => 'last day']);

        SubmissionIntake::create(SubmissionType::Dialysis, $this->contactFields($data) + [
            'service_key' => 'dialysis',
            'consented_at' => now(),
            'message' => $data['message'] ?? null,
            'details' => $this->patientDetails($data) + [
                'situation' => $data['situation'],
                'current_unit' => $data['current_unit'] ?? null,
                'schedule' => $data['schedule'],
                'shift' => $data['shift'],
                'visit_from' => $data['situation'] === 'visiting' ? $data['visit_from'] : null,
                'visit_to' => $data['situation'] === 'visiting' ? $data['visit_to'] : null,
            ],
        ], ['referral' => $stash->entries('referral')], $request);
        $stash->forget();

        return to_route('thanks');
    }

    // ---------------------------------------------------------------- careers

    public function apply(Request $request): View
    {
        $jobs = JobPosting::open()->orderBy('title')->get();

        return view('pages.careers.apply', [
            'jobs' => $jobs,
            'selected' => $jobs->firstWhere('slug', input_string($request->query('job'))),
        ]);
    }

    public function storeApplication(Request $request): RedirectResponse
    {
        if (SubmissionIntake::isBot($request, SubmissionType::Career)) {
            return to_route('thanks');
        }
        $openSlugs = JobPosting::open()->pluck('slug')->all();
        $stash = UploadStash::absorb($request, 'career', [
            'cv' => ['rules' => ['file', self::CV_MIMES, 'max:5120'], 'max' => 1],
            'certificates' => ['rules' => self::docRules(4096), 'max' => self::MAX_CERTIFICATES],
        ]);
        $data = $this->check($stash, [
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30', 'regex:'.self::PHONE_REGEX],
            'email' => ['required', 'email:rfc', 'max:255'],
            'contact_pref' => ['nullable', Rule::in(['phone', 'whatsapp', 'email'])],
            'job' => ['nullable', Rule::in($openSlugs)],
            'role' => ['nullable', 'required_without:job', Rule::in(array_keys((array) ccmc('career_roles')))],
            'registration' => ['nullable', 'string', 'max:120'],
            'experience' => ['required', Rule::in(array_keys(self::EXPERIENCE))],
            'availability' => ['required', 'array', 'min:1'],
            'availability.*' => [Rule::in(array_keys((array) ccmc('availability')))],
            'available_from' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:today'],
            'cv' => [Rule::requiredIf(! $stash->has('cv')), 'nullable', 'file', self::CV_MIMES, 'max:5120'],
            // Certificates kept from an earlier try count towards the three.
            'certificates' => ['nullable', 'array', 'max:'.max(0, self::MAX_CERTIFICATES - $stash->count('certificates'))],
            // 4 MB each: CV (5 MB) + 3 certificates stays under Hostinger's 20 MB post limit.
            'certificates.*' => self::docRules(4096),
            'message' => ['nullable', 'string', 'max:2000'],
            'consent' => ['accepted'],
        ], [
            'role.required_without' => 'Choose the kind of role you are applying for.',
            'job.in' => 'That vacancy has closed. Choose another, or send a general application.',
            'cv.required' => 'Attach your CV (PDF or Word).',
            'cv.mimes' => 'Your CV must be a PDF or Word file.',
            'certificates.max' => 'Up to 3 certificates, please.',
            'availability.required' => 'Tick at least one kind of work you are available for.',
            'consent.accepted' => 'We need your consent to keep your application on file.',
        ], ['cv' => 'CV', 'available_from' => 'start date']);

        $job = isset($data['job']) ? JobPosting::where('slug', $data['job'])->first() : null;
        SubmissionIntake::create(SubmissionType::Career, $this->contactFields($data) + [
            'job_posting_id' => $job?->id,
            'service_key' => $job->role_key ?? $data['role'],
            'consented_at' => now(),
            'message' => $data['message'] ?? null,
            'details' => [
                'registration' => $data['registration'] ?? null,
                'experience' => $data['experience'],
                'availability' => array_values($data['availability']),
                'available_from' => $data['available_from'] ?? null,
            ],
        ], [
            'cv' => $stash->entries('cv'),
            'certificate' => $stash->entries('certificates'),
        ], $request);
        $stash->forget();

        return to_route('thanks');
    }

    // ---------------------------------------------------------------- contact

    public function storeEnquiry(Request $request): RedirectResponse
    {
        if (SubmissionIntake::isBot($request)) {
            return to_route('thanks');
        }
        $data = $request->validate($this->contactRules() + [
            'topic' => ['required', Rule::in(array_keys(self::TOPICS))],
            'message' => ['required', 'string', 'max:3000'],
            'consent' => ['accepted'],
        ], ['consent.accepted' => 'Tick the box so we can keep your message and reply to it.']);
        SubmissionIntake::create(SubmissionType::Enquiry, $this->contactFields($data) + [
            'message' => $data['message'],
            'consented_at' => now(),
            'details' => ['topic' => $data['topic']],
        ], [], $request);

        return to_route('thanks');
    }

    public function thanks(Request $request): View|RedirectResponse
    {
        $last = $request->session()->get('last_submission');

        return is_array($last)
            ? view('pages.thanks', ['reference' => $last['reference'], 'type' => SubmissionType::tryFrom($last['type']) ?? SubmissionType::Enquiry])
            : to_route('home');
    }

    // ---------------------------------------------------------------- shared

    public const array ID_TYPES = [
        'national_id' => 'National ID card',
        'driving_permit' => "Driver's permit",
        'passport' => 'Passport',
        'birth_certificate' => 'Birth certificate (children)',
    ];

    public const array EXPERIENCE = [
        'student' => 'Student or newly qualified',
        '1-3' => '1 to 3 years',
        '3-5' => '3 to 5 years',
        '5-10' => '5 to 10 years',
        '10+' => 'More than 10 years',
    ];

    public const array TOPICS = [
        'general' => 'A general question',
        'billing' => 'Billing, payment or insurance',
        'records' => 'Medical records or reports',
        'feedback' => 'Feedback or a complaint',
        'other' => 'Something else',
    ];

    /** @return array<string, string> */
    public static function dialysisSituations(): array
    {
        $all = (array) ccmc('dialysis.situations');

        return ccmc('dialysis_visitors') ? $all : array_diff_key($all, ['visiting' => true]);
    }

    /**
     * Grouped options for the appointment form: specialist clinics, then tests and scans.
     *
     * @return array<string, array<string, string>>
     */
    public static function serviceOptions(): array
    {
        return [
            'Specialist clinics' => (array) ccmc('clinics'),
            'Tests, scans and procedures' => (array) ccmc('tests'),
            'Other' => ['not-sure' => 'Not sure, please advise me'],
        ];
    }

    /** @return array<string, string> */
    public static function serviceKeys(): array
    {
        return array_merge(...array_values(self::serviceOptions()));
    }

    /** @return array<string, list<mixed>> */
    private function contactRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30', 'regex:'.self::PHONE_REGEX],
            // Optional: not every patient has email. Without it the reference is given on the phone.
            'email' => ['nullable', 'required_if:contact_pref,email', 'email:rfc', 'max:255'],
            'contact_pref' => ['nullable', Rule::in(['phone', 'whatsapp', 'email'])],
        ];
    }

    /**
     * "Is this for you or someone else?" Shared by the appointment and dialysis forms.
     *
     * @return array<string, list<mixed>>
     */
    private function patientRules(): array
    {
        return [
            'for_whom' => ['required', Rule::in(['self', 'other'])],
            'patient_name' => ['nullable', 'required_if:for_whom,other', 'string', 'max:120'],
            'relationship' => ['nullable', 'string', 'max:60'],
            'patient_dob' => ['nullable', 'date_format:Y-m-d', 'before_or_equal:today', 'after:1900-01-01'],
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function patientDetails(array $data): array
    {
        $other = ($data['for_whom'] ?? 'self') === 'other';

        return [
            'for_whom' => $other ? 'other' : 'self',
            'patient_name' => $other ? trim((string) $data['patient_name']) : null,
            'relationship' => $other ? ($data['relationship'] ?? null) : null,
            'patient_dob' => $data['patient_dob'] ?? null,
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function contactFields(array $data): array
    {
        $email = trim((string) ($data['email'] ?? ''));

        return [
            'name' => trim((string) ($data['name'] ?? '')),
            'phone' => trim((string) $data['phone']),
            'email' => $email === '' ? null : strtolower($email),
            'contact_pref' => $data['contact_pref'] ?? 'phone',
        ];
    }

    /** @return list<string> */
    private static function docRules(int $maxKb = 8192): array
    {
        return ['file', self::DOC_MIMES, 'max:'.$maxKb];
    }

    /**
     * Validate with the uploads that UploadStash did not keep (the valid ones are already safe).
     *
     * @param  array<string, mixed>  $rules
     * @param  array<string, string>  $messages
     * @param  array<string, string>  $attributes
     * @return array<string, mixed>
     */
    private function check(UploadStash $stash, array $rules, array $messages = [], array $attributes = []): array
    {
        return Validator::make($stash->input(), $rules, $messages, $attributes)->validate();
    }
}
