<?php
/* @var $this MapFloorController */
/* @var $model MapFloor */
/* @var $form CActiveForm  */
$this->pageTitle=Yii::app()->name .' - '.Yii::t('admin/mapfloor','title_map_floor');
$this->breadcrumbs=array(
	'Map Floor miALERT',
);

?>
<?php
$this->widget('ext.EUpdateDialog.EUpdateDialog', array(
    'options'=>array(
    'height' => 200,
    'resizable' => true,
    'width' => 300,)
));
?>
<div class="row">
<?php
echo CHtml::link( 'Create', array( 'create' ),
  array(
    'class' => 'update-dialog-open-link',
    'data-update-dialog-title' => Yii::t( 'admin/mapfloor','Create Map floor' ),
));
?>
<div id="showMapNewDialog"></div>
<div class="row">
<?php
//$dataProvider = $modelMapFloor->search();
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$modelMapFloor->search(),
    'enableSorting'=>'true',
    'filter'=>$modelMapFloor,
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
    'summaryText'=> Yii::t('admin/floor', 'Displaying {start}-{end} of {count} results.'),
    
    'columns' => array(
        array('name'=>'name_map', 'header'=> 'Floor', /*'tooltip'=>'Test'*/),
        array('name'=>'description', 'header'=>'Floor Description'),
        array('name'=>'building', 'header'=>'Building', 'value'=>'$data->building->name'),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template'=>'{update} {delete}',
            'buttons'=>array(
                'delete' => array(
                    'label' =>  Yii::t('admin/map','Delete'),
                    'url'   =>  '$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey, "asDialog"=>1, "gridId"=>$this->grid->id))',
                    //'click' =>  'function(){$("#cru-frame").attr("src", $(this).attr("href"));$("#cru-dialog").dialog("open"); return false;}'
                    
                    
                ),
                'update' => array(
                    'label'=>Yii::t('admin/map','Edit'),
                    'click'=>'updateDialogUpdate'
                ),
            ),
        ),
    ),
));
?>
</div>