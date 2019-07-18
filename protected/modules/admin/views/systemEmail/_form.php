<?php
/* @var $this SystemEmailController */
/* @var $model SystemEmail */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'system-email-form',
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

	<div class="row">
    	<div class=" col-lg-6">
            <?php echo $form->errorSummary($model, null, null, array('class'=>'alert alert-danger')); ?>
        </div>
    </div>

	<div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="description_email"><?php echo $form->labelEx($model,'description_email'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-info"></i>
                </span>
                <?php echo $form->textField($model,'description_email',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <?php echo $form->error($model,'description_email', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>

	<div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="name_email"><?php echo $form->labelEx($model,'name_email'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-envelope-o"></i>
                </span>
                <?php echo $form->textField($model,'name_email',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <?php echo $form->error($model,'name_email', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>

	<div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="email"><?php echo $form->labelEx($model,'email'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-send"></i>
                </span>
                <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <?php echo $form->error($model,'email', array('class' => 'alert alert-danger')); ?>
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