<?php
include('device.php');
$deviceObj = new Device();
if(file_get_contents('php://input'))
{
	
	//{"BaseName":"miPos_630114", "DeviceType":"pull", "AntennaInt":"0", "EventType":"alarm", "DeviceID":"AB00189", "PendantRxLevel": "0", "LowBattery":"false", "TimeStamp":"20160311130539"}
	$data = json_decode(file_get_contents('php://input'), true);	
	if($data['action'] === 'create')
	{
		unset($data['action']);
		$deviceObj->create($data);
	}
	elseif($data['action'] === 'update')
	{
		unset($data['action']);
		$deviceObj->update($data);
	}
	elseif($data['action'] === 'delete')
	{
		unset($data['action']);
		$deviceObj->deleteByDeviceId($data['DeviceID']);
	}
}

if(!empty($_GET['device_id']))
{
	$deviceObj->getDeviceByDeviceId($_GET['device_id']);
}