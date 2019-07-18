<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
    )
)); 
$urlAuthConf = require(Yii::getPathOfAlias('application.config.auth').'.php');
$authArray = array();

foreach ($urlAuthConf as $v) {
    $authArray[$v['abreviation']] = $v['description'];
}
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
    	<div class=" col-lg-6">
            <?php echo $form->errorSummary($model,null, null,array('class'=>'alert alert-danger')); ?>
        </div>
    </div>

	<div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="first_name"><?php echo $form->labelEx($model,'first_name'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>
                <?php echo $form->textField($model,'first_name',array('size'=>50,'maxlength'=>50, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <div>
                <?php echo $form->error($model,'first_name', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>

		<div class="col-lg-6">
            <label class="control-label" for="last_name"><?php echo $form->labelEx($model,'last_name'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>
                <?php echo $form->textField($model,'last_name',array('size'=>50,'maxlength'=>50, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <div>
                <?php echo $form->error($model,'last_name', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
	</div>

	<div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="login_name"><?php echo $form->labelEx($model,'login_name'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-key"></i>
                </span>
                <?php echo $form->textField($model,'login_name',array('size'=>50,'maxlength'=>50, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <div>
                <?php echo $form->error($model,'login_name', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
		<div class="col-lg-6">
            <label class="control-label" for="passwd"><?php echo $form->labelEx($model,'passwd'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-user-secret"></i>
                </span>
                <?php echo $form->passwordField($model,'passwd',array('size'=>60,'maxlength'=>100, 'class'=>'form-control', 'style'=>'width:250px', 'value'=> '')); ?>
            </div><br />
            <div>
                <?php echo $form->error($model,'passwd', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
	</div>

	<div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="passwd"><?php echo $form->labelEx($model,'role'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-user-secret"></i>
                </span>
                <div class="controls">
                    <?php
                        echo $form->dropDownList($model, 'role', $authArray, array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen"));
                    ?>
                </div>
            </div><br/>
            <div>
                <?php echo $form->error($model,'role', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
		<div class="col-lg-6">
            <label class="control-label" for="email"><?php echo $form->labelEx($model,'email'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                </span>
                <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>80, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <div>
                <?php echo $form->error($model,'email', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
	</div>

	<div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="phone"><?php echo $form->labelEx($model,'phone'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-tty"></i>
                </span>
                <?php echo $form->textField($model,'phone',array('size'=>15,'maxlength'=>15, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <div>
                <?php echo $form->error($model,'phone', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
		<div class="col-lg-6">
            <label class="control-label" for="company"><?php echo $form->labelEx($model,'company'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-bank"></i>
                </span>
                <?php echo $form->textField($model,'company',array('size'=>50,'maxlength'=>50, 'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
            <div>
                <?php echo $form->error($model,'company', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
	</div>

	<div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="phone"><?php echo $form->labelEx($model,'reports'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-area-chart"></i>
                </span>
                <?php echo $form->radioButtonList($model,'reports',array('1'=>'Yes', '0' => 'No'), array('separator'=>'  ')); ?>
            </div><br />
            <div>
                <?php echo $form->error($model,'reports', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>

		<div class="col-lg-6">
            <label class="control-label" for="phone"><?php echo $form->labelEx($model,'status'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-plug"></i>
                </span>
                <?php echo $form->radioButtonList($model,'status',array('1'=>'Yes', '0' => 'No'), array('separator'=>'  ')); ?>
            </div><br />
            <div>
                <?php echo $form->error($model,'status', array('class' => 'alert alert-danger')); ?>
            </div>
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