<x-layouts.admin title="Patient handouts">
    <x-slot:actions><a href="{{ route('admin.handouts.create') }}" class="a-btn a-btn-primary"><x-icon name="plus" class="h-4 w-4" />Add a handout</a></x-slot:actions>
    <p class="mb-5 max-w-3xl text-sm text-ink-2">Handouts appear in the patient corner. Upload the centre's own PDFs, or link to a trusted public-health source. Handouts are public: never upload anything about a patient.</p>
    <div class="a-card relative overflow-x-auto">
        <table class="data-table w-full min-w-[40rem]">
            <thead><tr><th scope="col">Handout</th><th scope="col">Topic</th><th scope="col">Source</th><th scope="col">Shown</th></tr></thead>
            <tbody>
                @forelse ($handouts as $h)
                    <tr>
                        <td><a href="{{ route('admin.handouts.edit', $h) }}" class="inline-flex min-h-11 items-center font-semibold text-link hover:underline">{{ $h->title }}</a></td>
                        <td class="text-sm">{{ $h->categoryLabel() }}</td>
                        <td class="text-sm text-ink-2">{{ $h->file_path ? 'PDF upload' : $h->host() }}</td>
                        <td><x-chip :tone="$h->published ? 'good' : 'muted'" :icon="$h->published ? 'check-circle' : 'x'">{{ $h->published ? 'Published' : 'Hidden' }}</x-chip></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-10 text-center text-ink-3">No handouts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
