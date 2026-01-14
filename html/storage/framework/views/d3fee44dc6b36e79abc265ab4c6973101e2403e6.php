<li>
    <a href="javascript:" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <img src="<?php echo e(asset(currentUser()->photoPath()), false); ?>" alt="...">
        <?php echo currentUser()->fullName(); ?> <span class="fa fa-angle-down"></span>
    </a>
    <ul class="dropdown-menu dropdown-usermenu pull-right">
        <li>
            <a href="javascript:" id="change-passwd-top">
                <i class="fa fa-key pull-right"></i> <?php echo e(trans('app.labels.change_password'), false); ?>

            </a>
        </li>
        <?php if (Auth::check() && Auth::user()->can('change_fiscal_year.users')): ?>
        <li>
            <a class="ajaxify" href="<?php echo e(route('change_fiscal_year.users', currentUser()->id), false); ?>">
                <i class="fa fa-calendar pull-right"></i> <?php echo e(trans('app.labels.change_fiscal_year_profile'), false); ?>

            </a>
        </li>
        <?php endif; ?>
        <li>
            <a class="ajaxify" href="<?php echo e(route('index.profile'), false); ?>">
                <i class="fa fa-user pull-right"></i> <?php echo e(trans('app.labels.profile'), false); ?>

            </a>
        </li>
        <li>
            <a href="javascript:" class="logout">
                <i class="fa fa-sign-out pull-right"></i> <?php echo e(trans('app.labels.exit'), false); ?>

            </a>
        </li>
    </ul>
</li>
<?php /**PATH /var/www/html/resources/views/layout/partial/profile_button.blade.php ENDPATH**/ ?>