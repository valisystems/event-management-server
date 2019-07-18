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
$tmp2 = Yii::app()->request->getParam('id');
$building_id = (!empty( $tmp )) ? $tmp : -1;
$id_map = (!empty($tmp2 )) ? $tmp2 : 0;

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
<script>
    var id_building = <?php echo $building_id;?>;
    var id_map = <?php echo $id_map;?>;
</script>
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
