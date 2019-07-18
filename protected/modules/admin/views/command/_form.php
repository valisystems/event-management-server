<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 9/23/15
 * Time: 15:15
 */
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'command-form',
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
?>
<?php
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
    foreach($flashMessages as $key => $message) {
        $css_class = "";
        if (substr_count($key, 'success'))
            $css_class = "alert alert-success";
        else if (substr_count($key, 'success'))
            $css_class = "alert alert-danger";
        echo '<div class="row">
            <div class="'.$css_class.'">'.$message.'
            </div>
        </div>';
    }
}
?>
<div class="form-group">
    <div class="row">
        <div class="col-lg-6 col-sm-6">
            <label class="control-label" for="com_name"><?php echo Yii::t("admin/command",'Command Name'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-info"></i>
                </span>
                <?php echo $form->textField($model,'com_name',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/command', 'Command Name'))); ?>
            </div>
            <br />
            <div class="col-lg-6" style="padding: 0;">
                <?php echo $form->error($model,'com_name', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
            <label class="control-label" for="command"><?php echo Yii::t("admin/command",'Command'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-info"></i>
                </span>
                <?php echo $form->textField($model,'command',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/command', 'Command'))); ?>
            </div>
            <br />
            <div class="col-lg-6" style="padding: 0;">
                <?php echo $form->error($model,'command', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
    </div>

    <div class="row buttons">
        <?php
        echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
        echo "&nbsp;&nbsp;&nbsp;";
        echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary', 'id'=>'btnSave')); ?>
    </div>
<?php $this->endWidget(); ?>