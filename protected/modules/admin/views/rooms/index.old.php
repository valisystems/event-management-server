<?php
/* @var $this RoomsController */
/* @var $model Rooms */

$this->breadcrumbs=array(
	Yii::t('admin/rooms','Rooms')=>array('index'),
	Yii::t('admin/rooms','Manage'),
);
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'roomEvents',
        'options'=>array(
            'title'=>'Manage Events',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'800',
            'height'=>'auto',
            'autoResize' => true,
            //'resizable'=>'false',
            'buttons' => array
            (
                 Yii::t('admin/rooms','Add Events') =>'js:function(){addEvents();}',
                 Yii::t('admin/rooms','Close') =>'js:function(){$(this).dialog("close")}',
            ),
        ),
    ));
$this->endWidget();

$manageDialog =<<<'EOT'
    function() {
         $("#ajax_loader").ajaxStart(function(){
             $(this).show();
         }); 
        var url = $(this).attr('href');
        $.get(url, function(r){
            var stArray = url.split("/");
            var idRoom = stArray[stArray.length-1];
            var divIdRoom = '<div id="need_room" id_room="'+idRoom+'"></div>'
            $("#roomEvents").html(divIdRoom+r).dialog("open");
        });
        $("#ajax_loader").ajaxStop(function(){
            $(this).hide();
         });
        return false;
    }
EOT;

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'addRoomEvents',
        'options'=>array(
            'title'=>'Add Event',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'700',
            'height'=>'auto',
            'beforeClose' => 'js:function( ) {
                    generateOneTimeUpdate = 0;
                    $("#addRoomEvents").html("");
                    }',
            'autoResize' => true,
            //'resizable'=>'false',
            'buttons' => array
            (
                 Yii::t('admin/rooms','Save') =>'js:function(){saveEvents();}',
                 Yii::t('admin/rooms','Close') =>'js:function(){$(this).dialog("close")}',
            ),
        ),
    ));
$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'editRoomEvents',
        'options'=>array(
            'title'=>'Edit Event',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'700',
            'height'=>'auto',
            'autoResize' => true,
            'beforeClose' => 'js:function( ) {
                    generateOneTimeUpdate = 0;
                    $("#editRoomEvents").html("");
            }',
            //'resizable'=>'false',
            'buttons' => array
            (
                 Yii::t('admin/rooms','Save') =>'js:function(){updateEvents();}',
                 Yii::t('admin/rooms','Close') =>'js:function(){$(this).dialog("close")}',
            ),
        ),
    ));
$this->endWidget();
?>
<div id='ajax_loader' style="display: none;" class="ui-widget-overlay">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; z-index:3000000"/>
</div>
<h1><?php echo Yii::t('admin/rooms', 'Manage Rooms');?></h1>
<div class="row">
<?php
echo CHtml::link( Yii::t( 'admin/rooms','Add Room' ), array( 'create' ),
  array(
    //'class' => 'update-dialog-open-link',
    'data-update-dialog-title' => Yii::t( 'admin/rooms','Add Room' ),
    'class'=>'btn btn-primary'
));

?>
</div><br/>
<?php if(Yii::app()->user->hasFlash('success')):
    ?>
    <div class="row">
        <div class="alert alert-success">
            <?php
            echo Yii::app()->user->getFlash('success');
            ?>
        </div>
    </div>
<?php
endif; ?>
<?php if(Yii::app()->user->hasFlash('error')):
    ?>
    <div class="row">
        <div class="alert alert-danger">
            <?php
            echo Yii::app()->user->getFlash('error');
            ?>
        </div>
    </div>
