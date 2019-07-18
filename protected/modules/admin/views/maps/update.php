<?php
/* @var $this MapsController */
/* @var $model Maps */

$this->breadcrumbs=array(
	'Maps'=>array('index'),
	$model->id_map=>array('view','id'=>$model->id_map),
	'Update',
);

$this->menu=array(
	array('label'=>'List Maps', 'url'=>array('index')),
	array('label'=>'Create Maps', 'url'=>array('create')),
	array('label'=>'View Maps', 'url'=>array('view', 'id'=>$model->id_map)),
	array('label'=>'Manage Maps', 'url'=>array('admin')),
);
?>

<h1>Update Maps <?php echo $model->id_map; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>