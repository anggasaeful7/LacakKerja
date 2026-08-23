<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::heading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::subheading}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/subheading.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::button}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::main}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/main.blade.php}:{1786975751} ?>
<?php if (isset($component)) { $__componentOriginal23399719f391f3076fe3bf0929a84741 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23399719f391f3076fe3bf0929a84741 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.sidebar','data' => ['title' => __($site->exists ? 'Ubah lokasi' : 'Tambah lokasi')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__($site->exists ? 'Ubah lokasi' : 'Tambah lokasi'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php ob_start(); ?><div class="[grid-area:main] p-6 lg:p-8 [[data-flux-container]_&amp;]:px-0" data-flux-main>
    <?php ob_start(); ?>
        <div class="mx-auto w-full max-w-4xl space-y-6 p-4 sm:p-6 lg:p-8">
            <div><?php ob_start(); ?><a href="<?php echo e(route('customers.show', $customer)); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white" wire:navigate="">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M14 8a.75.75 0 0 1-.75.75H4.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 0 1 1.06 1.06L4.56 7.25h8.69A.75.75 0 0 1 14 8Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>Kembali ke <?php echo e($customer->name); ?><?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?><?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-2xl [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2 mt-3" data-flux-heading><?php ob_start(); ?><?php echo e($site->exists ? 'Ubah lokasi' : 'Tambah lokasi'); ?><?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?><?php ob_start(); ?><div class="text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 mt-1" data-flux-subheading>
    <?php ob_start(); ?>Simpan alamat, kontak, dan instruksi akses untuk teknisi.<?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?></div>
            <form method="POST" action="<?php echo e($site->exists ? route('customers.sites.update', [$customer, $site]) : route('customers.sites.store', $customer)); ?>" class="lk-card space-y-6 p-5 sm:p-7"><?php echo csrf_field(); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($site->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="grid gap-5 sm:grid-cols-2"><div><label for="name" class="mb-2 block text-sm font-medium text-foreground">Nama lokasi <span class="text-danger">*</span></label><input id="name" name="name" value="<?php echo e(old('name', $site->name)); ?>" required class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div><div><label for="code" class="mb-2 block text-sm font-medium text-foreground">Kode lokasi</label><input id="code" name="code" value="<?php echo e(old('code', $site->code)); ?>" placeholder="SITE-01" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div><div class="sm:col-span-2"><label for="address_line1" class="mb-2 block text-sm font-medium text-foreground">Alamat utama <span class="text-danger">*</span></label><input id="address_line1" name="address_line1" value="<?php echo e(old('address_line1', $site->address_line1)); ?>" required class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['address_line1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div><div class="sm:col-span-2"><label for="address_line2" class="mb-2 block text-sm font-medium text-foreground">Alamat tambahan</label><input id="address_line2" name="address_line2" value="<?php echo e(old('address_line2', $site->address_line2)); ?>" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div><div><label for="city" class="mb-2 block text-sm font-medium text-foreground">Kota</label><input id="city" name="city" value="<?php echo e(old('city', $site->city)); ?>" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div><div><label for="province" class="mb-2 block text-sm font-medium text-foreground">Provinsi</label><input id="province" name="province" value="<?php echo e(old('province', $site->province)); ?>" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div><div><label for="postal_code" class="mb-2 block text-sm font-medium text-foreground">Kode pos</label><input id="postal_code" name="postal_code" value="<?php echo e(old('postal_code', $site->postal_code)); ?>" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div></div>
                <div class="rounded-control border border-border bg-surface-subtle p-4"><p class="text-sm font-semibold text-foreground">Kontak site</p><div class="mt-4 grid gap-5 sm:grid-cols-3"><div><label for="contact_name" class="mb-2 block text-sm font-medium text-foreground">Nama</label><input id="contact_name" name="contact_name" value="<?php echo e(old('contact_name', $site->contact_name)); ?>" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div><div><label for="contact_phone" class="mb-2 block text-sm font-medium text-foreground">Telepon</label><input id="contact_phone" name="contact_phone" value="<?php echo e(old('contact_phone', $site->contact_phone)); ?>" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div><div><label for="contact_email" class="mb-2 block text-sm font-medium text-foreground">Email</label><input id="contact_email" name="contact_email" type="email" value="<?php echo e(old('contact_email', $site->contact_email)); ?>" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"></div></div></div>
                <div class="grid gap-5 sm:grid-cols-2"><div><label for="latitude" class="mb-2 block text-sm font-medium text-foreground">Latitude <span class="text-xs text-muted-foreground">opsional</span></label><input id="latitude" name="latitude" value="<?php echo e(old('latitude', $site->latitude)); ?>" type="number" step="any" min="-90" max="90" placeholder="-6.200000" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div><div><label for="longitude" class="mb-2 block text-sm font-medium text-foreground">Longitude <span class="text-xs text-muted-foreground">opsional</span></label><input id="longitude" name="longitude" value="<?php echo e(old('longitude', $site->longitude)); ?>" type="number" step="any" min="-180" max="180" placeholder="106.816666" class="h-11 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div></div>
                <div><label for="access_notes" class="mb-2 block text-sm font-medium text-foreground">Catatan akses</label><textarea id="access_notes" name="access_notes" rows="4" placeholder="Contoh: lapor security, akses loading dock dari sisi timur" class="w-full rounded-control border border-border bg-surface px-3 py-2 text-sm text-foreground"><?php echo e(old('access_notes', $site->access_notes)); ?></textarea><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['access_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
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
<?php $__blaze->popData(); ?><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
                <label class="flex items-center gap-3 text-sm text-foreground"><input type="checkbox" name="is_default" value="1" <?php if(old('is_default', $site->is_default)): echo 'checked'; endif; ?> class="rounded border-border text-accent focus:ring-accent"><span>Jadikan lokasi utama pelanggan</span></label>
                <div class="flex flex-col-reverse gap-3 border-t border-border pt-5 sm:flex-row sm:justify-end"><?php ob_start(); ?><a href="<?php echo e(route('customers.show', $customer)); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white" wire:navigate="">
        <?php ob_start(); ?>Batal<?php echo trim(ob_get_clean()); ?>

    </a>
<?php echo ltrim(ob_get_clean()); ?><?php ob_start(); ?><button type="submit" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[disabled]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[disabled]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[disabled]]:pointer-events-none" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>Simpan lokasi<?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?></div>
            </form>
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
<?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\pages\customers\sites\form.blade.php ENDPATH**/ ?>