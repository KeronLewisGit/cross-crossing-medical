<?php
    use App\Enums\SubmissionStatus;
    use App\Enums\SubmissionType as T;
    use App\Http\Controllers\FormController as F;
    $d = $s->details ?? [];
    $date = fn ($v) => $v ? \Illuminate\Support\Carbon::parse($v)->format('j M Y') : null;
    $weekdays = (array) ccmc('weekdays');
    // Label => value for the request's own details, in reading order. Nulls are skipped.
    $rows = match ($s->type) {
        T::Appointment => [
            'Clinic or test' => $s->subject(),
            'Seen at CCMC before' => ['yes' => 'Yes', 'no' => 'No, first visit', 'unsure' => 'Not sure'][$d['seen_before'] ?? ''] ?? null,
            'Days that suit' => collect((array) ($d['days'] ?? []))->map(fn ($k) => $weekdays[$k] ?? $k)->implode(', ') ?: null,
            'Time of day' => ccmc('time_windows.'.($d['window'] ?? '')) ?: null,
            'Earliest date' => $date($d['from_date'] ?? null) ?? 'As soon as possible',
            'Reason' => $d['reason'] ?? null,
        ],
        T::Dialysis => [
            'Situation' => F::dialysisSituations()[$d['situation'] ?? ''] ?? (ccmc('dialysis.situations.'.($d['situation'] ?? '')) ?: null),
            'Current unit or doctor' => $d['current_unit'] ?? null,
            'Days' => ccmc('dialysis.schedules.'.($d['schedule'] ?? '')) ?: null,
            'Time' => ccmc('dialysis.shifts.'.($d['shift'] ?? '')) ?: null,
            'Visiting' => ($d['visit_from'] ?? null) ? $date($d['visit_from']).' to '.$date($d['visit_to'] ?? null) : null,
            'Message' => $s->message,
        ],
        T::Registration => $canSeePersonal ? [
            'Patient' => $d['patient_name'] ?? null,
            'Date of birth' => $date($d['patient_dob'] ?? null),
            'Sex' => ['female' => 'Female', 'male' => 'Male', 'unsaid' => 'Prefer not to say'][$d['sex'] ?? ''] ?? null,
            'Filled in by' => ($d['for_whom'] ?? 'self') === 'other' ? $s->name.(($d['relationship'] ?? null) ? ' ('.$d['relationship'].')' : '') : 'The patient',
            'Address' => trim(($d['address'] ?? '').', '.($d['town'] ?? ''), ', ') ?: null,
            'ID to bring' => F::ID_TYPES[$d['id_type'] ?? ''] ?? null,
            'Insurance' => ($d['insured'] ?? 'no') === 'yes' ? ($d['insurer'] ?? 'Yes') : 'None or not sure',
            'Emergency contact' => trim(($d['emergency_name'] ?? '').(($d['emergency_relationship'] ?? null) ? ' ('.$d['emergency_relationship'].')' : '').' · '.format_phone((string) ($d['emergency_phone'] ?? '')), ' ·'),
            'Reminders' => ! empty($d['reminders']) ? 'Yes, please' : 'No',
        ] : ['Details' => 'Restricted to the registration and medical records team.'],
        T::Career => [
            'Applying for' => $s->subject(),
            'Experience' => F::EXPERIENCE[$d['experience'] ?? ''] ?? null,
            'Registration no.' => $d['registration'] ?? null,
            'Available for' => collect((array) ($d['availability'] ?? []))->map(fn ($k) => ccmc('availability.'.$k) ?: $k)->implode(', ') ?: null,
            'Can start' => $date($d['available_from'] ?? null),
            'Note' => $s->message,
        ],
        T::Enquiry => [
            'Topic' => F::TOPICS[$d['topic'] ?? ''] ?? null,
            'Message' => $s->message,
        ],
    };
    if (in_array($s->type, [T::Appointment, T::Dialysis], true)) {
        $rows = ['Patient' => $s->patientName().(($d['for_whom'] ?? 'self') === 'other' ? ' (requested by '.$s->name.(($d['relationship'] ?? null) ? ', '.$d['relationship'] : '').')' : ''), 'Date of birth' => $date($d['patient_dob'] ?? null)] + $rows;
    }
    $rows = array_filter($rows, fn ($v) => $v !== null && $v !== '');
    $digits = nanp_digits($s->phone);
