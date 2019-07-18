<?php
/* @var $this CallsTypeController */
/* @var $model CallsType */

$this->breadcrumbs=array(
	'MaxiVox Types'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List MaxiVox Type', 'url'=>array('index')),
	array('label'=>'Create MaxiVox Type', 'url'=>array('create')),
);
?>

<h1><?php Yii::t('admin/maxivox','Manage MaxiVox Types')?></h1>
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
));
?>
</div>
<div class="row">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'maxivox-type-grid',
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
    'summaryText'=> Yii::t('admin/maxivox', 'Displaying {start}-{end} of {count} results.'),
	'columns'=>array(
		'description',
		'script',
		'priority',
		array(
            'name' => 'color_hex',
            'type'=>'raw',
            'value'=> function($data){
                return "<span style='width:15px;height:15px;background-color:".$data->color_hex.";display:block;' title='".$data->color_hex."'>&nbsp;</span>"; 
            }
        ),
		array(
            'header' => Yii::t('admin/maxivox', 'Actions'),
            'template'=>'{update}&nbsp;&nbsp;{delete}',
			'class'=>'CButtonColumn',
            'buttons' =>array(
                'update' => array(
                    'label' => '<i class="fa fa-pencil"></i>',
                    'options'=> array('title'=>Yii::t('admin/maxivox', 'Update')),
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
</div>