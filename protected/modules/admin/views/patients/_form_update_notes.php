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
<div class="row">
    <div class="col-lg-12">
        <label class="control-label" for="notes"><?php echo $form->label($model,Yii::t('admin/patients','notes')); ?></label>
    	<div class="controls">
    	  <?php echo $form->textArea($model,'notes', array('class'=>'notesEditor')); ?>
    	</div>
    </div>
</div><br />
<div class="row">
    <div class="col-lg-7">
        <label class="control-label" for="description_email"><?php echo $form->labelEx($model,'file_url'); ?></label>
        <?php echo $form->hiddenField($model,'file_url'); ?>
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
                            'minSizeLimit'=>0.01*1024*1024,// minimum file size in bytes
                       ),
                       'callbacks'=>array(
                          'onComplete'=>"js:function(id, name, response){ // for test purpose
                             $('#PatientsNotes_file_url').val(response.filename);
                           }",
                           //'onError'=>"js:function(id, name, errorReason){ }",
                          'onValidateBatch' => "js:function(fileOrBlobData) {}", // because of crash
                        ),
                    ),
                    
                )
            );
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
</div>