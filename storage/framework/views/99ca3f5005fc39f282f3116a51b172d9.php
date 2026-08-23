<?php
if (!function_exists('_99ca3f5005fc39f282f3116a51b172d9')):
function _99ca3f5005fc39f282f3116a51b172d9($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
$__defaults = [
    'iconVariant' => 'mini',
    'size' => null,
];
$iconVariant ??= $attributes['icon-variant'] ?? $attributes['iconVariant'] ?? $__defaults['iconVariant']; unset($attributes['iconVariant'], $attributes['icon-variant']);
$size ??= $attributes['size'] ?? $__defaults['size']; unset($attributes['size']);
unset($__defaults);
?>

<?php
$attributes = $attributes->merge([
    'variant' => 'subtle',
    'class' => '-me-1',
    'square' => true,
    'size' => null,
]);
?>

<?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/dba4e6d429c2c5737b8f4f363900dfa5.php'); ?>
<?php if (isset($__slotsdba4e6d429c2c5737b8f4f363900dfa5)) { $__slotsStackdba4e6d429c2c5737b8f4f363900dfa5[] = $__slotsdba4e6d429c2c5737b8f4f363900dfa5; } ?>
<?php if (isset($__attrsdba4e6d429c2c5737b8f4f363900dfa5)) { $__attrsStackdba4e6d429c2c5737b8f4f363900dfa5[] = $__attrsdba4e6d429c2c5737b8f4f363900dfa5; } ?>
<?php $__attrsdba4e6d429c2c5737b8f4f363900dfa5 = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputViewable','xOn:click' => 'toggle()','xBind:dataViewableOpen' => 'open','ariaLabel' => e(__('Toggle password visibility'))]; ?>
<?php $__slotsdba4e6d429c2c5737b8f4f363900dfa5 = []; ?>
<?php $__blaze->pushData($__attrsdba4e6d429c2c5737b8f4f363900dfa5); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/eye-slash.blade.php', $__blaze->compiledPath.'/2c8b3149502a34951bf24717913c75d3.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant,'class' => 'hidden [[data-viewable-open]>&]:block']); ?>
<?php _2c8b3149502a34951bf24717913c75d3($__blaze, ['variant' => $iconVariant,'class' => 'hidden [[data-viewable-open]>&]:block'], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/eye.blade.php', $__blaze->compiledPath.'/be1c2fe325d5c4eea35d99df30d3142a.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant,'class' => 'block [[data-viewable-open]>&]:hidden']); ?>
<?php _be1c2fe325d5c4eea35d99df30d3142a($__blaze, ['variant' => $iconVariant,'class' => 'block [[data-viewable-open]>&]:hidden'], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsdba4e6d429c2c5737b8f4f363900dfa5['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsdba4e6d429c2c5737b8f4f363900dfa5); ?>
<?php _dba4e6d429c2c5737b8f4f363900dfa5($__blaze, $__attrsdba4e6d429c2c5737b8f4f363900dfa5, $__slotsdba4e6d429c2c5737b8f4f363900dfa5, ['attributes', 'size'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'xBind:dataViewableOpen' => 'x-bind:data-viewable-open', 'ariaLabel' => 'aria-label'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackdba4e6d429c2c5737b8f4f363900dfa5)) { $__slotsdba4e6d429c2c5737b8f4f363900dfa5 = array_pop($__slotsStackdba4e6d429c2c5737b8f4f363900dfa5); } ?>
<?php if (! empty($__attrsStackdba4e6d429c2c5737b8f4f363900dfa5)) { $__attrsdba4e6d429c2c5737b8f4f363900dfa5 = array_pop($__attrsStackdba4e6d429c2c5737b8f4f363900dfa5); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\stubs\resources\views\flux\input\viewable.blade.php ENDPATH**/ ?>