@props(['purpose', 'name' => 'consent'])
{{-- Explicit consent under the Data Protection Act, 2011: a ticked box, a plain-words purpose and a link to the notice. --}}
<div class="rounded-xl border border-line bg-surface-2/60 p-4 md:p-5">
    <label class="flex cursor-pointer items-start gap-3">
        <input type="checkbox" name="{{ $name }}" value="1" class="mt-1 h-5 w-5 flex-none accent-[color:var(--primary)]" required @checked(old($name)) @if($errors->has($name)) aria-invalid="true" @endif>
        <span><strong>I consent</strong> to Cross Crossing Medical Centre keeping these details {{ $purpose }}, as set out in the <a href="{{ route('privacy') }}" class="text-link" target="_blank">privacy notice</a> (Data Protection Act, 2011). I can ask to see, correct or withdraw them at any time.</span>
    </label>
    <x-error :for="$name" />
</div>
