<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 4/28/15
 * Time: 23:00
 */

$this->breadcrumbs=array(
    Yii::t('admin/cdr', 'Vodia CDR')=>array('index'),
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
                <h2><i class="fa fa-floppy-o"></i> Vodia CDR</h2>

            </div>
            <div class="box-content">
                <form name="cdrReport" id="cdrReport-form" action="" method="post">
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
                                <!--input id="checkSearch" name="searchFilter" value="daterange" type="radio" checked>-->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label class="control-label" for="checkSearch"><?php echo Yii::t('admin/cdr', 'Call Date');?></label>
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
                        <div class=" col-xs-12 col-sm-12 col-md-12" style="height: 50px;">
                            <div class="col-sm-2" style="white-space: nowrap">
                                <input id="CallerIDNumber" name="searchFilter" value="CallerIDNumberCheck" type="radio">&nbsp;
                                <label class="control-label" for="CallerIDNumber"><?php echo Yii::t('admin/cdr', 'CallerID Number');?></label>
                            </div>
                            <div class="row col-xs-2 col-sm-2 col-md-2">
                                <div class="input-group col-sm-12" style="white-space: nowrap">
                                    <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                    <input class="form-control" value="" type="text" id="clidnumber" name="clidnumber">
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 70px;height: 50px;">
                                <div class="input-group input-sm">
                                    <label><?php echo Yii::t('admin/cdr', 'Not:')?></label>
                                    <input class="input-sm" name="cnum_neg" value="true" type="checkbox">
                                </div>
                            </div>
                            <div class=" col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 100px;height: 50px;">
                                <div class="input-group input-sm">
                                    <label><?php echo Yii::t('admin/cdr', 'Begins With:')?></label>
                                    <input class="input-sm" checked="checked" name="cnum_mod" value="begins_with" type="radio">
                                </div>&nbsp;&nbsp;
                            </div>
                            <div class=" col-xs-1 col-sm-1 col-md-1" style="width: 100px">
                                <div class="input-group input-sm" style="white-space: nowrap;width: 100px;height: 50px;">
                                    <label><?php echo Yii::t('admin/cdr', 'Contains:')?></label>
                                    <input class="input-sm" name="cnum_mod" value="contains" type="radio">
                                </div>
                            </div>
                            <div class=" col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 100px;height: 50px;">
                                <div class="input-group input-sm">
                                    <label><?php echo Yii::t('admin/cdr', 'Ends With:')?></label>
                                    <input class="input-sm" name="cnum_mod" value="ends_with" type="radio">
                                </div>&nbsp;&nbsp;
                            </div>
                            <div class=" col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 120px;height: 50px;">
                                <div class="input-group input-sm">
                                    <label><?php echo Yii::t('admin/cdr', 'Exactly:')?></label>
                                    <input class="input-sm" name="cnum_mod" value="exact" type="radio">
                                </div>&nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class=" col-xs-12 col-sm-12 col-md-12" style="height: 50px;">
                            <div class="col-sm-2">
                                <input id="CallerIdName" name="searchFilter" value="CallerIdNameCheck" type="radio">&nbsp;
                                <label class="control-label" for="CallerIdName"><?php echo Yii::t('admin/cdr', 'CallerID Name');?></label>
                            </div>
                            <div class="row col-xs-2 col-sm-2 col-md-2">
                                <div class="input-group col-sm-12" style="white-space: nowrap">
                                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                                    <input class="form-control" value="" type="text" id="clidname" name="clidname">
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 70px;height: 50px;">
                                <div class="input-group input-sm">
                                    <label><?php echo Yii::t('admin/cdr', 'Not:')?></label>
                                    <input class="input-sm" name="cnam_neg" value="true" type="checkbox">
                                </div>
                            </div>
                            <div class=" col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 100px;height: 50px;">
                                <div class="input-group input-sm">
                                    <label><?php echo Yii::t('admin/cdr', 'Begins With:')?></label>
                                    <input class="input-sm" checked="checked" name="cnam_mod" value="begins_with" type="radio">
                                </div>&nbsp;&nbsp;
                            </div>
                            <div class=" col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 100px;height: 50px;">
                                <div class="input-group input-sm">
                                    <label><?php echo Yii::t('admin/cdr', 'Contains:')?></label>
                                    <input class="input-sm" name="cnam_mod" value="contains" type="radio">
                                </div>&nbsp;&nbsp;
                            </div>
                            <div class=" col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 100px;height: 50px;">
                                <div class="input-group input-sm">
                                    <label><?php echo Yii::t('admin/cdr', 'Ends With:')?></label>
                                    <input class="input-sm" name="cnam_mod" value="ends_with" type="radio">
                                </div>&nbsp;&nbsp;
                            </div>
                            <div class=" col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 120px;height: 50px;">
                                <div class="input-group input-sm">
                                    <label><?php echo Yii::t('admin/cdr', 'Exactly:')?></label>
                                    <input class="input-sm" name="cnam_mod" value="exact" type="radio">
                                </div>&nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class=" col-xs-12 col-sm-12 col-md-12" style="height: 50px;">
                            <div class="col-sm-2">
                                <input id="destination" name="searchFilter" value="DestinationCheck" type="radio">&nbsp;
                                <label class="control-label" for="destination"><?php echo Yii::t('admin/cdr', 'Destination');?></label>
                            </div>
                            <div class="row col-xs-2 col-sm-2 col-md-2">
                                <div class="input-group col-sm-12" style="white-space: nowrap">
                                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                                    <input class="form-control" value="" type="text" id="destin" name="destin">
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 70px;height: 50px;">
                                <div class="input-group input-sm">
                                    <label><?php echo Yii::t('admin/cdr', 'Not:')?></label>
                                    <input class="input-sm" name="dst_neg" value="true" type="checkbox">
                                </div>
                            </div>
                            <div class=" col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 100px;height: 50px;">
                                <div class="input-group input-sm">
                                    <label><?php echo Yii::t('admin/cdr', 'Begins With:')?></label>
                                    <input class="input-sm" checked="checked" name="dst_mod" value="begins_with" type="radio">
                                </div>&nbsp;&nbsp;
                            </div>
                            <div class=" col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 100px;height: 50px;">
                                <div class="input-group input-sm" style="white-space: nowrap;width: 120px;height: 50px;">
                                    <label><?php echo Yii::t('admin/cdr', 'Contains:')?></label>
                                    <input class="input-sm" name="dst_mod" value="contains" type="radio">
                                </div>&nbsp;&nbsp;
                            </div>
                            <div class=" col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 100px;height: 50px;">
                                <div class="input-group input-sm">
                                    <label><?php echo Yii::t('admin/cdr', 'Ends With:')?></label>
                                    <input class="input-sm" name="dst_mod" value="ends_with" type="radio">
                                </div>&nbsp;&nbsp;
                            </div>
                            <div class=" col-xs-1 col-sm-1 col-md-1" style="white-space: nowrap;width: 120px;height: 50px;">
                                <div class="input-group input-sm">
                                    <label><?php echo Yii::t('admin/cdr', 'Exactly:')?></label>
                                    <input class="input-sm" name="dst_mod" value="exact" type="radio">
                                </div>&nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class=" col-xs-12 col-sm-12 col-md-12">
                            <div class="col-sm-2">
                                <input id="duration" name="searchFilter" value="durationCheck" type="radio">&nbsp;
                                <label class="control-label" for="duration"><?php echo Yii::t('admin/cdr', ' Duration');?></label>
                            </div>
                            <div class="row col-xs-1 col-sm-1 col-md-1">
                                <label><?php echo Yii::t('admin/cdr', 'Between');?></label>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    <input class="form-control" id="between" name="between" value="" type="text" >
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1">
                                <label><?php echo Yii::t('admin/cdr', 'And');?></label>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    <input class="form-control" id="betweenand" name="betweenand" value="" type="text" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class=" col-xs-12 col-sm-12 col-md-12">
                            <div class="col-sm-2">
                                <input id="dispositionRadio" name="searchFilter" value="dispositionCheck" type="radio">&nbsp;
                                <label class="control-label" for="duration"><?php echo Yii::t('admin/cdr', ' Disposition');?></label>
                            </div>
                            <div class="row col-xs-4 col-sm-4 col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    <select class="form-control" id="disposition" name="disposition">
                                        <option value=""><?php echo Yii::t('admin/cdr', ' Choose disposition');?></option>
                                        <option value="ANSWERED"><?php echo Yii::t('admin/cdr', ' Answered');?></option>
                                        <option value="NO ANSWER"><?php echo Yii::t('admin/cdr', ' NO Answer ');?></option>
                                        <option value="BUSY"><?php echo Yii::t('admin/cdr', ' Busy');?></option>
                                    </select>
                                </div>
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
<table class="hover display" id="resultCDR" data-page-length='25' style="display:none;">
    <thead>
    <tr>
        <th data-sortable="true" data-field="timestart">Call Date</th>
        <th data-sortable="true" data-field="cid_from">CallerID</th>
        <th data-sortable="true" data-field="cid_to">Outbound CallerID</th>
        <th data-sortable="true" data-field="durationhhmmss">Duration</th>
        <th data-sortable="true" data-field="recordlocation">File</th>
    </tr>
    </thead>
</table>