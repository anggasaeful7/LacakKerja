<?php # [BlazeFolded]:{flux::icon.clipboard-document-list}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/clipboard-document-list.blade.php}:{1786975751} ?>
<?php if (isset($component)) { $__componentOriginal7e1e7b7fade6aeb109492d5899cdfbcf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7e1e7b7fade6aeb109492d5899cdfbcf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.technician','data' => ['title' => __('Tugas')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.technician'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Tugas'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="space-y-6">
        <header><p class="text-sm font-medium text-accent"><?php echo e(__('Pekerjaan saya')); ?></p><h1 class="mt-1 text-3xl font-semibold tracking-tight text-on-surface">Tugas</h1><p class="mt-2 text-base text-on-surface-variant">Semua pekerjaan yang ditugaskan kepada <?php echo e(auth()->user()->name); ?>.</p></header>
        <nav class="grid grid-cols-3 gap-2 rounded-card border border-border bg-surface p-1" aria-label="Filter tugas"><a href="<?php echo e(route('technician.tasks', ['tab' => 'upcoming'])); ?>" class="flex min-h-11 items-center justify-center rounded-control px-3 text-sm font-semibold transition <?php echo e($tab === 'upcoming' ? 'bg-accent text-white' : 'text-muted-foreground hover:bg-surface-subtle'); ?>" wire:navigate>Berikutnya</a><a href="<?php echo e(route('technician.tasks', ['tab' => 'active'])); ?>" class="flex min-h-11 items-center justify-center rounded-control px-3 text-sm font-semibold transition <?php echo e($tab === 'active' ? 'bg-accent text-white' : 'text-muted-foreground hover:bg-surface-subtle'); ?>" wire:navigate>Aktif</a><a href="<?php echo e(route('technician.tasks', ['tab' => 'history'])); ?>" class="flex min-h-11 items-center justify-center rounded-control px-3 text-sm font-semibold transition <?php echo e($tab === 'history' ? 'bg-accent text-white' : 'text-muted-foreground hover:bg-surface-subtle'); ?>" wire:navigate>Riwayat</a></nav>
        <section aria-labelledby="tasks-list-title" class="space-y-3"><div class="flex items-center justify-between gap-3"><h2 id="tasks-list-title" class="text-xs font-semibold uppercase tracking-[0.14em] text-muted-foreground"><?php echo e(ucfirst($tab)); ?></h2><span class="text-xs text-muted-foreground"><?php echo e($workOrders->total()); ?> pekerjaan</span></div><div class="space-y-3"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $workOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><?php if (isset($component)) { $__componentOriginalf79102bc95371f438673ccaaf7e38cb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf79102bc95371f438673ccaaf7e38cb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.technician.task-card','data' => ['workOrder' => $workOrder,'compact' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('technician.task-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['work-order' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($workOrder),'compact' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf79102bc95371f438673ccaaf7e38cb4)): ?>
<?php $attributes = $__attributesOriginalf79102bc95371f438673ccaaf7e38cb4; ?>
<?php unset($__attributesOriginalf79102bc95371f438673ccaaf7e38cb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf79102bc95371f438673ccaaf7e38cb4)): ?>
<?php $component = $__componentOriginalf79102bc95371f438673ccaaf7e38cb4; ?>
<?php unset($__componentOriginalf79102bc95371f438673ccaaf7e38cb4); ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?><div class="lk-panel p-8 text-center"><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 mx-auto size-10 text-muted-foreground" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?><p class="mt-3 font-semibold text-on-surface">Belum ada pekerjaan</p><p class="mt-1 text-sm text-on-surface-variant">Tugas yang masuk akan muncul di sini.</p></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrders->hasPages()): ?><div class="pt-2"><?php echo e($workOrders->links()); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></section>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7e1e7b7fade6aeb109492d5899cdfbcf)): ?>
<?php $attributes = $__attributesOriginal7e1e7b7fade6aeb109492d5899cdfbcf; ?>
<?php unset($__attributesOriginal7e1e7b7fade6aeb109492d5899cdfbcf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e1e7b7fade6aeb109492d5899cdfbcf)): ?>
<?php $component = $__componentOriginal7e1e7b7fade6aeb109492d5899cdfbcf; ?>
<?php unset($__componentOriginal7e1e7b7fade6aeb109492d5899cdfbcf); ?>
<?php endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views/pages/technician/tasks.blade.php ENDPATH**/ ?>