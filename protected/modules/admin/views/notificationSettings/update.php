<?php
/* @var $this NotificationSettingsController */
/* @var $model NotificationSettings */

$this->breadcrumbs=array(
	'Notification Settings'=>array('index'),
	$model->id_notification_setting=>array('view','id'=>$model->id_notification_setting),
	'Update',
);
?>

<h1>Update NotificationSettings <?php echo $model->id_notification_setting; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>