<?php
/* @var $this DevicesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Devices',
);

$this->menu=array(
	array('label'=>'Create Devices', 'url'=>array('create')),
	array('label'=>'Manage Devices', 'url'=>array('admin')),
);
?>

<h1>Devices</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
