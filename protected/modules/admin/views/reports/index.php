<?php
/* @var $this ReportsController */

$this->breadcrumbs=array(
	'Reports',
);
?>
<div class="box">
	<div class="box-header">
		<h2><i class="fa fa-bar-chart-o"></i> Code Reports</h2>
        <ul class="nav nav-tabs">
          <li class="active" id="code1"><a href="#" onclick="javascript:getCodeGraph(1)">Today</a></li>
          <li id="code7"><a href="#" onclick="javascript:getCodeGraph(7)">Last 7 days</a></li>
          <li id="code30"><a href="#" onclick="javascript:getCodeGraph(30)">Last Month</a></li>
        </ul>

	</div>
	<div class="box-content" id="chartContent">
		
	</div>
</div>
<br/>
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