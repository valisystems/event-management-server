<?php
/* @var $this GlobalEventTemplateController */
/* @var $model GlobalEventTemplate */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'global-event-template-form',
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

	<?php echo $form->errorSummary($model,null, null,array('class'=>'alert alert-danger')); ?>
<div class="row col-lg-6">
	<div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="desc_global_event"><?php echo $form->labelEx($model,'desc_global_event'); ?></label>
    		<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-info-circle"></i>
                </span>
                <?php echo $form->textField($model,'desc_global_event',array('size'=>60,'maxlength'=>100,'class'=>'form-control', 'style'=>'width:250px')); ?>
            </div><br />
		<?php echo $form->error($model,'desc_global_event', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>
    <div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="id_pendant_type"><?php echo $form->labelEx($model,'id_pendant_type'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-info-circle"></i>
                </span>
            <div class="input-group date col-sm-4">
                <?php
                    echo $form->dropDownList($model, 'id_pendant_type', CHtml::listData(PendantType::model()->findAll(), 'id_pendant_type','description'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Pendant Type'),));
                ?>
            </div>
            </div><br />
            <div>
                <?php echo $form->error($model,'id_pendant_type', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
	</div>
    <div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="pick_event_type"><?php echo $form->labelEx($model,'pick_event_type'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-binoculars"></i>
                </span>
                <div class="input-group date col-sm-4">
                    <?php
                        echo $form->dropDownList($model, 'pick_event_type', Yii::app()->params['pick_event_type'],
                                array(
                                    'class'=>'form-control',
                                    'style'=>"width: 250px;",'data-rel'=>"chosen",
                                    'prompt' => Yii::t('admin/globalEventPendant','Select Event Type'),
                                    'ajax' => array(
                                        'type'=>'POST',
                                        'url'=>$this->createUrl('eventListByPick'),
                                        //'update'=>'#'.CHtml::activeId($model, 'divReceiver'), // ajax updates package_id, but I want ajax update registration_id if I select item no 4
                                        'success' =>'function(data){
                                            $("#divReceiver").html(data);
                                            $(".GlobalEventPendantTemplate_receiver").change(receiverAction);
                                        }',
                                        'data'=>array('pick_event_type'=>'js:this.value'),
                                    )
                                )
                            );
                    ?>
                </div>
            </div><br />
            <?php echo $form->error($model,'pick_event_type', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>
    <div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="id_global_message"><?php echo $form->labelEx($model,'id_global_message'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-comment-o"></i>
                </span>
                <div class="input-group date col-sm-4">
                    <?php
                        echo $form->dropDownList($model, 'id_global_message', CHtml::listData(GlobalMessages::model()->findAll(), 'id_global_message','global_description'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Global Description'),));
                    ?>
                </div>
            </div><br />
            <div>
                <?php echo $form->error($model,'id_global_message', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
	</div>

    <div class="row">
		<div id="divReceiver">
        </div>
    </div>
 </div>
 <div class="row col-lg-6">
    <div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="live_panel"><?php echo $form->labelEx($model,'live_panel'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-eye"></i>
                </span>
                <div class="input-group date col-sm-4">
                    <?php
                        echo $form->dropDownList($model, 'live_panel', array('Y' => Yii::t('admin/globalevent','Yes'), 'N' => Yii::t('admin/globalevent','No')), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Choose Options'),));
                    ?>
                </div>
            </div><br />
            <div>
                <?php echo $form->error($model,'live_panel', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
	</div><br />

    <div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="require_acknowledge"><?php echo $form->labelEx($model,'require_acknowledge'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-check-square-o"></i>
                </span>
                <div class="input-group date col-sm-4">
                    <?php
                        echo $form->dropDownList($model, 'require_acknowledge', array('Y' => Yii::t('admin/globalevent','Yes'), 'N' => Yii::t('admin/globalevent','No')), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Choose Options'),));
                    ?>
                </div>
            </div><br />
            <div>
                <?php echo $form->error($model,'require_acknowledge', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
	</div><br />
    <div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="flashing_toggle"><?php echo $form->labelEx($model,'flashing_toggle'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-bolt"></i>
                </span>
                <div class="input-group date col-sm-4">
                    <?php
                        echo $form->dropDownList($model, 'flashing_toggle', array('Y' => Yii::t('admin/globalevent','Yes'), 'N' => Yii::t('admin/globalevent','No')), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Choose Options'),));
                    ?>
                </div>
            </div><br />
            <div>
                <?php echo $form->error($model,'flashing_toggle', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
	</div>
    <div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="auto_close"><?php echo $form->labelEx($model,'auto_close'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-bell-slash"></i>
                </span>
                <div class="input-group date col-sm-4">
                    <?php
                        echo $form->dropDownList($model, 'auto_close', array('Y' => Yii::t('admin/globalevent','Yes'), 'N' => Yii::t('admin/globalevent','No')), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Choose Options'),));
                    ?>
                </div>
            </div><br/>
            <?php echo $form->error($model,'auto_close', array('class' => 'alert alert-danger')); ?>
        </div>
	</div><br />
    <div class="row">
        <div class="col-lg-6" id="divAutoCloseTime" style="display: none;">
            <label class="control-label" for="auto_close_duration"><?php echo $form->labelEx($model,'auto_close_duration'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-bell-slash"></i>
                </span>
                <div class="input-group date col-sm-4">
                    <?php
                    $model->isNewRecord ? $model->auto_close_duration = 5: $model->auto_close_duration = $model->auto_close_duration ;
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
                                                                                        ), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Choose Options'),));
                    ?>
                </div>
            </div><br/>
            <?php echo $form->error($model,'auto_close_duration', array('class' => 'alert alert-danger')); ?>
        </div>
    </div>  
</div>
<div class="row">
	<div class="row buttons">
		<div class="col-lg-12">
            <?php
                echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
                echo "&nbsp;&nbsp;&nbsp;";
                echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary',)); 
            ?>
        </div>
	</div>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->