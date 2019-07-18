<?php
$tt = time(); 
$str = ""; 
?>
<div class="row" id="<?php echo $tt;?>">
    <div class="col-sm-6">
        <div >
			<div class="controls">
<?php echo CHtml::textArea('Patients[patient_notes]['.$tt.'][notes]','', array('class'=>'cleditor')); ?>
</div>
        </div>
    </div>
    <div class="col-sm-3">
        <label class="control-label" for="description_email"><?php echo Yii::t('admin/patients','Note File');?></label>
<?php echo CHtml::hiddenField('Patients[patient_notes]['.$tt.'][notes_file]',''); 

$this->widget('ext.EFineUploader.EFineUploader',
                    array(
                        'id'=>'NotesFiles'.$tt,
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
        &nbsp;&nbsp;<a onClick="javascript:delCameraUrl(<?php echo $tt;?>);" class="btn btn-xs btn-success"><i class="fa fa-trash-o"></i></a>
    </div>
</div><br/>