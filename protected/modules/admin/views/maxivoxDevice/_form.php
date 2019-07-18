<?php
/**
 * User: iurik
 * Date: 8/3/15
 * Time: 20:02
 */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'maxivox-devices-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>true,
    //'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    )
));
?>
<div class="col-lg-12 col-sm-12">
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
                            'prompt' => Yii::t('admin/maxivox','Select Building'),
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
            <label class="control-label" for="id_map"><?php echo Yii::t("admin/maxivox",'Floor'); ?></label>
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
                                            $("#MaxivoxDevice_id_room").html(data);
                                            //$("#MaxivoxDevice_dev_desc").keyup();
                                            getMapImage($("#MaxivoxDevice_id_map").val());
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
                            'prompt' => Yii::t('admin/maxivox','Select Room'),
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
            <label class="control-label" for="comon_area"><?php echo $form->label($model,Yii::t('admin/devices','Common Area')); ?></label><br />
            <div class="controls col-md-4">
                <?php
                $model->isNewRecord ? $model->comon_area = 0: $model->comon_area = $model->comon_area ;
                echo $form->radioButtonList($model,'comon_area',array(0=>Yii::t('admin/devices','No'), 1=>Yii::t('admin/devices','Yes')),array('separator'=>'&nbsp;&nbsp;', 'id'=>'comon_area', 'onChange'=>'changeComonArea(this)'));
                ?>&nbsp;&nbsp;&nbsp;
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-6">
        <div class="row">
            <label class="control-label" for="dev_desc"><?php echo Yii::t("admin/maxivox",'Device Description'); ?></label>
            <div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-info"></i>
                    </span>
                <?php echo $form->textField($model,'dev_desc',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/maxivox', 'Device Description'))); ?>
            </div>
            <br />
            <div class="col-lg-6" style="padding: 0;">
                <?php echo $form->error($model,'dev_desc', array('class' => 'alert alert-danger')); ?>
            </div>
        </div>   <br />
        <div class="row">
            <label class="control-label" for="dev_address"><?php echo Yii::t("admin/maxivox",'Device Address'); ?></label>
            <div class="input-group date col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa  fa-flag-o"></i>
                    </span>
                <?php echo $form->textField($model,'dev_address',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/maxivox', 'Device Address'))); ?>
            </div>
            <br />
            <div class="col-lg-6" style="padding: 0;">
                <?php echo $form->error($model,'dev_address', array('class' => 'alert alert-danger')); ?>
            </div>
        </div><br />
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
    </div>
</div>
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
                           if ($(\'input:radio[name="MaxivoxDevice[comon_area]"]:checked\').val() == 0) {
                                var pos = $(this).position();
                                var x1Pos = parseInt(pos.left) - 14;
                                var y1Pos = parseInt(pos.top) - 440;
                                if (x1Pos >= x1 && x1Pos <= x2 && y1Pos >= y2 && y1Pos <= y1) {

                                } else {
                                    var convasPosition =  $("canvas").offset();
                                    $(this).offset({left: parseInt(convasPosition.left) + xTmp, top: parseInt(convasPosition.top)+yTmp});
                                    alert("Out of room area")
                                }
                            }
                        });
                    }));
                    //$( "#roomPosition" ).offset({top:10, left: 10});

                    $("#MaxivoxDevice_dev_desc").keyup();
                </script>
                ';

            //Yii::app()->clientScript->registerScript("dragScript",$script);
            list($width, $height, $type, $attr) = getimagesize(substr($data->path_to_img, 1));
            $str .= '<div id="roomConstruction" style="width: '.$width.'px;height: '.$height.'px;clear:both">';
            $str .= $form->hiddenField($model,'coordonate_on_map',array('id'=>'coordinate_on_map'));
            if (!empty($data->id_room))
                $str .= '<input id="coordinate_convas" name="coordinate_convas" type="hidden" value="'.$model->idRoom->coordinate_on_map.'" data-image-url="'.$model->idMap->path_to_img.'"/>';
            else
                $str .= '<input id="coordinate_convas" name="coordinate_convas" type="hidden" value="" data-image-url="'.$model->idMap->path_to_img.'"/>';
            //$str .= "<img src='".$data->path_to_img."' border=0 usemap='#roomPositionsMap' id='roomPositionsImg'/>";
            $str .= "<div id='devicePosition' class='btn btn-sm btn-success draggable ui-widget-content'>".$model->dev_desc."</div>";
            $str .= '</div>';
            echo $str.$script;
        }
    }
    ?>
</div>
<div class="col-lg-6 col-sm-6">
    <div class="row buttons">
        <?php
        echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
        echo "&nbsp;&nbsp;&nbsp;";
        echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary', 'id'=>'btnSave')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>