<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Health self-checks','description' => 'Quick health self-checks: diabetes risk, body mass index (BMI) and fracture risk, with the tests Cross Crossing Medical Centre can do to follow up.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Health self-checks','description' => 'Quick health self-checks: diabetes risk, body mass index (BMI) and fracture risk, with the tests Cross Crossing Medical Centre can do to follow up.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Health self-checks','lead' => 'A few quick checks you can do at home. They are a starting point for a conversation with your doctor, never a diagnosis.','code' => 'PC','label' => 'Patient corner']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Health self-checks','lead' => 'A few quick checks you can do at home. They are a starting point for a conversation with your doctor, never a diagnosis.','code' => 'PC','label' => 'Patient corner']); ?>
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

    <div class="wrap mt-12 grid gap-8 md:mt-16 lg:grid-cols-2">
        <section class="panel p-6 md:p-8" id="bmi" aria-labelledby="bmi-title">
            <h2 id="bmi-title" class="display-3">Body mass index (BMI)</h2>
            <p class="mt-2 text-ink-2">BMI compares weight with height. It is a rough guide: it can't tell muscle from fat.</p>
            <form method="GET" action="<?php echo e(route('health-checks')); ?>#bmi" class="mt-6 grid gap-5 sm:grid-cols-[1fr_1fr_auto] sm:items-end">
                <div><label for="height" class="label">Height (cm)</label><input id="height" name="height" type="number" inputmode="decimal" min="50" max="250" step="0.1" value="<?php echo e($input['height']); ?>" class="input" required></div>
                <div><label for="weight" class="label">Weight (kg)</label><input id="weight" name="weight" type="number" inputmode="decimal" min="2" max="400" step="0.1" value="<?php echo e($input['weight']); ?>" class="input" required></div>
                <button class="btn btn-primary">Work it out</button>
            </form>
            <div aria-live="polite">
                <?php if($bmi !== null): ?>
                    <div class="mt-6 rounded-xl bg-soft p-5">
                        <p class="text-ink-2">Your BMI is</p>
                        <p class="font-display text-4xl font-semibold text-link num"><?php echo e(number_format($bmi, 1)); ?></p>
                        <p class="mt-1 font-semibold">That is <?php echo e($band); ?> for adults (18.5 to 24.9 is the healthy range).</p>
                        <p class="mt-3 text-[0.9375rem] text-ink-2">For a fuller picture, a <a class="text-link" href="<?php echo e(route('appointments', ['service' => 'body-composition'])); ?>">DEXA body composition analysis</a> measures fat, muscle and bone directly.</p>
                    </div>
                <?php elseif($tried): ?>
                    <p class="error mt-4">Enter a height between 50 and 250 cm and a weight between 2 and 400 kg.</p>
                <?php endif; ?>
            </div>
            <p class="mt-5 text-sm text-ink-3">BMI bands for adults over 18 only. Children's BMI is read from growth charts; ask at the paediatric clinic.</p>
        </section>

        <div class="space-y-8">
            <?php $__currentLoopData = (array) ccmc('self_checks'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <section class="panel p-6 md:p-8">
                    <h2 class="display-3"><?php echo e($c['title']); ?></h2>
                    <p class="mt-2 text-ink-2"><?php echo e($c['body']); ?></p>
                    <a href="<?php echo e($c['url']); ?>" class="btn btn-outline mt-5" rel="noopener" target="_blank">Take the check<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'external','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'external','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><span class="sr-only">(opens <?php echo e($c['source']); ?> in a new tab)</span></a>
                    <p class="mt-3 text-sm text-ink-3">Hosted by the <?php echo e($c['source']); ?>.</p>
                </section>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <section class="panel p-6 md:p-8">
                <h2 class="display-3">Follow-up tests at CCMC</h2>
                <ul class="mt-4 flex flex-wrap gap-2">
                    <?php $__currentLoopData = ['dexa', 'body-composition', 'lab', 'ecg']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a class="tag" href="<?php echo e(route('appointments', ['service' => $k])); ?>"><?php echo e(ccmc('tests.'.$k)); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </section>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/pages/health-checks.blade.php ENDPATH**/ ?>