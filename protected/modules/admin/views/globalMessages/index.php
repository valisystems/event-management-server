<?php
/* @var $this GlobalMessagesController */
/* @var $model GlobalMessages */

$this->breadcrumbs=array(
	Yii::t( 'admin/globalmessages','System Messages' )=>array('index'),
	Yii::t( 'admin/globalmessages','Manage' ),
);

?>
<h1><?php Yii::t('admin/globalmessages','Manage System Messages')?></h1>
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
    'data-update-dialog-title' => Yii::t( 'admin/globalmessages','Create System Messages' ),
));
?>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'global-messages-grid',
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
        array(
            'name'=>'global_description',
            'type'=>'raw',
            'value'=> function($data){
                   $htmlData = "<span title='".$data->global_description."'  data-html='true' data-content='".$data->global_text."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$data->global_description."</span>"; 
                   return  $htmlData;
            }
        ),
        array(
            'name'=>'global_subject',
            'type'=>'raw',
            'value'=> function($data){
                   $htmlData = "<span title='".$data->global_description."'  data-html='true' data-content='".$data->global_text."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$data->global_subject."</span>"; 
                   return  $htmlData;
            }
        ),
		array(
            'header' => Yii::t('admin/globalmessages', 'Actions'),
            'template'=>'{update}&nbsp;&nbsp;{delete}',
			'class'=>'CButtonColumn',
            'buttons' =>array(
                'update' => array(
                    'label' => '<i class="fa fa-pencil"></i>',
                    'options'=> array('title'=>Yii::t('admin/building', 'Update')),
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
