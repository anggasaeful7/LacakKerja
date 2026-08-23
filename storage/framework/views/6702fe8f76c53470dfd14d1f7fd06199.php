<?php
if (!function_exists('_6702fe8f76c53470dfd14d1f7fd06199')):
function _6702fe8f76c53470dfd14d1f7fd06199($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php $tooltipPosition = $tooltipPosition ??= $attributes->pluck('tooltip:position'); ?>
<?php $tooltipKbd = $tooltipKbd ??= $attributes->pluck('tooltip:kbd'); ?>
<?php $tooltip = $tooltip ??= $attributes->pluck('tooltip'); ?>
<?php $iconTrailing ??= $attributes->pluck('icon:trailing'); ?>
<?php $iconVariant ??= $attributes->pluck('icon:variant'); ?>

<?php
$__defaults = [
    'tooltipPosition' => 'right',
    'tooltipKbd' => null,
    'tooltip' => null,
    'iconVariant' => 'outline',
    'iconTrailing' => null,
    'badgeColor' => null,
    'iconDot' => null,
    'accent' => true,
    'badge' => null,
    'icon' => null,
];
$tooltipPosition ??= $attributes['tooltip-position'] ?? $attributes['tooltipPosition'] ?? $__defaults['tooltipPosition']; unset($attributes['tooltipPosition'], $attributes['tooltip-position']);
$tooltipKbd ??= $attributes['tooltip-kbd'] ?? $attributes['tooltipKbd'] ?? $__defaults['tooltipKbd']; unset($attributes['tooltipKbd'], $attributes['tooltip-kbd']);
$tooltip ??= $attributes['tooltip'] ?? $__defaults['tooltip']; unset($attributes['tooltip']);
$iconVariant ??= $attributes['icon-variant'] ?? $attributes['iconVariant'] ?? $__defaults['iconVariant']; unset($attributes['iconVariant'], $attributes['icon-variant']);
$iconTrailing ??= $attributes['icon-trailing'] ?? $attributes['iconTrailing'] ?? $__defaults['iconTrailing']; unset($attributes['iconTrailing'], $attributes['icon-trailing']);
$badgeColor ??= $attributes['badge-color'] ?? $attributes['badgeColor'] ?? $__defaults['badgeColor']; unset($attributes['badgeColor'], $attributes['badge-color']);
$iconDot ??= $attributes['icon-dot'] ?? $attributes['iconDot'] ?? $__defaults['iconDot']; unset($attributes['iconDot'], $attributes['icon-dot']);
$accent ??= $attributes['accent'] ?? $__defaults['accent']; unset($attributes['accent']);
$badge ??= $attributes['badge'] ?? $__defaults['badge']; unset($attributes['badge']);
$icon ??= $attributes['icon'] ?? $__defaults['icon']; unset($attributes['icon']);
unset($__defaults);
?>

<?php
$tooltip ??= $slot->isNotEmpty() ? (string) $slot : null;

// Size-up icons in square/icon-only buttons...
$iconClasses = Flux::classes('size-4')
    ->add('in-data-flux-sidebar-group-dropdown:text-zinc-400! dark:in-data-flux-sidebar-group-dropdown:text-white/80!')
    ->add('[[data-flux-sidebar-item]:hover_&]:text-current!')
    ->add('[[data-flux-sidebar-item][data-active]_&]:text-current!');

$classes = Flux::classes()
    ->add('h-8 in-data-flux-sidebar-on-mobile:h-10 relative flex items-center gap-3 rounded-lg')
    ->add('in-data-flux-sidebar-collapsed-desktop:w-10 in-data-flux-sidebar-collapsed-desktop:justify-center')
    ->add('py-0 text-start w-full px-3 has-data-flux-navlist-badge:not-in-data-flux-sidebar-collapsed-desktop:pe-1.5 my-px')
    ->add('text-zinc-500 dark:text-white/80')
    ->add(match ($accent) {
        true => [
            'data-current:text-(--color-accent-content) hover:data-current:text-(--color-accent-content)',
            'data-current:bg-white dark:data-current:bg-white/[7%] data-current:border data-current:border-zinc-200 dark:data-current:border-transparent',
            'hover:text-zinc-800 dark:hover:text-white dark:hover:bg-white/[7%] hover:bg-zinc-800/5 ',
            'border border-transparent',
        ],
        false => [
            'data-current:text-zinc-800 dark:data-current:text-zinc-100 data-current:border-zinc-200',
            'data-current:bg-white dark:data-current:bg-white/10 data-current:border data-current:border-zinc-200 dark:data-current:border-white/10 data-current:shadow-xs',
            'hover:text-zinc-800 dark:hover:text-white',
        ],
    })
    // Override the default styles to match dropdowns for when the item is inside a collapsed group dropdown...
    ->add('in-data-flux-sidebar-group-dropdown:w-auto! in-data-flux-sidebar-group-dropdown:px-2!')
    ->add('in-data-flux-sidebar-group-dropdown:focus:outline-hidden!')
    ->add('in-data-flux-sidebar-group-dropdown:text-zinc-800! in-data-flux-sidebar-group-dropdown:bg-white! in-data-flux-sidebar-group-dropdown:hover:bg-zinc-50!')
    ->add('in-data-flux-sidebar-group-dropdown:data-active:bg-zinc-50!')
    ->add('dark:in-data-flux-sidebar-group-dropdown:text-white! dark:in-data-flux-sidebar-group-dropdown:bg-transparent! dark:in-data-flux-sidebar-group-dropdown:hover:bg-zinc-600! dark:in-data-flux-sidebar-group-dropdown:data-active:bg-zinc-600!')
    ;
?>

<?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/cc33e0737c68fb3d002142cf4d0522d9.php'); ?>
<?php if (isset($__slotscc33e0737c68fb3d002142cf4d0522d9)) { $__slotsStackcc33e0737c68fb3d002142cf4d0522d9[] = $__slotscc33e0737c68fb3d002142cf4d0522d9; } ?>
<?php if (isset($__attrscc33e0737c68fb3d002142cf4d0522d9)) { $__attrsStackcc33e0737c68fb3d002142cf4d0522d9[] = $__attrscc33e0737c68fb3d002142cf4d0522d9; } ?>
<?php $__attrscc33e0737c68fb3d002142cf4d0522d9 = ['position' => $tooltipPosition]; ?>
<?php $__slotscc33e0737c68fb3d002142cf4d0522d9 = []; ?>
<?php $__blaze->pushData($__attrscc33e0737c68fb3d002142cf4d0522d9); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button-or-link.blade.php', $__blaze->compiledPath.'/37b31ee99c3b5de21e27770a8fae0a25.php'); ?>
<?php if (isset($__slots37b31ee99c3b5de21e27770a8fae0a25)) { $__slotsStack37b31ee99c3b5de21e27770a8fae0a25[] = $__slots37b31ee99c3b5de21e27770a8fae0a25; } ?>
<?php if (isset($__attrs37b31ee99c3b5de21e27770a8fae0a25)) { $__attrsStack37b31ee99c3b5de21e27770a8fae0a25[] = $__attrs37b31ee99c3b5de21e27770a8fae0a25; } ?>
<?php $__attrs37b31ee99c3b5de21e27770a8fae0a25 = ['attributes' => $attributes->class($classes),'dataFluxSidebarItem' => true]; ?>
<?php $__slots37b31ee99c3b5de21e27770a8fae0a25 = []; ?>
<?php $__blaze->pushData($__attrs37b31ee99c3b5de21e27770a8fae0a25); ?>
<?php ob_start(); ?>
        <?php if ($icon): ?>
            <div class="relative">
                <?php if (is_string($icon) && $icon !== ''): ?>
                    <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $icon, 'variant' => $iconVariant, 'class' => $iconClasses]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/995fcf30025e3f51eec4ce3d730f2a62.php'); ?>
