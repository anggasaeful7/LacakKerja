<?php
if (!function_exists('_6fa86bcf5b3f9e49601a3759c8de5679')):
function _6fa86bcf5b3f9e49601a3759c8de5679($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'name',
    'descriptionTrailing',
    'description',
    'label',
    'badge',
]));
?>

<?php $descriptionTrailing = $descriptionTrailing ??= $attributes->pluck('description:trailing'); ?>

<?php
$__defaults = [
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'descriptionTrailing' => null,
    'description' => null,
    'label' => null,
    'badge' => null,
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$descriptionTrailing ??= $attributes['description-trailing'] ?? $attributes['descriptionTrailing'] ?? $__defaults['descriptionTrailing']; unset($attributes['descriptionTrailing'], $attributes['description-trailing']);
$description ??= $attributes['description'] ?? $__defaults['description']; unset($attributes['description']);
$label ??= $attributes['label'] ?? $__defaults['label']; unset($attributes['label']);
$badge ??= $attributes['badge'] ?? $__defaults['badge']; unset($attributes['badge']);
unset($__defaults);
?>

<?php if (isset($label) || isset($description) || isset($descriptionTrailing)): ?>
    <?php

        $fieldAttributes = Flux::attributesAfter('field:', $attributes, []);
        $labelAttributes = Flux::attributesAfter('label:', $attributes, ['badge' => $badge]);
        $descriptionAttributes = Flux::attributesAfter('description:', $attributes, []);
        $errorAttributes = Flux::attributesAfter('error:', $attributes, ['name' => $name]);
    ?>
    <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/field.blade.php', $__blaze->compiledPath.'/2b507f99dd2572e90af484178852ecd9.php'); ?>
<?php if (isset($__slots2b507f99dd2572e90af484178852ecd9)) { $__slotsStack2b507f99dd2572e90af484178852ecd9[] = $__slots2b507f99dd2572e90af484178852ecd9; } ?>
<?php if (isset($__attrs2b507f99dd2572e90af484178852ecd9)) { $__attrsStack2b507f99dd2572e90af484178852ecd9[] = $__attrs2b507f99dd2572e90af484178852ecd9; } ?>
<?php $__attrs2b507f99dd2572e90af484178852ecd9 = ['attributes' => $fieldAttributes]; ?>
<?php $__slots2b507f99dd2572e90af484178852ecd9 = []; ?>
<?php $__blaze->pushData($__attrs2b507f99dd2572e90af484178852ecd9); ?>
<?php ob_start(); ?>
        <?php if (isset($label)): ?>
            <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/label.blade.php', $__blaze->compiledPath.'/b2d22d7039742165a32ee05f557608a8.php'); ?>
<?php if (isset($__slotsb2d22d7039742165a32ee05f557608a8)) { $__slotsStackb2d22d7039742165a32ee05f557608a8[] = $__slotsb2d22d7039742165a32ee05f557608a8; } ?>
<?php if (isset($__attrsb2d22d7039742165a32ee05f557608a8)) { $__attrsStackb2d22d7039742165a32ee05f557608a8[] = $__attrsb2d22d7039742165a32ee05f557608a8; } ?>
<?php $__attrsb2d22d7039742165a32ee05f557608a8 = ['attributes' => $labelAttributes]; ?>
<?php $__slotsb2d22d7039742165a32ee05f557608a8 = []; ?>
<?php $__blaze->pushData($__attrsb2d22d7039742165a32ee05f557608a8); ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slotsb2d22d7039742165a32ee05f557608a8['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsb2d22d7039742165a32ee05f557608a8); ?>
<?php _b2d22d7039742165a32ee05f557608a8($__blaze, $__attrsb2d22d7039742165a32ee05f557608a8, $__slotsb2d22d7039742165a32ee05f557608a8, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackb2d22d7039742165a32ee05f557608a8)) { $__slotsb2d22d7039742165a32ee05f557608a8 = array_pop($__slotsStackb2d22d7039742165a32ee05f557608a8); } ?>
<?php if (! empty($__attrsStackb2d22d7039742165a32ee05f557608a8)) { $__attrsb2d22d7039742165a32ee05f557608a8 = array_pop($__attrsStackb2d22d7039742165a32ee05f557608a8); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/a65844d4731cd841cffb055a27f164cf.php'); ?>
<?php if (isset($__slotsa65844d4731cd841cffb055a27f164cf)) { $__slotsStacka65844d4731cd841cffb055a27f164cf[] = $__slotsa65844d4731cd841cffb055a27f164cf; } ?>
<?php if (isset($__attrsa65844d4731cd841cffb055a27f164cf)) { $__attrsStacka65844d4731cd841cffb055a27f164cf[] = $__attrsa65844d4731cd841cffb055a27f164cf; } ?>
<?php $__attrsa65844d4731cd841cffb055a27f164cf = ['attributes' => $descriptionAttributes]; ?>
<?php $__slotsa65844d4731cd841cffb055a27f164cf = []; ?>
<?php $__blaze->pushData($__attrsa65844d4731cd841cffb055a27f164cf); ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slotsa65844d4731cd841cffb055a27f164cf['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsa65844d4731cd841cffb055a27f164cf); ?>
<?php _a65844d4731cd841cffb055a27f164cf($__blaze, $__attrsa65844d4731cd841cffb055a27f164cf, $__slotsa65844d4731cd841cffb055a27f164cf, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka65844d4731cd841cffb055a27f164cf)) { $__slotsa65844d4731cd841cffb055a27f164cf = array_pop($__slotsStacka65844d4731cd841cffb055a27f164cf); } ?>
<?php if (! empty($__attrsStacka65844d4731cd841cffb055a27f164cf)) { $__attrsa65844d4731cd841cffb055a27f164cf = array_pop($__attrsStacka65844d4731cd841cffb055a27f164cf); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        
        <?php $__getScope = fn($scope = []) => $scope; ?><?php if (isset($scope)) $__scope = $scope; ?><?php $scope = $__getScope(scope: ['attributes' => $errorAttributes->getAttributes()]); ?>
        <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/18f04313a41a43517ffbd5c15b434d8b.php'); ?>
<?php $__blaze->pushData(['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])]); ?>
<?php _18f04313a41a43517ffbd5c15b434d8b($__blaze, ['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])], [], ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>

        <?php if (isset($descriptionTrailing)): ?>
            <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/a65844d4731cd841cffb055a27f164cf.php'); ?>
<?php if (isset($__slotsa65844d4731cd841cffb055a27f164cf)) { $__slotsStacka65844d4731cd841cffb055a27f164cf[] = $__slotsa65844d4731cd841cffb055a27f164cf; } ?>
<?php if (isset($__attrsa65844d4731cd841cffb055a27f164cf)) { $__attrsStacka65844d4731cd841cffb055a27f164cf[] = $__attrsa65844d4731cd841cffb055a27f164cf; } ?>
<?php $__attrsa65844d4731cd841cffb055a27f164cf = ['attributes' => $descriptionAttributes]; ?>
<?php $__slotsa65844d4731cd841cffb055a27f164cf = []; ?>
<?php $__blaze->pushData($__attrsa65844d4731cd841cffb055a27f164cf); ?>
<?php ob_start(); ?><?php echo e($descriptionTrailing); ?><?php $__slotsa65844d4731cd841cffb055a27f164cf['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsa65844d4731cd841cffb055a27f164cf); ?>
<?php _a65844d4731cd841cffb055a27f164cf($__blaze, $__attrsa65844d4731cd841cffb055a27f164cf, $__slotsa65844d4731cd841cffb055a27f164cf, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka65844d4731cd841cffb055a27f164cf)) { $__slotsa65844d4731cd841cffb055a27f164cf = array_pop($__slotsStacka65844d4731cd841cffb055a27f164cf); } ?>
<?php if (! empty($__attrsStacka65844d4731cd841cffb055a27f164cf)) { $__attrsa65844d4731cd841cffb055a27f164cf = array_pop($__attrsStacka65844d4731cd841cffb055a27f164cf); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slots2b507f99dd2572e90af484178852ecd9['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots2b507f99dd2572e90af484178852ecd9); ?>
<?php _2b507f99dd2572e90af484178852ecd9($__blaze, $__attrs2b507f99dd2572e90af484178852ecd9, $__slots2b507f99dd2572e90af484178852ecd9, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack2b507f99dd2572e90af484178852ecd9)) { $__slots2b507f99dd2572e90af484178852ecd9 = array_pop($__slotsStack2b507f99dd2572e90af484178852ecd9); } ?>
<?php if (! empty($__attrsStack2b507f99dd2572e90af484178852ecd9)) { $__attrs2b507f99dd2572e90af484178852ecd9 = array_pop($__attrsStack2b507f99dd2572e90af484178852ecd9); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php ENDPATH**/ ?>