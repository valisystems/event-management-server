<?php
/* @var $this AsteriskController */
/* @var $model Asterisk */

$this->breadcrumbs=array(
	'Asterisks'=>array('index'),
	$model->id_asterisk,
);

$this->menu=array(
	array('label'=>'List Asterisk', 'url'=>array('index')),
	array('label'=>'Create Asterisk', 'url'=>array('create')),
	array('label'=>'Update Asterisk', 'url'=>array('update', 'id'=>$model->id_asterisk)),
	array('label'=>'Delete Asterisk', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_asterisk),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Asterisk', 'url'=>array('admin')),
);
?>

<h1>View Asterisk #<?php echo $model->id_asterisk; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_asterisk',
		'asterisk_name',
		'asterisk_url',
		'id_building',
		'limit_of_ext',
	),
)); ?>
