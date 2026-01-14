
<div>
    <?php if(!currentUser()->hasRole('developer')): ?>
        <?php if(session()->get('module')->id == \App\Models\System\Module::MODULE_GXR): ?>
            <?php echo $__env->make('dashboard.planning.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif(session()->get('module')->id == \App\Models\System\Module::MODULE_ROADS): ?>
            <?php echo $__env->make('default_dashboard_roads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif(session()->get('module')->id == \App\Models\System\Module::MODULE_CONFIGURATION): ?>
            <?php echo $__env->make('dashboard.configuration.landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif(session()->get('module')->id == \App\Models\System\Module::MODULE_APP): ?>
            <?php echo $__env->make('dashboard.app.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make('default_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
    $(() => {
        hideLoading();
    });
</script>
<?php /**PATH /var/www/html/resources/views/dashboard.blade.php ENDPATH**/ ?>