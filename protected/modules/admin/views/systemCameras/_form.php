<?php
/* @var $this SystemCamerasController */
/* @var $model SystemCameras */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'system-cameras--form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	)
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<div class=" col-lg-6">
			<?php echo $form->errorSummary($model, null, null, array('class'=>'alert alert-danger')); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<label class="control-label" for="description_camera"><?php echo $form->labelEx($model,'description_camera'); ?></label>
			<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-camera-retro"></i>
                </span>
				<?php echo $form->textField($model,'description_camera',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
			</div><br />
			<?php echo $form->error($model,'description_camera', array('class' => 'alert alert-danger')); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<label class="control-label" for="name_camera"><?php echo $form->labelEx($model,'name_camera'); ?></label>
			<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-eye-slash"></i>
                </span>
				<?php echo $form->textField($model,'name_camera',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
			</div><br />
			<?php echo $form->error($model,'name_camera', array('class' => 'alert alert-danger')); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<label class="control-label" for="url_camera"><?php echo $form->labelEx($model,'url_camera'); ?></label>
			<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-camera"></i>
                </span>
				<?php echo $form->textField($model,'url_camera',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
			</div><br />
			<?php echo $form->error($model,'url_camera', array('class' => 'alert alert-danger')); ?>
		</div>
	</div>
	<div class="row buttons">
		<div class="col-lg-6">
			<?php
			echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
			echo "&nbsp;&nbsp;&nbsp;";
			echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary',));
			?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->