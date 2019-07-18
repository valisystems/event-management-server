<?php
/* @var $this CallsTypeController */
/* @var $model CallsType */

$this->breadcrumbs=array(
	'Calls Types'=>array('index'),
	$model->id_pendant_type=>array('view','id'=>$model->id_pendant_type),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pendant Type', 'url'=>array('index')),
	array('label'=>'Create Pendant Type', 'url'=>array('create')),
	array('label'=>'View Pendant Type', 'url'=>array('view', 'id'=>$model->id_pendant_type)),
	array('label'=>'Manage Pendant Type', 'url'=>array('admin')),
);
?>

<h1>Update CallsType <?php echo $model->description; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>