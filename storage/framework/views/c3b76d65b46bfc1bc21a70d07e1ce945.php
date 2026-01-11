<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/landing.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="landing-page" id="landingPage">
    <!-- Navbar -->
    <nav>
        <div class="logo">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="PolCaBot Logo">
            <span>
                <span style="color:white;">P</span><span style="color:orange;">o</span><span style="color:white;">l</span><span style="color:#1e90ff;">CaBot</span>
            </span>
        </div>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        
        <!-- Tombol Sign In (tampil kalau BELUM login) -->
        <?php if(auth()->guard()->guest()): ?>
            <a href="<?php echo e(route('login')); ?>" class="btn-signin">Sign In</a>
        <?php endif; ?>

        <!-- Tombol Logout (tampil kalau SUDAH login) -->
        <?php if(auth()->guard()->check()): ?>
            <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-signin" style="background: #dc3545; border: none; cursor: pointer;">Logout</button>
            </form>
        <?php endif; ?>
    </nav>

    <?php echo $__env->yieldContent('landing-content'); ?>

    <footer>
        <p>© 2025 PolCaBot. All rights reserved.</p>
        <ul>
            <li><a href="#">UI Design</a></li>
            <li><a href="#">UX Design</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Best Practices</a></li>
        </ul>
    </footer>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Polcabot-9\resources\views/layouts/landing.blade.php ENDPATH**/ ?>