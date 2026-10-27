<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['draw' => false, 'muted' => false]));

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

foreach (array_filter((['draw' => false, 'muted' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<svg <?php echo e($attributes->class(['pulse-line', 'draw' => $draw, 'muted' => $muted])); ?> viewBox="0 0 1200 34" preserveAspectRatio="none" aria-hidden="true" focusable="false">
    <path d="M0 22 H420 l14 0 8 -6 8 6 h14 l8 8 12 -28 12 28 8 -8 h22 l10 -7 10 7 H760 l10 0 6 -4 6 4 h10 l6 6 9 -20 9 20 6 -6 h16 l8 -5 8 5 H1200" />
</svg>
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/components/pulse-line.blade.php ENDPATH**/ ?>