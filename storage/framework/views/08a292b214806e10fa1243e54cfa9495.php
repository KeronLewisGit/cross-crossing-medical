<?php ($editing = $job->exists); ?>
<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => $editing ? 'Edit vacancy' : 'New vacancy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing ? 'Edit vacancy' : 'New vacancy')]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($editing && $job->isOpen()): ?><a href="<?php echo e(route('careers.show', $job)); ?>" class="a-btn a-btn-ghost ring-1 ring-line" target="_blank" rel="noopener"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'external','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'external','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>View on website</a><?php endif; ?>
        <a href="<?php echo e(route('admin.jobs.index')); ?>" class="a-btn a-btn-ghost ring-1 ring-line">All vacancies</a>
     <?php $__env->endSlot(); ?>
    <form method="POST" action="<?php echo e($editing ? route('admin.jobs.update', $job) : route('admin.jobs.store')); ?>" class="a-card max-w-3xl space-y-5 p-5 md:p-6">
        <?php echo csrf_field(); ?> <?php if($editing): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div><label for="title" class="mb-1 block text-sm font-semibold">Title</label><input id="title" name="title" value="<?php echo e(old('title', $job->title)); ?>" class="a-input w-full" required maxlength="120"></div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div><label for="role_key" class="mb-1 block text-sm font-semibold">Role group</label><select id="role_key" name="role_key" class="a-input w-full"><?php $__currentLoopData = (array) ccmc('career_roles'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k); ?>" <?php if(old('role_key', $job->role_key) === $k): echo 'selected'; endif; ?>><?php echo e($l); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <div><label for="department" class="mb-1 block text-sm font-semibold">Department</label><input id="department" name="department" value="<?php echo e(old('department', $job->department)); ?>" class="a-input w-full" maxlength="80" placeholder="e.g. Dialysis Unit"></div>
            <div><label for="employment" class="mb-1 block text-sm font-semibold">Hours</label><select id="employment" name="employment" class="a-input w-full"><?php $__currentLoopData = (array) ccmc('availability'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k); ?>" <?php if(old('employment', $job->employment) === $k): echo 'selected'; endif; ?>><?php echo e($l); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <div><label for="closes_on" class="mb-1 block text-sm font-semibold">Closing date <span class="font-normal text-ink-3">(optional)</span></label><input id="closes_on" name="closes_on" type="date" value="<?php echo e(old('closes_on', $job->closes_on?->toDateString())); ?>" class="a-input w-full"></div>
        </div>
        <fieldset><legend class="mb-1 text-sm font-semibold">Status</legend>
            <div class="flex flex-wrap gap-2"><?php $__currentLoopData = \App\Enums\JobStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><label class="flex min-h-11 items-center gap-2 rounded-lg border border-line px-3"><input type="radio" name="status" value="<?php echo e($st->value); ?>" class="h-5 w-5 accent-[color:var(--primary)]" <?php if(old('status', $job->status?->value) === $st->value): echo 'checked'; endif; ?>><?php echo e($st->label()); ?></label><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
            <p class="mt-1 text-xs text-ink-3">Only open vacancies before their closing date show on the website.</p>
        </fieldset>
        <div><label for="summary" class="mb-1 block text-sm font-semibold">Summary</label><textarea id="summary" name="summary" rows="2" class="a-input w-full" maxlength="600"><?php echo e(old('summary', $job->summary)); ?></textarea></div>
        <div><label for="duties" class="mb-1 block text-sm font-semibold">Duties <span class="font-normal text-ink-3">(one per line)</span></label><textarea id="duties" name="duties" rows="6" class="a-input w-full"><?php echo e(old('duties', $job->duties)); ?></textarea></div>
        <div><label for="requirements" class="mb-1 block text-sm font-semibold">Requirements <span class="font-normal text-ink-3">(one per line)</span></label><textarea id="requirements" name="requirements" rows="6" class="a-input w-full"><?php echo e(old('requirements', $job->requirements)); ?></textarea></div>
        <button class="a-btn a-btn-primary">Save vacancy</button>
    </form>
    <?php if($editing): ?>
        <form method="POST" action="<?php echo e(route('admin.jobs.destroy', $job)); ?>" class="mt-4" onsubmit="return confirm('Delete this vacancy? If it has applications it will be closed instead.')">
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
<?php endif; ?>Delete vacancy</button>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/admin/jobs/form.blade.php ENDPATH**/ ?>