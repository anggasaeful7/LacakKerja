<?php
if (!function_exists('__4d55aef6597543121593deaac84d1484')):
function __4d55aef6597543121593deaac84d1484($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
$__defaults = [
    'length' => null,
    'private' => false,
];
$length ??= $attributes['length'] ?? $__defaults['length']; unset($attributes['length']);
$private ??= $attributes['private'] ?? $__defaults['private']; unset($attributes['private']);
unset($__defaults);
?>

<?php
    $classes = Flux::classes()
        ->add('flex items-center gap-2 isolate w-fit')
        ->add('[&_[data-flux-input-group]]:w-auto')
?>

<?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/6fa86bcf5b3f9e49601a3759c8de5679.php'); ?>
<?php if (isset($__slots6fa86bcf5b3f9e49601a3759c8de5679)) { $__slotsStack6fa86bcf5b3f9e49601a3759c8de5679[] = $__slots6fa86bcf5b3f9e49601a3759c8de5679; } ?>
<?php if (isset($__attrs6fa86bcf5b3f9e49601a3759c8de5679)) { $__attrsStack6fa86bcf5b3f9e49601a3759c8de5679[] = $__attrs6fa86bcf5b3f9e49601a3759c8de5679; } ?>
<?php $__attrs6fa86bcf5b3f9e49601a3759c8de5679 = ['attributes' => $attributes]; ?>
<?php $__slots6fa86bcf5b3f9e49601a3759c8de5679 = []; ?>
<?php $__blaze->pushData($__attrs6fa86bcf5b3f9e49601a3759c8de5679); ?>
<?php ob_start(); ?>
    <ui-otp
        <?php echo e($attributes->class($classes)); ?>

        data-flux-otp
        data-flux-control
        role="group"
        data-flux-input-aria-label="<?php echo e(__('Character {current} of {total}')); ?>"
    >
        <?php if($slot->isEmpty() && $length): ?>
            <?php for($i = 0; $i < $length; $i++): ?>
                <?php $__blaze->ensureRequired('D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/otp/input.blade.php', $__blaze->compiledPath.'/4081018075f4c45e9b8ca9461327bb8e.php'); ?>
<?php $__blaze->pushData([]); ?>
<?php __4081018075f4c45e9b8ca9461327bb8e($__blaze, [], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
            <?php endfor; ?>
        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </ui-otp>
<?php $__slots6fa86bcf5b3f9e49601a3759c8de5679['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots6fa86bcf5b3f9e49601a3759c8de5679); ?>
<?php __6fa86bcf5b3f9e49601a3759c8de5679($__blaze, $__attrs6fa86bcf5b3f9e49601a3759c8de5679, $__slots6fa86bcf5b3f9e49601a3759c8de5679, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack6fa86bcf5b3f9e49601a3759c8de5679)) { $__slots6fa86bcf5b3f9e49601a3759c8de5679 = array_pop($__slotsStack6fa86bcf5b3f9e49601a3759c8de5679); } ?>
<?php if (! empty($__attrsStack6fa86bcf5b3f9e49601a3759c8de5679)) { $__attrs6fa86bcf5b3f9e49601a3759c8de5679 = array_pop($__attrsStack6fa86bcf5b3f9e49601a3759c8de5679); } ?>
<?php $__blaze->popData(); ?><?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\vendor\livewire\flux\src/../stubs/resources/views/flux/otp/index.blade.php ENDPATH**/ ?>