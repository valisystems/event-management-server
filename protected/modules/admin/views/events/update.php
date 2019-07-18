<?php
/**
 * User: iurik
 * Date: 5/25/15
 * Time: 13:05
 */

$this->breadcrumbs=array(
    Yii::t('admin/events','Events')=>array('index'),
    //$model->name=>array('view','id'=>$model->id_event),
    Yii::t('admin/events','Update'),
);

?>

    <h1><?php echo Yii::t('admin/events','Update Events');?> <b><i><?php //echo $model->name; ?></i></b></h1>

<?php $this->renderPartial('_form_events_update', array('model'=>$model)); ?>