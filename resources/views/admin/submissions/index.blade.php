@php
    use App\Enums\SubmissionStatus;
    $statusTabs = ['' => 'All', 'open' => 'Open'] + collect(SubmissionStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label($type)])->all();
    $openCount = collect(SubmissionStatus::cases())->filter->isOpen()->sum(fn ($s) => (int) ($counts[$s->value] ?? 0));
    $q = fn (array $over) => route('admin.submissions.index', array_filter(array_merge($filters, $over), fn ($v) => $v !== null && $v !== ''));
@endphp
<x-layouts.admin title="Requests inbox">
    <x-slot:actions>
        <a href="{{ route('admin.submissions.export', array_filter($filters)) }}" class="a-btn a-btn-ghost ring-1 ring-line"><x-icon name="download" class="h-4 w-4" />Export CSV</a>
    </x-slot:actions>

    {{-- Type tabs: only the types this role works. --}}
    @if (count($types) > 1)
        <nav class="tag-row mb-4" aria-label="Request type">
            <a href="{{ $q(['type' => null, 'service' => null]) }}" class="tag" @if(! $filters['type']) aria-current="page" @endif>All types</a>
            @foreach ($types as $t)
                <a href="{{ $q(['type' => $t->value, 'service' => null]) }}" class="tag" @if($filters['type'] === $t->value) aria-current="page" @endif><x-icon :name="$t->icon()" class="h-4 w-4" />{{ $t->plural() }}</a>
            @endforeach
        </nav>
    @endif

    <form method="GET" action="{{ route('admin.submissions.index') }}" class="a-card mb-4 grid gap-3 p-4 sm:grid-cols-2 lg:grid-cols-[1fr_12rem_12rem_auto_auto] lg:items-end">
        @if ($filters['type'])<input type="hidden" name="type" value="{{ $filters['type'] }}">@endif
        <div><label class="mb-1 block text-sm font-semibold" for="f-q">Search</label><input id="f-q" name="q" value="{{ $filters['q'] }}" class="a-input w-full" placeholder="Name, phone or reference"></div>
        <div><label class="mb-1 block text-sm font-semibold" for="f-status">Status</label>
            <select id="f-status" name="status" class="a-input w-full">@foreach ($statusTabs as $v => $l)<option value="{{ $v }}" @selected((string) $filters['status'] === (string) $v)>{{ $l }}</option>@endforeach</select></div>
        <div><label class="mb-1 block text-sm font-semibold" for="f-assigned">Assigned</label>
            <select id="f-assigned" name="assigned" class="a-input w-full">
                <option value="">Anyone</option><option value="me" @selected($filters['assigned'] === (string) auth()->id())>Me</option><option value="none" @selected($filters['assigned'] === 'none')>Nobody</option>
                @foreach ($staff as $u)<option value="{{ $u->id }}" @selected($filters['assigned'] === (string) $u->id && $u->id !== auth()->id())>{{ $u->name }}</option>@endforeach
            </select></div>
        <label class="flex min-h-11 items-center gap-2 text-sm font-semibold"><input type="checkbox" name="overdue" value="1" class="h-5 w-5 accent-[color:var(--primary)]" @checked($filters['overdue'])>Overdue only</label>
        <div class="flex gap-2"><button class="a-btn a-btn-primary">Filter</button><a href="{{ route('admin.submissions.index') }}" class="a-btn a-btn-ghost">Clear</a></div>
    </form>

    <p class="mb-3 text-sm text-ink-3"><span class="num font-semibold text-ink">{{ $submissions->total() }}</span> {{ \Illuminate\Support\Str::plural('request', $submissions->total()) }} · <span class="num">{{ $openCount }}</span> open</p>

    <div class="a-card relative overflow-x-auto">
        <table class="data-table w-full min-w-[46rem]">
            <thead><tr><th scope="col">Patient or applicant</th><th scope="col">Request</th><th scope="col">Status</th><th scope="col">Received</th><th scope="col">Assigned</th></tr></thead>
            <tbody>
                @forelse ($submissions as $s)
                    <tr>
                        <td>
                            <a href="{{ route('admin.submissions.show', $s) }}" class="inline-flex min-h-11 flex-col justify-center font-semibold text-link hover:underline">{{ $s->patientName() }}</a>
                            <p class="text-xs text-ink-3"><span class="num">{{ $s->reference }}</span>@if($s->is_demo) <span class="demo-badge ml-1">Demo</span>@endif</p>
                        </td>
                        <td class="max-w-[18rem]"><p class="flex items-center gap-1.5 text-sm"><x-icon :name="$s->type->icon()" class="h-4 w-4 flex-none text-ink-3" />{{ $s->type->label() }}</p><p class="truncate text-sm text-ink-2">{{ $s->subject() }}@if($s->files_count) · <x-icon name="file" class="inline h-3.5 w-3.5" /> {{ $s->files_count }}@endif</p></td>
                        <td><x-status :status="$s->status" :type="$s->type" />@if($s->booked_date)<p class="mt-1 text-xs text-ink-3 num">{{ $s->booked_date->format('D j M') }} {{ $s->booked_time }}</p>@endif</td>
                        <td class="whitespace-nowrap text-sm"><span title="{{ $s->created_at->format('j M Y H:i') }}">{{ $s->created_at->diffForHumans() }}</span>@if($s->isOverdue())<p><span class="chip mt-1" data-tone="critical"><x-icon name="clock" />Overdue</span></p>@endif</td>
                        <td class="text-sm">{{ $s->assignee->name ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-10 text-center text-ink-3">No requests match these filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $submissions->links('components.pagination') }}</div>
</x-layouts.admin>
