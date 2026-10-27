@props(['title', 'lead' => null, 'code' => 'CCMC', 'label' => 'Cross Crossing Medical Centre', 'photo' => null, 'photoAlt' => '', 'position' => 'center', 'ae' => false])
{{--
    The one hero band every inner page uses, so titles start at the same height and left
    edge site-wide: sign-blue stucco, a ward-sign label, the title and lead, and (when given)
    a framed photo on the right, like a window in the wall. A monitor trace runs along the
    bottom. Extra content (breadcrumbs, actions, notices) goes in the slot.
--}}
<section {{ $attributes->merge(['class' => 'stucco on-sign relative isolate overflow-hidden text-white']) }}>
    <div @class(['wrap grid gap-8 pb-8 pt-9 md:pb-12 md:pt-14', 'md:grid-cols-[minmax(0,1fr)_minmax(0,22rem)] md:items-center lg:grid-cols-[minmax(0,1fr)_minmax(0,26rem)] lg:gap-14' => $photo])>
        <div class="min-w-0">
            <x-sign :code="$code" :label="$label" :ae="$ae" />
            <h1 class="display-2 mt-5 max-w-4xl">{{ $title }}</h1>
            @if ($lead)<p class="lead mt-4 text-white/85 md:mt-5">{{ $lead }}</p>@endif
            {{ $slot }}
        </div>
        @if ($photo)
            <div class="frame">
                <x-photo :key="$photo" :alt="$photoAlt" :eager="true" sizes="(min-width: 1024px) 26rem, (min-width: 768px) 22rem, 100vw" class="aspect-[16/9] md:aspect-[4/3]" :position="$position" />
            </div>
        @endif
    </div>
    <x-pulse-line :draw="true" class="-mb-px" />
</section>
