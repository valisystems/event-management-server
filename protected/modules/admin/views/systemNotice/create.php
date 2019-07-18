<?php
/* @var $this SystemNoticeController */
/* @var $model SystemNotice */

$this->breadcrumbs=array(
	'System Notices'=>array('index'),
	'Create',
);

?>

<h1><?php echo Yii::t('admin/systemnotice', 'Create System Notice');?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>