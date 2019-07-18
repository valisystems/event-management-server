<?php
/* @var $this GlobalMessagesController */
/* @var $model GlobalMessages */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'global-messages-form',
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
            <?php echo $form->errorSummary($model,null, null,array('class'=>'alert alert-danger')); ?>
        </div>
    </div>

	<div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="global_description"><?php echo $form->labelEx($model,Yii::t('admin/globalmessages','Description')); ?></label>
    		<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-info"></i>
                </span>
                <?php echo $form->textField($model,'global_description',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
		  <?php echo $form->error($model,'global_description', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>

	<div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="global_subject"><?php echo $form->labelEx($model,'global_subject'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-cc"></i>
                </span>
                <?php echo $form->textField($model,'global_subject',array('size'=>60,'maxlength'=>100, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <?php echo $form->error($model,'global_subject', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>

	<div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="global_subject"><?php echo $form->labelEx($model,'global_text'); ?></label>
            <div class="form-group hidden-xs">
                <?php echo $form->textArea($model,'global_text',array('rows'=>6, 'cols'=>50, 'class'=>'cleditor')); ?>
            </div><br />
            <?php echo $form->error($model,'global_text', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>
    <div class="row">
        <label class="control-label"><?php echo Yii::t('admin/globalmessages','Pattern'); ?></label><br/>
        <?php
            foreach (Yii::app()->params['pattern'] as $k=>$l) {
                echo "<b>{$k}</b> - {$l}<br/>";
            }
        ?>
    </div>

	<div class="row buttons">
		<div class="col-lg-6">
        <?php
            echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
            echo "&nbsp;&nbsp;&nbsp;";
            echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary',)); ?>
        </div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->