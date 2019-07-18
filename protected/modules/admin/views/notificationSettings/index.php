<?php
/* @var $this NotificationSettingsController */
/* @var $model NotificationSettings */

$this->breadcrumbs=array(
	'Notification Settings'=>array('index'),
	'Manage',
);
?>
<?php
/* @var $this NotificationSettingsController */
/* @var $model NotificationSettings */
/* @var $form CActiveForm */
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
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'notification-settings-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => true,
    'enableClientValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model,'id_notification_setting'); ?>
	<div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="alarm_sound"><?php echo $form->labelEx($model,'alarm_sound'); ?></label>
            <div class="input-group date col-sm-4">
                <?php echo $form->radioButtonList($model,'alarm_sound',array('Y'=>'Yes', 'N' => 'No'), array('separator'=>'  ')); ?>
            </div><br />
            <?php echo $form->error($model,'alarm_sound', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>

	<div class="row">
		<div class="col-lg-6">
            <label class="control-label" for="escalation_interval"><?php echo $form->labelEx($model,'escalation_interval'); ?></label>
            <div class="input-group date col-sm-4">
                <?php echo 
                    $form->dropDownList($model, 'escalation_interval', array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10',
                    ), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen")); ?>
            </div><br />
            <?php echo $form->error($model,'escalation_interval', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>

	<div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="number_of_retry"><?php echo $form->labelEx($model,'number_of_retry'); ?></label>
            <div class="input-group date col-sm-4">
                <?php echo 
                    $form->dropDownList($model, 'number_of_retry', array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10',
                    ), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen")); ?>
            </div><br />
            <?php echo $form->error($model,'number_of_retry', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>

	<div class="row buttons">
		<div class="col-lg-6">
           <?php
                    echo CHtml::submitButton(Yii::t('admin/notificationsettings','Save changes'),
                        array(
                            'class'=>'btn btn-primary',
                            'ajax'=>array(
                                'type'=>'POST',
                                'dataType'=>'json',
                                'url'=>Yii::app()->createUrl('admin/notificationSettings/create'),
                                'success'=>'function(data) {
                                    if(data.success =="yes" || data.success =="update")
                                    {
                                       location.reload(); 
                                    }
                                }',
                            )
                        )
                    ); 
                ?>
        </div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->