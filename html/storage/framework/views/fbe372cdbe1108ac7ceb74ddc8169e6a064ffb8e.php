<style>
    .left_col, .nav_title {
        background-color: <?php echo e($menuStyles['color'], false); ?> !important;
    }

    .nav-sm ul.nav.child_menu, li.active, .nav.side-menu > li.active > a,
    li.active-sm {
        background: <?php echo e($menuStyles['active_color'], false); ?>;
    }

    .scroll-submenu {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .profile_info span, .profile_info h2,
    span.fa-chevron-down, .nav-md ul.nav.child_menu li:after,
    .nav-md ul.nav.child_menu li:before, .nav.side-menu > li.active,
    .nav.side-menu > li.current-page, .nav-sm .nav.child_menu li.active,
    .nav-sm .nav.side-menu li.active-sm, .nav.child_menu > li > a,
    .nav.side-menu > li > a {
        color: <?php echo e($menuStyles['text_color'], false); ?>;
    }

</style>
<div class="left_col scroll-view hidden-print">
    <div class="navbar nav_title">
        <table class="height-auto gad-table mt-3 mr-3 mb-3 ml-3">
            <tr>
                <td><img src="<?php echo e(asset($logos['menu_logo']), false); ?>" alt="LOGO" /></td>
                <td class="pl-3 gad-title"><span><?php echo e($gad['province_short_name'], false); ?></span></td>
            </tr>
        </table>
    </div>
    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile">
        <div class="profile_pic">
            <img src="<?php echo e(asset(currentUser()->photoPath()), false); ?>" alt="..." class="img-circle profile_img">
        </div>
        <div class="profile_info">
            <span><?php echo e(trans('app.labels.welcome'), false); ?>,</span>
            <h2><?php echo currentUser()->fullName(); ?></h2>
        </div>
    </div>
    <!-- /menu profile quick info -->

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu" style="margin-top: 20px;">
        <div class="menu_section">
            <h3>&nbsp;</h3>

            <ul class="nav side-menu">

                <?php if(!currentUser()->hasRole('developer') && session()->get('module')->id == \Laverix\Acl\Models\Eloquent\Module::MODULE_GXR): ?>
                    <li>
                        <a class="ajaxify start" href="<?php echo e(route('index.tasks'), false); ?>">
                            <i class="fa fa-tasks"></i> <?php echo e(trans('user_tasks.title'), false); ?>

                        </a>
                    </li>
                <?php endif; ?>

                <li>
                    <a class="ajaxify <?php echo e(session()->get('module')->id != \Laverix\Acl\Models\Eloquent\Module::MODULE_GXR ? 'start':'', false); ?>" href="<?php echo e($defaultRoute, false); ?>">
                        <i class="fa fa-dashboard"></i> <?php echo e(trans('app.labels.dashboard'), false); ?>

                    </a>
                </li>

                <?php echo $__env->renderEach('layout.partial.menu', $menus, 'menu'); ?>

                <?php if (Auth::check() && Auth::user()->hasRole('developer')): ?>
                <li>
                    <a href="javascript:">
                        <i class="fa fa-wrench"></i> <?php echo e(trans('configuration.title'), false); ?>

                        <span class="fa fa-chevron-down"></span>
                    </a>

                    <ul class="nav child_menu">
                        <li>
                            <a href="<?php echo e(route('index.permissions.configuration'), false); ?>" class="ajaxify">
                                <?php echo e(trans('configuration.permission.title'), false); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('index.roles.configuration'), false); ?>" class="ajaxify">
                                <?php echo e(trans('configuration.role.title'), false); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('index.menus.configuration'), false); ?>" class="ajaxify">
                                <?php echo e(trans('configuration.menu.title'), false); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('edit.ui.configuration'), false); ?>" class="ajaxify">
                                <?php echo e(trans('configuration.ui.title'), false); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('index.settings.configuration'), false); ?>" class="ajaxify">
                                <?php echo e(trans('configuration.setting.title'), false); ?>

                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
        <a href="<?php echo e(route('dashboard.app'), false); ?>" class="ajaxify" title="<?php echo e(trans('app.labels.dashboard'), false); ?>" data-toggle="tooltip" data-placement="top">
            <span class="glyphicon glyphicon-dashboard"></span>
        </a>

        <a href="<?php echo e(route('index.profile'), false); ?>" class="ajaxify" title="<?php echo e(trans('app.labels.profile'), false); ?>" data-toggle="tooltip" data-placement="top">
            <span class="glyphicon glyphicon-user"></span>
        </a>

        <a href="javascript:" title="<?php echo e(trans('app.labels.change_password'), false); ?>" id="change-passwd-left" data-toggle="tooltip" data-placement="top">
            <span class="fa fa-key"></span>
        </a>

        <a href="<?php echo e(route('logout'), false); ?>" class="logout" title="<?php echo e(trans('app.labels.exit'), false); ?>" data-toggle="tooltip" data-placement="top">
            <span class="glyphicon glyphicon-off"></span>
        </a>
    </div>

    <!-- /menu footer buttons -->
</div>
<?php /**PATH /var/www/html/resources/views/layout/left_col.blade.php ENDPATH**/ ?>