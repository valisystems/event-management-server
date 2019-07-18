<?php
/* @var $this DevicesController */

$this->breadcrumbs=array(
	'Devices',
);
?>
<div id='ajax_loader' style="display: none;" class="ui-widget-overlay">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; z-index:3000000"/>
</div>
<h1><?php Yii::t('admin/devices','Manage Devices');?></h1>
<?php 
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
    foreach($flashMessages as $key => $message) {
        $css_class = "";
        if (substr_count($key, 'success'))
            $css_class = "alert alert-success";
        else if (substr_count($key, 'success'))
                $css_class = "alert alert-danger";
        echo '<div class="row">
            <div class="'.$css_class.'">'.$message.'
            </div>
        </div>'; 
    }
}
?>
<div class="row">

<?php
echo CHtml::link( 'Create', array( 'create' ),
  array(
    //'class' => 'update-dialog-open-link',
    'data-update-dialog-title' => Yii::t( 'admin/devices','Add Device' ),
    'class'=>'btn btn-primary'
));
echo "<br/>";
?>

</div>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'managePatient',
        'options'=>array(
            'title'=>'Manage Patient',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'400px',
            'height'=>'auto',
            'resizable'=>'false',
            'buttons' => array
            (
                 'Close'=>'js:function(){$(this).dialog("close")}',
                 'Save'=>'js:function(){manageEmaps();}',
            ),
        ),
    ));
$this->endWidget();

$manageDialog =<<<'EOT'
    function() {
        var url = $(this).attr('href');
        $.get(url, function(r){
            $("#managePatient").html(r).dialog("open");
        });
        return false;
    }
EOT;

/**
 * Manage Extension 
 */
 $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'manageExtensions',
        'options'=>array(
            'title'=>'Manage Extension',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'600px',
            'height'=>'auto',
            'resizable'=>'false',
            'buttons' => array
            (
                 'Close'=>'js:function(){$(this).dialog("close")}',
            ),
        ),
    ));
$this->endWidget();

$manageExtension =<<<'EOT'
    function() {
        var url = $(this).attr('href');
        $.get(url, function(r){
            $("#manageExtensions").html(r).dialog("open");
        });
        return false;
    }
EOT;

$tmp = Yii::app()->request->getParam('building_id');
$building_id = (!empty( $tmp )) ? $tmp : -1;

?>
<br/><br/>
<ul class="nav nav-tabs" id="roomsTab">
    <?php
    if ($building_id == -1) {
    ?>
<li role="presentation" class="active">
<?php } else {?>
    <li role="presentation">

        <?php }?>
        <a href="<?php echo Yii::app()->createUrl('admin/devices');?>" role="button" aria-expanded="false">
            <?php echo Yii::t('admin/patients', 'All')?>
        </a>
    </li>
    <?php
    $buildings = Buildings::model()->findAll();
    $html = "";
    foreach ($buildings as $k){
        $floor = "";
        foreach($k->floor as $fl){
            $floor .= "<li><a href='".Yii::app()->createUrl('admin/devices/floor/id/'.$fl->id_map.'/building_id/'.$fl->id_building) ."'>{$fl->name_map}</a></li>";
        }
        if ($floor != "") {
            if ($k->id_building == $building_id)
                $html .= "<li role='presentation' class='dropdown active'>";
            else
                $html .= "<li role='presentation' class='dropdown'>";
            $html .= "<a class='dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-expanded='false'>
                                    {$k->name} <span class='caret'></span>
                                </a>";
            $html .= "<ul class='dropdown-menu' role='menu'>";
            $html .= $floor;
            $html .= "</ul>";
            $html .= "</li>";
        } else {
            if ($k->id_building == $building_id)
                $html .= "<li class='active'>";
            else
                $html .= "<li>";
            $html .= "<a href='#' role='button' aria-expanded='false'>
                                    {$k->name}
                                </a>";
            $html .= "</li>";
        }
    }
    echo $html;
    ?>
