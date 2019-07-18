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
    <?php echo $form->hiddenField($model,'id_maxivox_type',array('id'=>'id_maxivox_type')); ?>
    <input type="hidden" name="old_maxivox_type" id="old_maxivox_type" value="<?php echo $model->script;?>"/>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
    <div class="row">
    	<div class=" col-lg-6">
            <?php echo $form->errorSummary($model,null, null,array('class'=>'alert alert-danger')); ?>
        </div>
    </div>
    <br />
	<div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="description"><?php echo $form->labelEx($model,Yii::t('admin/maxivox','Description')); ?></label>
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
            <label class="control-label" for="script"><?php echo $form->labelEx($model,'script'); ?></label>
    		<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-spinner"></i>
                </span>
                <?php echo $form->textField($model,'script',array('size'=>60,'maxlength'=>150, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <?php echo $form->error($model,'script', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>
    <br/>
	<div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="priority"><?php echo $form->labelEx($model,Yii::t('admin/maxivox','Priority')); ?></label>
    		<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-bolt"></i>
                </span>
                <?php
                    echo $form->dropDownList($model, 'priority',array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10'), array('class'=>'form-control','style'=>"width: 75px"));
                ?>
            </div><br />
            <?php echo $form->error($model,'priority', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>
    <br/>
	<div class="row">
        <div class="col-lg-2">
            <label class="control-label" for="color_hex"><?php echo $form->labelEx($model,Yii::t('admin/maxivox','Color')); ?></label>
            <div id="colorPicker">
                <a class="color"><div class="colorInner" <?php if (isset($model->color_hex) && !empty($model->color_hex)) { echo "style='background-color:".$model->color_hex."';";}?>></div></a>
                <div class="track"></div>
                <ul class="dropdown"><li></li></ul>
                <?php echo $form->hiddenField($model,'color_hex', array('class'=> 'colorInput'));?>
            </div>
            <?php echo $form->error($model,'color_hex', array('class' => 'alert alert-danger')); ?>
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