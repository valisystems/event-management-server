<?php
/* @var $this RoomsController */
/* @var $model Rooms */

$this->breadcrumbs=array(
	'Device'=>array('index'),
	'Create',
);
?>

<h1>Create Room</h1>
<?
echo $this->renderPartial('_add', array('model'=>$model));
?>