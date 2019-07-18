<?php
/* @var $this RoomsController */
/* @var $model Rooms */

$this->breadcrumbs=array(
	'Rooms'=>array('index'),
	"#{$model->nb_room}" => array('view','id'=>$model->id_room)
);
?>

<h1>Update Rooms <b>#<?php echo $model->nb_room; ?></b></h1>

<?php $this->renderPartial('_update', array('model'=>$model)); ?>