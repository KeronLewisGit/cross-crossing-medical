<?php echo '<'.'?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php $__currentLoopData = $urls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <url><loc><?php echo e($u['loc']); ?></loc><?php if($u['lastmod']): ?><lastmod><?php echo e($u['lastmod']); ?></lastmod><?php endif; ?></url>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</urlset>
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/sitemap.blade.php ENDPATH**/ ?>