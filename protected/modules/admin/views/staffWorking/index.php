<?php
/* @var $this StaffController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staff',
);

$tmp = Yii::app()->request->getParam('building_id');
$tmp2 = Yii::app()->request->getParam('id_map');
$building_id = (!empty( $tmp )) ? $tmp : -1;
$id_map = (!empty($tmp2 )) ? $tmp2 : 0;



?>

<h1>Staff Information</h1>
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
		<a href="<?php echo Yii::app()->createUrl('admin/staffWorking');?>" role="button" aria-expanded="false">
			<?php echo Yii::t('admin/staff', 'All')?>
		</a>
	</li>
	<?php
	$buildings = Buildings::model()->findAll();
	$html = "";
	foreach ($buildings as $k){
		$floor = "";
		foreach($k->floor as $fl){
			$floor .= "<li><a href='".Yii::app()->createUrl('admin/staffWorking/index/id_map/'.$fl->id_map.'/building_id/'.$fl->id_building) ."'>{$fl->name_map}</a></li>";
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
<div class="staff-content">
</div>

<script>
	var id_building = <?php echo $building_id;?>;
	var id_map = <?php echo $id_map;?>;
</script>

<br/><br/>
<table class="display dataTable" id="resultStaff" data-page-length='25'>
	<thead>
	<tr>
		<th data-sortable="true" style="width: 100px;"><?php echo Yii::t('admin/staff','Date');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','First & Last Name');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Position');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Extension');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Actions');?></th>
	</tr>
	</thead>
</table>
