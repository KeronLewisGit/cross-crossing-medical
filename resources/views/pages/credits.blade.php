@php($credits = (array) config('photo-credits'))
<x-layouts.site title="Photo credits" description="Sources and licences for the photographs on this website.">
    <x-page-header title="Photo credits" lead="Where each photograph on this website comes from. Photos marked 'illustrative' are not of the centre." code="IMG" label="Credits" />
    <div class="wrap mt-12 md:mt-16">
        <ul class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($credits as $key => $c)
                <li class="plate">
                    <x-photo :key="$key" alt="" sizes="(min-width: 1024px) 24rem, (min-width: 640px) 45vw, 100vw" class="card-img aspect-[16/10]" />
                    <div class="p-5 text-[0.9375rem]">
                        <p class="font-bold">{{ $c['title'] }}</p>
                        <p class="mt-1 text-ink-2">{{ empty($c['own']) ? 'Illustrative · ' : '' }}{{ $c['author'] }}</p>
                        <p class="mt-1 text-ink-3">
                            @if ($c['license_url'])<a class="text-link" href="{{ $c['license_url'] }}" rel="noopener license">{{ $c['license'] }}</a>@else{{ $c['license'] }}@endif
                            · <a class="text-link" href="{{ $c['source'] }}" rel="noopener">Source</a>
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
        <p class="mt-10 text-ink-3 measure">Wikimedia Commons photos are used under the licence shown and have been resized. Photos shared under CC BY-SA remain under that licence.</p>
    </div>
</x-layouts.site>
