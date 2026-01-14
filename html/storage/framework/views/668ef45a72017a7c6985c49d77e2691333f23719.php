<?php use App\Models\Business\Planning\Income; ?>
<?php if (Auth::check() && Auth::user()->can('index.income.budget.plans_management|index.income.programmatic_structure.execution')): ?>

<div>
    <div class="page-title">
        <div class="col-md-11 col-sm-11 col-xs-11">
            <?php if($module === Income::MODULE['BUDGET']): ?>
                <h3><?php echo e(trans('income.title'), false); ?></h3>
            <?php elseif($module === Income::MODULE['PROGRAMMATIC_STRUCTURE']): ?>
                <h3><?php echo e(trans('income.title_structure'), false); ?></h3>
            <?php endif; ?>
        </div>
    </div>
    <div class="clearfix"></div>

    <?php if($module === Income::MODULE['BUDGET']): ?>
        <div class="row tile_count col-md-12 col-sm-12 col-xs-12" id="budget_summary">
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <i class="fa fa-dollar"></i> <?php echo e(trans('income.title') . ' - ' . trans('income.labels.fiscalYear') . ': ' . $fiscal_year, false); ?>

                    </h2>
                    <div class="text-right pull-right d-flex">

                        <a href="<?php echo e(route('import.index.income.budget.plans_management'), false); ?>" class="btn btn-default ajaxify">
                            <i class="fa fa-cloud-upload"></i> <?php echo e(trans('income.labels.import'), false); ?></a>

                        <a href="<?php echo e(route('download.index.income.budget.plans_management'), false); ?>" class="btn btn-default">
                            <i class="fa fa-cloud-download"></i> <?php echo e(trans('income.labels.download'), false); ?></a>

                        <?php if(isset($replicate) && $replicate): ?>
                            <a href="<?php echo e(route('replicate.index.income.budget.plans_management'), false); ?>" class="btn btn-default ajaxify"><?php echo e(trans('income.labels.replicate'), false); ?></a>
                        <?php endif; ?>

                        <?php if (Auth::check() && Auth::user()->can('create.income.budget.plans_management|create.income.programmatic_structure.execution')): ?>
                        <a href="<?php echo e($routes['create'], false); ?>" class="btn btn-success ajaxify">
                            <i class="fa fa-plus"></i> <?php echo e(trans('income.labels.create'), false); ?>

                        </a>
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
                    <table class="table table-striped text-center" id="incomes_tb">
                        <thead>
                        <tr>
                            <th></th>
                            <th><?php echo e(trans('income.labels.code'), false); ?>

                                <i role="button" data-toggle="tooltip" data-placement="top"
                                   data-original-title="<?php echo e(trans('income.labels.codeTooltip'), false); ?>"
                                   class="fa fa-info-circle blue"></i>
                            </th>
                            <th><?php echo e(trans('budget_classifiers.labels.title'), false); ?></th>
                            <th><?php echo e(trans('budget_classifiers.title'), false); ?></th>
                            <th><?php echo e(trans('income.labels.financingSource'), false); ?></th>
                            <th><?php echo e(trans('income.labels.distributor_name'), false); ?></th>
                            <th><?php echo e(trans('income.labels.institution'), false); ?></th>
                            <th><?php echo e(trans('income.labels.value'), false); ?></th>
                            <th><?php echo e(trans('app.labels.actions'), false); ?></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr id="tfoot-tr-1">
                            <th class="text-right" colspan="7"><?php echo e(trans('income.labels.subtotal'), false); ?></th>
                            <th class="text-center" id="tfoot-th-subtotal"></th>
                            <th></th>
                        </tr>
                        <tr id="tfoot-tr-2">
                            <th class="text-right" colspan="7"><?php echo e(trans('income.labels.total'), false); ?></th>
                            <th class="text-center" id="tfoot-th-total"></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(() => {
        let $table = $('#incomes_tb');
        build_datatable($table, {
            ajax: {
                url: '<?php echo $routes['data']; ?>',
                "dataSrc": (response) => {
                    if (response.exception !== '') {
                        notify(response.exception, 'warning')
                    }
                    return response.data;
                }
            },
            columns: [
                {data: 'id', visible: false, sortable: false, searchable: false, width: '0'},
                {data: 'code', width: '15%', sortable: false, searchable: true, class: 'text-center'},
                {data: 'name', width: '20%', sortable: false, searchable: true, class: 'text-justify'},
                {data: 'budget_classifier', width: '10%', sortable: false, searchable: true},
                {data: 'financing_source', width: '5%', sortable: false, searchable: true, class: 'text-center'},
                {data: 'distributor_name', width: '15%', sortable: false, searchable: true, class: 'text-center'},
                {data: 'institution', width: '15%', sortable: false, searchable: true},
                {data: 'value', width: '10%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'actions', width: '20%', sortable: false, searchable: false, class: 'text-center'}
            ],
            footerCallback: function () {
                let api = this.api(), json = api.ajax.json();

                // Remove the formatting to get integer data for summation
                let intVal = (i) => {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over this page
                let pageTotal = api
                    .column(7, {page: 'current'})
                    .data()
                    .reduce((a, b) => {
                        return parseFloat(intVal(a)) + parseFloat(intVal(b));
                    }, 0);

                // Update footer
                $('#tfoot-tr-1 #tfoot-th-subtotal').text(
                    pageTotal
                ).number(true, 2).text(`$ ${$('#tfoot-tr-1 #tfoot-th-subtotal').text()}`);

                $('#tfoot-tr-2 #tfoot-th-total').html(
                    '$ ' + (json.totalIncome !== undefined ? json.totalIncome : 0.00)
                );
                <?php if($module === Income::MODULE['BUDGET']): ?>
                pushRequest('<?php echo e(route('load_budget_summary.income.budget.plans_management'), false); ?>', '#budget_summary', null, 'GET', {}, false)
                <?php endif; ?>
            }
        });
    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/planning/income/index.blade.php ENDPATH**/ ?>