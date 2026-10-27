<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="color-scheme" content="light dark">
<meta name="theme-color" content="#0d2850">
<link rel="icon" href="<?php echo e(asset('favicon.svg')); ?>" type="image/svg+xml">
<link rel="icon" href="<?php echo e(asset('img/brand/favicon-32.png')); ?>" type="image/png" sizes="32x32">
<link rel="apple-touch-icon" href="<?php echo e(asset('img/brand/apple-touch-icon.png')); ?>">
<script>
    // Apply the saved theme before first paint so there is no flash.
    document.documentElement.classList.add('js');
    try { var t = localStorage.getItem('theme'); if (t === 'dark' || t === 'light') document.documentElement.dataset.theme = t; } catch (e) {}
</script>
<?php echo app('Illuminate\Foundation\Vite')->fonts(); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/partials/head.blade.php ENDPATH**/ ?>