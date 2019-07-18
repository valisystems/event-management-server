<?php
/* @var $this MaxivoxDeviceController */

$this->breadcrumbs=array(
	Yii::t('admin/maxivox','Maxivox Device'),
);
?>
<div id='ajax_loader' style="display: none;" class="ui-widget-overlay">
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; z-index:3000000"/>
</div>
<h1><?php Yii::t('admin/maxivox','Manage Maxivox Devices ');?></h1>
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
?>
<div class="row">

	<?php
	echo CHtml::link( 'Create', array( 'create' ),
		array(
			//'class' => 'update-dialog-open-link',
			'data-update-dialog-title' => Yii::t( 'admin/maxivox','Add Maxivox Device' ),
			'class'=>'btn btn-primary'
		));
	echo "<br/>";
	?>

</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'maxivox-grid',
	'dataProvider'=>$model->search(),
	'enableSorting'=>true,
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
	'summaryText'=> Yii::t('admin/maxivox', 'Displaying {start}-{end} of {count} results.'),
	'columns'=>array(
		array(
			'header'=>Yii::t('admin/maxivox', 'Device Description'),
			'name'=>'dev_desc',
			'type'=>'raw',
			'value' => function ($data){
				$common_area = ($data->comon_area) ? '<i class="fa fa-dot-circle-o"></i>' : '<i class="fa fa-circle-o"></i>';


				$html = "<span title='".Yii::t('admin/maxivox', 'Device Address')."' data-delay='{ \"hide\": \"3000\"}'  data-html='true' data-content='".$data->dev_address."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$common_area."</span> ".$data->dev_desc;

				return $html;
			},
			'filter' => false,
		),
		array(
			'header'=>Yii::t('admin/maxivox', 'Device Address'),
			'name'=>'dev_address',
			'type'=>'raw',
			'filter' => false,
		),
		array(
			'name'=>'id_building',
			'header'=> Yii::t('admin/maxivox', 'Location'),
			'type' => 'raw',
			'value'=> function ($data) {

				$patientInfo = "";//CHtml::link( $patients['patient_name'], array( 'patients/update/id/'.$patients['id_patient'] ));
				$location = $data->idBuilding->name.' ('.$data->idMap->name_map.")";
				$htmlData = $location;
				return $htmlData;
			},
		),
		array(
			'name'=>'id_room',
			'type' => 'raw',
			'value'=> function ($data) {

				/*$criteria=new CDbCriteria;
				$criteria->select = "p.id_patient, CONCAT(p.first_name, ' ', p.last_name) AS patient_name";
				$criteria->alias = 'p';
				$criteria->join = ' INNER JOIN '.Yii::app()->db->tablePrefix.'room_device_patient rdp ON rdp.id_patient = p.id_patient ';
				$criteria->condition = 'rdp.id_device = :id_device';
				$criteria->params = array(':id_device'=>$data->id_device);

				$patients = Patients::model()->find($criteria);*/
				$patientInfo = "";//CHtml::link( $patients['patient_name'], array( 'patients/update/id/'.$patients['id_patient'] ));
				$htmlData = "";
				if (!empty($data->id_room))
					$htmlData = "<span title='".$data->idRoom->nb_room."' data-delay='{ \"hide\": \"3000\"}'  data-html='true' data-content='".$patientInfo."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$data->idRoom->nb_room."</span>";
				return $htmlData;
			},
		),
		array(
			'class'=>'CButtonColumn',
			'header' => Yii::t('admin/maxivox', 'Actions'),
			'template'=>'{addPatients}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
			'buttons'=> array(
				'addPatients'=> array(
					'label' => '<i class="fa fa-users"></i>',
					'url' => 'Yii::app()->createUrl("admin/maxivoxDevice/addPatient", array("id"=>$data->id_maxivox_device))',
					'options'=> array('title'=>'Manage Patient'),
					'click' => $manageDialog,
					'visible' => '$data->comon_area == 0'
				),
				'update' => array(
					'label' => '<i class="fa fa-pencil"></i>',
					'options'=> array('title'=>Yii::t('admin/maxivox', 'Update')),
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
));