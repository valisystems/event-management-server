<?php
/* @var $this UpdateEmsController */

$this->breadcrumbs=array(
	'Update Ems',
);
$res = CJSON::decode($response);
$arr_Version = array();
?>

<div class="box">
	<div class="box-header">
		<h2><i class="fa fa-th"></i><span class="break"></span>Update Info</h2>
	</div>
	<div class="box-content">

		<?php
		if (count($res) > 0) {

			foreach ($res['update'] as $v) {
				$randNumber = time() . rand(0, 99999999999999999);
				$id = "collapse" . $randNumber;
				if (empty($existUpdate[$v['update_version']])) {
					$arr_Version[$randNumber] = $v['update_version'];
				}
				?>
				<div class="panel panel-info">
					<div class="panel-heading">
						<h4 class="panel-title">
							<b><a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
								  href="ui-elements.html#<?php echo $id;?>">
									<?php echo $v['update_name'] . " <small>vers. " . $v['update_version'] . "</small>";?>
								</a></b>
						</h4>
					</div>
					<div style="height: 0px;" id="<?php echo $id;?>" class="panel-collapse collapse">
						<div class="panel-body">
							<table class="table">
								<tr>
									<td colspan="2">
										<?php echo html_entity_decode($v['update_description']);?>
									</td>
								</tr>
								<tr>
									<td style="width: 140px"><h6><?php echo $v['update_time_ins'];?></h6></td>
									<td style="text-align: right;"><h6>
											<?php
											if (!empty($existUpdate[$v['update_version']]) && $existUpdate[$v['update_version']]['update_custom'] == '0') {
												?>
												<span class="btn btn-default"><?php echo Yii::t('admin/updateEms', 'Installed')?></span>
											<?php
											} else {

												?>
												<a
													id="<?php echo $randNumber; ?>"

													href="/admin/updateEms/applyUpdate/actUpdate/<?php echo $v['update_path']; ?>"
													class="btn btn-primary"><?php echo Yii::t('admin/updateEms', 'Apply update'); ?></a>
											<?php
											}
												?>
										</h6></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			<?php
			}
			asort($arr_Version, SORT_NUMERIC);
			?>

		<?php
		} else {
			echo "No Data";
		}
		?>


	</div>
</div>
	<script>
		var version_arr = $.parseJSON(JSON.stringify(<?php print json_encode($arr_Version); ?>));
	</script>
<?php
if (count($res['custom'])){
	?>
	<div class="box">
		<div class="box-header">
			<h2><i class="fa fa-th"></i><span class="break"></span>Custom Update Info</h2>
		</div>
		<div class="box-content">

			<?php
			if (count($res) > 0) {
				foreach ($res['custom'] as $v) {
					$id = "collapse" . time() . rand(0, 99999999999999999);
					?>
					<div class="panel panel-warning">
						<div class="panel-heading">
							<h4 class="panel-title">
								<b><a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
									  href="ui-elements.html#<?php echo $id;?>">
										<?php echo $v['update_name'] . " <small>vers. " . $v['update_version'] . "</small>";?>
									</a></b>
							</h4>
						</div>
						<div style="height: 0px;" id="<?php echo $id;?>" class="panel-collapse collapse">
							<div class="panel-body">
								<table class="table">
									<tr>
										<td colspan="2">
											<?php echo html_entity_decode($v['update_description']);?>
										</td>
									</tr>
									<tr>
										<td style="width: 140px"><h6><?php echo $v['update_time_ins'];?></h6></td>
										<td style="text-align: right;"><h6>
					<?php
					if (!empty($existUpdateCustom[$v['update_version']]) && $existUpdateCustom[$v['update_version']]['update_custom'] == '1') {
					?>
					<span class="btn btn-default"><?php echo Yii::t('admin/updateEms', 'Installed')?></span>
				<?php
				} else {

					?>
												<a
													href="/admin/updateEms/applyUpdate/actUpdate/<?php echo $v['update_path']; ?>"
													class="btn btn-primary"><?php echo Yii::t('admin/updateEms', 'Apply update');?></a>
						<?php }?>
											</h6></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				<?php
				}
			} else {
				echo "No Data";
			}
			?>


		</div>
	</div>
<?php
}
?>