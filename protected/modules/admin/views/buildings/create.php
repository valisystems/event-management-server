<?php
/* @var $this BuildingsController */
/* @var $model Buildings */

$this->breadcrumbs=array(
	Yii::t('admin/buildings','Buildings')=>array('index'),
	'Create',
);
?>

<h1><?php echo Yii::t('admin/buildings','Create Buildings');?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>