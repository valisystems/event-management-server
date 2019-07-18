<?php
/* @var $this GlobalEventTemplateController */
/* @var $model GlobalEventTemplate */

$this->breadcrumbs=array(
	Yii::t('admin/maxivox','Global Event Maxivox Templates')=>array('index'),
	Yii::t('admin/maxivox','Create'),
);

?>

<h1><?php echo Yii::t('admin/maxivox','Create Global Event MaxiVox Templates');?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>