<?php
/* @var $this PatientsController */
/* @var $model Patients */
/* @var $form CActiveForm */
?>
<?php
    $tt = time(); 
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'patients-form',
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
    <div class="container" style="">
        <div class="row">
            <div class="row step">
                <div id="div1" class="col-md-2  activestep" onclick="javascript: resetActive(event, 0, 'step-1');">
                    <span class="fa fa-user"></span>
                    <p><?php echo Yii::t('admin/patients', 'Profile');?></p>
                </div>
                <div class="col-md-2" onclick="javascript: resetActive(event, 15, 'step-2');">
                    <span class="fa fa-camera"></span>
                    <p><?php echo Yii::t('admin/patients', 'Cameras');?></p>
                </div>
                <div class="col-md-2" onclick="javascript: resetActive(event, 30, 'step-3');">
                    <span class="fa fa-pencil-square"></span>
                    <p><?php echo Yii::t('admin/patients', 'Notes');?></p>
                </div>
                <div id="last" class="col-md-2" onclick="javascript: resetActive(event, 45, 'step-4');">
                    <span class="fa fa-star"></span>
                    <p><?php echo Yii::t('admin/patients', 'Contacts');?></p>
                </div>
                <div id="last" class="col-md-2" onclick="javascript: resetActive(event, 60, 'step-5');">
                    <span class="fa fa-comment"></span>
                    <p><?php echo Yii::t('admin/patients', 'SMS');?></p>
                </div>
                <div id="last" class="col-md-2" onclick="javascript: resetActive(event, 75, 'step-6');">
                    <span class="fa fa-envelope"></span>
                    <p><?php echo Yii::t('admin/patients', 'Email');?></p>
                </div>
                <div id="last" class="col-md-2" onclick="javascript: resetActive(event, 100, 'step-7');">
                    <span class="fa fa-phone-square"></span>
                    <p><?php echo Yii::t('admin/patients', 'Voice');?></p>
                </div>
            </div>
        </div>
        <div class="row setup-content activeStepInfo" id="step-1">
            <div class="col-xs-12 well">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label" for="description_email"><?php echo $form->labelEx($model,'avatar_path'); ?></label>
                            <?php echo $form->hiddenField($model,'avatar_path'); ?>
                            <?php
                            $this->widget('ext.EFineUploader.EFineUploader',
                                array(
                                    'id'=>'FineUploader',
                                    'config'=>array(
                                        'autoUpload'=>true,
                                        'request'=>array(
                                            'endpoint'=>$this->createUrl('patients/saveavatar'),// OR $this->createUrl('files/upload'),
                                            'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                                        ),
                                        'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
                                        'chunking'=>array('enable'=>true,'partSize'=>50),//bytes
                                        'validation'=>array(
                                            'allowedExtensions'=>array('jpg','jpeg', 'bmp', 'gif', 'png'),
                                            'sizeLimit'=>6 * 1024 * 1024,//maximum file size in bytes
                                            'minSizeLimit'=>0.0001*1024*1024,// minimum file size in bytes
                                        ),
                                        'callbacks'=>array(
                                            'onComplete'=>"js:function(id, name, response){ // for test purpose
                                         $('#Patients_avatar_path').val(response.filename);
                                         $('#avatrImg').html('<img class=\"img-responsive img-thumbnail\" src=\"".Yii::app()->baseUrl."/upload/temp/'+response.filename+'\">');
                                       }",
                                            //'onError'=>"js:function(id, name, errorReason){ }",
                                            'onValidateBatch' => "js:function(fileOrBlobData) {}", // because of crash
                                        ),
                                    ),

                                )
                            );
                            ?>
                        </div>
                        <div class="col-lg-6" id="avatrImg">
                        </div>
                    </div>
                    <div class="row">
                        <label class="control-label" for="first_name"><?php echo $form->labelEx($model,'first_name'); ?></label>
                        <div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-user"></i>
                    </span>
                            <?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
                        </div><br />
                        <div class="col-lg-6">
                            <?php echo $form->error($model,'first_name', array('class' => 'alert alert-danger')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <label class="control-label" for="last_name"><?php echo $form->labelEx($model,'last_name'); ?></label>
                        <div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-user-secret"></i>
                    </span>
                            <?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
                        </div><br />
                        <div class="col-lg-6">
                            <?php echo $form->error($model,'last_name', array('class' => 'alert alert-danger')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <label class="control-label" for="afliction"><?php echo $form->labelEx($model,'Affliction'); ?></label>
                        <div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-bed"></i>
                    </span>
                            <?php echo $form->textField($model,'afliction',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
                        </div><br />
                        <div class="col-lg-6">
                            <?php echo $form->error($model,'afliction', array('class' => 'alert alert-danger')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
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
                                    'ajax' => array(
                                        'type'=>'POST',
                                        'url'=>$this->createUrl('floorRoomList'),
                                        'update'=>'#'.CHtml::activeId($model, 'id_room'), // ajax updates package_id, but I want ajax update registration_id if I select item no 4
                                        'data'=>array('id_building'=>'js:this.value'),
                                    )
                                )
                            );
                            ?><br />
                        </div>
                        <div class="col-lg-6">
                            <?php echo $form->error($model,'id_building', array('class' => 'alert alert-danger')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <label class="control-label" for="id_room"><?php echo $form->labelEx($model,'id_room'); ?></label>
                        <div class="input-group date col-sm-4">
                            <span class="input-group-addon">
                                <i class="fa fa-square-o"></i>
                            </span>
                            <?php
                            echo CHtml::activeDropDownList($model,'id_room',array(), array('class'=>'form-control','style'=>"width: 250px;"));
                            ?><br />
                        </div>
                        <div class="col-lg-6">
                            <?php echo $form->error($model,'id_room', array('class' => 'alert alert-danger')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <label class="control-label" for="language"><?php echo $form->label($model,Yii::t('admin/patients','language')); ?></label>
                        <div class="input-group date col-sm-4">
                            <span class="input-group-addon">
                                <i class="fa fa-language"></i>
                            </span>
                        <?php
                        echo $form->dropDownList($model, 'language',Yii::app()->params['languages'], array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen"));
                        ?>
                        </div><br/>
                        <?php echo $form->error($model,'language'); ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="row setup-content hiddenStepInfo" id="step-2">
            <div class="col-xs-12 well">
                <div class="col-lg-12">
                    <div class="row"  id="divCameraUrl">
                        <div class="col-lg-4">
                            <label class="control-label" for="cameraUrl_desc"><?php echo $form->labelEx($model,'camera_description'); ?></label>
                            <div class="input-group date col-sm-4">
                            <span class="input-group-addon">
                                <i class="fa  fa-eye-slash"></i>
                            </span>
                                <?php echo $form->textField($model,'cameraUrl['.$tt.'][desc]',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
                            </div><br />
                            <div class="col-lg-6">
                                <?php echo $form->error($model,'cameraUrl['.$tt.'][desc]', array('class' => 'alert alert-danger')); ?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="control-label" for="cameraUrl"><?php echo $form->labelEx($model,'cameraUrl'); ?></label>
                            <div class="input-group date col-sm-8">
                            <span class="input-group-addon">
                                <i class="fa  fa-external-link"></i>
                            </span>
                                <?php echo $form->textField($model,'cameraUrl['.$tt.'][url]',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
                            </div>
                            <?php echo $form->error($model,'cameraUrl['.$tt.'][url]', array('class' => 'alert alert-danger')); ?>
                        </div>
                        <div class="col-lg-2" style="padding-top: 35px;">
                            <a onClick="javascript:addCameraUrl();" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row setup-content hiddenStepInfo" id="step-3">
            <div class="col-xs-12 well">
                <div class="col-lg-12" id="divNotes">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="control-label" for="notes"><?php echo $form->label($model,Yii::t('admin/patients','notes')); ?></label>
                        </div>
                    </div>
                    <div class="row" id="notesList"></div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="">
                                <div class="controls">
                                    <?php echo $form->textArea($model,'patient_notes['.$tt.'][notes]', array('class'=>'cleditor','id'=>'notes')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label" for="description_email"><?php echo $form->labelEx($model,'notes_file'); ?></label>
                            <?php echo $form->hiddenField($model,'patient_notes['.$tt.'][notes_file]'); ?>
                            <?php
                            $this->widget('ext.EFineUploader.EFineUploader',
                                array(
                                    'id'=>'NotesFiles',
                                    'config'=>array(
                                        'autoUpload'=>true,
                                        'request'=>array(
                                            'endpoint'=>$this->createUrl('patients/saveafiles'),// OR $this->createUrl('files/upload'),
                                            'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                                        ),
                                        'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
                                        'chunking'=>array('enable'=>true,'partSize'=>50),//bytes
                                        'validation'=>array(
                                            'allowedExtensions'=>array('jpg','jpeg', 'bmp', 'gif', 'png', 'pdf', 'doc', 'docx'),
                                            'sizeLimit'=>6 * 1024 * 1024,//maximum file size in bytes
                                            'minSizeLimit'=>0.0001*1024*1024,// minimum file size in bytes
                                        ),
                                        'callbacks'=>array(
                                            'onComplete'=>"js:function(id, name, response){ // for test purpose
                                             $('#Patients_patient_notes_".$tt."_notes_file').val(response.filename);
                                           }",
                                            //'onError'=>"js:function(id, name, errorReason){ }",
                                            'onValidateBatch' => "js:function(fileOrBlobData) {}", // because of crash
                                        ),
                                    ),

                                )
                            );
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <a onClick="javascript:addInsertNotes();" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>
                        </div>
                    </div><br/><br/>
                </div>
            </div>
        </div>
        <div class="row setup-content hiddenStepInfo" id="step-4">
            <div class="col-xs-12 well">
                <div class="col-lg-12">
                    <fieldset>
                        <legend><?php echo Yii::t('admin/patients', 'Emergency Contact'); ?></legend>
                        <div class="row col-sm-12" id="headerEmergencyContact">
                            <table class="table table-bordered table-striped table-condensed" id="tabEmergencyContact">
                                <thead>
                                <tr>
                                    <th><?php echo Yii::t('admin/patients', 'Name'); ?></th>
                                    <th><?php echo Yii::t('admin/patients', 'Phone'); ?></th>
                                    <th><?php echo Yii::t('admin/patients', 'Cell'); ?></th>
                                    <th><?php echo Yii::t('admin/patients', 'E-mail'); ?></th>
                                    <th><?php echo Yii::t('admin/patients', 'SMS'); ?></th>
                                    <th><?php echo Yii::t('admin/patients', 'Login ID'); ?></th>
                                    <th><?php echo Yii::t('admin/patients', 'Pass'); ?></th>
                                    <th><a onClick="javascript:addEmergency();" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a></th>
                                </tr>
                                </thead>

                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="row setup-content hiddenStepInfo" id="step-5">
            <div class="col-xs-12 well">
                <div class="col-sm-9">
                    <div class="row">
                        <label class="control-label" for="text_desc"><?php echo $form->labelEx($model,'text_desc'); ?></label>
                        <div class="input-group date col-sm-4">
                            <span class="input-group-addon">
                                <i class="fa  fa-comments-o"></i>
                            </span>
                            <?php echo $form->textField($model,'text_desc',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
                        </div><br />
                        <?php echo $form->error($model,'text_desc', array('class' => 'alert alert-danger')); ?>
                    </div>
                    <div class="row">
                        <label class="control-label" for="text_message"><?php echo $form->label($model,Yii::t('admin/patients','Text Messages')); ?></label>
                        <div class="controls">
                            <?php echo $form->textArea($model,'text_message', array('class'=>'cleditor','id'=>'text_message')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row setup-content hiddenStepInfo" id="step-6">
            <div class="col-xs-12 well">
                <div class="col-sm-9">
                    <div class="row">
                        <label class="control-label" for="email_desc"><?php echo $form->labelEx($model,'email_desc'); ?></label>
                        <div class="input-group date col-sm-4">
                            <span class="input-group-addon">
                                <i class="fa  fa-envelope-o"></i>
                            </span>
                            <?php echo $form->textField($model,'email_desc',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
                        </div><br />
                        <?php echo $form->error($model,'email_desc', array('class' => 'alert alert-danger')); ?>
                    </div>
                    <div class="row">
                        <label class="control-label" for="email_message"><?php echo $form->label($model,Yii::t('admin/patients','Email Messages')); ?></label>
                        <div class="controls">
                            <?php echo $form->textArea($model,'email_message', array('class'=>'cleditor','id'=>'email_message')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row setup-content hiddenStepInfo" id="step-7">
            <div class="col-xs-12 well">
                <div class="col-sm-9">
                    <div class="row">
                        <label class="control-label" for="voice_desc"><?php echo $form->labelEx($model,'voice_desc'); ?></label>
                        <div class="input-group date col-sm-4">
                            <span class="input-group-addon">
                                <i class="fa  fa-phone-square"></i>
                            </span>
                            <?php echo $form->textField($model,'voice_desc',array('size'=>60,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:250px')); ?>
                        </div><br />
                        <?php echo $form->error($model,'voice_desc', array('class' => 'alert alert-danger')); ?>
                    </div>
                    <div class="row">
                        <label class="control-label" for="voice_message"><?php echo $form->label($model,Yii::t('admin/patients','Voice Messages')); ?></label>
                        <div class="controls">
                            <?php echo $form->textArea($model,'voice_message', array('class'=>'cleditor','id'=>'voice_message')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row buttons">
        <?php
        echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
        echo "&nbsp;&nbsp;&nbsp;";
        echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary'));
        ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->