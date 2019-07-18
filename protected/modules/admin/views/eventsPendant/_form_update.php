<?php
/* @var $this RoomsController */
/* @var $model Rooms */
/* @var $form CActiveForm */
?>
<div id='ajax_loader' style="display: none;" class="ui-widget-overlay">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; z-index:3000000"/>
</div>
<div class="col-xs-12 col-md-12 col-sm-12">
    <div class="form-group">

    <?php $form=$this->beginWidget('CActiveForm', array(
    	'id'=>'rooms-event-form',
    	// Please note: When you enable ajax validation, make sure the corresponding
    	// controller action is handling ajax validation correctly.
    	// There is a call to performAjaxValidation() commented in generated controller code.
    	// See class documentation of CActiveForm for details on this.
    	'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
    )); ?>
    
    	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->hiddenField($model,'id_event_pendant',array('id'=>'id_event')); ?>
        <div id="id_pendant_type_tmp" tochange="<?php echo $model->id_pendant_type;?>"></div>
        <div id="id_global_event_tmp" tochange="<?php echo $model->id_global_event;?>"></div>
        <div id="event_type_tmp" tochange="<?php echo $model->event_type;?>"></div>
    
    	<?php echo $form->errorSummary($model, null, null, array('class'=>'alert alert-warning')); ?>
        <div class="row">
            <label class="control-label" for="id_building"><?php echo $form->labelEx($model,'id_building'); ?></label>
            <div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-building"></i>
                    </span>
            <?php
            echo $form->dropDownList($model, 'id_building', CHtml::listData(Buildings::model()->findAll(), 'id_building','name'),
                array(
                    'class'=>'form-control',
                    'style'=>"width: 250px;",
                    'data-rel'=>"chosen",
                    //'data-rel'=>"chosen",
                    'prompt' => Yii::t('admin/events','Select Building'),
                    'ajax' => array(
                        'type'=>'POST',
                        'url'=>$this->createUrl('devicesList'),
                        'update'=>'#'.CHtml::activeId($model, 'id_device'), // ajax updates package_id, but I want ajax update registration_id if I select item no 4
                        'data'=>array('id_building'=>'js:this.value'),
                    )
                )
            );
            ?></div><br />
            <div class="col-lg-6">
                <?php echo $form->error($model,'id_building', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
    	<div class="row">
            <label class="control-label" for="id_device"><?php echo $form->labelEx($model,Yii::t("admin/rooms",'Device')); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-dashboard"></i>
                </span>
                <?php
                        echo $form->dropDownList($model, 'id_device', array(),
                            array(
                                    'class'=>'form-control',
                                    'style'=>"width: 250px;",
                                    //'data-rel'=>"chosen",
                                    'prompt' => Yii::t('admin/rooms','Select Device'),
                                    'onChange'=>'clearAfterChangeDevice(this)',
                                )
                            );
                    ?>
            </div>
    		<?php echo $form->error($model,'id_device'); ?>
    	</div>
        <div class="row">
            <div class="form-group">
                <label class="control-label" for="event_type"><?php echo $form->label($model,Yii::t('admin/settings','event_pendant_type')); ?></label>
                <div class="input-group date col-sm-4">
                   <span class="input-group-addon">
                        <i class="fa  fa-exclamation-circle"></i>
                    </span>
                    <?php
                        echo $form->dropDownList($model, 'event_type',Yii::app()->params['event_type'],
                            array(
                                    'class'=>'form-control',
                                    'style'=>"width: 250px;",
                                    'onChange'=>'populateAfterPickEventSelectUpdate(this)',
                                    'prompt' => Yii::t('admin/rooms','Select Event Type'),
                                )
                            );
                    ?>
                </div>
            </div>
        </div>
        <div id="eventAdditionalSettings" style="display: none;">
            <div class="col-xs-6 col-md-6 col-sm-6">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                		<div>
                            <label class="control-label" for="live_panel"><?php echo $form->labelEx($model,'live_panel'); ?></label>
                            <div class="input-group date col-sm-4">
                                <span class="input-group-addon">
                                    <i class="fa  fa-eye-slash"></i>
                                </span>
                                <?php
                                    echo $form->dropDownList($model, 'live_panel', array('Y' => Yii::t('admin/eventsmanage','Yes'), 'N' => Yii::t('admin/globalevent','No')), array('class'=>'form-control','style'=>"width: 250px;", 'prompt' => Yii::t('admin/globalevent','Choose Options'),));
                                ?>
                		    </div>
                            <?php echo $form->error($model,'live_panel', array('class' => 'alert alert-danger')); ?>
                        </div>
                	</div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                		<div>
                            <label class="control-label" for="require_acknowledge"><?php echo $form->labelEx($model,'require_acknowledge'); ?></label>
                            <div class="input-group date col-sm-4">
                                <span class="input-group-addon">
                                    <i class="fa  fa-check-square-o"></i>
                                </span>
                                <?php
                                    echo $form->dropDownList($model, 'require_acknowledge', array('Y' => Yii::t('admin/eventsmanage','Yes'), 'N' => Yii::t('admin/globalevent','No')), array('class'=>'form-control','style'=>"width: 250px;", 'prompt' => Yii::t('admin/globalevent','Choose Options'),));
                                ?>
                		    </div>
                            <?php echo $form->error($model,'require_acknowledge', array('class' => 'alert alert-danger')); ?>
                        </div>
                	</div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                		<div>
                            <label class="control-label" for="flashing_toggle"><?php echo $form->labelEx($model,'flashing_toggle'); ?></label>
                            <div class="input-group date col-sm-4">
                                <span class="input-group-addon">
                                    <i class="fa  fa-square"></i>
                                </span>
                                <?php
                                    echo $form->dropDownList($model, 'flashing_toggle', array('Y' => Yii::t('admin/eventsmanage','Yes'), 'N' => Yii::t('admin/globalevent','No')), array('class'=>'form-control','style'=>"width: 250px;", 'prompt' => Yii::t('admin/globalevent','Choose Options'),));
                                ?>
                		    </div>
                            <?php echo $form->error($model,'flashing_toggle', array('class' => 'alert alert-danger')); ?>
                        </div>
                	</div>
                </div>
            </div>
            <div class="col-xs-6 col-md-6 col-sm-6">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                		<div>
                            <label class="control-label" for="auto_close"><?php echo $form->labelEx($model,'auto_close'); ?></label>
                            <div class="input-group date col-sm-4">
                                <span class="input-group-addon">
                                    <i class="fa  fa-close"></i>
                                </span>
                                <?php
                                    echo $form->dropDownList($model, 'auto_close', array('Y' => Yii::t('admin/eventsmanage','Yes'), 'N' => Yii::t('admin/globalevent','No')), array('class'=>'form-control','style'=>"width: 250px;", 'prompt' => Yii::t('admin/globalevent','Choose Options'),));
                                ?>
                		    </div>
                            <?php echo $form->error($model,'auto_close', array('class' => 'alert alert-danger')); ?>
                        </div>
                	</div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <div id="divAutoCloseTime" style="display: none;">
                            <label class="control-label" for="auto_close_duration"><?php echo $form->labelEx($model,'auto_close_duration'); ?></label>
                            <div class="input-group date col-sm-4">
                                <span class="input-group-addon">
                                    <i class="fa  fa-times-circle-o"></i>
                                </span>
                                <?php
                                    echo $form->dropDownList($model, 'auto_close_duration', array('5' => '5 s', 
                                                                                                    '10' => '10 s', 
                                                                                                    '15' => '15 s', 
                                                                                                    '20' => '20 s', 
                                                                                                    '25' => '25 s', 
                                                                                                    '30' => '30 s',
                                                                                                    '35' => '35 s',
                                                                                                    '40' => '40 s',
                                                                                                    '45' => '45 s',
                                                                                                    '50' => '50 s',
                                                                                                    '55' => '55 s',
                                                                                                    '60' => '60 s',
                                                                                                    ), array('class'=>'form-control','style'=>"width: 250px;", 'prompt' => Yii::t('admin/globalevent','Choose Options'),));
                                ?>
                		    </div>
                            <?php echo $form->error($model,'auto_close_duration', array('class' => 'alert alert-danger')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="contentEvent" class="row">
            
        </div><br/>
        <div class="row buttons">
            <?php
            echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
            echo "&nbsp;&nbsp;&nbsp;";
            echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary', 'id'=>'btnSave')); ?>
        </div>
    <?php $this->endWidget(); ?>
    
    </div><!-- form -->
</div>