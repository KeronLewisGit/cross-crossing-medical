<x-layouts.site title="About the centre" description="Cross Crossing Medical Centre is a multi-speciality medical centre on Oliver Avenue, San Fernando, open 24 hours a day, 365 days a year.">
    <x-page-header title="About Cross Crossing Medical Centre" lead="A multi-speciality clinic near Halliburton, in the suburban area of San Fernando, for drop-in visits, routine check-ups and specialist care." code="CCMC" label="About" photo="lettering" photo-alt="Gold lettering reading Cross Crossing Medical Centre at reception" />

    <div class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1.3fr)_minmax(0,1fr)] lg:gap-16">
        <div class="prose-copy measure text-lg">
            <h2>Welcome</h2>
            <p>Cross Crossing Medical Centre is a multi-speciality clinic. You can visit the centre for a drop-in visit or a routine check-up, or see one of our specialists.</p>
            <p>The centre is staffed by physicians and a full nursing staff, and has a full laboratory, X-ray, and surgical suites on site, so there is no need to go anywhere else.</p>
            <p>Beyond general medical services, the centre performs bone density scans, sleep studies, echocardiograms, ECGs, lung function and stress testing, minor outpatient surgeries, and offers paediatric and women's healthcare.</p>
            <p>We are open 24 hours a day, 7 days a week, 365 days a year.</p>
        </div>
        <div class="grid grid-cols-2 gap-4 self-start">
            <div class="frame-light col-span-2"><x-photo key="building" alt="The front of the centre, with the CCMC entrance canopy" sizes="(min-width: 1024px) 28rem, 100vw" class="aspect-[3/2]" /></div>
            <div class="frame-light"><x-photo key="direction-sign" alt="A roadside sign pointing to the centre" sizes="(min-width: 1024px) 14rem, 50vw" class="aspect-[3/2]" /></div>
            <div class="frame-light"><x-photo key="building-street" alt="The approach to the centre from the street" sizes="(min-width: 1024px) 14rem, 50vw" class="aspect-[3/2]" /></div>
        </div>
    </div>

    <section class="mt-20 bg-surface py-16" aria-labelledby="media-title">
        <div class="wrap">
            <x-sign code="MED" label="In the media" :arrow="false" />
            <h2 id="media-title" class="display-2 mt-5">Research and health columns</h2>
            <p class="mt-3 text-ink-2 measure">Articles and research by the centre's physicians, as listed on the centre's previous website.</p>
            <div class="mt-10 grid gap-10 lg:grid-cols-2">
                @foreach (['research' => 'Research', 'press' => 'Newspaper and newsletter columns'] as $k => $h)
                    <div>
                        <h3 class="font-display text-xl font-medium">{{ $h }}</h3>
                        <ul class="mt-4 divide-y divide-line border-y border-line">
                            @foreach ((array) ccmc('media.'.$k) as $m)
                                <li class="py-4"><p class="font-bold">{{ $m['title'] }}</p><p class="text-[0.9375rem] text-ink-3">{{ $m['outlet'] }}</p></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.site>
