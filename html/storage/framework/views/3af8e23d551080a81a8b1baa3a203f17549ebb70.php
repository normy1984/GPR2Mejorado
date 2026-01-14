<?php if (Auth::check() && Auth::user()->can('index.budget_adjustment.budget.plans_management')): ?>
<?php echo $__env->make('business.planning.partials.justification.form', ['action' => trans('justifications.actions.approve'), 'form' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $BudgetItem = app('\App\Models\Business\BudgetItem'); ?>
<div>
    <div class="page-title">
        <div class="col-md-11 col-sm-11 col-xs-11">
            <h3><?php echo e(trans('budget_adjustment.title'), false); ?>

                <small><?php echo e(trans('app.labels.budget'), false); ?></small>
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row tile_count col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-5ths col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-usd"></i> <?php echo e(trans('budget_adjustment.labels.start_value'), false); ?></span>
            <div id="icome" class="count adjustment-balance"><?php echo e($starValue, false); ?></div>
        </div>
        <div class="col-md-5ths col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-usd"></i> <?php echo e(trans('budget_adjustment.labels.total_spends'), false); ?></span>
            <div id="total_spends" class="count adjustment-balance"><?php echo e($totalSpends, false); ?></div>
        </div>
        <div class="col-md-5ths col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-usd"></i> <?php echo e(trans('budget_adjustment.labels.balance'), false); ?></span>
            <div id="balance" class="count text-danger adjustment-balance"><?php echo e($balance, false); ?></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">

                    <div class="row">
                        <h2>
                            <i class="fa fa-database"></i> <?php echo e(trans('budget_adjustment.labels.projects'), false); ?>

                            <span><?php echo e($year, false); ?></span>
                        </h2>
                    </div>
                    <table class="table table-striped" id="projects_tb">
                        <thead>
                        <tr>
                            <th></th>
                            <th>
                                <?php if(isset($approved) && !$approved): ?>
                                    <i role="button" data-toggle="tooltip" data-placement="top"
                                       data-original-title="<?php echo e(trans('budget_adjustment.labels.bulk_actions_tooltip'), false); ?>"
                                       class="fa fa-info-circle blue"></i>
                                    <input type="checkbox" id="checkbox" class="bulk check-all"
                                           title="<?php echo e(trans('app.labels.select_all'), false); ?>"/>
                                <?php endif; ?>
                            </th>
                            <th><?php echo e(trans('app.headers.name'), false); ?></th>
                            <th><?php echo e(trans('projects.labels.annual_budget'), false); ?></th>
                            <th><?php echo e(trans('projects.labels.budget_value'), false); ?></th>
                            <th><?php echo e(trans('app.labels.actions'), false); ?></th>
                        </tr>
                        </thead>
                    </table>

                    <div class="form-group col-md-offset-3 col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label" for="terms_conditions">
                            <?php echo e(trans('budget_adjustment.labels.terms'), false); ?>

                        </label>
                        <div style="border: 1px solid #e5e5e5; height: 200px; overflow: auto; padding: 10px;">
                            <p><?php echo e(trans('budget_adjustment.labels.terms_conditions'), false); ?></p>
                            <p><?php echo e(trans('budget_adjustment.labels.terms_conditions_2'), false); ?></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-6 col-xs-offset-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="agree"/> <?php echo e(trans('budget_adjustment.labels.agree'), false); ?>

                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 text-center mt-1">
        <?php if(!$approved): ?>
            <button id="save_btn" name="indicatorSubmit" data-confirm="true" class="btn btn-warning">
                <i class="fa fa-check"></i> <?php echo e(trans('app.labels.save'), false); ?>

            </button>

            <button id="approve_btn" data-confirm="true" type="submit" class="btn btn-success">
                <i class="fa fa-check"></i> <?php echo e(trans('app.labels.approve'), false); ?>

            </button>

            <button id="after_proforma_review_btn" data-confirm="true" type="submit" class="btn btn-primary">
                <i class="glyphicon glyphicon-eye-open"></i> <?php echo e(trans('proforma.labels.preview_proforma'), false); ?>

            </button>
        <?php else: ?>
            <?php if(isset($synched) && !$synched && api_available()): ?>
                <a id="syncProformaBtn" href="<?php echo e(route('sync_proforma.budget_adjustment.budget.plans_management'), false); ?>" class="btn btn-primary ajaxify">
                    <i class="glyphicon glyphicon-refresh"></i> <?php echo e(trans('budget_adjustment.labels.sync_proforma'), false); ?>

                </a>
            <?php endif; ?>

            <a id="proformaPreviewBtn" href="<?php echo e(route('preview_proforma.budget_adjustment.budget.plans_management'), false); ?>" class="btn btn-primary ajaxify">
                <i class="glyphicon glyphicon-eye-open"></i> <?php echo e(trans('proforma.labels.preview_proforma'), false); ?>

            </a>
        <?php endif; ?>

    </div>
</div>

<script>
    $(() => {
        let $table = $('#projects_tb');

        let income = parseFloat(parseFloat('<?php echo e($starValue, false); ?>'.replace(/,/g, '')).toFixed(2));
        let totalSpend = parseFloat(parseFloat('<?php echo e($totalSpends, false); ?>'.replace(/,/g, '')).toFixed(2));
        let balance = -1;

        build_datatable($table, {
            dom: '<f<t>r>',
            paging: false,
            ajax: '<?php echo route('data.index.budget_adjustment.budget.plans_management'); ?>',
            columns: [
                {data: 'id', visible: false, sortable: false, searchable: false, width: '0'},
                {data: 'bulk_action', width: '5%', sortable: false, searchable: false, class: 'text-center'},
                {data: 'name', width: '30%', sortable: true, searchable: true},
                {data: 'referential_budget', width: '25%', class: 'text-center'},
                {data: 'value_budget', width: '25%', class: 'text-center'},
                {data: 'actions', width: '5%', sortable: false, searchable: false}
            ],
            fnRowCallback: (nRow, aData) => {
                $(nRow).find('input.bulk').on('ifChecked', (e) => {
                    let valueBudget = parseFloat(parseFloat(aData.value_budget.replace(/,/g, '')).toFixed(2));

                    totalSpend = parseFloat(totalSpend.toFixed(2)) + parseFloat(valueBudget.toFixed(2));

                    $('#total_spends').text(totalSpend).number(true, 2);

                    let balance = parseFloat(income.toFixed(2)) - parseFloat(totalSpend.toFixed(2));

                    $('#balance').text(balance).number(true, 2);

                    if (balance < 0) {
                        $('#balance').text(`-${$('#balance').text()}`)
                    }
                });

                $(nRow).find('input.bulk').on('ifUnchecked', (e) => {
                    let valueBudget = parseFloat(parseFloat(aData.value_budget.replace(/,/g, '')).toFixed(2));

                    totalSpend = parseFloat(totalSpend.toFixed(2)) - parseFloat(valueBudget.toFixed(2));

                    $('#total_spends').text(totalSpend).number(true, 2);

                    balance = parseFloat(income.toFixed(2)) - parseFloat(totalSpend.toFixed(2));
                    $('#balance').text(balance).number(true, 2);

                    if (balance < 0) {
                        $('#balance').text(`-${$('#balance').text()}`)
                    }
                });
            }
        });

        $('#save_btn').on('click', (e) => {
            e.preventDefault();

            let action = $(e.currentTarget);
            let confirm = action.attr('data-confirm');
            if (confirm) {

                let checked = $table.find("input[name='table_records']:checked");
                let ids = [];
                checked.each((index, element) => {
                    let id = $(element).closest('tr').attr('id');
                    ids.push(id);
                });

                if (ids.length > 0) {
                    $('#checkbox').prop("checked", false);
                    confirmModal("<?php echo e(trans('budget_adjustment.messages.confirm.save'), false); ?>", () => {
                        pushRequest('<?php echo route('edit.budget_adjustment.budget.plans_management'); ?>', null, null, 'put', {
                            _token: '<?php echo e(csrf_token(), false); ?>',
                            ids: ids,
                            balance: balance
                        });
                    });
                } else {
                    notify('<?php echo e(trans('budget_adjustment.messages.info.not_empty'), false); ?>', 'warning', '<?php echo e(trans('app.labels.warning'), false); ?>');
                }
            }
        });

        $('#approve_btn').on('click', (e) => {
            e.preventDefault();
            let action = $(e.currentTarget);
            let confirm = action.attr('data-confirm');
            if (confirm) {

                let checked = $table.find("input[name='table_records']:checked");
                let ids = [];
                checked.each((index, element) => {
                    let id = $(element).closest('tr').attr('id');
                    ids.push(id);
                });

                if ($('#agree').prop('checked')) {
                    if (ids.length > 0) {
                        balance = parseFloat(income.toFixed(2)) - parseFloat(totalSpend.toFixed(2));
                        if (balance == 0) {
                            $('#checkbox').prop("checked", false);

                            let callback = (data = null, options = null) => {
                                pushRequest('<?php echo route('approve.budget_adjustment.budget.plans_management'); ?>', null, null, 'POST', data, false, options);
                            };

                            justificationModal(callback, {
                                _token: '<?php echo e(csrf_token(), false); ?>',
                                ids: ids,
                                balance: balance
                            }, '<?php echo e(trans('budget_adjustment.messages.confirm.approve'), false); ?>');
                        } else {
                            notify('<?php echo e(trans('budget_adjustment.messages.exceptions.balance_not_cero'), false); ?>', 'warning', '<?php echo e(trans('app.labels.warning'), false); ?>');
                        }
                    } else {
                        notify('<?php echo e(trans('budget_adjustment.messages.info.not_empty'), false); ?>', 'warning', '<?php echo e(trans('app.labels.warning'), false); ?>');
                    }
                } else {
                    notify('<?php echo e(trans('budget_adjustment.messages.info.terms'), false); ?>', 'warning', '<?php echo e(trans('app.labels.warning'), false); ?>');
                }
            }
        });

        $('#after_proforma_review_btn').on('click', (e) => {
            e.preventDefault();
            let action = $(e.currentTarget);
            let confirm = action.attr('data-confirm');
            if (confirm) {
                let checked = $table.find("input[name='table_records']:checked");
                let ids = [];
                checked.each((index, element) => {
                    let id = $(element).closest('tr').attr('id');
                    ids.push(id);
                });
                if (ids.length > 0) {
                    balance = parseFloat(income.toFixed(2)) - parseFloat(totalSpend.toFixed(2));
                    if (balance == 0) {
                        $('#checkbox').prop("checked", false);
                        pushRequest('<?php echo e(route('after_preview_proforma.budget_adjustment.budget.plans_management'), false); ?>', null, null, 'GET', null);
                    } else {
                        notify('<?php echo e(trans('budget_adjustment.messages.exceptions.preview_balance_not_cero'), false); ?>', 'warning', '<?php echo e(trans('app.labels.warning'), false); ?>');
                    }
                } else {
                    notify('<?php echo e(trans('budget_adjustment.messages.info.not_empty'), false); ?>', 'warning', '<?php echo e(trans('app.labels.warning'), false); ?>');
                }
            }
        });
    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/planning/budget_adjustment/index.blade.php ENDPATH**/ ?>