<div class="row mt-3">
    <div class="col-md-12 text-center" id="detailsProject">
        <div class="col-md-2 br-1">
            <h4>Asignado Inicial</h4>
            <span class="fs-m"><i class="fa fa-dollar text-success"></i> 0.00</span>
        </div>
        <div class="col-md-2 br-1">
            <h4>Reformas</h4>
            <span class="fs-m"><i class="fa fa-dollar text-success"></i> 0.00</span>
        </div>
        <div class="col-md-2 br-1">
            <h4>Codificado</h4>
            <span class="fs-m"><i class="fa fa-dollar text-success"></i> 0.00</span>
        </div>
    </div>
</div>

<div class="row mt-3">
    <?php echo $__env->make('dashboard.planning.components.projects.expenses.chart_3', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<div class="row mt-3">
    <?php echo $__env->make('dashboard.planning.components.projects.expenses.chart_4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<script>

    $(() => {
        $.ajax({
            url: '<?php echo e(route('details.projects.dashboard.control_panel'), false); ?>',
            method: 'GET'
        }).done(function (response) {
            processResponse(response, "#detailsProject");
        })
    })
</script><?php /**PATH /var/www/html/resources/views/dashboard/planning/components/projects/index.blade.php ENDPATH**/ ?>