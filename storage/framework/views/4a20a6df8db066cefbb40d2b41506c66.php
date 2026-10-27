<?php ($cats = \App\Models\Handout::CATEGORIES); ?>
<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Patient handouts','description' => 'Free patient handouts from Cross Crossing Medical Centre: blood pressure, diabetes, bone health, vaccinations and more.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Patient handouts','description' => 'Free patient handouts from Cross Crossing Medical Centre: blood pressure, diabetes, bone health, vaccinations and more.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Patient handouts','lead' => 'Plain-language information to read at home or take to your appointment. These do not replace advice from your own doctor.','code' => 'PC','label' => 'Patient corner']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Patient handouts','lead' => 'Plain-language information to read at home or take to your appointment. These do not replace advice from your own doctor.','code' => 'PC','label' => 'Patient corner']); ?>
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

    <div class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[14rem_minmax(0,1fr)] lg:gap-16">
        <nav aria-label="Handout topics" class="lg:sticky lg:top-28 lg:self-start">
            <p class="kicker text-ink-3">Topics</p>
            <ul class="mt-3 flex flex-wrap gap-2 lg:flex-col lg:gap-0">
                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat => $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="#<?php echo e($cat); ?>" class="tag lg:!rounded-none lg:!bg-transparent lg:!px-0 lg:!ring-0 lg:min-h-11 lg:font-bold"><?php echo e($cats[$cat] ?? ucfirst($cat)); ?> <span class="text-ink-3">(<?php echo e($list->count()); ?>)</span></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <li><a href="<?php echo e(route('health-checks')); ?>" class="tag lg:!rounded-none lg:!bg-transparent lg:!px-0 lg:!ring-0 lg:min-h-11 lg:font-bold">Health self-checks</a></li>
            </ul>
        </nav>
        <div class="space-y-14">
            <?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat => $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <section id="<?php echo e($cat); ?>" aria-labelledby="h-<?php echo e($cat); ?>" class="scroll-mt-28">
                    <h2 id="h-<?php echo e($cat); ?>" class="display-3"><?php echo e($cats[$cat] ?? ucfirst($cat)); ?></h2>
                    <ul class="mt-5 grid gap-4 md:grid-cols-2">
                        <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="card-link plate p-5">
                                <div class="flex items-start gap-3">
                                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $h->isExternal() ? 'external' : 'book','class' => 'mt-0.5 h-5 w-5 flex-none text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($h->isExternal() ? 'external' : 'book'),'class' => 'mt-0.5 h-5 w-5 flex-none text-ink-3']); ?>
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
                                    <div>
                                        <h3 class="text-[1.0625rem] font-bold"><a href="<?php echo e($h->href()); ?>" class="stretch" <?php if($h->isExternal()): ?> rel="noopener" target="_blank" <?php endif; ?>><?php echo e($h->title); ?></a></h3>
                                        <?php if($h->summary): ?><p class="mt-1 text-[0.9375rem] text-ink-2"><?php echo e($h->summary); ?></p><?php endif; ?>
                                        <p class="mt-2 text-sm text-ink-3"><?php echo e($h->publisher ?: ccmc('name')); ?> · <?php echo e($h->isExternal() ? 'Opens '.$h->host() : 'PDF'.($h->file_size ? ', '.number_format($h->file_size / 1024).' KB' : '')); ?><?php if($h->isExternal()): ?><span class="sr-only"> (opens in a new tab)</span><?php endif; ?></p>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </section>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="panel p-6">Handouts are being added. Ask at reception for printed copies.</p>
            <?php endif; ?>
        </div>
    </div>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/pages/handouts.blade.php ENDPATH**/ ?>