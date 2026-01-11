<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'PolCaBot'); ?></title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/common.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="light-mode">
    <?php echo $__env->yieldContent('content'); ?>
    
    <!-- Scripts -->
    <script src="<?php echo e(asset('js/navigation.js')); ?>"></script>
    <script src="<?php echo e(asset('js/darkmode.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\Polcabot-9\resources\views/layouts/app.blade.php ENDPATH**/ ?>