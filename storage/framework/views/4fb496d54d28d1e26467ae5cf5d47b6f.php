<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::subheading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/subheading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php if (isset($component)) { $__componentOriginal6da4ac82edc751872ca5a34642b398d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6da4ac82edc751872ca5a34642b398d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::auth.simple','data' => ['title' => __('Buat organisasi')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::auth.simple'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Buat organisasi'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="space-y-6">
        <div class="space-y-2 text-center">
            <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-2xl [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Mulai workspace LacakKerja<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
            <?php ob_start(); ?><div class="text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70" data-flux-subheading>
    <?php ob_start(); ?>Siapkan organisasi pertama untuk mengelola pelanggan, teknisi, dan work order.<?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
        </div>

        <form method="POST" action="<?php echo e(route('onboarding.organization.store')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>
            <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/38b67d1afb7a97540315963469340040.php'); ?>
<?php $__blaze->pushData(['name' => 'name','label' => __('Nama organisasi'),'placeholder' => 'Contoh: Prima Teknik Sejahtera','value' => e(old('name')),'required' => true,'autofocus' => true]); ?>
<?php _38b67d1afb7a97540315963469340040($__blaze, ['name' => 'name','label' => __('Nama organisasi'),'placeholder' => 'Contoh: Prima Teknik Sejahtera','value' => e(old('name')),'required' => true,'autofocus' => true], [], ['label', 'required', 'autofocus'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="timezone" class="mb-2 block text-sm font-medium text-foreground">Zona waktu</label>
                    <select id="timezone" name="timezone" required class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Asia/Jakarta' => 'WIB · Asia/Jakarta', 'Asia/Makassar' => 'WITA · Asia/Makassar', 'Asia/Jayapura' => 'WIT · Asia/Jayapura']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($value); ?>" <?php if(old('timezone', 'Asia/Jakarta') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
<?php if (isset($__slots18f04313a41a43517ffbd5c15b434d8b)) { $__slotsStack18f04313a41a43517ffbd5c15b434d8b[] = $__slots18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php if (isset($__attrs18f04313a41a43517ffbd5c15b434d8b)) { $__attrsStack18f04313a41a43517ffbd5c15b434d8b[] = $__attrs18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php $__attrs18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__slots18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__blaze->pushData($__attrs18f04313a41a43517ffbd5c15b434d8b); ?>
<?php ob_start(); ?><?php echo e($message); ?><?php $__slots18f04313a41a43517ffbd5c15b434d8b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots18f04313a41a43517ffbd5c15b434d8b); ?>
<?php _18f04313a41a43517ffbd5c15b434d8b($__blaze, $__attrs18f04313a41a43517ffbd5c15b434d8b, $__slots18f04313a41a43517ffbd5c15b434d8b, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack18f04313a41a43517ffbd5c15b434d8b)) { $__slots18f04313a41a43517ffbd5c15b434d8b = array_pop($__slotsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php if (! empty($__attrsStack18f04313a41a43517ffbd5c15b434d8b)) { $__attrs18f04313a41a43517ffbd5c15b434d8b = array_pop($__attrsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php $__blaze->popData(); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div>
                    <label for="currency" class="mb-2 block text-sm font-medium text-foreground">Mata uang</label>
                    <select id="currency" name="currency" required class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <option value="IDR" <?php if(old('currency', 'IDR') === 'IDR'): echo 'selected'; endif; ?>>IDR · Rupiah</option>
                        <option value="USD" <?php if(old('currency') === 'USD'): echo 'selected'; endif; ?>>USD · Dollar</option>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
<?php if (isset($__slots18f04313a41a43517ffbd5c15b434d8b)) { $__slotsStack18f04313a41a43517ffbd5c15b434d8b[] = $__slots18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php if (isset($__attrs18f04313a41a43517ffbd5c15b434d8b)) { $__attrsStack18f04313a41a43517ffbd5c15b434d8b[] = $__attrs18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php $__attrs18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__slots18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__blaze->pushData($__attrs18f04313a41a43517ffbd5c15b434d8b); ?>
<?php ob_start(); ?><?php echo e($message); ?><?php $__slots18f04313a41a43517ffbd5c15b434d8b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots18f04313a41a43517ffbd5c15b434d8b); ?>
<?php _18f04313a41a43517ffbd5c15b434d8b($__blaze, $__attrs18f04313a41a43517ffbd5c15b434d8b, $__slots18f04313a41a43517ffbd5c15b434d8b, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack18f04313a41a43517ffbd5c15b434d8b)) { $__slots18f04313a41a43517ffbd5c15b434d8b = array_pop($__slotsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php if (! empty($__attrsStack18f04313a41a43517ffbd5c15b434d8b)) { $__attrs18f04313a41a43517ffbd5c15b434d8b = array_pop($__attrsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php $__blaze->popData(); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
<?php if (isset($__slots18f04313a41a43517ffbd5c15b434d8b)) { $__slotsStack18f04313a41a43517ffbd5c15b434d8b[] = $__slots18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php if (isset($__attrs18f04313a41a43517ffbd5c15b434d8b)) { $__attrsStack18f04313a41a43517ffbd5c15b434d8b[] = $__attrs18f04313a41a43517ffbd5c15b434d8b; } ?>
<?php $__attrs18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__slots18f04313a41a43517ffbd5c15b434d8b = []; ?>
<?php $__blaze->pushData($__attrs18f04313a41a43517ffbd5c15b434d8b); ?>
<?php ob_start(); ?><?php echo e($message); ?><?php $__slots18f04313a41a43517ffbd5c15b434d8b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots18f04313a41a43517ffbd5c15b434d8b); ?>
<?php _18f04313a41a43517ffbd5c15b434d8b($__blaze, $__attrs18f04313a41a43517ffbd5c15b434d8b, $__slots18f04313a41a43517ffbd5c15b434d8b, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack18f04313a41a43517ffbd5c15b434d8b)) { $__slots18f04313a41a43517ffbd5c15b434d8b = array_pop($__slotsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php if (! empty($__attrsStack18f04313a41a43517ffbd5c15b434d8b)) { $__attrs18f04313a41a43517ffbd5c15b434d8b = array_pop($__attrsStack18f04313a41a43517ffbd5c15b434d8b); } ?>
<?php $__blaze->popData(); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php ob_start(); ?><button type="submit" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[disabled]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[disabled]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[disabled]]:pointer-events-none  w-full" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>Buat organisasi<?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
        </form>

        <p class="text-center text-xs text-muted-foreground">Kamu dapat mengundang anggota dan mengatur role setelah workspace dibuat.</p>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6da4ac82edc751872ca5a34642b398d0)): ?>
<?php $attributes = $__attributesOriginal6da4ac82edc751872ca5a34642b398d0; ?>
<?php unset($__attributesOriginal6da4ac82edc751872ca5a34642b398d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6da4ac82edc751872ca5a34642b398d0)): ?>
<?php $component = $__componentOriginal6da4ac82edc751872ca5a34642b398d0; ?>
<?php unset($__componentOriginal6da4ac82edc751872ca5a34642b398d0); ?>
<?php endif; ?>
<?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views/pages/organization/onboarding.blade.php ENDPATH**/ ?>