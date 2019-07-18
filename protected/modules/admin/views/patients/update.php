<?php
/* @var $this PatientsController */
/* @var $model Patients */

$this->breadcrumbs=array(
	Yii::t('admin/patients','Patients')=>array('index'),
	//$model->id_patient=>array('view','id'=>$model->id_patient),
	'Update',
);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/assets/css/modules/admin/pages/patients.css');
?>

<h1><?php echo Yii::t('admin/patients', 'Update Patients ').'<b><i>'.$model->first_name.' '.$model->last_name.'</i></b>'; ?></h1>

<?php $this->renderPartial('_form_update_tab', array('model'=>$model)); ?>
<?php


    Yii::app()->clientScript->registerScript('loading', ' 
        populateUpdateForm('.$model->id_patient.');
        
    ', CClientScript::POS_LOAD);  

?>