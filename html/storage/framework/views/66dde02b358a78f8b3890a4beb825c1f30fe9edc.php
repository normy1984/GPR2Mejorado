<?php if (Auth::check() && Auth::user()->can('get_indicator_info.link.links.plans.plans_management')): ?>
<?php $Plan = app('\App\Models\Business\Plan'); ?>

<div class="info_panel_container">
    <div class="x_panel" id="info_panel">
        <div class="mb-3">
            <b><?php echo $route; ?></b>
        </div>

        <div class="mb-3">
            <b><?php echo e(trans('plan_elements.labels.INDICATOR'), false); ?>:</b> <?php echo e($indicator->name, false); ?>

        </div>

        <div class="mb-3">
            <span><?php echo e(trans('links.messages.info.showGoal'), false); ?></span>
            <div class="mt-3 card">
                <div class="card-header">
                    <span role="button" id="goal" class="bg-info col-lg-12 col-md-12 col-sm-12 col-xs-12" data-toggle="collapse" data-target="#goal-description"
                          aria-expanded="true" aria-controls="goal-description">
                        <i id="arrow-right" class="glyphicon glyphicon-chevron-right"></i>
                        <i id="arrow-down" class="glyphicon glyphicon-chevron-down"></i>
                        <b><?php echo e(trans('plan_elements.labels.GOAL'), false); ?></b>
                    </span>
                </div>

                <div id="goal-description" class="collapse" aria-labelledby="goal">
                    <div class="card-body x_panel text-justify">
                        <?php echo e($indicator->goal_description, false); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="plansSelector" class="mt-2 x_panel">
    <div class="mb-5">
        <h5><?php echo e(trans('links.messages.info.selectPlan'), false); ?></h5>
    </div>

    <?php if(empty($availablePlans)): ?>
        <div class="alert alert-warning align-center" role="alert">
            <?php echo e(trans('links.messages.info.noAvailablePlans'), false); ?>

        </div>
    <?php else: ?>
        <?php $__currentLoopData = $availablePlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div plan-id="<?php echo e($plan['id'], false); ?>" class="availablePlans btn btn-default col-lg-3 col-md-3 col-sm-3 col-xs-12 ml-5 mb-5">
                <?php if($plan['type'] === $Plan::TYPE_SECTORAL): ?>
                    <h1 class="align-center"><?php echo e(trans('plans.labels.' . $Plan::TYPE_SECTORAL), false); ?></h1>
                <?php else: ?>
                    <h1 class="align-center"><?php echo e($plan['name'], false); ?></h1>
                <?php endif; ?>
                <div class="align-center col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <?php if($plan['type'] === $Plan::TYPE_SECTORAL): ?>
                        <h5><?php echo e($plan['name'], false); ?></h5>
                    <?php else: ?>
                        <h5><?php echo e(trans('plans.description.' . $plan['type']), false); ?></h5>
                    <?php endif; ?>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>

<div id="loadLinks" class="mt-2 x_panel">

</div>

<script>
    $(() => {
        $('#arrow-down').hide()
        $('#loadLinks').hide()

        $('#cancelIndex').hide()
        $('#cancelLinks').show()

        $('#goal').click(() => {
            if ($('#arrow-down').is(":visible")) {
                $('#arrow-down').hide()
                $('#arrow-right').show()
            } else {
                $('#arrow-down').show()
                $('#arrow-right').hide()
            }
        })

        $('.availablePlans').each((index, element) => {
            $(element).click(() => {
                $('#plansSelector').slideUp()
                $('#backButton').attr('page', 2)
                pushRequest('<?php echo route('load.plan.link.links.plans.plans_management'); ?>', '#loadLinks', () => {
                    $('#loadLinks').slideDown()
                }, 'GET', {
                    '_token': '<?php echo e(csrf_token(), false); ?>',
                    'indicatorId': <?php echo e($indicator->id, false); ?>,
                    'planId': $(element).attr('plan-id'),
                    'objectiveId': <?php echo e($objectiveId, false); ?>,
                    'childPlanName': '<?php echo e($childPlanName, false); ?>'
                });

            })
        })


    })
</script>

<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/planning/link/load_indicator_info.blade.php ENDPATH**/ ?>