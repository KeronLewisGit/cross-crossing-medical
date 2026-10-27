<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Overview']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Overview']); ?>
    <?php if($notifyMissing): ?>
        <div class="mb-5 flex gap-3 rounded-xl border border-line bg-surface p-4 text-sm" role="status"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'mail','class' => 'h-5 w-5 flex-none text-link']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'mail','class' => 'h-5 w-5 flex-none text-link']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><p><strong>Nobody is emailed about new requests yet.</strong> Set <code>CCMC_NOTIFY_EMAIL</code> (and <code>CCMC_NOTIFY_HR_EMAIL</code> for applications) in <code>.env</code>.</p></div>
    <?php elseif($notifyInvalid): ?>
        <div class="mb-5 flex gap-3 rounded-xl border border-line bg-surface p-4 text-sm" role="status"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'alert','class' => 'h-5 w-5 flex-none text-[color:var(--critical)]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'alert','class' => 'h-5 w-5 flex-none text-[color:var(--critical)]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><p>These notification addresses look wrong and are skipped: <?php echo e(implode(', ', $notifyInvalid)); ?></p></div>
    <?php endif; ?>

    
    <section class="<?php echo \Illuminate\Support\Arr::toCssClasses(['a-card overflow-hidden', 'ring-2 ring-[color:var(--critical)]' => $headlineCount > 0]); ?>" aria-labelledby="overdue-title">
        <div class="grid gap-5 p-6 md:grid-cols-[auto_1fr_auto] md:items-center md:gap-8 md:p-8">
            <p class="<?php echo \Illuminate\Support\Arr::toCssClasses(['big-number font-display', 'text-[color:var(--critical-text)]' => $headlineCount > 0, 'text-[color:var(--good)]' => $headlineCount === 0]); ?>"><?php echo e($headlineCount); ?></p>
            <div>
                <h2 id="overdue-title" class="text-xl font-bold"><?php echo e(ucfirst($headlineLabel)); ?></h2>
                <p class="mt-1 text-ink-2">
                    <?php if($headlineCount): ?>
                        The oldest arrived <?php echo e($oldestOverdue?->diffForHumans()); ?>. Patients who hear back quickly don't ring the switchboard again.
                    <?php else: ?>
                        Everything is inside its response time. <?php echo e($newCount); ?> <?php echo e(\Illuminate\Support\Str::plural('request', $newCount)); ?> still new but not yet late.
                    <?php endif; ?>
                </p>
                <p class="mt-2 text-sm text-ink-3">Response times: <?php echo e(collect($headlineTypes)->map(fn ($t) => $t->plural().' '.$t->responseHours().'h')->implode(', ')); ?></p>
            </div>
            <a href="<?php echo e(route('admin.submissions.index', $headlineCount ? ['overdue' => 1] : ['status' => 'new'])); ?>" class="a-btn <?php echo e($headlineCount ? 'a-btn-primary' : 'a-btn-ghost'); ?>"><?php echo e($headlineCount ? 'Deal with them now' : 'Open new requests'); ?><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a>
        </div>
        <?php if (isset($component)) { $__componentOriginalb010addd8d0ea019d1f5f2b79163d3e6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb010addd8d0ea019d1f5f2b79163d3e6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pulse-line','data' => ['muted' => $headlineCount === 0,'class' => ''.e($headlineCount ? 'text-[color:var(--critical)]' : 'text-[color:var(--pulse)]').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pulse-line'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['muted' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($headlineCount === 0),'class' => ''.e($headlineCount ? 'text-[color:var(--critical)]' : 'text-[color:var(--pulse)]').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb010addd8d0ea019d1f5f2b79163d3e6)): ?>
