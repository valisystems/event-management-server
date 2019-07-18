<?php
/* @var $this BuildingsController */
/* @var $model Buildings */

$this->breadcrumbs=array(
	'Buildings'=>array('index'),
	$model->name,
);
?>

<h1>View Buildings #<?php echo $model->id_building; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_building',
		'name',
		'address',
	),
)); ?>
