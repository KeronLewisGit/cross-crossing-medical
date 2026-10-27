<x-layouts.admin title="Vacancies">
    <x-slot:actions><a href="{{ route('admin.jobs.create') }}" class="a-btn a-btn-primary"><x-icon name="plus" class="h-4 w-4" />New vacancy</a></x-slot:actions>
    <div class="a-card relative overflow-x-auto">
        <table class="data-table w-full min-w-[40rem]">
            <thead><tr><th scope="col">Vacancy</th><th scope="col">Status</th><th scope="col">Closes</th><th scope="col" class="r">Applications</th></tr></thead>
            <tbody>
                @forelse ($jobs as $job)
                    <tr>
                        <td><a href="{{ route('admin.jobs.edit', $job) }}" class="inline-flex min-h-11 items-center font-semibold text-link hover:underline">{{ $job->title }}</a>@if($job->is_demo) <span class="demo-badge ml-1">Demo</span>@endif<p class="text-xs text-ink-3">{{ $job->department }} · {{ $job->employmentLabel() }}</p></td>
                        <td><x-chip :tone="$job->status->tone()" :icon="$job->status->icon()">{{ $job->status->label() }}</x-chip></td>
                        <td class="text-sm num">{{ $job->closes_on?->format('j M Y') ?? '—' }}</td>
                        <td class="r"><a href="{{ route('admin.submissions.index', ['type' => 'career', 'q' => null]) }}" class="inline-flex min-h-11 items-center gap-2 num"><span class="font-semibold">{{ $job->applications_count }}</span>@if($job->new_count)<span class="chip" data-tone="attention"><x-icon name="dot" />{{ $job->new_count }} new</span>@endif</a></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-10 text-center text-ink-3">No vacancies yet. Without any, the careers page invites general applications.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
