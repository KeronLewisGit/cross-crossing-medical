<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['key', 'alt', 'sizes' => '100vw', 'eager' => false, 'imgClass' => '', 'position' => null]));

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

foreach (array_filter((['key', 'alt', 'sizes' => '100vw', 'eager' => false, 'imgClass' => '', 'position' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php ($p = photo($key)); ?>
<figure <?php echo e($attributes->merge(['class' => 'photo'])); ?>>
    <img src="<?php echo e($p['src']); ?>" srcset="<?php echo e($p['srcset']); ?>" sizes="<?php echo e($sizes); ?>" width="<?php echo e($p['width']); ?>" height="<?php echo e($p['height']); ?>" alt="<?php echo e($alt); ?>" class="<?php echo e($imgClass); ?>" <?php if($position): ?> style="object-position: <?php echo e($position); ?>" <?php endif; ?> <?php if($eager): ?> fetchpriority="high" <?php else: ?> loading="lazy" decoding="async" <?php endif; ?>>
</figure>
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/components/photo.blade.php ENDPATH**/ ?>