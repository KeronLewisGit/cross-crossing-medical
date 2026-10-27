@props(['tone' => 'auto', 'compact' => false, 'small' => false])
{{--
    CCMC's own mark: the line drawing of the building (two round towers with slit windows,
    the window rows between them and the "CCMC" plaque on the east wing), redrawn as SVG from
    the 111px logo on the Google Site so it stays sharp and can turn white on blue. Replace
    with the original artwork when the centre supplies it.
--}}
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 sm:gap-3']) }}>
    <span @class(['flex flex-none items-center justify-center rounded-md', 'bg-white px-1.5 py-1 ring-1 ring-inset ring-line' => $tone !== 'light', 'text-[#141463]' => $tone !== 'light', 'text-white [--logo-fill:transparent]' => $tone === 'light'])>
        <x-logo-mark @class(['w-auto', 'h-7' => $small, 'h-8 sm:h-9' => ! $small]) />
    </span>
    @unless ($compact)
        <span class="leading-none {{ $tone === 'light' ? 'text-white' : 'text-ink' }}">
            {{-- Phones: the name on two lines (the 24/7 band above already says "open now"). --}}
            <span @class(['font-display block font-semibold tracking-[-0.01em]', 'text-[0.95rem] leading-[1.1]' => $small, 'text-[1.02rem] leading-[1.1] sm:whitespace-nowrap sm:text-[1.15rem] sm:leading-none' => ! $small])>Cross Crossing @if($small)<br>@else<br class="sm:hidden">@endif Medical Centre</span>
            {{-- The narrow staff sidebar has no room for the tagline. --}}
            <span @class(['mt-1 whitespace-nowrap text-[0.6875rem] font-extrabold uppercase', $tone === 'light' ? 'text-white/75' : 'text-ink-3', 'hidden' => $small, 'hidden tracking-[0.16em] sm:block' => ! $small])>San Fernando · Open 24/7</span>
        </span>
    @endunless
</span>
