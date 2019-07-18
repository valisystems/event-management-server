<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */

?>
<div id='ajax_loader' style="display: none;z-index:100000" class="ui-widget-overlay">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; z-index:3000000"/>
</div>

    <div id="messages"></div>
<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'users-rules',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'action'=>Yii::app()->createUrl('/admin/users/updateAccessRules/id/'.$model->id_user),
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        )
    )); ?>

<?php
    $selected_Array= (isset($model->access_rules) && !empty($model->access_rules)) ? unserialize($model->access_rules) : array();
    //print_r($this->userRules);
    foreach ($this->userRulesPath as $k=>$v){
        ?>
        <div class="box">
            <div class="box-header">
                <h2><i class="fa fa-edit"></i><span class="break"></span><?php echo $v['name'];?></h2>
                <div class="box-icon">
                    <a href="javascript:void(0);" class="btn-minimize"><i class="fa fa-chevron-down"></i></a>
                </div>
            </div>
            <div class="box-content" style="display: none;height:200px;overflow-y:auto !important;;">
                <?php
                    $arrCheck = array();
                    if (isset($v['data']) && $v['data'] == 'fromDB') {
                        $list = CustomLinks::model()->findAll();
                        foreach ($list as $mc => $lc){
                            $arrCheck["cust_".$lc->id_custom_links] = $lc->desc_custom_links;
                        }
                    } else {
                        foreach ($v['controller'] as $m => $l) {
                            $arrCheck[$v['module'] . '/' . $l['name']] = $l['description'];
                            //array_push($arrCheck, array($v['module'].'/'.$l['name'] => $l['name']));
                        }
                    }
                //print_r($arrCheck);
                    if (count($arrCheck)) {
                        echo CHtml::checkBoxList('access_rules[]',$selected_Array,$arrCheck);
                    } else {
                        echo Yii::t('admin/users', 'No actions for this module');
                    }

                ?>
            </div>
        </div>
        <?php
    }
?>
<!--div class="form-group">
    <label class="control-label" for="selectError1"><?php echo Yii::t("admin/users", "Access Rules");?></label>
    <div class="controls">
        <select id="selectError1" class="form-control" multiple data-rel="chosen">
            <option>Option 1</option>
            <option selecte	d>Option 2</option>
            <option>Option 3</option>
            <option>Option 4</option>
            <option>Option 5</option>
        </select>
    </div>
</div-->

<?php $this->endWidget(); ?>