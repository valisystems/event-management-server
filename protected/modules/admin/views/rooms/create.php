<?php
/* @var $this RoomsController */
/* @var $model Rooms */

$this->breadcrumbs=array(
	'Rooms'=>array('index'),
	'Create',
);
?>

<h1>Create Room</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>