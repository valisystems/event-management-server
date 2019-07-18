<?php
/* @var $this SystemVoiceNumberController */
/* @var $model SystemVoiceNumber */

$this->breadcrumbs=array(
	'System Voice Numbers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SystemVoiceNumber', 'url'=>array('index')),
	array('label'=>'Manage SystemVoiceNumber', 'url'=>array('admin')),
);
?>

<h1>Create SystemVoiceNumber</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>