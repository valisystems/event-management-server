<?php
/* @var $this AsteriskController */
/* @var $model Asterisk */

$this->breadcrumbs=array(
	'Node'=>array('index'),
	'Manage',
);

?>

<h1><?php Yii::t('admin/asterisk','Manage Node');?></h1>
<div class="row">
<?php
echo CHtml::link( 'Create', array( 'create' ),
  array(
    //'class' => 'update-dialog-open-link',
        'data-update-dialog-title' => Yii::t( 'admin/asterisk','Create Node Connection' ),
        'class'=>'btn btn-primary',
        'id'=>'createNodes'

));

?>
</div>
<div id='ajax_loader' style="display: none;" class="ui-widget-overlay">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; z-index:3000000"/>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'asterisk-grid',
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
    'summaryText'=> Yii::t('admin/asterisk', 'Displaying {start}-{end} of {count} results.'),    

	'columns'=>array(
		'asterisk_name',
		'asterisk_url',
		'voip_url',
		array(
            'name'=>'id_building', 
            'value'=>'$data->building->name',
            'filter'=>CHtml::listData(Buildings::model()->findAll(), 'id_building','name')
        ),
		array(
            'header' => Yii::t('admin/asterisk', 'Actions'),
            'template'=>'{update}&nbsp;&nbsp;{delete}',
			'class'=>'CButtonColumn',
            'buttons' =>array(
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
            )
		),
	),
)); ?>
