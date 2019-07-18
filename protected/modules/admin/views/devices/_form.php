<?php
/* @var $this DevicesController */
/* @var $model Devices */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'devices-form',
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
<style>
.mapActive {
    border-color : blue;
    background : grey;
}  
.mapHover {
    border-color : red;
    background : green;
}

</style>
<div class="form-group">
    <?php echo $form->errorSummary($model,null, null,array('class'=>'alert alert-danger')); ?>

    <input type="hidden" name="id_device_update" id="id_device_update" value="<?php echo $model->id_device;?>"/>
    <div class="col-lg-6 col-sm-6">
        <div class="row">
            <label class="control-label" for="name_map"><?php echo Yii::t("admin/devices",'Building'); ?></label>
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
                                    'data-rel'=>"chosen",
                                    'prompt' => Yii::t('admin/devices','Select Building'),
                                    'ajax' => array(
                                        'type'=>'POST',
                                        'url'=>$this->createUrl('floorList'), 
                                        'update'=>'#'.CHtml::activeId($model, 'id_map'), // ajax updates package_id, but I want ajax update registration_id if I select item no 4
                                        'data'=>array('id_building'=>'js:this.value'),
                                    )
                                )
                            );
                    ?>
			    </div>
            </div>
    		<br />
    	    <div class="col-lg-6" style="padding: 0;">
                <?php echo $form->error($model,'id_building', array('class' => 'alert alert-danger')); ?>
            </div>
    	</div>
        <br />
     	<div class="row">
            <label class="control-label" for="id_map"><?php echo Yii::t("admin/devices",'Floor'); ?></label>
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
                                    'url'=>$this->createUrl('roomList'),
                                    'data'=>array('id_map'=>'js:this.value', 'nbRoom'=>'js:$("#nb_room").val()'),
                                    //'update'=>'#'.CHtml::activeId($model, 'id_room'),
                                    'success' => 'function(data){
                                        $("#Devices_id_room").html(data);
                                        getMapImage($("#Devices_id_map").val());
                                    }'
                                )
                            )
                        );
                    ?>
			    </div>
            </div>
    		<br />
    	    <div class="col-lg-6" style="padding: 0;">
                <?php echo $form->error($model,'id_map', array('class' => 'alert alert-danger')); ?>
            </div>
    	</div> 
        <br />
        <div class="row">
            <label class="control-label" for="id_room"><?php echo Yii::t("admin/devices",'Room'); ?></label>
    		<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-sort-numeric-asc"></i>
                </span>
                <div class="controls">
                    <?php
                        echo $form->dropDownList($model, 'id_room', $model->getRoomList($model->id_map), 
                            array(
                                'class'=>'form-control', 
                                'style'=>'width:250px',
                            )
                        );
                    ?>
			    </div>
            </div>
    		<br />
    	    <div class="col-lg-6" style="padding: 0;">
                <?php echo $form->error($model,'id_room', array('class' => 'alert alert-danger')); ?>
            </div>
    	</div><br />
        <div class="row">
            <label class="control-label" for="device_description"><?php echo Yii::t("admin/devices",'Device Description'); ?></label>
    		<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-info"></i>
                </span>
                <?php echo $form->textField($model,'device_description',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/devices', 'Device Description'))); ?>
            </div>
    		<br />
    	    <div class="col-lg-6" style="padding: 0;">
                <?php echo $form->error($model,'device_description', array('class' => 'alert alert-danger')); ?>
            </div>
    	</div>   <br />
        <div class="row">
            <label class="control-label" for="serial_number"><?php echo Yii::t("admin/devices",'Serial #'); ?></label>
    		<div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-flag-o"></i>
                </span>
                <?php echo $form->textField($model,'serial_number',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/devices', 'Device Serial Number'))); ?>
            </div>
    		<br />
    	    <div class="col-lg-6" style="padding: 0;">
                <?php echo $form->error($model,'serial_number', array('class' => 'alert alert-danger')); ?>
            </div>
    	</div><br />
        <div class="row">
            <label class="control-label" for="language"><?php echo $form->label($model,Yii::t('admin/devices','Language')); ?></label><br />
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-language"></i>
                </span>
                <div class="control">
                <?php
                    echo $form->dropDownList($model, 'language',Yii::app()->params['languages'], array('class'=>'form-control', 'style'=>'width:250px', 'data-rel'=>"chosen"));
                ?>
                </div>
		    </div>
        </div><br />
        <!--div class="row">
            <label class="control-label" for="activity_timer_status"><?php echo $form->label($model,Yii::t('admin/devices','Activity Timer')); ?></label><br />
            <div class="controls col-md-4">
                <?php
                    echo $form->radioButtonList($model,'activity_timer_status',array(0=>Yii::t('admin/devices','No'), 1=>Yii::t('admin/devices','Yes')),array('separator'=>'&nbsp;&nbsp;', 'onChange'=>'javascript:changeActivityTimer(this);'));
                ?>&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-md-2">
                <?php
                    echo $form->dropDownList($model, 'activity_timer',array('1'=>'1 s', '2'=>'2 s', '3'=>'3 s', '4'=>'4 s','5'=>'5 s'), array('class'=>'form-control','style'=>"width: 75px", 'id'=>'activity_timer'));
                ?>
            </div>
        </div><br /-->
        <div class="row">
            <label class="control-label" for="nurce_aknowege_status"><?php echo $form->label($model,Yii::t('admin/devices','Nurse Acknowledge')); ?></label><br />
            <div class="controls col-md-4">
                <?php
                    $model->isNewRecord ? $model->nurce_aknowege_status = 0: $model->nurce_aknowege_status = $model->nurce_aknowege_status ;
                    echo $form->radioButtonList($model,'nurce_aknowege_status',array(0=>Yii::t('admin/devices','No'), 1=>Yii::t('admin/devices','Yes')),array('separator'=>'&nbsp;&nbsp;', 'onChange'=>'javascript:changeNurceAknowegeTimer(this);'));
                ?>
            </div>
            <div class="col-md-2">
                <?php
                    echo $form->dropDownList($model, 'nurce_aknowege',array('1'=>'1 s', '2'=>'2 s', '3'=>'3 s', '4'=>'4 s','5'=>'5 s'), array('class'=>'form-control','style'=>"width: 75px", 'id'=>'nurce_aknowege'));
                ?>
            </div>
        </div><br />   
        <!--div class="row">
            <label class="control-label" for="call_duration"><?php echo $form->label($model,Yii::t('admin/devices','Call Duration')); ?></label><br />
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-comment-o"></i>
                </span>
                <div class="control">
                <?php
                    echo $form->dropDownList($model, 'call_duration',array('1'=>'1 s', '2'=>'2 s', '3'=>'3 s', '4'=>'4 s','5'=>'5 s'), array('class'=>'form-control', 'id'=>'call_duration', 'style'=>'width:250px'));
                ?>
                </div>
            </div>
        </div><br /-->
        <!--div class="row">
            <label class="control-label" for="auto_test_status"><?php echo $form->label($model,Yii::t('admin/devices','Auto Test')); ?></label><br />
            <div class="controls col-md-4">
                <?php
                    echo $form->radioButtonList($model,'auto_test_status',array(0=>Yii::t('admin/devices','No'), 1=>Yii::t('admin/devices','Yes')),array('separator'=>'&nbsp;&nbsp;', 'onChange'=>'javascript:changeAutoTestTimer(this);'));
                ?>&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-sm-4">
                <?php
                    echo $form->dropDownList($model, 'auto_test',array('1'=>'1 s', '2'=>'2 s', '3'=>'3 s', '4'=>'4 s','5'=>'5 s'), array('class'=>'form-control','style'=>"width: 75px", 'id'=>'auto_test'));
                ?>
            </div>
        </div><br /-->
    </div> <!-- div column col-lg-6 col-sm-6 -->
    <div class="col-lg-6 col-sm-6">
        <div class="row">
            <label class="control-label" for="position_popup"><?php echo $form->labelEx($model,'position_popup'); ?></label>
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-bell"></i>
                </span>
                <?php
                    echo $form->dropDownList($model, 'position_popup', Yii::app()->params['devicePosition'], array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Choose Options'),));
                ?>
		    </div>
            <?php echo $form->error($model,'position_popup', array('class' => 'alert alert-danger')); ?>
    	</div><br />
        
        <div class="row">
            <label class="control-label" for="comon_area"><?php echo $form->label($model,Yii::t('admin/devices','Common Area')); ?></label><br />
            <div class="controls col-md-4">
                <?php
                    $model->isNewRecord ? $model->comon_area = 0: $model->comon_area = $model->comon_area ;
                    echo $form->radioButtonList($model,'comon_area',array(0=>Yii::t('admin/devices','No'), 1=>Yii::t('admin/devices','Yes')),array('separator'=>'&nbsp;&nbsp;', 'onChange'=>'javascript:changeNurceAknowegeTimer(this);'));
                ?>&nbsp;&nbsp;&nbsp;
            </div>
        </div><br />
        <div class="row">
            <label class="control-label" for="comon_area"><?php echo Yii::t('admin/devices','Extension define'); ?></label><br />
            <div class="controls col-md-4">
                <?php
                    echo $form->radioButtonList($model,'extension_define',array(0=>Yii::t('admin/devices','Auto'), 1=>Yii::t('admin/devices','Manual')),array('separator'=>'&nbsp;&nbsp;', 'onChange'=>'javascript:extensionDefine(this);'));
                ?>&nbsp;&nbsp;&nbsp;
            </div>
        </div><br />
        <div class="row" id="extNb" style="display: none;">
            <label class="control-label" for="extension_number"><?php echo $form->label($model,Yii::t('admin/devices','Extension number')); ?></label><br />
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-tty"></i>
                </span>
                <?php echo $form->textField($model,'extension_number',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/devices', 'Extension number'))); ?>
            </div><br />
            <div class="col-lg-6" style="padding: 0;">
                <?php echo $form->error($model,'extension_number', array('class' => 'alert alert-danger')); ?>
            </div><br />
        </div>
        <div class="row">
            <label class="control-label" for="caller_id_internal"><?php echo $form->label($model,Yii::t('admin/devices','Caller ID Internal')); ?></label>&nbsp;
            <?php
            if (!empty($model->extension_password)){
            ?>
            <span title='<?php echo $model->extension_number;?>' data-html='true' data-delay='{ "hide": "3000"}' data-content='<?php echo $model->extension_password;?>' data-toggle='popover' data-trigger='hover' data-placement='right'><i class="fa fa-key"></i></span>
            <?php }?>
            <br />
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-child"></i>
                </span>
                <?php echo $form->textField($model,'caller_id_internal',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/devices', 'Caller ID Internal'))); ?>
            </div><br />
            <div class="col-lg-6" style="padding: 0;">
                <?php echo $form->error($model,'caller_id_internal', array('class' => 'alert alert-danger')); ?>
            </div>
        </div><br />
        <div class="row">
            <label class="control-label" for="caller_id_external"><?php echo $form->label($model,Yii::t('admin/devices','Caller ID External')); ?></label><br />
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-male"></i>
                </span>
                <?php echo $form->textField($model,'caller_id_external',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/devices', 'Caller ID External'))); ?>
            </div><br />
            <div class="col-lg-6" style="padding: 0;">
                <?php echo $form->error($model,'caller_id_external', array('class' => 'alert alert-danger')); ?>
            </div>
        </div><br /> 
        <div class="row">
            <label class="control-label" for="caller_id_name"><?php echo $form->label($model,Yii::t('admin/devices','Caller ID Name')); ?></label><br />
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-female"></i>
                </span>
                <?php echo $form->textField($model,'caller_id_name',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/devices', 'Caller ID Name'))); ?>
            </div><br />
            <div class="col-lg-6" style="padding: 0;">
                <?php echo $form->error($model,'caller_id_name', array('class' => 'alert alert-danger')); ?>
            </div>
        </div><br />
        <div class="row">
            <label class="control-label" for="device_type"><?php echo $form->label($model,Yii::t('admin/devices','device_type')); ?></label><br />
            <div class="input-group date col-sm-4">
                <span class="input-group-addon">
                    <i class="fa  fa-futbol-o"></i>
                </span>
                <div class="control">
                <?php
                    echo $form->dropDownList($model, 'device_type',Yii::app()->params['device_type'], array('class'=>'form-control', 'style'=>'width:250px', 'data-rel'=>"chosen"));
                ?>
                </div>
		    </div>
        </div><br />
    </div> <!-- div column col-lg-6 col-sm-6 -->
    <div class="row" id="maps" style="clear: both;">


    <?php
        if (!$model->isNewRecord) {

            $data=Maps::model()->findByPk($model->id_map);
            
            if (!empty($data->path_to_img)) {
                $str = '';
                $script = '<script>
                    $(document).ready($(function () {
                       //$("#roomPositionsImg").remove();
                        $("#coordinate_convas").canvasAreaDraw({
                            activePoint: false,
                            readOnly: true
                        });
                        var coordonate = $("#coordinate_on_map").val().split(";");

                        $("#devicePosition" ).draggable(
                            {
                                containment: "#roomConstruction",
                                scroll: false,
                                stop: function() {
                                    var pPlan = $("#roomConstruction").position();
                                    var p = $( "#devicePosition" );
                                    //console.log(pPlan.left, pPlan.top);

                                    var position = p.position();
                                    $("#coordinate_on_map").val( (parseInt(position.left) - parseInt(pPlan.left))+";"+ (parseInt(position.top) - parseInt(pPlan.top)));
                                }
                            }
                        );
                        setTimeout(function(){
                            var convasPosition =  $("canvas").offset();
                            var newPositionTop = parseInt(coordonate[1]);
                            var newPositionLeft = parseInt(coordonate[0]);
                            xTmp = parseInt(coordonate[0]);
                            yTmp = parseInt(coordonate[1]);
                            var coord = $("#coordinate_convas").val();
                            var coordonateArray = new Array();
                            coordonateArray = coord.split(",").map(Number);
                            //console.log(coord);

                            //console.log(coordonateArray.length);
                            x1,x2, y1, y2 = 0;
                            for (var i = 0; i < (coordonateArray.length/2); i++) {
                                if(i == 0) {
                                    x1 = x2 = coordonateArray[i*2];
                                    y1 = y2 = coordonateArray[i*2+1];
                                }
                                if (i > 0) {
                                    if (x1 > coordonateArray[i*2]) {
                                        x1 = coordonateArray[i*2];
                                    }
                                    if (y1 < coordonateArray[i*2+1]) {
                                        y1 = coordonateArray[i*2+1];
                                    }

                                    if (x2 < coordonateArray[i*2]) {
                                        x2 = coordonateArray[i*2];
                                    }
                                    if (y2 > coordonateArray[i*2+1]) {
                                        y2 = coordonateArray[i*2+1];
                                    }

                                }
                            }

                            $("#devicePosition" ).offset({top:parseInt(convasPosition.top)+newPositionTop, left: parseInt(convasPosition.left) + newPositionLeft});
                        }, 2000);
                        $("#devicePosition").mouseup(function() {
                            var pos = $(this).position();
                            var x1Pos = parseInt(pos.left) - 13;
                            var y1Pos = parseInt(pos.top) - 745;
                            if (x1Pos >= x1 && x1Pos <= x2 && y1Pos >= y2 && y1Pos <= y1) {

                            } else {
                                var convasPosition =  $("canvas").offset();
                                $(this).offset({left: parseInt(convasPosition.left) + xTmp, top: parseInt(convasPosition.top)+yTmp});
                                alert("Out of room area")
                            }
                        });
                    }));
                    //$( "#roomPosition" ).offset({top:10, left: 10});
                </script>
                ';
                
                //Yii::app()->clientScript->registerScript("dragScript",$script);
                list($width, $height, $type, $attr) = getimagesize(substr($data->path_to_img, 1));
                $str .= '<div id="roomConstruction" style="width: '.$width.'px;height: '.$height.'px;clear:both">';
                $str .= $form->hiddenField($model,'coordonate_on_map',array('id'=>'coordinate_on_map'));
                $coordinate = (!empty($model->id_room)) ? $model->idRoom->coordinate_on_map : "";
                $str .= '<input id="coordinate_convas" name="coordinate_convas" type="hidden" value="'.$coordinate.'" data-image-url="'.$model->idMap->path_to_img.'"/>';
                //$str .= "<img src='".$data->path_to_img."' border=0 usemap='#roomPositionsMap' id='roomPositionsImg'/>";
                $str .= "<div id='devicePosition' class='btn btn-sm btn-danger draggable ui-widget-content'>".$model->device_description."</div>";
                $str .= '</div>';
                echo $str.$script;
            }
        }
    ?>
    </div>
        <br />
</div><!-- form -->
<div class="row buttons">
	<?php 
    echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
    echo "&nbsp;&nbsp;&nbsp;";
    echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary', 'id'=>'btnSave')); ?>
</div>
<?php $this->endWidget(); ?>

<script>
function changeActivityTimer(vv) {
    if($(vv).val() == 1) {
        $('#activity_timer').removeAttr('disabled');
    } else {
        $('#activity_timer').attr('disabled', '');
    }
}

function changeNurceAknowegeTimer(vv){
    if($(vv).val() == 1) {
        $('#nurce_aknowege').removeAttr('disabled');
    } else {
        $('#nurce_aknowege').attr('disabled', '');
    }
}
function changeAutoTestTimer(vv){
    if($(vv).val() == 1) {
        $('#auto_test').removeAttr('disabled');
    } else {
        $('#auto_test').attr('disabled', '');
    }
}
<?php 
if (!$model->isNewRecord) {
    $posDev = explode(";", $model->coordonate_on_map);
?>
$(document).ready(function(){
    //changePositionOfDev(<?php //echo $posDev[0].",".$posDev[1];?>);
});

<?php  
}
?>
</script>