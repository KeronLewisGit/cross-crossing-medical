<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Careers: nursing, technical and support roles','description' => 'Work at Cross Crossing Medical Centre, a 24-hour medical centre in San Fernando. Vacancies for nurses, dialysis and lab technicians, radiographers and support staff.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Careers: nursing, technical and support roles','description' => 'Work at Cross Crossing Medical Centre, a 24-hour medical centre in San Fernando. Vacancies for nurses, dialysis and lab technicians, radiographers and support staff.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Careers at CCMC','lead' => 'A 24-hour centre needs people around the clock: nurses, dialysis and lab technicians, radiographers, and the reception and records team who keep it running.','code' => 'HR','label' => 'Careers','photo' => 'nursing','photoAlt' => 'A smiling nurse in a white uniform on a Caribbean hospital ward','position' => 'center 30%']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Careers at CCMC','lead' => 'A 24-hour centre needs people around the clock: nurses, dialysis and lab technicians, radiographers, and the reception and records team who keep it running.','code' => 'HR','label' => 'Careers','photo' => 'nursing','photo-alt' => 'A smiling nurse in a white uniform on a Caribbean hospital ward','position' => 'center 30%']); ?>
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
        <section aria-labelledby="open-title">
            <h2 id="open-title" class="display-3">Open vacancies</h2>
            <?php if($jobs->isEmpty()): ?>
                <div class="panel mt-6 p-6">
                    <p class="font-semibold">There are no advertised vacancies right now.</p>
                    <p class="mt-1 text-ink-2">Send your CV anyway. The HR team keeps applications on file for six months and calls when something suitable opens.</p>
                </div>
            <?php else: ?>
                <ul class="mt-6 space-y-4">
                    <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="card-link plate p-5 md:p-6">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="code-chip"><?php echo e(strtoupper(\Illuminate\Support\Str::limit($job->department, 12, ''))); ?></span>
                                <span class="tag"><?php echo e($job->employmentLabel()); ?></span>
                                <?php if($job->closes_on): ?><span class="text-sm text-ink-3">Closes <?php echo e($job->closes_on->format('j M Y')); ?></span><?php endif; ?>
                                <?php if($job->is_demo): ?><span class="demo-badge">Demo</span><?php endif; ?>
                            </div>
                            <h3 class="mt-3 text-[1.25rem] font-medium"><a href="<?php echo e(route('careers.show', $job)); ?>" class="stretch"><?php echo e($job->title); ?></a></h3>
                            <p class="mt-1.5 text-ink-2"><?php echo e($job->summary); ?></p>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
            <a href="<?php echo e(route('careers.apply')); ?>" class="btn btn-primary mt-8">Send a general application<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
        </section>

        <aside class="space-y-6">
            <div class="panel p-6">
                <h2 class="font-display text-lg font-medium">How to apply</h2>
                <ol class="steps mt-5 text-[0.9375rem]">
                    <li><p>Choose a vacancy, or send a general application for the kind of role you do.</p></li>
                    <li><p>Attach your CV (PDF or Word) and up to three certificates or licences.</p></li>
                    <li><p>You get a reference number by email. HR reviews every application and contacts shortlisted applicants.</p></li>
                </ol>
            </div>
            <div class="panel p-6">
                <h2 class="font-display text-lg font-medium">Who we look for</h2>
                <ul class="mt-4 flex flex-wrap gap-2">
                    <?php $__currentLoopData = (array) ccmc('career_roles'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($k === 'other') continue; ?>
                        <li><a class="tag" href="<?php echo e(route('careers.apply', ['role' => $k])); ?>"><?php echo e($label); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <p class="text-sm text-ink-3">Your application is kept privately and seen only by the HR team. See the <a href="<?php echo e(route('privacy')); ?>" class="text-link">privacy notice</a>.</p>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/pages/careers/index.blade.php ENDPATH**/ ?>