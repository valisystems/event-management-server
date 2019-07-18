<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    
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
        array('name'=>'name_map', 'header'=> 'Floor'),
        array('name'=>'description', 'header'=>'Floor Description'),
        array('name'=>'id_building', 'header'=>'Building', 'value'=>'$data->building->name'),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template'=>'{update} {delete}',
            'buttons'=>array(
                'delete' => array(
                    'label'=>Yii::t('admin/map','Delete'),
                ),
                'update' => array(
                    'label'=>Yii::t('admin/map','Edit'),
                ),
            ),
        ),
    ),
));
?>