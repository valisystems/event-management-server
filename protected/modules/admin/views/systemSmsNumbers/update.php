<?php
/* @var $this SystemSmsNumbersController */
/* @var $model SystemSmsNumbers */

$this->breadcrumbs=array(
	'System SMS Numbers'=>array('index'),
	'Update',
);
?>

<h1> <?php echo Yii::t('admin/systemsmsnumber','Update System SMS Numbers')." <b><i>".$model->description_sms.'</i></b>'; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>