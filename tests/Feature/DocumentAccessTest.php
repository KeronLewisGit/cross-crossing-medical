<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Enums\SubmissionType;
use App\Models\FileAccess;
use App\Models\Submission;
use App\Models\SubmissionFile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * ID and insurance cards open for the records role only (not even admin), and every
 * opening of any document is written to file_accesses and the request's timeline.
 */
class DocumentAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    private function user(Role $role): User
    {
        return User::factory()->create(['role' => $role]);
    }

    private function withFile(SubmissionType $type, string $kind, string $name = 'card.jpg'): SubmissionFile
    {
        $s = Submission::factory()->type($type)->create();
        $path = "submissions/{$s->id}/abc.".pathinfo($name, PATHINFO_EXTENSION);
        Storage::disk('local')->put($path, 'demo-bytes');

        return $s->files()->create(['kind' => $kind, 'path' => $path, 'original_name' => $name, 'mime' => str_ends_with($name, '.pdf') ? 'application/pdf' : 'image/jpeg', 'size' => 10]);
    }

    private function open(SubmissionFile $f): TestResponse
    {
        return $this->get(route('admin.submissions.file', [$f->submission_id, $f->id]));
    }

    /** @return array<string, array{string}> */
    public static function restrictedKinds(): array
    {
        return ['id card' => ['id_card'], 'insurance card' => ['insurance_card']];
    }

    #[DataProvider('restrictedKinds')]
    public function test_records_can_open_restricted_documents_and_it_is_logged(string $kind): void
    {
        $f = $this->withFile(SubmissionType::Registration, $kind);
        $records = $this->user(Role::Records);

        $this->actingAs($records)->open($f)->assertOk()->assertHeader('Cache-Control', 'no-store, private');

        $log = FileAccess::sole();
        $this->assertSame($f->id, $log->submission_file_id);
        $this->assertSame($records->id, $log->user_id);
        $this->assertSame('127.0.0.1', $log->ip);
        $this->assertTrue($f->submission->notes()->where('kind', 'access')->where('user_id', $records->id)->exists());
    }

    #[DataProvider('restrictedKinds')]
    public function test_nobody_else_can_open_restricted_documents_not_even_admin(string $kind): void
    {
        $f = $this->withFile(SubmissionType::Registration, $kind);
        foreach ([Role::Admin, Role::FrontDesk, Role::Hr] as $role) {
            $this->actingAs($this->user($role))->open($f)->assertForbidden();
            $this->get(route('admin.submissions.file', [$f->submission_id, $f->id, 'download' => 1]))->assertForbidden();
        }
        $this->assertSame(0, FileAccess::count());
    }

    public function test_admin_sees_the_card_exists_but_not_its_file_name(): void
    {
        $f = $this->withFile(SubmissionType::Registration, 'id_card', 'shereen-persad-id.jpg');
        $this->actingAs($this->user(Role::Admin))->get(route('admin.submissions.show', $f->submission_id))
            ->assertOk()->assertSee('Records team only')->assertDontSee('shereen-persad-id.jpg');
        $this->actingAs($this->user(Role::Records))->get(route('admin.submissions.show', $f->submission_id))
            ->assertSee('shereen-persad-id.jpg');
    }

    public function test_cv_opens_for_hr_and_admin_only_and_each_opening_is_logged(): void
    {
        $f = $this->withFile(SubmissionType::Career, 'cv', 'cv.pdf');
        $this->actingAs($this->user(Role::Hr))->open($f)->assertOk();
        $this->actingAs($this->user(Role::Admin))->get(route('admin.submissions.file', [$f->submission_id, $f->id, 'download' => 1]))->assertOk()->assertDownload();
        $this->actingAs($this->user(Role::FrontDesk))->open($f)->assertForbidden();
        $this->actingAs($this->user(Role::Records))->open($f)->assertForbidden();
        $this->assertSame(2, FileAccess::count());
        $this->assertSame(2, $f->submission->notes()->where('kind', 'access')->count());
    }

    public function test_referral_letter_opens_for_front_desk_and_is_logged(): void
    {
        $f = $this->withFile(SubmissionType::Appointment, 'referral', 'letter.pdf');
        $this->actingAs($this->user(Role::FrontDesk))->open($f)->assertOk();
        $this->assertSame(1, FileAccess::count());
    }

    public function test_file_must_belong_to_the_request_in_the_url(): void
    {
        $f = $this->withFile(SubmissionType::Registration, 'id_card');
        $other = Submission::factory()->type(SubmissionType::Registration)->create();
        $this->actingAs($this->user(Role::Records))->get(route('admin.submissions.file', [$other->id, $f->id]))->assertNotFound();
        $this->assertSame(0, FileAccess::count());
    }

    public function test_uploads_are_not_reachable_from_the_web(): void
    {
        $f = $this->withFile(SubmissionType::Registration, 'id_card');
        $this->get('/storage/'.$f->path)->assertNotFound();
        $this->get('/'.$f->path)->assertNotFound();
    }

    public function test_document_log_is_for_admin_and_records(): void
    {
        $f = $this->withFile(SubmissionType::Registration, 'id_card');
        $records = $this->user(Role::Records);
        $this->actingAs($records)->open($f);

        $this->actingAs($records)->get('/admin/document-log')->assertOk()->assertSee($records->name)->assertSee($f->submission->reference);
        $this->actingAs($this->user(Role::Admin))->get('/admin/document-log')->assertOk()->assertSee($records->name);
        $this->actingAs($this->user(Role::FrontDesk))->get('/admin/document-log')->assertForbidden();
        $this->actingAs($this->user(Role::Hr))->get('/admin/document-log')->assertForbidden();
    }
}
