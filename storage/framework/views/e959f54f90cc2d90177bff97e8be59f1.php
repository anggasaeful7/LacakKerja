<?php # [BlazeFolded]:{flux::icon.bell}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/bell.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::menu.item}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/menu/item.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::menu.item}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/menu/item.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::menu}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/menu/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::dropdown}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/dropdown.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.calendar}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/calendar.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.clipboard-document-list}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/clipboard-document-list.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.cloud-arrow-up}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/cloud-arrow-up.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::icon.user}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/user.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::toast}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/toast/index.blade.php}:{1786975751} ?>
<?php # [BlazeFolded]:{flux::toast.group}:{D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/toast/group.blade.php}:{1786975751} ?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </head>
    <body class="min-h-screen bg-background text-foreground antialiased">
        <header class="sticky top-0 z-10 border-b border-border bg-surface/95 backdrop-blur">
            <div class="mx-auto flex min-h-16 max-w-2xl items-center gap-3 px-4 sm:px-6">
                <?php if (isset($component)) { $__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-logo','data' => ['href' => ''.e(route('dashboard')).'','wire:navigate' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('dashboard')).'','wire:navigate' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3)): ?>
<?php $attributes = $__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3; ?>
<?php unset($__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3)): ?>
<?php $component = $__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3; ?>
<?php unset($__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3); ?>
<?php endif; ?>
                <div class="ms-auto flex items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginal293d7ec7115725dbc5538d4bd6e40978 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal293d7ec7115725dbc5538d4bd6e40978 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lk-sync-badge','data' => ['status' => 'synced','dataSyncBadge' => true,'ariaLive' => 'polite']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lk-sync-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => 'synced','data-sync-badge' => true,'aria-live' => 'polite']); ?>
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
<?php endif; ?>
                    <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/cc33e0737c68fb3d002142cf4d0522d9.php'); ?>
