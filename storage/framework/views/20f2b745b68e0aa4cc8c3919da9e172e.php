<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Settings']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Settings']); ?>
    <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" class="max-w-2xl space-y-6">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <section class="a-card space-y-3 p-5">
            <h2 class="font-semibold">Notice on every page</h2>
            <p class="text-sm text-ink-2">A short line shown under the 24-hour band on every public page, for a holiday clinic change, a phone line fault or a public-health message. Leave blank to hide it.</p>
            <label for="notice" class="sr-only">Public notice</label>
            <textarea id="notice" name="public_notice" rows="3" maxlength="280" class="a-input w-full" placeholder="e.g. The 652-4412 line is down today. Please call 652-4411."><?php echo e(old('public_notice', $notice)); ?></textarea>
            <p class="text-xs text-ink-3">Up to 280 characters. Do not post anything about a named patient.</p>
        </section>
        <button class="a-btn a-btn-primary">Save settings</button>
    </form>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $attributes = $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $component = $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/admin/settings.blade.php ENDPATH**/ ?>