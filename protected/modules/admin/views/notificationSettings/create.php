<?php
/* @var $this NotificationSettingsController */
/* @var $model NotificationSettings */

$this->breadcrumbs=array(
	'Notification Settings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NotificationSettings', 'url'=>array('index')),
	array('label'=>'Manage NotificationSettings', 'url'=>array('admin')),
);
?>

<h1>Create NotificationSettings</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>