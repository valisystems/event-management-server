<?php
/* @var $this CustomLinksController */
/* @var $model CustomLinks */
/* @var $form CActiveForm */
$this->breadcrumbs=array(
	'Custom Links'=>array('index'),
	'Create',
);
?>

<h1><?php echo Yii::t('admin/command', 'Create Custom Links')?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>