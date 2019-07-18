<?php
/* @var $this AsteriskController */
/* @var $model Asterisk */

$this->breadcrumbs=array(
	'Devices'=>array('index'),
	'Create',
);
?>

<h1><?php echo Yii::t('admin/devices', 'Create Device')?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>