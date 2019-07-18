<?php
/* @var $this FuncController */
/* @var $form CActiveForm  */
$this->pageTitle=Yii::app()->name .' - '.Yii::t('admin/delivery','title_delivery');
$this->breadcrumbs=array(
	'Delivery miALERT',
);
?>
<style>
    .toggle-handle.btn {
        background: #FFF;
    }
</style>
 <?php $funcSettings = $this->beginWidget('CActiveForm', array(
        'id'=>'access-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableClientValidation'=>true,
    )); ?>
<div id="messages"></div>
<?php
if (count($modelFunction) > 0) {
foreach ($modelFunction as $i => $item){
?>
<div class="row" id="forDelete_<?php echo $i;?>">
    <div class="col-lg-12 col-sm-12">
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4">
                    <label class="control-label" for="description_manufacture"><?php echo $funcSettings->label($item,Yii::t('admin/delivery','Manufacturer')); ?></label>
                    <div class="input-group date col-sm-4">
                        <span class="input-group-addon">
                            <i class="fa fa-plug"></i>
                        </span>
                        <?php echo $funcSettings->hiddenField($item,"[$i]id_support_manufactures", array('class'=>'form-control bfh-phone', 'style'=>'width:250px')) ?>
                        <?php echo $funcSettings->textField($item,"[$i]description_manufacture", array('class'=>'form-control bfh-phone', 'style'=>'width:250px')) ?>
                    </div>
                    <?php echo $funcSettings->error($item,"[$i]description_manufacture", array('class'=>'alert alert-danger', 'style'=>'margin-top:5px;')) ?>
                </div>&nbsp;&nbsp;
                <div class="col-lg-4">
                    <label class="control-label" for="number_manufacture"><?php echo $funcSettings->label($item,Yii::t('admin/delivery','Access Number')); ?></label>
                    <div class="controls">
                        <div class="input-group date col-sm-4">
                            <span class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </span>
                            <?php echo $funcSettings->textField($item,"[$i]number_manufacture", array('class'=>'form-control', 'style'=>'width:250px')) ?>
                        </div>
                    </div>
                    <?php echo $funcSettings->error($item,"[$i]number_manufacture", array('class'=>'alert alert-danger', 'style'=>'margin-top:5px;')) ?>
                </div>
                <div class="col-lg-1">
                    <label class="control-label">&nbsp;</label>
                    <div class="checkbox">
                        <?php echo $funcSettings->checkBox($item,"[$i]status_manufacture",  array("data-toggle" => "toggle")); ?>
                    </div>
                </div>
                <div class="col-lg-2" style="margin-top:10px;margin-left: 10px;">
                    <label class="control-label">&nbsp;</label><br/>
                    <div class="controls">
                        <div class="btn btn-primary" onclick="javascript:removeRecord(<?php echo $i;?>)">
                            <i class='fa fa-trash-o'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }
}
?>
<div id="newRecord" class="row"></div>
<div class="row">
    <div class="row">
        <div class="col-lg-6">
            <?php
            echo CHtml::button('New Record', array('onClick' => "javascript:addNewRecord()", 'class'=>'btn btn-primary')).'&nbsp;&nbsp;&nbsp;';
                echo CHtml::submitButton(Yii::t('admin/functions','Save changes'),
                    array(
                        'class'=>'btn btn-primary',
                        //'disabled'=>'disabled',
                        'ajax'=>array(
                            'type'=>'POST',
                            'dataType'=>'json',
                            'url'=>Yii::app()->createUrl('admin/func/allSave'),
                            'success'=>'function(data) {
                                $("#mail-form alert").hide();
                                if(data.success =="yes")
                                {
                                   location.reload(); 
                                } else if (data.success =="update"){
                                    $("#messages").html("'."<div class=\'alert alert-success\'><button data-dismiss=\'alert\' class=\'close\' type=\'button\'>x</button><strong>Well done!</strong> You successfully read this important alert message.</div>".'");   
                                }
                                else
                                {
                                    $.each(data, function(key, val) 
                                    {
                                      $("#mail-form #"+key+"_em_").text(val);
                                      $("#messages").html("'."<div class=\'alert alert-danger\'><button data-dismiss=\'alert\' class=\'close\' type=\'button\'>x</button>\"+val+\"</div>".'");
                                      $("#mail-form #"+key+"_em_").show();
                                      $("div[for="+key+"]").show();
                                    });
                                }
                            }',
                            'beforeSend'=>'function(){                        
                                
                                $("alert alert-danger").hide();
                            }'

                        ),
                    )
                ); 
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>