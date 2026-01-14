<div class="nav_menu hidden-print">
    <?php if(!currentUser()->hasRole('developer')): ?>
        <div class="row text-center position-relative">
            <h1 class="top_nav_title"><?php echo session()->get('module')->name; ?></h1>
        </div>
    <?php endif; ?>

    <nav class="position-relative position-relative" role="navigation">
        <div class="nav toggle">
            <a id="menu_toggle">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <?php echo $__env->make('layout.partial.profile_button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if(!currentUser()->hasRole('developer')): ?>
                <?php echo $__env->make('layout.partial.modules_button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </ul>
    </nav>
</div><?php /**PATH /var/www/html/resources/views/layout/top_nav.blade.php ENDPATH**/ ?>