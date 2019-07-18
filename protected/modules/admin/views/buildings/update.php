<?php
/* @var $this BuildingsController */
/* @var $model Buildings */

$this->breadcrumbs=array(
	Yii::t('admin/buildings','Buildings')=>array('index'),
	$model->name=>array('view','id'=>$model->id_building),
	Yii::t('admin/buildings','Update'),
);

?>

<h1><?php echo Yii::t('admin/buildings','Update Buildings');?> <b><i><?php echo $model->name; ?></i></b></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>