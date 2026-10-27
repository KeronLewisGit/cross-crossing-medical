<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Privacy notice','description' => 'How Cross Crossing Medical Centre collects, uses and protects personal and health information sent through this website, under the Data Protection Act, 2011 of Trinidad and Tobago.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Privacy notice','description' => 'How Cross Crossing Medical Centre collects, uses and protects personal and health information sent through this website, under the Data Protection Act, 2011 of Trinidad and Tobago.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Privacy notice','lead' => 'How we handle the personal and health information you send through this website.','code' => 'DPA','label' => 'Privacy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Privacy notice','lead' => 'How we handle the personal and health information you send through this website.','code' => 'DPA','label' => 'Privacy']); ?>
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
    <div class="wrap mt-12 md:mt-16">
        <p class="max-w-3xl rounded-xl bg-soft p-4 text-[0.9375rem] font-semibold">Draft for the centre's review: this notice must be checked by the centre and its legal adviser before the site goes live.</p>
        <div class="prose-copy measure mt-10 text-lg">
            <h2>Who we are</h2>
            <p><?php echo e(ccmc('name')); ?>, <?php echo e(ccmc('address.street')); ?>, <?php echo e(ccmc('address.area')); ?>, <?php echo e(ccmc('address.city')); ?>, Trinidad and Tobago ("the centre", "we"). You can contact us about your information at <a href="mailto:<?php echo e(ccmc('email')); ?>"><?php echo e(ccmc('email')); ?></a> or on <?php echo e(format_phone(main_phone())); ?>.</p>

            <h2>What this website collects</h2>
            <p>Only what you type into a form, and the files you choose to attach:</p>
            <ul>
                <li><strong>Appointment requests:</strong> the patient's name and date of birth, the clinic or test, the days and times that suit, a short reason, and an optional referral letter.</li>
                <li><strong>New patient registration:</strong> the patient's name, date of birth, address, emergency contact, ID type, insurer, and optional photos of the ID and insurance card.</li>
                <li><strong>Dialysis enquiries:</strong> the patient's situation, preferred sessions and an optional referral or dialysis summary.</li>
                <li><strong>Job applications:</strong> your CV, certificates, experience and availability.</li>
                <li><strong>Messages:</strong> what you write to us.</li>
            </ul>
            <p>For every form we also keep your phone number, optional email address, how you prefer to be contacted, the page you sent it from, and the date and time you gave consent.</p>
            <p>We do not use advertising or tracking cookies. The website sets one session cookie so forms work securely.</p>

            <h2>Why we use it</h2>
            <p>To call you back, book the appointment or assessment you asked for, open a patient file, or consider your job application. We use it only for the purpose you consented to on the form, and never sell or share it for marketing.</p>
            <p>Sensitive personal information, including health information, is handled with the extra care the Data Protection Act, 2011 requires.</p>

            <h2>Who can see it</h2>
            <p>Each request is seen only by the team that handles it: front desk and appointments, registration and medical records, or human resources. Photos of ID and insurance cards are stored privately, off the public website, and can be opened only by the registration and medical records team. Every opening is logged with the staff member and the time.</p>
            <p>Confirmation emails contain your reference number only, never health or identity details. Test results are never published on this website or sent by email.</p>

            <h2>How long we keep it</h2>
            <p>Appointment and dialysis requests and messages: 12 months after the request is closed, unless they become part of a patient file. Registration details become part of the patient's medical record and are kept as medical records must be. Job applications: six months, unless you are hired.</p>

            <h2>Your rights</h2>
            <p>You can ask to see the information we hold about you, ask us to correct it, or withdraw your consent, by writing to <a href="mailto:<?php echo e(ccmc('email')); ?>"><?php echo e(ccmc('email')); ?></a> or asking at reception. Withdrawing consent does not affect care already given.</p>

            <h2>Security</h2>
            <p>The website uses an encrypted (HTTPS) connection. Staff sign in with individual accounts, each limited to their own team's work, and inactive accounts are switched off.</p>
        </div>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/pages/privacy.blade.php ENDPATH**/ ?>