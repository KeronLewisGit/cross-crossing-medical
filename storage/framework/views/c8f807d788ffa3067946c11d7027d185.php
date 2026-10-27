<?php
    $phones = (array) ccmc('phones');
    $book = ['cardiac' => 'cardiology', 'laboratory' => 'lab', 'imaging' => 'xray', 'sleep-lung' => 'sleep-study', 'vaccinations' => 'vaccination', 'surgery' => 'minor-surgery'][$slug] ?? null;
    $isAe = (bool) ($dept['emergency'] ?? false);
    $jsonLd = [[
        '@context' => 'https://schema.org', '@type' => 'MedicalWebPage', 'name' => $dept['name'].' · '.ccmc('name'),
        'about' => ['@type' => 'MedicalSpecialty', 'name' => $dept['name']], 'url' => route('department', $slug),
    ]];
?>
<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => $dept['name'],'description' => $dept['short'].' Cross Crossing Medical Centre, Oliver Avenue, San Fernando. Open 24 hours.','jsonLd' => $jsonLd,'ogImage' => $dept['photo']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dept['name']),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dept['short'].' Cross Crossing Medical Centre, Oliver Avenue, San Fernando. Open 24 hours.'),'json-ld' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($jsonLd),'og-image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dept['photo'])]); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => $dept['name'],'lead' => $dept['short'],'code' => $dept['code'],'label' => 'Services','photo' => $dept['photo'],'ae' => $isAe]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dept['name']),'lead' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dept['short']),'code' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dept['code']),'label' => 'Services','photo' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dept['photo']),'ae' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isAe)]); ?>
        <nav class="mt-6 text-sm text-white/80" aria-label="Breadcrumb"><a href="<?php echo e(route('services')); ?>" class="inline-flex min-h-11 items-center underline underline-offset-2 hover:text-white">All services</a> <span aria-hidden="true" class="px-1">/</span> <span aria-current="page"><?php echo e($dept['name']); ?></span></nav>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

    <?php if($isAe): ?>
        <section class="ae-fill">
            <div class="wrap flex flex-col gap-4 py-6 md:flex-row md:items-center md:justify-between">
                <p class="font-display text-xl font-medium">Emergency? Do not fill in a form. Come straight in, or call <?php echo e(ccmc('ambulance')); ?> for an ambulance.</p>
                <a href="<?php echo e(tel_href($phones[0] ?? '')); ?>" class="btn flex-none bg-white text-[#8f1a13] hover:bg-white/90"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'phone','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'phone','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Call ahead <?php echo e(format_phone($phones[0] ?? '')); ?></a>
            </div>
        </section>
    <?php endif; ?>

    <div class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1.35fr)_minmax(0,1fr)] lg:gap-16">
        <div>
            <div class="prose-copy measure text-lg">
                <?php $__currentLoopData = $dept['body']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($p); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <h2 class="display-3 mt-12">At a glance</h2>
            <ul class="check-list mt-5 measure">
                <?php $__currentLoopData = $dept['points']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?><?php echo e($pt); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <?php if($slug === 'laboratory'): ?>
                <div class="mt-10 rounded-2xl border border-line bg-surface p-6" id="results">
                    <h2 class="flex items-center gap-2.5 font-display text-xl font-medium"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'lock','class' => 'h-5 w-5 text-link']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'lock','class' => 'h-5 w-5 text-link']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Your results</h2>
                    <p class="mt-2 text-ink-2 measure">Test results are private, so they are never shown on this website and are not sent by email. When your results are ready, the centre will let you know. Call the lab on <a class="text-link font-bold" href="<?php echo e(tel_href($phones[0] ?? '')); ?>"><?php echo e(format_phone($phones[0] ?? '')); ?></a> to check whether they are ready to collect, and bring photo ID when you come.</p>
                </div>
            <?php endif; ?>

            <?php if($slug === 'dental'): ?>
                <div class="mt-10 rounded-2xl border border-line bg-surface p-6">
                    <h2 class="font-display text-xl font-medium"><?php echo e($dept['partner']); ?></h2>
                    <p class="mt-2 text-ink-2">Call to set up an appointment:</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <?php $__currentLoopData = $dept['phones']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><a href="<?php echo e(tel_href($p)); ?>" class="btn btn-primary"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'phone','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'phone','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php echo e(format_phone($p)); ?></a><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <p class="mt-5 text-ink-2">For a dental emergency at any hour, call <a class="text-link font-bold" href="<?php echo e(tel_href($phones[0] ?? '')); ?>"><?php echo e(format_phone($phones[0] ?? '')); ?></a> for the emergency room.</p>
                </div>
            <?php endif; ?>

            <?php if($slug === 'vaccinations'): ?>
                <div class="mt-10 prose-copy measure">
                    <h2>How immunisations work</h2>
                    <p>Immunisations expose you to a very small, very safe amount of a virus or bacteria that has been weakened or killed. Your immune system then learns to recognise and attack the infection if you meet it later in life.</p>
                    <p>For a few weeks after birth, babies have some protection passed on from their mother. That natural protection soon goes away, which is why the childhood schedule matters.</p>
                    <p>Read more in the <a href="<?php echo e(route('handouts')); ?>">patient handouts library</a>.</p>
                </div>
            <?php endif; ?>
        </div>

        <aside class="space-y-6">
            <?php if(! empty($dept['photo2'])): ?>
                <figure class="frame-light">
                    <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => $dept['photo2'],'alt' => (config('photo-credits.'.$dept['photo2'].'.own') ? '' : 'Illustrative photo: ').config('photo-credits.'.$dept['photo2'].'.title'),'sizes' => '(min-width: 1024px) 28rem, 100vw','class' => 'aspect-[4/3]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dept['photo2']),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((config('photo-credits.'.$dept['photo2'].'.own') ? '' : 'Illustrative photo: ').config('photo-credits.'.$dept['photo2'].'.title')),'sizes' => '(min-width: 1024px) 28rem, 100vw','class' => 'aspect-[4/3]']); ?>
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
                </figure>
            <?php endif; ?>
            <div class="panel p-6">
                <?php if($isAe): ?>
                    <h2 class="font-display text-lg font-medium">Open now</h2>
                    <p class="mt-2 flex items-center gap-2.5 font-bold"><span class="live-dot" aria-hidden="true"></span>24 hours, 7 days, 365 days</p>
                    <p class="mt-3 text-ink-2">Oliver Avenue, Cross Crossing, San Fernando, near Halliburton.</p>
                    <a href="<?php echo e(ccmc('map_url')); ?>" class="btn btn-outline mt-5 w-full" rel="noopener" target="_blank"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?>Directions<span class="sr-only">(opens Google Maps)</span></a>
                <?php elseif($slug === 'dialysis'): ?>
                    <h2 class="font-display text-lg font-medium">New to the unit?</h2>
                    <p class="mt-2 text-ink-2">Start with an initial dialysis examination and review by our physicians.</p>
                    <a href="#enquire" class="btn btn-primary mt-5 w-full">Send an enquiry</a>
                <?php elseif($slug === 'dental'): ?>
                    <h2 class="font-display text-lg font-medium">Dental emergency?</h2>
                    <p class="mt-2 text-ink-2">Emergency dental care is available 24 hours through the emergency room.</p>
                    <a href="<?php echo e(tel_href($phones[0] ?? '')); ?>" class="btn btn-primary mt-5 w-full"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'phone','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'phone','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php echo e(format_phone($phones[0] ?? '')); ?></a>
                <?php else: ?>
                    <h2 class="font-display text-lg font-medium">Book with us</h2>
                    <p class="mt-2 text-ink-2">Send a request with the days that suit you, and we will call you back to agree a time.</p>
                    <a href="<?php echo e(route('appointments', array_filter(['service' => $book]))); ?>" class="btn btn-primary mt-5 w-full">Request an appointment</a>
                    <a href="<?php echo e(tel_href($phones[0] ?? '')); ?>" class="btn btn-outline mt-3 w-full"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'phone','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'phone','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php echo e(format_phone($phones[0] ?? '')); ?></a>
                <?php endif; ?>
            </div>
        </aside>
    </div>

    <?php if($slug === 'dialysis'): ?>
        <?php echo $__env->make('pages.forms.dialysis', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <section class="wrap mt-20" aria-labelledby="other">
        <h2 id="other" class="display-3">Other departments</h2>
        <ul class="mt-6 flex flex-wrap gap-2">
            <?php $__currentLoopData = (array) ccmc('departments'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($s === $slug) continue; ?>
                <li><a href="<?php echo e(route('department', $s)); ?>" class="tag"><span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['code-chip', 'ae' => $d['emergency'] ?? false]); ?>"><?php echo e($d['code']); ?></span><?php echo e($d['name']); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/pages/services/show.blade.php ENDPATH**/ ?>