<?php if (isset($__slotscc33e0737c68fb3d002142cf4d0522d9)) { $__slotsStackcc33e0737c68fb3d002142cf4d0522d9[] = $__slotscc33e0737c68fb3d002142cf4d0522d9; } ?>
<?php if (isset($__attrscc33e0737c68fb3d002142cf4d0522d9)) { $__attrsStackcc33e0737c68fb3d002142cf4d0522d9[] = $__attrscc33e0737c68fb3d002142cf4d0522d9; } ?>
<?php $__attrscc33e0737c68fb3d002142cf4d0522d9 = ['content' => __('Notifikasi'),'position' => 'bottom']; ?>
<?php $__slotscc33e0737c68fb3d002142cf4d0522d9 = []; ?>
<?php $__blaze->pushData($__attrscc33e0737c68fb3d002142cf4d0522d9); ?>
<?php ob_start(); ?>
                        <button type="button" aria-label="<?php echo e(__('Notifikasi')); ?>" class="inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-control text-on-surface-variant transition hover:bg-surface-subtle hover:text-on-surface">
                            <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                        </button>
                    <?php $__slotscc33e0737c68fb3d002142cf4d0522d9['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotscc33e0737c68fb3d002142cf4d0522d9); ?>
<?php _cc33e0737c68fb3d002142cf4d0522d9($__blaze, $__attrscc33e0737c68fb3d002142cf4d0522d9, $__slotscc33e0737c68fb3d002142cf4d0522d9, ['content'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcc33e0737c68fb3d002142cf4d0522d9)) { $__slotscc33e0737c68fb3d002142cf4d0522d9 = array_pop($__slotsStackcc33e0737c68fb3d002142cf4d0522d9); } ?>
<?php if (! empty($__attrsStackcc33e0737c68fb3d002142cf4d0522d9)) { $__attrscc33e0737c68fb3d002142cf4d0522d9 = array_pop($__attrsStackcc33e0737c68fb3d002142cf4d0522d9); } ?>
<?php $__blaze->popData(); ?>
                    <?php ob_start(); ?><ui-dropdown position="bottom end"  data-flux-dropdown>
    <?php ob_start(); ?>
                        <button type="button" aria-label="<?php echo e(__('Buka menu akun')); ?>" class="inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-full transition hover:bg-surface-subtle">
                            <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::avatar", ['name' => auth()->user()->name, 'initials' => auth()->user()->initials()]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/avatar/index.blade.php', $__blaze->compiledPath.'/41eeb391213c701601172daa9f203562.php'); ?>
<?php $__blaze->pushData(['name' => auth()->user()->name,'initials' => auth()->user()->initials()]); ?>
<?php _41eeb391213c701601172daa9f203562($__blaze, ['name' => auth()->user()->name,'initials' => auth()->user()->initials()], [], ['name', 'initials'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                        </button>
                        <?php ob_start(); ?><ui-menu
    class="[:where(&amp;)]:min-w-48 p-[.3125rem] rounded-lg shadow-xs border border-zinc-200 dark:border-zinc-600 bg-white dark:bg-zinc-700 focus:outline-hidden"
    popover="manual"
    data-flux-menu
>
    <?php ob_start(); ?>
                            <?php ob_start(); ?><a href="<?php echo e(route('profile.edit')); ?>" data-flux-menu-item="data-flux-menu-item" data-flux-menu-item-has-icon="data-flux-menu-item-has-icon" class="flex items-center px-2 py-1.5 w-full focus:outline-hidden rounded-md text-start text-sm font-medium [&amp;[disabled]]:opacity-50 text-zinc-800 data-active:bg-zinc-50 dark:text-white dark:data-active:bg-zinc-600 **:data-flux-menu-item-icon:text-zinc-400 dark:**:data-flux-menu-item-icon:text-white/60 [&amp;[data-active]_[data-flux-menu-item-icon]]:text-current" wire:navigate="">
        <svg class="shrink-0 [:where(&amp;)]:size-5 me-2" data-flux-menu-item-icon="data-flux-menu-item-icon" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M13.024 9.25c.47 0 .827-.433.637-.863a4 4 0 0 0-4.094-2.364c-.468.05-.665.576-.43.984l1.08 1.868a.75.75 0 0 0 .649.375h2.158ZM7.84 7.758c-.236-.408-.79-.5-1.068-.12A3.982 3.982 0 0 0 6 10c0 .884.287 1.7.772 2.363.278.38.832.287 1.068-.12l1.078-1.868a.75.75 0 0 0 0-.75L7.839 7.758ZM9.138 12.993c-.235.408-.039.934.43.984a4 4 0 0 0 4.094-2.364c.19-.43-.168-.863-.638-.863h-2.158a.75.75 0 0 0-.65.375l-1.078 1.868Z"/>
  <path fill-rule="evenodd" d="m14.13 4.347.644-1.117a.75.75 0 0 0-1.299-.75l-.644 1.116a6.954 6.954 0 0 0-2.081-.556V1.75a.75.75 0 0 0-1.5 0v1.29a6.954 6.954 0 0 0-2.081.556L6.525 2.48a.75.75 0 1 0-1.3.75l.645 1.117A7.04 7.04 0 0 0 4.347 5.87L3.23 5.225a.75.75 0 1 0-.75 1.3l1.116.644A6.954 6.954 0 0 0 3.04 9.25H1.75a.75.75 0 0 0 0 1.5h1.29c.078.733.27 1.433.556 2.081l-1.116.645a.75.75 0 1 0 .75 1.298l1.117-.644a7.04 7.04 0 0 0 1.523 1.523l-.645 1.117a.75.75 0 1 0 1.3.75l.644-1.116a6.954 6.954 0 0 0 2.081.556v1.29a.75.75 0 0 0 1.5 0v-1.29a6.954 6.954 0 0 0 2.081-.556l.645 1.116a.75.75 0 0 0 1.299-.75l-.645-1.117a7.042 7.042 0 0 0 1.523-1.523l1.117.644a.75.75 0 0 0 .75-1.298l-1.116-.645a6.954 6.954 0 0 0 .556-2.081h1.29a.75.75 0 0 0 0-1.5h-1.29a6.954 6.954 0 0 0-.556-2.081l1.116-.644a.75.75 0 0 0-.75-1.3l-1.117.645a7.04 7.04 0 0 0-1.524-1.523ZM10 4.5a5.475 5.475 0 0 0-2.781.754A5.527 5.527 0 0 0 5.22 7.277 5.475 5.475 0 0 0 4.5 10a5.475 5.475 0 0 0 .752 2.777 5.527 5.527 0 0 0 2.028 2.004c.802.458 1.73.719 2.72.719a5.474 5.474 0 0 0 2.78-.753 5.527 5.527 0 0 0 2.001-2.027c.458-.802.719-1.73.719-2.72a5.475 5.475 0 0 0-.753-2.78 5.528 5.528 0 0 0-2.028-2.002A5.475 5.475 0 0 0 10 4.5Z" clip-rule="evenodd"/>
</svg>

            
    <?php ob_start(); ?><?php echo e(__('Akun & pengaturan')); ?><?php echo trim(ob_get_clean()); ?>

    </a>
<?php echo ltrim(ob_get_clean()); ?>
                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-full">
                                <?php echo csrf_field(); ?>
                                <?php ob_start(); ?><button type="submit" class="flex items-center px-2 py-1.5 w-full focus:outline-hidden rounded-md text-start text-sm font-medium [&amp;[disabled]]:opacity-50 text-zinc-800 data-active:bg-zinc-50 dark:text-white dark:data-active:bg-zinc-600 **:data-flux-menu-item-icon:text-zinc-400 dark:**:data-flux-menu-item-icon:text-white/60 [&amp;[data-active]_[data-flux-menu-item-icon]]:text-current w-full cursor-pointer" data-flux-menu-item="data-flux-menu-item" data-flux-menu-item-has-icon="data-flux-menu-item-has-icon">
        <svg class="shrink-0 [:where(&amp;)]:size-5 me-2" data-flux-menu-item-icon="data-flux-menu-item-icon" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z" clip-rule="evenodd"/>
  <path fill-rule="evenodd" d="M6 10a.75.75 0 0 1 .75-.75h9.546l-1.048-.943a.75.75 0 1 1 1.004-1.114l2.5 2.25a.75.75 0 0 1 0 1.114l-2.5 2.25a.75.75 0 1 1-1.004-1.114l1.048-.943H6.75A.75.75 0 0 1 6 10Z" clip-rule="evenodd"/>
</svg>

            
    <?php ob_start(); ?><?php echo e(__('Keluar')); ?><?php echo trim(ob_get_clean()); ?>

    </button>
<?php echo ltrim(ob_get_clean()); ?>
                            </form>
                        <?php echo trim(ob_get_clean()); ?>

</ui-menu>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php echo trim(ob_get_clean()); ?>

</ui-dropdown>
<?php echo ltrim(ob_get_clean()); ?>
                </div>
            </div>
        </header>

        <main id="main-content" class="mx-auto min-h-[calc(100dvh-8rem)] max-w-2xl px-4 pb-28 pt-6 sm:px-6">
            <?php echo e($slot); ?>

        </main>

        <nav aria-label="<?php echo e(__('Navigasi teknisi')); ?>" class="fixed inset-x-0 bottom-0 z-20 border-t border-border bg-surface/95 backdrop-blur lk-safe-bottom">
            <div class="mx-auto grid max-w-2xl grid-cols-4 gap-1 px-3 pt-2">
                <a href="<?php echo e(route('technician.today')); ?>" aria-current="<?php echo e(request()->routeIs('technician.today') ? 'page' : 'false'); ?>" class="flex min-h-12 cursor-pointer flex-col items-center justify-center gap-1 rounded-control px-2 text-xs font-semibold transition <?php echo e(request()->routeIs('technician.today') ? 'bg-accent-soft text-accent' : 'text-muted-foreground hover:bg-surface-subtle hover:text-on-surface'); ?>" wire:navigate>
                    <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                    <span><?php echo e(__('Hari Ini')); ?></span>
                </a>
                <a href="<?php echo e(route('technician.tasks')); ?>" aria-current="<?php echo e(request()->routeIs('technician.tasks') ? 'page' : 'false'); ?>" class="flex min-h-12 cursor-pointer flex-col items-center justify-center gap-1 rounded-control px-2 text-xs font-medium transition <?php echo e(request()->routeIs('technician.tasks') ? 'bg-accent-soft text-accent' : 'text-muted-foreground hover:bg-surface-subtle hover:text-on-surface'); ?>" wire:navigate>
                    <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                    <span><?php echo e(__('Tugas')); ?></span>
                </a>
                <a href="<?php echo e(route('technician.sync.center')); ?>" aria-current="<?php echo e(request()->routeIs('technician.sync.*') ? 'page' : 'false'); ?>" class="flex min-h-12 cursor-pointer flex-col items-center justify-center gap-1 rounded-control px-2 text-xs font-medium transition <?php echo e(request()->routeIs('technician.sync.*') ? 'bg-accent-soft text-accent' : 'text-muted-foreground hover:bg-surface-subtle hover:text-on-surface'); ?>" wire:navigate>
                    <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                    <span><?php echo e(__('Sinkronisasi')); ?></span>
                </a>
                <a href="<?php echo e(route('profile.edit')); ?>" class="flex min-h-12 cursor-pointer flex-col items-center justify-center gap-1 rounded-control px-2 text-xs font-medium text-muted-foreground transition hover:bg-surface-subtle hover:text-on-surface">
                    <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                    <span><?php echo e(__('Akun')); ?></span>
                </a>
            </div>
        </nav>

        <?php app("livewire")->forceAssetInjection(); ?><div x-persist="<?php echo e('toast'); ?>">
            <?php ob_start(); ?><ui-toast-group x-data x-on:toast-show.document="$el.showToast($event.detail)" popover="manual" position="bottom end"  wire:ignore>
    <?php ob_start(); ?>
                <?php ob_start(); ?><ui-toast x-data x-on:toast-show.document="! $el.closest('ui-toast-group') && $el.showToast($event.detail)" popover="manual" position="bottom end" wire:ignore>
    <template>
        <div class="max-w-sm in-[ui-toast-group]:max-w-auto in-[ui-toast-group]:w-xs sm:in-[ui-toast-group]:w-sm" data-variant="" data-flux-toast-dialog>
            <div class="p-2 flex rounded-xl shadow-lg bg-white border border-zinc-200 border-b-zinc-300/80 dark:bg-zinc-700 dark:border-zinc-600">
                <div class="flex-1 flex items-start gap-4 overflow-hidden">
                    <div class="flex-1 py-1.5 ps-2.5 flex gap-2">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=success]_&]:block shrink-0 mt-0.5 size-4 text-lime-600 dark:text-lime-400">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd" />
                        </svg>

                        
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=warning]_&]:block shrink-0 mt-0.5 size-4 text-amber-500 dark:text-amber-400">
                            <path fill-rule="evenodd" d="M6.701 2.25c.577-1 2.02-1 2.598 0l5.196 9a1.5 1.5 0 0 1-1.299 2.25H2.804a1.5 1.5 0 0 1-1.3-2.25l5.197-9ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 1 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>

                        
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=info]_&]:block shrink-0 mt-0.5 size-4 text-cyan-500 dark:text-cyan-400">
                            <path fill-rule="evenodd" d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0ZM9 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM6.75 8a.75.75 0 0 0 0 1.5h.75v1.75a.75.75 0 0 0 1.5 0v-2.5A.75.75 0 0 0 8.25 8h-1.5Z" clip-rule="evenodd" />
                        </svg>

                        
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=danger]_&]:block shrink-0 mt-0.5 size-4 text-rose-500 dark:text-rose-400">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>

                        <div>
                            
                            <div class="font-medium text-sm text-zinc-800 dark:text-white [&:not(:empty)+div]:font-normal [&:not(:empty)+div]:text-zinc-500 [&:not(:empty)+div]:dark:text-zinc-300 [&:not(:empty)]:pb-2"><slot name="heading"></slot></div>

                            
                            <div class="font-medium text-sm text-zinc-800 dark:text-white"><slot name="text"></slot></div>

                            
                            <template name="link">
                                <a class="block mt-2 font-medium text-sm text-[var(--color-accent-content)] decoration-[color-mix(in_oklab,var(--color-accent-content),transparent_80%)] underline underline-offset-[6px] hover:decoration-current"><slot name="text"></slot></a>
                            </template>
                        </div>
                    </div>

                    
                    <ui-close class="flex items-center">
                        <button type="button" class="inline-flex items-center font-medium justify-center gap-2 truncate disabled:opacity-50 dark:disabled:opacity-75 disabled:cursor-default h-8 text-sm rounded-md w-8 bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-400 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white" as="button">
                            <div>
                                <svg class="[:where(&)]:size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"></path>
                                </svg>
                            </div>
                        </button>
                    </ui-close>
                </div>
            </div>
        </div>
    </template>
</ui-toast>
<?php echo ltrim(ob_get_clean()); ?>
            <?php echo trim(ob_get_clean()); ?>

</ui-toast-group>
<?php echo ltrim(ob_get_clean()); ?>
        </div>

        <?php app('livewire')->forceAssetInjection(); ?>
<?php echo app('flux')->scripts(); ?>

    </body>
</html><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\layouts\app\technician.blade.php ENDPATH**/ ?>