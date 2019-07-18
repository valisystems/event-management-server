<?php
/* @var $this MapsController */
/* @var $model Maps */

$this->breadcrumbs=array(
	Yii::t('admin/maxivox', 'MaxiVox Device')=>array('index'),
	$model->dev_desc=>array('view','id'=>$model->id_maxivox_device),
	'Update',
);
?>
<h1><?php echo Yii::t('admin/maxivox', 'Update MaxiVox Device')?> <b><i><?php echo $model->dev_desc; ?></i></b></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>