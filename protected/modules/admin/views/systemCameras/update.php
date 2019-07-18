<?php
/* @var $this SystemCamerasController */
/* @var $model SystemCameras */

$this->breadcrumbs=array(
    Yii::t('admin/systemcamera','System Camera')=>array('index'),
    Yii::t('admin/systemcamera','Update'),
);
?>

    <h1><?php echo Yii::t('admin/systemcamera','Update System Camera').' <b><i>'.$model->description_camera.'</i></b>'; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>