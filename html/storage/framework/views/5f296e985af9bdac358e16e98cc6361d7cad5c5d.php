<div class="col-md-2 br-1">
    <h4>Asignado Inicial</h4>
    <span class="fs-m"><i class="fa fa-dollar text-success"></i> <?php echo e(number_format($assigned, 2), false); ?></span>
</div>
<div class="col-md-2 br-1">
    <h4>Reformas</h4>
    <span class="fs-m"><i class="fa fa-dollar text-success"></i> <?php echo e(number_format($reform, 2), false); ?></span>
</div>
<div class="col-md-2 br-1">
    <h4>Codificado</h4>
    <span class="fs-m"><i class="fa fa-dollar text-success"></i> <?php echo e(number_format($encoded, 2), false); ?></span>
</div>
<div class="col-md-2 br-1">
    <h4>Por Comprometer</h4>
    <span class="fs-m"><i class="fa fa-dollar text-success"></i> <?php echo e(number_format($porComprometer, 2), false); ?></span><br>
</div>
<div class="col-md-2 br-1">
    <h4>Por Devengar</h4>
    <span class="fs-m"><i class="fa fa-dollar text-success"></i> <?php echo e(number_format($porDevengar, 2), false); ?></span><br>
</div>
<div class="col-md-2">
    <h4>Devengado</h4>
    <span class="fs-m"><i class="fa fa-dollar text-success"></i> <?php echo e(number_format($accrued, 2), false); ?></span><br>
    <span class="text-danger"><?php echo e(number_format($percent, 2), false); ?>%</span>
</div>
<?php /**PATH /var/www/html/resources/views/dashboard/planning/components/budget/details.blade.php ENDPATH**/ ?>