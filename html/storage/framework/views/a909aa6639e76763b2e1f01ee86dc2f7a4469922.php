<div class="row mt-3">
    <?php echo $__env->make('dashboard.planning.components.administrative.chart_1', ['url' => route('chart_1.administrative.dashboard.control_panel')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('dashboard.planning.components.administrative.chart_2', ['url' => route('chart_2.administrative.dashboard.control_panel')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<div class="row mt-3">
    <?php echo $__env->make('dashboard.planning.components.administrative.chart_3', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>


<?php /**PATH /var/www/html/resources/views/dashboard/planning/components/administrative/index.blade.php ENDPATH**/ ?>