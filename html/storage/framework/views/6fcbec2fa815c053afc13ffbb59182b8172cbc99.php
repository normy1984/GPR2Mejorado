<tr id="activity_row_<?php echo e($element['id'], false); ?>" class="activity_row treeview-item-unselected" activity_id="<?php echo e($element['id'], false); ?>" parent_row="component_row_<?php echo e($element['component_id'], false); ?>">
    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(!in_array($key, ['type', 'id', 'children', 'status', 'responsible', 'component_id', 'attachment'])): ?>
            <td class="<?php echo e($key, false); ?>" id="activity_col_<?php echo e($element['id'], false); ?>_<?php echo e($key, false); ?>">
                <?php switch($key):
                    case ('name'): ?>
                    <div class="ml-3">
                        <?php if(isset($element['children']) && $element['children']->count()): ?>
                            <i id="arrow_<?php echo e($element['id'], false); ?>_right" class="glyphicon glyphicon-chevron-right arrow_right mr-1" role="button"></i>
                            <i id="arrow_<?php echo e($element['id'], false); ?>_down" class="glyphicon glyphicon-chevron-down arrow_down mr-1" role="button"></i>
                        <?php endif; ?>
                        <?php if(isset($element['responsible']) && $element['responsible']): ?>
                            (<label class="acronym" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo e($element['responsible']->fullName(), false); ?>">
                                <?php echo e($element['responsible']->getAcronym(), false); ?>

                            </label>)
                        <?php endif; ?>
                        <strong><?php echo e($column, false); ?></strong>
                    </div>
                    <?php break; ?>

                    <?php case ('semaphore'): ?>
                    <div class="circle bg_<?php echo e($column, false); ?>" data-toggle="tooltip" data-placement="top"
                         data-original-title="<?php echo e(trans('physical_progress.labels.activityStatus.' . $column), false); ?>"></div>
                    <?php break; ?>

                    <?php default: ?>
                    <div id="activity_col_<?php echo e($element['id'], false); ?>_<?php echo e($key, false); ?>">
                        <strong><?php echo e($column, false); ?></strong>
                    </div>
                <?php endswitch; ?>
            </td>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <td></td>
</tr><?php /**PATH /var/www/html/resources/views/business/tracking/projects/physical/loadActivity.blade.php ENDPATH**/ ?>