<?php $attributes = $__attributesOriginalb010addd8d0ea019d1f5f2b79163d3e6; ?>
<?php unset($__attributesOriginalb010addd8d0ea019d1f5f2b79163d3e6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb010addd8d0ea019d1f5f2b79163d3e6)): ?>
<?php $component = $__componentOriginalb010addd8d0ea019d1f5f2b79163d3e6; ?>
<?php unset($__componentOriginalb010addd8d0ea019d1f5f2b79163d3e6); ?>
<?php endif; ?>
    </section>

    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['mt-6 grid gap-4 sm:grid-cols-2', 'xl:grid-cols-4' => count($tiles) >= 4, 'xl:grid-cols-3' => count($tiles) === 3]); ?>">
        <?php $__currentLoopData = $tiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(($t['format'] ?? null) === 'minutes'): ?>
                <a href="<?php echo e($t['href']); ?>" class="a-card block p-5 transition hover:shadow-lg">
                    <p class="text-sm text-ink-2"><?php echo e($t['label']); ?></p>
                    <p class="mt-2 text-[2rem] font-semibold leading-none tracking-tight num"><?php echo e($t['value'] === null ? '—' : ($t['value'] >= 120 ? round($t['value'] / 60, 1).' h' : $t['value'].' min')); ?></p>
                    <p class="mt-3 text-sm text-ink-3"><?php echo e($t['note']); ?></p>
                </a>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginalec2208e5b554b62f9a0aeb9b4b09865b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec2208e5b554b62f9a0aeb9b4b09865b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-tile','data' => ['label' => $t['label'],'value' => $t['value'],'previous' => $t['previous'] ?? null,'period' => $t['period'] ?? null,'note' => $t['note'] ?? null,'href' => $t['href']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-tile'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($t['label']),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($t['value']),'previous' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($t['previous'] ?? null),'period' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($t['period'] ?? null),'note' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($t['note'] ?? null),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($t['href'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalec2208e5b554b62f9a0aeb9b4b09865b)): ?>
