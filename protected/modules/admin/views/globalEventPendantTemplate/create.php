<?php
/* @var $this GlobalEventTemplateController */
/* @var $model GlobalEventTemplate */

$this->breadcrumbs=array(
	Yii::t('admin/globalevent','Global Event Templates')=>array('index'),
	Yii::t('admin/globalevent','Create'),
);

?>

<h1><?php echo Yii::t('admin/globalevent','Create Global Event Pendant Templates');?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>