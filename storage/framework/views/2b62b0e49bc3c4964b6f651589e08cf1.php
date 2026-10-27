<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'lead' => null, 'code' => 'CCMC', 'label' => 'Cross Crossing Medical Centre', 'photo' => null, 'photoAlt' => '', 'position' => 'center', 'ae' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title', 'lead' => null, 'code' => 'CCMC', 'label' => 'Cross Crossing Medical Centre', 'photo' => null, 'photoAlt' => '', 'position' => 'center', 'ae' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<section <?php echo e($attributes->merge(['class' => 'stucco on-sign relative isolate overflow-hidden text-white'])); ?>>
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['wrap grid gap-8 pb-8 pt-9 md:pb-12 md:pt-14', 'md:grid-cols-[minmax(0,1fr)_minmax(0,22rem)] md:items-center lg:grid-cols-[minmax(0,1fr)_minmax(0,26rem)] lg:gap-14' => $photo]); ?>">
        <div class="min-w-0">
            <?php if (isset($component)) { $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sign','data' => ['code' => $code,'label' => $label,'ae' => $ae]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sign'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['code' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($code),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($label),'ae' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ae)]); ?>
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
            <h1 class="display-2 mt-5 max-w-4xl"><?php echo e($title); ?></h1>
            <?php if($lead): ?><p class="lead mt-4 text-white/85 md:mt-5"><?php echo e($lead); ?></p><?php endif; ?>
            <?php echo e($slot); ?>

        </div>
        <?php if($photo): ?>
            <div class="frame">
                <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => $photo,'alt' => $photoAlt,'eager' => true,'sizes' => '(min-width: 1024px) 26rem, (min-width: 768px) 22rem, 100vw','class' => 'aspect-[16/9] md:aspect-[4/3]','position' => $position]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($photo),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($photoAlt),'eager' => true,'sizes' => '(min-width: 1024px) 26rem, (min-width: 768px) 22rem, 100vw','class' => 'aspect-[16/9] md:aspect-[4/3]','position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($position)]); ?>
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
        <?php endif; ?>
    </div>
    <?php if (isset($component)) { $__componentOriginalb010addd8d0ea019d1f5f2b79163d3e6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb010addd8d0ea019d1f5f2b79163d3e6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pulse-line','data' => ['draw' => true,'class' => '-mb-px']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pulse-line'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['draw' => true,'class' => '-mb-px']); ?>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/components/page-header.blade.php ENDPATH**/ ?>