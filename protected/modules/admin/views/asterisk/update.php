<?php
/* @var $this AsteriskController */
/* @var $model Asterisk */

$this->breadcrumbs=array(
	Yii::t('admin/asterisk', 'Nodes')=>array('index'),
	$model->asterisk_name=>array('view','id'=>$model->asterisk_name),
	'Update',
);

?>

<h1><?php echo Yii::t('admin/asterisk', 'Update Nodes').' <b><i>'.$model->asterisk_name.'</i></b>'; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>