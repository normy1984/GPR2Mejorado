<?php if (Auth::check() && Auth::user()->can($permission)): ?>

<div id="plan-tree" class="x_panel">
    <div class="x_title">
        <div class="col-md-11 col-sm-11 col-xs-11">
            <h2 class="align-center"><?php echo e(trans('plans.labels.planStructure', ['scope' => trans('plans.labels.'.$scope)]), false); ?></h2>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<script>
    $(() => {

        $('#plan-tree').tree({
            data: '<?php echo $json; ?>',
            selectParents: true
        })
    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/planning/plan/load_structure.blade.php ENDPATH**/ ?>