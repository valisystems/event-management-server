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
	'enableAjaxValidation'=>true,
    //'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	)
));
echo $form->hiddenField($model, 'language', array('value'=>'en'));
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
    <div class="container" style="">
        <div class="row">
            <div class="row step">
                <div id="div1" class="col-md-2  activestep" onclick="javascript: resetActive(event, 0, 'step-1');">
                    <span class="fa fa-user"></span>
                    <p><?php echo Yii::t('admin/positioning', 'Device');?></p>
                </div>
                <div class="col-md-2" onclick="javascript: resetActive(event, 15, 'step-2');">
                    <span class="fa fa-camera"></span>
                    <p><?php echo Yii::t('admin/positioning', 'Profile');?></p>
                </div>
            </div>
        </div>
        <div class="row setup-content activeStepInfo" id="step-1">
            <?php echo $form->hiddenField($model,'coordonate_on_map',array('id'=>'coordinate_on_map')); ?>
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
                                            /*'ajax' => array(
                                                'type'=>'POST',
                                                'url'=>$this->createUrl('floorList'),
                                                'update'=>'#'.CHtml::activeId($model, 'id_map'), // ajax updates package_id, but I want ajax update registration_id if I select item no 4
                                                'data'=>array('id_building'=>'js:this.value'),
                                            )*/
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
                                        'onChange'=>'javascript:getMapImage(this)',
                                        'data-rel'=>"chosen"
                                    )
                                );
                            ?>
                        </div>
                    </div>
                    <br />
                    <div class="col-lg-6" style="padding: 0;">
                        <?php echo $form->error($model,'id_map', array('class' => 'alert alert-danger')); ?>
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
            </div> <!-- div column col-lg-6 col-sm-6 -->
            <div class="col-lg-6 col-sm-6">
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
                    <label class="control-label" for="ip_address"><?php echo Yii::t("admin/devices",'IP Address'); ?></label>
                    <div class="input-group date col-sm-4">
                        <span class="input-group-addon">
                            <i class="fa  fa-flag-o"></i>
                        </span>
                        <?php echo $form->textField($model,'ip_address',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/devices', 'IP Address'))); ?>
                    </div>
                    <br />
                    <div class="col-lg-6" style="padding: 0;">
                        <?php echo $form->error($model,'ip_address', array('class' => 'alert alert-danger')); ?>
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
            </div> <!-- div column col-lg-6 col-sm-6 -->
            <div class="row col-lg-12">
                <?php
                    //echo $form->hiddenField($model, 'coordonate_on_map');
                ?>
            </div>
            <div class="row" id="maps" style="clear: both;">
            <?php
                if (!$model->isNewRecord) {
                    $data=Maps::model()->findByPk($model->id_map);

                    if (!empty($data->path_to_img)) {
                        $str = '';
                        $script = '<script>
                            $(document).ready($(function () {
                                $( "#devicePosition" ).draggable(
                                    {
                                        containment: "#roomConstruction",
                                        scroll: false,
                                        stop: function() {
                                            var pPlan = $("#roomConstruction").position();
                                            var p = $( "#devicePosition" );
                                            console.log(pPlan.left, pPlan.top);

                                            var position = p.position();
                                            $("#coordinate_on_map").val( (parseInt(position.left) - parseInt(pPlan.left))+";"+ (parseInt(position.top) - parseInt(pPlan.top)));
                                        }
                                    }
                                );
                            }));
                            //$( "#roomPosition" ).offset({top:10, left: 10});
                        </script>
                        ';

                        //Yii::app()->clientScript->registerScript("dragScript",$script);
                        list($width, $height, $type, $attr) = getimagesize(substr($data->path_to_img, 1));
                        $str .= '<div id="roomConstruction" style="width: '.$width.'px;height: '.$height.'px;clear:both">';
                        $str .= "<img src='".$data->path_to_img."' border=0 usemap='#roomPositionsMap' id='roomPositionsImg'/>";
                        $str .= "<div id='devicePosition' class='btn btn-sm btn-danger draggable ui-widget-content'>".$model->device_description."</div>";
                        $str .= '</div>';
                        echo $str.$script;
                    }
                }
            ?>
            </div>
        <br />
        </div>
        <div class="row setup-content   hiddenStepInfo" id="step-2">
            <div class="form-group">
                <div class="col-xs-1">
                    <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
                </div>
            </div><br />
            <?php
            if (!$model->isNewRecord) {
                if (count($modelInput)) {
                    ?>
                    <div class="col-lg-6 col-sm-6">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th><?php echo Yii::t('admin/patients', 'Name'); ?></th>
                                <th><?php echo Yii::t('admin/patients', 'ID'); ?></th>
                                <th><?php echo Yii::t('admin/patients', 'Action'); ?></th>
                            </tr>
                            </thead>

                            <tbody>
                                <?php
                                    foreach ($modelInput as $kl) {
                                        echo "<tr>
                                            <td> ".$kl->io_name."</a></td>
                                            <td><a href='#' class='id_in_dev_edit' data-type='text' data-name='io_id' data-pk='".$kl->id_input_device."' data-url='/admin/positioning/changeIO' data-title='Enter I/O ID'>".$kl->io_id."</a></td>
                                            <td><a href='#' onClick='javascript:deleteIO(this, ".$kl->id_input_device.");'><i class='fa fa-trash-o'></i></a></td>
                                        </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                }
            }
            ?>

            <div class="form-group hide  io-form-group col-lg-12 col-sm-12" id="ioTemplate">
                <div class="col-xs-4">
                    <div class="col-xs-12 col-xs-offset-1">
                        <label class="control-label" for="io_name"><?php echo Yii::t('asmin/devices','I/O Name'); ?></label>
                        <input type="text" class="form-control" name="io_name" placeholder="I/O Name" />
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="col-xs-12">
                        <label class="control-label" for="io_id"><?php echo Yii::t('asmin/devices','I/O ID'); ?></label>
                        <input type="text" class="form-control" name="io_id" placeholder="I/O ID" />
                    </div>
                </div>
                <div class="col-xs-1">
                    <div class="col-xs-1"><br/>
                        <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                    <br />
            </div>
        </div>
    </div>
</div><!-- form -->
<div class="row buttons">
	<?php 
    echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
    echo "&nbsp;&nbsp;&nbsp;";
    echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary', 'id'=>'btnSave')); ?>
</div>
<?php $this->endWidget(); ?>



<script>

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