<?php
/* @var $this ExtensionInventoryController */
/* @var $model ExtensionInventory */

$this->breadcrumbs=array(
	'Extension Inventories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ExtensionInventory', 'url'=>array('index')),
	array('label'=>'Manage ExtensionInventory', 'url'=>array('admin')),
);
?>

<h1>Create ExtensionInventory</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>