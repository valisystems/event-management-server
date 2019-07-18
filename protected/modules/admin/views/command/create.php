<?php
/* @var $this CommandController */
/* @var $model Command */

$this->breadcrumbs=array(
    'Devices'=>array('index'),
    'Create',
);
?>

    <h1><?php echo Yii::t('admin/command', 'Create Command')?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>