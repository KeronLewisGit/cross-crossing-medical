@php($cats = \App\Models\Handout::CATEGORIES)
<x-layouts.site title="Patient handouts" description="Free patient handouts from Cross Crossing Medical Centre: blood pressure, diabetes, bone health, vaccinations and more.">
    <x-page-header title="Patient handouts" lead="Plain-language information to read at home or take to your appointment. These do not replace advice from your own doctor." code="PC" label="Patient corner" />

    <div class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[14rem_minmax(0,1fr)] lg:gap-16">
        <nav aria-label="Handout topics" class="lg:sticky lg:top-28 lg:self-start">
            <p class="kicker text-ink-3">Topics</p>
            <ul class="mt-3 flex flex-wrap gap-2 lg:flex-col lg:gap-0">
                @foreach ($groups as $cat => $list)
                    <li><a href="#{{ $cat }}" class="tag lg:!rounded-none lg:!bg-transparent lg:!px-0 lg:!ring-0 lg:min-h-11 lg:font-bold">{{ $cats[$cat] ?? ucfirst($cat) }} <span class="text-ink-3">({{ $list->count() }})</span></a></li>
                @endforeach
                <li><a href="{{ route('health-checks') }}" class="tag lg:!rounded-none lg:!bg-transparent lg:!px-0 lg:!ring-0 lg:min-h-11 lg:font-bold">Health self-checks</a></li>
            </ul>
        </nav>
        <div class="space-y-14">
            @forelse ($groups as $cat => $list)
                <section id="{{ $cat }}" aria-labelledby="h-{{ $cat }}" class="scroll-mt-28">
                    <h2 id="h-{{ $cat }}" class="display-3">{{ $cats[$cat] ?? ucfirst($cat) }}</h2>
                    <ul class="mt-5 grid gap-4 md:grid-cols-2">
                        @foreach ($list as $h)
                            <li class="card-link plate p-5">
                                <div class="flex items-start gap-3">
                                    <x-icon :name="$h->isExternal() ? 'external' : 'book'" class="mt-0.5 h-5 w-5 flex-none text-ink-3" />
                                    <div>
                                        <h3 class="text-[1.0625rem] font-bold"><a href="{{ $h->href() }}" class="stretch" @if($h->isExternal()) rel="noopener" target="_blank" @endif>{{ $h->title }}</a></h3>
                                        @if ($h->summary)<p class="mt-1 text-[0.9375rem] text-ink-2">{{ $h->summary }}</p>@endif
                                        <p class="mt-2 text-sm text-ink-3">{{ $h->publisher ?: ccmc('name') }} · {{ $h->isExternal() ? 'Opens '.$h->host() : 'PDF'.($h->file_size ? ', '.number_format($h->file_size / 1024).' KB' : '') }}@if($h->isExternal())<span class="sr-only"> (opens in a new tab)</span>@endif</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @empty
                <p class="panel p-6">Handouts are being added. Ask at reception for printed copies.</p>
            @endforelse
        </div>
    </div>
</x-layouts.site>
