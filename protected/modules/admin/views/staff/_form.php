<?php
/* @var $this StaffController */
/* @var $model Staff */
/* @var $form CActiveForm */
?>
<style>
	.toggle-handle.btn {
		background: #FFF;
	}
</style>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'staff-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<!--p class="note">Fields with <span class="required">*</span> are required.</p-->

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="col-lg-4">
			<label class="control-label" for="first_name"><?php echo $form->labelEx($model,'first_name'); ?></label>
			<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>
				<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
			</div><br />
			<?php echo $form->error($model,'first_name', array('class' => 'alert alert-danger')); ?>
		</div>
		<div class="col-lg-6">
			<label class="control-label" for="last_name"><?php echo $form->labelEx($model,'last_name'); ?></label>
			<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-user-secret"></i>
                </span>
				<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
			</div><br />
			<?php echo $form->error($model,'last_name', array('class' => 'alert alert-danger')); ?>
		</div>
	</div>


	<div class="row">
		<div class="col-lg-4">
			<label class="control-label" for="birth_day"><?php echo $form->labelEx($model,'birth_day'); ?></label>
			<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
				<?php echo $form->textField($model,'birth_day',array('size'=>60,'maxlength'=>250, 'class'=>'form-control datepicker', 'style'=>'width:250px', 'data-date-format'=>"yyyy-mm-dd")); ?>
			</div><br />
			<?php echo $form->error($model,'birth_day', array('class' => 'alert alert-danger')); ?>
		</div>
		<div class="col-lg-6">
			<label class="control-label" for="avatar_path"><?php echo $form->labelEx($model,'avatar_path'); ?></label>
			<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                                <i class="fa  fa-picture-o"></i>
                            </span>
				<?php echo $form->hiddenField($model,'avatar_path'); ?>
				<?php
				$this->widget('ext.EFineUploader.EFineUploader',
					array(
						'id'=>'FineUploader',
						'config'=>array(
							'autoUpload'=>true,
							'request'=>array(
								'endpoint'=>$this->createUrl('staff/saveimage'),// OR $this->createUrl('files/upload'),
								'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
							),
							'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
							'chunking'=>array('enable'=>true,'partSize'=>50),//bytes
							'validation'=>array(
								'allowedExtensions'=>array('jpg','jpeg', 'bmp', 'gif', 'png'),
								'sizeLimit'=>6 * 1024 * 1024,//maximum file size in bytes
								'minSizeLimit'=>0.001*1024*1024,// minimum file size in bytes
							),
							'callbacks'=>array(
								'onComplete'=>"js:function(id, name, response){ // for test purpose
                                                 $('#Staff_avatar_path').val(response.filename);
                                                 $('#imgLogo').html('<img class=\"img-responsive img-thumbnail\" src=\"".Yii::app()->baseUrl."/upload/temp/'+response.filename+'\" width=\"150\">');
                                               }",
								//'onError'=>"js:function(id, name, errorReason){ }",
								'onValidateBatch' => "js:function(fileOrBlobData) {}", // because of crash
							),
						),

					)
				);
				?>
			</div><br />
			<div id="imgLogo"></div>
			<?php echo $form->error($model,'avatar_path', array('class' => 'alert alert-danger')); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-4">
			<div>
				<label class="control-label" for="position"><?php echo $form->labelEx($model,'position'); ?></label>
				<div class="input-group date col-sm-4">
					<span class="input-group-addon">
						<i class="fa fa-camera-retro"></i>
					</span>
					<?php echo $form->textField($model,'position',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
				</div><br />
				<?php echo $form->error($model,'position', array('class' => 'alert alert-danger')); ?>
			</div>
			<div>
				<label class="control-label" for="personal_id"><?php echo $form->labelEx($model,'personal_id'); ?></label>
				<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-indent"></i>
                </span>
					<?php echo $form->textField($model,'personal_id',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
				</div><br />
				<?php echo $form->error($model,'personal_id', array('class' => 'alert alert-danger')); ?>
			</div>
			<div>
				<label class="control-label" for="pin_code"><?php echo $form->labelEx($model,'pin_code'); ?></label>
				<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa fa-key"></i>
                </span>
					<?php echo $form->textField($model,'pin_code',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
				</div><br />
				<?php echo $form->error($model,'pin_code', array('class' => 'alert alert-danger')); ?>
			</div>
			<div>
				<label class="control-label" for="staff_status"><?php echo $form->labelEx($model,'staff_status'); ?></label>
				<div class="row checkbox">
					<?php echo $form->checkBox($model,"staff_status",  array("data-toggle" => "toggle")); ?>
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div>
				<div class="row">
					<label class="control-label" for="id_building"><?php echo $form->labelEx($model,'id_building'); ?></label>
					<div class="input-group date col-sm-4">
                            <span class="input-group-addon">
                                <i class="fa  fa-building-o"></i>
                            </span>
						<?php
						echo $form->dropDownList($model, 'id_building', CHtml::listData(Buildings::model()->findAll(), 'id_building','name'),
							array(
								'class'=>'form-control',
								'style'=>"width: 250px;",
								//'data-rel'=>"chosen",
								'prompt' => Yii::t('admin/patients','Select Building'),
							)
						);
						?><br />
					</div>
					<div class="col-lg-6">
						<?php echo $form->error($model,'id_building', array('class' => 'alert alert-danger')); ?>
					</div>
				</div>
			</div><br/>
			<div>
				<div class="row">
					<label class="control-label" for="description"><?php echo $form->labelEx($model,'description'); ?></label>
					<div class="input-group date col-sm-4">
						<span class="input-group-addon">
							<i class="fa fa-camera-retro"></i>
						</span>
						<?php echo $form->textArea($model,'description',array('class'=>'cleditor','id'=>'footer')); ?>
					</div><br />
					<?php echo $form->error($model,'description', array('class' => 'alert alert-danger')); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row">

	</div>
	<div class="row buttons">
		<?php
		echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
		echo "&nbsp;&nbsp;&nbsp;";
		echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->