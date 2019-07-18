<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 2/1/16
 * Time: 19:17
 */


$this->breadcrumbs=array(
    'Update Ems',
);

?>
<div class="panel panel-default">
    <div class="panel-heading"><?php echo Yii::t('admin/updateEms', 'Update Status');?></div>
    <div class="panel-body">
        <?php echo nl2br($response);?>
    </div>
</div>

<div class="row">
    <a
        href="/admin/updateEms"
        class="btn btn-primary"><?php echo Yii::t('admin/updateEms', 'Go to update list');?></a>
</div>