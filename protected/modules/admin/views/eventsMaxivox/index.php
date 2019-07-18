<?php
/* @var $this EventsPendantController */


$this->breadcrumbs=array(
	'Events Maxivox',
);
$tmp = Yii::app()->request->getParam('building_id');
$building_id = (!empty( $tmp )) ? $tmp : -1;
?>
<div id='ajax_loader' style="display: none;" class="ui-widget-overlay">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; z-index:3000000"/>
</div>
<div class="row">
	<?php
	echo CHtml::link( Yii::t( 'admin/eventsmaxivox','Add MaxiVox Events' ), array( 'create' ),
			array(
				//'class' => 'update-dialog-open-link',
				'class'=>'btn btn-primary'
			));

	?>
</div><br/>
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
<ul class="nav nav-tabs" id="roomsTab">
	<?php
	if ($building_id == -1) {
		?>
		<li role="presentation" class="active">
	<?php } else {?>
		<li role="presentation">

	<?php }?>
		<a href="<?php echo Yii::app()->createUrl('admin/eventsMaxivox');?>" role="button" aria-expanded="false">
			<?php echo Yii::t('admin/eventsmaxivox', 'All')?>
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
		$html .= "<a href='" . Yii::app()->createUrl('admin/eventsMaxivox/index/building_id/' . $k->id_building) . "' role='button' aria-expanded='false'>
								{$k->name}
							</a>";
		$html .= "</li>";
	}
	echo $html;
	?>
</ul>
<div class="room-content">
</div>
</br>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'rooms-grid',
	'dataProvider'=>$model,
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
	'summaryText'=> Yii::t('admin/eventsmaxivox', 'Displaying {start}-{end} of {count} results.'),
	'columns'=>array(
		array(
			'header'=>Yii::t('admin/eventsmaxivox', 'Device Description'),
			'name'=>'dev_desc',
			'type'=>'raw',
			'filter' => false,
		),
		array(
			'header'=>Yii::t('admin/eventsmaxivox', 'MaxiVox Type'),
			'name'=>'maxivox_type_desc',
			'type'=>'raw',
			'filter' => false,
		),
		array(
			'header'=>Yii::t('admin/eventsmaxivox', 'Event Message'),
			'name'=>'eventMessages',
			'type'=>'raw',
		),
		array(
			'class'=>'CButtonColumn',
			'header' => Yii::t('admin/eventsmaxivox', 'Actions'),
			'template'=>'{update}&nbsp;&nbsp;{delete}',
			'buttons'=> array(
				'update' => array(
					'label' => '<i class="fa fa-pencil"></i>',
					'options'=> array('title'=>Yii::t('admin/eventsmaxivox', 'Update')),
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