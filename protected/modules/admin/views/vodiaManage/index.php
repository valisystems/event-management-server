<?php
/* @var $this VodiaManageController */

$this->breadcrumbs=array(
	'Vodia Manage',
);

?>

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Vodia Server</h3>
		</div>
		<div class="panel-body">
			<table id="vodiaTable" class="display table table-hover" cellspacing="0" width="100%" data-page-length='25'>
				<thead>
				<tr>
					<th>Server Name</th>
					<th>Server URL</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				<?php
				if (count($model)) {
					foreach ($model as $k) {
						echo "<tr>
                                <td>".$k['asterisk_name']."</td>
                                <td>".htmlspecialchars($k['asterisk_url'])."</td>
                                 <td>".CHtml::link( Yii::t( 'admin/staff','Manage' ), array( 'manage' , 'id_asterisk'=>$k['id_asterisk']),
								array(
									//'class' => 'update-dialog-open-link',
									'data-update-dialog-title' => Yii::t( 'admin/rooms','Add Room' ),
									'class'=>'btn btn-primary'
								))."</td>
                            </tr>";

					}
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
