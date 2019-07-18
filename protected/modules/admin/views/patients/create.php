<?php
/* @var $this PatientsController */
/* @var $model Patients */

$this->breadcrumbs=array(
	'Patients'=>array('index'),
	'Create',
);

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/assets/css/modules/admin/pages/patients.css');
?>

<h1>Create Patients</h1>

<?php $this->renderPartial('_form_tab', array('model'=>$model)); ?>