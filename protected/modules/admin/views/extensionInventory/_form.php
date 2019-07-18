<?php
/* @var $this ExtensionInventoryController */
/* @var $model ExtensionInventory */
/* @var $form CActiveForm */

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'extension-inventory-form',
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

	<!--p class="note">Fields with <span class="required">*</span> are required.</p-->

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<div class="col-lg-6">
			<label class="control-label" for="name_map"><?php echo $form->labelEx($model,'id_building'); ?></label>
			<div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-institution"></i>
                    </span>
				<div class="controls">
					<?php
					echo $form->dropDownList($model, 'id_building', CHtml::listData(Buildings::model()->findAll(), 'id_building','name'),
						array(
							'class'=>'form-control',
							'style'=>"width: 250px;",
							//'data-rel'=>"chosen",
							'prompt' => Yii::t('admin/rooms','Select Building'),
							'ajax' => array(
								'type'=>'POST',
								'url'=>$this->createUrl('floorList'),
								//'update'=>'#'.CHtml::activeId($model, 'id_map'), // ajax updates package_id, but I want ajax update registration_id if I select item no 4
								'data'=>array('id_building'=>'js:this.value'),
								'success' => 'function(data){
                                                $("#ExtensionInventory_id_map").html(data);
                                                getSipServer();
                                            }'

							)
						)
					);
					?>
				</div>
			</div>
			<br />
			<div class="col-lg-12" style="padding: 0;">
				<?php echo $form->error($model,'id_building', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<label class="control-label" for="id_map"><?php echo $form->labelEx($model,'id_map'); ?></label>
			<div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-building-o"></i>
                    </span>
				<div class="controls">
					<?php
					echo $form->dropDownList($model, 'id_map', $model->getFloorList($model->id_building),
						array(
							'class'=>'form-control',
							'style'=>'width:250px',
							'prompt' => Yii::t('admin/rooms','Select Floor'),
						)
					);
					?>
				</div>
			</div>
			<br />
			<div class="col-lg-12" style="padding: 0;">
				<?php echo $form->error($model,'id_map', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<label class="control-label" for="id_sip_server"><?php echo $form->labelEx($model,'id_sip_server'); ?></label>
			<div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-building-o"></i>
                    </span>
				<div class="controls">
					<?php
					echo $form->dropDownList($model, 'id_sip_server', $model->getSipServer($model->id_building),
						array(
							'class'=>'form-control',
							'style'=>'width:250px',
							'prompt' => Yii::t('admin/extensioninventory','Select SIP Server')
						)
					);
					?>
				</div>
			</div>
			<br />
			<div class="col-lg-12" style="padding: 0;">
				<?php echo $form->error($model,'id_sip_server', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<label class="control-label" for="ext_number"><?php echo $form->labelEx($model,'ext_number'); ?></label>
			<div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-hotel"></i>
                    </span>
				<?php
								echo $form->textField($model,'ext_number',array('size'=>10,'maxlength'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/rooms', 'Extension Number'))); ?>
			</div>
			<br />
			<div class="col-lg-12" style="padding: 0;">
				<?php echo $form->error($model,'ext_number', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<label class="control-label" for="password"><?php echo $form->labelEx($model,'password'); ?></label>
			<div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-hotel"></i>
                    </span>
				<?php echo $form->textField($model,'password',array('size'=>10,'maxlength'=>100, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/rooms', 'Password'))); ?>
			</div>
			<br />
			<div class="col-lg-12" style="padding: 0;">
				<?php echo $form->error($model,'password', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<label class="control-label" for="caller_id_internal"><?php echo $form->labelEx($model,'caller_id_internal'); ?></label>
			<div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-hotel"></i>
                    </span>
				<?php echo $form->textField($model,'caller_id_internal',array('size'=>10,'maxlength'=>100, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/rooms', 'Caller ID Internal'))); ?>
			</div>
			<br />
			<div class="col-lg-12" style="padding: 0;">
				<?php echo $form->error($model,'caller_id_internal', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<label class="control-label" for="caller_id_external"><?php echo $form->labelEx($model,'caller_id_external'); ?></label>
			<div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-hotel"></i>
                    </span>
				<?php echo $form->textField($model,'caller_id_external',array('size'=>10,'maxlength'=>100, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/rooms', 'Caller ID External'))); ?>
			</div>
			<br />
			<div class="col-lg-12" style="padding: 0;">
				<?php echo $form->error($model,'caller_id_external', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<label class="control-label" for="caller_id_name"><?php echo $form->labelEx($model,'caller_id_name'); ?></label>
			<div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-hotel"></i>
                    </span>
				<?php echo $form->textField($model,'caller_id_name',array('size'=>10,'maxlength'=>100, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/rooms', 'Caller ID Name'))); ?>
			</div>
			<br />
			<div class="col-lg-12" style="padding: 0;">
				<?php echo $form->error($model,'caller_id_name', array('class' => 'alert alert-danger')); ?>
			</div>
		</div>
	</div>
	<!--div>
		<label class="control-label" for="extension_define"><?php echo $form->labelEx($model,'extension_define'); ?></label>
		<div class="row checkbox">
			<?php echo $form->checkBox($model,"extension_define",  array("data-toggle" => "toggle")); ?>
		</div>
	</div-->

	<div class="row buttons">
		<?php
		echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
		echo "&nbsp;&nbsp;&nbsp;";
		echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->