<?php
/* @var $this CallsTypeController */
/* @var $model CallsType */

$this->breadcrumbs=array(
	'Calls Types'=>array('index'),
	$model->id_call_type=>array('view','id'=>$model->id_call_type),
	'Update',
);

$this->menu=array(
	array('label'=>'List CallsType', 'url'=>array('index')),
	array('label'=>'Create CallsType', 'url'=>array('create')),
	array('label'=>'View CallsType', 'url'=>array('view', 'id'=>$model->id_call_type)),
	array('label'=>'Manage CallsType', 'url'=>array('admin')),
);
?>

<h1>Update CallsType <?php echo $model->description; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>