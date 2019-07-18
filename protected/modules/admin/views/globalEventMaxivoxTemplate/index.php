<?php
/* @var $this GlobalEventTemplateController */
/* @var $model GlobalEventTemplate */

$this->breadcrumbs=array(
	Yii::t('admin/maxivox', 'Global Event MaxiVox Templates') => array('index'),
	Yii::t('admin/maxivox', 'Manage'),
);
?>
<h1><?php echo Yii::t('admin/maxivox', 'Manage Global Event MaxiVox Templates');?></h1>
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
	'id'=>'global-event-template-grid',
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
        'desc_global_event',
		array(
            'name'=>'id_maxivox_type',
            'value'=>'$data->idMaxiVoxType->description',
            'filter'=>CHtml::listData(MaxivoxType::model()->findAll(), 'id_maxivox_type','description')
        ),
        array(
            'name'=>'pick_event_type',
            'value'=>'$data->pick_event_type',
            'filter'=>Yii::app()->params['pick_event_type']
        ),
        array(
            'name'=>'id_global_message',
            'value'=>'$data->idGlobalMessage->global_description',
            'filter'=>CHtml::listData(GlobalMessages::model()->findAll(), 'id_global_message','global_description'),
            //'htmlOptions'=>array('class' => 'form-control')
        ),
		array(
            'header' => Yii::t('admin/maxivox', 'Actions'),
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
	)
)); ?>
