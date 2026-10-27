<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title>Sign in · CCMC staff desk</title>
    <meta name="robots" content="noindex">
</head>
<body class="admin stucco grid min-h-screen place-items-center px-4 py-10">
    <main class="w-full max-w-sm">
        <a href="<?php echo e(route('home')); ?>" class="mx-auto mb-8 flex min-h-11 w-max items-center"><?php if (isset($component)) { $__componentOriginal987d96ec78ed1cf75b349e2e5981978f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal987d96ec78ed1cf75b349e2e5981978f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.logo','data' => ['tone' => 'light']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tone' => 'light']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal987d96ec78ed1cf75b349e2e5981978f)): ?>
<?php $attributes = $__attributesOriginal987d96ec78ed1cf75b349e2e5981978f; ?>
<?php unset($__attributesOriginal987d96ec78ed1cf75b349e2e5981978f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal987d96ec78ed1cf75b349e2e5981978f)): ?>
<?php $component = $__componentOriginal987d96ec78ed1cf75b349e2e5981978f; ?>
<?php unset($__componentOriginal987d96ec78ed1cf75b349e2e5981978f); ?>
<?php endif; ?></a>
        <form method="POST" action="<?php echo e(route('login')); ?>" class="a-card space-y-5 p-6 sm:p-8">
            <?php echo csrf_field(); ?>
            <div>
                <h1 class="text-xl font-semibold">Staff desk</h1>
                <p class="mt-1 text-sm text-ink-3">Appointments, registrations, dialysis enquiries and applications. Staff only.</p>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold" for="email">Email</label>
                <input class="a-input w-full" id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username" <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" aria-describedby="email-error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                <?php if (isset($component)) { $__componentOriginal26e98e8e5cc4164d9d54ab94efc26e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e98e8e5cc4164d9d54ab94efc26e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.error','data' => ['for' => 'email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'email']); ?>
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
            <div>
                <label class="mb-1.5 block text-sm font-semibold" for="password">Password</label>
                <input class="a-input w-full" id="password" name="password" type="password" required autocomplete="current-password">
            </div>
            <label class="flex min-h-11 items-center gap-2 text-sm"><input type="checkbox" name="remember" value="1" class="h-5 w-5 accent-[color:var(--primary)]">Keep me signed in on this device</label>
            <button class="a-btn a-btn-primary w-full">Sign in</button>
            <p class="text-xs text-ink-3">Every opening of a patient document is logged against your account.</p>
        </form>
    </main>
</body>
</html>
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/auth/login.blade.php ENDPATH**/ ?>