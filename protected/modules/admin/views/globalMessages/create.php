<?php
/* @var $this GlobalMessagesController */
/* @var $model GlobalMessages */

$this->breadcrumbs=array(
	'Global Messages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GlobalMessages', 'url'=>array('index')),
	array('label'=>'Manage GlobalMessages', 'url'=>array('admin')),
);
?>

<h1>Create GlobalMessages</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>