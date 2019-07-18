<?php
/**
 * User: iurik
 * Date: 5/25/15
 * Time: 13:05
 */

$this->breadcrumbs=array(
    Yii::t('admin/eventspendant','Events Pendant')=>array('index'),
    //$model->name=>array('view','id'=>$model->id_event),
    Yii::t('admin/eventspendant','Update'),
);

?>

    <h1><?php echo Yii::t('admin/events','Update Events Pendant');?> <b><i><?php //echo $model->name; ?></i></b></h1>

<?php $this->renderPartial('_form_update', array('model'=>$model)); ?>