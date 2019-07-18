<?php
/* @var $this PendantDevicesController */

$this->breadcrumbs=array(
	'Pendant Devices',
);
?>
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
	?>
</div>
<div class="row">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'calls-type-grid',
		'dataProvider'=>$model->search(),
		//'filter'=>$model,
		'enableSorting'=>'true',
		'emptyText'=>'No Data',
		'enablePagination'=> true,
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
		'summaryText'=> Yii::t('admin/building', 'Displaying {start}-{end} of {count} results.'),
		'columns'=>array(
			'description',
			'serial_number',
			array(
				'name'=>'id_patient',
				'value'=> function($data) {
						if ($data->id_patient > 0) {
							return $data->idPatient->first_name . ' ' . $data->idPatient->last_name;
						} else return "";
					},
			),
			array(
				'name' => 'id_pendant_type',
				'type'=>'raw',
				'value'=> function($data){
					return $data->idPendantType->description;
				}
			),
			array(
				'header' => Yii::t('admin/pendantDevices', 'Actions'),
				'template'=>'{update}&nbsp;&nbsp;{delete}',
				'class'=>'CButtonColumn',
				'buttons' =>array(
					'update' => array(
						'label' => '<i class="fa fa-pencil"></i>',
						'options'=> array('title'=>Yii::t('admin/pendantDevices', 'Update')),
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
</div>