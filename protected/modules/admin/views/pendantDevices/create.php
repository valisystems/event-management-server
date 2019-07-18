<?php
/* @var $this CallsTypeController */
/* @var $model CallsType */

$this->breadcrumbs=array(
	'Pendant Devices'=>array('index'),
	'Create',
);

?>

<h1><?php echo Yii::t('admin/pendantDevices','Create Pendant devices');?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>