<?php
/* @var $this PatientsController */
/* @var $model Patients */

$this->breadcrumbs=array(
	Yii::t('admin/patients', 'Patients')=>array('index'),
	Yii::t('admin/patients', 'Manage'),
);
?>
<div id='ajax_loader' style="display: none;" class="ui-widget-overlay">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; z-index:3000000"/>
</div>
<h1><?php echo Yii::t('admin/patients', 'Manage Patients')?></h1>
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

<div class="row">
<?php
echo CHtml::link( 'Create', array( 'create' ),
  array(
    'class' => 'btn btn-primary',
));
echo "&nbsp;&nbsp;&nbsp;";
echo CHtml::button(Yii::t('admin/patients', 'Import'), array('onClick' => 'js:openImportDiag()', 'class' => 'btn btn-primary',) );
?>
</div>


<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'manageNotes',
        'options'=>array(
            'title'=>'Manage Notes',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'700',
            'height'=>'auto',
            'autoResize' => true,
            //'resizable'=>'false',
            'buttons' => array
            (
                 'Add Notes'=>'js:function(){addNotes();}',
                'Close'=>'js:function(){$(this).dialog("close"); $("#ajax_loader").ajaxStop(function(){
                                $(this).hide();
                            });}',
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
            $("#manageNotes").html(r).dialog("open");
            $("[data-toggle='popover']").popover(
                {
                    html:true, 
                    trigger:"hover",
                }
            );
            var urlAux = url.split('/');
            $("#needInfo").attr('id_patient',urlAux[urlAux.length -1]);
            $(".popover").css("max-width", "350px");
        });
        $("#ajax_loader").ajaxStop(function(){
            $(this).hide();
         });
        return false;
    }
EOT;

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'editNotes',
        'options'=>array(
            'title'=> Yii::t( 'admin/patients','Edit Notes'),
            'autoOpen'=>false,
            'modal'=>true,
            'autoResize' => true,
            'width'=>'700',
            'height'=>'auto',
            //'resizable'=>'false',
            'buttons' => array
            (
                 Yii::t('admin/patients', 'Save')=>'js:function(){editNotes();}',
                 'Close'=>'js:function(){$(this).dialog("close"); $("#ajax_loader").ajaxStop(function(){
                                $(this).hide();
                            });}',
            ),
        ),
    ));
$this->endWidget();
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'addNotes',
        'options'=>array(
            'title'=> Yii::t( 'admin/patients','Edit Notes'),
            'autoOpen'=>false,
            'modal'=>true,
            'autoResize' => true,
            'width'=>'700',
            'height'=>'auto',
            //'resizable'=>'false',
            'buttons' => array
            (
                 Yii::t('admin/patients', 'Save')=>'js:function(){addNoteToDb()}',
                'Close'=>'js:function(){$(this).dialog("close"); $("#ajax_loader").ajaxStop(function(){
                                $(this).hide();
                            });}',
            ),
        ),
    ));
$this->endWidget();
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'viewCamera',
        'options'=>array(
            'title'=> Yii::t( 'admin/patients','View Camera'),
            'autoOpen'=>false,
            'modal'=>true,
            'autoResize' => false,
            'width'=>'700',
            'height'=>'480',
            'beforeClose'=>"js:function(){stoper();}",
            'resizable'=>'false',
            'buttons' => array
            (
                 'Close'=>'js:function(){$(this).dialog("close");}',
            ),
        ),
    ));
$this->endWidget();
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'importCSV',
        'options'=>array(
            'title'=> Yii::t( 'admin/patients','Import CSV'),
            'autoOpen'=>false,
            'modal'=>true,
            'autoResize' => true,
            'width'=>'400',
            'height'=>'auto',
            //'resizable'=>'false',
            'beforeClose'=>"js:function (){
                //alert($('#nameFile').val())
            }",
            'buttons' => array
            (
                Yii::t('admin/patients', 'Import')=>'js:function(){importCSV()}',
                'Close'=>'js:function(){$(this).dialog("close")}',
            ),
        ),
    ));
