<script>
    openFormExt = 0;
</script>
<?php Yii::app()->clientScript->registerCoreScript('jquery');
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
    foreach($flashMessages as $key => $message) {
        $css_class = "";
        if (substr_count($key, 'success'))
            $css_class = "alert alert-success";
        else if (substr_count($key, 'warning'))
                $css_class = "alert alert-danger";
        echo '<div class="row">
            <div class="alert alert-success">'.$message.'
            </div>
        </div>'; 
    }
}
$id_extension = (isset($model->id_extension) && $model->id_extension != 0) ? $model->id_extension : -1;
$ext_number = (isset($model->extension_number) && $model->extension_number != 0) ? $model->extension_number : "";
$caller_id_name = (isset($model->caller_id_name) && !empty($model->caller_id_name)) ? $model->caller_id_name : "";
$caller_id_external = (isset($model->caller_id_external) && !empty($model->caller_id_external)) ? $model->caller_id_external : "";
$caller_id_internal = (isset($model->caller_id_internal) && !empty($model->caller_id_internal)) ? $model->caller_id_internal : "";
$password = (isset($model->extension_password) && !empty($model->extension_password)) ? $model->extension_password : "";

if ($model->extension_number == 0 || empty($model->extension_number) || $model->viewEditForm){
    echo "<div class='row col-lg-6'>".CHtml::button(Yii::t('admin/devices', 'Generate Extension'), array('onClick' => 'js:openFormCreateExtension()', 'class'=>'btn btn-primary'))."</div><br/><br/>";

?>
<?php if ($model->viewEditForm) {
?>
<div id="extForm" class="row col-lg-9">
<?php
} else {?>
<div id="extForm" style="display: none;" class="row col-lg-9">
<?php }?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'extension-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	)
));

echo $form->hiddenField($model,'id_device',array('value'=>$model->id_device));
echo $form->hiddenField($model,'id_extension',array('value'=>$model->id_extension));
echo $form->hiddenField($model,'id_building',array('value'=>$model->id_building));
echo $form->hiddenField($model,'id_room',array('value'=>$model->id_room));
?>

    <div class="row col-lg-9">
        <label class="control-label" for="extension_define"><?php echo Yii::t('admin/devices','Extension define'); ?></label><br />
        <div class="controls">
            <?php
                echo $form->radioButtonList($model,'extension_define',array('0' => Yii::t('admin/devices','Auto'), '1' => Yii::t('admin/devices','Manual')),array('separator'=>'&nbsp;&nbsp;', 'onChange'=>'javascript:extensionDefine(this);'));
            ?>&nbsp;&nbsp;&nbsp;
        </div>
    </div><br />
    <div class="row col-lg-9" id="extNb" style="display: none;">
        <label class="control-label" for="extension_number"><?php echo $form->label($model,Yii::t('admin/devices','Extension number')); ?></label><br />
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa  fa-comment-o"></i>
            </span>
            <?php echo $form->textField($model,'extension_number',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/devices', 'Extension number'))); ?>
        </div><br />
        <div class="col-lg-6" style="padding: 0;">
            <?php echo $form->error($model,'extension_number', array('class' => 'alert alert-danger')); ?>
        </div><br />
    </div>
    <div class="row col-lg-9">
        <label class="control-label" for="caller_id_internal"><?php echo $form->label($model,Yii::t('admin/devices','Caller ID Internal')); ?></label><br />
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa  fa-comment-o"></i>
            </span>
            <?php echo $form->textField($model,'caller_id_internal',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/devices', 'Caller ID Internal'))); ?>
        </div><br />
        <div class="col-lg-6" style="padding: 0;">
            <?php echo $form->error($model,'caller_id_internal', array('class' => 'alert alert-danger')); ?>
        </div>
    </div><br />
    <div class="row col-lg-9">
        <label class="control-label" for="caller_id_external"><?php echo $form->label($model,Yii::t('admin/devices','Caller ID External')); ?></label><br />
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa  fa-comment-o"></i>
            </span>
            <?php echo $form->textField($model,'caller_id_external',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/devices', 'Caller ID External'))); ?>
        </div><br />
        <div class="col-lg-6" style="padding: 0;">
            <?php echo $form->error($model,'caller_id_external', array('class' => 'alert alert-danger')); ?>
        </div>
    </div><br /> 
    <div class="row col-lg-9">
        <label class="control-label" for="caller_id_name"><?php echo $form->label($model,Yii::t('admin/devices','Caller ID Name')); ?></label><br />
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa  fa-comment-o"></i>
            </span>
            <?php echo $form->textField($model,'caller_id_name',array('size'=>10, 'class'=>'form-control', 'style'=>'width:250px', 'placeholder'=>Yii::t('admin/devices', 'Caller ID Name'))); ?>
        </div><br />
        <div class="col-lg-6" style="padding: 0;">
            <?php echo $form->error($model,'caller_id_name', array('class' => 'alert alert-danger')); ?>
        </div>
    </div><br /> 
    <div class="row col-lg-9">
	<?php 
        echo CHtml::button(Yii::t('admin/devices', 'Save Extension'), array('onClick' => 'js:saveFormExtension()', 'class'=>'btn btn-primary'));?><br /><br />
    </div>
<?php $this->endWidget(); ?>
</div>
<?php }?>
<?php
if ($id_extension > 0) {
$asterInfo = Asterisk::model()->findByPk($model->extensionInfos['id_asterisk']);

?>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
    <thead>
        <tr>
            <th><?php echo Yii::t('admin/devices', 'Nodes')?></th>
            <th><?php echo Yii::t('admin/devices', 'Extension Number')?></th>
            <th><?php echo Yii::t('admin/devices', 'Caller ID Name')?></th>
            <th><?php echo Yii::t('admin/devices', 'Caller ID External')?></th>
            <th><?php echo Yii::t('admin/devices', 'Caller ID Internal')?></th>
            <th><?php echo Yii::t('admin/devices', 'Password')?></th>
            <th><?php echo Yii::t('admin/devices', 'Action')?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><span title='<?php echo $asterInfo['asterisk_name'];?>' data-delay='{ \"hide\": \"3000\"}'  data-html='true' data-content='<?php echo $asterInfo['asterisk_url']?>' data-toggle='popover' data-trigger='hover' data-placement='right'><?php echo $asterInfo['asterisk_name'];?></span></td>
            <td><?php echo $ext_number;?></td>
            <td><?php echo $caller_id_name;?></td>
            <td><?php echo $caller_id_external;?></td>
            <td><?php echo $caller_id_internal;?></td>
            <td><?php echo $password;?></td>
            <td><a href="javascript:void(0)" onclick="javascript:editExtension(<?php echo $id_extension;?>, <?php echo $model->id_device;?>)"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="javascript:deleteExtension(<?php echo $id_extension;?>, <?php echo $model->id_device;?>, '<?php echo Yii::t('admin/devices', 'Are you sure want to delete extension')?>')"><i class="fa fa-trash-o"></i></a></td>
        </tr>
    </tbody>
</table>
<?php }?>

<script>
    $(document).ready($(function () {
        $("[data-toggle='popover']").popover({"html": true, "trigger": "hover", "delay": {"show": 500, "hide": 2000}});
        $(".popover").css("max-width", "750px");
    }));
</script>