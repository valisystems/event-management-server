<?php
/* @var $this BuildingsController */
/* @var $model Buildings */
/* @var $form CActiveForm */
?>
<div class="col-lg-6 col-sm-6">
<div class="form-group">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'buildings-form',
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

	<p class="note"><?php echo Yii::t('admin/buildings', 'Fields with <span class="required">*</span> are required.');?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="name"><?php echo $form->labelEx($model,'name'); ?></label>
    		<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-comment-o"></i>
                </span>
                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div>
    		<?php echo $form->error($model,'name'); ?>
        </div>
	</div>

	<div class="row">
        <div class="col-lg-6">
    		<label class="control-label" for="name"><?php echo $form->labelEx($model,'address'); ?></label>
    		<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-comment-o"></i>
                </span>
                <?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>150, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div>
    		<?php echo $form->error($model,'address'); ?>
        </div>
	</div>
    <br/>
	<div class="row buttons">
        <div class="col-lg-6">
        <?php
            echo CHtml::link( Yii::t('admin/buildings','Back'), array( 'index' ), array('class' => 'btn btn-primary',));
            echo "&nbsp;&nbsp;&nbsp;";
            echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin/buildings','Create') : Yii::t('admin/buildings','Save'), array('class'=>'btn btn-primary',)); ?>
        </div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div> <!-- div column col-lg-6 col-sm-6 -->