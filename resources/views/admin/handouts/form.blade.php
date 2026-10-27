@php($editing = $handout->exists)
<x-layouts.admin :title="$editing ? 'Edit handout' : 'Add a handout'">
    <x-slot:actions><a href="{{ route('admin.handouts.index') }}" class="a-btn a-btn-ghost ring-1 ring-line">All handouts</a></x-slot:actions>
    <form method="POST" action="{{ $editing ? route('admin.handouts.update', $handout) : route('admin.handouts.store') }}" enctype="multipart/form-data" class="a-card max-w-3xl space-y-5 p-5 md:p-6">
        @csrf @if($editing) @method('PUT') @endif
        <div><label for="title" class="mb-1 block text-sm font-semibold">Title</label><input id="title" name="title" value="{{ old('title', $handout->title) }}" class="a-input w-full" required maxlength="140"></div>
        <div class="grid gap-4 sm:grid-cols-[1fr_8rem]">
            <div><label for="category" class="mb-1 block text-sm font-semibold">Topic</label><select id="category" name="category" class="a-input w-full">@foreach (\App\Models\Handout::CATEGORIES as $k => $l)<option value="{{ $k }}" @selected(old('category', $handout->category) === $k)>{{ $l }}</option>@endforeach</select></div>
            <div><label for="sort" class="mb-1 block text-sm font-semibold">Order</label><input id="sort" name="sort" type="number" min="0" max="999" value="{{ old('sort', $handout->sort) }}" class="a-input w-full"></div>
        </div>
        <div><label for="summary" class="mb-1 block text-sm font-semibold">One-line summary</label><textarea id="summary" name="summary" rows="2" class="a-input w-full" maxlength="400">{{ old('summary', $handout->summary) }}</textarea></div>
        <div><label for="publisher" class="mb-1 block text-sm font-semibold">Publisher <span class="font-normal text-ink-3">(blank = the centre)</span></label><input id="publisher" name="publisher" value="{{ old('publisher', $handout->publisher) }}" class="a-input w-full" maxlength="120"></div>
        <div class="rounded-lg border border-line p-4">
            <p class="text-sm font-semibold">Upload a PDF, or link to a page</p>
            <div class="mt-3"><label for="file" class="mb-1 block text-sm">PDF (up to 10 MB)</label><input id="file" name="file" type="file" accept=".pdf,application/pdf" class="a-input w-full"></div>
            @if ($handout->file_path)
                <p class="mt-2 text-sm"><a href="{{ $handout->href() }}" class="text-link" target="_blank" rel="noopener">Current PDF</a> · <label class="inline-flex min-h-11 items-center gap-2"><input type="checkbox" name="remove_file" value="1" class="h-5 w-5">Remove it</label></p>
            @endif
            <div class="mt-3"><label for="url" class="mb-1 block text-sm">Or a link</label><input id="url" name="url" type="url" value="{{ old('url', $handout->url) }}" class="a-input w-full" placeholder="https://"></div>
        </div>
        <label class="flex min-h-11 items-center gap-2 text-sm font-semibold"><input type="checkbox" name="published" value="1" class="h-5 w-5 accent-[color:var(--primary)]" @checked(old('published', $handout->published))>Show on the website</label>
        <button class="a-btn a-btn-primary">Save handout</button>
    </form>
    @if ($editing)
        <form method="POST" action="{{ route('admin.handouts.destroy', $handout) }}" class="mt-4" onsubmit="return confirm('Delete this handout?')">
            @csrf @method('DELETE')
            <button class="a-btn a-btn-ghost text-[color:var(--critical-text)]"><x-icon name="trash" class="h-4 w-4" />Delete handout</button>
        </form>
    @endif
</x-layouts.admin>
