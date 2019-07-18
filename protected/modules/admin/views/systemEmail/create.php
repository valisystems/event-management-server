<?php
/* @var $this SystemEmailController */
/* @var $model SystemEmail */

$this->breadcrumbs=array(
	'System Emails'=>array('index'),
	'Create',
);
?>

<h1><?php echo Yii::t('admin/systememail', 'Create System Email');?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>