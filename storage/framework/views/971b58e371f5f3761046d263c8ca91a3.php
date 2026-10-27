<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label', 'value', 'previous' => null, 'period' => null, 'note' => null, 'href' => null, 'upIsGood' => true]));

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

foreach (array_filter((['label', 'value', 'previous' => null, 'period' => null, 'note' => null, 'href' => null, 'upIsGood' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $delta = $previous !== null ? $value - $previous : null;
    $tone = $delta === null || $delta === 0 ? 'neutral' : (($delta > 0) === $upIsGood ? 'good' : 'critical');
?>
<a href="<?php echo e($href); ?>" class="a-card block p-5 transition hover:shadow-lg focus-visible:shadow-lg">
    <p class="text-sm text-ink-2"><?php echo e($label); ?></p>
    <p class="mt-2 text-[2rem] font-semibold leading-none tracking-tight"><?php echo e(compact_number($value)); ?></p>
    <?php if($delta !== null): ?>
        <p class="mt-3 flex items-center gap-1.5 text-sm">
            <span class="chip num" data-tone="<?php echo e($tone); ?>">
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $delta > 0 ? 'arrow-right' : ($delta < 0 ? 'arrow-right' : 'dot'),'class' => \Illuminate\Support\Arr::toCssClasses(['-rotate-45' => $delta > 0, 'rotate-45' => $delta < 0])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($delta > 0 ? 'arrow-right' : ($delta < 0 ? 'arrow-right' : 'dot')),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses(['-rotate-45' => $delta > 0, 'rotate-45' => $delta < 0]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php echo e($delta > 0 ? '+' : ''); ?><?php echo e(number_format($delta)); ?>

            </span>
            <span class="text-ink-3"><?php echo e($period); ?></span>
        </p>
    <?php elseif($note): ?>
        <p class="mt-3 text-sm text-ink-3"><?php echo e($note); ?></p>
    <?php endif; ?>
</a>
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/components/stat-tile.blade.php ENDPATH**/ ?>