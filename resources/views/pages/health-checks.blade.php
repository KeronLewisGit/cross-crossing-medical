<x-layouts.site title="Health self-checks" description="Quick health self-checks: diabetes risk, body mass index (BMI) and fracture risk, with the tests Cross Crossing Medical Centre can do to follow up.">
    <x-page-header title="Health self-checks" lead="A few quick checks you can do at home. They are a starting point for a conversation with your doctor, never a diagnosis." code="PC" label="Patient corner" />

    <div class="wrap mt-12 grid gap-8 md:mt-16 lg:grid-cols-2">
        <section class="panel p-6 md:p-8" id="bmi" aria-labelledby="bmi-title">
            <h2 id="bmi-title" class="display-3">Body mass index (BMI)</h2>
            <p class="mt-2 text-ink-2">BMI compares weight with height. It is a rough guide: it can't tell muscle from fat.</p>
            <form method="GET" action="{{ route('health-checks') }}#bmi" class="mt-6 grid gap-5 sm:grid-cols-[1fr_1fr_auto] sm:items-end">
                <div><label for="height" class="label">Height (cm)</label><input id="height" name="height" type="number" inputmode="decimal" min="50" max="250" step="0.1" value="{{ $input['height'] }}" class="input" required></div>
                <div><label for="weight" class="label">Weight (kg)</label><input id="weight" name="weight" type="number" inputmode="decimal" min="2" max="400" step="0.1" value="{{ $input['weight'] }}" class="input" required></div>
                <button class="btn btn-primary">Work it out</button>
            </form>
            <div aria-live="polite">
                @if ($bmi !== null)
                    <div class="mt-6 rounded-xl bg-soft p-5">
                        <p class="text-ink-2">Your BMI is</p>
                        <p class="font-display text-4xl font-semibold text-link num">{{ number_format($bmi, 1) }}</p>
                        <p class="mt-1 font-semibold">That is {{ $band }} for adults (18.5 to 24.9 is the healthy range).</p>
                        <p class="mt-3 text-[0.9375rem] text-ink-2">For a fuller picture, a <a class="text-link" href="{{ route('appointments', ['service' => 'body-composition']) }}">DEXA body composition analysis</a> measures fat, muscle and bone directly.</p>
                    </div>
                @elseif ($tried)
                    <p class="error mt-4">Enter a height between 50 and 250 cm and a weight between 2 and 400 kg.</p>
                @endif
            </div>
            <p class="mt-5 text-sm text-ink-3">BMI bands for adults over 18 only. Children's BMI is read from growth charts; ask at the paediatric clinic.</p>
        </section>

        <div class="space-y-8">
            @foreach ((array) ccmc('self_checks') as $c)
                <section class="panel p-6 md:p-8">
                    <h2 class="display-3">{{ $c['title'] }}</h2>
                    <p class="mt-2 text-ink-2">{{ $c['body'] }}</p>
                    <a href="{{ $c['url'] }}" class="btn btn-outline mt-5" rel="noopener" target="_blank">Take the check<x-icon name="external" class="h-4 w-4" /><span class="sr-only">(opens {{ $c['source'] }} in a new tab)</span></a>
                    <p class="mt-3 text-sm text-ink-3">Hosted by the {{ $c['source'] }}.</p>
                </section>
            @endforeach
            <section class="panel p-6 md:p-8">
                <h2 class="display-3">Follow-up tests at CCMC</h2>
                <ul class="mt-4 flex flex-wrap gap-2">
                    @foreach (['dexa', 'body-composition', 'lab', 'ecg'] as $k)
                        <li><a class="tag" href="{{ route('appointments', ['service' => $k]) }}">{{ ccmc('tests.'.$k) }}</a></li>
                    @endforeach
                </ul>
            </section>
        </div>
    </div>
</x-layouts.site>
