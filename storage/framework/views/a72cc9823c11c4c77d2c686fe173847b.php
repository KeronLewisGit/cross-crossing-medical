<?php
    use App\Enums\SubmissionType as T;
    $next = match ($type) {
        T::Appointment => 'The appointments team will call you back, usually within 2 hours, to agree a day and time. Nothing is booked until you have spoken to us.',
        T::Registration => 'The registration team will check the details and open the patient file. Bring the original ID and insurance card to the first visit.',
        T::Dialysis => 'The dialysis unit will call you back, usually within 2 hours, to talk through the next step.',
        T::Career => 'The HR team reviews every application and will contact you if you are shortlisted.',
        default => 'We will reply as soon as we can, usually within a few hours.',
    };
?>
<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Thank you','mobileBar' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Thank you','mobile-bar' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Thank you. We have it.','lead' => $next,'code' => 'OK','label' => $type->label()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Thank you. We have it.','lead' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($next),'code' => 'OK','label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($type->label())]); ?>
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
    <section class="wrap mt-12 md:mt-16">
        <div class="panel max-w-xl border-l-[6px] border-l-[color:var(--pulse)] p-7 md:p-9">
            <p class="kicker text-ink-3">Your reference</p>
            <p class="font-display mt-3 text-3xl font-semibold tracking-wide num sm:text-4xl"><?php echo e($reference); ?></p>
            <p class="mt-5 text-ink-2">Write it down or take a screenshot. If you gave an email address we have sent it to you too. Quote it if you call, and we will find your request straight away.</p>
        </div>
        <?php if($type === T::Appointment): ?>
            <div class="panel mt-6 max-w-xl p-6">
                <p class="font-bold">First visit to the centre?</p>
                <p class="mt-1 text-ink-2">Save time at reception by registering the patient now.</p>
                <a href="<?php echo e(route('new-patients')); ?>" class="btn btn-outline btn-sm mt-4">Register as a new patient</a>
            </div>
        <?php endif; ?>
        <?php if($type !== T::Career): ?>
            <?php if (isset($component)) { $__componentOriginal1e6a602e17f653e5f5d9ec413ce2af06 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e6a602e17f653e5f5d9ec413ce2af06 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.not-emergency','data' => ['class' => 'mt-6 max-w-xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('not-emergency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-6 max-w-xl']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1e6a602e17f653e5f5d9ec413ce2af06)): ?>
<?php $attributes = $__attributesOriginal1e6a602e17f653e5f5d9ec413ce2af06; ?>
<?php unset($__attributesOriginal1e6a602e17f653e5f5d9ec413ce2af06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e6a602e17f653e5f5d9ec413ce2af06)): ?>
<?php $component = $__componentOriginal1e6a602e17f653e5f5d9ec413ce2af06; ?>
<?php unset($__componentOriginal1e6a602e17f653e5f5d9ec413ce2af06); ?>
<?php endif; ?>
        <?php endif; ?>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="<?php echo e(tel_href(main_phone())); ?>" class="btn btn-outline"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?><?php echo e(format_phone(main_phone())); ?></a>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Back to the home page</a>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/pages/thanks.blade.php ENDPATH**/ ?>