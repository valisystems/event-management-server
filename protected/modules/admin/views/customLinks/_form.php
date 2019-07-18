<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 11/11/15
 * Time: 15:43
 */

?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'custom-links-create-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of CActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    )
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<div class="row">

    <div class="col-lg-6 col-sm-6">
        <label class="control-label" for="desc_custom_links"><?php echo $form->labelEx($model,'desc_custom_links'); ?></label>
        <div class="input-group date col-sm-4">
					<span class="input-group-addon">
						<i class="fa fa-info"></i>
					</span>
            <?php echo $form->textField($model,'desc_custom_links',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/command', 'Description Links'))); ?>
        </div>
        <br />
        <div class="col-lg-6" style="padding: 0;">
            <?php echo $form->error($model,'desc_custom_links', array('class' => 'alert alert-danger')); ?>
        </div>
    </div>

    <div class="col-lg-6 col-sm-6">
        <label class="control-label" for="url_custom_links"><?php echo $form->labelEx($model,'url_custom_links'); ?></label>
        <div class="input-group date col-sm-4">
					<span class="input-group-addon">
						<i class="fa fa-info"></i>
					</span>
            <?php echo $form->textField($model,'url_custom_links',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/command', 'URL Custom Links'))); ?>
        </div>
        <br />
        <div class="col-lg-6" style="padding: 0;">
            <?php echo $form->error($model,'url_custom_links', array('class' => 'alert alert-danger')); ?>
        </div>
    </div>

    <div class="col-lg-6 col-sm-6">
        <label class="control-label" for="target_type"><?php echo $form->labelEx($model,'link_target'); ?></label>
        <div class="input-group date col-sm-4">
					<span class="input-group-addon">
						<i class="fa fa-info"></i>
					</span>
            <?php echo $form->dropDownList($model, 'target_type',Yii::app()->params['link_target'], array('class'=>'form-control', 'style'=>'width:250px','onChange'=>'addAditionalInfo(this)'));?>
        </div>
        <br />
        <div class="col-lg-6" style="padding: 0;">
            <?php echo $form->error($model,'target_type', array('class' => 'alert alert-danger')); ?>
        </div>
    </div>
    <div class="col-lg-6 col-sm-6">
        <label class="control-label" for="location_links"><?php echo $form->labelEx($model,'location_links'); ?></label>
        <div class="input-group date col-sm-4">
					<span class="input-group-addon">
						<i class="fa fa-info"></i>
					</span>
            <?php echo $form->dropDownList($model, 'location_links',Yii::app()->params['location_links'], array('class'=>'form-control', 'style'=>'width:250px')); ?>


        </div>
        <br />
        <div class="col-lg-6" style="padding: 0;">
            <?php echo $form->error($model,'location_links', array('class' => 'alert alert-danger')); ?>
        </div>
    </div>

</div>
<div class="row" id='additionalForm'>
    <div class="col-lg-4 col-sm-4">
        <label class="control-label" for="iframe_width"><?php echo $form->labelEx($model,'iframe_width'); ?></label>
        <div class="input-group date col-sm-12">
                    <span class="input-group-addon">
                        <i class="fa fa-info"></i>
                    </span>
            <?php echo $form->textField($model,'iframe_width',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/command', 'Iframe Width'))); ?>
        </div>
        <br />
        <div class="col-lg-12" style="padding: 0;">
            <?php echo $form->error($model,'iframe_width', array('class' => 'alert alert-danger')); ?>
        </div>
    </div>
    <div class="col-lg-2 col-sm-2">
        <label class="control-label" for="target_type"><?php echo $form->labelEx($model,'iframe_width_mesure'); ?></label>
        <div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa fa-info"></i>
                    </span>
            <?php echo $form->dropDownList($model, 'iframe_width_mesure',array('%'=>'%','px'=>'pixel'), array('class'=>'form-control', 'style'=>'width:70px'));?>
        </div>
        <br />
        <div class="col-lg-6" style="padding: 0;">
            <?php echo $form->error($model,'target_type', array('class' => 'alert alert-danger')); ?>
        </div>
    </div>

    <div class="col-lg-6 col-sm-6">
        <label class="control-label" for="iframe_height"><?php echo $form->labelEx($model,'iframe_height'); ?></label>
        <div class="input-group date col-sm-12">
                    <span class="input-group-addon">
                        <i class="fa fa-info"></i>
                    </span>
            <?php echo $form->textField($model,'iframe_height',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/command', 'Height'))); ?>&nbsp;px
        </div>
        <br />
        <div class="col-lg-6" style="padding: 0;">
            <?php echo $form->error($model,'iframe_height', array('class' => 'alert alert-danger')); ?>
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

</div><!-- form -->