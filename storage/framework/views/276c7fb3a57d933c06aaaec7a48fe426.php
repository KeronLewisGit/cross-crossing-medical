<?php
    $phones = (array) ccmc('phones');
    $depts = (array) ccmc('departments');
    $icons = ['accident-emergency' => 'ambulance', 'cardiac' => 'heart-pulse', 'dialysis' => 'droplet', 'laboratory' => 'flask', 'imaging' => 'scan', 'surgery' => 'scalpel', 'sleep-lung' => 'moon-wave', 'vaccinations' => 'syringe', 'dental' => 'tooth'];
?>
<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
    <section class="relative overflow-hidden">
        <div class="wrap grid gap-10 pb-10 pt-10 md:pt-14 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,1fr)] lg:items-center lg:gap-14 lg:pb-16 lg:pt-16">
            <div>
                <?php if (isset($component)) { $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sign','data' => ['code' => 'CCMC','label' => 'Oliver Avenue · San Fernando']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sign'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['code' => 'CCMC','label' => 'Oliver Avenue · San Fernando']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $attributes = $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $component = $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
                <h1 class="display-1 mt-6 max-w-[14ch]">Care around the clock in San&nbsp;Fernando.</h1>
                <p class="lead mt-5 text-ink-2">Physicians and a full nursing staff, an emergency room, a cardiac care unit, a dialysis unit, lab, X-ray and surgical suites, all in one building near Halliburton. Open 24 hours a day, 7 days a week, 365 days a year.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="<?php echo e(route('appointments')); ?>" class="btn btn-primary">Request an appointment<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'nudge h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'nudge h-4 w-4']); ?>
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
                    <a href="<?php echo e(route('new-patients')); ?>" class="btn btn-outline">Register as a new patient</a>
                </div>
                <dl class="mt-10 grid max-w-lg grid-cols-3 divide-x divide-line rounded-xl border border-line bg-surface">
                    <?php $__currentLoopData = ['24' => 'hours a day', '7' => 'days a week', '365' => 'days a year']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="px-4 py-3.5"><dt class="sr-only">Open</dt><dd><span class="font-display block text-3xl font-semibold tracking-tight text-link num"><?php echo e($n); ?></span><span class="text-sm font-semibold text-ink-3"><?php echo e($l); ?></span></dd></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </dl>
            </div>
            <div class="relative">
                <div class="frame-light">
                    <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => 'building','alt' => 'The front of Cross Crossing Medical Centre: a white building with blue tiled entrance canopy lettered CCMC','eager' => true,'sizes' => '(min-width: 1024px) 36rem, 100vw','class' => 'aspect-[3/2]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => 'building','alt' => 'The front of Cross Crossing Medical Centre: a white building with blue tiled entrance canopy lettered CCMC','eager' => true,'sizes' => '(min-width: 1024px) 36rem, 100vw','class' => 'aspect-[3/2]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $attributes = $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $component = $__componentOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
                </div>
                <a href="<?php echo e(route('department', 'accident-emergency')); ?>" class="absolute -bottom-5 left-4 right-4 flex items-center gap-3 ae-fill rounded-xl px-4 py-3 shadow-md sm:left-auto sm:right-6 sm:max-w-sm">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'ambulance','class' => 'h-6 w-6 flex-none']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'ambulance','class' => 'h-6 w-6 flex-none']); ?>
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
                    <span class="text-[0.9375rem] font-bold leading-snug">Emergency? No appointment needed. Come straight to A&amp;E, open 24 hours.</span>
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'h-5 w-5 flex-none']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'h-5 w-5 flex-none']); ?>
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
                </a>
            </div>
        </div>
        <?php if (isset($component)) { $__componentOriginalb010addd8d0ea019d1f5f2b79163d3e6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb010addd8d0ea019d1f5f2b79163d3e6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pulse-line','data' => ['draw' => true,'class' => 'text-[color:var(--pulse)]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pulse-line'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['draw' => true,'class' => 'text-[color:var(--pulse)]']); ?>
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

    
    <section class="wrap mt-14 grid gap-8 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,1fr)] lg:gap-12" aria-labelledby="dir-title" data-reveal>
        <div class="directory stucco on-sign shadow-md">
            <div class="flex items-center justify-between gap-3 px-5 pb-3 pt-5">
                <h2 id="dir-title" class="font-display text-[1.375rem] font-medium text-white">Where would you like to go?</h2>
                <span class="hidden text-xs font-bold uppercase tracking-[0.14em] text-white/60 sm:inline">Directory</span>
            </div>
            <a href="<?php echo e(route('department', 'accident-emergency')); ?>"><span class="dir-code ae">A&amp;E</span><span><span class="dir-name">Emergency room</span><span class="dir-note">Open 24 hours. Come straight in, no appointment.</span></span><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'dir-arrow']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'dir-arrow']); ?>
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
            <a href="<?php echo e(route('appointments')); ?>"><span class="dir-code">APPT</span><span><span class="dir-name">Clinic or test appointment</span><span class="dir-note">Pick the clinic and the days that suit you. We call back.</span></span><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'dir-arrow']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'dir-arrow']); ?>
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
            <a href="<?php echo e(route('new-patients')); ?>"><span class="dir-code">REG</span><span><span class="dir-name">New patient registration</span><span class="dir-note">Fill in your details before your first visit.</span></span><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'dir-arrow']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'dir-arrow']); ?>
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
            <a href="<?php echo e(route('department', 'dialysis')); ?>"><span class="dir-code">RD</span><span><span class="dir-name">Renal Centre &amp; Dialysis Unit</span><span class="dir-note">Ask about an initial dialysis examination.</span></span><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'dir-arrow']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'dir-arrow']); ?>
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
            <a href="<?php echo e(route('department', 'laboratory')); ?>"><span class="dir-code">LAB</span><span><span class="dir-name">Laboratory and X-ray</span><span class="dir-note">On site. Results are never put online.</span></span><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'dir-arrow']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'dir-arrow']); ?>
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
            <a href="<?php echo e(route('careers')); ?>"><span class="dir-code">HR</span><span><span class="dir-name">Careers</span><span class="dir-note">Nurses, technicians and support staff.</span></span><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'dir-arrow']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'dir-arrow']); ?>
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
        <div class="lg:pt-2">
            <?php if (isset($component)) { $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sign','data' => ['code' => 'APPT','label' => 'How a request works','arrow' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sign'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['code' => 'APPT','label' => 'How a request works','arrow' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $attributes = $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $component = $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
            <h2 class="display-3 mt-5">No more holding on the line to book.</h2>
            <p class="mt-3 text-ink-2">Send a request any time of day. The appointments team calls you back to agree a real day and time with the clinic.</p>
            <ol class="steps mt-7">
                <li><div><p class="font-bold">Choose the clinic or test</p><p class="text-ink-2">Cardiology, a bone density scan, an ECG, vaccinations and more.</p></div></li>
                <li><div><p class="font-bold">Tell us the days and time that suit you</p><p class="text-ink-2">Morning, afternoon or evening, and the earliest date.</p></div></li>
                <li><div><p class="font-bold">Get a reference number</p><p class="text-ink-2">On screen straight away, and by email if you give one.</p></div></li>
                <li><div><p class="font-bold">We call you back</p><p class="text-ink-2">The appointment is booked once you have agreed a time with us.</p></div></li>
            </ol>
            <div class="ae-note mt-8"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'alert','class' => 'h-5 w-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'alert','class' => 'h-5 w-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><p class="text-[0.9375rem]"><strong>Forms are not for emergencies.</strong> If you are unwell now, come to our emergency room or call <?php echo e(ccmc('ambulance')); ?> for an ambulance.</p></div>
        </div>
    </section>

    
    <section class="wrap mt-24" aria-labelledby="dept-title">
        <div class="flex flex-wrap items-end justify-between gap-4" data-reveal>
            <div>
                <?php if (isset($component)) { $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sign','data' => ['code' => '01','label' => 'Departments','arrow' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sign'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['code' => '01','label' => 'Departments','arrow' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $attributes = $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $component = $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
                <h2 id="dept-title" class="display-2 mt-5">Everything under one roof</h2>
                <p class="lead mt-3 text-ink-2">"With all facilities within one location, you don't need to go anywhere else."</p>
            </div>
            <a href="<?php echo e(route('services')); ?>" class="btn btn-outline">All services<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'nudge h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'nudge h-4 w-4']); ?>
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
        <ul class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = $depts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="card-link plate p-5" data-reveal style="--reveal-delay: <?php echo e($loop->index * 40); ?>ms">
                    <div class="flex items-center justify-between gap-3">
                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['plate-code', 'ae' => $d['emergency'] ?? false]); ?>"><?php echo e($d['code']); ?></span>
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $icons[$slug] ?? 'activity','class' => 'h-6 w-6 text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icons[$slug] ?? 'activity'),'class' => 'h-6 w-6 text-ink-3']); ?>
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
                    </div>
                    <h3 class="mt-4 text-[1.1875rem] font-medium"><a href="<?php echo e(route('department', $slug)); ?>" class="stretch"><?php echo e($d['name']); ?></a></h3>
                    <p class="mt-1.5 text-ink-2"><?php echo e($d['short']); ?></p>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </section>

    
    <section class="mt-24 bg-surface py-20" aria-labelledby="tests-title">
        <div class="wrap grid gap-12 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.1fr)] lg:gap-16">
            <div data-reveal>
                <?php if (isset($component)) { $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sign','data' => ['code' => '02','label' => 'Tests and scans','arrow' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sign'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['code' => '02','label' => 'Tests and scans','arrow' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $attributes = $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $component = $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
                <h2 id="tests-title" class="display-2 mt-5">Tests done on site</h2>
                <p class="mt-4 text-ink-2 measure">The tests and scans the centre offers, from its own list of services. Request any of them online; we call back with a time.</p>
                <ul class="mt-8 grid gap-x-6 sm:grid-cols-2">
                    <?php $__currentLoopData = (array) ccmc('tests'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(in_array($key, ['vaccination', 'minor-surgery'], true)) continue; ?>
                        <li class="border-b border-line"><a href="<?php echo e(route('appointments', ['service' => $key])); ?>" class="flex min-h-12 items-center justify-between gap-3 py-2 font-semibold hover:text-link"><?php echo e($label); ?><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'h-4 w-4 flex-none text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'h-4 w-4 flex-none text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="grid content-start gap-6" data-reveal>
                <div class="frame-light"><?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => 'cardiac','alt' => 'A patient monitor showing ECG, oxygen and blood pressure traces','sizes' => '(min-width: 1024px) 40rem, 100vw','class' => 'aspect-[16/9]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => 'cardiac','alt' => 'A patient monitor showing ECG, oxygen and blood pressure traces','sizes' => '(min-width: 1024px) 40rem, 100vw','class' => 'aspect-[16/9]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $attributes = $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $component = $__componentOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?></div>
                <div class="rounded-2xl border border-line p-6">
                    <h3 class="text-[1.1875rem] font-medium">Specialist clinics</h3>
                    <p class="mt-1 text-ink-2">"We have many specialist physicians for most medical needs."</p>
                    <ul class="mt-5 flex flex-wrap gap-2">
                        <?php $__currentLoopData = (array) ccmc('clinics'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(route('appointments', ['service' => $key])); ?>" class="tag"><?php echo e(\Illuminate\Support\Str::before($label, ' (')); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    
    <section class="wrap mt-24 grid items-center gap-10 md:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)] lg:gap-16" aria-labelledby="reg-title">
        <div class="grid grid-cols-2 gap-4" data-reveal>
            <div class="frame-light"><?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => 'reception','alt' => 'Reception desk and red waiting-room chairs','sizes' => '(min-width: 768px) 20vw, 50vw','class' => 'aspect-[2/3]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => 'reception','alt' => 'Reception desk and red waiting-room chairs','sizes' => '(min-width: 768px) 20vw, 50vw','class' => 'aspect-[2/3]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $attributes = $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $component = $__componentOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?></div>
            <div class="frame-light mt-10"><?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => 'lab-coat','alt' => 'A white coat with the CCMC logo in front of framed certificates','sizes' => '(min-width: 768px) 20vw, 50vw','class' => 'aspect-[2/3]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => 'lab-coat','alt' => 'A white coat with the CCMC logo in front of framed certificates','sizes' => '(min-width: 768px) 20vw, 50vw','class' => 'aspect-[2/3]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $attributes = $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $component = $__componentOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?></div>
        </div>
        <div data-reveal>
            <?php if (isset($component)) { $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sign','data' => ['code' => 'REG','label' => 'New patients','arrow' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sign'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['code' => 'REG','label' => 'New patients','arrow' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $attributes = $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $component = $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
            <h2 id="reg-title" class="display-2 mt-5">Register before your first visit</h2>
            <p class="lead mt-4 text-ink-2">Fill in the patient's details at home, so your first visit starts with care, not paperwork.</p>
            <ul class="check-list mt-6">
                <li><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'check-circle']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'check-circle']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Patient details, emergency contact and insurer in one short form</li>
                <li><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'check-circle']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'check-circle']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Add a photo of your ID and insurance card from your phone, or bring them in</li>
                <li><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'lock']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'lock']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Documents are kept off the public website and opened only by the registration team</li>
                <li><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'shield']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'shield']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Your consent is recorded, as the Data Protection Act requires</li>
            </ul>
            <a href="<?php echo e(route('new-patients')); ?>" class="btn btn-primary mt-8">Start registration<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'nudge h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'nudge h-4 w-4']); ?>
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
    </section>

    
    <section class="mt-24" aria-labelledby="rd-title">
        <div class="stucco on-sign text-white">
            <div class="wrap grid items-center gap-10 py-16 md:grid-cols-2 lg:gap-16 lg:py-20">
                <div data-reveal>
                    <?php if (isset($component)) { $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sign','data' => ['code' => 'RD','label' => 'Renal Centre & Dialysis Unit','arrow' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sign'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['code' => 'RD','label' => 'Renal Centre & Dialysis Unit','arrow' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $attributes = $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $component = $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
                    <h2 id="rd-title" class="display-2 mt-5">A dedicated dialysis unit</h2>
                    <p class="lead mt-4 text-white/85">New patients start with an initial dialysis examination and review by our physicians. Send an enquiry and the unit will call you to arrange it.</p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="<?php echo e(route('department', 'dialysis')); ?>#enquire" class="btn btn-brass">Send a dialysis enquiry<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'nudge h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'nudge h-4 w-4']); ?>
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
                        <a href="<?php echo e(route('department', 'dialysis')); ?>" class="btn btn-on-sign">About the unit</a>
                    </div>
                </div>
                <div class="grid grid-cols-[1.2fr_1fr] gap-4" data-reveal>
                    <div class="frame"><?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => 'renal-sign','alt' => 'The blue Renal Centre & Dialysis Unit sign at the centre','sizes' => '(min-width: 768px) 25vw, 55vw','class' => 'aspect-[4/3]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => 'renal-sign','alt' => 'The blue Renal Centre & Dialysis Unit sign at the centre','sizes' => '(min-width: 768px) 25vw, 55vw','class' => 'aspect-[4/3]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $attributes = $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $component = $__componentOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?></div>
                    <div class="frame mt-12"><?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => 'dialysis','alt' => 'A haemodialysis machine beside a reclining treatment chair (illustrative)','sizes' => '(min-width: 768px) 20vw, 45vw','class' => 'aspect-[4/5]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => 'dialysis','alt' => 'A haemodialysis machine beside a reclining treatment chair (illustrative)','sizes' => '(min-width: 768px) 20vw, 45vw','class' => 'aspect-[4/5]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $attributes = $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $component = $__componentOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?></div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="wrap mt-24 grid gap-6 lg:grid-cols-2" aria-label="Patient corner and careers">
        <article class="card-link panel overflow-hidden" data-reveal>
            <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => 'consultation','alt' => 'A doctor\'s hands holding a stethoscope','sizes' => '(min-width: 1024px) 40vw, 100vw','class' => 'card-img aspect-[2/1]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => 'consultation','alt' => 'A doctor\'s hands holding a stethoscope','sizes' => '(min-width: 1024px) 40vw, 100vw','class' => 'card-img aspect-[2/1]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $attributes = $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $component = $__componentOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
            <div class="p-6 md:p-8">
                <?php if (isset($component)) { $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sign','data' => ['code' => 'PC','label' => 'Patient corner','arrow' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sign'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['code' => 'PC','label' => 'Patient corner','arrow' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $attributes = $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $component = $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
                <h2 class="display-3 mt-4"><a href="<?php echo e(route('handouts')); ?>" class="stretch">Handouts and self-checks</a></h2>
                <p class="mt-2 text-ink-2">Blood pressure, diabetes and bone-health handouts, vaccination information, and quick checks for diabetes risk, BMI and fracture risk.</p>
                <p class="mt-5 inline-flex items-center gap-2 font-bold text-link">Open the patient corner<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?></p>
            </div>
        </article>
        <article class="card-link panel overflow-hidden" data-reveal style="--reveal-delay: 80ms">
            <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => 'nursing','alt' => 'A smiling Caribbean nurse in a white uniform on a hospital ward','sizes' => '(min-width: 1024px) 40vw, 100vw','class' => 'card-img aspect-[2/1]','position' => 'center 30%']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => 'nursing','alt' => 'A smiling Caribbean nurse in a white uniform on a hospital ward','sizes' => '(min-width: 1024px) 40vw, 100vw','class' => 'card-img aspect-[2/1]','position' => 'center 30%']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $attributes = $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $component = $__componentOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
            <div class="p-6 md:p-8">
                <?php if (isset($component)) { $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sign','data' => ['code' => 'HR','label' => 'Careers','arrow' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sign'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['code' => 'HR','label' => 'Careers','arrow' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $attributes = $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $component = $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
                <h2 class="display-3 mt-4"><a href="<?php echo e(route('careers')); ?>" class="stretch">Work at a 24-hour centre</a></h2>
                <p class="mt-2 text-ink-2">Nurses, dialysis and lab technicians, radiographers and support staff. <?php echo e($openJobs ? $openJobs.' '.\Illuminate\Support\Str::plural('vacancy', $openJobs).' open now' : 'Send your CV for future openings'); ?>.</p>
                <p class="mt-5 inline-flex items-center gap-2 font-bold text-link">See careers<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?></p>
            </div>
        </article>
    </section>

    
    <section class="wrap mt-24" aria-labelledby="visit-title">
        <div class="overflow-hidden rounded-2xl border border-line bg-surface lg:grid lg:grid-cols-[1.1fr_1fr]">
            <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => 'san-fernando','alt' => 'San Fernando from the air, with San Fernando Hill and the waterfront','sizes' => '(min-width: 1024px) 45vw, 100vw','class' => 'aspect-[16/9] lg:aspect-auto lg:h-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => 'san-fernando','alt' => 'San Fernando from the air, with San Fernando Hill and the waterfront','sizes' => '(min-width: 1024px) 45vw, 100vw','class' => 'aspect-[16/9] lg:aspect-auto lg:h-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $attributes = $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $component = $__componentOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
            <div class="p-6 md:p-10" data-reveal>
                <?php if (isset($component)) { $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sign','data' => ['code' => 'MAP','label' => 'Find us','arrow' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sign'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['code' => 'MAP','label' => 'Find us','arrow' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $attributes = $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $component = $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
                <h2 id="visit-title" class="display-3 mt-4">Oliver Avenue, Cross Crossing</h2>
                <p class="mt-2 text-ink-2">Near Halliburton, in the suburban area of San Fernando.</p>
                <dl class="mt-6 space-y-3">
                    <div class="flex gap-3"><dt><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'phone','class' => 'mt-0.5 h-5 w-5 text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'phone','class' => 'mt-0.5 h-5 w-5 text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><span class="sr-only">Phone</span></dt><dd class="font-semibold"><?php $__currentLoopData = $phones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><a href="<?php echo e(tel_href($p)); ?>" class="inline-flex min-h-11 items-center underline-offset-4 hover:underline"><?php echo e(format_phone($p)); ?></a><?php if(! $loop->last): ?><span class="px-2 text-ink-3">or</span><?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></dd></div>
                    <div class="flex gap-3"><dt><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'mail','class' => 'mt-0.5 h-5 w-5 text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'mail','class' => 'mt-0.5 h-5 w-5 text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><span class="sr-only">Email</span></dt><dd><a href="mailto:<?php echo e(ccmc('email')); ?>" class="inline-flex min-h-11 items-center font-semibold underline-offset-4 hover:underline"><?php echo e(ccmc('email')); ?></a></dd></div>
                    <div class="flex gap-3"><dt><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'clock','class' => 'mt-0.5 h-5 w-5 text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'clock','class' => 'mt-0.5 h-5 w-5 text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><span class="sr-only">Hours</span></dt><dd class="font-semibold">Open 24 hours, every day of the year</dd></div>
                </dl>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="<?php echo e(ccmc('map_url')); ?>" class="btn btn-primary" rel="noopener" target="_blank"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'map-pin','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'map-pin','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Get directions<span class="sr-only">(opens Google Maps)</span></a>
                    <a href="<?php echo e(route('contact')); ?>" class="btn btn-outline">Contact and map</a>
                </div>
            </div>
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e)): ?>
<?php $attributes = $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e; ?>
<?php unset($__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfefb4fd9b7004fa65f70c415ac76903e)): ?>
<?php $component = $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e; ?>
<?php unset($__componentOriginalfefb4fd9b7004fa65f70c415ac76903e); ?>
<?php endif; ?>
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/pages/home.blade.php ENDPATH**/ ?>