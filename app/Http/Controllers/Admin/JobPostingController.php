<?php

namespace App\Http\Controllers\Admin;

use App\Enums\JobStatus;
use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Support\Slug;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/** Vacancies on /careers. Applications arrive in the requests inbox as job applications. */
class JobPostingController extends Controller
{
    public function index(): View
    {
        return view('admin.jobs.index', [
            'jobs' => JobPosting::withCount([
                'applications',
                'applications as new_count' => fn ($q) => $q->where('status', 'new'),
            ])->orderByRaw("case status when 'open' then 0 when 'draft' then 1 else 2 end")->latest('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.jobs.form', ['job' => new JobPosting(['status' => JobStatus::Draft, 'employment' => 'full-time', 'role_key' => 'registered-nurse'])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = Slug::unique(JobPosting::class, $data['title'], 'vacancy');
        $job = JobPosting::create($data);

        return to_route('admin.jobs.edit', $job)->with('status', 'Vacancy created.');
    }

    public function edit(JobPosting $job): View
    {
        return view('admin.jobs.form', ['job' => $job]);
    }

    public function update(Request $request, JobPosting $job): RedirectResponse
    {
        $job->update($this->validated($request));

        return back()->with('status', 'Vacancy saved.');
    }

    public function destroy(JobPosting $job): RedirectResponse
    {
        if ($job->applications()->exists()) {
            $job->update(['status' => JobStatus::Closed]);

            return to_route('admin.jobs.index')->with('status', 'That vacancy has applicants, so it was closed instead of deleted.');
        }
        $job->delete();

        return to_route('admin.jobs.index')->with('status', 'Vacancy deleted.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        $text = ['nullable', 'string', 'max:5000'];

        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'role_key' => ['required', Rule::in(array_keys((array) ccmc('career_roles')))],
            'department' => ['nullable', 'string', 'max:80'],
            'employment' => ['required', Rule::in(array_keys((array) ccmc('availability')))],
            'status' => ['required', Rule::enum(JobStatus::class)],
            'closes_on' => ['nullable', 'date_format:Y-m-d'],
            'summary' => ['nullable', 'string', 'max:600'],
            'duties' => $text,
            'requirements' => $text,
        ], [], ['role_key' => 'role group', 'closes_on' => 'closing date']);
    }
}
