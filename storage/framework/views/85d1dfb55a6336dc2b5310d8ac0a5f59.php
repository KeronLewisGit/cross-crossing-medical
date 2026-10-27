<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name', 'label', 'options' => [], 'required' => false, 'hint' => null, 'value' => null, 'placeholder' => 'Choose…', 'optional' => false]));

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

foreach (array_filter((['name', 'label', 'options' => [], 'required' => false, 'hint' => null, 'value' => null, 'placeholder' => 'Choose…', 'optional' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $id = 'f-'.str_replace(['.', '[', ']'], '-', $name);
    $current = (string) old($name, $value);
?>
<div>
    <label for="<?php echo e($id); ?>" class="label"><?php echo e($label); ?><?php if($optional): ?> <span class="opt">(optional)</span><?php endif; ?></label>
    <select id="<?php echo e($id); ?>" name="<?php echo e($name); ?>" <?php if($required): echo 'required'; endif; ?> <?php if($errors->has($name)): ?> aria-invalid="true" <?php endif; ?> <?php if($hint): ?> aria-describedby="<?php echo e($id); ?>-hint" <?php endif; ?> <?php echo e($attributes->merge(['class' => 'input'])); ?>>
        <?php if($placeholder !== null): ?><option value=""><?php echo e($placeholder); ?></option><?php endif; ?>
        <?php echo e($slot); ?>

        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_array($text)): ?>
                <optgroup label="<?php echo e($v); ?>">
                    <?php $__currentLoopData = $text; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v2 => $t2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($v2); ?>" <?php if($current === (string) $v2): echo 'selected'; endif; ?>><?php echo e($t2); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </optgroup>
            <?php else: ?>
                <option value="<?php echo e($v); ?>" <?php if($current === (string) $v): echo 'selected'; endif; ?>><?php echo e($text); ?></option>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php if($hint): ?><span id="<?php echo e($id); ?>-hint" class="hint"><?php echo e($hint); ?></span><?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal26e98e8e5cc4164d9d54ab94efc26e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e98e8e5cc4164d9d54ab94efc26e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.error','data' => ['for' => $name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($name)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal26e98e8e5cc4164d9d54ab94efc26e46)): ?>
<?php $attributes = $__attributesOriginal26e98e8e5cc4164d9d54ab94efc26e46; ?>
<?php unset($__attributesOriginal26e98e8e5cc4164d9d54ab94efc26e46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal26e98e8e5cc4164d9d54ab94efc26e46)): ?>
<?php $component = $__componentOriginal26e98e8e5cc4164d9d54ab94efc26e46; ?>
<?php unset($__componentOriginal26e98e8e5cc4164d9d54ab94efc26e46); ?>
<?php endif; ?>
</div>
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/components/select.blade.php ENDPATH**/ ?>