<?php
/* @var $this HttpInventoryController */

$this->breadcrumbs=array(
	'Http Inventory',
);
?>

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
<br/>
<h1><?php
	echo Yii::t('admin/httpInventory', 'HTTP Inventory');
	?></h1>
<div class="row">
	<?php
	echo CHtml::link( 'Create', array( 'create' ),
		array(
			//'class' => 'update-dialog-open-link',
			'data-update-dialog-title' => Yii::t( 'admin/httpInventory','Create HTTP Action' ),
			'class'=>'btn btn-primary'
		));
	?>
</div>
<br/>
<div class="row" style="background-color: white; padding: 10px; border-radius: 5px">
	<table class="table table-hover display" id="resultHttp" data-page-length='25'>
		<thead>
		<tr>
			<th data-sortable="true" style="width: 100px;"><?php echo Yii::t('admin/http','Description');?></th>
			<th data-sortable="true"><?php echo Yii::t('admin/http','Type URL');?></th>
			<th data-sortable="true"><?php echo Yii::t('admin/http','URL Action');?></th>
			<th data-sortable="true"><?php echo Yii::t('admin/http','Action');?></th>
		</tr>
		</thead>
		<tbody>
		<?php
		if (count($model)) {
			foreach ($model as $k) {
				echo "<tr>
                                <td>".$k['description']."</td>
                                <td>".$k['type_of_url']."</td>
                                <td>".urldecode($k['action_url'])."</td>
                                <td><a href='".Yii::app()->createUrl("admin/httpInventory/update", array("id"=>$k['id_http_inventory']))."'><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href='".Yii::app()->createUrl("admin/httpInventory/delete", array("id"=>$k['id_http_inventory']))."' onClick='javascript:return confirm(\"".Yii::t('admin/http', 'Are you sure you want to delete this item?')."\")'><i class='fa fa-trash-o'></i></a></td>
                            </tr>";

			}
		}
		?>
		</tbody>
	</table>
</div>
<script>
	$(document).ready(function () {
		$('#resultHttp').dataTable({
			"paging": true,
			"ordering": true,
			"hover": true,
			"info": false,
			"processing": true,
			"serverSide": false,
			"stateSave": true,
			//"filter": false,
			"destroy": true
		});
	$('#resultHttp').removeClass('display');
	});
</script>