<?php $__blaze->pushData(['icon' => $icon,'variant' => $iconVariant,'class' => $iconClasses]); ?>
<?php _995fcf30025e3f51eec4ce3d730f2a62($__blaze, ['icon' => $icon,'variant' => $iconVariant,'class' => $iconClasses], [], ['icon', 'variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                <?php else: ?>
                    <?php echo e($icon); ?>

                <?php endif; ?>

                <?php if ($iconDot): ?>
                    <div class="absolute top-[-2px] end-[-2px]">
                        <div class="size-[6px] rounded-full bg-zinc-500 dark:bg-zinc-400"></div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($slot->isNotEmpty()): ?>
            <div class="
                in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden
                flex-1 text-sm font-medium truncate [[data-nav-footer]_&]:hidden [[data-nav-sidebar]_[data-nav-footer]_&]:block" data-content><?php echo e($slot); ?></div>
        <?php endif; ?>

        <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
            <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $iconTrailing, 'variant' => $iconVariant, 'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden size-4!']); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/995fcf30025e3f51eec4ce3d730f2a62.php'); ?>
<?php $__blaze->pushData(['icon' => $iconTrailing,'variant' => $iconVariant,'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden size-4!']); ?>
<?php _995fcf30025e3f51eec4ce3d730f2a62($__blaze, ['icon' => $iconTrailing,'variant' => $iconVariant,'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden size-4!'], [], ['icon', 'variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
        <?php elseif ($iconTrailing): ?>
            <?php echo e($iconTrailing); ?>

        <?php endif; ?>

        <?php if (isset($badge) && $badge !== ''): ?>
            <?php $badgeAttributes = Flux::attributesAfter('badge:', $attributes, ['color' => $badgeColor]); ?>
            <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/navlist/badge.blade.php', $__blaze->compiledPath.'/47239e35670c0346764efb6633d59113.php'); ?>
<?php if (isset($__slots47239e35670c0346764efb6633d59113)) { $__slotsStack47239e35670c0346764efb6633d59113[] = $__slots47239e35670c0346764efb6633d59113; } ?>
<?php if (isset($__attrs47239e35670c0346764efb6633d59113)) { $__attrsStack47239e35670c0346764efb6633d59113[] = $__attrs47239e35670c0346764efb6633d59113; } ?>
<?php $__attrs47239e35670c0346764efb6633d59113 = ['attributes' => $badgeAttributes,'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden']; ?>
<?php $__slots47239e35670c0346764efb6633d59113 = []; ?>
<?php $__blaze->pushData($__attrs47239e35670c0346764efb6633d59113); ?>
<?php ob_start(); ?><?php echo e($badge); ?><?php $__slots47239e35670c0346764efb6633d59113['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots47239e35670c0346764efb6633d59113); ?>
<?php _47239e35670c0346764efb6633d59113($__blaze, $__attrs47239e35670c0346764efb6633d59113, $__slots47239e35670c0346764efb6633d59113, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack47239e35670c0346764efb6633d59113)) { $__slots47239e35670c0346764efb6633d59113 = array_pop($__slotsStack47239e35670c0346764efb6633d59113); } ?>
<?php if (! empty($__attrsStack47239e35670c0346764efb6633d59113)) { $__attrs47239e35670c0346764efb6633d59113 = array_pop($__attrsStack47239e35670c0346764efb6633d59113); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slots37b31ee99c3b5de21e27770a8fae0a25['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots37b31ee99c3b5de21e27770a8fae0a25); ?>
<?php _37b31ee99c3b5de21e27770a8fae0a25($__blaze, $__attrs37b31ee99c3b5de21e27770a8fae0a25, $__slots37b31ee99c3b5de21e27770a8fae0a25, ['attributes', 'dataFluxSidebarItem'], ['dataFluxSidebarItem' => 'data-flux-sidebar-item'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack37b31ee99c3b5de21e27770a8fae0a25)) { $__slots37b31ee99c3b5de21e27770a8fae0a25 = array_pop($__slotsStack37b31ee99c3b5de21e27770a8fae0a25); } ?>
<?php if (! empty($__attrsStack37b31ee99c3b5de21e27770a8fae0a25)) { $__attrs37b31ee99c3b5de21e27770a8fae0a25 = array_pop($__attrsStack37b31ee99c3b5de21e27770a8fae0a25); } ?>
<?php $__blaze->popData(); ?>

    <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/ddad38b1b9a000816baf1c23043b060b.php'); ?>
<?php if (isset($__slotsddad38b1b9a000816baf1c23043b060b)) { $__slotsStackddad38b1b9a000816baf1c23043b060b[] = $__slotsddad38b1b9a000816baf1c23043b060b; } ?>
<?php if (isset($__attrsddad38b1b9a000816baf1c23043b060b)) { $__attrsStackddad38b1b9a000816baf1c23043b060b[] = $__attrsddad38b1b9a000816baf1c23043b060b; } ?>
<?php $__attrsddad38b1b9a000816baf1c23043b060b = ['kbd' => $tooltipKbd,'class' => 'not-in-data-flux-sidebar-collapsed-desktop:hidden in-data-flux-sidebar-group-dropdown:hidden cursor-default']; ?>
<?php $__slotsddad38b1b9a000816baf1c23043b060b = []; ?>
<?php $__blaze->pushData($__attrsddad38b1b9a000816baf1c23043b060b); ?>
<?php ob_start(); ?>
        <?php echo e($tooltip); ?>

    <?php $__slotsddad38b1b9a000816baf1c23043b060b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsddad38b1b9a000816baf1c23043b060b); ?>
<?php _ddad38b1b9a000816baf1c23043b060b($__blaze, $__attrsddad38b1b9a000816baf1c23043b060b, $__slotsddad38b1b9a000816baf1c23043b060b, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackddad38b1b9a000816baf1c23043b060b)) { $__slotsddad38b1b9a000816baf1c23043b060b = array_pop($__slotsStackddad38b1b9a000816baf1c23043b060b); } ?>
<?php if (! empty($__attrsStackddad38b1b9a000816baf1c23043b060b)) { $__attrsddad38b1b9a000816baf1c23043b060b = array_pop($__attrsStackddad38b1b9a000816baf1c23043b060b); } ?>
<?php $__blaze->popData(); ?>
<?php $__slotscc33e0737c68fb3d002142cf4d0522d9['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotscc33e0737c68fb3d002142cf4d0522d9); ?>
<?php _cc33e0737c68fb3d002142cf4d0522d9($__blaze, $__attrscc33e0737c68fb3d002142cf4d0522d9, $__slotscc33e0737c68fb3d002142cf4d0522d9, ['position'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcc33e0737c68fb3d002142cf4d0522d9)) { $__slotscc33e0737c68fb3d002142cf4d0522d9 = array_pop($__slotsStackcc33e0737c68fb3d002142cf4d0522d9); } ?>
<?php if (! empty($__attrsStackcc33e0737c68fb3d002142cf4d0522d9)) { $__attrscc33e0737c68fb3d002142cf4d0522d9 = array_pop($__attrsStackcc33e0737c68fb3d002142cf4d0522d9); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\stubs\resources\views\flux\sidebar\item.blade.php ENDPATH**/ ?>