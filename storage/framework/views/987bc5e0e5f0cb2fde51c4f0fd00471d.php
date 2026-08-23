<?php # [BlazeFolded]:{flux::icon.clock}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/clock.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.map-pin}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/map-pin.blade.php}:{1786975751} ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['workOrder', 'compact' => false]));

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

foreach (array_filter((['workOrder', 'compact' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<a href="<?php echo e(route('technician.work-orders.show', $workOrder)); ?>" wire:navigate aria-label="<?php echo e($workOrder->number); ?> — <?php echo e($workOrder->title); ?>" class="lk-clickable block rounded-card border border-border bg-surface p-4 shadow-card focus:outline-none focus:ring-2 focus:ring-ring/40 <?php echo e($compact ? 'sm:flex sm:items-center sm:gap-4' : ''); ?>">
    <div class="flex items-start justify-between gap-3"><div><span class="lk-number text-xs font-semibold tracking-wide text-muted-foreground"><?php echo e($workOrder->number); ?></span><p class="mt-1 text-xs text-muted-foreground"><?php echo e($workOrder->scheduled_start?->format('d M Y') ?: 'Belum dijadwalkan'); ?></p></div><?php if (isset($component)) { $__componentOriginald937aa70a0ae81844cc7808a9f1b2f7a = $component; } ?>
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
    <div class="min-w-0 <?php echo e($compact ? 'sm:flex-1' : ''); ?>"><h3 class="mt-3 truncate text-base font-semibold text-on-surface"><?php echo e($workOrder->title); ?></h3><p class="mt-1 truncate text-sm text-on-surface-variant"><?php echo e($workOrder->customer->name); ?></p></div>
    <div class="mt-4 flex flex-wrap items-center gap-x-3 gap-y-2 text-xs text-muted-foreground <?php echo e($compact ? 'sm:mt-0' : ''); ?>"><span class="inline-flex min-h-11 items-center gap-1.5"><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?><?php echo e($workOrder->scheduled_start ? $workOrder->scheduled_start->format('H:i').'–'.$workOrder->scheduled_end?->format('H:i') : 'Atur jadwal'); ?></span><span class="inline-flex min-h-11 items-center gap-1.5"><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?><?php echo e($workOrder->site->city ?? $workOrder->site->name); ?></span></div>
    <div class="mt-3 border-t border-border pt-3 <?php echo e($compact ? 'sm:mt-0 sm:border-0 sm:pt-0' : ''); ?>"><?php if (isset($component)) { $__componentOriginal3fd872b7fd21dc9020e78faa7528b9be = $component; } ?>
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
<?php endif; ?></div>
</a><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\components\technician\task-card.blade.php ENDPATH**/ ?>