<?php
/* @var $this MapsController */
/* @var $model Maps */

$this->breadcrumbs=array(
	'Devices'=>array('index'),
	$model->device_description=>array('index'),
	'Update',
);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/assets/css/modules/admin/pages/positioning.css');
?>
<h1><?php echo Yii::t('admin/devices', 'Update Device')?> <b><i><?php echo $model->device_description; ?></i></b></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'modelInput' => $modelInput)); ?>