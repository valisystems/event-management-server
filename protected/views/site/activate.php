<?php
/**
 * User: iurik
 * Date: 08.01.15
 * Time: 21:45
 */
$this->pageTitle=Yii::app()->name . ' - Activate';
$this->breadcrumbs=array(
    Yii::t("site/activate",'Activate'),
);
?>
<?php
if (!Yii::app()->user->licenseVerification()){
?>
<div class="row">
    <div class="alert alert-danger">
        <?php
            echo Yii::t("site/activation", 'Your Product is not activated, please enter valid information');
        ?>
    </div>
</div>
<?php }?>
<h1>
    Activation
</h1>
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
    <div class="form-group">
        <?php
        $result = array();
        $os = strtoupper(php_uname('s'));
        if (substr_count($os, 'WIN')) {
            $command ='powershell "Get-CimInstance Win32_OperatingSystem | FL SerialNumber"';
            $result = shell_exec($command);
            $txt = explode(":", trim($result));
            $serialNumberMB = $txt[count($txt)-1];
            $result = array();
            $command = 'getmac | findstr /C:"-" 2>&1';
            exec($command, $result);
            $txtMac = substr(trim($result[0]), 0, 17);
        } else {
            exec('sudo dmidecode -t 1 | grep "UUID:"', $result);
            $txt = explode(" ", $result[0]);
            $serialNumberMB = $txt[count($txt)-1];
            $result = array();
            exec('ifconfig -a | grep "eth0"', $result);
            $txtMac = substr($result[0], strpos($result[0], "HWaddr") + 7, 17);
        }

        echo "<b>UUID:</b> ".$serialNumberMB."<br/>";
        echo "<b>MAC Address: </b>".$txtMac."<br/><br/>";
        ?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'activation-form',
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
        <?php echo $form->hiddenField($model, 'id_settings'); ?>
    <div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="name"><?php echo $form->labelEx($model,'activation_key'); ?></label>
            <div class="input-group date col-sm-4">
            <span class="input-group-addon">
                <i class="fa  fa-comment-o"></i>
            </span>
                <?php echo $form->textField($model,'activation_key',array('size'=>250,'maxlength'=>250, 'class'=>'form-control', 'style'=>'width:350px')); ?>
            </div>
            <?php echo $form->error($model,'activation_key'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <label class="control-label" for="name"><?php echo $form->labelEx($model,'secret_key'); ?></label>
            <div class="input-group date col-sm-4">
            <span class="input-group-addon">
                <i class="fa  fa-comment-o"></i>
            </span>
                <?php echo $form->textField($model,'secret_key',array('size'=>60,'maxlength'=>150, 'class'=>'form-control', 'style'=>'width:350px')); ?>
            </div>
            <?php echo $form->error($model,'secret_key'); ?>
        </div>
    </div>
    <br/>
    <div class="row buttons">
        <div class="col-lg-6">
            <?php
            echo CHtml::link( Yii::t('site/activate','Back'), array( 'index' ), array('class' => 'btn btn-primary',));
            echo "&nbsp;&nbsp;&nbsp;";
            echo CHtml::submitButton($model->isNewRecord ? Yii::t('site/activate','Create') : Yii::t('admin/buildings','Save'), array('class'=>'btn btn-primary',)); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
 </div>