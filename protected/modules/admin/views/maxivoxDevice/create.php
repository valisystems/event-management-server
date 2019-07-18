<?php
/* @var $this AsteriskController */
/* @var $model Asterisk */

$this->breadcrumbs=array(
	Yii::t('admin/maxivox', 'MaxiVox Devices')=>array('index'),
	Yii::t('admin/maxivox', 'Create'),
);
?>

<h1><?php echo Yii::t('admin/maxivox', 'Create MaxiVox Device')?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>