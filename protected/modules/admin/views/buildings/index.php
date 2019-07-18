<?php
/* @var $this BuildingsController */
/* @var $model Buildings */

$this->breadcrumbs=array(
	Yii::t('admin/buildings','Buildings')=>array('index'),
	Yii::t('admin/buildings','Manage'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#buildings-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('admin/buildings', 'Manage Buildings');?></h1>
<div id='ajax_loader' style="display: none;" class="ui-widget-overlay">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; "/>
</div>
<div class="row">
<?php
echo CHtml::link( Yii::t('admin/buildings', 'Create'), array( 'create' ),
  array(
    'class' => 'btn btn-primary',
    'data-update-dialog-title' => Yii::t( 'admin/buildings','Create E-Maps' ),
));
?>
</div>
<div class="row">
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'updateEmap',
        'options'=>array(
            'title'=> Yii::t( 'admin/buildings','Edit E-Maps'),
            'autoOpen'=>false,
            'modal'=>true,
            'autoResize' => true,
            'width'=>'auto',
            'height'=>'auto',
            //'resizable'=>'false',
            'buttons' => array
            (
                 Yii::t('admin/buildings', 'Save')=>'js:function(){submitUpdateFloor()}',
                 'Close'=>'js:function(){$(this).dialog("close");$("#ajax_loader").ajaxStop(function(){
        $(this).hide();
    });}',
            ),
        ),
    ));
$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'manageEmaps2',
        'options'=>array(
            'title'=>'Manage E-Maps',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'auto',
            'height'=>'auto',
            'autoResize' => true,
            //'resizable'=>'false',
            'buttons' => array
            (
                 'Add Floor'=>'js:function(){manageEmaps();}',
                 'Close'=>'js:function(){$(this).dialog("close")}',
            ),
        ),
    ));
$this->endWidget();

$manageDialog =<<<'EOT'
    function() {
         $("#ajax_loader").ajaxStart(function(){
             $(this).show();
         }); 
        var url = $(this).attr('href');
        $.get(url, function(r){
            var stArray = url.split("/");
            var idBuilding = stArray[stArray.length-1];
            $("#manageEmaps2").html(r).dialog("open");
            $('#Maps_id_building').val(idBuilding);
        });
        $("#ajax_loader").ajaxStop(function(){
            $(this).hide();
         });
        return false;
    }
EOT;

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'buildings-grid',
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
    'rowHtmlOptionsExpression' => 'array("id"=>"tr_".$data->id_building)',
    'summaryText'=> Yii::t('admin/buildings', 'Displaying {start}-{end} of {count} results.'),    
	'columns'=>array(
		array(
            'name' => '...',
            'type' => 'raw',
            'value' => function($data){
                return "<a id_building='".$data->id_building."' href='#' onClick='javascript:manageAppendTr(this);' class='expand' toremove='no' urlToGet='".Yii::app()->createUrl("admin/buildings/viewflors", array("id"=>$data->id_building))."'><i class='fa fa-caret-square-o-right'></i>";
            }
        ),
        'name',
		'address',
		array(
            'header' => Yii::t('admin/building', 'Actions'),
            'template'=>'{manageFloor}&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
			'class'=>'CButtonColumn',
            'htmlOptions' =>array('style','width:50px;'),
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
                'manageFloor'=> array(
                    'label' => '<i class="fa fa-hospital-o"></i>',
                    'url' => 'Yii::app()->createUrl("admin/buildings/addFloor", array("id"=>$data->id_building))',
                    'options'=> array('title'=>Yii::t('admin/building', 'Add E-Maps')),
                    'click' => $manageDialog
                ),
            )
		),
	),
)); ?>
</div>