$this->endWidget();

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
        <a href="<?php echo Yii::app()->createUrl('admin/patients');?>" role="button" aria-expanded="false">
            <?php echo Yii::t('admin/patients', 'All')?>
        </a>
    </li>
    <?php
    $buildings = Buildings::model()->findAll();
    $html = "";
    foreach ($buildings as $k){
        $floor = "";
        foreach($k->floor as $fl){
            $floor .= "<li><a href='".Yii::app()->createUrl('admin/patients/floor/id/'.$fl->id_map.'/building_id/'.$fl->id_building) ."'>{$fl->name_map}</a></li>";
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
<!--
<?php

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'patients-grid',
	'dataProvider'=>$model,
	//'dataProvider'=>$model->search(),
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
    'summaryText'=> Yii::t('admin/maps', 'Displaying {start}-{end} of {count} results.'),

	'columns'=>array(
        array(
            'name'=>'first_name',
            'header'=>Yii::t('admin/patients', 'First Name'),
            'type'=>'raw',
            'value'=> function($data){
                //$htmlData = "<a data-toggle='popover' class='patInfo' data-content='javascript:getPatientInfo();' url_info='".Yii::app()->createUrl('admin/patients/patientInfo/id/'.$data->id_patient)."' style='cursor:pointer'>".$data->first_name."</a>"; 
                $content = "<div><div>";
                $content .= $data->first_name.' '.$data->last_name."<br/>";
                if (!empty($data->text_desc))
                    $content .= $data->text_desc."<br/>";
                $content .= $data->nb_room."<br/>";
                $content .= "</div>";
                if (!empty($data->avatar_path))
                    $content .= "<div class=\"thumbnail\">".CHtml::image(Yii::app()->getRequest()->getHostInfo().$data->avatar_path, $data->first_name.' '.$data->last_name, array('width'=>'150px'))."</div>";
                $content .= "</div>";
                $htmlData = "<span title='".$data->first_name.' '.$data->last_name."'  data-html='true' data-content='".$content."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$data->first_name."</span>";
                return  $htmlData;
            }
        ),
		'last_name',
		'afliction',
        array(
            'header'=>Yii::t('admin/rooms', 'Building'),
            'name'=>'id_building',
            'type'=>'raw',
            'filter' => false,
            'value'=> function($data){
                $room = Rooms::model()->findByPk($data->residentsOfRooms[0]['id_room']);
                $build = Buildings::model()->findByPk($room['id_building']);
                return $build['name'];
            }
        ),
        array(
            'header'=>Yii::t('admin/rooms', 'Floor'),
            'name'=>'id_map',
            'type'=>'raw',
            'filter' => false,
            'value'=> function($data){
                $room = Rooms::model()->findByPk($data->residentsOfRooms[0]['id_room']);
                $floor = Maps::model()->findByPk($room['id_map']);
                return CHtml::link( '<i class="fa fa-eye"></i>', array( 'rooms/viewonmap/id/'.$data->residentsOfRooms[0]['id_room'] ),
                    array(
                        'class'=>'btn btn-xs btn-success',
                    )).'&nbsp;'.$floor->name_map;
            }
        ),
        array(
            'name' => 'nb_room',
            'header'=>Yii::t('admin/patients', 'Room number'),
            'type'=>'raw',
            'value'=> function($data){
                //print_r($data);
                $content = $htmlData ='';
                $crCamera = new CDbCriteria;
                $crCamera->condition = 'id_patient = :id_patient';
                $crCamera->params = array(':id_patient'=>$data->id_patient);
                
                $mdCamera = PatientCameras::model()->findAll($crCamera);
                if (count($mdCamera)) {
                    foreach ($mdCamera as $k) {
                        $content .= "<div class=\"thumbnail\">".CHtml::image($k['url_camera'], $data->first_name.' '.$data->last_name, array('width'=>'128px'))."</div>";
                    }
                    $htmlData = "<span title='".$data->nb_room."'  data-html='true' data-content='".$content."' data-toggle='popover' data-trigger='hover' data-placement='right' onClick=\"javascript:openCameraView('".$k['url_camera']."')\" style='cursor:pointer'>".$data->nb_room."</span>";
                } else {
                    $htmlData = $data->nb_room;
                }
                return $htmlData;
            }
        ),
		/*array(
            'name'=>'language',
            'value'=>function($data){
                return Yii::app()->params['languages'][$data->language];
            }
        ),*/
		/*
		'voice_message',
		*/
		array(
			'class'=>'CButtonColumn',
            'header' => Yii::t('admin/maps', 'Actions'),
            'template'=>'{patientNotes}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
            'htmlOptions' =>array('style','width:50px;'),
            'buttons'=> array(
                'update' => array(
                    'label' => '<i class="fa fa-pencil"></i>',
                    'options'=> array('title'=>Yii::t('admin/building', 'Update')),
                    //'url' => 'Yii::app()->createUrl("admin/buildings/update", array("id"=>$data->id_building))',
                    'imageUrl' => false,
                ),
                'delete' => array(
                    'label' => '<i class="fa fa-trash-o"></i>',
                    'imageUrl' => false,
                ),
                'patientNotes' => array(
                    'label' => '<i class="fa fa-book"></i>',
                    'url' => 'Yii::app()->createUrl("admin/patients/manageNotes", array("id"=>$data->id_patient))',
                    'options'=> array('title'=>Yii::t('admin/patients', 'Manage Notes')),
                    'click' => $manageDialog
                )
            )
		),
	),
));
//unlink('./upload/notes/CodeBar128_7001_8000.pdf')
?>
-->
<table class="hover display" id="resultPatient" data-page-length='25'>
    <thead>
    <tr>
        <th data-sortable="true" style="width: 100px;"><?php echo Yii::t('admin/patient','First Name');?></th>
        <th data-sortable="true"><?php echo Yii::t('admin/patient','Last Name');?></th>
        <th data-sortable="true"><?php echo Yii::t('admin/patient','Afliction');?></th>
        <th data-sortable="true"><?php echo Yii::t('admin/patient','Building');?></th>
        <th data-sortable="true"><?php echo Yii::t('admin/patient','Floor');?></th>
        <th data-sortable="true"><?php echo Yii::t('admin/patient','Room number');?></th>
        <th data-sortable="true"><?php echo Yii::t('admin/patient','Actions');?></th>
    </tr>
    </thead>
</table>
