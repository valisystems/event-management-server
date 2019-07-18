<?php
/* @var $this AsteriskController */
/* @var $model Asterisk */

$this->breadcrumbs=array(
	'Devices'=>array('index'),
	'Create',
);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/assets/css/modules/admin/pages/positioning.css');
?>

<h1><?php echo Yii::t('admin/devices', 'Create Device')?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>