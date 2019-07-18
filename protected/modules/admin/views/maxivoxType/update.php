<?php
/* @var $this CallsTypeController */
/* @var $model CallsType */

$this->breadcrumbs=array(
	'MaxiVox Types'=>array('index'),
	$model->description=>array('view','id'=>$model->id_maxivox_type),
	'Update',
);

$this->menu=array(
	array('label'=>'List MaxiVox Type', 'url'=>array('index')),
	array('label'=>'Create MaxiVox Type', 'url'=>array('create')),
	array('label'=>'View MaxiVox Type', 'url'=>array('view', 'id'=>$model->id_maxivox_type)),
	array('label'=>'Manage MaxiVox Type', 'url'=>array('admin')),
);
?>

<h1>Update MaxiVox Type <?php echo $model->description; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>