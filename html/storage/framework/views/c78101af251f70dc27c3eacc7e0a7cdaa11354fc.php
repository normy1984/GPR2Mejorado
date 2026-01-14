<?php if (Auth::check() && Auth::user()->can('project_dashboard.control_panel')): ?>
<!-- Nav tabs -->
<ul class="md nav nav-tabs" role="tablist" style="display: inline-block" id="my-tabs">
    <?php if(api_available()): ?>
        <li role="presentation" class="active">
            <a href="#table" aria-controls="table" role="tab" data-toggle="tab"><?php echo e(trans('dashboard.budget.title'), false); ?></a>
        </li>
        <li role="presentation">
            <a href="#projects" aria-controls="projects" role="tab" data-toggle="tab"><?php echo e(trans('dashboard.project.title'), false); ?></a>
        </li>
    <?php endif; ?>
    <li role="presentation" <?php if(!api_available()): ?> class="active" <?php endif; ?>>
        <a href="#administrative" aria-controls="administrative" role="tab" data-toggle="tab"><?php echo e(trans('dashboard.admin.title'), false); ?></a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <?php if(api_available()): ?>
        <div role="tabpanel" class="tab-pane active" id="table">
            <?php echo $__env->make('dashboard.planning.components.budget.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="projects">
            <?php echo $__env->make('dashboard.planning.components.projects.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    <?php endif; ?>
    <div role="tabpanel" class="tab-pane <?php if(!api_available()): ?> active <?php endif; ?>" id="administrative">
        <?php echo $__env->make('dashboard.planning.components.administrative.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<?php else: ?>
    <?php echo $__env->make('default_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php /**PATH /var/www/html/resources/views/dashboard/planning/index.blade.php ENDPATH**/ ?>