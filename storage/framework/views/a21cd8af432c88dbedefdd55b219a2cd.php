<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Document log']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Document log']); ?>
    <p class="mb-5 max-w-3xl text-sm text-ink-2">Every time a staff member opens or downloads a document attached to a website request, it is recorded here and on the request's timeline. ID and insurance cards open for the Registration &amp; records role only. Entries cannot be edited or deleted from the dashboard.</p>
    <div class="a-card relative overflow-x-auto">
        <table class="data-table w-full min-w-[42rem]">
            <thead><tr><th scope="col">When</th><th scope="col">Staff member</th><th scope="col">Document</th><th scope="col">Request</th><th scope="col">IP address</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $accesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="whitespace-nowrap text-sm num"><?php echo e($a->created_at->format('j M Y, H:i')); ?></td>
                        <td class="text-sm font-semibold"><?php echo e($a->user->name ?? 'Deleted user'); ?><p class="text-xs font-normal text-ink-3"><?php echo e($a->user?->role->label()); ?></p></td>
                        <td class="text-sm"><span class="inline-flex items-center gap-1.5"><?php if($a->file?->isRestricted()): ?><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'lock','class' => 'h-4 w-4 text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'lock','class' => 'h-4 w-4 text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php endif; ?><?php echo e($a->file?->label() ?? 'Deleted file'); ?></span></td>
                        <td class="text-sm"><?php if($a->submission): ?><a href="<?php echo e(route('admin.submissions.show', $a->submission)); ?>" class="inline-flex min-h-11 items-center font-semibold text-link num"><?php echo e($a->submission->reference); ?></a><?php else: ?> — <?php endif; ?></td>
                        <td class="text-sm text-ink-3 num"><?php echo e($a->ip); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="py-10 text-center text-ink-3">No documents have been opened yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4"><?php echo e($accesses->links('components.pagination')); ?></div>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/admin/document-log.blade.php ENDPATH**/ ?>