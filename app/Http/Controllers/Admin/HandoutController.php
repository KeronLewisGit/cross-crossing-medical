<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Handout;
use App\Support\Slug;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/** The patient handouts library: a PDF uploaded here, or a link to the publisher's own copy. */
class HandoutController extends Controller
{
    public function index(): View
    {
        return view('admin.handouts.index', ['handouts' => Handout::orderBy('category')->orderBy('sort')->orderBy('title')->get()]);
    }

    public function create(): View
    {
        return view('admin.handouts.form', ['handout' => new Handout(['category' => 'general', 'published' => true, 'sort' => 100])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, null);
        $data['slug'] = Slug::unique(Handout::class, $data['title'], 'handout');
        $handout = Handout::create($data);

        return to_route('admin.handouts.edit', $handout)->with('status', 'Handout added.');
    }

    public function edit(Handout $handout): View
    {
        return view('admin.handouts.form', ['handout' => $handout]);
    }

    public function update(Request $request, Handout $handout): RedirectResponse
    {
        $handout->update($this->validated($request, $handout));

        return back()->with('status', 'Handout saved.');
    }

    public function destroy(Handout $handout): RedirectResponse
    {
        if ($handout->file_path) {
            Storage::disk('uploads')->delete($handout->file_path);
        }
        $handout->delete();

        return to_route('admin.handouts.index')->with('status', 'Handout deleted.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, ?Handout $handout): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:140'],
            'category' => ['required', Rule::in(array_keys(Handout::CATEGORIES))],
            'summary' => ['nullable', 'string', 'max:400'],
            'publisher' => ['nullable', 'string', 'max:120'],
            'url' => ['nullable', 'url:https,http', 'max:300'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'remove_file' => ['nullable', 'boolean'],
            'published' => ['nullable', 'boolean'],
            'sort' => ['nullable', 'integer', 'min:0', 'max:999'],
        ], ['file.mimes' => 'Handouts must be PDF files.']);

        $out = collect($data)->only(['title', 'category', 'summary', 'publisher', 'url'])->all();
        $out['published'] = $request->boolean('published');
        $out['sort'] = (int) ($data['sort'] ?? 100);

        $file = $request->file('file');
        if ($file instanceof UploadedFile) {
            if ($handout?->file_path) {
                Storage::disk('uploads')->delete($handout->file_path);
            }
            // Handouts are public documents, so they live in the web root (uploads/handouts).
            $out['file_path'] = $file->store('handouts', 'uploads');
            $out['file_size'] = (int) $file->getSize();
        } elseif ($request->boolean('remove_file') && $handout?->file_path) {
            Storage::disk('uploads')->delete($handout->file_path);
            $out['file_path'] = null;
            $out['file_size'] = null;
        }

        return $out;
    }
}
