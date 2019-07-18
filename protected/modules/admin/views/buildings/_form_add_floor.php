<?php
/* @var $this MapsController */
/* @var $modelFloor Maps */
/* @var $form CActiveForm */
?>
<div class="col-lg-11 col-sm-11">
    <div class="form-group">
    
    <?php $form=$this->beginWidget('CActiveForm', array(
    	'id'=>'maps-form',
    	// Please note: When you enable ajax validation, make sure the corresponding
    	// controller action is handling ajax validation correctly.
    	// There is a call to performAjaxValidation() commented in generated controller code.
    	// See class documentation of CActiveForm for details on this.
    	'enableAjaxValidation'=>false,
    )); ?>
    
    	<p class="note"><?php echo Yii::t('admin/buildings', 'Fields with <span class="required">*</span> are required.');?></p>
    
    	<?php echo $form->errorSummary($modelFloor); ?>
    
    	<div class="row">
    		<div class="col-lg-6">
                <label class="control-label" for="name_map"><?php echo $form->labelEx($modelFloor,'name_map'); ?></label>
        		<div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-comment-o"></i>
                    </span>
                    <?php echo $form->textField($modelFloor,'name_map',array('size'=>60,'maxlength'=>100,'class'=>'form-control', 'style'=>'width:250px')); ?>
                </div>
            </div>
    		<?php echo $form->error($modelFloor,'name_map'); ?>
    	</div>
    
    	<div class="row">
    		<div class="col-lg-6">
                <label class="control-label" for="description"><?php echo $form->labelEx($modelFloor,'description'); ?></label>
                <div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-comment-o"></i>
                    </span>
                    <?php echo $form->textField($modelFloor,'description',array('size'=>60,'maxlength'=>250,'class'=>'form-control', 'style'=>'width:250px')); ?>
                </div>
                <?php echo $form->error($modelFloor,'description'); ?>
            </div>
    	</div>
    
    	<div class="row">
    		<div class="col-lg-6">
                <label class="control-label" for="id_building"><?php echo $form->labelEx($modelFloor,'id_building'); ?></label>
                <div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-comment-o"></i>
                    </span>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($modelFloor, 'id_building', CHtml::listData(Buildings::model()->findAll(), 'id_building','name'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen"));
                        ?>
				    </div>
                </div>
                <?php echo $form->error($modelFloor,'id_building'); ?>
            </div>
    	</div>
    
    	<div class="row">
    		<div class="col-lg-6">
                <label class="control-label" for="id_building"><?php echo $form->labelEx($modelFloor,'path_to_img'); ?>
                    <h4><small>(
                        <?php
                        echo Yii::t("admin/settings", 'Optimal image size 1200px * 800px')
                        ?>
                        )</small>
                    </h4>
                </label>
                <div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-comment-o"></i>
                    </span>
                    <?php echo $form->hiddenField($modelFloor,'path_to_img'); ?>
                            <?php
                                $this->widget('ext.EFineUploader.EFineUploader',
                                    array(
                                        'id'=>'FineUploader',
                                        'config'=>array(
                                            'autoUpload'=>true,
                                            'request'=>array(
                                                'endpoint'=>$this->createUrl('buildings/saveimage'),// OR $this->createUrl('files/upload'),
                                                'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                                            ),
                                           'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
                                           'chunking'=>array('enable'=>true,'partSize'=>50),//bytes
                                           'validation'=>array(
                                                'allowedExtensions'=>array('jpg','jpeg', 'bmp', 'gif', 'png'),
                                                'sizeLimit'=>6 * 1024 * 1024,//maximum file size in bytes
                                                'minSizeLimit'=>0.01*1024*1024,// minimum file size in bytes
                                           ),
                                           'callbacks'=>array(
                                              'onComplete'=>"js:function(id, name, response){ // for test purpose
                                                 $('#Maps_path_to_img').val(response.filename);
                                                 //$('#imgLogo').html('<img class=\"img-responsive img-thumbnail\" src=\"".Yii::app()->baseUrl."/upload/temp/'+response.filename+'\">');
                                               }",
                                               //'onError'=>"js:function(id, name, errorReason){ }",
                                              'onValidateBatch' => "js:function(fileOrBlobData) {}", // because of crash
                                            ),
                                        ),
                                        
                                    )
                                );
                            ?>
                </div>
                <?php echo $form->error($modelFloor,'path_to_img'); ?>
            </div>
    	</div>
        <?php
        
            if (!$modelFloor->isNewRecord) {
                ?>
       	<div class="row">
    		<div class="col-lg-6">
            <?php echo CHtml::image(Yii::app()->getRequest()->getHostInfo().$modelFloor->path_to_img, $modelFloor->name_map, array('width'=>'400px')); ?>
            </div>
        </div>
                <?php
            }
        ?>
        <br />
    <?php $this->endWidget(); ?>
    
    </div><!-- form -->
</div>