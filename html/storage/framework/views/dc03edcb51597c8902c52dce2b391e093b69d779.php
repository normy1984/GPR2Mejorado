<!--
Layout for Datatables actions. The usage of each variable will be:

1. $actions. For each $action:

Each action’s key, will represent the icon ($icon) of the button. Use Font Awesome icons.

$action[‘route’] : (Mandatory) defines the URL that will be called when user clicks the button.
$action[‘method’]: (Optional) If not sent, the default will be GET.
$action[‘confirm_message’] : (Optional) If sent, a confirmation modal will be raised with the sent message.
$action[‘tooltip’]: (Optional) If sent, the button icon will have a tooltip.
$action[‘btn_class’]: (Optional) If sent, the link of the button will have a CSS class, to work with.
$action[‘post_action’]: (Optional) If sent, a Javascript callback can be sent to be executed after the Back-end sends a response. Example  ‘$(“#publish_vacants_tb”).DataTable().draw();’
$action['params']: (Optional) If sent, the route will send the specified params
$action['no_ajax']: (Optional) If sent, the route will be open in a new blank tab without ajax

2. $entity

The database object that represents the entity that will be manipulated with the current actions.


To hide the actions and show them on mouse hover, add an "actions" class on the very first div of this file.
-->

<div>
    <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon => $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a
            <?php if(isset($entity->gid)): ?>
                id="<?php echo e(explode('.',$action['route'])[0].$entity->gid . '-' . explode('.',$action['route'])[1].$entity->gid, false); ?>" class="btn btn-xs <?php if(isset($action['btn_class'])): ?> <?php echo e($action['btn_class'], false); ?> <?php else: ?> btn-primary <?php endif; ?> <?php echo e(explode('.',$action['route'])[0].$entity->gid . '-' . explode('.',$action['route'])[1].$entity->gid, false); ?>"
            <?php elseif(isset($entity->codigo)): ?>
                id="<?php echo e(explode('.',$action['route'])[0].$entity->codigo . '-' . explode('.',$action['route'])[1].$entity->codigo, false); ?>" class="btn btn-xs <?php if(isset($action['btn_class'])): ?> <?php echo e($action['btn_class'], false); ?> <?php else: ?> btn-primary <?php endif; ?> <?php echo e(explode('.',$action['route'])[0].$entity->codigo . '-' . explode('.',$action['route'])[1].$entity->codigo, false); ?>"
            <?php else: ?>
                id="<?php echo e(explode('.',$action['route'])[0].$entity->id . '-' . explode('.',$action['route'])[1].$entity->id, false); ?>" class="btn btn-xs <?php if(isset($action['btn_class'])): ?> <?php echo e($action['btn_class'], false); ?> <?php else: ?> btn-primary <?php endif; ?> <?php echo e(explode('.',$action['route'])[0].$entity->id . '-' . explode('.',$action['route'])[1].$entity->id, false); ?>"
            <?php endif; ?>
            role="button" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo e($action['tooltip'] ?? '', false); ?>"
            <?php if(isset($action['ajaxify'])): ?> data-ajaxify="<?php echo e($action['ajaxify'], false); ?>" <?php endif; ?>
            <?php if(isset($action['no_ajax'])): ?> target="_blank"
            <?php if(isset($action['params'])): ?>
                <?php if(isset($entity->gid)): ?>
                    url = '<?php echo route ($action['route'], array_merge($action['params'], ['gid' => $entity->gid] ) ); ?>';
            <?php elseif(isset($entity->codigo)): ?>
                url = '<?php echo route ($action['route'], array_merge($action['params'], ['codigo' => $entity->codigo] ) ); ?>';
            <?php else: ?>
                url = '<?php echo route ($action['route'], array_merge($action['params'], ['id' => $entity->id] ) ); ?>';
            <?php endif; ?>
            <?php else: ?>
                <?php if(isset($entity->gid)): ?>
                    href = '<?php echo route ($action['route'], ['gid' => $entity->gid] ); ?>';
            <?php elseif(isset($entity->codigo)): ?>
                href = '<?php echo route ($action['route'], ['codigo' => $entity->codigo] ); ?>';
            <?php else: ?>
                href = '<?php echo route ($action['route'], ['id' => $entity->id] ); ?>';
            <?php endif; ?>
            <?php endif; ?>
            <?php endif; ?>>
            <i class="fa fa-<?php echo e($icon, false); ?>"></i>
        </a>

        <?php if(!isset($action['no_ajax'])): ?>
            <script>
                <?php if(isset($entity->gid)): ?>
                let class_id = '<?php echo explode('.',$action['route'])[0].$entity->gid . '-' . explode('.',$action['route'])[1].$entity->gid; ?>';
                <?php elseif(isset($entity->codigo)): ?>
                let class_id = '<?php echo explode('.',$action['route'])[0].$entity->codigo . '-' . explode('.',$action['route'])[1].$entity->codigo; ?>';
                <?php else: ?>
                let class_id = '<?php echo explode('.',$action['route'])[0].$entity->id . '-' . explode('.',$action['route'])[1].$entity->id; ?>';
                <?php endif; ?>
                $('.' + class_id).on('click', (e) => {
                    if (e.isDefaultPrevented()) {
                        return;
                    }
                    e.preventDefault();
                    $('[data-toggle="tooltip"]', $main_content).tooltip('hide');
                    let url = "";
                    <?php if(isset($action['params'])): ?>
                        <?php if(isset($entity->gid)): ?>
                        url = '<?php echo route ($action['route'], array_merge($action['params'], ['gid' => $entity->gid] ) ); ?>';
                    <?php elseif(isset($entity->codigo)): ?>
                        url = '<?php echo route ($action['route'], array_merge($action['params'], ['codigo' => $entity->codigo] ) ); ?>';
                    <?php else: ?>
                        url = '<?php echo route ($action['route'], array_merge($action['params'], ['id' => $entity->id] ) ); ?>';
                    <?php endif; ?>
                        <?php else: ?>
                        <?php if(isset($entity->gid)): ?>
                        url = '<?php echo route ($action['route'], ['gid' => $entity->gid]); ?>';
                    <?php elseif(isset($entity->codigo)): ?>
                        url = '<?php echo route ($action['route'], ['codigo' => $entity->codigo]); ?>';
                    <?php else: ?>
                        url = '<?php echo route ($action['route'], ['id' => $entity->id]); ?>';
                    <?php endif; ?>
                    <?php endif; ?>
                    let method = '<?php echo isset($action['method']) ? $action['method'] : null; ?>';
                    let data_ajaxify = '<?php echo isset($action['ajaxify']) ? $action['ajaxify'] : null; ?>';
                    <?php if(isset($action['confirm_message'])): ?>
                    let confirmMessage = '<?php echo $action['confirm_message']; ?>';
                    confirmModal(confirmMessage, () => {
                        pushRequest(url, data_ajaxify, () => {
                            <?php if(isset($action['post_action'])): ?>
                                <?php echo $action['post_action']; ?>

                                <?php endif; ?>
                        }, method, {'_token': '<?php echo e(csrf_token(), false); ?>'}, <?php echo e(isset($action['scroll-top']) ? $action['scroll-top'] : null, false); ?>);
                    });
                    <?php else: ?>
                    pushRequest(url, data_ajaxify, () => {
                        <?php if(isset($action['post_action'])): ?>
                            <?php echo $action['post_action']; ?>

                            <?php endif; ?>
                    }, method, {'_token': '<?php echo e(csrf_token(), false); ?>'}, <?php echo e(isset($action['scroll-top']) ? $action['scroll-top'] : null, false); ?> );
                    <?php endif; ?>
                });
            </script>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /var/www/html/resources/views/layout/partial/actions_tooltip.blade.php ENDPATH**/ ?>