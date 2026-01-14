<?php if (Auth::check() && Auth::user()->can('load_budget_summary.current_expenditure_elements.budget.plans_management|load_budget_summary.income.budget.plans_management')): ?>
    <div class="col-md-5ths col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-usd"></i> <?php echo e(trans('budget_adjustment.labels.start_value'), false); ?></span>
        <div id="icome" class="count adjustment-balance"><?php echo e($starValue, false); ?></div>
    </div>
    <div class="col-md-5ths col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top">
            <i class="fa fa-usd"></i> <?php echo e(trans('budget_adjustment.labels.total_spends'), false); ?>

        </span>
        <div id="total_spends" class="count adjustment-balance"><?php echo e($totalSpends, false); ?></div>
    </div>
    <div class="col-md-5ths col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top">
            <i class="fa fa-usd"></i> <?php echo e(trans('budget_adjustment.labels.balance'), false); ?>

        </span>
        <div id="balance" class="count text-danger adjustment-balance"><?php echo e($balance, false); ?></div>
    </div>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?><?php /**PATH /var/www/html/resources/views/business/planning/budget_adjustment/load_budget_summary.blade.php ENDPATH**/ ?>