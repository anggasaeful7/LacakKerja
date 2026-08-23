<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="theme-color" content="#0F172A" />
<meta name="color-scheme" content="light dark" /><meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
<link rel="manifest" href="/manifest.webmanifest">
<meta name="lk-currency" content="<?php echo e(request()->attributes->get('currentOrganization')?->currency ?? 'IDR'); ?>">
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->check()): ?>
    <meta name="lk-scope" content="<?php echo e(auth()->id()); ?>:<?php echo e(auth()->user()->current_organization_id); ?>">
    <meta name="lk-sync-bootstrap-url" content="<?php echo e(route('technician.sync.bootstrap')); ?>">
    <meta name="lk-sync-batch-url" content="<?php echo e(route('technician.sync.batch')); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<title>
    <?php echo e(filled($title ?? null) ? $title.' - '.config('app.name', 'LacakKerja') : config('app.name', 'LacakKerja')); ?>

</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<?php echo app('Illuminate\Foundation\Vite')->fonts(); ?>

<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<?php echo app('flux')->fluxAppearance(); ?><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views/partials/head.blade.php ENDPATH**/ ?>