<?php for($i = 0; $i < $years + 1; $i++): ?>
    <div class="item form-group">
        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="budgets">
            <?php echo e(trans('projects.labels.year'), false); ?> <?php echo e(isset($annualBudgets[$i]) ? $annualBudgets[$i]['year'] : ($i + 1), false); ?> <span class="required
            text-danger">*</span>
        </label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <?php if(!$inProgress || (isset($annualBudgets[$i]) && $annualBudgets[$i]['year'] > currentFiscalYear()->year)): ?>
                <div class="input-group">
                    <span class="input-group-addon warning">
                        <span class="fa fa-dollar"></span>
                     </span>
                    <input type="text" name="budgets[<?php echo e($i, false); ?>]" id="budgets[<?php echo e($i, false); ?>]" maxlength="16"
                           class="form-control col-md-7 col-sm-7 col-xs-12 mt-0" min="0"
                           value="<?php echo e(isset($annualBudgets[$i]) ? $annualBudgets[$i]['pivot']['referential_budget'] : (isset($values[$i]) ? $values[$i] : ''), false); ?>"
                    />
                </div>
            <?php else: ?>
                <label class="mt-2">$ <?php echo e(isset($annualBudgets[$i]) ? $annualBudgets[$i]['pivot']['referential_budget'] : (isset($values[$i]) ? $values[$i] : ''), false); ?></label>
            <?php endif; ?>
        </div>
    </div>
<?php endfor; ?>

<?php for($i = $years + 1; $i < $newYears + $years + 1; $i++): ?>
    <div class="item form-group">
        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12" for="budgets">
            <?php echo e(trans('projects.labels.year'), false); ?> <?php echo e(($i + 1), false); ?> <span class="required text-danger">*</span>
        </label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon warning">
                    <span class="fa fa-dollar"></span>
                 </span>
                <input type="text" name="budgets[<?php echo e($i, false); ?>]" id="budgets[<?php echo e($i, false); ?>]" maxlength="16"
                       class="form-control col-md-7 col-sm-7 col-xs-12 mt-0" min="0"
                       value="<?php echo e(isset($values[$i]) ? $values[$i] : '', false); ?>"
                />
            </div>
        </div>
    </div>
<?php endfor; ?><?php /**PATH /var/www/html/resources/views/business/planning/plan_element/project/annual_budgets.blade.php ENDPATH**/ ?>