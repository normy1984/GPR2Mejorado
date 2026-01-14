<?php if (Auth::check() && Auth::user()->can('index.project_tracking.execution')): ?>

<div>
    <div class="page-title">
        <div class="col-md-11 col-sm-11 col-xs-11">
            <h3><?php echo e(trans('projects.title'), false); ?>

                <small><?php echo e(trans('app.labels.tracking'), false); ?></small>
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <i class="fa fa-product-hunt"></i> <?php echo e(trans('projects.title'), false); ?>

                    </h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-striped" id="projects_tb">
                        <thead>
                        <tr>
                            <th></th>
                            <th><?php echo e(trans('projects.labels.code'), false); ?> <i role="button" data-toggle="tooltip" data-placement="top"
                                                                       data-original-title="<?php echo e(trans('projects.labels.cup_tooltip'), false); ?>"
                                                                       class="fa fa-info-circle blue"></i>
                            </th>
                            <th><?php echo e(trans('app.headers.name'), false); ?></th>
                            <th><?php echo e(trans('projects.labels.responsibleUnit'), false); ?></th>
                            <th><?php echo e(trans('app.headers.date_init'), false); ?></th>
                            <th><?php echo e(trans('app.headers.date_end'), false); ?></th>
                            <th><?php echo e(trans('projects.labels.annual_budget'), false); ?></th>
                            <th><?php echo e(trans('projects.labels.state'), false); ?></th>
                            <th><?php echo e(trans('projects.labels.actions'), false); ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(() => {
        let $table = $('#projects_tb');
        build_datatable($table, {
            ajax: '<?php echo route('data.index.project_tracking.execution'); ?>',
            columns: [
                {data: 'id', visible: false, sortable: false, searchable: false, width: '0'},
                {data: 'full_cup', name: 'projects.full_cup', class: 'text-center', width: '10%', searchable: true},
                {data: 'name', name: 'projects.name', width: '15%', searchable: true},
                {data: 'responsibleUnit', name: 'departments.name', width: '15%', class: 'text-center', searchable: true},
                {data: 'date_init', name: 'projects.date_init', width: '10%', class: 'text-center', searchable: true},
                {data: 'date_end', name: 'projects.date_end', width: '10%', class: 'text-center', searchable: true},
                {data: 'referential_budget', width: '10%', class: 'text-center', searchable: false},
                {data: 'status', width: '10%', class: 'text-center', searchable: false},
                {data: 'actions', width: '15%', sortable: false, searchable: false, class: 'text-center'}
            ]
        });
    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/tracking/projects/index.blade.php ENDPATH**/ ?>