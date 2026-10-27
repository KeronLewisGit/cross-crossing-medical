<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['tone' => 'auto', 'compact' => false, 'small' => false]));

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

foreach (array_filter((['tone' => 'auto', 'compact' => false, 'small' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<span <?php echo e($attributes->merge(['class' => 'inline-flex items-center gap-2.5 sm:gap-3'])); ?>>
    <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['flex flex-none items-center justify-center rounded-md', 'bg-white px-1.5 py-1 ring-1 ring-inset ring-line' => $tone !== 'light', 'text-[#141463]' => $tone !== 'light', 'text-white [--logo-fill:transparent]' => $tone === 'light']); ?>">
        <?php if (isset($component)) { $__componentOriginal4383542ad8210ed40ff2e701a8552b53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4383542ad8210ed40ff2e701a8552b53 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.logo-mark','data' => ['class' => \Illuminate\Support\Arr::toCssClasses(['w-auto', 'h-7' => $small, 'h-8 sm:h-9' => ! $small])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('logo-mark'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses(['w-auto', 'h-7' => $small, 'h-8 sm:h-9' => ! $small]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4383542ad8210ed40ff2e701a8552b53)): ?>
<?php $attributes = $__attributesOriginal4383542ad8210ed40ff2e701a8552b53; ?>
<?php unset($__attributesOriginal4383542ad8210ed40ff2e701a8552b53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4383542ad8210ed40ff2e701a8552b53)): ?>
<?php $component = $__componentOriginal4383542ad8210ed40ff2e701a8552b53; ?>
<?php unset($__componentOriginal4383542ad8210ed40ff2e701a8552b53); ?>
<?php endif; ?>
    </span>
    <?php if (! ($compact)): ?>
        <span class="leading-none <?php echo e($tone === 'light' ? 'text-white' : 'text-ink'); ?>">
            
            <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['font-display block font-semibold tracking-[-0.01em]', 'text-[0.95rem] leading-[1.1]' => $small, 'text-[1.02rem] leading-[1.1] sm:whitespace-nowrap sm:text-[1.15rem] sm:leading-none' => ! $small]); ?>">Cross Crossing <?php if($small): ?><br><?php else: ?><br class="sm:hidden"><?php endif; ?> Medical Centre</span>
            <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['mt-1 whitespace-nowrap text-[0.6875rem] font-extrabold uppercase tracking-[0.16em]', $tone === 'light' ? 'text-white/75' : 'text-ink-3', 'block' => $small, 'hidden sm:block' => ! $small]); ?>">San Fernando · Open 24/7</span>
        </span>
    <?php endif; ?>
</span>
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/components/logo.blade.php ENDPATH**/ ?>