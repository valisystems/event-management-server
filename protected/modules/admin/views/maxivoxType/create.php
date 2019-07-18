<?php
/* @var $this CallsTypeController */
/* @var $model CallsType */

$this->breadcrumbs=array(
	'MaxiVox Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MaxiVox Type', 'url'=>array('index')),
	array('label'=>'Manage Maxivox Type', 'url'=>array('admin')),
);
?>

<h1>Create MaxiVox Type</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>