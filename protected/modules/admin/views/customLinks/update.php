<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 11/11/15
 * Time: 15:44
 */
$this->breadcrumbs=array(
    'Custom Links'=>array('index'),
    'Update',
);
?>

    <h1> <?php echo Yii::t('admin/customLinks', 'Update Custom Links')." ".$model->desc_custom_links; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>