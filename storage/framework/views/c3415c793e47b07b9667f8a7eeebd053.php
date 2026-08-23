<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['workOrder', 'technicians', 'selectedDate', 'filters']));

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

foreach (array_filter((['workOrder', 'technicians', 'selectedDate', 'filters']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<form method="POST" action="<?php echo e(route('dispatch.schedule', $workOrder)); ?>" class="space-y-3" onsubmit="if (! confirm('Simpan assignment dan jadwal ini?')) { return false; } const button = this.querySelector('button[type=submit]'); button.disabled = true; button.textContent = 'Menyimpan...'; return true;">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="return_date" value="<?php echo e($selectedDate->toDateString()); ?>"><input type="hidden" name="return_view" value="<?php echo e(request('view', 'day')); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['technician_id', 'status', 'priority', 'area', 'q']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $returnKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><input type="hidden" name="return_<?php echo e($returnKey); ?>" value="<?php echo e($filters[$returnKey] ?? ''); ?>"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    <div><label for="technician-<?php echo e($workOrder->id); ?>" class="mb-1 block text-xs font-semibold text-foreground">Teknisi</label><select id="technician-<?php echo e($workOrder->id); ?>" name="technician_id" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"><option value="">Belum ditugaskan</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($membership->user_id); ?>" <?php if($workOrder->primaryAssignment?->user_id === $membership->user_id): echo 'selected'; endif; ?>><?php echo e($membership->user->name); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
    <div class="grid gap-3 sm:grid-cols-2"><div><label for="start-<?php echo e($workOrder->id); ?>" class="mb-1 block text-xs font-semibold text-foreground">Mulai</label><input id="start-<?php echo e($workOrder->id); ?>" type="datetime-local" name="scheduled_start" value="<?php echo e($workOrder->scheduled_start?->format('Y-m-d\\TH:i')); ?>" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div><div><label for="end-<?php echo e($workOrder->id); ?>" class="mb-1 block text-xs font-semibold text-foreground">Selesai</label><input id="end-<?php echo e($workOrder->id); ?>" type="datetime-local" name="scheduled_end" value="<?php echo e($workOrder->scheduled_end?->format('Y-m-d\\TH:i')); ?>" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div></div>
    <label class="flex cursor-pointer items-start gap-2 text-xs text-muted-foreground"><input type="checkbox" name="confirmed" value="1" required class="mt-0.5 size-4 rounded border-border text-accent focus:ring-ring/40"><span>Saya sudah meninjau assignment dan jadwal ini.</span></label>
    <button type="submit" class="inline-flex min-h-11 w-full cursor-pointer items-center justify-center gap-2 rounded-control bg-accent px-3 text-sm font-semibold text-white transition hover:bg-accent/90 focus:outline-none focus:ring-2 focus:ring-ring/40">Simpan setelah konfirmasi</button>
</form><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\components\dispatch\schedule-form.blade.php ENDPATH**/ ?>