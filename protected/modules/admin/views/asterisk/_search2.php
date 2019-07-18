<?php
/* @var $this AsteriskController */
/* @var $model Asterisk */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_asterisk'); ?>
		<?php echo $form->textField($model,'id_asterisk',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'asterisk_name'); ?>
		<?php echo $form->textField($model,'asterisk_name',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'asterisk_url'); ?>
		<?php echo $form->textField($model,'asterisk_url',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_building'); ?>
		<?php echo $form->textField($model,'id_building',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'limit_of_ext'); ?>
		<?php echo $form->textField($model,'limit_of_ext'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->