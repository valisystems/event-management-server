<?php 


/*$updateEmapDialog =<<<'EOT'
    function() {
        var url = $(this).attr('href');
        $.get(url, function(r){
            $("#updateEmap").html(r).dialog("open");
        });
        return false;
    }
EOT;*/

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'maps-grid',
	'dataProvider'=>$model,
    //'enableSorting'=>'false',
    'emptyText'=>'No Data',
    'enablePagination'=> false,
	//'filter'=>$model,
    'itemsCssClass'=>'table table-striped table-bordered bootstrap-datatable',
    'pagerCssClass'=>'dataTables_paginate paging_bootstrap',
    //'htmlOptions' => array('style' => "width:90% !important"),
    'pager' => array(
        'class' => 'CLinkPager', 
        'header' => '', 'htmlOptions'=>array('class'=>'pagination'),
        'firstPageLabel'=>'<<',
        'prevPageLabel'=>'<',
        'nextPageLabel'=>'>',
        'lastPageLabel'=>'>>',
    ),
    'summaryText'=> Yii::t('admin/buildings', 'Displaying {start}-{end} of {count} results.'),
	'columns'=>array(
		array(
            'name'=>'name_map',
            'header'=>Yii::t('admin/buildings', 'Floors'),
            'type'=>'raw',
            'value'=> function($data){
                   $htmlData = ($data->path_to_img != NULL) ? "<span title='".$data->name_map."'  data-html='true' data-content='".CHtml::image(Yii::app()->getRequest()->getHostInfo().$data->path_to_img, $data->name_map, array('width'=>'400px'))."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$data->name_map."</span>": CHtml::encode($data->name_map); 
                   return  $htmlData;
            }
        ),
		'description',
        array(
            'header' => Yii::t('admin/buildings', 'Actions'),
            'htmlOptions' => array('style'=>'width:10%'),
            'type' => 'raw',
            'value' => function($data){
                $html = "<a href='javascript:void(0);' onClick='javascript:updateFloorDialog(".$data->id_map.");'><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;";
                $html.= "<a href='javascript:void(0);' onClick='javascript:deleteFloor(".$data->id_map.", ".$data->id_building.",\"".Yii::t('admin/buildings', 'Are you sure you want to delete this item?')."\");'><i class='fa fa-trash-o'></i></a>";
                return $html;
            }
        ),
	),
)); ?>