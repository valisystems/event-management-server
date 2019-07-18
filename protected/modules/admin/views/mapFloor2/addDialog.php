<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'mapAddDialog',
                'options'=>array(
                    'title'=>Yii::t('admin/mapFloor','Create Map'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'auto',
                    'height'=>'auto',
                ),
                ));
echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>