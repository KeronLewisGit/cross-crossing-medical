<x-layouts.admin title="Settings">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-2xl space-y-6">
        @csrf @method('PUT')
        <section class="a-card space-y-3 p-5">
            <h2 class="font-semibold">Notice on every page</h2>
            <p class="text-sm text-ink-2">A short line shown under the 24-hour band on every public page, for a holiday clinic change, a phone line fault or a public-health message. Leave blank to hide it.</p>
            <label for="notice" class="sr-only">Public notice</label>
            <textarea id="notice" name="public_notice" rows="3" maxlength="280" class="a-input w-full" placeholder="e.g. The 652-4412 line is down today. Please call 652-4411.">{{ old('public_notice', $notice) }}</textarea>
            <p class="text-xs text-ink-3">Up to 280 characters. Do not post anything about a named patient.</p>
        </section>
        <button class="a-btn a-btn-primary">Save settings</button>
    </form>
</x-layouts.admin>
