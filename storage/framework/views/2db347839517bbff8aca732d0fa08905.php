<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::subheading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/subheading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::main}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/main.blade.php}:{1786975751} ?>
<?php if (isset($component)) { $__componentOriginal23399719f391f3076fe3bf0929a84741 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23399719f391f3076fe3bf0929a84741 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.sidebar','data' => ['title' => __('Invoice')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Invoice'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php ob_start(); ?><div class="[grid-area:main] p-6 lg:p-8 [[data-flux-container]_&amp;]:px-0" data-flux-main>
    <?php ob_start(); ?>
        <div class="mx-auto w-full max-w-[1440px] space-y-6 p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-2xl [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Invoice<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php ob_start(); ?><div class="text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 mt-1" data-flux-subheading>
    <?php ob_start(); ?>Tagihkan pekerjaan selesai dan pantau pembayaran tanpa kehilangan jejak transaksi.<?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
                </div>
                <?php ob_start(); ?><a href="<?php echo e(route('invoices.create')); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)]" data-flux-group-target="data-flux-group-target" wire:navigate="">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>Buat invoice<?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
                <div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content" role="status"><?php echo e(session('status')); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Ringkasan keuangan">
                <div class="lk-card p-5"><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Outstanding</p><p class="mt-2 text-2xl font-semibold tabular-nums text-foreground"><?php echo e($organization->currency); ?> <?php echo e(number_format($kpis['outstanding'], 0, ',', '.')); ?></p><p class="mt-1 text-sm text-muted-foreground">Total amount due aktif</p></div>
                <div class="lk-card border-danger/25 p-5"><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Jatuh tempo</p><p class="mt-2 text-2xl font-semibold tabular-nums text-danger-content"><?php echo e(number_format($kpis['overdue'], 0, ',', '.')); ?></p><p class="mt-1 text-sm text-muted-foreground">Invoice perlu ditindaklanjuti</p></div>
                <div class="lk-card border-success/25 p-5"><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Dibayar bulan ini</p><p class="mt-2 text-2xl font-semibold tabular-nums text-success-content"><?php echo e($organization->currency); ?> <?php echo e(number_format($kpis['paid_this_month'], 0, ',', '.')); ?></p><p class="mt-1 text-sm text-muted-foreground">Pembayaran terposting</p></div>
                <div class="lk-card p-5"><p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Draft</p><p class="mt-2 text-2xl font-semibold tabular-nums text-foreground"><?php echo e(number_format($kpis['drafts'], 0, ',', '.')); ?></p><p class="mt-1 text-sm text-muted-foreground">Belum diterbitkan</p></div>
            </section>

            <form method="GET" class="lk-card grid gap-4 p-4 sm:grid-cols-[minmax(0,1fr)_13rem_auto] sm:items-end">
                <div class="min-w-0">
                    <label for="invoice-search" class="mb-2 block text-sm font-medium text-foreground">Cari invoice</label>
                    <input id="invoice-search" name="q" value="<?php echo e($search); ?>" placeholder="Nomor, pelanggan, work order" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground placeholder:text-muted-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                </div>
                <div class="min-w-0">
                    <label for="invoice-status" class="mb-2 block text-sm font-medium text-foreground">Status</label>
                    <select id="invoice-status" name="status" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <option value="">Semua status</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Enums\InvoiceStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoiceStatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($invoiceStatus->value); ?>" <?php if($status === $invoiceStatus): echo 'selected'; endif; ?>><?php echo e($invoiceStatus->label()); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <?php ob_start(); ?><button type="submit" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75 text-zinc-800 dark:text-white border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600 shadow-xs [[data-flux-button-group]_&amp;]:border-s-0 [:is([data-flux-button-group]&gt;&amp;:first-child,_[data-flux-button-group]_:first-child&gt;&amp;)]:border-s-[1px] *:transition-opacity [&amp;[disabled]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[disabled]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[disabled]]:pointer-events-none" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target">
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
            </form>

            <section class="lk-card overflow-hidden" aria-labelledby="invoice-list-title">
                <div class="border-b border-border px-5 py-4 sm:px-6">
                    <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" id="invoice-list-title" data-flux-heading><?php ob_start(); ?>Daftar invoice<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
                    <p class="mt-1 text-sm text-muted-foreground"><?php echo e($invoices->total()); ?> invoice dalam workspace ini.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-[980px] w-full divide-y divide-border text-sm">
                        <caption class="sr-only">Daftar invoice dan status pembayarannya</caption>
                        <thead class="bg-surface-subtle text-left text-xs uppercase tracking-wide text-muted-foreground"><tr><th scope="col" class="px-5 py-3 font-medium">Invoice</th><th scope="col" class="px-5 py-3 font-medium">Pelanggan</th><th scope="col" class="px-5 py-3 font-medium">Terbit / jatuh tempo</th><th scope="col" class="px-5 py-3 text-right font-medium">Total</th><th scope="col" class="px-5 py-3 font-medium">Status</th><th scope="col" class="px-5 py-3 text-right font-medium">Aksi</th></tr></thead>
                        <tbody class="divide-y divide-border">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $statusColors = ['draft' => 'zinc', 'issued' => 'blue', 'partially_paid' => 'amber', 'paid' => 'green', 'overdue' => 'red', 'void' => 'zinc'];
                                ?>
                                <tr class="transition hover:bg-surface-subtle/70">
                                    <td class="px-5 py-4"><a href="<?php echo e(route('invoices.show', $invoice)); ?>" class="font-semibold text-accent hover:underline" wire:navigate><?php echo e($invoice->number); ?></a><p class="mt-1 text-xs text-muted-foreground"><?php echo e($invoice->workOrder?->number ?: 'Invoice manual'); ?></p></td>
                                    <td class="px-5 py-4"><p class="font-medium text-foreground"><?php echo e($invoice->customer->name); ?></p><p class="mt-1 text-xs text-muted-foreground"><?php echo e($invoice->customer->customer_number); ?></p></td>
                                    <td class="whitespace-nowrap px-5 py-4 text-muted-foreground"><p><?php echo e($invoice->issued_at?->format('d M Y') ?: 'Belum terbit'); ?></p><p class="mt-1 text-xs">Jatuh tempo: <?php echo e($invoice->due_date?->format('d M Y') ?: '—'); ?></p></td>
                                    <td class="whitespace-nowrap px-5 py-4 text-right font-semibold tabular-nums text-foreground"><?php echo e($invoice->currency); ?> <?php echo e(number_format($invoice->total_amount, 0, ',', '.')); ?><p class="mt-1 text-xs font-normal text-muted-foreground">Sisa <?php echo e(number_format($invoice->amount_due, 0, ',', '.')); ?></p></td>
                                    <td class="whitespace-nowrap px-5 py-4"><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/badge/index.blade.php', $__blaze->compiledPath.'/cffde9804881bb2b5f7284c583c5dca4.php'); ?>
<?php if (isset($__slotscffde9804881bb2b5f7284c583c5dca4)) { $__slotsStackcffde9804881bb2b5f7284c583c5dca4[] = $__slotscffde9804881bb2b5f7284c583c5dca4; } ?>
<?php if (isset($__attrscffde9804881bb2b5f7284c583c5dca4)) { $__attrsStackcffde9804881bb2b5f7284c583c5dca4[] = $__attrscffde9804881bb2b5f7284c583c5dca4; } ?>
<?php $__attrscffde9804881bb2b5f7284c583c5dca4 = ['color' => $statusColors[$invoice->status->value] ?? 'zinc','icon' => $invoice->status === \App\Enums\InvoiceStatus::Paid ? 'check-circle' : ($invoice->status === \App\Enums\InvoiceStatus::Overdue ? 'exclamation-triangle' : 'document-text'),'size' => 'sm']; ?>
<?php $__slotscffde9804881bb2b5f7284c583c5dca4 = []; ?>
<?php $__blaze->pushData($__attrscffde9804881bb2b5f7284c583c5dca4); ?>
<?php ob_start(); ?><?php echo e($invoice->status->label()); ?><?php $__slotscffde9804881bb2b5f7284c583c5dca4['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotscffde9804881bb2b5f7284c583c5dca4); ?>
<?php _cffde9804881bb2b5f7284c583c5dca4($__blaze, $__attrscffde9804881bb2b5f7284c583c5dca4, $__slotscffde9804881bb2b5f7284c583c5dca4, ['color', 'icon'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcffde9804881bb2b5f7284c583c5dca4)) { $__slotscffde9804881bb2b5f7284c583c5dca4 = array_pop($__slotsStackcffde9804881bb2b5f7284c583c5dca4); } ?>
<?php if (! empty($__attrsStackcffde9804881bb2b5f7284c583c5dca4)) { $__attrscffde9804881bb2b5f7284c583c5dca4 = array_pop($__attrsStackcffde9804881bb2b5f7284c583c5dca4); } ?>
<?php $__blaze->popData(); ?></td>
                                    <td class="whitespace-nowrap px-5 py-4 text-right"><?php ob_start(); ?><a href="<?php echo e(route('invoices.show', $invoice)); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md px-3 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white" wire:navigate="">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M2 8a.75.75 0 0 1 .75-.75h8.69L8.22 4.03a.75.75 0 0 1 1.06-1.06l4.5 4.5a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06-1.06l3.22-3.22H2.75A.75.75 0 0 1 2 8Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>Lihat<?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?></td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr><td colspan="6" class="p-5"><?php if (isset($component)) { $__componentOriginal1638cc9c9bed71d4fca242bbe3acaef4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1638cc9c9bed71d4fca242bbe3acaef4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lk-empty-state','data' => ['icon' => 'banknotes','title' => 'Belum ada invoice','description' => 'Buat invoice dari work order yang sudah selesai untuk mulai mencatat penagihan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lk-empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'banknotes','title' => 'Belum ada invoice','description' => 'Buat invoice dari work order yang sudah selesai untuk mulai mencatat penagihan.']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
<?php ob_start(); ?><a href="<?php echo e(route('invoices.create')); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)]" data-flux-group-target="data-flux-group-target" wire:navigate="">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>Buat invoice<?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1638cc9c9bed71d4fca242bbe3acaef4)): ?>
<?php $attributes = $__attributesOriginal1638cc9c9bed71d4fca242bbe3acaef4; ?>
<?php unset($__attributesOriginal1638cc9c9bed71d4fca242bbe3acaef4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1638cc9c9bed71d4fca242bbe3acaef4)): ?>
<?php $component = $__componentOriginal1638cc9c9bed71d4fca242bbe3acaef4; ?>
<?php unset($__componentOriginal1638cc9c9bed71d4fca242bbe3acaef4); ?>
<?php endif; ?></td></tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoices->hasPages()): ?><div class="border-t border-border px-5 py-4 sm:px-6"><?php echo e($invoices->links()); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php endif; ?>
<?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\pages\invoices\index.blade.php ENDPATH**/ ?>