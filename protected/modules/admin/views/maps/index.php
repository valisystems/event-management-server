<?php
/* @var $this MapsController */
/* @var $model Maps */

$this->breadcrumbs=array(
	'Maps'=>array('index'),
	'Manage Maps',
);

?>

<h1>Manage Maps</h1>
<div class="row">
<?php
echo CHtml::link( 'Create', array( 'create' ),
  array(
    //'class' => 'update-dialog-open-link',
    'data-update-dialog-title' => Yii::t( 'admin/maps','Create Map floor' ),
    'class'=>'btn btn-primary'
));
?>
</div>

<div class="row">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'maps-grid',
	'dataProvider'=>$model->search(),
    'enableSorting'=>'true',
    'emptyText'=>'No Data',
    'enablePagination'=> true,
	'filter'=>$model,
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
		'id_map',
		array(
            'name'=>'name_map',
            'header'=>Yii::t('admin/maps', 'Name map'),
            'type'=>'raw',
            'value'=> function($data){
                   $htmlData = ($data->path_to_img != NULL) ? "<span title='".$data->name_map."'  data-html='true' data-content='".CHtml::image(Yii::app()->getRequest()->getHostInfo().$data->path_to_img, $data->name_map, array('width'=>'400px'))."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$data->name_map."</span>": CHtml::encode($data->name_map); 
                   return  $htmlData;
            }
        ),
		'description',
		array(
            'name'=>'id_building', 
            'value'=>'$data->building->name',
            'filter'=>CHtml::listData(Buildings::model()->findAll(), 'id_building','name')
        ),
		/*array(
            'name'=>'path_to_img',
            'header'=>Yii::t('admin/maps', 'Images'),
            'type'=>'image',
            'value'=>'$data->path_to_img'
        ),*/
		array(
			'class'=>'CButtonColumn',
            'header' => Yii::t('admin/maps', 'Actions'),
            'template'=>'{update} {delete}',
            'buttons'=> array(
                'update',
                'delete',
            )
		),
	),
)); ?>
</div>
