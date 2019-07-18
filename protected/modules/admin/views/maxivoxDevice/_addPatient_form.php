<?php
/* @var $this DevicesController */
/* @var $model Devices */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'patient-devices-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	)
));

if (isset($status)){
    $css_class = "";
    if ($status == 'success_add') {
        $css_class = "alert alert-success";
        $message = Yii::t('admin/devices', 'Changed Successful');
    } else if ($status == 'success_update') {
        $css_class = "alert alert-success";
        $message = Yii::t('admin/devices', 'Updated Successful');
    }
    else if ($status == 'fail_add') {
        $css_class = "alert alert-danger";
        $message = Yii::t('admin/devices', 'Change fail');
    } else if ($status == 'fail_update') {
        $css_class = "alert alert-danger";
        $message = Yii::t('admin/devices', 'Updated fail');
    }
    if ($css_class != "") {
        echo '<div class="row">
            <div class="col-sm-12">
                <div class="' . $css_class . '">' . $message . '</div>
            </div>
        </div>';
    }
}
?>
<div class="form-group">
    <?php 
        echo $form->hiddenField($model,'id_room',array('value'=>$model->id_room));
    ?>
    <div class="row col-sm-9">
        <label class="control-label" for="id_patient"><?php echo $model->dev_desc; ?></label>
    </div>
    <div class="row col-sm-9">
        <label class="control-label" for="id_patient"><?php echo Yii::t("admin/devices",'Patients'); ?></label>
		<div class="input-group date col-sm-4">
            <span class="input-group-addon">
                <i class="fa  fa-comment-o"></i>
            </span>
            <div class="controls">
                <?php
                    $model->isNewRecord ? $model->id_patient = 0: $model->id_patient = $model->id_patient ;
                    echo $form->dropDownList($model, 'id_patient', $model->getPatients($model->id_room), 
                        array(
                            'class'=>'form-control', 
                            'style'=>'width:250px',
                        )
                    );
                ?>
		    </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>