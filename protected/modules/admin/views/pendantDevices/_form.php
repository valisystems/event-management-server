<?php
/* @var $this CallsTypeController */
/* @var $model CallsType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'calls-type-form',
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
    <br />
	<div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="description"><?php echo $form->labelEx($model,Yii::t('admin/callstype','Description')); ?></label>
    		<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-info"></i>
                </span>
                <?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>150, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
    		<?php echo $form->error($model,'description', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>
    <br/>
	<div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="script"><?php echo $form->labelEx($model,'serial_number'); ?></label>
    		<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-flag-o"></i>
                </span>
                <?php echo $form->textField($model,'serial_number',array('size'=>60,'maxlength'=>150, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <?php echo $form->error($model,'serial_number', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>
    <br/>
	<div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="priority"><?php echo $form->labelEx($model,'id_pendant_type'); ?></label>
    		<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-gear"></i>
                </span>
                <?php
                    echo $form->dropDownList($model, 'id_pendant_type',CHtml::listData(PendantType::model()->findAll(), 'id_pendant_type','description'), array('class'=>'form-control','style'=>"width: 150px", 'empty'=>'--- Choose---'));
                ?>
            </div><br />
            <?php echo $form->error($model,'priority', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>
    <br/>
    <div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="priority"><?php echo $form->labelEx($model,'id_patient'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-wheelchair"></i>
                </span>
                <?php
                echo $form->dropDownList($model, 'id_patient',CHtml::listData(Patients::model()->findAll(), 'id_patient','patientName'), array('class'=>'form-control','style'=>"width: 150px", 'empty'=>'--- Choose---', 'data-rel'=>"chosen"));
                ?>
            </div><br />
            <?php echo $form->error($model,'priority', array('class' => 'alert alert-danger')); ?>
        </div>
    </div>
    <br/>
	<div class="row buttons">
		<div class="col-lg-6">
        <?php
            echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
            echo "&nbsp;&nbsp;&nbsp;";
            echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary', 'id'=>'saveCallType')); ?>
        </div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->