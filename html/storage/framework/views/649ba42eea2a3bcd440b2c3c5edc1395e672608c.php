<div id="current-expenditure-tree" class="x_panel">
    <div class="x_title">
        <h2 class="align-center"><?php echo e(trans('current_expenditure.labels.structure'), false); ?></h2>

        <div class="clearfix"></div>
    </div>
</div>

<script>
    $(() => {
        $('#current-expenditure-tree').tree({
            data: '<?php echo $json; ?>',
            selectParents: true
        })
    });
</script><?php /**PATH /var/www/html/resources/views/business/planning/current_expenditure/load_structure.blade.php ENDPATH**/ ?>