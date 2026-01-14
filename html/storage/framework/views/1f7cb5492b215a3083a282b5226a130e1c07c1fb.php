<?php if (Auth::check() && Auth::user()->can('showplanlinks.plan.link.links.plans.plans_management')): ?>
<?php $Plan = app('\App\Models\Business\Plan'); ?>
<div class="page-title">
    <div class="title_left">
        <h3><?php echo e(trans('links.title'), false); ?>

            <small><?php echo e(trans('app.labels.administration'), false); ?></small>
        </h3>
    </div>

    <div class="title_right hidden-xs">
        <ol class="breadcrumb pull-right">

            <?php if (Auth::check() && Auth::user()->can('index.plans.plans_management')): ?>
            <li>
                <a href="<?php echo e(route('plan.link.links.plans.plans_management', ['id' => $plan->id]), false); ?>" class="ajaxify"> <?php echo e(trans('links.title'), false); ?></a>
            </li>
            <?php endif; ?>

            <li class="active"> <?php echo e(trans('app.labels.details'), false); ?></li>
        </ol>
    </div>
</div>

<div class="clearfix"></div>

<ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
    <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="nav-item">
            <a id="tab_<?php echo e($index, false); ?>" class="nav-link" role="tab" data-toggle="tab" href="#panel_<?php echo e($index, false); ?>" aria-controls="panel_<?php echo e($index, false); ?>">
                <?php echo e(\Illuminate\Support\Str::limit($plan->name, 15, '...'), false); ?>

                <i class="fa fa-arrow-right"></i>
                <?php echo e(\Illuminate\Support\Str::limit($tab['linkedPlan']->name, 15, '...'), false); ?>

            </a>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<div class="tab-content">
    <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="x_content tab-pane mb-15" role="tabpanel" id="panel_<?php echo e($index, false); ?>">
            <table class="table report-table">
                <thead>
                <tr>
                    <th class="planLinkColor" align="center" colspan="<?php if(!in_array($plan->type, [$Plan::TYPE_PEI, $Plan::TYPE_SECTORAL])): ?> 4 <?php else: ?> 3 <?php endif; ?>"><b><?php echo e($plan->name, false); ?></b></th>
                    <th class="linkedPlanColor" align="center" colspan="<?php if(!in_array($tab['linkedPlan']->type, [$Plan::TYPE_PEI, $Plan::TYPE_SECTORAL, $Plan::TYPE_ODS])): ?> 4 <?php else: ?> 3 <?php endif; ?>"><b><?php echo e($tab['linkedPlan']->name, false); ?></b></th>
                </tr>
                <tr>
                    <th class="planLinkColor" align="center"><b><?php echo e(trans('links.labels.vision'), false); ?></b></th>
                    <?php if(!in_array($plan->type, [$Plan::TYPE_PEI, $Plan::TYPE_SECTORAL])): ?>
                        <th class="planLinkColor" align="center"><b><?php echo e(trans('links.labels.thrust'), false); ?></b></th>
                    <?php endif; ?>
                    <th class="planLinkColor" align="center"><b><?php echo e(trans('links.labels.objective'), false); ?></b></th>
                    <th class="planLinkColor" align="center"><b><?php echo e(trans('links.labels.goal'), false); ?></b></th>

                    <th class="linkedPlanColor" align="center"><b><?php echo e(trans('links.labels.goal'), false); ?></b></th>
                    <th class="linkedPlanColor" align="center"><b><?php echo e(trans('links.labels.objective'), false); ?></b></th>
                    <?php if(!in_array($tab['linkedPlan']->type, [$Plan::TYPE_PEI, $Plan::TYPE_SECTORAL, $Plan::TYPE_ODS])): ?>
                        <th class="linkedPlanColor" align="center"><b><?php echo e(trans('links.labels.thrust'), false); ?></b></th>
                    <?php endif; ?>
                    <th class="linkedPlanColor" align="center"><b><?php echo e(trans('links.labels.vision'), false); ?></b></th>
                </tr>
                </thead>
                <tbody>
                <?php if($tab['rows']->count()): ?>
                    <?php $__currentLoopData = $tab['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <?php $__currentLoopData = $row; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td width="12.5%" rowspan="<?php echo e($column['rowspan'], false); ?>"><?php echo $column['text']; ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td width="100%" align="center" colspan="8"> <?php echo e(trans('links.messages.info.noLinks'), false); ?> </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<footer class="navbar-default navbar-fixed-bottom text-center">
    <a id="cancelLinks" href="<?php echo e(route('plan.link.links.plans.plans_management', [ 'id' => $plan->id ]), false); ?>"
       class="btn btn-info ajaxify"><?php echo e(trans('app.labels.backward'), false); ?>

    </a>
</footer>

<script>
    $(() => {
        $('#tab_0').tab('show')
    })
</script>

<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/planning/link/show_plan_links.blade.php ENDPATH**/ ?>