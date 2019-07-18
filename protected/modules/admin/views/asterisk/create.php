<?php
/* @var $this AsteriskController */
/* @var $model Asterisk */

$this->breadcrumbs=array(
	'Node'=>array('index'),
	'Create',
);
?>

<h1>Create Node</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>