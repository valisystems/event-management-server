<?php
/* @var $this GlobalEventTemplateController */
/* @var $model GlobalEventTemplate */

$this->breadcrumbs=array(
	Yii::t('admin/maxivox', 'Global Event MaxiVox Templates')=>array('index'),
	$model->desc_global_event=>array('view','id'=>$model->id_global_event_maxivox_template),
	Yii::t('admin/maxivox','Update'),
);
?>
<script>
var id_global_event_maxivox_template = <?php echo $model->id_global_event_maxivox_template;?>;
</script>
<h1><?php echo Yii::t('admin/maxivox', 'Global Event MaxiVox Templates')."    <b><i>".$model->desc_global_event."</i></b>"; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>