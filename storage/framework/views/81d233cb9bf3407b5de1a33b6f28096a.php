<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::subheading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/subheading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.plus}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/plus.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.chevron-right}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/chevron-right.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.chevron-down}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/chevron-down.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::main}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/main.blade.php}:{1786975751} ?>
<?php if (isset($component)) { $__componentOriginal23399719f391f3076fe3bf0929a84741 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23399719f391f3076fe3bf0929a84741 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.sidebar','data' => ['title' => __('Dispatch Board')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Dispatch Board'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php ob_start(); ?><div class="[grid-area:main] p-6 lg:p-8 [[data-flux-container]_&amp;]:px-0" data-flux-main>
    <?php ob_start(); ?>
        <div class="mx-auto w-full max-w-[1680px] space-y-6 p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col gap-4 2xl:flex-row 2xl:items-end 2xl:justify-between">
                <div>
                    <p class="text-sm font-medium text-accent">Operasional · <?php echo e($organization->name); ?></p>
                    <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-2xl [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Dispatch Board<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php ob_start(); ?><div class="text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 mt-1" data-flux-subheading>
    <?php ob_start(); ?>Atur kapasitas teknisi, jadwal, dan pekerjaan yang belum ditugaskan.<?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
                </div>
                <div class="flex flex-wrap items-center gap-2" aria-label="Navigasi tanggal">
                    <?php ob_start(); ?><a href="<?php echo e(route('dispatch.index', array_merge(request()->query(), ['date' => $selectedDate->subDay()->toDateString()]))); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75 text-zinc-800 dark:text-white border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600 shadow-xs [[data-flux-button-group]_&amp;]:border-s-0 [:is([data-flux-button-group]&gt;&amp;:first-child,_[data-flux-button-group]_:first-child&gt;&amp;)]:border-s-[1px]" data-flux-group-target="data-flux-group-target" aria-label="Hari sebelumnya">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M9.78 4.22a.75.75 0 0 1 0 1.06L7.06 8l2.72 2.72a.75.75 0 1 1-1.06 1.06L5.47 8.53a.75.75 0 0 1 0-1.06l3.25-3.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>Sebelumnya<?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php ob_start(); ?><a href="<?php echo e(route('dispatch.index', array_merge(request()->query(), ['date' => now($organization->timezone)->toDateString()]))); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white">
        <?php ob_start(); ?>Hari ini<?php echo trim(ob_get_clean()); ?>

    </a>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php ob_start(); ?><a href="<?php echo e(route('dispatch.index', array_merge(request()->query(), ['date' => $selectedDate->addDay()->toDateString()]))); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75 text-zinc-800 dark:text-white border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600 shadow-xs [[data-flux-button-group]_&amp;]:border-s-0 [:is([data-flux-button-group]&gt;&amp;:first-child,_[data-flux-button-group]_:first-child&gt;&amp;)]:border-s-[1px]" data-flux-group-target="data-flux-group-target">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L8.94 8 6.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>Berikutnya<?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
                <div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content" role="status" aria-live="polite"><?php echo e(session('status')); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="lk-card border-danger/30 bg-danger-soft p-4 text-sm text-danger-content" role="alert">
                    <p class="font-semibold">Jadwal belum disimpan.</p>
                    <ul class="mt-1 list-disc ps-5"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><li><?php echo e($error); ?></li><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></ul>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <section class="grid gap-3 sm:grid-cols-3" aria-label="Ringkasan agenda">
                <div class="lk-card p-4"><p class="text-sm text-muted-foreground">Pekerjaan dalam rentang</p><p class="mt-2 text-3xl font-semibold text-foreground"><?php echo e($summary['total']); ?></p></div>
                <div class="lk-card p-4"><p class="text-sm text-muted-foreground">Belum ditugaskan</p><p class="mt-2 text-3xl font-semibold text-warning-content"><?php echo e($summary['unassigned']); ?></p></div>
                <div class="lk-card p-4"><p class="text-sm text-muted-foreground">Indikasi bentrok</p><p class="mt-2 text-3xl font-semibold text-danger-content"><?php echo e($summary['conflicts']); ?></p></div>
            </section>

            <form method="GET" class="lk-card grid gap-4 p-4 sm:grid-cols-2 xl:grid-cols-[11rem_8rem_12rem_10rem_12rem_minmax(14rem,1fr)_auto] xl:items-end">
                <div>
                    <label for="dispatch-date" class="mb-2 block text-sm font-medium text-foreground">Tanggal</label>
                    <input id="dispatch-date" type="date" name="date" value="<?php echo e($selectedDate->toDateString()); ?>" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                </div>
                <div>
                    <label for="dispatch-view" class="mb-2 block text-sm font-medium text-foreground">Tampilan</label>
                    <select id="dispatch-view" name="view" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <option value="day" <?php if($view === 'day'): echo 'selected'; endif; ?>>Hari</option><option value="week" <?php if($view === 'week'): echo 'selected'; endif; ?>>Minggu</option>
                    </select>
                </div>
                <div>
                    <label for="dispatch-technician" class="mb-2 block text-sm font-medium text-foreground">Teknisi</label>
                    <select id="dispatch-technician" name="technician_id" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <option value="">Semua teknisi</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($membership->user_id); ?>" <?php if((string) $filters['technician_id'] === (string) $membership->user_id): echo 'selected'; endif; ?>><?php echo e($membership->user->name); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div>
                    <label for="dispatch-status" class="mb-2 block text-sm font-medium text-foreground">Status</label>
                    <select id="dispatch-status" name="status" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <option value="">Semua status</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Enums\WorkOrderStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($status->value); ?>" <?php if($filters['status'] === $status->value): echo 'selected'; endif; ?>><?php echo e($status->label()); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div>
                    <label for="dispatch-priority" class="mb-2 block text-sm font-medium text-foreground">Prioritas</label>
                    <select id="dispatch-priority" name="priority" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <option value="">Semua prioritas</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Enums\WorkOrderPriority::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($priority->value); ?>" <?php if($filters['priority'] === $priority->value): echo 'selected'; endif; ?>><?php echo e($priority->label()); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div>
                    <label for="dispatch-area" class="mb-2 block text-sm font-medium text-foreground">Area</label>
                    <input id="dispatch-area" name="area" value="<?php echo e($filters['area']); ?>" placeholder="Kota atau provinsi" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground placeholder:text-muted-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                </div>
                <div class="flex gap-2">
                    <div class="min-w-0 flex-1"><label for="dispatch-search" class="mb-2 block text-sm font-medium text-foreground">Cari</label><input id="dispatch-search" name="q" value="<?php echo e($filters['q']); ?>" placeholder="Nomor, judul, pelanggan" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground placeholder:text-muted-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30"></div>
                    <?php ob_start(); ?><button type="submit" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[disabled]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[disabled]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[disabled]]:pointer-events-none  mt-7" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
                    <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M14 2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v2.172a2 2 0 0 0 .586 1.414l2.828 2.828A2 2 0 0 1 6 9.828v4.363a.5.5 0 0 0 .724.447l2.17-1.085A2 2 0 0 0 10 11.763V9.829a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 0 14 4.172V2Z"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>Terapkan<?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                </div>
            </form>

            <div class="flex flex-wrap items-center justify-between gap-3">
                <div><?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?><?php echo e($view === 'week' ? 'Agenda minggu' : 'Agenda hari'); ?><?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?><p class="mt-1 text-sm text-muted-foreground"><?php echo e($from->format('d M Y')); ?><?php echo e($view === 'week' ? ' – '.$to->subDay()->format('d M Y') : ''); ?></p></div>
                <a href="<?php echo e(route('work-orders.create')); ?>" class="inline-flex min-h-11 cursor-pointer items-center gap-2 rounded-control bg-accent px-4 text-sm font-semibold text-white transition hover:bg-accent/90 focus:outline-none focus:ring-2 focus:ring-ring/40" wire:navigate><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>Buat work order</a>
            </div>

            <section class="hidden 2xl:block" aria-labelledby="dispatch-board-title">
                <h2 id="dispatch-board-title" class="sr-only">Board teknisi</h2>
                <div class="grid gap-4 xl:grid-cols-3 2xl:grid-cols-5">
                    <?php if (isset($component)) { $__componentOriginalbfe5598c6ee596174ce325c7a8818b37 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfe5598c6ee596174ce325c7a8818b37 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dispatch.lane','data' => ['title' => 'Belum Ditugaskan','laneKey' => 'unassigned','workOrders' => $lanes->get('unassigned', collect()),'technician' => null,'technicians' => $technicians,'filters' => $filters,'selectedDate' => $selectedDate]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dispatch.lane'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Belum Ditugaskan','lane-key' => 'unassigned','work-orders' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($lanes->get('unassigned', collect())),'technician' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'technicians' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($technicians),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filters),'selected-date' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedDate)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfe5598c6ee596174ce325c7a8818b37)): ?>
<?php $attributes = $__attributesOriginalbfe5598c6ee596174ce325c7a8818b37; ?>
<?php unset($__attributesOriginalbfe5598c6ee596174ce325c7a8818b37); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfe5598c6ee596174ce325c7a8818b37)): ?>
<?php $component = $__componentOriginalbfe5598c6ee596174ce325c7a8818b37; ?>
<?php unset($__componentOriginalbfe5598c6ee596174ce325c7a8818b37); ?>
<?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalbfe5598c6ee596174ce325c7a8818b37 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfe5598c6ee596174ce325c7a8818b37 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dispatch.lane','data' => ['title' => $membership->user->name,'laneKey' => $membership->user_id,'workOrders' => $lanes->get((string) $membership->user_id, collect()),'technician' => $membership->user,'technicians' => $technicians,'filters' => $filters,'selectedDate' => $selectedDate]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dispatch.lane'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($membership->user->name),'lane-key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($membership->user_id),'work-orders' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($lanes->get((string) $membership->user_id, collect())),'technician' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($membership->user),'technicians' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($technicians),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filters),'selected-date' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedDate)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfe5598c6ee596174ce325c7a8818b37)): ?>
<?php $attributes = $__attributesOriginalbfe5598c6ee596174ce325c7a8818b37; ?>
<?php unset($__attributesOriginalbfe5598c6ee596174ce325c7a8818b37); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfe5598c6ee596174ce325c7a8818b37)): ?>
<?php $component = $__componentOriginalbfe5598c6ee596174ce325c7a8818b37; ?>
<?php unset($__componentOriginalbfe5598c6ee596174ce325c7a8818b37); ?>
<?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </section>

            <section class="2xl:hidden" aria-labelledby="dispatch-summary-title">
                <div class="lk-card p-4"><h2 id="dispatch-summary-title" class="font-semibold text-foreground">Ringkasan kapasitas teknisi</h2><p class="mt-1 text-sm text-muted-foreground">Gunakan daftar pekerjaan di bawah untuk membuka detail dan mengubah assignment.</p><div class="mt-4 grid gap-3 sm:grid-cols-2"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><a href="<?php echo e(route('dispatch.technicians.edit', array_merge(['user' => $membership->user_id], $filters, ['date' => $selectedDate->toDateString(), 'view' => $view]))); ?>" class="flex min-h-11 items-center gap-3 rounded-control border border-border p-3 transition hover:border-accent focus:outline-none focus:ring-2 focus:ring-ring/40" wire:navigate><span class="size-3 rounded-full" style="background-color: <?php echo e($membership->user->technicianProfile?->display_color ?? '#0284c7'); ?>"></span><span class="min-w-0 flex-1"><span class="block truncate font-medium text-foreground"><?php echo e($membership->user->name); ?></span><span class="text-xs text-muted-foreground"><?php echo e($lanes->get((string) $membership->user_id, collect())->count()); ?> pekerjaan</span></span><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-4 text-muted-foreground" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?></a><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></div></div>
            </section>

            <section class="lk-card overflow-hidden" aria-labelledby="dispatch-list-title">
                <div class="flex flex-col gap-2 border-b border-border px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"><div><?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" id="dispatch-list-title" data-flux-heading><?php ob_start(); ?>Daftar aksesibel<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?><p class="mt-1 text-sm text-muted-foreground">Alternatif board yang dapat dijalankan penuh dengan keyboard dan pembaca layar.</p></div><span class="text-xs text-muted-foreground"><?php echo e($workOrders->count()); ?> pekerjaan</span></div>
                <div class="overflow-x-auto"><table class="min-w-[960px] w-full divide-y divide-border text-sm"><thead class="bg-surface-subtle text-left text-xs uppercase tracking-wide text-muted-foreground"><tr><th class="px-5 py-3 font-medium">Work order</th><th class="px-5 py-3 font-medium">Jadwal</th><th class="px-5 py-3 font-medium">Teknisi</th><th class="px-5 py-3 font-medium">Lokasi</th><th class="px-5 py-3 font-medium">Status</th><th class="px-5 py-3 text-right font-medium">Aksi</th></tr></thead><tbody class="divide-y divide-border">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $workOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="transition hover:bg-surface-subtle/70"><td class="px-5 py-4"><a href="<?php echo e(route('work-orders.show', $workOrder)); ?>?<?php echo e(http_build_query(['return_date' => $selectedDate->toDateString(), 'return_view' => $view, 'return_technician_id' => $filters['technician_id'], 'return_status' => $filters['status'], 'return_priority' => $filters['priority'], 'return_area' => $filters['area'], 'return_q' => $filters['q']])); ?>" class="font-semibold text-foreground hover:text-accent focus:outline-none focus:ring-2 focus:ring-ring/40" wire:navigate><?php echo e($workOrder->number); ?></a><p class="mt-1 max-w-[22rem] truncate text-muted-foreground"><?php echo e($workOrder->title); ?></p></td><td class="whitespace-nowrap px-5 py-4 text-muted-foreground"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->scheduled_start): ?><?php echo e($workOrder->scheduled_start->format('d M, H:i')); ?>–<?php echo e($workOrder->scheduled_end?->format('H:i')); ?><?php else: ?> Belum dijadwalkan <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></td><td class="px-5 py-4"><?php echo e($workOrder->primaryAssignment?->user?->name ?: 'Belum ditugaskan'); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((int) $workOrder->getAttribute('schedule_conflict_count') > 0): ?><span class="mt-1 block text-xs font-semibold text-danger-content" role="status">Bentrok: <?php echo e($workOrder->getAttribute('schedule_conflict_count')); ?> jadwal</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></td><td class="px-5 py-4 text-muted-foreground"><?php echo e($workOrder->site->city ?? $workOrder->site->name); ?></td><td class="whitespace-nowrap px-5 py-4"><?php if (isset($component)) { $__componentOriginal3fd872b7fd21dc9020e78faa7528b9be = $component; } ?>
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
<?php endif; ?><div class="mt-1"><?php if (isset($component)) { $__componentOriginald937aa70a0ae81844cc7808a9f1b2f7a = $component; } ?>
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
<?php endif; ?></div></td><td class="whitespace-nowrap px-5 py-4 text-right"><details class="relative inline-block text-left"><summary class="inline-flex min-h-11 cursor-pointer list-none items-center gap-2 rounded-control border border-border px-3 text-sm font-medium text-foreground transition hover:bg-surface-subtle focus:outline-none focus:ring-2 focus:ring-ring/40">Atur jadwal <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?></summary><div class="absolute end-0 z-20 mt-2 w-[min(90vw,24rem)] rounded-card border border-border bg-surface p-4 text-start shadow-lg"><?php if (isset($component)) { $__componentOriginala6d4fb3df01a09dce285e5cf22d26ad0 = $component; } ?>
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
<?php endif; ?></div></details></td></tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?><tr><td colspan="6" class="px-5 py-12 text-center text-sm text-muted-foreground">Tidak ada pekerjaan pada filter ini.</td></tr><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody></table></div>
            </section>
        </div>
    <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23399719f391f3076fe3bf0929a84741)): ?>
<?php $attributes = $__attributesOriginal23399719f391f3076fe3bf0929a84741; ?>
<?php unset($__attributesOriginal23399719f391f3076fe3bf0929a84741); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23399719f391f3076fe3bf0929a84741)): ?>
<?php $component = $__componentOriginal23399719f391f3076fe3bf0929a84741; ?>
<?php unset($__componentOriginal23399719f391f3076fe3bf0929a84741); ?>
<?php endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views/pages/dispatch/index.blade.php ENDPATH**/ ?>