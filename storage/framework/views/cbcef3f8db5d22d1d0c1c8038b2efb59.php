<?php
    $phones = (array) ccmc('phones');
    $address = ccmc('address');
    $dental = ccmc('departments.dental');
    $topic = old('topic', array_key_exists((string) request('topic'), $topics) ? request('topic') : 'general');
    $lat = (float) ccmc('geo.lat'); $lng = (float) ccmc('geo.lng');
    $bbox = implode(',', [$lng - 0.008, $lat - 0.005, $lng + 0.008, $lat + 0.005]);
?>
<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Contact and directions','description' => 'Cross Crossing Medical Centre, Oliver Avenue, Cross Crossing, San Fernando. Call '.format_phone($phones[0] ?? '').'. Open 24 hours.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Contact and directions','description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Cross Crossing Medical Centre, Oliver Avenue, Cross Crossing, San Fernando. Call '.format_phone($phones[0] ?? '').'. Open 24 hours.')]); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Contact and directions','lead' => 'Call any time, day or night. For a question that can wait, send a message and we will reply.','code' => 'MAP','label' => 'Contact','photo' => 'building','photoAlt' => 'The front of the centre on Oliver Avenue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Contact and directions','lead' => 'Call any time, day or night. For a question that can wait, send a message and we will reply.','code' => 'MAP','label' => 'Contact','photo' => 'building','photo-alt' => 'The front of the centre on Oliver Avenue']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

    <div class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.25fr)] lg:gap-16">
        <div class="space-y-10">
            <section aria-labelledby="dir-title">
                <h2 id="dir-title" class="display-3">Phone directory</h2>
                <dl class="mt-5 divide-y divide-line border-y border-line">
                    <div class="grid gap-1 py-3.5 sm:grid-cols-[11rem_1fr]"><dt class="font-bold">Main line, 24 hours</dt><dd class="flex flex-wrap gap-x-4"><?php $__currentLoopData = $phones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><a href="<?php echo e(tel_href($p)); ?>" class="inline-flex min-h-11 items-center font-semibold text-link"><?php echo e(format_phone($p)); ?></a><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></dd></div>
                    <div class="grid gap-1 py-3.5 sm:grid-cols-[11rem_1fr]"><dt class="font-bold">Emergency room</dt><dd class="text-ink-2">Come straight in, or call <a href="<?php echo e(tel_href($phones[0] ?? '')); ?>" class="font-semibold text-link"><?php echo e(format_phone($phones[0] ?? '')); ?></a>. Ambulance: <a href="tel:<?php echo e(ccmc('ambulance')); ?>" class="font-semibold text-link"><?php echo e(ccmc('ambulance')); ?></a></dd></div>
                    <div class="grid gap-1 py-3.5 sm:grid-cols-[11rem_1fr]"><dt class="font-bold">Fax</dt><dd><?php echo e(format_phone((string) ccmc('fax'))); ?></dd></div>
                    <div class="grid gap-1 py-3.5 sm:grid-cols-[11rem_1fr]"><dt class="font-bold">Email</dt><dd><a href="mailto:<?php echo e(ccmc('email')); ?>" class="inline-flex min-h-11 items-center font-semibold text-link"><?php echo e(ccmc('email')); ?></a></dd></div>
                    <div class="grid gap-1 py-3.5 sm:grid-cols-[11rem_1fr]"><dt class="font-bold">Dental</dt><dd class="text-ink-2"><?php echo e($dental['partner']); ?>: <?php $__currentLoopData = $dental['phones']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><a href="<?php echo e(tel_href($p)); ?>" class="font-semibold text-link whitespace-nowrap"><?php echo e(format_phone($p)); ?></a><?php if(! $loop->last): ?> or <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></dd></div>
                    <div class="grid gap-1 py-3.5 sm:grid-cols-[11rem_1fr]"><dt class="font-bold">Facebook</dt><dd><a href="<?php echo e(ccmc('facebook')); ?>" class="inline-flex min-h-11 items-center gap-2 font-semibold text-link" rel="noopener" target="_blank"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'facebook','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'facebook','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>facebook.com/ccmctt</a></dd></div>
                </dl>
            </section>
            <section aria-labelledby="addr-title">
                <h2 id="addr-title" class="display-3">Find us</h2>
                <address class="mt-4 not-italic text-lg"><?php echo e($address['street']); ?>, <?php echo e($address['area']); ?><br><?php echo e($address['city']); ?>, <?php echo e($address['country']); ?></address>
                <p class="mt-1 text-ink-2"><?php echo e(ucfirst($address['landmark'])); ?>.</p>
                <div class="mt-5 overflow-hidden rounded-2xl border border-line">
                    <iframe title="Map showing Cross Crossing Medical Centre" src="https://www.openstreetmap.org/export/embed.html?bbox=<?php echo e($bbox); ?>&amp;layer=mapnik&amp;marker=<?php echo e($lat); ?>,<?php echo e($lng); ?>" class="block aspect-[4/3] w-full" loading="lazy" referrerpolicy="no-referrer"></iframe>
                </div>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="<?php echo e(ccmc('map_url')); ?>" class="btn btn-primary" target="_blank" rel="noopener"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'map-pin','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'map-pin','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Directions in Google Maps</a>
                    <a href="https://www.openstreetmap.org/?mlat=<?php echo e($lat); ?>&amp;mlon=<?php echo e($lng); ?>#map=17/<?php echo e($lat); ?>/<?php echo e($lng); ?>" class="btn btn-outline" target="_blank" rel="noopener">Larger map</a>
                </div>
            </section>
        </div>

        <section aria-labelledby="msg-title">
            <form method="POST" action="<?php echo e(route('contact.store')); ?>" class="panel space-y-8 p-6 md:p-9" x-data="requestForm" @submit="submit">
                <?php echo csrf_field(); ?>
                <h2 id="msg-title" class="display-3">Send a message</h2>
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
                <fieldset>
                    <legend class="label">What's it about?</legend>
                    <div class="grid gap-2 sm:grid-cols-2">
                        <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="choice"><input type="radio" name="topic" value="<?php echo e($v); ?>" required <?php if($topic === $v): echo 'checked'; endif; ?>><?php echo e($t); ?></label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php if (isset($component)) { $__componentOriginal26e98e8e5cc4164d9d54ab94efc26e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e98e8e5cc4164d9d54ab94efc26e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.error','data' => ['for' => 'topic']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'topic']); ?>
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
                </fieldset>
                <?php if (isset($component)) { $__componentOriginalae4c123bc9806121d87d234de2f27a3b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae4c123bc9806121d87d234de2f27a3b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.field','data' => ['name' => 'message','label' => 'Message','type' => 'textarea','required' => true,'rows' => '5','maxlength' => '3000','hint' => 'Please don\'t include medical details here. To book, use the appointment form.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'message','label' => 'Message','type' => 'textarea','required' => true,'rows' => '5','maxlength' => '3000','hint' => 'Please don\'t include medical details here. To book, use the appointment form.']); ?>
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
                <?php if (isset($component)) { $__componentOriginalbb1209e37896c727d4c623f730746632 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb1209e37896c727d4c623f730746632 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.contact-fields','data' => ['step' => 2,'title' => 'How to reach you']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('contact-fields'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['step' => 2,'title' => 'How to reach you']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.consent','data' => ['purpose' => 'so that the centre can reply to my message']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('consent'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['purpose' => 'so that the centre can reply to my message']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.submit','data' => ['label' => 'Send message']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Send message']); ?>
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
        </section>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e)): ?>
<?php $attributes = $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e; ?>
<?php unset($__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfefb4fd9b7004fa65f70c415ac76903e)): ?>
<?php $component = $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e; ?>
<?php unset($__componentOriginalfefb4fd9b7004fa65f70c415ac76903e); ?>
<?php endif; ?>
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/pages/contact.blade.php ENDPATH**/ ?>