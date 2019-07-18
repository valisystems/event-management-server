<?php
/* @var $this ExtensionInventoryController */
/* @var $model ExtensionInventory */

$this->breadcrumbs=array(
	'Extension Inventories'=>array('index'),
	$model->id_extension=>array('view','id'=>$model->id_extension),
	'Update',
);

$this->menu=array(
	array('label'=>'List ExtensionInventory', 'url'=>array('index')),
	array('label'=>'Create ExtensionInventory', 'url'=>array('create')),
	array('label'=>'View ExtensionInventory', 'url'=>array('view', 'id'=>$model->id_extension)),
	array('label'=>'Manage ExtensionInventory', 'url'=>array('admin')),
);
?>

<h1>Update ExtensionInventory <?php echo $model->id_extension; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>