@props(['tone' => 'auto', 'compact' => false, 'small' => false])
{{--
    CCMC's own mark: the line drawing of the building (two round towers with slit windows,
    the window rows between them and the "CCMC" plaque on the east wing), redrawn as SVG from
    the 111px logo on the Google Site so it stays sharp and can turn white on blue. Replace
    with the original artwork when the centre supplies it.
--}}
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-3']) }}>
    <span @class(['flex flex-none items-center justify-center rounded-md', 'bg-white px-1.5 py-1 ring-1 ring-inset ring-line' => $tone !== 'light', 'text-[#141463]' => $tone !== 'light', 'text-white [--logo-fill:transparent]' => $tone === 'light'])>
        <x-logo-mark @class(['w-auto', 'h-7' => $small, 'h-8 min-[400px]:h-9' => ! $small]) />
    </span>
    @unless ($compact)
        <span class="leading-none {{ $tone === 'light' ? 'text-white' : 'text-ink' }}">
            <span class="font-display block whitespace-nowrap font-semibold tracking-[-0.01em] {{ $small ? 'text-[0.95rem]' : 'text-[1.02rem] min-[400px]:text-[1.15rem]' }}">Cross Crossing <span class="hidden min-[380px]:inline">Medical Centre</span><span class="min-[380px]:hidden">Medical</span></span>
            <span class="mt-1 block whitespace-nowrap text-[0.6875rem] font-extrabold uppercase tracking-[0.16em] {{ $tone === 'light' ? 'text-white/75' : 'text-ink-3' }}">San Fernando · Open 24/7</span>
        </span>
    @endunless
</span>
