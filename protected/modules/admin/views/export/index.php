<?php
/* @var $this ExportController */
/* @var $form CActiveForm */
$this->breadcrumbs=array(
	'Export'=>array('index'),
);
?>
<div class="box">
	<div class="box-header">
		<h2><i class="fa fa-floppy-o"></i> Export</h2>
        <ul class="nav nav-tabs">
          <li class="active"><a href="#" onclick="javascript:void(0)">Devices</a></li>
          <li><a href="#" onclick="javascript:void(0)">Patients</a></li>
        </ul>

	</div>
	<div class="box-content">
		<div class="row col-xs-12 col-sm-12 col-md-12" id="searchForm">
			<div class="input-group col-sm-4">
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				<input class="form-control" id="daterange" value="09/09/2013 - 09/28/2013" type="text">
			</div>
        </div>
        <div class="row" id="exportContent"></div>
	</div>
</div>