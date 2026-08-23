<!doctype html>
<html lang="id">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?php echo e($title); ?></title></head>
<body style="margin:0;background:#f8fafc;color:#0f172a;font-family:Arial,sans-serif;line-height:1.6">
    <main style="max-width:600px;margin:32px auto;padding:32px;background:#ffffff;border:1px solid #e2e8f0;border-radius:12px">
        <p style="margin:0 0 8px;color:#0284c7;font-size:13px;font-weight:700;letter-spacing:.08em;text-transform:uppercase">LacakKerja</p>
        <h1 style="margin:0 0 16px;font-size:24px"><?php echo e($title); ?></h1>
        <p style="white-space:pre-line"><?php echo e($body); ?></p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($route): ?><p style="margin-top:24px"><a href="<?php echo e($route); ?>" style="display:inline-block;padding:12px 18px;border-radius:8px;background:#0284c7;color:#ffffff;text-decoration:none;font-weight:700">Buka di LacakKerja</a></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </main>
</body>
</html><?php /**PATH D:\Documents\ChatGPT\deks\LacakKerja\apps\resources\views\emails\notification.blade.php ENDPATH**/ ?>