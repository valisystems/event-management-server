<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label" for="global_event"><?php echo $this->label($model,Yii::t('admin/settings','global_event')); ?></label>
            <div class="input-group date col-sm-4">
               <span class="input-group-addon">
                    <i class="fa  fa-comment-o"></i>
                </span>
                <?php
                    echo $this->dropDownList($model, 'global_event',CHtml::listData(GlobalEventTemplate::model()->findAll(), 'id_global_event_template','desc_global_event'));
                ?>
		    </div>
        </div>
    </div>
</div>