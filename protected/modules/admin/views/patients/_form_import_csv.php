<div class="row  col-lg-12">
<form action="<?php echo $this->createUrl("patients/importFromCvs")?>" method='POST' id="importCSVForm">
    <input type="hidden" name="nameFile" id="nameFile" value=""/>
    <?php
        $this->widget('ext.EFineUploader.EFineUploader',
            array(
                'id'=>'FineUploader',
                'config'=>array(
                    'autoUpload'=>true,
                    'request'=>array(
                        'endpoint'=>$this->createUrl('patients/importFromCSVUpload'),// OR $this->createUrl('files/upload'),
                        'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                    ),
                   'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
                   'chunking'=>array('enable'=>true,'partSize'=>50),//bytes
                   'validation'=>array(
                        'allowedExtensions'=>array('csv'),
                        'sizeLimit'=>6 * 1024 * 1024,//maximum file size in bytes
                        'minSizeLimit'=>0,// minimum file size in bytes
                   ),
                   'callbacks'=>array(
                      'onComplete'=>"js:function(id, name, response){ // for test purpose
                         $('#nameFile').val(response.filename);
                       }",
                       //'onError'=>"js:function(id, name, errorReason){ }",
                      'onValidateBatch' => "js:function(fileOrBlobData) {}", // because of crash
                    ),
                ),
                
            )
        );
    ?>
</form>
</div>
<div class="row  col-lg-12">
    <div class="col-md-8"></div>
    <div class="col-md-4">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/upload/sampleCSVPatients.csv" target="_blank" class="btn btn-sm btn-primary"><?php echo Yii::t('admin/patients','Sample CSV')?></a>
    </div>
</div>