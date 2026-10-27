<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Enums\SubmissionStatus;
use App\Enums\SubmissionType;
use App\Models\JobPosting;
use App\Models\Submission;
use App\Models\User;
use App\Notifications\NewSubmission;
use App\Notifications\SubmissionReceived;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use RuntimeException;
use Tests\TestCase;

/** Regressions for the issues found in the independent review of 27 October 2026. */
class ReviewRegressionTest extends TestCase
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

    /** @return array<string, mixed> */
    private function appointment(array $over = []): array
    {
        return array_merge([
            'name' => 'Shereen Persad', 'phone' => '868 355 1234', 'email' => 'shereen@example.com', 'contact_pref' => 'phone', 'consent' => '1',
            'service' => 'psychiatry', 'seen_before' => 'no', 'days' => ['mon'], 'window' => 'morning', 'for_whom' => 'self',
        ], $over);
    }

    /** @return array<string, mixed> */
    private function registration(array $over = []): array
    {
        return array_merge([
            'phone' => '868 355 1234', 'consent' => '1', 'for_whom' => 'self', 'patient_name' => 'Shereen Persad', 'patient_dob' => '1984-06-12',
            'address' => '12 Oliver Avenue', 'town' => 'Cross Crossing', 'id_type' => 'national_id', 'insured' => 'yes', 'insurer' => 'Example Insurance',
            'emergency_name' => 'Ravi Persad', 'emergency_phone' => '868-777-1234',
        ], $over);
    }

    public function test_the_appointment_reason_reaches_the_front_desk(): void
    {
        $this->post('/appointments', $this->appointment(['reason' => 'Follow-up after my last visit']))->assertRedirect('/thanks');

        $this->actingAs($this->staff(Role::FrontDesk))->get(route('admin.submissions.show', Submission::sole()))
            ->assertOk()->assertSee('Reason')->assertSee('Follow-up after my last visit');
    }

    public function test_an_insured_registration_shows_the_insurer_to_records(): void
    {
        $this->post('/new-patients', $this->registration())->assertRedirect('/thanks');

        $this->actingAs($this->staff(Role::Records))->get(route('admin.submissions.show', Submission::sole()))
            ->assertOk()->assertSee('Example Insurance')->assertDontSee('None or not sure');
    }

    public function test_a_phone_number_needs_at_least_seven_digits(): void
    {
        $this->post('/appointments', $this->appointment(['phone' => '+++++++']))->assertSessionHasErrors('phone');
        $this->post('/appointments', $this->appointment(['phone' => '(868) 355-1234']))->assertSessionHasNoErrors();
        $this->post('/new-patients', $this->registration(['emergency_phone' => '---- ----']))->assertSessionHasErrors('emergency_phone');
    }

    public function test_email_is_needed_when_email_is_the_way_to_reach_you(): void
    {
        $this->post('/contact', ['name' => 'A', 'phone' => '868 355 1234', 'contact_pref' => 'email', 'topic' => 'general', 'message' => 'Hi', 'consent' => '1'])
            ->assertSessionHasErrors(['email' => 'Add your email address, or choose another way for us to reach you.']);
        $this->assertSame(0, Submission::count());
    }

    public function test_staff_can_clear_a_booked_time(): void
    {
        $s = Submission::factory()->type(SubmissionType::Appointment)->create(['booked_date' => today()->addDay(), 'booked_time' => '09:30', 'status' => SubmissionStatus::Booked]);
        $this->actingAs($this->staff(Role::FrontDesk))
            ->patch(route('admin.submissions.update', $s), ['booked_date' => today()->addDay()->toDateString(), 'booked_time' => ''])->assertRedirect();

        $this->assertNull($s->refresh()->booked_time);
        $this->assertNotNull($s->booked_date);
    }

    public function test_a_message_cannot_be_marked_booked(): void
    {
        $s = Submission::factory()->type(SubmissionType::Enquiry)->create();
        $user = $this->staff(Role::FrontDesk);

        $this->actingAs($user)->get(route('admin.submissions.show', $s))->assertOk()->assertDontSee('value="booked"', false);
        $this->actingAs($user)->patch(route('admin.submissions.update', $s), ['status' => 'booked'])->assertSessionHasErrors('status');
        $this->assertSame(SubmissionStatus::New, $s->refresh()->status);
    }

    public function test_application_attachments_fit_the_hosting_upload_limit(): void
    {
        JobPosting::create(['slug' => 'lab-tech', 'title' => 'Lab tech', 'role_key' => 'lab', 'employment' => 'full-time', 'status' => 'open']);
        $form = ['name' => 'A', 'phone' => '868 355 1234', 'email' => 'a@example.com', 'consent' => '1', 'job' => 'lab-tech', 'experience' => '1-3',
            'availability' => ['full-time'], 'cv' => UploadedFile::fake()->create('cv.pdf', 300, 'application/pdf')];

        $this->post('/careers/apply', $form + ['certificates' => [UploadedFile::fake()->create('big.pdf', 5000, 'application/pdf')]])
            ->assertSessionHasErrors('certificates.0');
        // CV 5 MB + 3 x 4 MB stays under the 20 MB post limit set on Hostinger.
        $this->assertLessThan(20 * 1024, 5120 + 3 * 4096);
    }

    public function test_an_oversized_post_gets_a_branded_explanation(): void
    {
        $this->call('POST', '/careers/apply', [], [], [], ['CONTENT_LENGTH' => (string) (1024 ** 3)])
            ->assertStatus(413)->assertSee('Those files are too large to send')->assertSee('This form is not for emergencies');
    }

    public function test_invalid_utf8_input_is_scrubbed_and_the_session_survives(): void
    {
        $this->post('/contact', ['name' => "Ravi \xFF", 'phone' => '868 355 1234', 'topic' => 'general', 'message' => "Hello \xC3", 'consent' => '1'])
            ->assertRedirect('/thanks');
        $s = Submission::sole();
        $this->assertTrue(mb_check_encoding($s->name.$s->message, 'UTF-8'));
        $this->get('/thanks')->assertOk()->assertSee($s->reference);

        // With a validation error the errors and old input must come back too.
        $this->from('/contact')->post('/contact', ['name' => "Ravi \xFF", 'phone' => '1'])->assertSessionHasErrors('phone');
    }

    public function test_array_input_never_crashes_a_page(): void
    {
        $this->from('/contact')->post('/contact', ['name' => ['x'], 'message' => ['y'], 'phone' => '868 355 1234'])->assertRedirect('/contact');
        $this->get('/contact')->assertOk();
        $this->from('/services/dialysis')->post('/services/dialysis', ['situation' => ['x'], 'for_whom' => ['x']])->assertRedirect('/services/dialysis');
        $this->get('/services/dialysis')->assertOk();

        $this->get('/contact?topic[]=x')->assertOk();
        $this->get('/careers/apply?role[]=x')->assertOk();
        $this->from('/login')->post('/login', ['email' => ['x']]);
        $this->get('/login')->assertOk();
    }

    public function test_old_input_cannot_break_out_of_the_form_state(): void
    {
        $this->from('/services/dialysis')->post('/services/dialysis', ['situation' => "');alert(1)//"]);
        $this->get('/services/dialysis')->assertOk()->assertDontSee("');alert(1)//", false);
    }

    public function test_emails_and_csv_never_name_the_clinic(): void
    {
        $this->post('/appointments', $this->appointment())->assertRedirect('/thanks');
        $s = Submission::sole();
        foreach ([new SubmissionReceived($s), new NewSubmission($s)] as $n) {
            $mail = $n->toMail(new AnonymousNotifiable);
            $this->assertStringNotContainsString('Psychiatry', implode(' ', array_merge([$mail->subject], $mail->introLines, $mail->outroLines)));
        }

        $csv = $this->actingAs($this->staff(Role::FrontDesk))->get('/admin/requests/export')->assertOk()->streamedContent();
        $this->assertStringContainsString($s->reference, $csv);
        $this->assertStringNotContainsString('Psychiatry', $csv);
    }

    public function test_a_job_application_email_still_names_the_vacancy(): void
    {
        $job = JobPosting::create(['slug' => 'dialysis-nurse', 'title' => 'Dialysis Nurse', 'role_key' => 'dialysis', 'employment' => 'full-time', 'status' => 'open']);
        $s = Submission::factory()->type(SubmissionType::Career)->create(['job_posting_id' => $job->id]);

        $this->assertContains('About: Dialysis Nurse', (new NewSubmission($s))->toMail(new AnonymousNotifiable)->introLines);
    }

    public function test_the_demo_seeder_refuses_to_run_in_production(): void
    {
        Storage::disk('local')->put('submissions/1/real-id-card.jpg', 'x');
        $this->app['env'] = 'production';

        try {
            $this->app->make(DemoSeeder::class)->run();
            $this->fail('DemoSeeder ran in production.');
        } catch (RuntimeException $e) {
            $this->assertStringContainsString('never runs in production', $e->getMessage());
        } finally {
            $this->app['env'] = 'testing';
        }
        Storage::disk('local')->assertExists('submissions/1/real-id-card.jpg');
        $this->assertSame(0, User::count());
    }

    public function test_forms_have_an_hourly_cap_per_network(): void
    {
        $hit = null;
        for ($i = 0; $i < 121; $i++) {
            $this->travel(20)->seconds(); // three a minute: under the per-minute caps, inside one hour
            $hit = $this->post('/contact', ['name' => 'A', 'phone' => '868 355 '.str_pad((string) $i, 4, '0', STR_PAD_LEFT), 'topic' => 'general', 'message' => 'Hi', 'consent' => '1']);
            if ($hit->getStatusCode() === 429) {
                break;
            }
        }
        $this->assertSame(429, $hit?->getStatusCode());
        $this->assertSame(120, Submission::count());
    }

    /** @return array<string, array{string}> */
    public static function innerPages(): array
    {
        return array_map(fn (string $p) => [$p], [
            'handouts' => '/patient-handouts', 'health-checks' => '/health-checks', 'apply' => '/careers/apply', 'privacy' => '/privacy',
            'sitemap' => '/sitemap', 'credits' => '/photo-credits', 'job' => '/careers/dialysis-nurse', 'error' => '/no-such-page',
        ]);
    }

    #[DataProvider('innerPages')]
    public function test_every_inner_page_header_has_a_photo(string $path): void
    {
        JobPosting::create(['slug' => 'dialysis-nurse', 'title' => 'Dialysis Nurse', 'role_key' => 'dialysis', 'employment' => 'full-time', 'status' => 'open']);
        $html = $this->get($path)->getContent();

        $this->assertMatchesRegularExpression('#<section class="stucco on-sign[^"]*">(?:(?!</section>).)*class="frame"(?:(?!</section>).)*<img #s', (string) $html);
    }

    public function test_the_package_blocks_the_app_folder_and_names_the_right_site(): void
    {
        $this->assertStringContainsString('RewriteRule ^ccmc-app(/|$) - [F,L]', (string) file_get_contents(base_path('deploy/.htaccess')));
        foreach (['deploy/robots.txt', 'public/robots.txt'] as $f) {
            $this->assertStringContainsString('Sitemap: https://www.ccmctt.com/sitemap.xml', (string) file_get_contents(base_path($f)));
        }
        $this->assertStringContainsString("--exclude 'database/seeders/DemoSeeder.php'", (string) file_get_contents(base_path('scripts/package-hostinger.sh')));
    }

    // ------------------------------------------------------------ coordinator follow-ups

    public function test_valid_uploads_survive_a_validation_error_and_are_filed_on_success(): void
    {
        $form = $this->registration([
            'phone' => 'no digits', 'id_card' => UploadedFile::fake()->image('my-id.jpg'), 'insurance_card' => UploadedFile::fake()->image('my-card.jpg'),
        ]);
        $this->from('/new-patients')->post('/new-patients', $form)->assertRedirect('/new-patients')->assertSessionHasErrors('phone');
        $this->assertSame(0, Submission::count());
        $this->assertCount(2, Storage::disk('local')->allFiles('stash'));
        $this->get('/new-patients')->assertOk()->assertSee('Attached: <strong>my-id.jpg</strong>', false)->assertSee('my-card.jpg');

        // Second try: phone fixed, nothing re-attached.
        $this->post('/new-patients', $this->registration())->assertRedirect('/thanks');
        $s = Submission::sole();
        $this->assertEqualsCanonicalizing(['id_card', 'insurance_card'], $s->files->pluck('kind')->all());
        foreach ($s->files as $f) {
            $this->assertStringStartsWith('submissions/'.$s->id.'/', $f->path);
            Storage::disk('local')->assertExists($f->path);
        }
        $this->assertSame([], Storage::disk('local')->allFiles('stash'));
        $this->get('/new-patients')->assertDontSee('Attached:');

        // The records-only rule and the access log still apply to files that were stashed.
        $card = $s->files->firstWhere('kind', 'id_card');
        $this->actingAs($this->staff(Role::Admin))->get(route('admin.submissions.file', [$s, $card]))->assertForbidden();
        $this->actingAs($this->staff(Role::Records))->get(route('admin.submissions.file', [$s, $card]))->assertOk();
        $this->assertSame(1, $card->accesses()->count());
    }

    public function test_a_cv_kept_from_a_failed_try_counts_and_can_be_removed(): void
    {
        $form = ['name' => 'A', 'phone' => '868 355 1234', 'email' => 'a@example.com', 'consent' => '1', 'role' => 'lab', 'availability' => ['full-time']];
        $this->post('/careers/apply', $form + ['cv' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
            'certificates' => [UploadedFile::fake()->image('a.jpg'), UploadedFile::fake()->image('b.jpg')]])->assertSessionHasErrors('experience');
        $this->get('/careers/apply')->assertSee('Attached: <strong>cv.pdf</strong>', false)->assertSee('b.jpg');

        // Two certificates kept, so only one more fits.
        $this->post('/careers/apply', $form + ['certificates' => [UploadedFile::fake()->image('c.jpg'), UploadedFile::fake()->image('d.jpg')]])
            ->assertSessionHasErrors('certificates')->assertSessionDoesntHaveErrors('cv');

        // Removing the kept CV makes it required again.
        $this->post('/careers/apply', $form + ['experience' => '1-3', 'remove_attached' => ['cv' => ['0']]])->assertSessionHasErrors('cv');

        $this->post('/careers/apply', $form + ['experience' => '1-3', 'cv' => UploadedFile::fake()->create('cv2.pdf', 100, 'application/pdf')])->assertRedirect('/thanks');
        $s = Submission::sole();
        $this->assertSame(['cv2.pdf'], $s->files->where('kind', 'cv')->pluck('original_name')->values()->all());
        $this->assertCount(3, $s->files->where('kind', 'certificate'));
    }

    public function test_invalid_uploads_are_never_kept(): void
    {
        $this->post('/appointments', $this->appointment(['phone' => 'x', 'referral' => UploadedFile::fake()->create('run.exe', 10, 'application/x-msdownload')]))
            ->assertSessionHasErrors(['phone', 'referral']);
        $this->assertSame([], Storage::disk('local')->allFiles('stash'));
    }

    public function test_a_stash_belongs_to_one_visitor_and_expires_after_a_day(): void
    {
        $this->post('/appointments', $this->appointment(['phone' => 'x', 'referral' => UploadedFile::fake()->image('letter.jpg')]));
        $this->get('/appointments')->assertSee('letter.jpg');
        [$file] = Storage::disk('local')->allFiles('stash');

        // Another visitor (a fresh session) sees nothing and cannot claim it.
        $this->flushSession();
        $this->get('/appointments')->assertDontSee('letter.jpg');
        $this->post('/appointments', $this->appointment())->assertRedirect('/thanks');
        $this->assertCount(0, Submission::sole()->files);

        touch(Storage::disk('local')->path($file), now()->subHours(25)->getTimestamp());
        $this->post('/appointments', $this->appointment(['phone' => 'x']));
        Storage::disk('local')->assertMissing($file);
    }

    public function test_two_simultaneous_status_changes_write_one_note(): void
    {
        $s = Submission::factory()->type(SubmissionType::Appointment)->create();
        $first = Submission::find($s->id);
        $second = Submission::find($s->id);

        $this->assertTrue($first->claimStatus(SubmissionStatus::Contacted));
        $this->assertFalse($second->claimStatus(SubmissionStatus::Contacted));
        $this->assertFalse($second->claimStatus(SubmissionStatus::Closed), 'A stale copy must not overwrite the newer status.');
        $this->assertSame(SubmissionStatus::Contacted, $s->refresh()->status);
        $this->assertNotNull($s->first_contacted_at);

        // Through the desk: the same save sent twice adds one status note.
        $user = $this->staff(Role::FrontDesk);
        $this->actingAs($user)->patch(route('admin.submissions.update', $s), ['status' => 'completed']);
        $this->actingAs($user)->patch(route('admin.submissions.update', $s), ['status' => 'completed']);
        $this->assertSame(1, $s->notes()->where('kind', 'status')->count());
    }

    public function test_a_note_only_stops_the_clock_when_staff_say_they_spoke_to_the_patient(): void
    {
        $s = Submission::factory()->type(SubmissionType::Appointment)->create(['created_at' => now()->subHours(3)]);
        $user = $this->staff(Role::FrontDesk);

        $this->actingAs($user)->get(route('admin.submissions.show', $s))->assertOk()
            ->assertDontSee('name="contacted" value="1" class="h-5 w-5 accent-[color:var(--primary)]" checked', false);
        $this->actingAs($user)->post(route('admin.submissions.note', $s), ['body' => 'No answer, left a voicemail.'])->assertRedirect();
        $s->refresh();
        $this->assertSame(SubmissionStatus::New, $s->status);
        $this->assertNull($s->first_contacted_at);
        $this->assertTrue($s->isOverdue());
    }

    public function test_the_demo_seeder_runs_on_a_production_preview(): void
    {
        config(['ccmc.preview' => true]);
        $this->app['env'] = 'production';
        try {
            $this->app->make(DemoSeeder::class)->run();
        } finally {
            $this->app['env'] = 'testing';
        }
        $this->assertTrue(User::where('email', 'admin@ccmc.test')->exists());
        $this->assertGreaterThan(0, Submission::where('is_demo', true)->count());
    }
}
