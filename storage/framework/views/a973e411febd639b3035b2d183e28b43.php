<?php # [BlazeFolded]:{flux::icon.check}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/check.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php if (isset($component)) { $__componentOriginal7e1e7b7fade6aeb109492d5899cdfbcf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7e1e7b7fade6aeb109492d5899cdfbcf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.technician','data' => ['title' => __('Pekerjaan selesai')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.technician'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Pekerjaan selesai'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="flex min-h-[calc(100dvh-10rem)] flex-col items-center justify-center py-8 text-center">
        <div class="flex size-20 items-center justify-center rounded-full bg-success-soft text-success"><?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-10" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?></div><p class="mt-6 text-sm font-semibold uppercase tracking-[0.14em] text-success">Pekerjaan selesai</p><h1 class="mt-2 text-3xl font-semibold tracking-tight text-on-surface"><?php echo e($workOrder->number); ?> tersimpan</h1><p class="mt-3 max-w-sm text-base leading-7 text-on-surface-variant">Status, checklist, foto, material, dan tanda tangan sudah dikonfirmasi server.</p>
        <div class="mt-8 grid w-full max-w-sm gap-3"><?php ob_start(); ?><a href="<?php echo e($nextTask ? route('technician.work-orders.show', $nextTask) : route('technician.today')); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)]   min-h-12" data-flux-group-target="data-flux-group-target" wire:navigate="">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M2 8a.75.75 0 0 1 .75-.75h8.69L8.22 4.03a.75.75 0 0 1 1.06-1.06l4.5 4.5a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06-1.06l3.22-3.22H2.75A.75.75 0 0 1 2 8Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?><?php echo e($nextTask ? 'Buka tugas berikutnya' : 'Kembali ke hari ini'); ?><?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?><?php ob_start(); ?><a href="<?php echo e(route('technician.tasks', ['tab' => 'history'])); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75 text-zinc-800 dark:text-white border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600 shadow-xs [[data-flux-button-group]_&amp;]:border-s-0 [:is([data-flux-button-group]&gt;&amp;:first-child,_[data-flux-button-group]_:first-child&gt;&amp;)]:border-s-[1px]   min-h-12" data-flux-group-target="data-flux-group-target" wire:navigate="">
        <?php ob_start(); ?>Lihat riwayat<?php echo trim(ob_get_clean()); ?>

    </a>
<?php echo ltrim(ob_get_clean()); ?></div>
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
<?php endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\pages\technician\success.blade.php ENDPATH**/ ?>