</ul>
<div class="room-content">
</div><br/><br/>
<?php
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'devices-grid',
	'dataProvider'=>$model,
    'enableSorting'=>'true',
    'emptyText'=>'No Data',
    'enablePagination'=> true,
	//'filter'=>$model,
    'itemsCssClass'=>'table table-striped table-bordered bootstrap-datatable datatable',
    'pagerCssClass'=>'dataTables_paginate paging_bootstrap',
    'pager' => array(
        'class' => 'CLinkPager', 
        'header' => '', 'htmlOptions'=>array('class'=>'pagination'),
        'firstPageLabel'=>'<<',
        'prevPageLabel'=>'<',
        'nextPageLabel'=>'>',
        'lastPageLabel'=>'>>',
    ),
    'summaryText'=> Yii::t('admin/rooms', 'Displaying {start}-{end} of {count} results.'),
	'columns'=>array(
		array(
           'name' => 'device_description',
           'type' => 'raw',
           'value' => function ($data){
               $common_area = ($data->comon_area) ? '<i class="fa fa-dot-circle-o"></i>' : '<i class="fa fa-circle-o"></i>';


               $html = "<span title='".Yii::t('admin/devices','Serial Number')."' data-delay='{ \"hide\": \"3000\"}'  data-html='true' data-content='".$data->serial_number."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$common_area."</span> ".$data->device_description;

               return $html;
           }
        ),
        array(
            'name'=>'id_building', 
            'value'=>'$data->idBuilding->name',
            'filter'=>CHtml::listData(Buildings::model()->findAll(), 'id_building','name')
        ),
        array(
            'name'=>'id_map', 
            'value'=>'$data->idMap->name_map',
        ),
        array(
            'name'=>'id_room',
            'type' => 'raw',
            'value'=> function ($data) {
                
                $criteria=new CDbCriteria;
                $criteria->select = "p.id_patient, CONCAT(p.first_name, ' ', p.last_name) AS patient_name";
                $criteria->alias = 'p';
                $criteria->join = ' INNER JOIN '.Yii::app()->db->tablePrefix.'room_device_patient rdp ON rdp.id_patient = p.id_patient ';
                $criteria->condition = 'rdp.id_device = :id_device';
                $criteria->params = array(':id_device'=>$data->id_device);
                
                $patients = Patients::model()->find($criteria);
                $patientInfo = CHtml::link( $patients['patient_name'], array( 'patients/update/id/'.$patients['id_patient'] ));

                $htmlData = "";
                if (!empty($data->id_room))
                    $htmlData = "<span title='".$data->idRoom->nb_room."' data-delay='{ \"hide\": \"3000\"}'  data-html='true' data-content='".$patientInfo."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$data->idRoom->nb_room."</span>";
                return $htmlData;
            },
        ),

        array(
            'name' =>'ext_number',
            'type' => 'raw',
            'value' => function ($data){
                $extInfo = ExtensionInfo::model()->findByAttributes(array('id_device'=>$data->id_device));
                $html = "";
                if (count($extInfo)) {
                    //$extInfoHtml = Yii::t('admin/devices', 'SIP Server: ').$extInfo->idAsterisk->asterisk_url."<br/>";
                    $extInfoHtml = Yii::t('admin/devices', 'Extension Number: ')."<b>".$extInfo->ext_number."</b><br/>";
                    $extInfoHtml .= Yii::t('admin/devices', 'Extension Password: ')."<b>".$extInfo->password."</b><br/>";
                    $html = "<span title='Extension Info' data-delay='{ \"hide\": \"3000\"}'  data-html='true' data-content='".$extInfoHtml."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$extInfo->ext_number."</span>";
                }
                return $html;
            }
        ),
        /*array(
            'name'=>'device_type', 
            'value'=>function ($data){
                return Yii::app()->params['device_type'][$data->device_type];                   
            },
        ),*/
        array(
            'name'=> 'patient_name',
            'type' => 'raw',
            'value' => function ($data){
                $criteria=new CDbCriteria;
                $criteria->select = "p.id_patient, CONCAT(p.first_name, ' ', p.last_name) AS patient_name";
                $criteria->alias = 'p';
                $criteria->join = ' INNER JOIN '.Yii::app()->db->tablePrefix.'room_device_patient rdp ON rdp.id_patient = p.id_patient ';
                $criteria->condition = 'rdp.id_device = :id_device';
                $criteria->params = array(':id_device'=>$data->id_device);

                $patients = Patients::model()->find($criteria);
                $patientInfo = CHtml::link( $patients['patient_name'], array( 'patients/update/id/'.$patients['id_patient'] ));

                return $patientInfo;
                //$htmlData = "<span title='".$data->idRoom->nb_room."' data-delay='{ \"hide\": \"3000\"}'  data-html='true' data-content='".$patientInfo."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$data->idRoom->nb_room."</span>";
                //return $htmlData;
            }
        ),
        array(
			'class'=>'CButtonColumn',
            'header' => Yii::t('admin/devices', 'Actions'),
            'template'=>'{addPatients}&nbsp;&nbsp;{manageExtension}&nbsp;&nbsp;{updateM}&nbsp;&nbsp;{delete}',
            'htmlOptions'=>array('width'=>'90px', 'style'=>'text-align:center;'),
            'buttons'=> array(
                'updateM' => array(
                    'label' => '<i class="fa fa-pencil"></i>',
                    'url' => 'Yii::app()->createUrl("admin/devices/update", array("id"=>$data->id_device))',
                    'options'=> array('title'=>'Update')
                ),
                'delete' => array(
                    'label' => '<i class="fa fa-trash-o"></i>',
                    'url' => 'Yii::app()->createUrl("admin/devices/delete", array("id"=>$data->id_device))',
                    'options'=> array('title'=>'Delete'),
                    'imageUrl' => false,
                ),
                'addPatients'=> array(
                    'label' => '<i class="fa fa-users"></i>',
                    'url' => 'Yii::app()->createUrl("admin/devices/addPatient", array("id"=>$data->id_device))',
                    'options'=> array('title'=>'Manage Patient'),
                    'click' => $manageDialog
                ),
                'manageExtension' => array(
                    'label' => '<i class="fa fa-phone-square"></i>',
                    'url' => 'Yii::app()->createUrl("admin/devices/manageExtension", array("id"=>$data->id_device))',
                    'options'=> array('title'=>'Manage Extension'),
                    'click' => $manageExtension
                ),
            )
		),
	),
)); ?>

