<?php ($editing = $handout->exists); ?>
<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => $editing ? 'Edit handout' : 'Add a handout']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing ? 'Edit handout' : 'Add a handout')]); ?>
     <?php $__env->slot('actions', null, []); ?> <a href="<?php echo e(route('admin.handouts.index')); ?>" class="a-btn a-btn-ghost ring-1 ring-line">All handouts</a> <?php $__env->endSlot(); ?>
    <form method="POST" action="<?php echo e($editing ? route('admin.handouts.update', $handout) : route('admin.handouts.store')); ?>" enctype="multipart/form-data" class="a-card max-w-3xl space-y-5 p-5 md:p-6">
        <?php echo csrf_field(); ?> <?php if($editing): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div><label for="title" class="mb-1 block text-sm font-semibold">Title</label><input id="title" name="title" value="<?php echo e(old('title', $handout->title)); ?>" class="a-input w-full" required maxlength="140"></div>
        <div class="grid gap-4 sm:grid-cols-[1fr_8rem]">
            <div><label for="category" class="mb-1 block text-sm font-semibold">Topic</label><select id="category" name="category" class="a-input w-full"><?php $__currentLoopData = \App\Models\Handout::CATEGORIES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k); ?>" <?php if(old('category', $handout->category) === $k): echo 'selected'; endif; ?>><?php echo e($l); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <div><label for="sort" class="mb-1 block text-sm font-semibold">Order</label><input id="sort" name="sort" type="number" min="0" max="999" value="<?php echo e(old('sort', $handout->sort)); ?>" class="a-input w-full"></div>
        </div>
        <div><label for="summary" class="mb-1 block text-sm font-semibold">One-line summary</label><textarea id="summary" name="summary" rows="2" class="a-input w-full" maxlength="400"><?php echo e(old('summary', $handout->summary)); ?></textarea></div>
        <div><label for="publisher" class="mb-1 block text-sm font-semibold">Publisher <span class="font-normal text-ink-3">(blank = the centre)</span></label><input id="publisher" name="publisher" value="<?php echo e(old('publisher', $handout->publisher)); ?>" class="a-input w-full" maxlength="120"></div>
        <div class="rounded-lg border border-line p-4">
            <p class="text-sm font-semibold">Upload a PDF, or link to a page</p>
            <div class="mt-3"><label for="file" class="mb-1 block text-sm">PDF (up to 10 MB)</label><input id="file" name="file" type="file" accept=".pdf,application/pdf" class="a-input w-full"></div>
            <?php if($handout->file_path): ?>
                <p class="mt-2 text-sm"><a href="<?php echo e($handout->href()); ?>" class="text-link" target="_blank" rel="noopener">Current PDF</a> · <label class="inline-flex min-h-11 items-center gap-2"><input type="checkbox" name="remove_file" value="1" class="h-5 w-5">Remove it</label></p>
            <?php endif; ?>
            <div class="mt-3"><label for="url" class="mb-1 block text-sm">Or a link</label><input id="url" name="url" type="url" value="<?php echo e(old('url', $handout->url)); ?>" class="a-input w-full" placeholder="https://"></div>
        </div>
        <label class="flex min-h-11 items-center gap-2 text-sm font-semibold"><input type="checkbox" name="published" value="1" class="h-5 w-5 accent-[color:var(--primary)]" <?php if(old('published', $handout->published)): echo 'checked'; endif; ?>>Show on the website</label>
        <button class="a-btn a-btn-primary">Save handout</button>
    </form>
    <?php if($editing): ?>
        <form method="POST" action="<?php echo e(route('admin.handouts.destroy', $handout)); ?>" class="mt-4" onsubmit="return confirm('Delete this handout?')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button class="a-btn a-btn-ghost text-[color:var(--critical-text)]"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'trash','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'trash','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Delete handout</button>
        </form>
    <?php endif; ?>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/admin/handouts/form.blade.php ENDPATH**/ ?>