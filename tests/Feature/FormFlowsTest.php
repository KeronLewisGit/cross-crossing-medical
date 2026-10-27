<?php

namespace Tests\Feature;

use App\Enums\SubmissionStatus;
use App\Enums\SubmissionType;
use App\Models\JobPosting;
use App\Models\Submission;
use App\Notifications\NewSubmission;
use App\Notifications\SubmissionReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FormFlowsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['ccmc.notify' => 'frontdesk@example.com', 'ccmc.notify_hr' => 'hr@example.com']);
        Notification::fake();
        Storage::fake('local');
        $this->withoutDefer();
    }

    /** @return array<string, string> */
    private function contact(array $over = []): array
    {
        return array_merge(['name' => 'Shereen Persad', 'phone' => '868 355 1234', 'email' => 'shereen@example.com', 'contact_pref' => 'phone', 'consent' => '1'], $over);
    }

    private function assertEmailed(Submission $s, string $office = 'frontdesk@example.com'): void
    {
        Notification::assertSentTo(new AnonymousNotifiable, NewSubmission::class, fn ($n, $c, $to) => $to->routes['mail'] === [$office] && $n->submission->is($s));
        Notification::assertSentTo(new AnonymousNotifiable, SubmissionReceived::class, fn ($n, $c, $to) => $to->routes['mail'] === 'shereen@example.com' && $n->submission->is($s));
    }

    // ------------------------------------------------------------ appointment

    public function test_appointment_request_gets_reference_email_and_thanks_page(): void
    {
        $this->post('/appointments', $this->contact([
            'service' => 'cardiology', 'seen_before' => 'no', 'days' => ['mon', 'wed'], 'window' => 'morning',
            'for_whom' => 'self', 'reason' => 'Chest tightness when walking',
        ]))->assertRedirect('/thanks');

        $s = Submission::sole();
        $this->assertMatchesRegularExpression('/^AP-\d{2}-\d{5}$/', $s->reference);
        $this->assertSame(SubmissionType::Appointment, $s->type);
        $this->assertSame(SubmissionStatus::New, $s->status);
        $this->assertSame(['mon', 'wed'], $s->detail('days'));
        $this->assertSame('8683551234', $s->phone_digits);
        $this->assertNotNull($s->consented_at);
        $this->assertEmailed($s);
        $this->get('/thanks')->assertOk()->assertSee($s->reference)->assertSee('Register as a new patient');
    }

    public function test_confirmation_email_never_contains_the_reason(): void
    {
        $this->post('/appointments', $this->contact(['service' => 'urology', 'seen_before' => 'yes', 'days' => ['fri'], 'window' => 'any', 'for_whom' => 'self', 'reason' => 'Blood in urine']));
        $s = Submission::sole();
        foreach ([new SubmissionReceived($s), new NewSubmission($s)] as $n) {
            $mail = $n->toMail(new AnonymousNotifiable);
            $text = implode(' ', array_merge([$mail->subject], $mail->introLines, $mail->outroLines));
            $this->assertStringNotContainsString('Blood in urine', $text);
        }
    }

    public function test_appointment_for_someone_else_records_the_patient(): void
    {
        $this->post('/appointments', $this->contact([
            'service' => 'paediatrics', 'seen_before' => 'unsure', 'days' => ['sat'], 'window' => 'afternoon',
            'for_whom' => 'other', 'patient_name' => 'Aaliyah Persad', 'relationship' => 'daughter', 'patient_dob' => '2019-04-02',
        ]))->assertRedirect('/thanks');
        $s = Submission::sole();
        $this->assertSame('Aaliyah Persad', $s->patientName());
        $this->assertSame('Shereen Persad', $s->name);
    }

    public function test_appointment_validation(): void
    {
        $this->from('/appointments')->post('/appointments', $this->contact(['service' => 'brain-surgery', 'consent' => null, 'for_whom' => 'other']))
            ->assertRedirect('/appointments')
            ->assertSessionHasErrors(['service', 'days', 'window', 'seen_before', 'consent', 'patient_name']);
        $this->assertSame(0, Submission::count());
    }

    public function test_email_is_optional_on_patient_forms(): void
    {
        $this->post('/appointments', $this->contact(['email' => '', 'service' => 'lab', 'seen_before' => 'yes', 'days' => ['tue'], 'window' => 'morning', 'for_whom' => 'self']))->assertRedirect('/thanks');
        $this->assertNull(Submission::sole()->email);
        Notification::assertNotSentTo(new AnonymousNotifiable, SubmissionReceived::class);
    }

    public function test_referral_letter_is_stored_privately(): void
    {
        $this->post('/appointments', $this->contact(['service' => 'orthopaedic-surgery', 'seen_before' => 'no', 'days' => ['thu'], 'window' => 'any', 'for_whom' => 'self',
            'referral' => UploadedFile::fake()->create('referral.pdf', 200, 'application/pdf')]))->assertRedirect('/thanks');
        $file = Submission::sole()->files()->sole();
        $this->assertSame('referral', $file->kind);
        Storage::disk('local')->assertExists($file->path);
        $this->assertStringStartsWith('submissions/', $file->path);
        $this->assertFalse($file->isRestricted());
    }

    public function test_honeypot_shows_thanks_but_saves_nothing(): void
    {
        $this->post('/appointments', $this->contact(['website' => 'http://spam.example', 'service' => 'lab']))->assertRedirect('/thanks');
        $this->assertSame(0, Submission::count());
        Notification::assertNothingSent();
    }

    // ------------------------------------------------------------ registration

    /** @return array<string, mixed> */
    private function registration(array $over = []): array
    {
        return array_merge($this->contact(['name' => '']), [
            'for_whom' => 'self', 'patient_name' => 'Shereen Persad', 'patient_dob' => '1984-06-12', 'sex' => 'female',
            'address' => '12 Oliver Avenue', 'town' => 'Cross Crossing', 'id_type' => 'national_id', 'insured' => 'yes', 'insurer' => 'Example Insurance',
            'emergency_name' => 'Ravi Persad', 'emergency_phone' => '868-777-1234',
            'id_card' => UploadedFile::fake()->image('id.jpg'), 'insurance_card' => UploadedFile::fake()->image('card.jpg'),
        ], $over);
    }

    public function test_registration_stores_id_and_insurance_cards_on_private_disk_as_restricted(): void
    {
        $this->post('/new-patients', $this->registration())->assertRedirect('/thanks');
        $s = Submission::sole();
        $this->assertMatchesRegularExpression('/^PR-\d{2}-\d{5}$/', $s->reference);
        $this->assertSame('Shereen Persad', $s->name);
        $this->assertSame('1984-06-12', $s->detail('patient_dob'));
        $this->assertEqualsCanonicalizing(['id_card', 'insurance_card'], $s->files->pluck('kind')->all());
        foreach ($s->files as $f) {
            $this->assertTrue($f->isRestricted());
            Storage::disk('local')->assertExists($f->path);
            $this->assertFileDoesNotExist(public_path($f->path));
        }
        $this->assertEmailed($s);
    }

    public function test_registration_requires_consent_and_the_carers_name(): void
    {
        $this->post('/new-patients', $this->registration(['consent' => null, 'for_whom' => 'other', 'name' => '', 'insurer' => '']))
            ->assertSessionHasErrors(['consent', 'name', 'relationship', 'insurer']);
        $this->assertSame(0, Submission::count());
    }

    public function test_registration_rejects_executable_uploads(): void
    {
        $this->post('/new-patients', $this->registration(['id_card' => UploadedFile::fake()->create('id.php', 10, 'application/x-php')]))->assertSessionHasErrors('id_card');
    }

    // ------------------------------------------------------------ dialysis

    public function test_dialysis_enquiry(): void
    {
        $this->post('/services/dialysis', $this->contact(['for_whom' => 'self', 'situation' => 'transfer', 'schedule' => 'mwf', 'shift' => 'morning']))->assertRedirect('/thanks');
        $s = Submission::sole();
        $this->assertMatchesRegularExpression('/^DI-/', $s->reference);
        $this->assertSame('dialysis', $s->service_key);
        $this->assertEmailed($s);
    }

    public function test_visiting_dialysis_is_refused_until_the_centre_confirms_it(): void
    {
        config(['ccmc.dialysis_visitors' => false]);
        $this->post('/services/dialysis', $this->contact(['for_whom' => 'self', 'situation' => 'visiting', 'schedule' => 'mwf', 'shift' => 'morning']))->assertSessionHasErrors('situation');

        config(['ccmc.dialysis_visitors' => true]);
        $this->post('/services/dialysis', $this->contact(['for_whom' => 'self', 'situation' => 'visiting', 'schedule' => 'mwf', 'shift' => 'morning']))->assertSessionHasErrors(['visit_from', 'visit_to']);
        $this->post('/services/dialysis', $this->contact(['for_whom' => 'self', 'situation' => 'visiting', 'schedule' => 'tts', 'shift' => 'any',
            'visit_from' => today()->addDays(10)->toDateString(), 'visit_to' => today()->addDays(20)->toDateString()]))->assertRedirect('/thanks');
        $this->assertSame(1, Submission::count());
    }

    // ------------------------------------------------------------ careers

    public function test_job_application_with_cv_goes_to_hr(): void
    {
        $job = JobPosting::create(['slug' => 'dialysis-nurse', 'title' => 'Dialysis Nurse', 'role_key' => 'dialysis', 'employment' => 'full-time', 'status' => 'open']);
        $this->post('/careers/apply', $this->contact(['job' => 'dialysis-nurse', 'experience' => '3-5', 'availability' => ['full-time', 'shifts'],
            'cv' => UploadedFile::fake()->create('cv.pdf', 300, 'application/pdf'),
            'certificates' => [UploadedFile::fake()->image('licence.jpg')]]))->assertRedirect('/thanks');

        $s = Submission::sole();
        $this->assertMatchesRegularExpression('/^CV-/', $s->reference);
        $this->assertTrue($s->jobPosting->is($job));
        $this->assertSame('dialysis', $s->service_key);
        $this->assertEqualsCanonicalizing(['cv', 'certificate'], $s->files->pluck('kind')->all());
        $this->assertEmailed($s, 'hr@example.com');
        $this->get('/thanks')->assertDontSee('This form is not for emergencies');
    }

    public function test_application_requires_a_cv_and_email(): void
    {
        $this->post('/careers/apply', $this->contact(['email' => '', 'role' => 'registered-nurse', 'experience' => '1-3', 'availability' => ['part-time']]))
            ->assertSessionHasErrors(['cv', 'email']);
        $this->post('/careers/apply', $this->contact(['role' => 'registered-nurse', 'experience' => '1-3', 'availability' => ['part-time'],
            'cv' => UploadedFile::fake()->image('cv.png')]))->assertSessionHasErrors('cv');
    }

    public function test_closed_vacancy_cannot_be_applied_for(): void
    {
        JobPosting::create(['slug' => 'old', 'title' => 'Old', 'role_key' => 'lab', 'employment' => 'full-time', 'status' => 'closed']);
        $this->post('/careers/apply', $this->contact(['job' => 'old', 'experience' => '1-3', 'availability' => ['part-time'], 'cv' => UploadedFile::fake()->create('cv.pdf', 10, 'application/pdf')]))
            ->assertSessionHasErrors('job');
    }

    // ------------------------------------------------------------ enquiry

    public function test_contact_message(): void
    {
        $this->post('/contact', $this->contact(['topic' => 'records', 'message' => 'Can I get a copy of my report?']))->assertRedirect('/thanks');
        $s = Submission::sole();
        $this->assertMatchesRegularExpression('/^EN-/', $s->reference);
        $this->assertSame('records', $s->detail('topic'));
        $this->post('/contact', $this->contact(['topic' => 'general', 'message' => 'Hi', 'consent' => null]))->assertSessionHasErrors('consent');
    }

    public function test_forms_are_rate_limited(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $last = $this->post('/contact', $this->contact(['topic' => 'general', 'message' => 'Hello '.$i]));
        }
        $last->assertStatus(429);
    }
}
