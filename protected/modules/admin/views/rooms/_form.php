<?php
/* @var $this RoomsController */
/* @var $model Rooms */
/* @var $form CActiveForm */
?>

<div class="col-lg-6 col-sm-6">
    <div class="form-group">

    <?php $form=$this->beginWidget('CActiveForm', array(
    	'id'=>'rooms-form',
    	// Please note: When you enable ajax validation, make sure the corresponding
    	// controller action is handling ajax validation correctly.
    	// There is a call to performAjaxValidation() commented in generated controller code.
    	// See class documentation of CActiveForm for details on this.
    	'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
    )); ?>
    
    	<p class="note">Fields with <span class="required">*</span> are required.</p>
    
    	<?php echo $form->errorSummary($model, null, null, array('class'=>'alert alert-warning')); ?>
        <?php //echo $form->hiddenField($model,'coordinate_on_map',array('id'=>'coordinate_on_map')); ?>
        <div class="row">
            <div class="col-lg-6">
                <label class="control-label" for="name_map"><?php echo Yii::t("admin/rooms",'Building'); ?></label>
                <div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-institution"></i>
                    </span>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'id_building', CHtml::listData(Buildings::model()->findAll(), 'id_building','name'),
                            array(
                                'class'=>'form-control',
                                'style'=>"width: 250px;",
                                //'data-rel'=>"chosen",
                                'prompt' => Yii::t('admin/rooms','Select Building'),
                                'ajax' => array(
                                    'type'=>'POST',
                                    'url'=>$this->createUrl('floorList'),
                                    //'update'=>'#'.CHtml::activeId($model, 'id_map'), // ajax updates package_id, but I want ajax update registration_id if I select item no 4
                                    'data'=>array('id_building'=>'js:this.value'),
                                    'success' => 'function(data){
                                                $("#Rooms_id_map").html(data);
                                                $("#roomConstruction").empty();
                                            }'

                                )
                            )
                        );
                        ?>
                    </div>
                </div>
                <br />
                <div class="col-lg-12" style="padding: 0;">
                    <?php echo $form->error($model,'id_building', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <label class="control-label" for="name_map"><?php echo Yii::t("admin/rooms",'Floor'); ?></label>
                <div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-building-o"></i>
                    </span>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'id_map', $model->getFloorList($model->id_building),
                            array(
                                'class'=>'form-control',
                                'style'=>'width:250px',
                                'ajax' => array(
                                    'type'=>'post',
                                    'url'=>$this->createUrl('floorInfo'),
                                    'data'=>array('id_map'=>'js:this.value', 'nbRoom'=>'js:$("#nb_room").val()'),
                                    'update'=>'#maps',

                                )
                            )
                        );
                        ?>
                    </div>
                </div>
                <br />
                <div class="col-lg-12" style="padding: 0;">
                    <?php echo $form->error($model,'id_map', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>
        </div>
        <div class="row">
    		<div class="col-lg-6">
                <label class="control-label" for="nb_room"><?php echo $form->labelEx($model,Yii::t("admin/rooms",'Room number')); ?></label>
        		<div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-sort-numeric-asc"></i>
                    </span>
                    <?php echo $form->textField($model,'nb_room',array('size'=>10,'maxlength'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'value'=>'','placeholder'=>Yii::t('admin/rooms', 'Room number'))); ?>
                </div>
                <br />
                <div class="col-lg-12" style="padding: 0;">
        		    <?php echo $form->error($model,'nb_room', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>
    	</div>
    
    	<div class="row">
    		<div class="col-lg-6">
                <label class="control-label" for="name_map"><?php echo $form->labelEx($model,'nb_of_seats'); ?></label>
        		<div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-hotel"></i>
                    </span>
                    <?php echo $form->textField($model,'nb_of_seats',array('size'=>10,'maxlength'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'value'=>'', 'placeholder'=>Yii::t('admin/rooms', 'Number of beds'))); ?>
                </div>
                <br />
                <div class="col-lg-12" style="padding: 0;">
        		    <?php echo $form->error($model,'nb_of_seats', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>
    	</div>

    	<div class="row" id="maps">
    	</div>
        <br />
    	<div class="row buttons">
    	   <?php 
                echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
                echo "&nbsp;&nbsp;&nbsp;";
                echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary', 'id' => 'submitRooms')); ?>
    	</div>
    
    <?php $this->endWidget(); ?>
    
    </div><!-- form -->
</div>