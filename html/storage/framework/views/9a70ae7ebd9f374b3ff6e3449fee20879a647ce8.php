<table class="report-table pdf-table">
    <thead>
    <tr>
        <th colspan="42" style="text-align: center; background-color: #B3B3B3; font-weight: bold; font-size: 18px; height: 30px"><?php echo e(trans('reports.poa.title_tracking'), false); ?></th>
    </tr>
    <tr>
        <th colspan="40"></th>
    </tr>
    <tr>
        <th colspan="6" style="text-align: center; background-color: #6FB4F6"><?php echo e(trans('reports.poa.programmatic_structure'), false); ?></th>
        <th colspan="5" style="text-align: center; background-color: #f6ffb3"><?php echo e(trans('reports.poa.alignment_budget_item'), false); ?></th>
        <th rowspan="2" style="background-color: #46f7ff"><?php echo e(trans('reports.poa.competence'), false); ?></th>
        <th colspan="4" style="text-align: center; background-color: #ded3f6"><?php echo e(trans('reports.poa.alignment_orientation'), false); ?></th>
        <th colspan="3" style="text-align: center; background-color: #d093f6"><?php echo e(trans('reports.poa.alignment_location'), false); ?></th>
        <th rowspan="2" style="width: 20px; text-align: center; background-color: #b9b5ab"><?php echo e(trans('reports.poa.source'), false); ?></th>
        <th rowspan="2" style="width: 30px; background-color: #b9b5ab"><?php echo e(trans('reports.poa.institution'), false); ?></th>
        <th rowspan="2" style="width: 60px; text-align: center; background-color: #6463b9; color: #FFFFFF"><?php echo e(trans('reports.poa.budget_item'), false); ?></th>
		<th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.assigned'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.encoded'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.for_compromising'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.total_accrued'), false); ?></th>
        <!--<th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.encoded'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.total_accrued'), false); ?></th>-->
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.jan'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.feb'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.mar'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.t1'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.apr'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.may'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.jun'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.t2'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.jul'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.aug'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.sep'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.t3'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.oct'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.nov'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.dec'), false); ?></th>
        <th rowspan="2" style="text-align: center; background-color: #6463b9; color: #FFFFFF; width: 12px"><?php echo e(trans('reports.poa.t4'), false); ?></th>
    </tr>
    <tr>
        <th style="width: 15px; background-color: #6FB4F6"><?php echo e(trans('reports.poa.area'), false); ?></th>
        <th style="width: 40px; background-color: #6FB4F6"><?php echo e(trans('reports.poa.program'), false); ?></th>
        <th style="width: 40px; background-color: #6FB4F6"><?php echo e(trans('reports.poa.subprogram'), false); ?></th>
        <th style="width: 40px; background-color: #6FB4F6"><?php echo e(trans('reports.poa.project'), false); ?></th>
        <th style="width: 20px; background-color: #6FB4F6"><?php echo e(trans('reports.poa.executing_unit'), false); ?></th>
        <th style="width: 40px; background-color: #6FB4F6"><?php echo e(trans('reports.poa.activity'), false); ?></th>
        <th style="text-align: center;background-color: #f6ffb3"><?php echo e(trans('reports.poa.nature'), false); ?></th>
        <th style="text-align: center;background-color: #f6ffb3"><?php echo e(trans('reports.poa.group'), false); ?></th>
        <th style="text-align: center;background-color: #f6ffb3"><?php echo e(trans('reports.poa.subgroup'), false); ?></th>
        <th style="width: 30px;background-color: #f6ffb3"><?php echo e(trans('reports.poa.item'), false); ?></th>
        <th style="width: 55px; background-color: #f6ffb3"><?php echo e(trans('reports.poa.description'), false); ?></th>
        <th style="text-align: center;background-color: #ded3f6"><?php echo e(trans('reports.poa.orientation'), false); ?></th>
        <th style="text-align: center;background-color: #ded3f6"><?php echo e(trans('reports.poa.direction'), false); ?></th>
        <th style="text-align: center;background-color: #ded3f6"><?php echo e(trans('reports.poa.category'), false); ?></th>
        <th style="width: 20px; background-color: #ded3f6"><?php echo e(trans('reports.poa.sub_category'), false); ?></th>
        <th style="text-align: center;background-color: #d093f6"><?php echo e(trans('reports.poa.province'), false); ?></th>
        <th style="text-align: center;background-color: #d093f6"><?php echo e(trans('reports.poa.canton'), false); ?></th>
        <th style="width: 20px; background-color: #d093f6"><?php echo e(trans('reports.poa.parish'), false); ?></th>
    </tr>
    </thead>
    <?php if(isset($rows)): ?>
        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($row->area, false); ?></td>
                <td><?php echo e($row->program, false); ?></td>
                <td><?php echo e($row->subprogram, false); ?></td>
                <td><?php echo e($row->project, false); ?></td>
                <td><?php echo e($row->executingUnit, false); ?></td>
                <td><?php echo e($row->activity, false); ?></td>
                <td><?php echo e($row->nature, false); ?></td>
                <td><?php echo e($row->group, false); ?></td>
                <td><?php echo e($row->subgroup, false); ?></td>
                <td><?php echo e($row->item, false); ?></td>
                <td><?php echo e($row->description, false); ?></td>
                <td><?php echo e($row->competence, false); ?></td>
                <td><?php echo e($row->orientation, false); ?></td>
                <td><?php echo e($row->direction, false); ?></td>
                <td><?php echo e($row->category, false); ?></td>
                <td><?php echo e($row->subCategory, false); ?></td>
                <td><?php echo e($row->province, false); ?></td>
                <td><?php echo e($row->canton, false); ?></td>
                <td><?php echo e($row->parish, false); ?></td>
                <td><?php echo e($row->source, false); ?></td>
                <td><?php echo e($row->institution, false); ?></td>
                <td><?php echo e($row->code, false); ?></td>        
                <td><?php echo e((float) str_replace(',', '',$row->assigned), false); ?></td>
                <td><?php echo e((float) str_replace(',', '', $row->encoded), false); ?></td>
                <td><?php echo e((float) str_replace(',', '', $row->for_compromising), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->total_amount), false); ?></td>
            	<td><?php echo e((float) str_replace(',', '',$row->jan), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->feb), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->mar), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->t1 ), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->apr), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->may), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->jun), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->t2 ), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->jul), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->aug), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->sep), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->t3 ), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->oct), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->nov), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->dec), false); ?></td>
                <td><?php echo e((float) str_replace(',', '',$row->t4 ), false); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</table><?php /**PATH /var/www/html/resources/views/business/reports/tracking/poa/table.blade.php ENDPATH**/ ?>