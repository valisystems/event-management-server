<?php
/* @var $this DefaultController */
/* @var $error array */
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>


<div class="alert alert-danger">
<button class="close" data-dismiss="alert" type="button">x</button>
<h2>Error <?php echo $code; ?></h2>
<?php echo CHtml::encode($message); ?>
</div>