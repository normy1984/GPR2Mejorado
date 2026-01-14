<?php if (Auth::check() && Auth::user()->can('index.plans.plans_management')): ?>

<?php $Plan = app('\App\Models\Business\Plan'); ?>
<?php $PlanElement = app('\App\Models\Business\PlanElement'); ?>

<?php echo $__env->make('business.planning.partials.justification.form', ['action' => trans('justifications.actions.delete'), 'form' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="page-title">
    <div class="col-md-11 col-sm-11 col-xs-11">
        <h3><?php echo e(trans('plans.labels.plansManagement'), false); ?>

            <small><?php echo e(trans('app.labels.planning'), false); ?></small>
        </h3>
    </div>
</div>

<div class="dashboard-title title_left col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4">
    <h3 class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?php echo e(trans('plans.labels.'.$Plan::SCOPE_SUPRANATIONAL), false); ?> </h3>
    <ul class="nav navbar-right">
        <li class="pull-right">
            <a href="<?php echo e(route('create.plans.plans_management', ['scope'=>$Plan::SCOPE_SUPRANATIONAL]), false); ?>"
               class="ajaxify white">
                <i class="fa fa-plus"></i> <?php echo e(trans('plans.labels.create.'.$Plan::SCOPE_SUPRANATIONAL), false); ?>

            </a>
        </li>
    </ul>
</div>

<div class="row m-4">
    <?php $__currentLoopData = collect($plans)->where('scope', $Plan::SCOPE_SUPRANATIONAL); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($loop->first || (($loop->iteration - 1) % 2) === 0): ?>
            <div class="row">
                <?php endif; ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-4">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo e(\Illuminate\Support\Str::limit($plan->name, 50, '...'), false); ?></h2>
                            <ul class="nav navbar-right panel_toolbox">

                                <li class="pull-right">
                                    <a id="delete_plan_<?php echo e($plan->id, false); ?>" data-toggle="tooltip" data-placement="top"
                                       data-original-title="<?php if($plan->type == $Plan::TYPE_ODS): ?>
                               <?php echo e(trans('app.labels.archives'), false); ?>

                               <?php else: ?>
                               <?php echo e(trans('app.labels.delete'), false); ?>

                               <?php endif; ?>">
                                        <i class="fa <?php if($plan->type == $Plan::TYPE_ODS): ?> fa-inbox green <?php else: ?> fa-trash text-danger <?php endif; ?>"></i>
                                    </a>
                                </li>
                                <li class="pull-right">
                                    <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo e(trans('app.labels.edit'), false); ?>"
                                       class="ajaxify" href="<?php echo e(route('edit.plans.plans_management', ['id'=> $plan->id, 'element_type' => $PlanElement::TYPE_OBJECTIVE]), false); ?>">
                                        <i class="fa fa-edit orange"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>

                        </div>
                        <div class="x_content">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <h5><?php echo e(trans('plan_elements.titles.OBJECTIVE') . ': ' . $plan->elements[$PlanElement::TYPE_OBJECTIVE], false); ?></h5>
                                    <h5><?php echo e(trans('plan_elements.titles.INDICATORS') . ': ' . $plan->elements[$PlanElement::TYPE_INDICATOR], false); ?></h5>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-3">
                                    <i class="<?php echo e($plan->completness, false); ?>"></i>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noVerticalGap">
                                    <h5><?php echo e(trans('plans.labels.objWithIndicators') . ': ' . $plan->elements['additionalInfo']['OBJECTIVES_WITH_INDICATORS'], false); ?></h5>
                                    <?php if($plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS']): ?>
                                        <h5 class="red bold"><?php echo e(trans('plans.labels.objWithoutIndicators') . ': ' . $plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS'], false); ?></h5>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(($loop->iteration % 2) === 0 || $loop->last): ?>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="dashboard-title title_left col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h3 class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?php echo e(trans('plans.labels.'.$Plan::SCOPE_NATIONAL), false); ?> </h3>
    <ul class="nav navbar-right">
        <li class="pull-right">
            <a href="<?php echo e(route('create.plans.plans_management', ['scope'=>$Plan::SCOPE_NATIONAL]), false); ?>"
               class="ajaxify white">
                <i class="fa fa-plus"></i> <?php echo e(trans('plans.labels.create.'.$Plan::SCOPE_NATIONAL), false); ?>

            </a>
        </li>
    </ul>
</div>

<div class="row m-4">
    <?php $__currentLoopData = collect($plans)->where('scope', $Plan::SCOPE_NATIONAL); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($loop->first || (($loop->iteration - 1) % 2) === 0): ?>
            <div class="row">
                <?php endif; ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-4">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo e(\Illuminate\Support\Str::limit($plan->name, 50, '...'), false); ?></h2>
                            <ul class="nav navbar-right panel_toolbox">

                                <li class="pull-right">
                                    <a id="delete_plan_<?php echo e($plan->id, false); ?>" data-toggle="tooltip" data-placement="top"
                                       data-original-title="<?php if($plan->type == $Plan::TYPE_PND): ?>
                               <?php echo e(trans('app.labels.archives'), false); ?>

                               <?php else: ?>
                               <?php echo e(trans('app.labels.delete'), false); ?>

                               <?php endif; ?>">
                                        <i class="fa <?php if($plan->type == $Plan::TYPE_PND): ?> fa-inbox green <?php else: ?> fa-trash text-danger <?php endif; ?>"></i>
                                    </a>
                                </li>
                                <li class="pull-right">
                                    <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo e(trans('app.labels.edit'), false); ?>"
                                       class="ajaxify" href="<?php echo e(route('edit.plans.plans_management', ['id'=> $plan->id, 'element_type' => $PlanElement::TYPE_THRUST]), false); ?>">
                                        <i class="fa fa-edit orange"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>

                        </div>
                        <div class="x_content">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <h5><?php echo e(trans('plan_elements.titles.THRUST') . ': ' . $plan->elements[$PlanElement::TYPE_THRUST], false); ?></h5>
                                    <h5><?php echo e(trans('plan_elements.titles.OBJECTIVE') . ': ' . $plan->elements[$PlanElement::TYPE_OBJECTIVE], false); ?></h5>
                                    <h5><?php echo e(trans('plan_elements.titles.INDICATORS') . ': ' . $plan->elements[$PlanElement::TYPE_INDICATOR], false); ?></h5>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-3">
                                    <i class="<?php echo e($plan->completness, false); ?>"></i>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noVerticalGap">
                                    <h5><?php echo e(trans('plans.labels.objWithIndicators') . ': ' . $plan->elements['additionalInfo']['OBJECTIVES_WITH_INDICATORS'], false); ?></h5>
                                    <?php if($plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS']): ?>
                                        <h5 class="red bold"><?php echo e(trans('plans.labels.objWithoutIndicators') . ': ' . $plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS'], false); ?></h5>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(($loop->iteration % 2) === 0 || $loop->last): ?>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="dashboard-title title_left col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h3 class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?php echo e(trans('plans.labels.' . $Plan::SCOPE_TERRITORIAL), false); ?> </h3>
    <ul class="nav navbar-right ">
        <li class="pull-right">
            <a href="<?php echo e(route('create.plans.plans_management', ['scope'=>$Plan::SCOPE_TERRITORIAL]), false); ?>"
               class="ajaxify white">
                <i class="fa fa-plus"></i> <?php echo e(trans('plans.labels.create.' . $Plan::SCOPE_TERRITORIAL), false); ?>

            </a>
        </li>
    </ul>
</div>

<div class="row m-4">
    <?php $__currentLoopData = collect($plans)->where('scope', $Plan::SCOPE_TERRITORIAL); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($loop->first || (($loop->iteration - 1) % 2) === 0): ?>
            <div class="row">
                <?php endif; ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-4">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo e(\Illuminate\Support\Str::limit($plan->name, 50, '...'), false); ?></h2>
                            <ul class="nav navbar-right panel_toolbox">

                                <?php if($plan->status != $Plan::STATUS_DRAFT): ?>
                                    <li class="pull-right">
                                        <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo e(trans('app.labels.link'), false); ?>"
                                           class="ajaxify"
                                           href="<?php echo e(route('plan.link.links.plans.plans_management', [
                                   'id' => $plan->id
                               ]), false); ?>">
                                            <i class="fa fa-link blue"></i>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="pull-right">
                                        <a id="verify_PDOT_<?php echo e($plan->id, false); ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo e(trans('plans.labels.VERIFIED'), false); ?>"
                                           <?php if(isset($plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS']) && $plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS'] == 0): ?>
                                               class="ajaxify"
                                           href="<?php echo e(route('approve.plans.plans_management', [
                                    'id' => $plan->id,
                                    'no_indicators' => $plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS'] ]), false); ?>"
                                           <?php else: ?>
                                               class="notify"
                                            <?php endif; ?>>
                                            <i class="fa fa-check-square-o green"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <li class="pull-right">
                                    <a id="delete_plan_<?php echo e($plan->id, false); ?>" data-toggle="tooltip" data-placement="top"
                                       data-original-title="<?php if($plan->type == $Plan::TYPE_PDOT): ?>
                               <?php echo e(trans('app.labels.archives'), false); ?>

                               <?php else: ?>
                               <?php echo e(trans('app.labels.delete'), false); ?>

                               <?php endif; ?>">
                                        <i class="fa <?php if($plan->type == $Plan::TYPE_PDOT): ?> fa-inbox green <?php else: ?> fa-trash text-danger <?php endif; ?>"></i>
                                    </a>
                                </li>

                                <li class="pull-right">
                                    <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo e(trans('app.labels.edit'), false); ?>"
                                       class="ajaxify"
                                       href="<?php echo e(route('edit.plans.plans_management', [
                                   'id' => $plan->id,
                                   'element_type' => $plan->type == $Plan::TYPE_PDOT ?
                                       $PlanElement::TYPE_THRUST :
                                       $PlanElement::TYPE_OBJECTIVE
                               ]), false); ?>">
                                        <i class="fa fa-edit orange"></i>
                                    </a>
                                </li>

                            </ul>
                            <div class="clearfix"></div>

                        </div>
                        <div class="x_content">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <?php if($plan->type == $Plan::TYPE_PDOT): ?>
                                        <h5><?php echo e(trans('plan_elements.titles.THRUST') . ': ' . $plan->elements[$PlanElement::TYPE_THRUST], false); ?></h5>
                                    <?php endif; ?>
                                    <h5><?php echo e(trans('plan_elements.titles.OBJECTIVE') . ': ' . $plan->elements[$PlanElement::TYPE_OBJECTIVE], false); ?></h5>
                                    <h5><?php echo e(trans('plan_elements.titles.INDICATORS') . ': ' . $plan->elements[$PlanElement::TYPE_INDICATOR], false); ?></h5>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-3">
                                    <i class="<?php echo e($plan->completness, false); ?>"></i>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noVerticalGap">
                                    <h5><?php echo e(trans('plans.labels.objWithIndicators') . ': ' . $plan->elements['additionalInfo']['OBJECTIVES_WITH_INDICATORS'], false); ?></h5>

                                    <?php if($plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS']): ?>
                                        <h5 class="red bold"><?php echo e(trans('plans.labels.objWithoutIndicators') . ': ' . $plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS'], false); ?></h5>
                                    <?php endif; ?>
                                    <?php if($plan->status != $Plan::STATUS_DRAFT): ?>
                                        <?php if($plan->elements['additionalInfo']['NO_LINKED_INDICATORS']): ?>
                                            <h5 class="red bold"><?php echo e(trans('plans.labels.noLinkedIndicators') . ': ' . $plan->elements['additionalInfo']['NO_LINKED_INDICATORS'], false); ?></h5>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(($loop->iteration % 2) === 0 || $loop->last): ?>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="dashboard-title title_left col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h3 class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?php echo e(trans('plans.labels.'.$Plan::SCOPE_INSTITUTIONAL), false); ?> </h3>
    <ul class="nav navbar-right ">
        <li class="pull-right">
            <a id="createPEI" href="<?php echo e(route('create.plans.plans_management', ['scope'=>$Plan::SCOPE_INSTITUTIONAL]), false); ?>" class="ajaxify white">
                <i class="fa fa-plus"></i> <?php echo e(trans('plans.labels.create.'.$Plan::SCOPE_INSTITUTIONAL), false); ?>

            </a>
        </li>
    </ul>
</div>

<div class="row m-4">
    <?php $__currentLoopData = collect($plans)->where('scope', $Plan::SCOPE_INSTITUTIONAL); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($loop->first || (($loop->iteration - 1) % 2) === 0): ?>
            <div class="row">
                <?php endif; ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-4">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo e(\Illuminate\Support\Str::limit($plan->name, 50, '...'), false); ?></h2>
                            <ul class="nav navbar-right panel_toolbox">

                                <?php if($plan->status != $Plan::STATUS_DRAFT): ?>
                                    <li class="pull-right">
                                        <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo e(trans('app.labels.link'), false); ?>"
                                           class="ajaxify"
                                           href="<?php echo e(route('plan.link.links.plans.plans_management', [
                                   'id'=> $plan->id
                               ]), false); ?>">
                                            <i class="fa fa-link blue"></i>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="pull-right">
                                        <a id="verify_PEI_<?php echo e($plan->id, false); ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo e(trans('plans.labels.APPROVED'), false); ?>"
                                           <?php if(isset($plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS']) && $plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS'] == 0): ?>
                                               class="ajaxify"
                                           href="<?php echo e(route('approve.plans.plans_management', [
                                    'id' => $plan->id,
                                    'no_indicators' => $plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS'],
                                    'projects' => $plan->elements[$PlanElement::TYPE_PROJECT] ]), false); ?>"
                                           <?php else: ?>
                                               class="notify"
                                            <?php endif; ?>>
                                            <i class="fa fa-check-square-o green"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <li class="pull-right">
                                    <a id="delete_plan_<?php echo e($plan->id, false); ?>" data-toggle="tooltip" data-placement="top"
                                       data-original-title="<?php if($plan->type == $Plan::TYPE_PEI): ?>
                                           <?php echo e(trans('app.labels.archives'), false); ?>

                                           <?php else: ?>
                                           <?php echo e(trans('app.labels.delete'), false); ?>

                                           <?php endif; ?>">
                                        <i class="fa <?php if($plan->type == $Plan::TYPE_PEI): ?> fa-inbox green <?php else: ?> fa-trash text-danger <?php endif; ?>"></i>
                                    </a>
                                </li>
                                <li class="pull-right">
                                    <a data-toggle="tooltip" data-placement="top" data-original-title="<?php echo e(trans('app.labels.edit'), false); ?>"
                                       class="ajaxify"
                                       href="<?php echo e(route('edit.plans.plans_management', [
                                   'id'=> $plan->id,
                                   'element_type' => $PlanElement::TYPE_OBJECTIVE
                               ]), false); ?>">
                                        <i class="fa fa-edit orange"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>

                        </div>
                        <div class="x_content">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <h5><?php echo e(trans('plan_elements.titles.OBJECTIVE') . ': ' . $plan->elements[$PlanElement::TYPE_OBJECTIVE], false); ?></h5>
                                    <h5><?php echo e(trans('plan_elements.titles.INDICATORS') . ': ' . $plan->elements[$PlanElement::TYPE_INDICATOR], false); ?></h5>
                                    <h5><?php echo e(trans('plan_elements.titles.PROJECT') . ': ' . $plan->elements[$PlanElement::TYPE_PROJECT], false); ?></h5>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-3">
                                    <i class="<?php echo e($plan->completness, false); ?>"></i>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noVerticalGap">
                                    <h5><?php echo e(trans('plans.labels.objWithIndicators') . ': ' . $plan->elements['additionalInfo']['OBJECTIVES_WITH_INDICATORS'], false); ?></h5>
                                    <?php if($plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS']): ?>
                                        <h5 class="red bold"><?php echo e(trans('plans.labels.objWithoutIndicators') . ': ' . $plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_INDICATORS'], false); ?></h5>
                                    <?php endif; ?>
                                    <?php if($plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_PROJECTS']): ?>
                                        <h5 class="red bold"><?php echo e(trans('plans.labels.objWithoutProjects') . ': ' . $plan->elements['additionalInfo']['OBJECTIVES_WITHOUT_PROJECTS'], false); ?></h5>
                                    <?php endif; ?>
                                    <?php if($plan->elements['additionalInfo']['PROGRAM_SUBPROGRAM_WITHOUT_PROJECTS']): ?>
                                        <h5 class="red bold"><?php echo e(trans('plans.labels.programWithoutProjects') . ': ' . $plan->elements['additionalInfo']['PROGRAM_SUBPROGRAM_WITHOUT_PROJECTS'], false); ?></h5>
                                    <?php endif; ?>

                                    <?php if(!$plan->elements[$PlanElement::TYPE_PROJECT]): ?>
                                        <h5 class="red bold"><?php echo e(trans('plans.labels.planWithoutProjects') . ': ' . $plan->elements[$PlanElement::TYPE_PROJECT], false); ?></h5>
                                    <?php endif; ?>
                                    <?php if($plan->type == $Plan::TYPE_PEI): ?>
                                        <?php if($plan->status != $Plan::STATUS_DRAFT): ?>
                                            <?php if($plan->elements['additionalInfo']['NO_LINKED_INDICATORS']): ?>
                                                <h5 class="red bold"><?php echo e(trans('plans.labels.noLinkedIndicators') . ': ' . $plan->elements['additionalInfo']['NO_LINKED_INDICATORS'], false); ?></h5>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(($loop->iteration % 2) === 0 || $loop->last): ?>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<script>
    $(() => {

        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        $('#delete_plan_<?php echo e($plan->id, false); ?>').click(() => {

            let jsonData = {
                '_token': '<?php echo e(csrf_token(), false); ?>',
            };

            let confirmMessage = '<?php echo $plan->confirmMessage; ?>';
            let url = '<?php echo route ('destroy.plans.plans_management', ['id' => $plan->id] ); ?>';

            let callback = (data = null, options = null) => {
                pushRequest(url, null, () => {
                }, 'post', data || jsonData, true, options);
            };

            <?php if(isJustifiable($plan)): ?>
            justificationModal(callback, jsonData, confirmMessage);
            <?php else: ?>
            confirmModal(confirmMessage, callback);
            <?php endif; ?>
        });

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        $('#createPEI').on('click', () => {
            if ($('#createPEI').hasClass('notify')) {
                notify('<?php echo e(trans('plans.messages.warning.planAlreadyExists'), false); ?>', 'warning', null);
            }
        })

        $('[id^=verify_PDOT_]').on('click', (e) => {
            if ($(e.currentTarget).hasClass('notify')) {
                notify('<?php echo e(trans('plans.messages.warning.approvalNotAllowed.' . $Plan::SCOPE_TERRITORIAL), false); ?>', 'warning')
            }
        })

        $('[id^=verify_PEI_]').on('click', (e) => {
            if ($(e.currentTarget).hasClass('notify')) {
                notify('<?php echo e(trans('plans.messages.warning.approvalNotAllowed.' . $Plan::SCOPE_INSTITUTIONAL), false); ?>', 'warning')
            }
        })

    });
</script>

<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/business/planning/plan/index.blade.php ENDPATH**/ ?>