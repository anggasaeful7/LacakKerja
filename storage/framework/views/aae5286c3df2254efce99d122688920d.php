<?php
if (!function_exists('_aae5286c3df2254efce99d122688920d')):
function _aae5286c3df2254efce99d122688920d($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'class' => '-me-1 [[data-flux-input]:has(input:placeholder-shown)_&]:hidden [[data-flux-input]:has(input[disabled])_&]:hidden',
    'square' => true,
    'size' => null,
]);
?>

<?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/dba4e6d429c2c5737b8f4f363900dfa5.php'); ?>
<?php if (isset($__slotsdba4e6d429c2c5737b8f4f363900dfa5)) { $__slotsStackdba4e6d429c2c5737b8f4f363900dfa5[] = $__slotsdba4e6d429c2c5737b8f4f363900dfa5; } ?>
<?php if (isset($__attrsdba4e6d429c2c5737b8f4f363900dfa5)) { $__attrsStackdba4e6d429c2c5737b8f4f363900dfa5[] = $__attrsdba4e6d429c2c5737b8f4f363900dfa5; } ?>
<?php $__attrsdba4e6d429c2c5737b8f4f363900dfa5 = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputClearable','xOn:click' => 'clear()','tabindex' => '-1','ariaLabel' => e(__('Clear input')),'dataFluxClearButton' => true]; ?>
<?php $__slotsdba4e6d429c2c5737b8f4f363900dfa5 = []; ?>
<?php $__blaze->pushData($__attrsdba4e6d429c2c5737b8f4f363900dfa5); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/x-mark.blade.php', $__blaze->compiledPath.'/280e7c0d5c2e251a219414354cdac7c0.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant]); ?>
<?php _280e7c0d5c2e251a219414354cdac7c0($__blaze, ['variant' => $iconVariant], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsdba4e6d429c2c5737b8f4f363900dfa5['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsdba4e6d429c2c5737b8f4f363900dfa5); ?>
<?php _dba4e6d429c2c5737b8f4f363900dfa5($__blaze, $__attrsdba4e6d429c2c5737b8f4f363900dfa5, $__slotsdba4e6d429c2c5737b8f4f363900dfa5, ['attributes', 'size', 'dataFluxClearButton'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'ariaLabel' => 'aria-label', 'dataFluxClearButton' => 'data-flux-clear-button'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackdba4e6d429c2c5737b8f4f363900dfa5)) { $__slotsdba4e6d429c2c5737b8f4f363900dfa5 = array_pop($__slotsStackdba4e6d429c2c5737b8f4f363900dfa5); } ?>
<?php if (! empty($__attrsStackdba4e6d429c2c5737b8f4f363900dfa5)) { $__attrsdba4e6d429c2c5737b8f4f363900dfa5 = array_pop($__attrsStackdba4e6d429c2c5737b8f4f363900dfa5); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\stubs\resources\views\flux\input\clearable.blade.php ENDPATH**/ ?>