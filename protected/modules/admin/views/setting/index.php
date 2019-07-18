<?php
/* @var $this SettingController */
/* @var $model Setting */
/* @var $form CActiveForm  */
$this->pageTitle=Yii::app()->name .' - '.Yii::t('admin/settings','title_settings');
$this->breadcrumbs=array(
	'Settings miALERT',
);

?>
<?php if(Yii::app()->user->hasFlash('success')):
    ?>
    <div class="row">
        <div class="alert alert-success">
            <?php
            echo Yii::app()->user->getFlash('success');
            ?>
        </div>
    </div>
<?php
endif; ?>
<?php if(Yii::app()->user->hasFlash('error')):
    ?>
    <div class="row">
        <div class="alert alert-danger">
            <?php
            echo Yii::app()->user->getFlash('error');
            ?>
        </div>
    </div>
<?php
endif; ?>
<div class="row">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">GENERAL</h3>
        </div>
        <div class="panel-body">
    <?php $settings = $this->beginWidget('CActiveForm', array(
            'id'=>'settings-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
            'focus'=>array($model,'site_name'),
            'enableClientValidation'=>true,
        )); ?>
    <?php echo $settings->errorSummary($model, null, null, array('class'=>'alert alert-warning')); ?>
    <div class="col-lg-6 col-sm-6">
        <div class="form-group">
            <?php echo $settings->hiddenField($model,'id_settings'); ?>
            <div id="test"></div>
            <div class="row">
                <div class="col-lg-6">
                    <label class="control-label" for="site_name"><?php echo $settings->label($model,Yii::t('admin/settings','Site name')); ?></label>
                    <div class="input-group date col-sm-4">
                        <span class="input-group-addon">
                            <i class="fa  fa-comment-o"></i>
                        </span>
                        <?php echo $settings->textField($model,'site_name', array('class'=>'form-control', 'style'=>'width:250px')) ?>
                    </div>
                    <?php echo $settings->error($model,'site_name', array('class'=>'alert alert-danger', 'style'=>'margin-top:5px;')) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label class="control-label" for="site_email"><?php echo $settings->label($model,Yii::t('admin/settings','site_email')); ?></label>
                    <div class="input-group date col-sm-4">
                        <span class="input-group-addon">@</span>
                        <?php echo $settings->textField($model,'site_email', array('class'=>'form-control', 'style'=>'width:250px')) ?>
                    </div>
                    <?php echo $settings->error($model,'site_email', array('class'=>'alert alert-danger', 'style'=>'margin-top:5px;')) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label class="control-label" for="logo_path"><?php echo $settings->label($model,Yii::t('admin/settings','logo_path')); ?>
                        <h4><small>(
                            <?php
                            echo Yii::t("admin/settings", 'Optimal image size 120px * 80px')
                            ?>
                         )</small></h4>
                    </label>
                    <div class="input-group date col-sm-4">
                        <span class="input-group-addon">
                            <i class="fa  fa-picture-o"></i>
                        </span>
                        <?php echo $settings->hiddenField($model,'logo_path'); ?>
                        <?php
                            $this->widget('ext.EFineUploader.EFineUploader',
                                array(
                                    'id'=>'FineUploader',
                                    'config'=>array(
                                        'autoUpload'=>true,
                                        'request'=>array(
                                            'endpoint'=>$this->createUrl('setting/saveimage'),// OR $this->createUrl('files/upload'),
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
                                             $('#Setting_logo_path').val(response.filename);
                                             $('#imgLogo').html('<img class=\"img-responsive img-thumbnail\" src=\"".Yii::app()->baseUrl."/upload/temp/'+response.filename+'\">');
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
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="row">
            <div id="imgLogo"></div>
        </div>
    </div>
    <div class="col-lg-12 col-xs-12 col-md-12">
        <div class="col-lg-6">
            <div class="form-group hidden-xs" style="width: 90%;">
                <label class="control-label" for="header"><?php echo $settings->label($model,Yii::t('admin/settings','header')); ?></label>
                <div class="controls">
                  <?php echo $settings->textArea($model,'header', array('class'=>'cleditor','id'=>'header')); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group hidden-xs" style="width: 90%;">
                <label class="control-label" for="footer"><?php echo $settings->label($model,Yii::t('admin/settings','footer')); ?></label>
                <div class="controls">
                  <?php echo $settings->textArea($model,'footer', array('class'=>'cleditor','id'=>'footer')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label class="control-label" for="default_lang"><?php echo $settings->label($model,Yii::t('admin/settings','default_lang')); ?></label>
                <div class="controls">
                    <?php
                        echo $settings->dropDownList($model, 'default_lang',Yii::app()->params['languages'], array('class'=>'form-control','style'=>"width: 90%;",'data-rel'=>"chosen"));
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-1">
            <label class="control-label">Discovered</label>
            <div class="checkbox">
                <?php echo $settings->checkBox($model,"discovery",  array("data-toggle" => "toggle")); ?>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label class="control-label" for="default_building"><?php echo $settings->label($model,'default_building'); ?></label>
                <div class="controls">
                    <?php
                    echo $settings->dropDownList($model, 'default_building',CHtml::listData(Buildings::model()->findAll(), 'id_building','name'), array(
                            'class'=>'form-control',
                            'style'=>"width: 90%;",
                            //'data-rel'=>"chosen",
                            'prompt' => Yii::t('admin/setting','Select Building'),
                            'ajax' => array(
                                'type'=>'POST',
                                'url'=>$this->createUrl('floorList'),
                                //'update'=>'#'.CHtml::activeId($model, 'id_map'), // ajax updates package_id, but I want ajax update registration_id if I select item no 4
                                'data'=>array('id_building'=>'js:this.value'),
                                'success' => 'function(data){
                                                $("#Setting_default_map").html(data);
                                            }'

                            )
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label class="control-label" for="default_map"><?php echo $settings->label($model,'default_map'); ?></label>
                <div class="controls">
                    <?php
                    echo $settings->dropDownList($model, 'default_map',$model->getFloorList($model->default_building), array('class'=>'form-control','style'=>"width: 90%;"));
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="control-label" for="update_ems_server"><?php echo $settings->label($model,Yii::t('admin/settings','update_ems_server')); ?></label>
                <div class="input-group date col-sm-4">
                            <span class="input-group-addon">
                                <i class="fa fa-link"></i>
                            </span>
                    <?php echo $settings->textField($model,'update_ems_server', array('class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>'http://url_to_update_server.com')) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="control-label" for="update_ems_key"><?php echo $settings->label($model,Yii::t('admin/settings','update_ems_key')); ?></label>
                <div class="input-group date col-sm-4">
                            <span class="input-group-addon">
                                <i class="fa fa-link"></i>
                            </span>
                    <?php echo $settings->textField($model,'update_ems_key', array('class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>'Authentification Code')) ?>
                </div>
            </div>
        </div>
    </div>
            <div class="row">
                <div class="col-lg-6">
                    <?php
                        echo CHtml::submitButton(Yii::t('admin/settings','Save changes'),
                            array(
                                'class'=>'btn btn-primary',
                                'ajax'=>array(
                                    'type'=>'POST',
                                    'dataType'=>'json',
                                    'url'=>Yii::app()->createUrl('admin/setting/save'),
                                    'success'=>'function(data) {
                                        if(data.success =="yes")
                                        {
                                           location.reload();
                                        } else if(data.success == "update"){
                                            $("#imgLogo").html("<img class=\'img-responsive img-thumbnail\' src=\'"+data.img_content+"\'>");
                                        }
                                        else
                                        {
                                            $.each(data, function(key, val)
                                            {
                                              $("#settings-form #"+key+"_em_").text(val);
                                              $("#settings-form #"+key+"_em_").show();
                                              $("div[for="+key+"]").show();
                                            });
                                        }
                                    }',
                                )
                            )
                        );
                    ?>
                </div>
            </div>
    </div>
    <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
