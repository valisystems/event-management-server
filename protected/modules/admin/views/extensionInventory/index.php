<?php
/* @var $this ExtensionInventoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Extension Inventories',
);


$tmp = Yii::app()->request->getParam('building_id');
$tmp2 = Yii::app()->request->getParam('id_map');
$building_id = (!empty( $tmp )) ? $tmp : -1;
$id_map = (!empty($tmp2 )) ? $tmp2 : 0;
?>
	<div id='ajax_loader' style="display: none;" class="ui-widget-overlay">
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; z-index:3000000"/>
	</div>
	<h1><?php echo Yii::t('admin/extensionInventory', 'Manage Extension');?></h1>
	<div class="row">
<?php
echo CHtml::link( Yii::t( 'admin/extensionInventory','Add Extension' ), array( 'create' ),
	array(
		//'class' => 'update-dialog-open-link',
		'data-update-dialog-title' => Yii::t( 'admin/extensionInventory','Add Extension' ),
		'class'=>'btn btn-primary'
	));
?>
	</div><br/>
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
<ul class="nav nav-tabs" id="roomsTab">
	<?php
	if ($building_id == -1) {
	?>
<li role="presentation" class="active">
<?php } else {?>
	<li role="presentation">

		<?php }?>
		<a href="<?php echo Yii::app()->createUrl('admin/extensionInventory');?>" role="button" aria-expanded="false">
			<?php echo Yii::t('admin/extensionInventory', 'All')?>
		</a>
	</li>
	<?php
	$buildings = Buildings::model()->findAll();
	$html = "";
	foreach ($buildings as $k){
		$floor = "";
		foreach($k->floor as $fl){
			$floor .= "<li><a href='".Yii::app()->createUrl('admin/extensionInventory/index/id_map/'.$fl->id_map.'/building_id/'.$fl->id_building) ."'>{$fl->name_map}</a></li>";
		}
		if ($floor != "") {
			if ($k->id_building == $building_id)
				$html .= "<li role='presentation' class='dropdown active'>";
			else
				$html .= "<li role='presentation' class='dropdown'>";
			$html .= "<a class='dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-expanded='false'>
                                    {$k->name} <span class='caret'></span>
                                </a>";
			$html .= "<ul class='dropdown-menu' role='menu'>";
			$html .= $floor;
			$html .= "</ul>";
			$html .= "</li>";
		} else {
			if ($k->id_building == $building_id)
				$html .= "<li class='active'>";
			else
				$html .= "<li>";
			$html .= "<a href='#' role='button' aria-expanded='false'>
                                    {$k->name}
                                </a>";
			$html .= "</li>";
		}
	}
	echo $html;
	?>
</ul>
<div class="extension-content">
</div>

<script>
	var id_building = <?php echo $building_id;?>;
	var id_map = <?php echo $id_map;?>;
</script>

<br/><br/>
<table class="hover display" id="resultExtensionInventory" data-page-length='25'>
	<thead>
	<tr>
		<th data-sortable="true" style="width: 100px;"><?php echo Yii::t('admin/rooms','Extension Number');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Caller ID Internal');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Caller ID External');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Caller ID Name');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Actions');?></th>
	</tr>
	</thead>
</table>

