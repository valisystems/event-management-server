<?php

class Device {
	
	public $host;
	public $database_name;
	public $username;
	public $password;
	public $conn;
	
	public function __construct()
	{
		$this->host = 'localhost';
		$this->database_name = 'miniprtg';
		$this->username = 'admin';
		$this->password = 'claricom';
		
		try
		{
			$dsn = "mysql:host=" . $this->host . ";dbname=" . $this->database_name;
			$this->conn = new PDO($dsn, $this->username, $this->password);
		}
		catch(PDOException $e)
		{
			exit("Connect failed: " . $e->getMessage() );
		}
	}
	
	public function create($data)
	{
		$statement = $this->conn->prepare("
                                INSERT INTO `device_status` (BaseName, DeviceType, AntennaInt, EventType, DeviceID, PendantRxLevel, LowBattery, TimeStamp) 
                                VALUES (:BaseName, :DeviceType, :AntennaInt, :EventType, :DeviceID, :PendantRxLevel, :LowBattery, :TimeStamp )
                            ");
		try
		{
			$statement->execute($data);
			$this->generateQueryFile('C:/Program Files (x86)/PRTG Network Monitor/Custom Sensors/sql/mysql', $data['DeviceID']);
			return $data['DeviceID'];
		}
		catch(PDOException $e)
		{
			exit("Failed to insert row: " . $e->getMessage() );
		}
	}
	
	public function update($data)
	{
		$statement = $this->conn->prepare("
                                UPDATE `device_status` 
								SET BaseName  = :BaseName, DeviceType  = :DeviceType, AntennaInt = :AntennaInt, 
								   `EventType` = :EventType, PendantRxLevel = :PendantRxLevel, LowBattery = :LowBattery, `TimeStamp` = :TimeStamp
								WHERE DeviceID = :DeviceID
							");
		try
		{
			$statement->execute($data);
			return $data['DeviceID'];
		}
		catch(PDOException $e)
		{
			exit("Failed to insert row: " . $e->getMessage() );
		}
	}
	
	public function getList()
	{
		$stmt = $this->conn->prepare('SELECT * FROM device_status;');
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if($rows)
		{
			return $rows;
		}
		return false;
	}
	
	public function getDeviceByDeviceId($device_id)
	{
		$stmt = $this->conn->prepare('SELECT * FROM device_status WHERE DeviceID = :device_id;');
		$stmt->bindParam(':device_id', $device_id);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!$row)
		{
			return false;
		}
		echo $this->editForm($row);
	}
	
	public function deleteByDeviceId($device_id)
	{
		$stmt = $this->conn->prepare('DELETE FROM device_status WHERE DeviceID = :device_id;');
		$stmt->bindParam(':device_id', $device_id);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
		$path = 'C:/Program Files (x86)/PRTG Network Monitor/Custom Sensors/sql/mysql/single_device_' . $device_id . '.sql';
		@unlink($path);
		
		if(!$row)
		{
			return false;
		}
		return $row;
	}
	
	
	public function createForm()
	{
		$output ='
			<form id="formoid" action="classes/ajax.php"  method="POST">
				<input type="hidden" id="action" name="action" value="create"/>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label" >BaseName</label>
								<input type="text" id="BaseName" class="form-control" value="miPos_630114" name="BaseName" />
							</div>
							<div class="col-sm-5">
								<label class="title control-label">DeviceID</label>
								<input type="text" id="DeviceID" class="form-control"  value="AB00189" name="DeviceID" />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label">DeviceType</label>
								<input type="text" id="DeviceType" class="form-control" value="pull" name="DeviceType" />
							</div>
							<div class="col-sm-5">
								<label class="title control-label">EventType</label>
								<input type="text" id="EventType" class="form-control" value="Alarm" name="EventType" >
							</div>
						</div>
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label">LowBattery</label>
								<input type="text" id="LowBattery" class="form-control" value="false" name="LowBattery" >
							</div>
							<div class="col-sm-5">
								<label class="title control-label">TimeStamp</label>
								<input type="text" id="TimeStamp" class="form-control" value="2016031113053" name="TimeStamp" >
							</div>
						</div>
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label">AntennaInt</label>
								<input type="text" id="AntennaInt" class="form-control" value="0" name="AntennaInt" >
							</div>
							<div class="col-sm-5">
								<label class="title control-label">PendantRxLevel</label>
								<input type="text" id="PendantRxLevel" class="form-control" value="0" name="PendantRxLevel" >
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<input type="submit" id="submitButton" class="btn btn-primary"  name="submitButton" value="Submit">
					</div>
			 </form>
		';
		
		return $output;
	}
	
	public function editForm($data)
	{
		$output ='
			<form id="formoid2" action="classes/ajax.php"  method="POST">
				<input type="hidden" id="action2" name="action" value="update"/>
				<input type="hidden" id="DeviceID2" name="DeviceID" value=' . $data["DeviceID"] . ' />
					<div class="form-group">
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label" >BaseName</label>
								<input type="text" id="BaseName2" class="form-control" value=' . $data["BaseName"] . ' name="BaseName" />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label">DeviceType</label>
								<input type="text" id="DeviceType2" class="form-control" name="DeviceType" value=' .   $data["DeviceType"] . ' />
							</div>
							<div class="col-sm-5">
								<label class="title control-label">EventType</label>
								<input type="text" id="EventType2" class="form-control" name="EventType" value=' .   $data["EventType"] . ' />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label">LowBattery</label>
								<input type="text" id="LowBattery2" class="form-control"  name="LowBattery" value=' . $data["LowBattery"]. ' />
							</div>
							<div class="col-sm-5">
								<label class="title control-label">TimeStamp</label>
								<input type="text" id="TimeStamp2" class="form-control"  name="TimeStamp" value=' .   $data["TimeStamp"] . ' />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-5">
								<label class="title control-label">AntennaInt</label>
								<input type="text" id="AntennaInt2" class="form-control" name="AntennaInt" value=' .   $data["AntennaInt"] . ' />
							</div>
							<div class="col-sm-5">
								<label class="title control-label">PendantRxLevel</label>
								<input type="text" id="PendantRxLevel2" class="form-control" name="PendantRxLevel" value=' .   $data["PendantRxLevel"] . ' />
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<input type="submit" id="submitButton2" class="btn btn-primary"  name="submitButton" value="Submit">
					</div>
			 </form>
		';
		
		return $output;
	}
	
	
	// create mysql sensor query file to use in prtg
	public function generateQueryFile($path, $device_id = null)
	{
		chmod($path, 0755);
		$customSensorPath = $path . '/single_device_' . $device_id . '.sql';
		$handle = fopen($customSensorPath, 'a') or die('Cannot open file:  '.$customSensorPath);
		$data = 'SELECT DeviceID,
				CASE
					WHEN EventType = "CancelAlarm" THEN 0
					WHEN EventType = "Alarm" THEN 1
					ELSE 0
				END as EventType
			FROM
				device_status 
			WHERE
				DeviceID = "' .$device_id . '";';
		@fwrite($handle, $data);
		fclose($handle);
	}
	
	
}

