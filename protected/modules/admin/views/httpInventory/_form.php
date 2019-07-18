<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 4/22/16
 * Time: 12:54
 */
?>
<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'asterisk-form',
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

    <div class="row">
        <div class="col-lg-4">
            <label class="control-label" for="description"><?php echo $form->labelEx($model,'description'); ?></label>
            <div class="input-group date col-sm-4">
            <span class="input-group-addon">
                <i class="fa  fa-history"></i>
            </span>
                <?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>200, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>'Description')); ?>
            </div>
            <br />
            <div class="col-lg-3" style="padding: 0;">
                <?php echo $form->error($model,'description', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
        <div class="col-lg-2">
            <label class="control-label" for="type_of_url"><?php echo $form->labelEx($model,'type_of_url'); ?></label>
            <div class="input-group date">
                <span class="input-group-addon">
                    <i class="fa  fa-bolt"></i>
                </span>
                <?php
                echo $form->dropDownList($model, 'type_of_url',array(''=>'Choose type','3cx' => '3CX', 'pbx' => 'PBXnSIP', 'vodia'=>'Vodia', 'custom'=>'Custom'), array('class'=>'form-control','style'=>"width: 100px", 'onChange' => 'javascript:verifyCustom(this)'));
                ?>
            </div>
            <?php echo $form->error($model,'type_of_url', array('class' => 'alert alert-danger')); ?>
        </div>
        <div class="col-lg-3">
            <label class="control-label">&nbsp;</label>
            <div class="input-group">
            <?php
            echo CHtml::link( Yii::t( 'admin/staff','Generate URL' ), '#',
                array(
                    'onClick' => 'javascript:generateUrl()',
                    'id' => 'generateUrl',
                    'class'=>'btn btn-primary'
                ))
            ?>
                </div>
        </div>
    </div><br/>
    <div class="row">
        <div class="col-lg-8">
            <label class="control-label" for="action_url"><?php echo $form->labelEx($model,'action_url'); ?></label>
            <div class="input-group date col-sm-4">
            <span class="input-group-addon">
                <i class="fa  fa-history"></i>
            </span>
                <?php echo $form->textField($model,'action_url',array('size'=>60,'maxlength'=>200, 'class'=>'form-control disabled', 'style'=>'width:650px', 'placeholder'=>'', 'readonly'=> 'readonly')); ?>
            </div>
            <br />
            <div class="col-lg-3" style="padding: 0;">
                <?php echo $form->error($model,'action_url', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>
        <?php echo $form->hiddenField($model, 'urlencode'); ?>
        <?php echo $form->hiddenField($model, 'username'); ?>
        <?php echo $form->hiddenField($model, 'password'); ?>
        <?php echo $form->hiddenField($model, 'enconding_message'); ?>
        <?php echo $form->hiddenField($model, 'message_body'); ?>
        <?php echo $form->hiddenField($model, 'region'); ?>
        <?php echo $form->hiddenField($model, 'additional_header'); ?>
        <?php echo $form->hiddenField($model, 'type_method_info'); ?>
        <?php echo $form->hiddenField($model, 'send_method'); ?>
        <?php echo $form->hiddenField($model, 'custom_variable'); ?>



    </div><br/>
    <div class="row buttons">
        <?php
        echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
        echo "&nbsp;&nbsp;&nbsp;";
        echo CHtml::submitButton('Save', array('class'=>'btn btn-primary', 'id'=>'btnSave')); ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
<!-- Modal -->
<div class="modal fade" id="myModalHttp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalTitle">Modal title</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnGenerate">Generate</button>
            </div>
        </div>
    </div>
</div>