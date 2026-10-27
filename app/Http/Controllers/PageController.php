<?php

namespace App\Http\Controllers;

use App\Models\Handout;
use App\Models\JobPosting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', ['openJobs' => JobPosting::open()->count()]);
    }

    public function services(): View
    {
        return view('pages.services.index');
    }

    public function department(string $slug): View
    {
        $dept = ccmc('departments.'.$slug);
        abort_unless(is_array($dept), 404);

        return view('pages.services.show', [
            'slug' => $slug,
            'dept' => $dept,
            'situations' => FormController::dialysisSituations(),
        ]);
    }

    public function clinics(): View
    {
        return view('pages.clinics');
    }

    public function newPatients(): View
    {
        return view('pages.forms.registration');
    }

    public function handouts(): View
    {
        $handouts = Handout::published()->orderBy('sort')->orderBy('title')->get();

        return view('pages.handouts', [
            'groups' => $handouts->groupBy('category')->sortBy(fn ($list, $cat) => array_search($cat, array_keys(Handout::CATEGORIES), true)),
        ]);
    }

    /** BMI check from the old "Self evaluation" pages. A plain GET form, so it works without JavaScript. */
    public function healthChecks(Request $request): View
    {
        $height = (float) input_string($request->query('height'));
        $weight = (float) input_string($request->query('weight'));
        $bmi = $height >= 50 && $height <= 250 && $weight >= 2 && $weight <= 400 ? round($weight / (($height / 100) ** 2), 1) : null;

        return view('pages.health-checks', [
            'bmi' => $bmi,
            'band' => $bmi === null ? null : match (true) {
                $bmi < 18.5 => 'below the healthy range',
                $bmi < 25 => 'in the healthy range',
                $bmi < 30 => 'in the overweight range',
                default => 'in the obese range',
            },
            'input' => ['height' => $height ?: null, 'weight' => $weight ?: null],
            'tried' => $request->has('height') || $request->has('weight'),
        ]);
    }

    public function careers(): View
    {
        return view('pages.careers.index', ['jobs' => JobPosting::open()->orderBy('title')->get()]);
    }

    public function job(JobPosting $job): View
    {
        abort_unless($job->isOpen(), 404);

        return view('pages.careers.show', ['job' => $job]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function contact(): View
    {
        return view('pages.contact', ['topics' => FormController::TOPICS]);
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }

    public function credits(): View
    {
        return view('pages.credits');
    }

    public function sitemapPage(): View
    {
        return view('pages.sitemap', ['jobs' => JobPosting::open()->orderBy('title')->get(['slug', 'title'])]);
    }

    public function sitemap(): Response
    {
        $static = ['home', 'services', 'clinics', 'appointments', 'new-patients', 'handouts', 'health-checks', 'careers', 'careers.apply',
            'about', 'contact', 'privacy', 'credits', 'sitemap.page'];
        $urls = collect($static)->map(fn (string $name) => ['loc' => route($name), 'lastmod' => null])
            ->concat(collect(array_keys((array) ccmc('departments')))->map(fn (string $slug) => ['loc' => route('department', $slug), 'lastmod' => null]))
            ->concat(JobPosting::open()->get()->map(fn (JobPosting $j) => ['loc' => route('careers.show', $j), 'lastmod' => $j->updated_at->toAtomString()]));

        return response()->view('sitemap', ['urls' => $urls])->header('Content-Type', 'application/xml');
    }

    /**
     * Paths from the Google Site (sites.google.com/site/ccmctt/…), in case old links are
     * pointed at the new domain: send each to the matching new page.
     */
    public function legacy(string $path = ''): RedirectResponse
    {
        $path = trim($path, '/');
        $to = match (true) {
            str_ends_with($path, 'contact'), str_ends_with($path, 'location') => route('contact'),
            str_ends_with($path, 'physicians') => route('clinics'),
            str_ends_with($path, 'services'), $path === 'facilities' => route('services'),
            str_ends_with($path, 'vaccinations') => route('department', 'vaccinations'),
            str_ends_with($path, 'accident-and-emergency') => route('department', 'accident-emergency'),
            str_ends_with($path, 'cardiac-care-unit') => route('department', 'cardiac'),
            str_ends_with($path, 'dental') => route('department', 'dental'),
            str_ends_with($path, 'dialysis') => route('department', 'dialysis'),
            str_starts_with($path, 'newpatient') => route('new-patients'),
            str_starts_with($path, 'patient-corner') => route('handouts'),
            $path === 'media' => route('about').'#media-title',
            str_starts_with($path, 'self-evaluation') => route('health-checks'),
            default => route('home'),
        };

        return redirect()->to($to, 301);
    }
}
