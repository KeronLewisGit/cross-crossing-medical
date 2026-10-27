<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Enums\SubmissionStatus;
use App\Enums\SubmissionType;
use App\Models\Handout;
use App\Models\JobPosting;
use App\Models\Setting;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private function user(Role $role, bool $active = true): User
    {
        return User::factory()->create(['role' => $role, 'active' => $active]);
    }

    private function make(SubmissionType $type, array $attrs = []): Submission
    {
        return Submission::factory()->type($type)->create($attrs);
    }

    public function test_guests_are_sent_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
        $this->get('/admin/requests')->assertRedirect('/login');
    }

    public function test_staff_can_sign_in_and_inactive_staff_cannot_stay_in(): void
    {
        $u = $this->user(Role::FrontDesk);
        $this->post('/login', ['email' => $u->email, 'password' => 'password'])->assertRedirect(route('admin.dashboard'));
        $this->get('/admin')->assertOk()->assertSee('Patient requests not called back in time');

        $u->update(['active' => false]);
        $this->app['auth']->forgetGuards(); // a fresh request reloads the user from the database
        $this->get('/admin')->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_login_is_throttled(): void
    {
        $u = $this->user(Role::Admin);
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => $u->email, 'password' => 'wrong']);
        }
        $this->post('/login', ['email' => $u->email, 'password' => 'password'])->assertStatus(429);
        $this->assertGuest();
    }

    /** @return array<string, array{Role, list<string>, list<string>}> */
    public static function roleRoutes(): array
    {
        return [
            'admin' => [Role::Admin, ['/admin', '/admin/requests', '/admin/appointments', '/admin/document-log', '/admin/jobs', '/admin/handouts', '/admin/settings', '/admin/users'], []],
            'front desk' => [Role::FrontDesk, ['/admin', '/admin/requests', '/admin/appointments'], ['/admin/document-log', '/admin/jobs', '/admin/handouts', '/admin/settings', '/admin/users']],
            'records' => [Role::Records, ['/admin', '/admin/requests', '/admin/document-log'], ['/admin/appointments', '/admin/jobs', '/admin/handouts', '/admin/settings', '/admin/users']],
            'hr' => [Role::Hr, ['/admin', '/admin/requests', '/admin/jobs'], ['/admin/appointments', '/admin/document-log', '/admin/handouts', '/admin/settings', '/admin/users']],
        ];
    }

    /**
     * @param  list<string>  $allowed
     * @param  list<string>  $denied
     */
    #[DataProvider('roleRoutes')]
    public function test_each_role_reaches_only_its_pages(Role $role, array $allowed, array $denied): void
    {
        $this->make(SubmissionType::Appointment, ['booked_date' => today(), 'booked_time' => '09:00', 'status' => SubmissionStatus::Booked]);
        $this->make(SubmissionType::Career);
        $this->actingAs($this->user($role));
        foreach ($allowed as $path) {
            $this->get($path)->assertOk();
        }
        foreach ($denied as $path) {
            $this->get($path)->assertForbidden();
        }
    }

    public function test_each_role_only_sees_its_own_request_types(): void
    {
        $appt = $this->make(SubmissionType::Appointment, ['name' => 'Appointment Person']);
        $reg = $this->make(SubmissionType::Registration, ['name' => 'Registration Person']);
        $cv = $this->make(SubmissionType::Career, ['name' => 'Career Person']);
        $dia = $this->make(SubmissionType::Dialysis, ['name' => 'Dialysis Person']);

        $this->actingAs($this->user(Role::FrontDesk))->get('/admin/requests')
            ->assertSee('Appointment Person')->assertSee('Dialysis Person')->assertDontSee('Registration Person')->assertDontSee('Career Person');
        $this->get(route('admin.submissions.show', $reg))->assertForbidden();
        $this->get(route('admin.submissions.show', $cv))->assertForbidden();

        $this->actingAs($this->user(Role::Records))->get('/admin/requests')->assertSee('Test Patient')->assertDontSee('Appointment Person');
        $this->get(route('admin.submissions.show', $appt))->assertForbidden();

        $this->actingAs($this->user(Role::Hr))->get('/admin/requests')->assertSee('Career Person')->assertDontSee('Dialysis Person');
        $this->get(route('admin.submissions.show', $dia))->assertForbidden();
        $this->patch(route('admin.submissions.update', $dia), ['status' => 'closed'])->assertForbidden();

        $this->actingAs($this->user(Role::Admin))->get('/admin/requests')->assertSee('Appointment Person')->assertSee('Career Person')->assertSee('Test Patient');
    }

    public function test_registration_details_show_to_records_and_admin_only(): void
    {
        $reg = $this->make(SubmissionType::Registration, ['details' => ['patient_name' => 'Pat Example', 'patient_dob' => '1970-02-03', 'for_whom' => 'self', 'address' => '99 Secret Street', 'town' => 'Debe', 'id_type' => 'passport', 'insured' => 'no']]);
        $this->actingAs($this->user(Role::Records))->get(route('admin.submissions.show', $reg))->assertOk()->assertSee('99 Secret Street');
        $this->actingAs($this->user(Role::Admin))->get(route('admin.submissions.show', $reg))->assertOk()->assertSee('99 Secret Street');
        $this->actingAs($this->user(Role::FrontDesk))->get(route('admin.submissions.show', $reg))->assertForbidden();
        $this->actingAs($this->user(Role::Hr))->get(route('admin.submissions.show', $reg))->assertForbidden();
    }

    public function test_dashboard_headline_counts_overdue_for_the_role(): void
    {
        $this->make(SubmissionType::Appointment)->forceFill(['created_at' => now()->subHours(3)])->save();
        $this->make(SubmissionType::Appointment)->forceFill(['created_at' => now()->subMinutes(30)])->save();
        $this->make(SubmissionType::Registration)->forceFill(['created_at' => now()->subHours(30)])->save();
        $this->make(SubmissionType::Career)->forceFill(['created_at' => now()->subHours(10)])->save();

        $count = fn (Role $r) => $this->actingAs($this->user($r))->get('/admin')->assertOk()->viewData('headlineCount');
        $this->assertSame(1, $count(Role::FrontDesk));
        $this->assertSame(1, $count(Role::Records));
        $this->assertSame(0, $count(Role::Hr));
        $this->actingAs($this->user(Role::Hr))->get('/admin')->assertSee('Applications not reviewed within 3 days');
    }

    public function test_status_assignment_and_booking(): void
    {
        $desk = $this->user(Role::FrontDesk);
        $hr = $this->user(Role::Hr);
        $s = $this->make(SubmissionType::Appointment);
        $this->actingAs($desk);

        $this->patch(route('admin.submissions.update', $s), ['booked_date' => today()->addDays(2)->toDateString(), 'booked_time' => '10:30', 'assigned_to' => $desk->id])->assertRedirect();
        $s->refresh();
        $this->assertSame(SubmissionStatus::Booked, $s->status);
        $this->assertSame($desk->id, $s->assigned_to);
        $this->assertSame('10:30', $s->booked_time);
        $this->get('/admin/appointments')->assertSee($s->patientName());

        $this->patch(route('admin.submissions.update', $s), ['assigned_to' => $hr->id])->assertSessionHasErrors('assigned_to');
        $this->assertSame($desk->id, $s->refresh()->assigned_to);

        $this->patch(route('admin.submissions.update', $s), ['status' => 'completed']);
        $this->assertSame(SubmissionStatus::Completed, $s->refresh()->status);
        $this->assertTrue($s->notes()->where('kind', 'status')->exists());
    }

    public function test_logging_a_call_counts_as_first_contact(): void
    {
        $s = $this->make(SubmissionType::Dialysis);
        $this->actingAs($this->user(Role::FrontDesk))->post(route('admin.submissions.note', $s), ['body' => 'Spoke to the family.', 'contacted' => '1'])->assertRedirect();
        $s->refresh();
        $this->assertSame(SubmissionStatus::Contacted, $s->status);
        $this->assertNotNull($s->first_contacted_at);
        $this->assertFalse($s->isOverdue());
    }

    public function test_export_has_contact_columns_only_and_is_formula_safe(): void
    {
        $this->make(SubmissionType::Appointment, ['name' => '=HYPERLINK("x")', 'details' => ['reason' => 'Private reason', 'patient_dob' => '1961-01-01', 'for_whom' => 'self']]);
        $this->make(SubmissionType::Career, ['name' => 'Hidden Applicant']);
        $csv = $this->actingAs($this->user(Role::FrontDesk))->get('/admin/requests/export')->assertOk()->streamedContent();
        $this->assertStringContainsString("'=HYPERLINK", $csv);
        $this->assertStringNotContainsString('Private reason', $csv);
        $this->assertStringNotContainsString('1961-01-01', $csv);
        $this->assertStringNotContainsString('Hidden Applicant', $csv);
    }

    public function test_inbox_filters_and_search(): void
    {
        $this->make(SubmissionType::Appointment, ['name' => 'Kevin Joseph', 'phone' => '868-620-1111']);
        $this->make(SubmissionType::Enquiry, ['name' => 'Nadia Ali']);
        $this->actingAs($this->user(Role::Admin));
        $this->get('/admin/requests?q=6201111')->assertSee('Kevin Joseph')->assertDontSee('Nadia Ali');
        $this->get('/admin/requests?type=enquiry')->assertSee('Nadia Ali')->assertDontSee('Kevin Joseph');
    }

    public function test_hr_manages_vacancies(): void
    {
        $this->actingAs($this->user(Role::Hr));
        $this->post('/admin/jobs', ['title' => 'Radiographer', 'role_key' => 'radiography', 'department' => 'Imaging', 'employment' => 'full-time', 'status' => 'open', 'duties' => "Take X-rays\nKeep records"])->assertRedirect();
        $job = JobPosting::sole();
        $this->assertSame('radiographer', $job->slug);
        $this->get('/careers')->assertSee('Radiographer');

        $this->make(SubmissionType::Career, ['job_posting_id' => $job->id]);
        $this->delete(route('admin.jobs.destroy', $job))->assertRedirect();
        $this->assertSame('closed', $job->refresh()->status->value);
    }

    public function test_admin_manages_handouts_settings_and_staff(): void
    {
        Storage::fake('uploads');
        $admin = $this->user(Role::Admin);
        $this->actingAs($admin);

        $this->post('/admin/handouts', ['title' => 'Living with gout', 'category' => 'bones', 'published' => '1', 'file' => UploadedFile::fake()->create('gout.pdf', 100, 'application/pdf')])->assertRedirect();
        $h = Handout::sole();
        Storage::disk('uploads')->assertExists((string) $h->file_path);
        $this->get('/patient-handouts')->assertSee('Living with gout');
        $this->post('/admin/handouts', ['title' => 'Bad', 'category' => 'bones', 'file' => UploadedFile::fake()->create('x.exe', 10)])->assertSessionHasErrors('file');

        $this->put('/admin/settings', ['public_notice' => 'Closed for Divali? No, open as usual.'])->assertRedirect();
        $this->assertSame('Closed for Divali? No, open as usual.', Setting::get('public_notice'));

        $this->post('/admin/users', ['name' => 'New Records', 'email' => 'NEW@ccmc.test', 'role' => 'records', 'password' => 'a-long-password'])->assertRedirect();
        $new = User::where('email', 'new@ccmc.test')->sole();
        $this->assertSame(Role::Records, $new->role);
        $this->patch(route('admin.users.update', $admin), ['role' => 'front_desk', 'active' => '1'])->assertSessionHasErrors('role');
    }
}
