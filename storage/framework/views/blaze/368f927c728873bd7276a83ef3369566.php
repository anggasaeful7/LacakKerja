<?php
if (!function_exists('__368f927c728873bd7276a83ef3369566')):
function __368f927c728873bd7276a83ef3369566($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
extract(Flux::forwardedAttributes($attributes, [
    'tooltipPosition',
    'tooltipKbd',
    'tooltip',
]));
?>

<?php $tooltipPosition = $tooltipPosition ??= $attributes->pluck('tooltip:position'); ?>
<?php $tooltipKbd = $tooltipKbd ??= $attributes->pluck('tooltip:kbd'); ?>
<?php $tooltip = $tooltip ??= $attributes->pluck('tooltip'); ?>

<?php
$__defaults = [
    'tooltipPosition' => 'top',
    'tooltipKbd' => null,
    'tooltip' => null,
];
$tooltipPosition ??= $attributes['tooltip-position'] ?? $attributes['tooltipPosition'] ?? $__defaults['tooltipPosition']; unset($attributes['tooltipPosition'], $attributes['tooltip-position']);
$tooltipKbd ??= $attributes['tooltip-kbd'] ?? $attributes['tooltipKbd'] ?? $__defaults['tooltipKbd']; unset($attributes['tooltipKbd'], $attributes['tooltip-kbd']);
$tooltip ??= $attributes['tooltip'] ?? $__defaults['tooltip']; unset($attributes['tooltip']);
unset($__defaults);
?>

<?php if ($tooltip): ?>
    <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/cc33e0737c68fb3d002142cf4d0522d9.php'); ?>
<?php if (isset($__slotscc33e0737c68fb3d002142cf4d0522d9)) { $__slotsStackcc33e0737c68fb3d002142cf4d0522d9[] = $__slotscc33e0737c68fb3d002142cf4d0522d9; } ?>
<?php if (isset($__attrscc33e0737c68fb3d002142cf4d0522d9)) { $__attrsStackcc33e0737c68fb3d002142cf4d0522d9[] = $__attrscc33e0737c68fb3d002142cf4d0522d9; } ?>
<?php $__attrscc33e0737c68fb3d002142cf4d0522d9 = ['content' => $tooltip,'position' => $tooltipPosition,'kbd' => $tooltipKbd]; ?>
<?php $__slotscc33e0737c68fb3d002142cf4d0522d9 = []; ?>
<?php $__blaze->pushData($__attrscc33e0737c68fb3d002142cf4d0522d9); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slotscc33e0737c68fb3d002142cf4d0522d9['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotscc33e0737c68fb3d002142cf4d0522d9); ?>
<?php __cc33e0737c68fb3d002142cf4d0522d9($__blaze, $__attrscc33e0737c68fb3d002142cf4d0522d9, $__slotscc33e0737c68fb3d002142cf4d0522d9, ['content', 'position', 'kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcc33e0737c68fb3d002142cf4d0522d9)) { $__slotscc33e0737c68fb3d002142cf4d0522d9 = array_pop($__slotsStackcc33e0737c68fb3d002142cf4d0522d9); } ?>
<?php if (! empty($__attrsStackcc33e0737c68fb3d002142cf4d0522d9)) { $__attrscc33e0737c68fb3d002142cf4d0522d9 = array_pop($__attrsStackcc33e0737c68fb3d002142cf4d0522d9); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/with-tooltip.blade.php ENDPATH**/ ?>