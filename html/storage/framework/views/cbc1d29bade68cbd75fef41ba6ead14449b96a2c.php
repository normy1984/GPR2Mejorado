<?php if (Auth::check() && Auth::user()->can('index.current_expenditure_elements.budget.plans_management')): ?>

<div>
    <div class="page-title">
        <div class="col-md-11 col-sm-11 col-xs-11">
            <h3><?php echo e(trans('current_expenditure.title'), false); ?>

                <small><?php echo e(trans('app.labels.budget'), false); ?></small>
            </h3>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12 sidebar" id="sidebar-left">

            <div class="row tile_count col-md-12 col-sm-12 col-xs-12" id="budget_summary">

            </div>

            <div class="x_panel well-lg">
                <div class="x_title">
                    <h2>
                        <i class="fa fa-cart-arrow-down"></i> <?php echo e(trans('current_expenditure.title') . ' - ' . trans('current_expenditure.labels.fiscal_year', ['fiscalYear' => $fiscalYear]), false); ?>

                    </h2>
                    <div class="text-right pull-right d-flex">

                        <a href="<?php echo e(route('load.import.current_expenditure_elements.budget.plans_management'), false); ?>" class="btn btn-info ajaxify">
                            <i class="fa fa-cloud-upload"></i> <?php echo e(trans('current_expenditure.labels.import'), false); ?></a>

                        <a href="<?php echo e(route('download.current_expenditure_elements.budget.plans_management'), false); ?>" class="btn btn-info">
                            <i class="fa fa-cloud-download"></i> <?php echo e(trans('current_expenditure.labels.download'), false); ?></a>

                        <?php if(isset($replicate) && $replicate): ?>
                            <a href="<?php echo e(route('replicate.current_expenditure_elements.budget.plans_management'), false); ?>"
                               class="btn btn-sm btn-warning ajaxify">
                                <i class="fa fa-copy"></i><?php echo e(trans('current_expenditure.labels.replicate'), false); ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php if(isset($failures) && $failures->isNotEmpty()): ?>
                        <table class="table table-error">
                            <tr class="bg-red-300 text-white fw-b">
                                <td><?php echo e(trans('income.labels.row'), false); ?></td>
                                <td><?php echo e(trans('income.labels.column'), false); ?></td>
                                <td><?php echo e(trans('income.labels.errors'), false); ?></td>
                            </tr>
                            <?php $__currentLoopData = $failures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="bg-red-300 text-white">
                                    <td><?php echo e($fail->row(), false); ?></td>
                                    <td><?php echo e($fail->attribute(), false); ?></td>
                                    <td>
                                        <ul>
                                            <?php $__currentLoopData = $fail->errors(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <?php echo e($e, false); ?>

                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>
                    <?php endif; ?>
                    <div id="load-tree" class="col-lg-5 col-md-5 col-sm-5 col-xs-10 mt-3 pl-0"></div>
                    <div id="load-area" class="col-lg-7 col-md-7 col-sm-7 col-xs-10 mt-3 p-0"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 sidebar collapsed hidden" id="sidebar-right">
            <div id="budget-items-area" class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
            <div id="budget-planning-area" class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
        </div>
    </div>

</div>

<script>
    $(() => {
        // Load tree structure
        const url = '<?php echo route('loadstructure.current_expenditure_elements.budget.plans_management'); ?>'
        pushRequest(url, '#load-tree', null, 'GET', {'_token': '<?php echo csrf_token(); ?>'});

        pushRequest('<?php echo e(route('load_budget_summary.current_expenditure_elements.budget.plans_management'), false); ?>', '#budget_summary', null, 'GET', {}, false)
    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/planning/current_expenditure/index.blade.php ENDPATH**/ ?>