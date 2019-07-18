<?php
/* @var $this SystemNoticeController */
/* @var $model SystemNotice */

$this->breadcrumbs=array(
	'System Notices'=>array('index'),
	'Update',
);

?>

<h1> <?php echo Yii::t('admin/systemnotice', 'Update System Notice').' <b><i>'.$model->description_notice.'</i></b>'; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>