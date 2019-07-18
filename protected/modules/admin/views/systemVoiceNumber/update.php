<?php
/* @var $this SystemVoiceNumberController */
/* @var $model SystemVoiceNumber */

$this->breadcrumbs=array(
	'System Voice Numbers'=>array('index'),
	$model->description_voice_number=>array('view','id'=>$model->id_system_voice_number),
	'Update',
);

?>

<h1><?php echo Yii::t('admin/systemvoicenumber', 'Update System voice number').' <i><b>'.$model->description_voice_number.'</b></i>'; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>