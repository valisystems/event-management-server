<?php
/* @var $this ExportController */
/* @var $form CActiveForm */
$this->breadcrumbs=array(
    'Events Reports'=>array('index'),
);

$dateLast = mktime(date('i'), date('H'), date('s'), date('m')-1, date('d'), date('Y'));
$dateNext = mktime(date('i'), date('H'), date('s'), date('m'), date('d'), date('Y'));

?>
<div id='ajax_loader' style="display: none;z-index:100000" class="ui-widget-overlay">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; z-index:3000000"/>
</div>
<fieldset>
<legend>
    Search Criteria
</legend>

<div class="form">
    <div class="box">
        <div class="box-header">
            <h2><i class="fa fa-floppy-o"></i> Event Reports</h2>

        </div>
        <div class="box-content">
            <form name="eventsReport" id="eventsReport-form" action="" method="post">
                <div class="dropdown" style="position: relative;right: 0;top: 0;float: right;">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-floppy-o"></i>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="" id="exportPDF" ><i class="fa fa-file-pdf-o"></i> PDF</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="0" href="" id="exportXLS"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-sm-2">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="control-label" for="checkSearch"><?php echo Yii::t('admin/eventsreports', 'Event Date');?></label>
                        </div>
                        <div class="row col-xs-3 col-sm-3 col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input class="form-control input-append date" id="daterange" name="daterange" data-format="yyyy-MM-dd HH:mm:ss"  value="<?php echo date('Y/m/d H:i', $dateLast);?>" type="text" placeholder="From">
                            </div>
                        </div>
                        <div class=" col-xs-3 col-sm-3 col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input class="form-control input-append date" id="daterangeTo" name="daterangeTo" data-format="yyyy-MM-dd HH:mm:ss"  value="<?php echo date('Y/m/d H:i', $dateNext);?>" type="text" placeholder="To">
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class=" col-xs-12 col-sm-12 col-md-12">
                        <div class="col-sm-2">
                            <input id="serialNumberCheck" name="searchFilter" value="serialNumberCheck" type="radio">&nbsp;
                            <label class="control-label" for="serialNumberCheck"><?php echo Yii::t('admin/eventsreports', 'Serial Number');?></label>
                        </div>
                        <div class="input-group col-sm-4">
                            <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                            <input class="form-control" value="" type="text" id="serialNumber" name="serialNumber">
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class=" col-xs-12 col-sm-12 col-md-12">
                        <div class="col-sm-2">
                            <input id="codeCheck" name="searchFilter" value="codeCheck" type="radio">&nbsp;
                            <label class="control-label" for="codeCheck"><?php echo Yii::t('admin/eventsreports', 'Code');?></label>
                        </div>
                        <div class="input-group col-sm-4">
                            <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                            <?php
                                echo  CHtml::dropDownList('code', '', CHtml::listData(CallsType::model()->findAll(), 'script','description'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/eventsreports','Select Call Type')));
                            ?>

                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class=" col-xs-12 col-sm-12 col-md-12">
                        <div class="col-sm-2">
                            <input id="typeEventCheck" name="searchFilter" value="typeEventCheck" type="radio">&nbsp;
                            <label class="control-label" for="typeEventCheck"><?php echo Yii::t('admin/eventsreports', 'Type of Event');?></label>
                        </div>
                        <div class="input-group col-sm-4">
                            <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                            <select class="form-control" id="typeEvent" name="typeEvent">
                               <?php
                               foreach (Yii::app()->params['pick_event_type'] as $k => $v){
                                   echo "<option value='{$k}'>{$v}</option>";
                               }
                               ?>
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class=" col-xs-12 col-sm-12 col-md-12">
                        <div class="col-sm-2">
                            <input id="receiverCheck" name="searchFilter" value="receiverCheck" type="radio">&nbsp;
                            <label class="control-label" for="receiverCheck"><?php echo Yii::t('admin/eventsreports', 'Receiver');?></label>
                        </div>
                        <div class="input-group col-sm-4">
                            <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                            <input class="form-control" value="" type="text" id="receiver" name="receiver">
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class=" col-xs-12 col-sm-12 col-md-12">
                        <?php
                        echo CHtml::button(Yii::t('admin/eventsreports','Search'), array('id'=> "search", 'class'=>'btn btn-primary'));
                        echo "&nbsp;&nbsp;".CHtml::button(Yii::t('admin/eventsreports','Reset'), array('id'=> "reset", 'class'=>'btn btn-primary'));
                        ?>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12" id="exportContent">

                </div>
            </div>
        </div>
    </div>
</div>
</fieldset>
<br/>
<table class="hover display" id="resultEvent" data-page-length='25' style="display:none;">
    <thead>
        <tr>
            <th data-sortable="true">Time</th>
            <th data-sortable="true" data-field="device_description">Device Description</th>
            <th data-sortable="true">Room #</th>
            <th data-sortable="true">Receiver</th>
            <th data-sortable="true">Serial Number</th>
            <th data-sortable="true">Code</th>
            <th data-sortable="true">Type Notification</th>
        </tr>
    </thead>
</table>