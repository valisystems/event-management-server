<?php

class LiveRequestController extends Controller
{
	public function init(){
        parent::init();
    }
    public function actionIndex()
	{
		//$this->render('index');
	}
    
    public function actionGetLastNotification($idBuilding, $idMap){
        /*
        SELECT nl.code, nl.type_notification, nl.receiver, nl.message_sent, nl.current_time, nl.response_message,
        nl.status_of_notification, nl.live_panel, nl.require_acknowledge, nl.auto_close, nl.flashing_toggle, nl.auto_close_duration, d.device_description, d.device_type, d.comon_area, d.id_device,
        p.first_name, p.last_name, p.avatar_path, p.afliction, ei.id_asterisk, ei.ext_number, ct.color_hex, r.nb_room
        FROM mia_notification_log nl 
        INNER JOIN mia_devices d ON nl.serial_number = d.serial_number
        INNER JOIN mia_calls_type ct ON ct.script = nl.code
        LEFT JOIN mia_room_device_patient rdp ON d.id_device = rdp.id_device
        LEFT JOIN mia_patients p ON p.id_patient = rdp.id_patient
        LEFT JOIN mia_rooms r ON d.id_room = r.id_room
        INNER JOIN mia_extension_info ei ON ei.id_device = d.id_device
        WHERE  d.id_building = 1 AND d.id_map = 1 AND nl.current_time > DATE_SUB(NOW(), INTERVAL 1 WEEK)
        */
        if (Yii::app()->request->isAjaxRequest) {
            if ($idBuilding > 0 && $idMap > 0) {
                $connection=Yii::app()->db;
                $cmd = $connection->createCommand();
                $row = $cmd->select('nl.id_log, nl.code, nl.type_notification, nl.receiver, nl.message_sent, nl.current_time, nl.response_message,
                                    nl.status_of_notification, nl.live_panel, nl.require_acknowledge, nl.auto_close, nl.flashing_toggle, nl.auto_close_duration, d.position_popup, d.device_description, d.device_type, d.comon_area, d.id_device,
                                    p.id_patient, p.first_name, p.last_name, p.avatar_path, p.afliction, ei.id_asterisk, ei.ext_number, r.coordinate_on_map, ct.color_hex, r.nb_room, d.coordonate_on_map as dev_coordonate, mid.io_name, nl.command')
                    ->from('{{notification_log}} nl')
                    ->join('{{devices}} d', 'nl.serial_number = d.serial_number')
                    ->join('{{calls_type}} ct', 'ct.script = nl.code')
                    ->leftJoin('{{room_device_patient}} rdp', 'd.id_device = rdp.id_device')
                    ->leftJoin('{{rooms}} r', 'd.id_room = r.id_room')
                    ->leftJoin('{{patients}} p', 'p.id_patient = rdp.id_patient')
                    ->join('{{extension_info}} ei', 'ei.id_device = d.id_device')
                    ->leftJoin('{{mipositioning_input_device}} mid', 'mid.io_id = nl.id_iodevice')
                    ->where('d.id_building = :id_building AND d.id_map = :id_map AND nl.current_time > DATE_SUB(NOW(), INTERVAL  5 year)', array(':id_building'=>$idBuilding, ':id_map'=>$idMap))
                    ->queryAll();
                header('Content-Type: application/json');
                echo json_encode($row);
            } else {
                
            }
        } 
    }

    public function actionGetLastNotificationPositioning(){
        if(isset($_POST['listDevice']) && count($_POST['listDevice']) > 0){
            $listDevPosId = "";
            foreach ($_POST['listDevice'] as $k) {
                $listDevPosId .= $k.",";
            }

            if ($listDevPosId != "") {
                $listDevPosId = '0,'.substr($listDevPosId, 0, -1);

                $connection=Yii::app()->db;
                $cmd = $connection->createCommand();
                $row = $cmd->select('nl.id_log, nl.EventType, nl.type_notification, nl.receiver, nl.message_sent, nl.current_time, nl.response_message,
                  nl.status_of_notification, nl.live_panel, nl.require_acknowledge, nl.auto_close, nl.flashing_toggle, nl.auto_close_duration, d.position_popup, nl.device_description, d.id_device,
                  p.id_patient, p.first_name, p.last_name, p.avatar_path, p.afliction, r.coordinate_on_map, pt.color_hex, r.nb_room, d.coordonate_on_map as dev_coordonate, mid.io_name, nl.command')
                ->from('{{notification_pendant_log}} nl')
                ->join('{{devices}} d', 'nl.BaseName = d.serial_number')
                ->join('{{pendant_devices}} pd', 'pd.serial_number = nl.serial_number')
                ->join('{{pendant_type}} pt', 'pt.script = nl.EventType')
                ->leftJoin('{{residents_of_rooms}} rr', 'pd.id_patient = rr.id_patient')
                ->leftJoin('{{patients}} p', 'p.id_patient = pd.id_patient')
                ->leftJoin('{{rooms}} r', 'r.id_room = rr.id_room')
                ->leftJoin('{{mipositioning_input_device}} mid', 'mid.io_id = nl.id_iodevice')
                ->where('d.id_device IN ('.$listDevPosId.') AND nl.current_time > DATE_SUB(NOW(), INTERVAL  5 year)')
                ->queryAll();

                header('Content-Type: application/json');
                echo json_encode($row);
            }
        }
    }

    public function actionGetLastNotificationMaxiVox(){
        if(isset($_POST['listDevice']) && count($_POST['listDevice']) > 0){
            $listDevPosId = "";
            foreach ($_POST['listDevice'] as $k) {
                $listDevPosId .= $k.",";
            }

            if ($listDevPosId != "") {
                $listDevPosId = '0,'.substr($listDevPosId, 0, -1);

                $connection=Yii::app()->db;
                $cmd = $connection->createCommand();
                $row = $cmd->select('nl.id_log, nl.DeviceType, nl.maxivox_address, nl.DeviceLabel, nl.type_notification, nl.receiver, nl.message_sent, nl.current_time, nl.response_message,
                  nl.status_of_notification, nl.live_panel, nl.require_acknowledge, nl.auto_close, nl.flashing_toggle, nl.auto_close_duration, d.position_popup, nl.device_description, d.id_maxivox_device,
                  p.id_patient, p.first_name, p.last_name, p.avatar_path, p.afliction, r.coordinate_on_map, pt.color_hex, r.nb_room, d.coordonate_on_map as dev_coordonate, mid.io_name, nl.command')
                    ->from('{{notification_maxivox_log}} nl')
                    ->join('{{maxivox_device}} d', 'nl.maxivox_address = d.dev_address')
                    ->join('{{maxivox_type}} pt', 'pt.script = nl.DeviceLabel')
                    ->leftJoin('{{patients}} p', 'p.id_patient = d.id_patient')
                    ->leftJoin('{{rooms}} r', 'r.id_room = d.id_room')
                    ->leftJoin('{{mipositioning_input_device}} mid', 'mid.io_id = nl.id_iodevice')
                    ->where('d.id_maxivox_device IN ('.$listDevPosId.') AND nl.current_time > DATE_SUB(NOW(), INTERVAL  5 year)')
                    ->queryAll();

                header('Content-Type: application/json');
                echo json_encode($row);
            }
        }
    }

    public function actionGetImgUrl($idCamera){
        if (Yii::app()->request->isAjaxRequest) {
            $systemCamera = SystemCameras::model()->findByPk($idCamera);
            if (isset($systemCamera->url_camera) && !empty($systemCamera->url_camera)) {
                echo $systemCamera->url_camera;
            }
            else {
                echo "";
            }
        }
    }
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
    
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}