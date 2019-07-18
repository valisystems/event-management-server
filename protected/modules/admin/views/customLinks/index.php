<?php
/* @var $this CustomLinksController */

$this->breadcrumbs=array(
	Yii::t('admin/command','Custom Links'),
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
	echo Yii::t('admin/command', 'Manage Custom Links');
	?></h1>
<div class="row">
	<?php
	echo CHtml::link( 'Create', array( 'create' ),
		array(
			//'class' => 'update-dialog-open-link',
			'data-update-dialog-title' => Yii::t( 'admin/maps','Create Command' ),
			'class'=>'btn btn-primary'
		));
	?>
</div>
<br/><br/>
<table class="hover display" id="resultCustomLinks" data-page-length='25'>
	<thead>
	<tr>
		<th data-sortable="true" style="width: 100px;"><?php echo Yii::t('admin/rooms','Description');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','URL');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Target');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Location');?></th>
		<th data-sortable="true"><?php echo Yii::t('admin/rooms','Actions');?></th>
	</tr>
	</thead>
</table>