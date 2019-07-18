<?php
/* @var $this CallsTypeController */
/* @var $model CallsType */

$this->breadcrumbs=array(
	'Calls Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CallsType', 'url'=>array('index')),
	array('label'=>'Manage CallsType', 'url'=>array('admin')),
);
?>

<h1>Create CallsType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>