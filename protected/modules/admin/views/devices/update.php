<?php
/* @var $this MapsController */
/* @var $model Maps */

$this->breadcrumbs=array(
	'Positioning'=>array('index'),
	$model->device_description=>array('view','id'=>$model->id_device),
	'Update',
);
?>
<h1><?php echo Yii::t('admin/devices', 'Update Device')?> <b><i><?php echo $model->device_description; ?></i></b></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>