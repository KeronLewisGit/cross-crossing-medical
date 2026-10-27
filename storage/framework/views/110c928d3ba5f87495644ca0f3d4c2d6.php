
<section id="enquire" class="mt-20 bg-surface py-16" aria-labelledby="enq-title">
    <div class="wrap grid gap-10 lg:grid-cols-[20rem_minmax(0,1fr)] lg:gap-14">
        <div>
            <?php if (isset($component)) { $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sign','data' => ['code' => 'RD','label' => 'Dialysis enquiry','arrow' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sign'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['code' => 'RD','label' => 'Dialysis enquiry','arrow' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $attributes = $__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__attributesOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d)): ?>
<?php $component = $__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d; ?>
<?php unset($__componentOriginal1a0bbf47f5ba44b1cbe5d2a17343b95d); ?>
<?php endif; ?>
            <h2 id="enq-title" class="display-3 mt-5">Ask the dialysis unit to call you</h2>
            <p class="mt-3 text-ink-2">Tell us a little about the patient's situation and the sessions that would suit. The unit calls back to arrange an initial examination and review by our physicians.</p>
            <p class="mt-4 text-sm text-ink-3">Your reference arrives on screen straight away. Nothing about the patient is sent by email.</p>
        </div>
        <form method="POST" action="<?php echo e(route('dialysis.store')); ?>" enctype="multipart/form-data" class="panel space-y-10 p-6 md:p-9" x-data="requestForm" @submit="submit">
            <?php echo csrf_field(); ?>
            <?php if (isset($component)) { $__componentOriginal1e6a602e17f653e5f5d9ec413ce2af06 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e6a602e17f653e5f5d9ec413ce2af06 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.not-emergency','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('not-emergency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1e6a602e17f653e5f5d9ec413ce2af06)): ?>
<?php $attributes = $__attributesOriginal1e6a602e17f653e5f5d9ec413ce2af06; ?>
<?php unset($__attributesOriginal1e6a602e17f653e5f5d9ec413ce2af06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e6a602e17f653e5f5d9ec413ce2af06)): ?>
<?php $component = $__componentOriginal1e6a602e17f653e5f5d9ec413ce2af06; ?>
<?php unset($__componentOriginal1e6a602e17f653e5f5d9ec413ce2af06); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3d251db05a714ec6b2f220d3dccfef6d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d251db05a714ec6b2f220d3dccfef6d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-errors','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-errors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d251db05a714ec6b2f220d3dccfef6d)): ?>
<?php $attributes = $__attributesOriginal3d251db05a714ec6b2f220d3dccfef6d; ?>
<?php unset($__attributesOriginal3d251db05a714ec6b2f220d3dccfef6d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d251db05a714ec6b2f220d3dccfef6d)): ?>
<?php $component = $__componentOriginal3d251db05a714ec6b2f220d3dccfef6d; ?>
<?php unset($__componentOriginal3d251db05a714ec6b2f220d3dccfef6d); ?>
<?php endif; ?>
            <fieldset class="space-y-5" x-data="{ situation: '<?php echo e(old('situation')); ?>' }">
                <legend class="fieldset-title mb-5"><span class="step">1</span>The patient's situation</legend>
                <div class="grid gap-2" role="radiogroup" aria-label="Which best describes the patient?">
                    <?php $__currentLoopData = $situations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="choice"><input type="radio" name="situation" value="<?php echo e($k); ?>" x-model="situation" required <?php if(old('situation') === $k): echo 'checked'; endif; ?>><?php echo e($label); ?></label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if (isset($component)) { $__componentOriginal26e98e8e5cc4164d9d54ab94efc26e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e98e8e5cc4164d9d54ab94efc26e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.error','data' => ['for' => 'situation']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'situation']); ?>
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
                <?php if (isset($component)) { $__componentOriginalae4c123bc9806121d87d234de2f27a3b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae4c123bc9806121d87d234de2f27a3b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.field','data' => ['name' => 'current_unit','label' => 'Current dialysis unit or referring doctor','optional' => true,'maxlength' => '120']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'current_unit','label' => 'Current dialysis unit or referring doctor','optional' => true,'maxlength' => '120']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $attributes = $__attributesOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $component = $__componentOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__componentOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
                <?php if(isset($situations['visiting'])): ?>
                    <div class="grid gap-5 sm:grid-cols-2" x-show="situation === 'visiting'" x-cloak>
                        <?php if (isset($component)) { $__componentOriginalae4c123bc9806121d87d234de2f27a3b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae4c123bc9806121d87d234de2f27a3b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.field','data' => ['name' => 'visit_from','label' => 'First day in Trinidad','type' => 'date','min' => today()->toDateString()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'visit_from','label' => 'First day in Trinidad','type' => 'date','min' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(today()->toDateString())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $attributes = $__attributesOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $component = $__componentOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__componentOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalae4c123bc9806121d87d234de2f27a3b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae4c123bc9806121d87d234de2f27a3b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.field','data' => ['name' => 'visit_to','label' => 'Last day','type' => 'date','min' => today()->toDateString()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'visit_to','label' => 'Last day','type' => 'date','min' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(today()->toDateString())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $attributes = $__attributesOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $component = $__componentOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__componentOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalae4c123bc9806121d87d234de2f27a3b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae4c123bc9806121d87d234de2f27a3b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.field','data' => ['name' => 'referral','label' => 'Referral letter or latest dialysis summary','type' => 'file','optional' => true,'accept' => '.pdf,.jpg,.jpeg,.png,.webp,.heic,.heif','hint' => 'A photo or PDF, up to 8 MB. Kept privately for the unit.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'referral','label' => 'Referral letter or latest dialysis summary','type' => 'file','optional' => true,'accept' => '.pdf,.jpg,.jpeg,.png,.webp,.heic,.heif','hint' => 'A photo or PDF, up to 8 MB. Kept privately for the unit.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $attributes = $__attributesOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $component = $__componentOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__componentOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
            </fieldset>
            <fieldset class="space-y-5">
                <legend class="fieldset-title mb-5"><span class="step">2</span>Sessions that would suit</legend>
                <div class="grid gap-5 sm:grid-cols-2">
                    <?php if (isset($component)) { $__componentOriginaled2cde6083938c436304f332ba96bb7c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled2cde6083938c436304f332ba96bb7c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.select','data' => ['name' => 'schedule','label' => 'Days','options' => (array) ccmc('dialysis.schedules'),'required' => true,'value' => old('schedule', 'either'),'placeholder' => null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'schedule','label' => 'Days','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((array) ccmc('dialysis.schedules')),'required' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('schedule', 'either')),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $attributes = $__attributesOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__attributesOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $component = $__componentOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__componentOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginaled2cde6083938c436304f332ba96bb7c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled2cde6083938c436304f332ba96bb7c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.select','data' => ['name' => 'shift','label' => 'Time','options' => (array) ccmc('dialysis.shifts'),'required' => true,'value' => old('shift', 'any'),'placeholder' => null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'shift','label' => 'Time','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((array) ccmc('dialysis.shifts')),'required' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('shift', 'any')),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $attributes = $__attributesOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__attributesOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $component = $__componentOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__componentOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>
                </div>
                <?php if (isset($component)) { $__componentOriginalae4c123bc9806121d87d234de2f27a3b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae4c123bc9806121d87d234de2f27a3b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.field','data' => ['name' => 'message','label' => 'Anything else the unit should know','type' => 'textarea','optional' => true,'rows' => '3','maxlength' => '1000']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'message','label' => 'Anything else the unit should know','type' => 'textarea','optional' => true,'rows' => '3','maxlength' => '1000']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $attributes = $__attributesOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $component = $__componentOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__componentOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
            </fieldset>
            <?php if (isset($component)) { $__componentOriginalbb1209e37896c727d4c623f730746632 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb1209e37896c727d4c623f730746632 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.contact-fields','data' => ['step' => 3,'title' => 'The patient, and who we call']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('contact-fields'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['step' => 3,'title' => 'The patient, and who we call']); ?>
                <?php if (isset($component)) { $__componentOriginal00b4c1c14bdde71ef7d14ad9a4e5ecca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal00b4c1c14bdde71ef7d14ad9a4e5ecca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.for-whom','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('for-whom'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal00b4c1c14bdde71ef7d14ad9a4e5ecca)): ?>
<?php $attributes = $__attributesOriginal00b4c1c14bdde71ef7d14ad9a4e5ecca; ?>
<?php unset($__attributesOriginal00b4c1c14bdde71ef7d14ad9a4e5ecca); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal00b4c1c14bdde71ef7d14ad9a4e5ecca)): ?>
<?php $component = $__componentOriginal00b4c1c14bdde71ef7d14ad9a4e5ecca; ?>
<?php unset($__componentOriginal00b4c1c14bdde71ef7d14ad9a4e5ecca); ?>
<?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb1209e37896c727d4c623f730746632)): ?>
<?php $attributes = $__attributesOriginalbb1209e37896c727d4c623f730746632; ?>
<?php unset($__attributesOriginalbb1209e37896c727d4c623f730746632); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb1209e37896c727d4c623f730746632)): ?>
<?php $component = $__componentOriginalbb1209e37896c727d4c623f730746632; ?>
<?php unset($__componentOriginalbb1209e37896c727d4c623f730746632); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal2dc3a0c4f59804dcb82c363f29f22111 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2dc3a0c4f59804dcb82c363f29f22111 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.consent','data' => ['purpose' => 'so that the dialysis unit can call me back about this enquiry']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('consent'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['purpose' => 'so that the dialysis unit can call me back about this enquiry']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2dc3a0c4f59804dcb82c363f29f22111)): ?>
<?php $attributes = $__attributesOriginal2dc3a0c4f59804dcb82c363f29f22111; ?>
<?php unset($__attributesOriginal2dc3a0c4f59804dcb82c363f29f22111); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2dc3a0c4f59804dcb82c363f29f22111)): ?>
<?php $component = $__componentOriginal2dc3a0c4f59804dcb82c363f29f22111; ?>
<?php unset($__componentOriginal2dc3a0c4f59804dcb82c363f29f22111); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal115b46fcdf6e9400520dc8007e7b99a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.submit','data' => ['label' => 'Send the enquiry']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Send the enquiry']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1)): ?>
<?php $attributes = $__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1; ?>
<?php unset($__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal115b46fcdf6e9400520dc8007e7b99a1)): ?>
<?php $component = $__componentOriginal115b46fcdf6e9400520dc8007e7b99a1; ?>
<?php unset($__componentOriginal115b46fcdf6e9400520dc8007e7b99a1); ?>
<?php endif; ?>
        </form>
    </div>
</section>
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/pages/forms/dialysis.blade.php ENDPATH**/ ?>