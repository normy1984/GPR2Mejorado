<?php if (Auth::check() && Auth::user()->can('index.projects.plans_management')): ?>

<div>
    <div class="page-title">
        <div class="col-md-11 col-sm-11 col-xs-11">
            <h3><?php echo e(trans('projects.title'), false); ?>

                <small><?php echo e(trans('app.labels.planning'), false); ?></small>
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

                        <span><?php echo e($year, false); ?></span>
                    </h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row mb-2">
                        <div class="form-group col-md-2 col-xs-12">
                            <label class="control-label" for="responsible_unit_id">
                                <?php echo e(trans('admin_activities.labels.responsible_unit'), false); ?>

                            </label>
                            <select class="form-control select2" id="responsible_unit_id">
                                <option value=""><?php echo e(trans('app.labels.all'), false); ?></option>
                                <?php $__currentLoopData = $responsibleUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($unit->id, false); ?>"><?php echo e($unit->name, false); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
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
        let dataTable = build_datatable($table, {
            ajax: {
                url: '<?php echo route('data.index.projects.plans_management'); ?>',
                "data": (d) => {
                    return $.extend({}, d, {
                        "unitId": $('#responsible_unit_id').val()
                    });
                }
            },
            columns: [
                {data: 'id', visible: false, sortable: false, searchable: false, width: '0'},
                {data: 'full_cup', name: 'project.full_cup', width: '10%', class: 'text-center', searchable: true},
                {data: 'name', name: 'projects.name', width: '15%', searchable: true},
                {data: 'responsibleUnit', name: 'project.responsibleUnit.name', width: '15%', class: 'text-center', searchable: true},
                {data: 'date_init', name: 'projects.date_init', width: '10%', class: 'text-center', searchable: false},
                {data: 'date_end', name: 'projects.date_end', width: '10%', class: 'text-center', searchable: false},
                {data: 'referential_budget', name: 'project_fiscal_years.referential_budget', width: '10%', class: 'text-center', searchable: false},
                {data: 'status', width: '10%', class: 'text-center', searchable: false},
                {data: 'actions', width: '20%', sortable: false, searchable: false, class: 'text-center'}
            ]
        });

        $("#responsible_unit_id").on('change', () => {
            dataTable.draw();
        });
    });
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/planning/projects/index.blade.php ENDPATH**/ ?>