<?php
/* @var $this SystemEmailController */
/* @var $model SystemEmail */

$this->breadcrumbs=array(
	Yii::t('admin/systememail','System Emails')=>array('index'),
	Yii::t('admin/systememail','Update'),
);
?>

<h1><?php echo Yii::t('admin/systememail','Update System Email').' <b><i>'.$model->description_email.'</i></b>'; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>