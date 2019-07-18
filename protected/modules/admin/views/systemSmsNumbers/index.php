<?php
/* @var $this SystemSmsNumbersController */
/* @var $model SystemSmsNumbers */

$this->breadcrumbs=array(
	Yii::t('admin/systemsmsnumbers', 'System SMS Numbers')=>array('index'),
	Yii::t('admin/systemsmsnumbers', 'Manage'),
);
?>

<h1><?php echo Yii::t('admin/systemsmsnumbers', 'Manage System SMS Numbers')?></h1>
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
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'system-sms-numbers-grid',
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
    'summaryText'=> Yii::t('admin/systemnotice', 'Displaying {start}-{end} of {count} results.'),
	'columns'=>array(
		'description_sms',
		'name_sms',
		array(
            'name'=>'number_sms',
            'type'=>'raw',
            'value'=> function($data){
                $tmp = "(".substr($data->number_sms, 0,3).") ".substr($data->number_sms, 3,3).'-'.substr($data->number_sms, 6);
                return $tmp;
            }
        ),
		array(
            'header' => Yii::t('admin/systemsmsnumber', 'Actions'),
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
