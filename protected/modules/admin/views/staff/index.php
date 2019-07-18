<?php
/* @var $this StaffController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staff',
);

$this->menu=array(
	array('label'=>'Create Staff', 'url'=>array('create')),
	array('label'=>'Manage Staff', 'url'=>array('admin')),
);
$tmp = Yii::app()->request->getParam('building_id');
$tmp2 = Yii::app()->request->getParam('id');
$building_id = (!empty( $tmp )) ? $tmp : -1;
$id_map = (!empty($tmp2 )) ? $tmp2 : 0;


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
/*$manageDialog =<<<'EOT'
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
            $("#needInfo").attr('id_staff',urlAux[urlAux.length -1]);
            $(".popover").css("max-width", "350px");
        });
        $("#ajax_loader").ajaxStop(function(){
            $(this).hide();
         });
        return false;
    }
EOT;
*/
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
	'id'=>'editNotes',
	'options'=>array(
		'title'=> Yii::t( 'admin/staff','Edit Notes'),
		'autoOpen'=>false,
		'modal'=>true,
		'autoResize' => true,
		'width'=>'700',
		'height'=>'auto',
		//'resizable'=>'false',
		'buttons' => array
		(
			Yii::t('admin/staff', 'Save')=>'js:function(){editNotes();}',
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
		'title'=> Yii::t( 'admin/staff','Add Notes'),
		'autoOpen'=>false,
		'modal'=>true,
		'autoResize' => true,
		'width'=>'700',
		'height'=>'auto',
		//'resizable'=>'false',
		'buttons' => array
		(
			Yii::t('admin/staff', 'Save')=>'js:function(){addNoteToDb()}',
			'Close'=>'js:function(){$(this).dialog("close"); $("#ajax_loader").ajaxStop(function(){
                                $(this).hide();
                            });}',
		),
	),
));
$this->endWidget();
?>

<h1>Staff</h1>
<div class="row">
	<?php
	echo CHtml::link( Yii::t( 'admin/staff','Add Staff' ), array( 'create' ),
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
		<a href="<?php echo Yii::app()->createUrl('admin/staff');?>" role="button" aria-expanded="false">
			<?php echo Yii::t('admin/staff', 'All')?>
		</a>
	</li>
	<?php
	$buildings = Buildings::model()->findAll();
	$html = "";
	foreach ($buildings as $k){
		if ($k->id_building == $building_id)
			$html .= "<li class='active'>";
		else
			$html .= "<li>";
		$html .= "<a href='".Yii::app()->createUrl('admin/staff/index/building_id/'.$k->id_building) ."'>
								{$k->name}
							</a>";
		$html .= "</li>";
	}
	echo $html;
	?>
</ul>
<div class="staff-content">
</div>

<script>
	var id_building = <?php echo $building_id;?>;
</script>

<br/><br/>
<table class="hover display" id="resultStaff" data-page-length='25'>
	<thead>
	<tr>
		<th data-sortable="true" style="width: 100px;"><?php echo Yii::t('admin/staff','First Name');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Last Name');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Birth Day');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Position');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Personal ID');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Status');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Actions');?></th>
	</tr>
	</thead>
</table>
