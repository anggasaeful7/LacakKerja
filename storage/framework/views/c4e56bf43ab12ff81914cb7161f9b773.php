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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.sidebar','data' => ['title' => __('Checklist')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Checklist'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php ob_start(); ?><div class="[grid-area:main] p-6 lg:p-8 [[data-flux-container]_&amp;]:px-0" data-flux-main>
    <?php ob_start(); ?><div class="mx-auto w-full max-w-[1320px] space-y-6 p-4 sm:p-6 lg:p-8"><div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between"><div><?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-2xl [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Checklist template<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?><?php ob_start(); ?><div class="text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 mt-1" data-flux-subheading>
    <?php ob_start(); ?>Checklist versi snapshot untuk menjaga histori work order tetap konsisten.<?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?></div><?php ob_start(); ?><a href="<?php echo e(route('checklists.create')); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)]" data-flux-group-target="data-flux-group-target" wire:navigate="">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>Buat checklist<?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?></div><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?><div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content"><?php echo e(session('status')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><form method="GET" class="lk-card grid gap-4 p-4 sm:grid-cols-[minmax(0,1fr)_12rem_auto] sm:items-end"><div class="min-w-0"><label for="checklist-search" class="mb-2 block text-sm font-medium text-foreground">Cari template</label><input id="checklist-search" name="q" value="<?php echo e($search); ?>" placeholder="Nama atau key template" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div><div class="min-w-0"><label for="checklist-status" class="mb-2 block text-sm font-medium text-foreground">Status</label><select id="checklist-status" name="status" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"><option value="">Semua status</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Enums\ChecklistStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($status->value); ?>" <?php if(request('status') === $status->value): echo 'selected'; endif; ?>><?php echo e($status->label()); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div><?php ob_start(); ?><button type="submit" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75 text-zinc-800 dark:text-white border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600 shadow-xs [[data-flux-button-group]_&amp;]:border-s-0 [:is([data-flux-button-group]&gt;&amp;:first-child,_[data-flux-button-group]_:first-child&gt;&amp;)]:border-s-[1px] *:transition-opacity [&amp;[disabled]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[disabled]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[disabled]]:pointer-events-none" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target">
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
<?php echo ltrim(ob_get_clean()); ?></form><section class="lk-card overflow-hidden"><div class="border-b border-border px-5 py-4 sm:px-6"><?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Template tersimpan<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?><p class="mt-1 text-sm text-muted-foreground"><?php echo e($templates->total()); ?> template versi.</p></div><div class="overflow-x-auto"><table class="min-w-[900px] w-full divide-y divide-border text-sm"><thead class="bg-surface-subtle text-left text-xs uppercase tracking-wide text-muted-foreground"><tr><th class="px-5 py-3 font-medium">Template</th><th class="px-5 py-3 font-medium">Layanan</th><th class="whitespace-nowrap px-5 py-3 font-medium">Versi</th><th class="whitespace-nowrap px-5 py-3 font-medium">Item</th><th class="whitespace-nowrap px-5 py-3 font-medium">Status</th><th class="whitespace-nowrap px-5 py-3 text-right font-medium">Aksi</th></tr></thead><tbody class="divide-y divide-border"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><tr class="hover:bg-surface-subtle/70"><td class="px-5 py-4"><a href="<?php echo e(route('checklists.show', $template)); ?>" class="font-semibold text-foreground hover:text-accent" wire:navigate><?php echo e($template->name); ?></a><p class="mt-1 text-xs text-muted-foreground"><?php echo e($template->template_key); ?></p></td><td class="px-5 py-4 text-muted-foreground"><?php echo e($template->service?->name ?: 'Semua layanan'); ?></td><td class="whitespace-nowrap px-5 py-4 text-foreground">v<?php echo e($template->version); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($template->is_current): ?><span class="ms-1 text-xs text-success-content">· current</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></td><td class="whitespace-nowrap px-5 py-4 text-foreground"><?php echo e($template->items_count); ?></td><td class="whitespace-nowrap px-5 py-4"><?php if (isset($component)) { $__componentOriginal3fd872b7fd21dc9020e78faa7528b9be = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd872b7fd21dc9020e78faa7528b9be = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lk-status-badge','data' => ['status' => $template->status->value]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lk-status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($template->status->value)]); ?>
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
<?php endif; ?></td><td class="whitespace-nowrap px-5 py-4 text-right"><?php ob_start(); ?><a href="<?php echo e(route('checklists.show', $template)); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md px-3 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white" wire:navigate="">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M2 8a.75.75 0 0 1 .75-.75h8.69L8.22 4.03a.75.75 0 0 1 1.06-1.06l4.5 4.5a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06-1.06l3.22-3.22H2.75A.75.75 0 0 1 2 8Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>Lihat<?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?></td></tr><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?><tr><td colspan="6" class="p-5"><?php if (isset($component)) { $__componentOriginal1638cc9c9bed71d4fca242bbe3acaef4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1638cc9c9bed71d4fca242bbe3acaef4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lk-empty-state','data' => ['icon' => 'clipboard-document-check','title' => 'Belum ada checklist','description' => 'Buat checklist untuk menstandarkan pemeriksaan teknisi.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lk-empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'clipboard-document-check','title' => 'Belum ada checklist','description' => 'Buat checklist untuk menstandarkan pemeriksaan teknisi.']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
<?php ob_start(); ?><a href="<?php echo e(route('checklists.create')); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)]" data-flux-group-target="data-flux-group-target" wire:navigate="">
        <?php ob_start(); ?>Buat checklist<?php echo trim(ob_get_clean()); ?>

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
<?php endif; ?></td></tr><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></tbody></table></div><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($templates->hasPages()): ?><div class="border-t border-border px-5 py-4 sm:px-6"><?php echo e($templates->links()); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></section></div><?php echo trim(ob_get_clean()); ?>

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
<?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\pages\checklists\index.blade.php ENDPATH**/ ?>