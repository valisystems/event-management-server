<?php
/* @var $this AsteriskController */
/* @var $model Asterisk */
/* @var $form CActiveForm */

$asterArray = Asterisk::model()->findAll();
?>
<script>
    var nodesArray = [];
    <?php
    foreach ($asterArray as $k) {
        echo "nodesArray[{$k->id_asterisk}] = ['{$k->asterisk_name}','{$k->asterisk_url}', '{$k->voip_url}'];\n";
    }
    ?>

</script>
<div id='ajax_loader' style="display: none;" class="ui-widget-overlay">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; z-index:3000000"/>
</div>
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
    <?php echo $form->hiddenField($model,'id_asterisk',array('id'=>'id_asterisk')); ?>
    <?php echo "<input type='hidden' id='id_building_old' value='".$model->id_building."' name='id_building_old'/>"; ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model,null, null,array('class'=>'alert alert-danger')); ?>

    <div class="row">
        <div class="row col-sm-4">
            <label class="control-label" for="asterisk_name"><?php echo Yii::t('admin/asterisk', 'Existing Nodes'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-map"></i>
                </span>
                <?php
                    echo CHtml::dropDownList('existing_nodes', "", CHtml::listData($asterArray, 'id_asterisk','asterisk_name'), array('maxlength'=>200, 'class'=>'form-control', 'style'=>'width:250px', 'data-theme'=>"e", 'empty' => Yii::t('admin/asterisk', 'Choose option')));
                ?>
            </div>
        </div>
        <div class="col-sm-4"><br/>
            <?php echo Chtml::button(Yii::t('asmin/asterisk', 'Copy & Confirm'), array('onClick' => 'javascript:copyNodesInfo();', 'class'=>'btn btn-primary'));?>
        </div>
        <br />
        <div class="col-lg-3" style="padding: 0;">
            <?php echo $form->error($model,'asterisk_name', array('class' => 'alert alert-danger')); ?>
        </div>
    </div><br/>

	<div class="row">
        <label class="control-label" for="asterisk_name"><?php echo $form->labelEx($model,'asterisk_name'); ?></label>
		<div class="input-group date col-sm-4">
            <span class="input-group-addon">
                <i class="fa  fa-info"></i>
            </span>
		  <?php echo $form->textField($model,'asterisk_name',array('size'=>60,'maxlength'=>150, 'class'=>'form-control', 'style'=>'width:250px')); ?>
        </div>
        <br />
	    <div class="col-lg-3" style="padding: 0;">
            <?php echo $form->error($model,'asterisk_name', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>

	<div class="row">
        <label class="control-label" for="asterisk_url"><?php echo $form->labelEx($model,'asterisk_url'); ?></label>
		<div class="input-group date col-sm-4">
            <span class="input-group-addon">
                <i class="fa  fa-history"></i>
            </span>
		  <?php echo $form->textField($model,'asterisk_url',array('size'=>60,'maxlength'=>200, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>'http://mialert.ast')); ?>
        </div>
        <br />
		<div class="col-lg-3" style="padding: 0;">
            <?php echo $form->error($model,'asterisk_url', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>
	<div class="row">
        <label class="control-label" for="voip_url"><?php echo $form->labelEx($model,'voip_url'); ?></label>
		<div class="input-group date col-sm-4">
            <span class="input-group-addon">
                <i class="fa  fa-compass"></i>
            </span>
		  <?php echo $form->textField($model,'voip_url',array('size'=>60,'maxlength'=>200, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>'http://mialert.ast')); ?>
        </div>
        <br />
		<div class="col-lg-3" style="padding: 0;">
            <?php echo $form->error($model,'voip_url', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>

	<div class="row">
        <label class="control-label" for="id_building"><?php echo $form->labelEx($model,'id_building'); ?></label>
        <div class="input-group date col-sm-4">
            <span class="input-group-addon">
                <i class="fa  fa-building-o"></i>
            </span>
            <div class="form-group">
                <div class="controls">
                    <?php
                        echo $form->dropDownList($model, 'id_building', CHtml::listData(Buildings::model()->findAll(), 'id_building','name'), array('class'=>'form-control','style'=>"width: 250px;",  'data-native-menu'=>"false", 'data-theme'=>"e"));
                    ?>
                </div>
            </div>
        </div>
        <br />
        <div class="col-lg-3" style="padding: 0;">
            <?php echo $form->error($model,'id_building', array('class' => 'alert alert-danger')); ?>
        </div>
	</div>
    <div class="row">
        <label class="control-label" for="user"><?php echo $form->labelEx($model,'user'); ?></label>
        <div class="input-group date col-sm-4">
            <span class="input-group-addon">
                <i class="fa  fa-compass"></i>
            </span>
            <?php echo $form->textField($model,'user',array('size'=>60,'maxlength'=>200, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>'User Name')); ?>
        </div>
        <br />
        <div class="col-lg-3" style="padding: 0;">
            <?php echo $form->error($model,'user', array('class' => 'alert alert-danger')); ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label" for="passwd"><?php echo $form->labelEx($model,'passwd'); ?></label>
        <div class="input-group date col-sm-4">
            <span class="input-group-addon">
                <i class="fa  fa-compass"></i>
            </span>
            <?php echo $form->textField($model,'passwd',array('size'=>60,'maxlength'=>200, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>'Password')); ?>
        </div>
        <br />
        <div class="col-lg-3" style="padding: 0;">
            <?php echo $form->error($model,'passwd', array('class' => 'alert alert-danger')); ?>
        </div>
    </div>
    <br/>
	<div class="row buttons">
		<div class="col-lg-4">
            <?php
                echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
                echo "&nbsp;&nbsp;&nbsp;";
                echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary',)); ?>
        </div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->