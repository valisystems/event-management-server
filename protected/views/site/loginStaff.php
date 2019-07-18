<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>
<div class="row col-sm-4">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation"><a href="<?php echo Yii::app()->createUrl('/site/login');?>" aria-controls="general" role="tab" >General</a></li>
		<li role="presentation" class="active"><a href="#staff" aria-controls="staff">Staff</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content" style="padding: 10px 30px;">
		<div role="tabpanel" class="tab-pane  active" id="staff">
			<div class="form">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'staff-form',
					//'action' => Yii::app()->createUrl('/site/loginStaff'),
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true,
					),
				)); ?>
				<?php echo $form->hiddenField($model, 'loginMode', array('value'=>'staff')); ?>
				<p class="note">Fields with <span class="required">*</span> are required.</p>

				<div class="row">
					<?php echo $form->labelEx($model,'username'); ?>
					<?php echo $form->textField($model,'username', array('class'=>'form-control', 'style'=>'width:250px')); ?><br />
					<?php echo $form->error($model,'username', array('class' => 'alert alert-danger')); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'password'); ?>
					<?php echo $form->passwordField($model,'password', array('class'=>'form-control', 'style'=>'width:250px')); ?><br />
					<?php echo $form->error($model,'password', array('class' => 'alert alert-danger')); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'extension'); ?>
					<?php echo $form->textField($model,'extension', array('class'=>'form-control', 'style'=>'width:250px')); ?><br />
					<?php echo $form->error($model,'extension', array('class' => 'alert alert-danger')); ?>
				</div>

				<div class="row rememberMe">
					<?php echo $form->checkBox($model,'rememberMe'); ?>
					<?php echo $form->label($model,'rememberMe'); ?>
					<?php echo $form->error($model,'rememberMe'); ?>
				</div>

				<div class="row buttons">
					<?php echo CHtml::submitButton('Login', array('class' => 'btn btn-primary',)); ?>
				</div>

				<?php $this->endWidget(); ?>
			</div><!-- form -->

		</div>
	</div>

</div>


