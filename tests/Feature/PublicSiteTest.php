<?php

namespace Tests\Feature;

use App\Models\JobPosting;
use App\Models\Setting;
use Database\Seeders\HandoutSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, array{string}> */
    public static function pages(): array
    {
        $pages = ['/', '/services', '/clinics', '/appointments', '/new-patients', '/patient-handouts', '/health-checks', '/careers', '/careers/apply', '/about', '/contact', '/privacy', '/photo-credits', '/sitemap'];
        foreach (['accident-emergency', 'cardiac', 'dialysis', 'laboratory', 'imaging', 'surgery', 'sleep-lung', 'vaccinations', 'dental'] as $slug) {
            $pages[] = '/services/'.$slug;
        }

        return array_combine($pages, array_map(fn ($p) => [$p], $pages));
    }

    #[DataProvider('pages')]
    public function test_public_page_renders(string $path): void
    {
        $this->seed(HandoutSeeder::class);
        $this->get($path)->assertOk()->assertSee('Cross Crossing Medical Centre', false)->assertSee('Open 24');
    }

    public function test_every_department_in_config_has_a_page_and_unknown_is_404(): void
    {
        foreach (array_keys((array) ccmc('departments')) as $slug) {
            $this->get('/services/'.$slug)->assertOk();
        }
        $this->get('/services/heart-transplants')->assertNotFound();
    }

    public function test_emergency_page_says_call_or_come_in_and_has_no_form(): void
    {
        $this->get('/services/accident-emergency')->assertOk()
            ->assertSee('811')->assertSee('tel:+18686524411', false)
            ->assertDontSee('name="phone"', false);
    }

    public function test_patient_forms_carry_the_not_for_emergencies_notice(): void
    {
        foreach (['/appointments', '/new-patients', '/services/dialysis', '/contact'] as $path) {
            $this->get($path)->assertSee('This form is not for emergencies');
        }
    }

    public function test_laboratory_page_never_offers_results_online(): void
    {
        $this->get('/services/laboratory')->assertOk()->assertSee('never shown on this website', false);
        $this->get('/results')->assertNotFound();
    }

    public function test_dialysis_visiting_option_only_shows_once_confirmed(): void
    {
        config(['ccmc.dialysis_visitors' => false]);
        $this->get('/services/dialysis')->assertDontSee('value="visiting"', false);
        config(['ccmc.dialysis_visitors' => true]);
        $this->get('/services/dialysis')->assertSee('value="visiting"', false);
    }

    public function test_appointment_form_preselects_a_service(): void
    {
        $this->get('/appointments?service=dexa')->assertOk()->assertSee('value="dexa" selected', false);
    }

    public function test_bmi_check_works_without_javascript(): void
    {
        $this->get('/health-checks?height=170&weight=80')->assertOk()->assertSee('27.7')->assertSee('overweight range');
        $this->get('/health-checks?height=10&weight=80')->assertOk()->assertSee('Enter a height between');
    }

    public function test_handouts_are_grouped_and_link_out_safely(): void
    {
        $this->seed(HandoutSeeder::class);
        $this->get('/patient-handouts')->assertOk()->assertSee('High blood pressure')->assertSee('Diabetes and nutrition')->assertSee('rel="noopener"', false);
    }

    public function test_careers_lists_only_open_vacancies(): void
    {
        JobPosting::create(['slug' => 'open-nurse', 'title' => 'Open Nurse Post', 'role_key' => 'registered-nurse', 'employment' => 'full-time', 'status' => 'open']);
        JobPosting::create(['slug' => 'draft-tech', 'title' => 'Draft Tech Post', 'role_key' => 'lab', 'employment' => 'full-time', 'status' => 'draft']);
        JobPosting::create(['slug' => 'expired', 'title' => 'Expired Post', 'role_key' => 'lab', 'employment' => 'full-time', 'status' => 'open', 'closes_on' => today()->subDay()]);

        $this->get('/careers')->assertSee('Open Nurse Post')->assertDontSee('Draft Tech Post')->assertDontSee('Expired Post');
        $this->get('/careers/open-nurse')->assertOk()->assertSee('JobPosting', false);
        $this->get('/careers/draft-tech')->assertNotFound();
    }

    public function test_public_notice_setting_shows_on_every_page(): void
    {
        Setting::put('public_notice', 'The 652-4412 line is down today.');
        $this->get('/')->assertSee('The 652-4412 line is down today.');
        $this->get('/clinics')->assertSee('The 652-4412 line is down today.');
    }

    public function test_sitemap_xml_lists_pages(): void
    {
        $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml')->assertSee(route('new-patients'));
    }

    public function test_old_google_site_links_redirect(): void
    {
        $this->get('/newpatient')->assertRedirect(route('new-patients'))->assertStatus(301);
        $this->get('/site/ccmctt/facilities/dialysis')->assertRedirect(route('department', 'dialysis'));
        $this->get('/facilities/accident-and-emergency')->assertRedirect(route('department', 'accident-emergency'));
        $this->get('/cross-crossing-medical-centre/contact')->assertRedirect(route('contact'));
        $this->get('/self-evaluation/osteoporosis')->assertRedirect(route('health-checks'));
        $this->get('/patient-corner/patient-handouts')->assertRedirect(route('handouts'));
    }

    public function test_every_photo_has_a_credit_and_a_file(): void
    {
        $credits = (array) config('photo-credits');
        foreach (array_keys((array) ccmc('photos')) as $key) {
            $this->assertArrayHasKey($key, $credits, "No credit for photo $key");
            $this->assertFileExists(public_path("img/$key-480.webp"));
        }
        $this->get('/photo-credits')->assertSee('Wikimedia', false)->assertSee('CC BY-SA 4.0');
    }

    public function test_preview_mode_adds_noindex(): void
    {
        config(['ccmc.preview' => true]);
        $this->get('/')->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_unknown_page_shows_helpful_404(): void
    {
        $this->get('/no-such-page')->assertNotFound()->assertSee('That page has moved');
    }

    public function test_thanks_without_a_submission_goes_home(): void
    {
        $this->get('/thanks')->assertRedirect('/');
    }
}
