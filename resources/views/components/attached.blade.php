@props(['form', 'field'])
{{-- Files kept from the visitor's last try (UploadStash), so a form error never means attaching them again. --}}
@php($kept = \App\Support\UploadStash::listed(request(), $form, $field))
@if ($kept)
    <div class="-mt-2 rounded-xl border border-line bg-surface-2/60 px-4 py-2" role="status">
        @foreach ($kept as $i => $f)
            <div class="flex flex-wrap items-center gap-x-3">
                <p class="flex min-h-11 min-w-0 flex-1 items-center gap-2"><x-icon name="check-circle" class="h-5 w-5 flex-none text-[color:var(--pulse)]" /><span class="min-w-0 break-all">Attached: <strong>{{ $f['name'] }}</strong> <span class="text-ink-3">({{ max(1, (int) round($f['size'] / 1024)) }} KB)</span></span></p>
                <label class="flex min-h-11 cursor-pointer items-center gap-2 text-ink-2"><input type="checkbox" name="remove_attached[{{ $field }}][]" value="{{ $i }}" class="h-5 w-5 accent-[color:var(--primary)]">Remove</label>
            </div>
        @endforeach
        <p class="pb-2 text-sm text-ink-3">Kept privately from your last try, so you do not need to attach {{ count($kept) > 1 ? 'them' : 'it' }} again.</p>
    </div>
@endif
