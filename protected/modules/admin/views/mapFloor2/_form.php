<?php 
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'mapFloor-form',
    'enableAjaxValidation'=>true,
)); 

?>
<div class="row buttons">
        <?php echo CHtml::ajaxSubmitButton(Yii::t('job','Create Job'),CHtml::normalizeUrl(array('mapFloor/addNew','render'=>false)),array('success'=>'js: function(data) {
                        //$("#Person_jid").append(data);
                        $("#mapAddDialog").dialog("close");
                    }'),array('id'=>'closeMapAddDialog')); ?>
    </div>
 
<?php $this->endWidget(); ?>