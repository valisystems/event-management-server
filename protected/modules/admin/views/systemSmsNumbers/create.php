<?php
/* @var $this SystemSmsNumbersController */
/* @var $model SystemSmsNumbers */

$this->breadcrumbs=array(
	'System SMS Numbers'=>array('index'),
	'Create',
);
?>

<h1><?php echo Yii::t('admin/systemsmsnumber', 'Create System SMS Numbers') ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>