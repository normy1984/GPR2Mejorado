<div class="row mt-3">
    <div class="col-md-12 text-center" id="detailsBudget">
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
        <div class="col-md-2 br-1">
            <h4>Por Comprometer</h4>
            <span class="fs-m"><i class="fa fa-dollar text-success"></i> 0.00</span><br>
        </div>
        <div class="col-md-2 br-1">
            <h4>Por Devengar</h4>
            <span class="fs-m"><i class="fa fa-dollar text-success"></i> 0.00</span><br>
        </div>
        <div class="col-md-2">
            <h4>Devengado</h4>
            <span class="fs-m"><i class="fa fa-dollar text-success"></i> 0.00</span><br>
            <span class="text-danger">0.00%</span>
        </div>
    </div>
</div>

<div class="row mt-3">
    <?php echo $__env->make('dashboard.planning.components.budget.expenses.chart_3', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<div class="row mt-3">
    <?php echo $__env->make('dashboard.planning.components.budget.incomes.chart_1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('dashboard.planning.components.budget.incomes.chart_2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<div class="row mt-3">
    <?php echo $__env->make('dashboard.planning.components.budget.expenses.chart_1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('dashboard.planning.components.budget.expenses.chart_2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<div class="row mt-3">
    <?php echo $__env->make('dashboard.planning.components.budget.expenses.chart_4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<script>

    $(() => {
        $.ajax({
            url: '<?php echo e(route('details.budget.dashboard.control_panel', ['type' => 1]), false); ?>',
            method: 'GET'
        }).done(function (response) {
            processResponse(response, "#detailsBudget");
        })
    })
</script><?php /**PATH /var/www/html/resources/views/dashboard/planning/components/budget/index.blade.php ENDPATH**/ ?>