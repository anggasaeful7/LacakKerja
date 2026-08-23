<?php # [BlazeFolded]:{flux::icon.building-office-2}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/building-office-2.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.arrow-right}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/arrow-right.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.map}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/map.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.check-circle}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/check-circle.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php if (isset($component)) { $__componentOriginal7e1e7b7fade6aeb109492d5899cdfbcf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7e1e7b7fade6aeb109492d5899cdfbcf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.technician','data' => ['title' => __('Hari Ini')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.technician'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Hari Ini'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="space-y-6" data-offline-page="today">
        <header>
            <p class="text-sm font-medium text-accent"><?php echo e($today->translatedFormat('l, d F Y')); ?></p>
            <h1 class="mt-1 text-3xl font-semibold tracking-tight text-on-surface">Selamat datang, <?php echo e(auth()->user()->name); ?></h1>
            <p class="mt-2 text-base text-on-surface-variant"><?php echo e($summary['total']); ?> tugas di agenda hari ini · <?php echo e($summary['active']); ?> perlu perhatian.</p>
        </header>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?><div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content" role="status" aria-live="polite"><?php echo e(session('status')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?><div class="lk-card border-danger/30 bg-danger-soft p-4 text-sm text-danger-content" role="alert"><p class="font-semibold">Aksi belum tersimpan.</p><ul class="mt-1 list-disc ps-5"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><li><?php echo e($error); ?></li><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></ul></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($nextTask): ?>
            <section aria-labelledby="next-task-title" class="space-y-3">
                <div class="flex items-center justify-between gap-3"><h2 id="next-task-title" class="text-xs font-semibold uppercase tracking-[0.14em] text-muted-foreground">Tugas berikutnya</h2><?php if (isset($component)) { $__componentOriginal293d7ec7115725dbc5538d4bd6e40978 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal293d7ec7115725dbc5538d4bd6e40978 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lk-sync-badge','data' => ['status' => 'synced']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lk-sync-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => 'synced']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal293d7ec7115725dbc5538d4bd6e40978)): ?>
<?php $attributes = $__attributesOriginal293d7ec7115725dbc5538d4bd6e40978; ?>
<?php unset($__attributesOriginal293d7ec7115725dbc5538d4bd6e40978); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal293d7ec7115725dbc5538d4bd6e40978)): ?>
<?php $component = $__componentOriginal293d7ec7115725dbc5538d4bd6e40978; ?>
<?php unset($__componentOriginal293d7ec7115725dbc5538d4bd6e40978); ?>
<?php endif; ?></div>
                <article class="lk-panel border-s-accent p-5">
                    <div class="flex items-start justify-between gap-4"><div><?php if (isset($component)) { $__componentOriginal3fd872b7fd21dc9020e78faa7528b9be = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd872b7fd21dc9020e78faa7528b9be = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lk-status-badge','data' => ['status' => $nextTask->status->value]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lk-status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($nextTask->status->value)]); ?>
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
<?php endif; ?><p class="mt-3 lk-number text-xs font-semibold text-muted-foreground"><?php echo e($nextTask->number); ?></p></div><div class="text-end"><p class="lk-number text-3xl font-semibold text-on-surface"><?php echo e($nextTask->scheduled_start?->format('H:i') ?: '—'); ?></p><p class="text-sm font-medium text-on-surface-variant"><?php echo e($nextTask->scheduled_start?->format('d M Y') ?: 'Waktu belum ditentukan'); ?></p></div></div>
                    <h3 class="mt-4 text-xl font-semibold text-on-surface"><?php echo e($nextTask->title); ?></h3><div class="mt-4 flex items-start gap-3 text-sm text-on-surface-variant"><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 mt-0.5 size-5 shrink-0" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?><div><p class="font-medium text-on-surface"><?php echo e($nextTask->customer->name); ?></p><p><?php echo e($nextTask->site->address_line1); ?>, <?php echo e($nextTask->site->city); ?></p></div></div>
                    <div class="mt-5 grid grid-cols-[minmax(0,1fr)_auto] gap-3"><a href="<?php echo e(route('technician.work-orders.show', $nextTask)); ?>" class="inline-flex min-h-12 cursor-pointer items-center justify-center gap-2 rounded-control bg-accent px-4 text-sm font-semibold text-white transition hover:bg-accent-hover focus:outline-none focus:ring-2 focus:ring-ring/40" wire:navigate>Lihat tugas <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?></a><a href="<?php echo e(route('technician.work-orders.show', $nextTask)); ?>#location" class="inline-flex min-h-12 min-w-12 cursor-pointer items-center justify-center rounded-control border border-border text-on-surface transition hover:bg-surface-subtle focus:outline-none focus:ring-2 focus:ring-ring/40" aria-label="Buka detail lokasi"><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?></a></div>
                </article>
            </section>
        <?php else: ?>
            <section class="lk-panel p-6 text-center"><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 mx-auto size-10 text-success" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?><h2 class="mt-3 text-lg font-semibold text-on-surface">Agenda hari ini kosong</h2><p class="mt-1 text-sm text-on-surface-variant">Nikmati waktu luang atau cek tugas yang akan datang.</p><?php ob_start(); ?><a href="<?php echo e(route('technician.tasks', ['tab' => 'upcoming'])); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75 text-zinc-800 dark:text-white border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600 shadow-xs [[data-flux-button-group]_&amp;]:border-s-0 [:is([data-flux-button-group]&gt;&amp;:first-child,_[data-flux-button-group]_:first-child&gt;&amp;)]:border-s-[1px]   mt-4 min-h-11" data-flux-group-target="data-flux-group-target" wire:navigate="">
        <?php ob_start(); ?>Lihat tugas berikutnya<?php echo trim(ob_get_clean()); ?>

    </a>
<?php echo ltrim(ob_get_clean()); ?></section>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <section aria-labelledby="today-summary-title" class="grid grid-cols-3 gap-2 sm:gap-3"><h2 id="today-summary-title" class="sr-only">Ringkasan hari ini</h2><div class="lk-card p-3 sm:p-4"><p class="text-xs text-muted-foreground">Total</p><p class="mt-1 text-2xl font-semibold text-on-surface"><?php echo e($summary['total']); ?></p></div><div class="lk-card p-3 sm:p-4"><p class="text-xs text-muted-foreground">Aktif</p><p class="mt-1 text-2xl font-semibold text-accent"><?php echo e($summary['active']); ?></p></div><div class="lk-card p-3 sm:p-4"><p class="text-xs text-muted-foreground">Selesai</p><p class="mt-1 text-2xl font-semibold text-success"><?php echo e($summary['completed']); ?></p></div></section>

        <section aria-labelledby="agenda-title" class="space-y-3"><div class="flex items-center justify-between gap-3"><h2 id="agenda-title" class="text-xs font-semibold uppercase tracking-[0.14em] text-muted-foreground">Agenda hari ini</h2><a href="<?php echo e(route('technician.tasks')); ?>" class="min-h-11 inline-flex items-center text-sm font-semibold text-accent hover:underline" wire:navigate>Lihat semua</a></div><div class="space-y-3"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $todayTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><?php if (isset($component)) { $__componentOriginalf79102bc95371f438673ccaaf7e38cb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf79102bc95371f438673ccaaf7e38cb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.technician.task-card','data' => ['workOrder' => $workOrder]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('technician.task-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['work-order' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($workOrder)]); ?>
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
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?><p class="rounded-card border border-dashed border-border p-6 text-center text-sm text-muted-foreground">Belum ada tugas untuk hari ini.</p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div></section>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($upcomingTasks->isNotEmpty()): ?><section aria-labelledby="upcoming-title" class="space-y-3"><h2 id="upcoming-title" class="text-xs font-semibold uppercase tracking-[0.14em] text-muted-foreground">Akan datang</h2><div class="space-y-3"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $upcomingTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><?php if (isset($component)) { $__componentOriginalf79102bc95371f438673ccaaf7e38cb4 = $component; } ?>
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
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></div></section><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views/pages/technician/today.blade.php ENDPATH**/ ?>