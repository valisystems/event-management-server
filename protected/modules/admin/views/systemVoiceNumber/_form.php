<?php
/* @var $this SystemVoiceNumberController */
/* @var $model SystemVoiceNumber */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'system-voice-number-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
    )
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model,null, null,array('class'=>'alert alert-danger')); ?>

	<div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="description_voice_number"><?php echo $form->labelEx($model,Yii::t('admin/systemvoicenumber','description_voice_number')); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-info"></i>
                </span>
                <?php echo $form->textField($model,'description_voice_number',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <?php echo $form->error($model,'description_voice_number', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>

	<div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="name_voice_number"><?php echo $form->labelEx($model,'name_voice_number'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-file-word-o"></i>
                </span>
                <?php echo $form->textField($model,'name_voice_number',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <?php echo $form->error($model,'name_voice_number', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>

	<div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="number_to_call"><?php echo $form->labelEx($model,'number_to_call'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-tty"></i>
                </span>
                <?php echo $form->textField($model,'number_to_call',array('size'=>11,' maxlength'=>15, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <?php echo $form->error($model,'number_to_call', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>
    <br/>
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