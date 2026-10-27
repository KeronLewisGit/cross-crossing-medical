<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Staff']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Staff']); ?>
    <div class="grid gap-6 xl:grid-cols-[1.5fr_1fr]">
        <div class="a-card relative overflow-x-auto">
            <table class="data-table">
                <thead><tr><th>Name</th><th>Role</th><th>Sees</th><th>Active</th><th><span class="sr-only">Save</span></th></tr></thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><p class="font-semibold"><?php echo e($u->name); ?></p><p class="text-sm text-ink-3"><?php echo e($u->email); ?></p></td>
                            <td colspan="4" class="!p-0">
                                <form method="POST" action="<?php echo e(route('admin.users.update', $u)); ?>" class="flex flex-wrap items-center gap-3 px-3.5 py-2">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <label class="sr-only" for="role-<?php echo e($u->id); ?>">Role for <?php echo e($u->name); ?></label>
                                    <select id="role-<?php echo e($u->id); ?>" name="role" class="a-input"><?php $__currentLoopData = \App\Enums\Role::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($r->value); ?>" <?php if($u->role === $r): echo 'selected'; endif; ?>><?php echo e($r->label()); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                                    <span class="min-w-40 flex-1 text-sm text-ink-3"><?php echo e(collect($u->role->types())->map->plural()->join(', ')); ?></span>
                                    <label class="flex min-h-11 items-center gap-2 text-sm"><input type="checkbox" name="active" value="1" class="h-4 w-4" <?php if($u->active): echo 'checked'; endif; ?>>Active</label>
                                    <button class="a-btn a-btn-ghost">Save</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <form method="POST" action="<?php echo e(route('admin.users.store')); ?>" class="a-card h-fit space-y-4 p-5">
            <?php echo csrf_field(); ?>
            <h2 class="font-semibold">Add a staff member</h2>
            <div><label for="n" class="mb-1 block text-sm font-semibold">Name</label><input id="n" name="name" value="<?php echo e(old('name')); ?>" class="a-input w-full" required></div>
            <div><label for="e" class="mb-1 block text-sm font-semibold">Email</label><input id="e" name="email" type="email" value="<?php echo e(old('email')); ?>" class="a-input w-full" required></div>
            <div><label for="r" class="mb-1 block text-sm font-semibold">Role</label><select id="r" name="role" class="a-input w-full"><?php $__currentLoopData = \App\Enums\Role::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($r->value); ?>" <?php if(old('role') === $r->value): echo 'selected'; endif; ?>><?php echo e($r->label()); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            <div><label for="p" class="mb-1 block text-sm font-semibold">Temporary password</label><input id="p" name="password" type="password" minlength="10" class="a-input w-full" required autocomplete="new-password"><p class="mt-1 text-xs text-ink-3">At least 10 characters. Share it in person.</p></div>
            <button class="a-btn a-btn-primary w-full">Add staff member</button>
            <p class="text-xs text-ink-3">ID and insurance cards open only for the Registration &amp; records role, not even for administrators. Every opening is logged.</p>
        </form>
    </div>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/admin/users.blade.php ENDPATH**/ ?>