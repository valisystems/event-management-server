<div id_patient='' id="needInfo"></div> 
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'maps-grid',
	'dataProvider'=>$model,
    'enableSorting'=>'0',
    'emptyText'=>'No Data',
    'enablePagination'=> false,
	//'filter'=>$model,
    'itemsCssClass'=>'table table-striped table-bordered bootstrap-datatable',
    'pagerCssClass'=>'dataTables_paginate paging_bootstrap',
    //'htmlOptions' => array('style' => "width:90% !important"),
    'pager' => array(
        'class' => 'CLinkPager', 
        'header' => '', 
        'htmlOptions'=>array('class'=>'pagination'),
        'firstPageLabel'=>'<<',
        'prevPageLabel'=>'<',
        'nextPageLabel'=>'>',
        'lastPageLabel'=>'>>',
    ),
    'summaryText'=> Yii::t('admin/staff', 'Displaying {start}-{end} of {count} results.'),
	'columns'=>array(
		array(
           'name' => 'notes',
           'type' => 'raw',
           'value' => function($data){
                $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
                   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
                   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
                   '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
                );
                $text = preg_replace($search, '', $data->notes);
                $html = (strlen($text) > 25) ? "<span title='".substr($text, 0, 25)."&hellip;' data-html='true' data-content='".$data->notes."' data-toggle='popover' data-trigger='hover' data-placement='right'>".substr($text, 0, 25)."&hellip;</span>" : $data->notes;
                return $html;
           }
        ),
		array(
            'name'=>'file_url',
            'type' => 'raw',
            'value'=>function($data){
                $html = '';
                if (!empty($data->file_url))
                    $html = "<a href='".Yii::app()->getRequest()->getHostInfo().$data->file_url."' target='_blank'><i class='fa fa-file'></i></a>";    
                return $html;
            }
        ),
        array(
            'header' => Yii::t('admin/staff', 'Actions'),
            'htmlOptions' => array('style'=>'width:10%'),
            'type' => 'raw',
            'value' => function($data){
                $html ='';
                $html = "<a href='javascript:void(0);' onClick='javascript:updateNotes(".$data->id_note_staff.");'><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;";
                $html.= "<a href='javascript:void(0);' onClick='javascript:deleteNotes(".$data->id_note_staff.", ".$data->id_staff.",\"".Yii::t('admin/staff', 'Are you sure you want to delete this item?')."\");'><i class='fa fa-trash-o'></i></a>";
                return $html;
            }
        ),
	),
)); ?><br /><br />