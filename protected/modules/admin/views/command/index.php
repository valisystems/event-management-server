<?php
/* @var $this CommandController */

$this->breadcrumbs=array(
	Yii::t('admin/command','Command'),
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
<br/>
<h1><?php
	echo Yii::t('admin/command', 'Manage Command');
	?></h1>
<div class="row">
	<?php
	echo CHtml::link( 'Create', array( 'create' ),
		array(
			//'class' => 'update-dialog-open-link',
			'data-update-dialog-title' => Yii::t( 'admin/maps','Create Command' ),
			'class'=>'btn btn-primary'
		));
	?>
</div>
<div class="row">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'command-grid',
		'dataProvider'=>$model->search(),
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
				'name'=>'com_name',
				'header'=>Yii::t('admin/maps', 'Command Name'),
				'type'=>'raw',
				'value'=> function($data){
					$htmlData = "<a href='#' class='command_edit' data-type='text' data-name='com_name' data-pk='".$data->id_command."' data-url='/admin/command/changeCommand' data-title='Command Name'>".$data->com_name."</a>";
					return  $htmlData;
				}
			),
			array(
				'name'=>'command',
				'type'=>'raw',
				'value'=>function($data){
						//$data->command
					$htmlData = "<a href='#' class='command_edit' data-type='text' data-name='command' data-pk='".$data->id_command."' data-url='/admin/command/changeCommand' data-title='Command'>".$data->command."</a>";
					return  $htmlData;
				}
			),
			array(
				'class'=>'CButtonColumn',
				'header' => Yii::t('admin/maps', 'Actions'),
				'template'=>'{delete}',
				'buttons'=> array(
					'update',
					'delete' => array(
						'label' => '<i class="fa fa-trash-o"></i>',
						'imageUrl' => false,
					),
				)
			),
		),
	)); ?>
</div>
