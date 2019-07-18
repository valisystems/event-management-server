<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	Yii::t('admin/users','Users')=>array('index'),
	Yii::t('admin/users','Manage'),
);
$urlAuthConf = require(Yii::getPathOfAlias('application.config.auth').'.php');
$authArray = array();

foreach ($urlAuthConf as $v) {
    $authArray[$v['abreviation']] = $v['description'];
}
?>

<h1><?php echo Yii::t('admin/users','Manage Users');?></h1>
<div class="row">
<?php
echo CHtml::link( 'Create', array( 'create' ),
  array(
    'class' => 'btn btn-primary',
    'data-update-dialog-title' => Yii::t( 'admin/globalmessages','Create Global Messages' ),
));
?>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'manageAccessRules',
    'options'=>array(
        'title'=>'Manage Access Rules',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'500',
        'height'=>'auto',
        'autoResize' => true,
        //'resizable'=>'false',
        'buttons' => array
        (
            'Save'=>'js:function(){saveAccessRules();}',
            'Close'=>'js:function(){$(this).dialog("close")}',
        ),
    ),
));
$this->endWidget();

$manageAccessRules =<<<'EOT'
    function() {
         $("#ajax_loader").ajaxStart(function(){
             $(this).show();
         });
        var url = $(this).attr('href');
        $.get(url, function(r){
            $("#manageAccessRules").html(r).dialog("open");
            $("[data-toggle='popover']").popover(
                {
                    html:true,
                    trigger:"hover",
                }
            );
        });
        $("#ajax_loader").ajaxStop(function(){
            $(this).hide();
         });
        return false;
    }
EOT;

?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'manageBuildingsRules',
    'options'=>array(
        'title'=>'Manage Building Access',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'500',
        'height'=>'auto',
        'autoResize' => true,
        //'resizable'=>'false',
        'buttons' => array
        (
            'Save'=>'js:function(){saveBuildingRules();}',
            'Close'=>'js:function(){$(this).dialog("close")}',
        ),
    ),
));
$this->endWidget();

$manageBuildingsRules =<<<'EOT'
    function() {
         $("#ajax_loader").ajaxStart(function(){
             $(this).show();
         });
        var url = $(this).attr('href');
        $.get(url, function(r){
            $("#manageBuildingsRules").html(r).dialog("open");
            $("[data-toggle='popover']").popover(
                {
                    html:true,
                    trigger:"hover",
                }
            );
        });
        $("#ajax_loader").ajaxStop(function(){
            $(this).hide();
         });
        return false;
    }
EOT;

?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
    'enableSorting'=>'true',
    'emptyText'=>'No Data',
    'enablePagination'=> true,
	//'filter'=>$model,
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
    'summaryText'=> Yii::t('admin/maps', 'Displaying {start}-{end} of {count} results.'),
	'columns'=>array(
		'first_name',
		'last_name',
		'login_name',
		'email',
		array(
            'name'=>'role',
            'type'=> 'raw',
            'value'=> function($data) use ($authArray){
                   $htmlData = $authArray[$data->role]; 
                   return  $htmlData;
            }
        ),
		'phone',
		'company',
		/*
		'reports',
		*/
		array(
            'name'=>'status',
            'type'=>'raw',
            'value'=> function ($data){
                return ($data->status) ? '<i class="fa fa-thumbs-up"></i>' : '<i class="fa fa-thumbs-down"></i>';
            }
        ),
		array(
			'class'=>'CButtonColumn',
            'header' => Yii::t('admin/maps', 'Actions'),
            'template'=>'{manage_building_view}&nbsp;&nbsp;{access_rules}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
            'htmlOptions' => array('style' => 'width: 90px !important; text-align:left'),
            'buttons'=> array(
                'manage_building_view' => array(
                    'label' => '<i class="fa fa-hospital-o"></i>',
                    'url' => 'Yii::app()->createUrl("admin/users/manageBuildingsRules", array("id"=>$data->id_user))',
                    'options'=> array('title'=>Yii::t('admin/users', 'Manage Buildings Rules')),
                    'click' => $manageBuildingsRules
                ),
                'access_rules' => array(
                    'label' => '<i class="fa fa-sitemap"></i>',
                    'url' => 'Yii::app()->createUrl("admin/users/manageAccessRules", array("id"=>$data->id_user))',
                    'options'=> array('title'=>Yii::t('admin/users', 'Manage Access Rules')),
                    'click' => $manageAccessRules
                ),
                'update' => array(
                    'label' => '<i class="fa fa-pencil"></i>',
                    'options'=> array('title'=>Yii::t('admin/users', 'Update')),
                    'imageUrl' => false,
                ),
                'delete' => array(
                    'visible' => '$data->id_user > 1',
                    'label' => '<i class="fa fa-trash-o"></i>',
                    'imageUrl' => false,
                ),
            )
		),
	),
)); ?>
