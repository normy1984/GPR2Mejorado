<?php if(is_array($menu)): ?>

<li>
    <a href="<?php echo e((array_key_exists('slug', $menu)) ? route($menu['slug']) : 'javascript:;', false); ?>"
        class="<?php echo e((array_key_exists('slug', $menu)) ? 'ajaxify' : '', false); ?>">

        <?php if(array_key_exists('icon', $menu)): ?>
            <i class="fa fa-<?php echo e($menu['icon'], false); ?>"></i>
        <?php endif; ?>

        <?php echo e($menu['label'], false); ?>


        <?php if(array_key_exists('children', $menu)): ?>
            <span class="fa fa-chevron-down"></span>
        <?php endif; ?>
    </a>

    <?php if(array_key_exists('children', $menu)): ?>
        <ul class="nav child_menu">
            <?php echo $__env->renderEach('layout.partial.menu', $menu['children'], 'menu'); ?>
        </ul>
    <?php endif; ?>
</li>

<?php endif; ?><?php /**PATH /var/www/html/resources/views/layout/partial/menu.blade.php ENDPATH**/ ?>