<?php
endif; ?>
<ul class="nav nav-tabs" id="roomsTab">
    <li role="presentation" class="active">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
            <?php echo Yii::t('admin/rooms', 'All')?>
        </a>
    </li>
    <?php
        $buildings = Buildings::model()->findAll();
        $html = "";
        foreach ($buildings as $k){
            $floor = "";
            foreach($k->floor as $fl){
                $floor .= "<li><a href='".Yii::app()->createUrl('admin/rooms/floor/id/'.$fl->id_map.'/building_id/'.$fl->id_building) ."'>{$fl->name_map}</a></li>";
            }
            if ($floor != "") {
                $html .= "<li role='presentation' class='dropdown'>";
                    $html .= "<a class='dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-expanded='false'>
                                    {$k->name} <span class='caret'></span>
                                </a>";
                    $html .= "<ul class='dropdown-menu' role='menu'>";
                    $html .= $floor;
                    $html .= "</ul>";
                $html .= "</li>";
            } else {
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
</div>


<br/><br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'rooms-grid',
	'dataProvider'=>$model->search(),
    'enableSorting'=>false,
    'emptyText'=>'No Data',
    'enablePagination'=> true,
	//'filter'=>$model,
    'ajaxUpdate'=>0,
    //'afterAjaxUpdate' => 'reinstallJsFilters',
    'itemsCssClass'=>'table table-striped table-bordered bootstrap-datatable datatable',
    'pagerCssClass'=>'dataTables_paginate paging_bootstrap',
    'pager' => array(
        'class' => 'CLinkPager', 
        'header' => '', 
        'htmlOptions'=>array('class'=>'pagination'),
        'firstPageLabel'=>'<<',
        'prevPageLabel'=>'<',
        'nextPageLabel'=>'>',
        'lastPageLabel'=>'>>',
    ),
    'summaryText'=> Yii::t('admin/rooms', 'Displaying {start}-{end} of {count} results.'),
	'columns'=>array(
		array(
            'name' => 'nb_room',
            'type' => 'raw',
            'value' => function($data) {
                $generalInfo = $patientsHtml = $nbOfSeats = $devicesHtml = '';
                $nbOfSeats = '<fieldset>';
                $nbOfSeats .= '<label>'.Yii::t('admin/rooms', 'Number of seats').'</label>';
                $nbOfSeats .= '<div class="row"><div class="col-lg-11">'.$data->nb_of_seats.'</div></div>';
                $nbOfSeats .= "</fieldset>";
                
                $criteria=new CDbCriteria;
                $criteria->select = "p.id_patient, CONCAT(p.first_name, ' ', p.last_name) AS patient_name, pc.url_camera";
                $criteria->alias = 'p';
                $criteria->join = ' INNER JOIN '.Yii::app()->db->tablePrefix.'room_device_patient rdp ON rdp.id_patient = p.id_patient ';
                $criteria->join .= ' INNER JOIN '.Yii::app()->db->tablePrefix.'patient_cameras pc ON p.id_patient = pc.id_patient ';
                $criteria->condition = 'rdp.id_room = :id_room';
                $criteria->params = array(':id_room'=>$data->id_room);
                
                $patients = Patients::model()->findAll($criteria);
                
                $crDevice=new CDbCriteria;
                $crDevice->condition = 'id_room = :id_room';
                $crDevice->params = array(':id_room'=>$data->id_room);
                
                $devices = Devices::model()->findAll($crDevice);
                if (count($devices)){
                    $devicesHtml = '<fieldset>';
                    $devicesHtml .= '<label>'.Yii::t('admin/rooms', 'List of Devices').'</label>';
                    foreach ($devices as $v) {
                        $devicesHtml .= '<div class="row"><div class="col-lg-11">'.CHtml::link( $v['device_description'].' - '. $v['serial_number'], array( 'devices/update/id/'.$v['id_device']))."</div></div>";
                    }
                    $devicesHtml .= "</fieldset>";
                }
                
                if (count($patients)) {
                    $patientsHtml = '<fieldset>';
                    $patientsHtml .= '<label>'.Yii::t('admin/rooms', 'List of Patients').'</label>';
                    foreach ($patients as $k) {
                        $cameraURL = ($k['url_camera'] != "") ? ' -  <a href="'.$k['url_camera'].'" target="_blank"><i class="fa fa-eye"></i></a>' : '';
                        $patientsHtml .= '<div class="row"><div class="col-lg-11">'.CHtml::link( $k['patient_name'], array( 'patients/update/id/'.$k['id_patient'])).$cameraURL."</div></div>";
                    }
                    $patientsHtml .= "</fieldset>";
                }
                $generalInfo = $nbOfSeats.$patientsHtml.$devicesHtml;
                $htmlData = "<span title='".$data->nb_room."' data-delay='{ \"hide\": \"3000\"}'  data-html='true' data-content='".$generalInfo."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$data->nb_room."</span>";
                return $htmlData;
            },
            'filter' => $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model'=>$model, 
                'attribute'=>'nb_room', 
                'source' =>Yii::app()->createUrl('admin/rooms/autocomplete'),
                'options'=>array(
                    'minLength'=>'2',
                    'showAnim'=>'fold',
                    'select' =>'js: function(event, ui) {
                        this.value = ui.item.label;
                        //$("#Rooms_nb_room").val(ui.item.label);
                        //return false;
                    }',
                ),
                'htmlOptions' => array(
                    //'maxlength'=>50,
                    'autocomplete'=>'off'
                ),
            ), true)
        ),
		array(
            'header'=>Yii::t('admin/rooms', 'Building'),
            'name'=>'id_building',
            'type'=>'raw',
            'filter' => false,
            'value'=> function($data){
                $build = Buildings::model()->findByPk($data->id_building);
                return $build->name;
            }
        ),
        array(
            'header'=>Yii::t('admin/rooms', 'Floor'),
            'name'=>'id_map',
            'type'=>'raw',
            'filter' => false,
            'value'=> function($data){
                $floor = Maps::model()->findByPk($data->id_map);
                return CHtml::link( '<i class="fa fa-eye"></i>', array( 'rooms/viewonmap/id/'.$data->id_room ),
                    array(
                        'class'=>'btn btn-xs btn-success'
                    )).'&nbsp;'.$floor->name_map;
            }
        ),
		array(
			'class'=>'CButtonColumn',
            'header' => Yii::t('admin/rooms', 'Actions'),
            'template'=>'{roomEvents}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
            'buttons'=> array(
                'roomEvents' => array(
                    'label' => '<i class="fa fa-tasks"></i>',
                    'url' => 'Yii::app()->createUrl("admin/rooms/roomEvent", array("id"=>$data->id_room))',
                    'options'=> array('title'=>Yii::t('admin/rooms', 'Manage Events')),
                    'click' => $manageDialog,
                ),
                'update' => array(
                    'label' => '<i class="fa fa-pencil"></i>',
                    'options'=> array('title'=>Yii::t('admin/rooms', 'Update')),
                    //'url' => 'Yii::app()->createUrl("admin/buildings/update", array("id"=>$data->id_building))',
                    'imageUrl' => false,
                ),
                'delete' => array(
                    'label' => '<i class="fa fa-trash-o"></i>',
                    'imageUrl' => false,
                ),
            )
		),
	),
)); ?>


