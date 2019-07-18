<?php
/* @var $this SystemCamerasController */
/* @var $model SystemCameras */

$this->breadcrumbs=array(
	Yii::t('admin/systemcamera', 'System Cameras')=>array('index'),
	Yii::t('admin/systemcamera', 'Manage'),
);
?>

<h1><?php echo Yii::t('admin/systemcamera', 'Manage System Cameras');?></h1>
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
			'data-update-dialog-title' => Yii::t( 'admin/systemcamera','Create System Camera' ),
		));
	?>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'system-email-grid',
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
	'summaryText'=> Yii::t('admin/systemcamera', 'Displaying {start}-{end} of {count} results.'),
	'columns'=>array(
		'description_camera',
		'name_camera',
		array(
			'name' => 'url_camera',
			'type' => 'raw',
			'value' => function($data) {
				$generalInfo = '<img src="'.$data->url_camera.'" border=0 width="250"/>';
				$htmlData = "<span title='".$data->description_camera."' data-delay='{ \"hide\": \"1000\"}'  data-html='true' data-content='".$generalInfo."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$data->url_camera."</span>";
				return $htmlData;
			}
		),
		array(
			'header' => Yii::t('admin/systemcamera', 'Actions'),
			'template'=>'{update}&nbsp;&nbsp;{delete}',
			'class'=>'CButtonColumn',
			'buttons' =>array(
				'update' => array(
					'label' => '<i class="fa fa-pencil"></i>',
					'options'=> array('title'=>Yii::t('admin/systemcamera', 'Update')),
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
