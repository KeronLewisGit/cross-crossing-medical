<x-layouts.admin title="Document log">
    <p class="mb-5 max-w-3xl text-sm text-ink-2">Every time a staff member opens or downloads a document attached to a website request, it is recorded here and on the request's timeline. ID and insurance cards open for the Registration &amp; records role only. Entries cannot be edited or deleted from the dashboard.</p>
    <div class="a-card relative overflow-x-auto">
        <table class="data-table w-full min-w-[42rem]">
            <thead><tr><th scope="col">When</th><th scope="col">Staff member</th><th scope="col">Document</th><th scope="col">Request</th><th scope="col">IP address</th></tr></thead>
            <tbody>
                @forelse ($accesses as $a)
                    <tr>
                        <td class="whitespace-nowrap text-sm num">{{ $a->created_at->format('j M Y, H:i') }}</td>
                        <td class="text-sm font-semibold">{{ $a->user->name ?? 'Deleted user' }}<p class="text-xs font-normal text-ink-3">{{ $a->user?->role->label() }}</p></td>
                        <td class="text-sm"><span class="inline-flex items-center gap-1.5">@if($a->file?->isRestricted())<x-icon name="lock" class="h-4 w-4 text-ink-3" />@endif{{ $a->file?->label() ?? 'Deleted file' }}</span></td>
                        <td class="text-sm">@if ($a->submission)<a href="{{ route('admin.submissions.show', $a->submission) }}" class="inline-flex min-h-11 items-center font-semibold text-link num">{{ $a->submission->reference }}</a>@else — @endif</td>
                        <td class="text-sm text-ink-3 num">{{ $a->ip }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-10 text-center text-ink-3">No documents have been opened yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $accesses->links('components.pagination') }}</div>
</x-layouts.admin>