?>
<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => $s->patientName()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($s->patientName())]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($neighbours['prev']): ?><a href="<?php echo e(route('admin.submissions.show', $neighbours['prev'])); ?>" class="a-btn a-btn-ghost w-11 px-0 ring-1 ring-line" aria-label="Previous request"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'chevron-left']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'chevron-left']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a><?php endif; ?>
        <?php if($neighbours['next']): ?><a href="<?php echo e(route('admin.submissions.show', $neighbours['next'])); ?>" class="a-btn a-btn-ghost w-11 px-0 ring-1 ring-line" aria-label="Next request"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'chevron-right']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'chevron-right']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a><?php endif; ?>
        <a href="<?php echo e(route('admin.submissions.index')); ?>" class="a-btn a-btn-ghost ring-1 ring-line">Inbox</a>
     <?php $__env->endSlot(); ?>

    <div class="mb-5 flex flex-wrap items-center gap-2 text-sm">
        <span class="chip"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $s->type->icon()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($s->type->icon())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php echo e($s->type->label()); ?></span>
        <?php if (isset($component)) { $__componentOriginal51ed764111e345fc11534f121cfeb451 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51ed764111e345fc11534f121cfeb451 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status','data' => ['status' => $s->status,'type' => $s->type]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($s->status),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($s->type)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $attributes = $__attributesOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__attributesOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $component = $__componentOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__componentOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?>
        <span class="kbd num !text-sm"><?php echo e($s->reference); ?></span>
        <span class="text-ink-3">Received <?php echo e($s->created_at->format('D j M Y, H:i')); ?> (<?php echo e($s->created_at->diffForHumans()); ?>)</span>
        <?php if($s->isOverdue()): ?><span class="chip" data-tone="critical"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'clock']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'clock']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Overdue: due <?php echo e($s->dueAt()->diffForHumans()); ?></span><?php elseif($s->status === SubmissionStatus::New): ?><span class="chip" data-tone="attention"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'clock']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'clock']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Call by <?php echo e($s->dueAt()->format('H:i')); ?></span><?php endif; ?>
        <?php if($s->is_demo): ?><span class="demo-badge">Demo data</span><?php endif; ?>
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1.5fr)_minmax(0,1fr)]">
        <div class="min-w-0 space-y-6">
            <section class="a-card p-5 md:p-6" aria-labelledby="who">
                <h2 id="who" class="font-semibold">Contact</h2>
                <dl class="dl-grid mt-4">
                    <dt>Name</dt><dd class="font-semibold"><?php echo e($s->name); ?></dd>
                    <dt>Phone</dt><dd><a href="<?php echo e(tel_href($s->phone)); ?>" class="inline-flex min-h-11 items-center font-semibold text-link num"><?php echo e(format_phone($s->phone)); ?></a></dd>
                    <?php if($s->email): ?><dt>Email</dt><dd><a href="mailto:<?php echo e($s->email); ?>" class="inline-flex min-h-11 items-center break-all text-link"><?php echo e($s->email); ?></a></dd><?php endif; ?>
                    <dt>Prefers</dt><dd><?php echo e(['phone' => 'Phone call', 'whatsapp' => 'WhatsApp', 'email' => 'Email'][$s->contact_pref] ?? $s->contact_pref); ?></dd>
                    <?php if($s->consented_at): ?><dt>Consent</dt><dd class="text-sm text-ink-2">Given <?php echo e($s->consented_at->format('j M Y, H:i')); ?></dd><?php endif; ?>
                </dl>
                <div class="mt-5 flex flex-wrap gap-2">
                    <a href="<?php echo e(tel_href($s->phone)); ?>" class="a-btn a-btn-primary"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'phone','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'phone','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Call</a>
                    <?php if($digits): ?><a href="<?php echo e(wa_href($s->phone, 'Hello, this is Cross Crossing Medical Centre about your request '.$s->reference.'.')); ?>" class="a-btn a-btn-ghost ring-1 ring-line" target="_blank" rel="noopener"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'whatsapp','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'whatsapp','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>WhatsApp</a><?php endif; ?>
                </div>
            </section>

            <section class="a-card p-5 md:p-6" aria-labelledby="req">
                <h2 id="req" class="font-semibold"><?php echo e($s->type->label()); ?></h2>
                <dl class="dl-grid mt-4">
                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><dt><?php echo e($label); ?></dt><dd class="whitespace-pre-line"><?php echo e($value); ?></dd><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </dl>
            </section>

            <section class="a-card p-5 md:p-6" aria-labelledby="docs">
                <h2 id="docs" class="font-semibold">Documents</h2>
                <?php $__empty_1 = true; $__currentLoopData = $s->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php ($can = auth()->user()->can('openFile', [$s, $f])); ?>
                    <div class="mt-3 flex flex-wrap items-center gap-3 rounded-lg border border-line p-3">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $f->isRestricted() ? 'lock' : 'file','class' => 'h-5 w-5 flex-none text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($f->isRestricted() ? 'lock' : 'file'),'class' => 'h-5 w-5 flex-none text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                        <div class="min-w-0 flex-1"><p class="font-semibold"><?php echo e($f->label()); ?></p><p class="truncate text-xs text-ink-3"><?php echo e($can ? $f->original_name : 'File name hidden'); ?> · <?php echo e(number_format($f->size / 1024)); ?> KB</p></div>
                        <?php if($can): ?>
                            <a href="<?php echo e(route('admin.submissions.file', [$s, $f])); ?>" class="a-btn a-btn-ghost ring-1 ring-line" target="_blank" rel="noopener"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'eye','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'eye','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Open</a>
                            <a href="<?php echo e(route('admin.submissions.file', [$s, $f, 'download' => 1])); ?>" class="a-btn a-btn-ghost w-11 px-0 ring-1 ring-line" aria-label="Download <?php echo e($f->label()); ?>"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'download','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'download','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a>
                        <?php else: ?>
                            <span class="chip" data-tone="muted"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'lock']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'lock']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Records team only</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="mt-2 text-sm text-ink-3">No documents attached.</p>
                <?php endif; ?>
                <?php if($s->files->contains(fn ($f) => $f->isRestricted())): ?>
                    <p class="mt-4 text-xs text-ink-3">ID and insurance cards open for the registration and medical records team only. Every opening is logged with your name and the time.</p>
                <?php endif; ?>
            </section>

            <section id="timeline" class="a-card p-5 md:p-6" aria-labelledby="tl">
                <h2 id="tl" class="font-semibold">Timeline</h2>
                <form method="POST" action="<?php echo e(route('admin.submissions.note', $s)); ?>" class="mt-4 space-y-3">
                    <?php echo csrf_field(); ?>
                    <label for="note-body" class="sr-only">Add a note</label>
                    <textarea id="note-body" name="body" rows="3" class="a-input w-full" placeholder="What happened on the call? Keep clinical detail in the patient file, not here." required maxlength="3000"></textarea>
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <label class="flex min-h-11 items-center gap-2 text-sm"><input type="checkbox" name="contacted" value="1" class="h-5 w-5 accent-[color:var(--primary)]" <?php if($s->status === SubmissionStatus::New): echo 'checked'; endif; ?>>I spoke to them (counts as first contact)</label>
                        <button class="a-btn a-btn-primary">Add note</button>
                    </div>
                </form>
                <ol class="mt-6 space-y-4 border-l-2 border-line pl-5">
                    <?php $__currentLoopData = $s->notes->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="relative">
                            <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['absolute -left-[1.72rem] top-1 grid h-5 w-5 place-items-center rounded-full ring-4 ring-surface', 'bg-[color:var(--attention)]' => $n->kind === 'access', 'bg-[color:var(--series-1)]' => $n->kind !== 'access']); ?>" aria-hidden="true"></span>
                            <p class="text-sm"><span class="font-semibold"><?php echo e($n->user->name ?? 'Website'); ?></span> <span class="text-ink-3">· <?php echo e($n->created_at->format('j M, H:i')); ?><?php if($n->kind === 'access'): ?> · document opened <?php endif; ?></span></p>
                            <p class="mt-0.5 whitespace-pre-line"><?php echo e($n->body); ?></p>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            </section>
        </div>

        <aside class="min-w-0 space-y-6">
            <form method="POST" action="<?php echo e(route('admin.submissions.update', $s)); ?>" class="a-card space-y-4 p-5 md:p-6">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <h2 class="font-semibold">Status</h2>
                <div class="grid gap-2">
                    <?php $__currentLoopData = SubmissionStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex min-h-11 cursor-pointer items-center gap-3 rounded-lg border border-line px-3 has-[:checked]:border-[color:var(--primary)] has-[:checked]:bg-soft"><input type="radio" name="status" value="<?php echo e($st->value); ?>" class="h-5 w-5 accent-[color:var(--primary)]" <?php if($s->status === $st): echo 'checked'; endif; ?>><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $st->icon(),'class' => 'h-4 w-4 text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($st->icon()),'class' => 'h-4 w-4 text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php echo e($st->label($s->type)); ?></label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div>
                    <label for="assigned_to" class="mb-1 block text-sm font-semibold">Assigned to</label>
                    <select id="assigned_to" name="assigned_to" class="a-input w-full"><option value="">Nobody</option><?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($u->id); ?>" <?php if($s->assigned_to === $u->id): echo 'selected'; endif; ?>><?php echo e($u->name); ?> (<?php echo e($u->role->label()); ?>)</option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                </div>
                <?php if($s->type->hasBooking()): ?>
                    <div class="grid grid-cols-[1fr_8rem] gap-3">
                        <div><label for="booked_date" class="mb-1 block text-sm font-semibold"><?php echo e($s->type === T::Career ? 'Interview' : 'Booked'); ?> date</label><input id="booked_date" name="booked_date" type="date" value="<?php echo e($s->booked_date?->toDateString()); ?>" class="a-input w-full"></div>
                        <div><label for="booked_time" class="mb-1 block text-sm font-semibold">Time</label><input id="booked_time" name="booked_time" type="time" value="<?php echo e($s->booked_time); ?>" class="a-input w-full"></div>
                    </div>
                    <p class="text-xs text-ink-3">Setting a date moves a new or called-back request to <?php echo e(SubmissionStatus::Booked->label($s->type)); ?>.</p>
                <?php endif; ?>
                <button class="a-btn a-btn-primary w-full">Save</button>
            </form>
            <div class="a-card p-5 text-sm text-ink-2 md:p-6">
                <h2 class="font-semibold text-ink">Good to know</h2>
                <ul class="mt-3 list-disc space-y-1.5 pl-5">
                    <li>The patient was told: "We call back, usually within <?php echo e($s->type->responseHours()); ?> <?php echo e(\Illuminate\Support\Str::plural('hour', $s->type->responseHours())); ?>."</li>
                    <li>Emails to the patient never include health details. Give results by phone or in person only.</li>
                    <?php if($s->source_url): ?><li class="break-all">Sent from <?php echo e($s->source_url); ?></li><?php endif; ?>
                </ul>
            </div>
        </aside>
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
<?php /**PATH /Users/keronlewis/cross-crossing-medical/resources/views/admin/submissions/show.blade.php ENDPATH**/ ?>