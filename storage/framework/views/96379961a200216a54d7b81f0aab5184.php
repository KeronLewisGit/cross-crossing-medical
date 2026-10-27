<?php
    $jsonLd = [[
        '@context' => 'https://schema.org', '@type' => 'JobPosting', 'title' => $job->title,
        'description' => e($job->summary), 'datePosted' => $job->created_at?->toDateString(),
        'validThrough' => $job->closes_on?->toDateString(),
        'employmentType' => strtoupper(str_replace('-', '_', $job->employment)),
        'hiringOrganization' => ['@type' => 'MedicalOrganization', 'name' => ccmc('name'), 'sameAs' => route('home')],
        'jobLocation' => ['@type' => 'Place', 'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'Oliver Avenue, Cross Crossing', 'addressLocality' => 'San Fernando', 'addressCountry' => 'TT']],
    ]];
?>
<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => $job->title,'description' => $job->summary,'jsonLd' => $job->isOpen() ? $jsonLd : []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($job->title),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($job->summary),'json-ld' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($job->isOpen() ? $jsonLd : [])]); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => $job->title,'lead' => $job->summary,'code' => 'HR','label' => $job->department]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($job->title),'lead' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($job->summary),'code' => 'HR','label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($job->department)]); ?>
        <div class="mt-5 flex flex-wrap items-center gap-2 text-sm">
            <span class="tag !bg-white/10 !text-white !ring-white/30"><?php echo e($job->employmentLabel()); ?></span>
            <?php if($job->closes_on): ?><span class="text-white/85">Closes <?php echo e($job->closes_on->format('j F Y')); ?></span><?php endif; ?>
            <?php if($job->is_demo): ?><span class="demo-badge">Demo vacancy</span><?php endif; ?>
        </div>
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
    <div class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)] lg:gap-16">
        <div class="space-y-10">
            <?php if (! ($job->isOpen())): ?>
                <p class="rounded-xl bg-soft p-4 font-semibold">This vacancy has closed. You can still send a general application.</p>
            <?php endif; ?>
            <?php $__currentLoopData = ['duties' => 'What you will do', 'requirements' => 'What you need']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $heading): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($job->lines($field)): ?>
                    <section>
                        <h2 class="display-3"><?php echo e($heading); ?></h2>
                        <ul class="check-list mt-5 measure">
                            <?php $__currentLoopData = $job->lines($field); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?><?php echo e($line); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </section>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <aside>
            <div class="panel p-6 lg:sticky lg:top-28">
                <h2 class="font-display text-lg font-medium">Apply for this role</h2>
                <p class="mt-2 text-ink-2">Have your CV ready as a PDF or Word file. It takes about three minutes.</p>
                <a href="<?php echo e($job->isOpen() ? route('careers.apply', ['job' => $job->slug]) : route('careers.apply')); ?>" class="btn btn-primary mt-5 w-full"><?php echo e($job->isOpen() ? 'Apply now' : 'Send a general application'); ?></a>
                <a href="<?php echo e(route('careers')); ?>" class="btn btn-outline mt-3 w-full">All vacancies</a>
            </div>
        </aside>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/pages/careers/show.blade.php ENDPATH**/ ?>