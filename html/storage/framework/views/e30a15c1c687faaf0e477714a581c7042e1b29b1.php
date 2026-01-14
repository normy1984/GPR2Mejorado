<?php if (Auth::check() && Auth::user()->can('physical_budgetary_advancement.budget.progress.project_tracking.execution')): ?>

<div>
    <div class="page-title">
        <div class="title_left">
            <h3><?php echo e(trans('projects.title'), false); ?>

                <small><?php echo e(trans('project_tracking.labels.progress'), false); ?></small>
            </h3>
        </div>
    </div>
    <div class="title_right hidden-xs">
        <ol class="breadcrumb pull-right mb-0">
            <?php if (Auth::check() && Auth::user()->can('index.project_tracking.execution')): ?>
            <li>
                <a class="ajaxify" href="<?php echo e(route('index.project_tracking.execution'), false); ?>"> <?php echo e(trans('project_tracking.title'), false); ?></a>
            </li>
            <?php endif; ?>

            <li class="active"> <?php echo e(trans('project_tracking.labels.progress'), false); ?></li>
        </ol>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 p-0">
        <h4><?php echo e(trans('projects.labels.project'), false); ?>:
            <small><?php echo e($project->name, false); ?></small>
        </h4>
    </div>

    <div class="clearfix"></div>

    <div class="title_right hidden-xs">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            <a class="btn btn-xs btn-success ajaxify" id="physical_progress"
                               href="<?php echo e(route('index.physical.progress.project_tracking.execution', ['id' => $projectId]), false); ?>" data-ajaxify="#view_area">
                                <i class="fa fa-line-chart"></i> <?php echo e(trans('project_tracking.labels.physical_progress'), false); ?>

                            </a>
                            <?php if(api_available()): ?>
                                <a class="btn btn-xs btn-primary ajaxify progress-action" id="budget_progress"
                                   href="<?php echo e(route('budget.progress.project_tracking.execution', ['id' => $projectId]), false); ?>" data-ajaxify="#view_area">
                                    <i class="fa fa-bar-chart"></i> <?php echo e(trans('project_tracking.labels.budget_progress'), false); ?>

                                </a>
                                <a class="btn btn-xs btn-primary ajaxify progress-action" id="certifications"
                                   href="<?php echo e(route('index.projects.certifications.execution', ['id' => $projectId]), false); ?>" data-ajaxify="#view_area">
                                    <i class="fa fa-certificate"></i> <?php echo e(trans('project_tracking.labels.certifications'), false); ?>

                                </a>
                            <?php endif; ?>
                        </h2>

                        <ul class="nav navbar-right panel_toolbox">
                            <?php if (Auth::check() && Auth::user()->can('index.project_tracking.execution')): ?>
                            <li class="pull-right">
                                <a href="<?php echo e(route('index.project_tracking.execution'), false); ?>" class="btn btn-box-tool ajaxify">
                                    <i class="fa fa-times"></i>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" id="view_area">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(() => {

        $('#physical_help, #budget_help').hide()

        $('#physical_progress').on('click', (e) => {
            $(e.currentTarget).removeClass('btn-success btn-primary').addClass('btn-success');
            $('#budget_progress').removeClass('btn-success btn-primary').addClass('btn-primary');
            $('#certifications').removeClass('btn-success btn-primary').addClass('btn-primary');
            $('#physical_help').show()
            $('#budget_help').hide()
        });
        $('#budget_progress').on('click', (e) => {
            $(e.currentTarget).removeClass('btn-success btn-primary').addClass('btn-success');
            $('#physical_progress').removeClass('btn-success btn-primary').addClass('btn-primary');
            $('#certifications').removeClass('btn-success btn-primary').addClass('btn-primary');
            $('#budget_help').show()
            $('#physical_help').hide()
        });
        $('#certifications').on('click', (e) => {
            $(e.currentTarget).removeClass('btn-success btn-primary').addClass('btn-success');
            $('#physical_progress').removeClass('btn-success btn-primary').addClass('btn-primary');
            $('#budget_progress').removeClass('btn-success btn-primary').addClass('btn-primary');
            $('#budget_help').hide()
            $('#physical_help').hide()
        });

        $('#physical_progress').click();
    })
</script>

<?php else: ?>
    <?php echo $__env->make('errors.403', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/tracking/projects/progress.blade.php ENDPATH**/ ?>