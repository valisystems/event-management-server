<?php
/* @var $this CallsTypeController */
/* @var $model CallsType */

$this->breadcrumbs=array(
	'Pendant Devices '=>array('index'),
	$model->id_pendant_device=>array('view','id'=>$model->id_pendant_device),
	'Update',
);
?>

<h1>Update Pendant Devices <?php echo $model->description; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>