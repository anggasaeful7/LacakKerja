<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'laneKey', 'workOrders', 'technician' => null, 'technicians', 'filters', 'selectedDate']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title', 'laneKey', 'workOrders', 'technician' => null, 'technicians', 'filters', 'selectedDate']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<section class="flex min-h-[18rem] flex-col rounded-card border border-border bg-surface" aria-labelledby="lane-<?php echo e($laneKey); ?>">
    <div class="flex items-center gap-3 border-b border-border px-4 py-3"><span class="size-3 rounded-full" style="background-color: <?php echo e($technician?->technicianProfile?->display_color ?? '#94a3b8'); ?>"></span><div class="min-w-0 flex-1"><h3 id="lane-<?php echo e($laneKey); ?>" class="truncate font-semibold text-foreground"><?php echo e($title); ?></h3><p class="text-xs text-muted-foreground"><?php echo e($workOrders->count()); ?> pekerjaan</p></div></div>
    <div class="flex flex-1 flex-col gap-3 p-3">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $workOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <article class="rounded-control border border-border bg-background p-3 shadow-sm transition hover:border-accent/60">
                <div class="flex items-start justify-between gap-2"><a href="<?php echo e(route('work-orders.show', $workOrder)); ?>" class="font-semibold text-foreground hover:text-accent focus:outline-none focus:ring-2 focus:ring-ring/40" wire:navigate><?php echo e($workOrder->number); ?></a><?php if (isset($component)) { $__componentOriginald937aa70a0ae81844cc7808a9f1b2f7a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald937aa70a0ae81844cc7808a9f1b2f7a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lk-priority-badge','data' => ['priority' => $workOrder->priority->value]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lk-priority-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['priority' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($workOrder->priority->value)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald937aa70a0ae81844cc7808a9f1b2f7a)): ?>
<?php $attributes = $__attributesOriginald937aa70a0ae81844cc7808a9f1b2f7a; ?>
<?php unset($__attributesOriginald937aa70a0ae81844cc7808a9f1b2f7a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald937aa70a0ae81844cc7808a9f1b2f7a)): ?>
<?php $component = $__componentOriginald937aa70a0ae81844cc7808a9f1b2f7a; ?>
<?php unset($__componentOriginald937aa70a0ae81844cc7808a9f1b2f7a); ?>
<?php endif; ?></div>
                <p class="mt-2 line-clamp-2 text-sm text-foreground"><?php echo e($workOrder->title); ?></p><p class="mt-2 text-xs text-muted-foreground"><?php echo e($workOrder->customer->name); ?> · <?php echo e($workOrder->site->city ?? $workOrder->site->name); ?></p>
                <p class="mt-2 text-xs text-muted-foreground"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->scheduled_start): ?><?php echo e($workOrder->scheduled_start->format('H:i')); ?>–<?php echo e($workOrder->scheduled_end?->format('H:i')); ?> · <?php echo e($workOrder->scheduled_start->format('d M')); ?><?php else: ?> Belum dijadwalkan <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></p>
                <div class="mt-3 flex items-center justify-between gap-2"><?php if (isset($component)) { $__componentOriginal3fd872b7fd21dc9020e78faa7528b9be = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd872b7fd21dc9020e78faa7528b9be = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lk-status-badge','data' => ['status' => $workOrder->status->value]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lk-status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($workOrder->status->value)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd872b7fd21dc9020e78faa7528b9be)): ?>
<?php $attributes = $__attributesOriginal3fd872b7fd21dc9020e78faa7528b9be; ?>
<?php unset($__attributesOriginal3fd872b7fd21dc9020e78faa7528b9be); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd872b7fd21dc9020e78faa7528b9be)): ?>
<?php $component = $__componentOriginal3fd872b7fd21dc9020e78faa7528b9be; ?>
<?php unset($__componentOriginal3fd872b7fd21dc9020e78faa7528b9be); ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((int) $workOrder->getAttribute('schedule_conflict_count') > 0): ?><span class="text-xs font-semibold text-danger-content" role="status">Bentrok: <?php echo e($workOrder->getAttribute('schedule_conflict_count')); ?> jadwal</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
                <details class="mt-3"><summary class="min-h-11 cursor-pointer rounded-control border border-border px-3 py-2 text-center text-sm font-medium text-foreground transition hover:bg-surface-subtle focus:outline-none focus:ring-2 focus:ring-ring/40">Atur assignment & jadwal</summary><div class="mt-3 border-t border-border pt-3"><?php if (isset($component)) { $__componentOriginala6d4fb3df01a09dce285e5cf22d26ad0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala6d4fb3df01a09dce285e5cf22d26ad0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dispatch.schedule-form','data' => ['workOrder' => $workOrder,'technicians' => $technicians,'selectedDate' => $selectedDate,'filters' => $filters]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dispatch.schedule-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['work-order' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($workOrder),'technicians' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($technicians),'selected-date' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedDate),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filters)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala6d4fb3df01a09dce285e5cf22d26ad0)): ?>
<?php $attributes = $__attributesOriginala6d4fb3df01a09dce285e5cf22d26ad0; ?>
<?php unset($__attributesOriginala6d4fb3df01a09dce285e5cf22d26ad0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala6d4fb3df01a09dce285e5cf22d26ad0)): ?>
<?php $component = $__componentOriginala6d4fb3df01a09dce285e5cf22d26ad0; ?>
<?php unset($__componentOriginala6d4fb3df01a09dce285e5cf22d26ad0); ?>
<?php endif; ?></div></details>
            </article>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <p class="flex min-h-28 items-center justify-center rounded-control border border-dashed border-border p-4 text-center text-sm text-muted-foreground">Belum ada pekerjaan</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\components\dispatch\lane.blade.php ENDPATH**/ ?>