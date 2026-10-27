@php($editing = $job->exists)
<x-layouts.admin :title="$editing ? 'Edit vacancy' : 'New vacancy'">
    <x-slot:actions>
        @if ($editing && $job->isOpen())<a href="{{ route('careers.show', $job) }}" class="a-btn a-btn-ghost ring-1 ring-line" target="_blank" rel="noopener"><x-icon name="external" class="h-4 w-4" />View on website</a>@endif
        <a href="{{ route('admin.jobs.index') }}" class="a-btn a-btn-ghost ring-1 ring-line">All vacancies</a>
    </x-slot:actions>
    <form method="POST" action="{{ $editing ? route('admin.jobs.update', $job) : route('admin.jobs.store') }}" class="a-card max-w-3xl space-y-5 p-5 md:p-6">
        @csrf @if($editing) @method('PUT') @endif
        <div><label for="title" class="mb-1 block text-sm font-semibold">Title</label><input id="title" name="title" value="{{ old('title', $job->title) }}" class="a-input w-full" required maxlength="120"></div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div><label for="role_key" class="mb-1 block text-sm font-semibold">Role group</label><select id="role_key" name="role_key" class="a-input w-full">@foreach ((array) ccmc('career_roles') as $k => $l)<option value="{{ $k }}" @selected(old('role_key', $job->role_key) === $k)>{{ $l }}</option>@endforeach</select></div>
            <div><label for="department" class="mb-1 block text-sm font-semibold">Department</label><input id="department" name="department" value="{{ old('department', $job->department) }}" class="a-input w-full" maxlength="80" placeholder="e.g. Dialysis Unit"></div>
            <div><label for="employment" class="mb-1 block text-sm font-semibold">Hours</label><select id="employment" name="employment" class="a-input w-full">@foreach ((array) ccmc('availability') as $k => $l)<option value="{{ $k }}" @selected(old('employment', $job->employment) === $k)>{{ $l }}</option>@endforeach</select></div>
            <div><label for="closes_on" class="mb-1 block text-sm font-semibold">Closing date <span class="font-normal text-ink-3">(optional)</span></label><input id="closes_on" name="closes_on" type="date" value="{{ old('closes_on', $job->closes_on?->toDateString()) }}" class="a-input w-full"></div>
        </div>
        <fieldset><legend class="mb-1 text-sm font-semibold">Status</legend>
            <div class="flex flex-wrap gap-2">@foreach (\App\Enums\JobStatus::cases() as $st)<label class="flex min-h-11 items-center gap-2 rounded-lg border border-line px-3"><input type="radio" name="status" value="{{ $st->value }}" class="h-5 w-5 accent-[color:var(--primary)]" @checked(old('status', $job->status?->value) === $st->value)>{{ $st->label() }}</label>@endforeach</div>
            <p class="mt-1 text-xs text-ink-3">Only open vacancies before their closing date show on the website.</p>
        </fieldset>
        <div><label for="summary" class="mb-1 block text-sm font-semibold">Summary</label><textarea id="summary" name="summary" rows="2" class="a-input w-full" maxlength="600">{{ old('summary', $job->summary) }}</textarea></div>
        <div><label for="duties" class="mb-1 block text-sm font-semibold">Duties <span class="font-normal text-ink-3">(one per line)</span></label><textarea id="duties" name="duties" rows="6" class="a-input w-full">{{ old('duties', $job->duties) }}</textarea></div>
        <div><label for="requirements" class="mb-1 block text-sm font-semibold">Requirements <span class="font-normal text-ink-3">(one per line)</span></label><textarea id="requirements" name="requirements" rows="6" class="a-input w-full">{{ old('requirements', $job->requirements) }}</textarea></div>
        <button class="a-btn a-btn-primary">Save vacancy</button>
    </form>
    @if ($editing)
        <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}" class="mt-4" onsubmit="return confirm('Delete this vacancy? If it has applications it will be closed instead.')">
            @csrf @method('DELETE')
            <button class="a-btn a-btn-ghost text-[color:var(--critical-text)]"><x-icon name="trash" class="h-4 w-4" />Delete vacancy</button>
        </form>
    @endif
</x-layouts.admin>
