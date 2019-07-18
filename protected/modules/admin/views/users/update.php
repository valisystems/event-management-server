<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id_user=>array('view','id'=>$model->id_user),
	'Update',
);
?>
<h1><?php echo Yii::t('admin/users', 'Update Users ').' <b><i>'.$model->first_name.' '.$model->last_name."</i></b>"; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>