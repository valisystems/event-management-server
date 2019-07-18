<?php
/* @var $this SystemVoiceNumberController */
/* @var $model SystemVoiceNumber */

$this->breadcrumbs=array(
	'System Voice Numbers'=>array('index'),
	'Manage',
);

?>
<h1><?php echo Yii::t('admin/systemvoicenumber', 'Manage System Voice Numbers');?></h1>
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
    'data-update-dialog-title' => Yii::t( 'admin/globalmessages','Create Global Messages' ),
));
?>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'system-voice-number-grid',
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
		'description_voice_number',
		'name_voice_number',
        'number_to_call',
		/*array(
            'name'=>'number_to_call',
            'type'=>'raw',
            'value'=> function($data){
                if (substr($data->number_to_call, 0,1) == '1') {
                    $tmp = substr($data->number_to_call, 0,1)." (".substr($data->number_to_call, 1,3).") ".substr($data->number_to_call, 4,3).'-'.substr($data->number_to_call, 7);
                } else {
                    $tmp = "(".substr($data->number_to_call, 0,3).") ".substr($data->number_to_call, 3,3).'-'.substr($data->number_to_call, 6);
                }
                return $tmp;
            }
        ),*/
        array(
            'header' => Yii::t('admin/systemvoicenumber', 'Actions'),
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
