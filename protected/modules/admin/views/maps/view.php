<?php
/* @var $this MapsController */
/* @var $model Maps */

$this->breadcrumbs=array(
	'Maps'=>array('index'),
	$model->id_map,
);

$this->menu=array(
	array('label'=>'List Maps', 'url'=>array('index')),
	array('label'=>'Create Maps', 'url'=>array('create')),
	array('label'=>'Update Maps', 'url'=>array('update', 'id'=>$model->id_map)),
	array('label'=>'Delete Maps', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_map),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Maps', 'url'=>array('admin')),
);
?>

<h1>View Maps #<?php echo $model->id_map; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_map',
		'name_map',
		'description',
		'id_building',
		'path_to_img',
	),
)); ?>
