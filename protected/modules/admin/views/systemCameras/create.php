<?php
/* @var $this SystemCamerasController */
/* @var $model SystemCameras */

$this->breadcrumbs=array(
    'System Cameras'=>array('index'),
    'Create',
);
?>

    <h1><?php echo Yii::t('admin/systemcamera', 'Create System Camera');?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>