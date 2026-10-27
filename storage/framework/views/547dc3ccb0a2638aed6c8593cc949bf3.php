<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Site map']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Site map']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Site map','lead' => 'Every page on this website.','code' => 'MAP','label' => 'Site map']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Site map','lead' => 'Every page on this website.','code' => 'MAP','label' => 'Site map']); ?>
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
    <div class="wrap mt-12 grid gap-10 md:mt-16 sm:grid-cols-2 lg:grid-cols-4">
        <?php $__currentLoopData = [
            'The centre' => [route('home') => 'Home', route('about') => 'About the centre', route('contact') => 'Contact and directions', route('services') => 'Services and departments', route('clinics') => 'Specialist clinics'],
            'Departments' => collect((array) ccmc('departments'))->mapWithKeys(fn ($d, $s) => [route('department', $s) => $d['name']])->all(),
            'Patients' => [route('appointments') => 'Request an appointment', route('new-patients') => 'New patient registration', route('department', 'dialysis').'#enquire' => 'Dialysis enquiry', route('handouts') => 'Patient handouts', route('health-checks') => 'Health self-checks'],
            'More' => [route('careers') => 'Careers', route('careers.apply') => 'Apply for a job'] + $jobs->mapWithKeys(fn ($j) => [route('careers.show', $j) => $j->title])->all() + [route('privacy') => 'Privacy notice', route('credits') => 'Photo credits'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $heading => $links): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <section>
                <h2 class="font-display text-xl font-medium"><?php echo e($heading); ?></h2>
                <ul class="mt-3">
                    <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $href => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><a class="inline-flex min-h-11 items-center text-link" href="<?php echo e($href); ?>"><?php echo e($label); ?></a></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </section>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/pages/sitemap.blade.php ENDPATH**/ ?>