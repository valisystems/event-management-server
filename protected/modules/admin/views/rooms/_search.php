<?php
/* @var $this RoomsController */
/* @var $model Rooms */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_room'); ?>
		<?php echo $form->textField($model,'id_room'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nb_room'); ?>
		<?php echo $form->textField($model,'nb_room',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nb_of_seats'); ?>
		<?php echo $form->textField($model,'nb_of_seats'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'coordinate_on_map'); ?>
		<?php echo $form->textField($model,'coordinate_on_map',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_map'); ?>
		<?php echo $form->textField($model,'id_map'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->