<?php
/* @var $this DefaultController */
?>
<div id='ajax_loader' style="display: none;" class="ui-widget-overlay">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; z-index:3000000"/>
</div>
<div>
    <table class="table table-condensed">
        <tr>
            <td style="width: 200px;">
                <?php echo Yii::t('admin/index', 'Room Total');?>
            </td>
            <td style="width: 100px;">
                <span class="badge badge-info" id="roomNumber">0</span>
            </td>
            <td>&nbsp;</td>
            <td style="width: 200px;">
                <?php echo Yii::t('admin/index', 'Missed Calls');?>
            </td>
            <td style="width: 100px;">
                <span class="badge badge-info" id="missedCall">0</span>
            </td>
            <td>&nbsp;</td>
            <td style="width: 200px;">
                <?php echo Yii::t('admin/index', 'SMS Events');?>
            </td>
            <td style="width: 100px;">
                <span class="badge badge-info" id="smsEvents">0</span>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::t('admin/index', 'Patients');?>            
            </td>
            <td>
                <span class="badge badge-info" id="patientsNb">0</span>
            </td>
            <td>&nbsp;</td>
            <td>
                <?php echo Yii::t('admin/index', 'Positioning Events');?>
            </td>
            <td>
                <span class="badge badge-info" id="positioningEvent">0</span>
            </td>
            <td>&nbsp;</td>
            <td>
                <?php echo Yii::t('admin/index', 'Voice Events');?>
            </td>
            <td>
                <span class="badge badge-info" id="voiceEvents">0</span>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::t('admin/index', 'Calls this month');?>
            </td>
            <td>
                <span class="badge badge-info" id="totalCallThisMonth">0</span>
            </td>
            <td>&nbsp;</td>
            <td>
                <?php echo Yii::t('admin/index', 'Transfer Events');?>
            </td>
            <td>
                <span class="badge badge-info" id="responseCall">0</span>
            </td>
            <td>&nbsp;</td>
            <td>
                <?php echo Yii::t('admin/index', 'Email Events');?>
            </td>
            <td>
                <span class="badge badge-info" id="emailEvents">0</span>
            </td>
        </tr>
    </table>
</div>

<div class="clearfix"></div>
<br />
<div class="box">
    <div class="box-header">
        <h2><i class="fa fa-bar-chart-o"></i> Notification Reports</h2>
        <ul class="nav nav-tabs">
            <li class="active" id="not1"><a href="#" onclick="javascript:getNotificationGraph(1)">Today</a></li>
            <li id="not7"><a href="#" onclick="javascript:getNotificationGraph(7)">Last 7 days</a></li>
            <li id="not30"><a href="#" onclick="javascript:getNotificationGraph(30)">Last Month</a></li>
        </ul>

    </div>
    <div class="box-content" id="chartContentNotif">

    </div>
</div>
<div class="clearfix"></div>
<br />
<!--div class="row">
    <div class="box">
    	<div class="box-header">
    		<h2><i class="fa fa-bar-chart-o"></i> <?php echo Yii::t('admin/index', 'Calls (answered, busy, no answered)')?></h2>
            <ul class="nav nav-tabs">
              <li class="active" id='liToday'><a href="#" onclick="javascript:timeDataCallActivity(1)"><?php echo Yii::t('admin/index', 'Today')?></a></li>
              <li id='liWeek'><a href="#" onclick="javascript:timeDataCallActivity(7)"><?php echo Yii::t('admin/index', 'Week')?></a></li>
              <li id='liMonth'><a href="#" onclick="javascript:timeDataCallActivity(30)"><?php echo Yii::t('admin/index', 'Month')?></a></li>
            </ul>
    
    	</div>
    	<div class="box-content" id="chartContent">
    		
    	</div>
    </div>
</div-->
<div class="clearfix"></div>
<br />

<!--div class="row">
    <div class="box">
    	<div class="box-header">
    		<h2><i class="fa fa-bar-chart-o"></i> <?php echo Yii::t('admin/index', 'Response activity')?></h2>
            <ul class="nav nav-tabs">
              <li class="active" id='liResponseToday'><a href="#" onclick="javascript:timeDataResponseActivity(1)"><?php echo Yii::t('admin/index', 'Today')?></a></li>
              <li id='liResponseWeek'><a href="#" onclick="javascript:timeDataResponseActivity(7)"><?php echo Yii::t('admin/index', 'Week')?></a></li>
              <li id='liResponseMonth'><a href="#" onclick="javascript:timeDataResponseActivity(30)"><?php echo Yii::t('admin/index', 'Month')?></a></li>
            </ul>
    
    	</div>
    	<div class="box-content" id="chartResponseContent">
    		
    	</div>
    </div>
</div-->