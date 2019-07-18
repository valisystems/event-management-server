<?php
/* @var $this GlobalMessagesController */
/* @var $model GlobalMessages */

$this->breadcrumbs=array(
	Yii::t('admin/globalmessages','System Messages')=>array('index'),
	'Update',
);

?>

<h1><?php echo Yii::t('admin/globalmessages','Update System Messages');?> <b><i><?php echo $model->global_description; ?></i></b></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>