<?php $attributes = $__attributesOriginalec2208e5b554b62f9a0aeb9b4b09865b; ?>
<?php unset($__attributesOriginalec2208e5b554b62f9a0aeb9b4b09865b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalec2208e5b554b62f9a0aeb9b4b09865b)): ?>
<?php $component = $__componentOriginalec2208e5b554b62f9a0aeb9b4b09865b; ?>
<?php unset($__componentOriginalec2208e5b554b62f9a0aeb9b4b09865b); ?>
<?php endif; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($recentOpens !== null): ?>
            <a href="<?php echo e(route('admin.document-log')); ?>" class="a-card block p-5 transition hover:shadow-lg">
                <p class="text-sm text-ink-2">Patient documents opened</p>
                <p class="mt-2 text-[2rem] font-semibold leading-none tracking-tight num"><?php echo e($recentOpens); ?></p>
                <p class="mt-3 text-sm text-ink-3">last 7 days, every opening logged</p>
            </a>
        <?php endif; ?>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1.5fr_1fr]">
        <section class="a-card min-w-0 p-5" aria-labelledby="chart-title">
            <div class="flex flex-wrap items-baseline justify-between gap-2">
                <h2 id="chart-title" class="font-semibold">Requests per day, last <?php echo e($chartDays); ?> days</h2>
                <p class="text-sm text-ink-3 num"><?php echo e($daily->sum('count')); ?> total</p>
            </div>
            <div class="relative mt-5" x-data="columnChart" @mouseleave="hide()">
                <svg viewBox="0 0 <?php echo e($chartDays * 10); ?> 120" class="h-44 w-full" preserveAspectRatio="none" role="img" aria-label="Column chart of requests per day">
                    <?php $__currentLoopData = $daily; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php ($h = $d['count'] / $dailyMax * 110); ?>
                        <rect class="bar" x="<?php echo e($i * 10 + 1.5); ?>" y="<?php echo e(120 - max($h, 1)); ?>" width="7" height="<?php echo e(max($h, 1)); ?>" rx="1.5" fill="<?php echo e($d['count'] ? 'var(--series-1)' : 'var(--series-track)'); ?>"
                            data-label="<?php echo e($d['date']->format('D j M')); ?>" data-value="<?php echo e($d['count']); ?>" tabindex="0" @mouseenter="show($el)" @focus="show($el)" @blur="hide()"><title><?php echo e($d['date']->format('D j M')); ?>: <?php echo e($d['count']); ?></title></rect>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </svg>
                <div x-show="tip" x-cloak class="pointer-events-none absolute -translate-x-1/2 -translate-y-full rounded-md bg-sign-950 px-2.5 py-1.5 text-xs font-semibold text-white shadow" :style="tip && `left:${tip.x}px; top:${tip.y - 6}px`"><span x-text="tip?.label"></span>: <span x-text="tip?.value"></span></div>
                <div class="mt-2 flex justify-between text-xs text-ink-3"><span><?php echo e($daily->first()['date']->format('j M')); ?></span><span>Today</span></div>
            </div>
        </section>
        <section class="a-card min-w-0 p-5" aria-labelledby="type-title">
            <h2 id="type-title" class="font-semibold">By type, last <?php echo e($chartDays); ?> days</h2>
            <?php ($maxType = max(1, $byType->max('count'))); ?>
            <ul class="mt-3 space-y-1">
                <?php $__currentLoopData = $byType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="<?php echo e(route('admin.submissions.index', ['type' => $row['type']->value])); ?>" class="block min-h-11 rounded px-1 py-1.5 hover:bg-surface-2">
                            <div class="flex justify-between text-sm"><span class="inline-flex items-center gap-2"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $row['type']->icon(),'class' => 'h-4 w-4 text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row['type']->icon()),'class' => 'h-4 w-4 text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php echo e($row['type']->plural()); ?></span><span class="num font-semibold"><?php echo e($row['count']); ?></span></div>
                            <div class="meter mt-1.5"><span style="width: <?php echo e($row['count'] / $maxType * 100); ?>%"></span></div>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php if($byService->isNotEmpty()): ?>
                <h3 class="mt-6 text-sm font-semibold text-ink-2">Most requested clinics and tests</h3>
                <ul class="mt-2 divide-y divide-line text-sm">
                    <?php $__currentLoopData = $byService; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e(route('admin.submissions.index', ['type' => 'appointment', 'service' => $key])); ?>" class="flex min-h-11 items-center justify-between gap-3 hover:text-link"><span class="truncate"><?php echo e(\App\Models\Submission::serviceLabel($key)); ?></span><span class="num font-semibold"><?php echo e($total); ?></span></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </section>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-2">
        <section class="a-card min-w-0" aria-labelledby="queue-title">
            <div class="flex items-center justify-between gap-3 px-5 pb-1.5 pt-3.5"><h2 id="queue-title" class="font-semibold">Next to call (oldest new first)</h2><a class="inline-flex min-h-11 flex-none items-center text-sm text-link underline" href="<?php echo e(route('admin.submissions.index', ['status' => 'new'])); ?>">All new</a></div>
            <?php $__empty_1 = true; $__currentLoopData = $queue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('admin.submissions.show', $s)); ?>" class="flex items-center gap-3 border-t border-line px-5 py-3 hover:bg-surface-2">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $s->type->icon(),'class' => 'h-5 w-5 flex-none text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($s->type->icon()),'class' => 'h-5 w-5 flex-none text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                    <div class="min-w-0 flex-1"><p class="truncate font-semibold"><?php echo e($s->patientName()); ?><?php if($s->is_demo): ?> <span class="demo-badge ml-1">Demo</span><?php endif; ?></p><p class="truncate text-sm text-ink-3"><?php echo e($s->type->label()); ?><?php if($s->subject()): ?> · <?php echo e($s->subject()); ?><?php endif; ?></p></div>
                    <span class="chip num" data-tone="<?php echo e($s->isOverdue() ? 'critical' : 'neutral'); ?>"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'clock']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'clock']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php echo e($s->created_at->diffForHumans(null, true, true)); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="border-t border-line px-5 py-6 text-ink-3">Nothing new waiting. Well done.</p>
            <?php endif; ?>
        </section>
        <section class="a-card min-w-0" aria-labelledby="up-title">
            <div class="p-5 pb-3"><h2 id="up-title" class="font-semibold">Booked, today to <?php echo e(today()->addDays(2)->format('l')); ?></h2></div>
            <?php $__empty_1 = true; $__currentLoopData = $upcoming; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('admin.submissions.show', $s)); ?>" class="flex items-center gap-3 border-t border-line px-5 py-3 hover:bg-surface-2">
                    <div class="w-20 flex-none text-sm"><p class="font-semibold"><?php echo e($s->booked_date->isToday() ? 'Today' : $s->booked_date->format('D j')); ?></p><p class="num text-ink-3"><?php echo e($s->booked_time); ?></p></div>
                    <div class="min-w-0 flex-1"><p class="truncate font-semibold"><?php echo e($s->patientName()); ?></p><p class="truncate text-sm text-ink-3"><?php echo e($s->subject()); ?></p></div>
                    <?php if (isset($component)) { $__componentOriginal51ed764111e345fc11534f121cfeb451 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51ed764111e345fc11534f121cfeb451 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status','data' => ['status' => $s->status,'type' => $s->type]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($s->status),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($s->type)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $attributes = $__attributesOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__attributesOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $component = $__componentOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__componentOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="border-t border-line px-5 py-6 text-ink-3">Nothing booked in the next three days.</p>
            <?php endif; ?>
        </section>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $attributes = $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $component = $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>