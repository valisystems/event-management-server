<?php
/* @var $this RoomsController */
/* @var $model Rooms */

$this->breadcrumbs=array(
	Yii::t('admin/rooms','Rooms')=>array('index'),
	Yii::t('admin/rooms','Manage'),
);

$tmp = Yii::app()->request->getParam('building_id');
$tmp2 = Yii::app()->request->getParam('id');
$building_id = (!empty( $tmp )) ? $tmp : -1;
$id_map = (!empty($tmp2 )) ? $tmp2 : 0;
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
    <?php
    if ($building_id == -1) {
    ?>
<li role="presentation" class="active">
<?php } else {?>
    <li role="presentation">

        <?php }?>
        <a href="<?php echo Yii::app()->createUrl('admin/rooms');?>" role="button" aria-expanded="false">
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
</div>

<script>
    var id_building = <?php echo $building_id;?>;
    var id_map = <?php echo $id_map;?>;
</script>

<br/><br/>
<table class="hover display" id="resultRooms" data-page-length='25'>
    <thead>
    <tr>
        <th data-sortable="true" style="width: 100px;"><?php echo Yii::t('admin/rooms','Room Number');?></th>
        <th data-sortable="true"><?php echo Yii::t('admin/rooms','Building');?></th>
        <th data-sortable="true"><?php echo Yii::t('admin/rooms','Floor');?></th>
        <th data-sortable="true"><?php echo Yii::t('admin/rooms','Actions');?></th>
    </tr>
    </thead>
</table>


