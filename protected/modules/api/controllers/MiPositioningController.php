<?php
/**
 * User: iurik
 * Date: 5/26/15
 * Time: 21:50
 */

class MiPositioningController extends Controller
{
    public $autorizatedIP = array();
    public $discovered = false;
    public $def_building = 0;
    public $def_map = 0;
    public function init()
    {
        $criteria=new CDbCriteria;
        //$criteria->compare('id_map',$id);
        $criteria->addCondition('device_classification = :device_classification');
        $criteria->addCondition('ip_address <> ""');
        $criteria->params = array(':device_classification'=>'mipositioning');

        $this->autorizatedIP = array_values(CHtml::listData(Devices::model()->findAll($criteria),'ip_address', "ip_address"));
        Yii::import('application.modules.admin.models.Setting');

        $settings = Setting::model()->find(array('order'=>'id_settings ASC', 'limit'=>1));
        //Yii::log(CVarDumper::dumpAsString(print_r($settings, true), 10),'error','app');
        if (count($settings)) {
            $this->discovered = ($settings->discovery == '1') ? true : false;
            $this->def_building = $settings->default_building;
            $this->def_map = $settings->default_map;
        }
    }

    public function actionIndex()
    {
        // curl -X POST -d '{"BaseName":"2105M6987","DeviceType":"pendant", "AntennaInt":"2", "EventType":"peble", "DeviceID":"AEFrr45", "PendantRxLevel": "7", "LowBattery":"false", "TimeStamp":"20150303163711"}' http://192.168.1.156/api/miPositioning
        // curl -X POST -d '{"BaseName":"ALBUTEST123","DeviceType":"pendant", "AntennaInt":"2", "EventType":"peble", "DeviceID":"AEFrr45", "PendantRxLevel": "7", "LowBattery":"false", "TimeStamp":"20150303163711"}' http://192.168.1.71/api/miPositioning
        // curl -X POST -d '{"BaseName":"ALBUTEST123","DeviceType":"pendant", "AntennaInt":"2", "EventType":"miDOM", "DeviceID":"AEFrr48", "PendantRxLevel": "7", "LowBattery":"false", "TimeStamp":"20150303163711"}' http://mialert.teleportvideo.com/api/miPositioning
        // curl -X POST -d '{"BaseName":"ALBUTEST12345","DeviceType":"pendant_test", "AntennaInt":"2", "EventType":"miDOM", "DeviceID":"AEFrr48092", "PendantRxLevel": "7", "LowBattery":"false", "TimeStamp":"20150303163711"}' http://mialert.teleportvideo.com/api/miPositioning
        // curl -X POST -d '{"BaseName":"ALBUTEST123456","DeviceType":"pendant_test3", "AntennaInt":"2", "EventType":"miDOM", "DeviceID":"AEFrr480923", "PendantRxLevel": "7", "LowBattery":"false", "TimeStamp":"20150303163711"}' http://mialert.teleportvideo.com/api/miPositioning
        // curl -X POST -d '{"BaseName":"2105M6986","DeviceType":"pendant", "AntennaInt":"2", "EventType":"miDOM", "DeviceID":"AEFrr48", "PendantRxLevel": "7", "LowBattery":"false", "TimeStamp":"20150303163711"}' http://mialert.teleportvideo.com/api/miPositioning
        // curl -X POST -d '{"BaseName":"2105M6986ALBU","DeviceType":"pendant", "AntennaInt":"2", "EventType":"miDOM", "DeviceID":"AEFrr48", "PendantRxLevel": "7", "LowBattery":"false", "TimeStamp":"20150303163711"}' http://mialert.teleportvideo.com/api/miPositioning




        if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && (in_array($_SERVER['REMOTE_ADDR'], $this->autorizatedIP) || $this->discovered)) {

            $arr = json_decode(file_get_contents("php://input"), 1);
            //Yii::log(CVarDumper::dumpAsString(print_r($arr, true), 10),'error','app');


            $BaseName = $arr['BaseName'];
            $DeviceType = $arr['DeviceType'];
            $AntennaInt = $arr['AntennaInt'];
            $EventType = $arr['EventType'];
            $DeviceID = $arr['DeviceID'];
            $PendantRxLevel = $arr['PendantRxLevel'];
            $LowBattery = $arr['LowBattery'];
            $TimeStamp = $arr['TimeStamp'];

            if ($this->discovered){
                Yii::import('application.modules.admin.models.Positioning');
                Yii::import('application.modules.admin.models.PendantDevices');
                Yii::import('application.modules.admin.models.PendantType');
                $count = Positioning::model()->count('serial_number = :baseName', array(':baseName'=>$BaseName));
                if ($count == 0){
                    $dev = new Positioning;
                    $dev->id_building = $this->def_building;
                    $dev->id_map = $this->def_map;
                    $dev->serial_number = $BaseName;
                    $dev->device_classification = 'mipositioning';
                    $dev->comon_area = 1;
                    $dev->ip_address = $_SERVER['REMOTE_ADDR'];
                    $dev->device_description = 'Discovered #'.$BaseName;

                    if ($dev->save()){
                        echo "added";
                    } else {
                        echo $dev->getErrors();
                    }
                } else {
                    echo "Exist";
                }
                $countPendantDevice = PendantDevices::model()->count('serial_number = :baseName', array(':baseName'=>$DeviceID));
                $countPendantType = PendantType::model()->count('script = :type', array(':type'=>$DeviceType));
                $id_pendant_type = -1;
                if ($countPendantType == 0) {
                    $pendType = new PendantType;
                    $pendType->description = 'Descovered #'.$DeviceType;
                    $pendType->script = $DeviceType;
                    $pendType->priority = '6';
                    $pendType->color_hex = '#FF0000';

                    $pendType->save();
                    $id_pendant_type = $pendType->id_pendant_type;
                } else {
                    //Yii::log(CVarDumper::dumpAsString($DeviceID, 10),'error','app');
                    $tmpPendantType = PendantDevices::model()->findByAttributes(array('serial_number'=>$DeviceID));
                    $id_pendant_type = $tmpPendantType->id_pendant_type;
                }
                if ($countPendantDevice == 0) {
                    $pendantDevice = new PendantDevices;
                    $pendantDevice->description = 'Discovered #'.$DeviceID;
                    $pendantDevice->serial_number = $DeviceID;
                    $pendantDevice->id_pendant_type = $id_pendant_type;
                    $pendantDevice->save();
                }
            }
            $jsonResponse = array();

            $connection=Yii::app()->db;
            $cmd = $connection->createCommand();
            $row = $cmd->select('pd.*, b.name as building_name, m.name_map, r.nb_room, r.id_room')
                ->from('{{pendant_devices}} pd')
                ->join('{{residents_of_rooms}} rr','pd.id_patient = rr.id_patient')
                ->join('{{patients}} pa','pa.id_patient = pd.id_patient')
                ->join('{{rooms}} r','r.id_room = rr.id_room')
                ->join('{{maps}} m','m.id_map = r.id_map')
                ->join('{{buildings}} b','b.id_building = r.id_building')
                ->where('serial_number=:serial_number', array(':serial_number'=>$DeviceID))->limit('1')->queryRow();

            $cmd->reset();

            if (isset($row['id_pendant_device']) && !empty($row['id_pendant_device'])) {
                $id_device = $row['id_pendant_device'];

                $callInfo = $cmd->select('epm.*, pt.script, pt.priority, pt.description, pt.color_hex')
                    ->from('{{events_pendant_manage}} epm')
                    ->join('{{pendant_type}} pt', 'epm.id_pendant_type = pt.id_pendant_type')
                    ->where( 'epm.id_device = :id_device', array(':id_device' => $id_device))
                    ->queryAll();
                $cmd->reset();
                $emailEvent = $smsEvent = $voipEvent = $emailEventCustom = $smsEventCustom = $voipEventCustom = $transferEvent =  $transferEventCustom =  $cameraEvent = $ioEventCustom = $ioEvent = $httpEvent = $httpEventCustom = array();
                if (count($callInfo)) {
                    foreach($callInfo as $kCall) {
                        if ($kCall['event_type'] == 'custom') {
                            /*
                            SELECT concat(p.first_name, ' ',p.last_name) as patient_name, ec.name_contact, ec.mobile, ec.email, ec.sms, pe.pick_event_type, p.text_desc, p.email_desc, p.voice_desc, p.voice_message, p.text_message, p.email_message, mid.io_id, c.command, d.ip_address, c.id_command
                            FROM mia_pick_pendant_events pe
                            LEFT JOIN mia_emergency_contact ec ON pe.id_contact = ec.id_emergency_contact
                            LEFT JOIN mia_patients p ON p.id_patient = ec.id_patient
                            LEFT JOIN mia_mipositioning_input_device mid ON pe.id_iodevice = mid.id_input_device
                            LEFT JOIN mia_devices d ON d.id_device = mid.id_device
                            LEFT JOIN mia_command c ON c.id_command = pe.id_command
                            WHERE pe.id_event_pendant=
                            */

                            $eventInfo = $cmd->select("concat(p.first_name, ' ',p.last_name) as patient_name, ec.name_contact, ec.mobile, ec.email, ec.sms, pe.pick_event_type, p.text_desc, p.email_desc, p.voice_desc, p.voice_message, p.text_message, p.email_message, mid.io_id, c.command, d.ip_address, c.id_command, hi.*")
                                ->from('{{pick_pendant_events}} pe')
                                ->leftJoin('{{emergency_contact}} ec', 'pe.id_contact = ec.id_emergency_contact')
                                ->leftJoin('{{patients}} p', 'p.id_patient = ec.id_patient')
                                ->leftJoin('{{mipositioning_input_device}} mid', 'pe.id_iodevice = mid.id_input_device')
                                ->leftJoin('{{devices}} d', 'd.id_device = mid.id_device')
                                ->leftJoin('{{command}} c', 'c.id_command = pe.id_command')
                                ->leftJoin('{{http_inventory}} hi', 'pe.id_http_inventory = hi.id_http_inventory')
                                ->where('pe.id_event_pendant=:id_event', array(':id_event' => $kCall['id_event_pendant']))
                                ->queryAll();
                            if (count($eventInfo)){
                                foreach ($eventInfo as $lEvInfo){
                                    if($lEvInfo['pick_event_type'] == 'VOIP') {
                                        $voipEventCustom[] = array(
                                            'description' => $kCall['description'],
                                            'id_pendant_type' => $kCall['id_pendant_type'],
                                            'priority' => $kCall['priority'],
                                            'color_hex' => $kCall['color_hex'],
                                            'desc_global_event' => $lEvInfo['voice_desc'],
                                            'pick_event_type' => $lEvInfo['pick_event_type'],
                                            'name_contact' => $lEvInfo['name_contact'],
                                            'mobile' => $lEvInfo['mobile'],
                                            'global_text' => $lEvInfo['voice_message'],
                                            'patient_name' => $lEvInfo['patient_name'],
                                            'live_panel' => $kCall['live_panel'],
                                            'require_acknowledge' => $kCall['require_acknowledge'],
                                            'auto_close' => $kCall['auto_close'],
                                            'flashing_toggle' => $kCall['flashing_toggle'],
                                            'auto_close_duration' => ($kCall['auto_close_duration'] > 0) ? $kCall['auto_close_duration'] : 0,
                                            'position_popup' => $kCall['position_popup'],
                                        );
                                    }
                                    else if($lEvInfo['pick_event_type'] == 'EMAIL'){
                                        $emailEventCustom[] = array(
                                            'description' => $kCall['description'],
                                            'id_pendant_type' => $kCall['id_pendant_type'],
                                            'priority' => $kCall['priority'],
                                            'color_hex' => $kCall['color_hex'],
                                            'desc_global_event' => $lEvInfo['email_desc'],
                                            'pick_event_type' => $lEvInfo['pick_event_type'],
                                            'name_contact' => $lEvInfo['name_contact'],
                                            'email' => $lEvInfo['email'],
                                            'global_text' => $lEvInfo['email_message'],
                                            'patient_name' => $lEvInfo['patient_name'],
                                            'live_panel' => $kCall['live_panel'],
                                            'require_acknowledge' => $kCall['require_acknowledge'],
                                            'auto_close' => $kCall['auto_close'],
                                            'flashing_toggle' => $kCall['flashing_toggle'],
                                            'auto_close_duration' => ($kCall['auto_close_duration'] > 0) ? $kCall['auto_close_duration'] : 0,
                                            'position_popup' => $kCall['position_popup'],
                                        );

                                    } else if($lEvInfo['pick_event_type'] == 'SMS'){
                                        $smsEventCustom[] = array(
                                            'description' => $kCall['description'],
                                            'id_pendant_type' => $kCall['id_pendant_type'],
                                            'priority' => $kCall['priority'],
                                            'color_hex' => $kCall['color_hex'],
                                            'desc_global_event' => $lEvInfo['text_desc'],
                                            'pick_event_type' => $lEvInfo['pick_event_type'],
                                            'name_contact' => $lEvInfo['name_contact'],
                                            'sms' => $lEvInfo['sms'],
                                            'global_text' => $lEvInfo['text_message'],
                                            'patient_name' => $lEvInfo['patient_name'],
                                            'live_panel' => $kCall['live_panel'],
                                            'require_acknowledge' => $kCall['require_acknowledge'],
                                            'auto_close' => $kCall['auto_close'],
                                            'flashing_toggle' => $kCall['flashing_toggle'],
                                            'auto_close_duration' => ($kCall['auto_close_duration'] > 0) ? $kCall['auto_close_duration'] : 0,
                                            'position_popup' => $kCall['position_popup'],
                                        );
                                    } //End IF SMS
                                    else if($lEvInfo['pick_event_type'] == 'IOPOS'){
                                        $ioEventCustom[] = array(
                                            'description' => $kCall['description'],
                                            'id_pendant_type' => $kCall['id_pendant_type'],
                                            'priority' => $kCall['priority'],
                                            'color_hex' => $kCall['color_hex'],
                                            'desc_global_event' => $lEvInfo['text_desc'],
                                            'pick_event_type' => $lEvInfo['pick_event_type'],
                                            'name_contact' => $lEvInfo['name_contact'],
                                            'global_text' => $lEvInfo['text_message'],
                                            'live_panel' => $kCall['live_panel'],
                                            'io_id' => $lEvInfo['io_id'],
                                            'command' => $lEvInfo['command'],
                                            'ip_address' => $lEvInfo['ip_address'],
                                            'require_acknowledge' => $kCall['require_acknowledge'],
                                            'auto_close' => $kCall['auto_close'],
                                            'flashing_toggle' => $kCall['flashing_toggle'],
                                            'auto_close_duration' => ($kCall['auto_close_duration'] > 0) ? $kCall['auto_close_duration'] : 0,
                                            'position_popup' => $kCall['position_popup']
                                        );
                                    } //End IF SMS
                                    else if($lEvInfo['pick_event_type'] == 'HTTP'){
                                        $httpEventCustom[] = array(
                                            'description' => $kCall['description'],
                                            'id_pendant_type' => $kCall['id_pendant_type'],
                                            'priority' => $kCall['priority'],
                                            'color_hex' => $kCall['color_hex'],
                                            'desc_global_event' => $lEvInfo['text_desc'],
                                            'pick_event_type' => $lEvInfo['pick_event_type'],
                                            'name_contact' => $lEvInfo['name_contact'],
                                            'global_text' => $lEvInfo['text_message'],
                                            'live_panel' => $kCall['live_panel'],
                                            'id_http' => $lEvInfo['id_http_inventory'],
                                            'url' => $lEvInfo['action_url'],
                                            'command' => $lEvInfo['command'],
                                            'ip_address' => $lEvInfo['ip_address'],
                                            'require_acknowledge' => $kCall['require_acknowledge'],
                                            'auto_close' => $kCall['auto_close'],
                                            'flashing_toggle' => $kCall['flashing_toggle'],
                                            'auto_close_duration' => ($kCall['auto_close_duration'] > 0) ? $kCall['auto_close_duration'] : 0,
                                            'position_popup' => $kCall['position_popup']
                                        );
                                    } //End IF SMS
                                } // End Foreach
                            } //End IF Count Event Info
                            $cmd->reset();
                        }
                    } // End of foreach
                    if (count($smsEventCustom)) {
                        foreach ($smsEventCustom as $m => $l) {
                            $settingsModel = Settings::model()->find();
                            $smsUrl = $settingsModel->sms_url;
                            $smsDestinationName = $l['name_contact'];
                            if (count($smsDestinationName) && !empty($smsUrl)) {
                                /* 'desc_global_event' => $lEvInfo['text_desc'],
                                'pick_event_type' => $lEvInfo['pick_event_type'],
                                'name_contact' => $lEvInfo['name_contact'],
                                'sms' => $lEvInfo['sms'],
                                'global_text' => $lEvInfo['text_message'],
                                'patient_name' => $lEvInfo['patient_name']*/

                                $smsNumber = $l['sms'];

                                $smsMessage = str_replace('%%BUILDING%%', "", $l['global_text']);
                                //$smsMessage = str_replace('%%FLOOR%%', $row['name_map'], $smsMessage);
                                //$smsMessage = str_replace('%%ROOM%%', $row['nb_room'], $smsMessage);
                                $smsMessage = str_replace('%%PATIENT%%', $l['patient_name'], $smsMessage);
                                $smsMessage = str_replace('%%RESPONSABLE%%', $l['name_contact'], $smsMessage);
                                //echo $smsMessage;
                                $smsMessage = html_entity_decode(strip_tags($smsMessage));
                                $url = $smsUrl."&phonenumber={$smsNumber}&text=".urlencode($smsMessage);
                                //echo $url;
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                                $response = curl_exec($ch);
                                //echo $response;  //OK: b555c7e2-1b70-4010-84de-ed6da18128c5
                                $status = (substr($response, 0, 2) == 'OK') ? 1 : 0;
                                $arrForLog = array(
                                    'serial_number' => $DeviceID,
                                    'AntennaInt' => $AntennaInt,
                                    'BaseName' => $BaseName,
                                    'DeviceType' => $DeviceType,
                                    'EventType' => $EventType,
                                    'PendantRxLevel' => $PendantRxLevel,
                                    'LowBattery' => $LowBattery,
                                    'type_notification' => 'sms',
                                    'receiver' => $smsNumber,
                                    'message_sent' => strip_tags($smsMessage),
                                    'response_message' => strip_tags($response),
                                    'status_of_notification' => $status,
                                    'time_stamp' => time(),
                                    'device_description' => $row['description'],
                                    'live_panel' => $l['live_panel'],
                                    'require_acknowledge' => $l['require_acknowledge'],
                                    'auto_close' => $l['auto_close'],
                                    'flashing_toggle' => $l['flashing_toggle'],
                                    'auto_close_duration' => $l['auto_close_duration'],
                                    'position_popup' => $l['position_popup']
                                );
                                $jsonResponse[] = array(
                                    'result_code' => $status,
                                    'result_details' => strip_tags($response),
                                    'notification_type' => 'sms',
                                    //'call_id' => $call_id,
                                    'transfer' => false
                                );
                                $this->insertStatus($arrForLog);
                            } //End If Verification of SMS Destination
                        }  //End of foreach
                    } // End IF SMS Custom


                    /**
                     * Preparing Send E-mail Custom
                     */

                    if (count($emailEventCustom)) {
                        $smtpSettings = $cmd->select('*')
                            ->from('{{mail_settings}}')
                            ->limit('1')
                            ->queryRow();
                        $cmd->reset();

                        /*$genInfoPatientPosition = $cmd->select("concat(pa.first_name, ' ',pa.last_name) as patient_name, b.name as name_building, m.name_map, ro.nb_room")
                                ->from('{{devices}} d')
                                ->leftJoin('{{room_device_patient}} rdp', 'pa.id_patient = rdp.id_patient')
                                ->leftJoin('{{patients}} pa', 'pa.id_patient = rdp.id_patient')
                                ->join('{{rooms}} ro', 'ro.id_room = rdp.id_room')
                                ->join('{{maps}} m', 'm.id_map = ro.id_map')
                                ->join('{{buildings}} b', 'b.id_building = ro.id_building')
                                ->where('d.serial_number = :serial_number', array(':serial_number'=> $serial_number))
                                ->queryRow();*/

                        $cmd->reset();
                        if (count($smtpSettings) && count($emailEventCustom)) {
                            $mail = new YiiMailer();
                            $mail->IsSMTP();
                            //$mail->SMTPDebug = 2;
                            $mail->Host = $smtpSettings['host'];
                            $mail->Port = $smtpSettings['port'];
                            $mail->SMTPAuth = true;
                            $mail->IsHTML(true);
                            $mail->clearView();
                            $mail->clearLayout();
                            $mail->SMTPSecure = $smtpSettings['security_type'];
                            $mail->Username = $smtpSettings['login_name'];
                            $mail->Password = $smtpSettings['passwd'];

                            foreach ($emailEventCustom as $k => $l) {
                                $emailDestination = $l['email'];
                                $mail->setFrom($smtpSettings['login_name'],$smtpSettings['from_text']);
                                $mail->setTo($emailDestination);
                                $mail->setSubject($l['desc_global_event']);
                                $mailMessage = $l['global_text'];
                                /*'desc_global_event' => $lEvInfo['email_desc'],
                               'pick_event_type' => $lEvInfo['pick_event_type'],
                               'name_contact' => $lEvInfo['name_contact'],
                               'email' => $lEvInfo['email'],
                               'global_text' => $lEvInfo['email_message'],
                               'patient_name' => $lEvInfo['patient_name']*/

                                //$mailMessage = str_replace('%%BUILDING%%', $row['building_name'], $mailMessage);
                                //$mailMessage = str_replace('%%FLOOR%%', $row['name_map'], $mailMessage);
                                //$mailMessage = str_replace('%%ROOM%%', $row['nb_room'], $mailMessage);
                                $mailMessage = str_replace('%%PATIENT%%', $l['patient_name'], $mailMessage);
                                $mailMessage = str_replace('%%RESPONSABLE%%', $l['name_contact'], $mailMessage);
                                $mail->setBody($mailMessage);
                                //$mail->setData(array('message' => $mailMessage, 'name' => $smtpSettings['from_text'], 'description' => ''));
                                if ($mail->send()) {
                                    $statusEmail = $mail->getError();
                                    $statusOfNotification = 1;
                                    //print_r($mail);
                                } else {
                                    $statusEmail = $mail->getError();
                                    $statusOfNotification = 0;
                                    //print_r($mail);
                                }
                                $mail->clearAddresses();

                                $arrForLog = array(
                                    'serial_number' => $DeviceID,
                                    'AntennaInt' => $AntennaInt,
                                    'EventType' => $EventType,
                                    'BaseName' => $BaseName,
                                    'DeviceType' => $DeviceType,
                                    'PendantRxLevel' => $PendantRxLevel,
                                    'LowBattery' => $LowBattery,
                                    'type_notification' => 'email',
                                    'receiver' => $emailDestination,
                                    'message_sent' => $mailMessage,
                                    'response_message' => $statusEmail,
                                    'status_of_notification' => $statusOfNotification,
                                    'time_stamp' => time(),
                                    'device_description' => $row['description'],
                                    'live_panel' => $l['live_panel'],
                                    'require_acknowledge' => $l['require_acknowledge'],
                                    'auto_close' => $l['auto_close'],
                                    'flashing_toggle' => $l['flashing_toggle'],
                                    'auto_close_duration' => $l['auto_close_duration'],
                                    'position_popup' => $l['position_popup']
                                );
                                $jsonResponse[] = array(
                                    'result_code' => $statusOfNotification,
                                    'result_details' => $statusEmail,
                                    'notification_type' => 'email',
                                    'transfer' => false
                                );
                                $this->insertStatus($arrForLog);
                            } //End foreach
                        } //End If verification of email Settings
                    }  // End If verification email event

                    /**
                     * Preparing VoIP Message Custom
                     */

                    if (count($voipEventCustom)){
                        $voipInfo = $cmd->select('a.voip_url')
                            ->from('{{pendant_devices}} pd')
                            ->join('{{residents_of_rooms}} rr', 'pd.id_patient = rr.id_patient')
                            ->join('{{rooms}} r', 'r.id_room = rr.id_room')
                            ->join('{{asterisk}} a', 'a.id_building = r.id_building')
                            ->where('pd.serial_number=:id_device', array(':id_device' => $DeviceID))
                            ->queryScalar();
                        $cmd->reset();
                        foreach ($voipEventCustom as $m => $l) {
                            /*$voipDestination = $cmd->select('name_voice_number, number_to_call')
                                ->from('{{system_voice_numbers}}')
                                ->where('id_system_voice_number=:voip_id', array(':voip_id'=>$m))
                                ->queryRow();
                            $cmd->reset();

                            'desc_global_event' => $lEvInfo['voice_desc'],
                           'pick_event_type' => $lEvInfo['pick_event_type'],
                           'name_contact' => $lEvInfo['name_contact'],
                           'mobile' => $lEvInfo['mobile'],
                           'global_text' => $lEvInfo['voice_message'],
                           'patient_name' => $lEvInfo['patient_name']

                            */
                            $voipDestinationName = $l['name_contact'];
                            if (count($voipDestinationName)) {
                                $voipNumber = $l['mobile'];
                                $voipMessage = str_replace('%%BUILDING%%', "", $l['global_text']);
                                //$voipMessage = str_replace('%%FLOOR%%', $row['name_map'], $voipMessage);
                                //$voipMessage = str_replace('%%ROOM%%', $row['nb_room'], $voipMessage);
                                $voipMessage = str_replace('%%PATIENT%%', $l['patient_name'], $voipMessage);
                                $voipMessage = str_replace('%%RESPONSABLE%%', $l['name_contact'], $voipMessage);
                                $voipMessage2 = strip_tags($voipMessage);
                                $voipMessage2 = mb_ereg_replace("&nbsp;", " ", $voipMessage2);
                                //$voipMessage2 = mb_convert_encoding($voipMessage2, "UTF-8");
                                $url = $voipInfo;
                                //echo $url;
                                $data_string = json_encode(array(
                                    "Channel" => $voipNumber,
                                    "callerid" => uniqid(),
                                    "waittime" => 45,
                                    "variables" => array(
                                        "notificationBody" => $voipMessage2,
                                        "eventId" =>uniqid()
                                    )

                                ));
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                                curl_setopt($ch, CURLOPT_POST, true);
                                /*curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                    'Content-Type: application/json')
                                ); */
                                curl_setopt($ch, CURLOPT_POSTFIELDS, array('data'=>$data_string));
                                $response = curl_exec($ch);
                                //$response = "";
                                $st = json_decode($response);
                                //print_r($st);
                                //print_r($response);echo "<br/>--";
                                //$st['result'] = "";
                                //print_r($st);
                                //echo $response;  //OK: b555c7e2-1b70-4010-84de-ed6da18128c5
                                // {"result": "success"}
                                $status = 1;//($st->result == 'success') ? 1 : 0;

                                $arrForLog = array(
                                    'serial_number' => $DeviceID,
                                    'AntennaInt' => $AntennaInt,
                                    'EventType' => $EventType,
                                    'BaseName' => $BaseName,
                                    'DeviceType' => $DeviceType,
                                    'PendantRxLevel' => $PendantRxLevel,
                                    'LowBattery' => $LowBattery,
                                    'type_notification' => 'voip',
                                    'receiver' => $voipNumber,
                                    'message_sent' => $voipMessage2,
                                    'response_message' => $response,
                                    'status_of_notification' => $status,
                                    'time_stamp' => time(),
                                    'device_description' => $row['description'],
                                    'live_panel' => $l['live_panel'],
                                    'require_acknowledge' => $l['require_acknowledge'],
                                    'auto_close' => $l['auto_close'],
                                    'flashing_toggle' => $l['flashing_toggle'],
                                    'auto_close_duration' => $l['auto_close_duration'],
                                    'position_popup' => $l['position_popup']
                                );
                                $jsonResponse[] = array(
                                    'result_code' => $status,
                                    'result_details' => $response,
                                    'notification_type' => 'voip',
                                    'transfer' => false
                                );
                                $this->insertStatus($arrForLog);
                            } // END If Count VoIP Destination
                        } // End Foreach
                    } // End if count of VoIP count

                    if (count($ioEventCustom)){
                        foreach ($ioEventCustom as $m => $l) {

                            $url = "http://".$l['ip_address'];
                            if ($url != "") {
                                $arrayForJson = array(
                                    'id' => $l['io_id'],
                                    'command' => $l['command']
                                );
                                $data_string = json_encode($arrayForJson);
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, array('data'=>$data_string));
                                $response = curl_exec($ch);
                                $st = json_decode($response);
                                //print_r($st);
                                //echo $response;  //OK: b555c7e2-1b70-4010-84de-ed6da18128c5
                                $status =  1;

                                $arrForLog = array(
                                    'serial_number' => $DeviceID,
                                    'AntennaInt' => $AntennaInt,
                                    'EventType' => $EventType,
                                    'BaseName' => $BaseName,
                                    'DeviceType' => $DeviceType,
                                    'PendantRxLevel' => $PendantRxLevel,
                                    'LowBattery' => $LowBattery,
                                    'type_notification' => 'IOPOS',
                                    'receiver' => "",
                                    'message_sent' => "",
                                    'response_message' => $response,
                                    'status_of_notification' => $status,
                                    'time_stamp' => time(),
                                    'url' => $url,
                                    'id_iodevice' => $l['io_id'],
                                    'command' => $l['command'],
                                    'device_description' => $row['description'],
                                    'live_panel' => $l['live_panel'],
                                    'require_acknowledge' => $l['require_acknowledge'],
                                    'auto_close' => $l['auto_close'],
                                    'flashing_toggle' => $l['flashing_toggle'],
                                    'auto_close_duration' => $l['auto_close_duration'],
                                    'position_popup' => $l['position_popup']
                                );
                                $jsonResponse[] = array(
                                    'result_code' => $status,
                                    'result_details' => $response,
                                    'notification_type' => 'IOPOS',
                                    'call_id' => '',
                                    'transfer' => false
                                );
                                $this->insertStatus($arrForLog);
                            } // END If Count VoIP Destination
                        } // End Foreach
                    } // End if count of Transfer count

                    if (count($httpEventCustom)){
                        foreach ($httpEventCustom as $m => $l) {
                            $httpLinks = $cmd->select('*')
                                ->from('{{http_inventory}}')
                                ->where('id_http_inventory=:id_http_inventory', array(':id_http_inventory'=>$m))
                                ->queryRow();
                            $cmd->reset();

                            if (count($httpLinks)) {
                                $url = urldecode($httpLinks['action_url']);
                                $ch = curl_init();

                                $headers = array();
                                $varHeaders = explode(';', $httpLinks['additional_header']);
                                $varHeadersParam = explode('|', substr($varHeaders[0], 0, -1));
                                $varHeadersValue = explode('|', substr($varHeaders[1], 0, -1));
                                foreach ($varHeadersParam as $k => $v){
                                    $headers[] = $v.':'.$varHeadersValue[$k];
                                }
                                $var_to_send = "";

                                if ($httpLinks['type_of_url'] == 'custom') {


                                    if (!empty($httpLinks['custom_variable'])) {
                                        $varCustom = explode(';', $httpLinks['custom_variable']);
                                        $varCustomParam = explode('|', substr($varCustom[0], 0, -1));
                                        $varCustomValue = explode('|', substr($varCustom[1], 0, -1));
                                        foreach ($varCustomParam as $k => $v) {
                                            if ($httpLinks['enconding_message'] == 'xml') {
                                                $var_to_send .= "<{$v}>" . $varCustomValue[$k] . "</{$v}";
                                            } else if ($httpLinks['enconding_message'] == 'json') {
                                                $var_to_send[$v] = $varCustomValue[$k];
                                            } else {
                                                if (!empty($var_to_send))
                                                    $var_to_send .= "&" . $v . '=' . $varCustomValue[$k];
                                                else
                                                    $var_to_send .= $v . '=' . $varCustomValue[$k];
                                            }
                                        }

                                    }


                                    if (!empty($var_to_send)) {
                                        if ($httpLinks['enconding_message'] == 'xml') {
                                            $var_to_send .= "<msg>" . $httpLinks['message_body'] . "</msg>";
                                            $var_to_send = "<xml>" . $var_to_send . "</xml>";
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
                                        } else if ($httpLinks['enconding_message'] == 'json') {
                                            $var_to_send .= '&msg=' . htmlspecialchars($httpLinks['message_body']);
                                            $var_to_send = json_encode($var_to_send);
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                    'Content-Type: application/json',
                                                    'Content-Length: ' . strlen($var_to_send))
                                            );
                                        } else if ($httpLinks['enconding_message'] == 'ascii') {
                                            $var_to_send .= '&msg=' . htmlspecialchars($httpLinks['message_body']);
                                            $var_to_send = iconv('UTF-8', 'ASCII//TRANSLIT', $var_to_send);
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                    'Content-Type: text/html; charset=us-ascii'
                                                )
                                            );
                                        } else {
                                            $var_to_send .= '&msg=' . htmlspecialchars($httpLinks['message_body']);
                                        }
                                    }
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                                    switch ($httpLinks['send_method']) {
                                        case "get":
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                                            curl_setopt($ch, CURLOPT_URL, $url . '?' . $var_to_send);
                                            brake;
                                        case "post":
                                            curl_setopt($ch, CURLOPT_POST, 1);
                                            curl_setopt($ch, CURLOPT_URL, $url);
                                            curl_setopt($ch, CURLOPT_POSTFIELDS, $var_to_send);
                                            brake;
                                        case "put":
                                            curl_setopt($ch, CURLOPT_PUT, 1);
                                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                                            curl_setopt($ch, CURLOPT_URL, $url . '?' . $var_to_send);
                                            brake;
                                        case "delete":
                                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                                            curl_setopt($ch, CURLOPT_URL, $url);
                                            brake;
                                    }
                                }
                                $response = curl_exec($ch);
                                $st = json_decode($response);
                                //print_r($st);
                                //echo $response;  //OK: b555c7e2-1b70-4010-84de-ed6da18128c5
                                $status =  1;

                                $arrForLog = array(
                                    'serial_number' => $DeviceID,
                                    'AntennaInt' => $AntennaInt,
                                    'EventType' => $EventType,
                                    'BaseName' => $BaseName,
                                    'DeviceType' => $DeviceType,
                                    'PendantRxLevel' => $PendantRxLevel,
                                    'LowBattery' => $LowBattery,
                                    'type_notification' => 'HTTP',
                                    'receiver' => "",
                                    'message_sent' => "",
                                    'response_message' => $response,
                                    'status_of_notification' => $status,
                                    'time_stamp' => time(),
                                    'url' => $url,
                                    'id_http_inventory' => $l['id_http'],
                                    'command' => $l['command'],
                                    'device_description' => $row['description'],
                                    'live_panel' => $l['live_panel'],
                                    'require_acknowledge' => $l['require_acknowledge'],
                                    'auto_close' => $l['auto_close'],
                                    'flashing_toggle' => $l['flashing_toggle'],
                                    'auto_close_duration' => $l['auto_close_duration'],
                                    'position_popup' => $l['position_popup']
                                );
                                $jsonResponse[] = array(
                                    'result_code' => $status,
                                    'result_details' => $response,
                                    'notification_type' => 'HTTP',
                                    'call_id' => '',
                                    'transfer' => false
                                );
                                $this->insertStatus($arrForLog);
                            } // END If Count VoIP Destination
                        } // End Foreach
                    } // End if count of Transfer count


                } //End Call Info IF

                $callInfo = $cmd->select('em.*, get.auto_close AS ge_auto_close, get.auto_close_duration AS ge_auto_close_duration, pt.id_pendant_type, pt.description, pt.priority, pt.color_hex ')
                    ->from('{{events_pendant_manage}} em')
                    ->join('{{global_event_pendant_template}} get', 'get.id_global_event_pendant_template = em.id_global_event')
                    ->join('{{pendant_type}} pt', 'get.id_pendant_type = pt.id_pendant_type')
                    ->where( array('AND', 'em.id_device = :id_device', 'pt.script = :code'), array(':id_device' => $id_device, ':code' => $EventType))
                    ->queryAll();
                //->getText();

                $cmd->reset();

                if (count($callInfo)){
                //print_r($callInfo);

                $settingsModel = Settings::model()->find();
                $smsUrl = $settingsModel->sms_url;

                $voipInfo = $cmd->select('a.voip_url')
                    ->from('{{pendant_devices}} pd')
                    ->join('{{residents_of_rooms}} rr', 'pd.id_patient = rr.id_patient')
                    ->join('{{rooms}} r', 'r.id_room = rr.id_room')
                    ->join('{{asterisk}} a', 'a.id_building = r.id_building')
                    ->where('pd.serial_number=:id_device', array(':id_device' => $DeviceID))
                    ->queryScalar();
                $cmd->reset();
                //print_r($callInfo);
                foreach($callInfo as $kCall) {
                    if ($kCall['event_type'] == 'template'){
                        $callInfoTemplate = $cmd->select('get.desc_global_event, get.pick_event_type,
                                            gm.global_description, gm.global_subject, gm.global_text, re.id_system_sms_number, re.id_system_email, re.id_system_voice_number, re.id_system_camera, re.id_http_inventory, mid.io_id, c.command, d.ip_address, c.id_command')
                            ->from('{{global_event_pendant_template}} get')
                            ->join('{{global_messages}} gm', 'gm.id_global_message = get.id_global_message')
                            ->join('{{receiver}} re', 're.id_global_event_pendant_template = get.id_global_event_pendant_template')
                            ->leftJoin('{{mipositioning_input_device}} mid', 're.id_iodevice = mid.id_input_device')
                            ->leftJoin('{{devices}} d', 'd.id_device = mid.id_device')
                            ->leftJoin('{{command}} c', 'c.id_command = re.id_command')
                            ->where('get.id_global_event_pendant_template = :id_global_event_template', array(':id_global_event_template'=> $kCall['id_global_event']))
                            ->queryAll();
                        //echo $cmd->getText();
                        //print_r($callInfoTemplate);
                        $cmd->reset();

                        if (count($callInfoTemplate)){
                            foreach ($callInfoTemplate as $k) {
                                if ($k['id_system_email'] != "" && $k['id_system_email'] > 0) {
                                    $emailEvent[$k['id_system_email']] = array(
                                        'description' => $kCall['description'],
                                        'id_pendant_type' => $kCall['id_pendant_type'],
                                        'priority' => $kCall['priority'],
                                        'color_hex' => $kCall['color_hex'],
                                        'desc_global_event' => $k['desc_global_event'],
                                        'pick_event_type' => $k['pick_event_type'],
                                        'global_description' => $k['global_description'],
                                        'global_subject' => $k['global_subject'],
                                        'global_text' => $k['global_text'],
                                        'live_panel' => $kCall['live_panel'],
                                        'require_acknowledge' => $kCall['require_acknowledge'],
                                        'auto_close' => $kCall['ge_auto_close'],
                                        'flashing_toggle' => $kCall['flashing_toggle'],
                                        'auto_close_duration' => ($kCall['ge_auto_close_duration'] > 0) ? $kCall['ge_auto_close_duration'] : 0,
                                        'position_popup' => $kCall['position_popup']
                                    );

                                } else if ($k['id_system_sms_number'] != "" && $k['id_system_sms_number'] > 0) {
                                    $smsEvent[$k['id_system_sms_number']] = array(
                                        'description' => $kCall['description'],
                                        'id_pendant_type' => $kCall['id_pendant_type'],
                                        'priority' => $kCall['priority'],
                                        'color_hex' => $kCall['color_hex'],
                                        'desc_global_event' => $k['desc_global_event'],
                                        'pick_event_type' => $k['pick_event_type'],
                                        'global_description' => $k['global_description'],
                                        'global_subject' => $k['global_subject'],
                                        'global_text' => $k['global_text'],
                                        'live_panel' => $kCall['live_panel'],
                                        'require_acknowledge' => $kCall['require_acknowledge'],
                                        'auto_close' => $kCall['ge_auto_close'],
                                        'flashing_toggle' => $kCall['flashing_toggle'],
                                        'auto_close_duration' => ($kCall['ge_auto_close_duration'] > 0) ? $kCall['ge_auto_close_duration'] : 0,
                                        'position_popup' => $kCall['position_popup']
                                    );
                                } else if ($k['id_system_voice_number'] != "" && $k['id_system_voice_number'] > 0) {
                                    if ($k['pick_event_type'] == 'VOIP') {
                                        $voipEvent[$k['id_system_voice_number']] = array(
                                            'description' => $kCall['description'],
                                            'id_pendant_type' => $kCall['id_pendant_type'],
                                            'priority' => $kCall['priority'],
                                            'color_hex' => $kCall['color_hex'],
                                            'desc_global_event' => $k['desc_global_event'],
                                            'pick_event_type' => $k['pick_event_type'],
                                            'global_description' => $k['global_description'],
                                            'global_subject' => $k['global_subject'],
                                            'global_text' => $k['global_text'],
                                            'live_panel' => $kCall['live_panel'],
                                            'require_acknowledge' => $kCall['require_acknowledge'],
                                            'auto_close' => $kCall['ge_auto_close'],
                                            'flashing_toggle' => $kCall['flashing_toggle'],
                                            'auto_close_duration' => ($kCall['ge_auto_close_duration'] > 0) ? $kCall['ge_auto_close_duration'] : 0,
                                            'position_popup' => $kCall['position_popup']
                                        );
                                    }
                                } //End if of verification else
                                else if ($k['pick_event_type'] == 'IOPOS'){
                                    $ioEvent[$k['id_command']] = array(
                                        'description' => $kCall['description'],
                                        'id_pendant_type' => $kCall['id_pendant_type'],
                                        'priority' => $kCall['priority'],
                                        'color_hex' => $kCall['color_hex'],
                                        'desc_global_event' => $k['desc_global_event'],
                                        'pick_event_type' => $k['pick_event_type'],
                                        'global_description' => $k['global_description'],
                                        'global_subject' => $k['global_subject'],
                                        'global_text' => $k['global_text'],
                                        'live_panel' => $kCall['live_panel'],
                                        'io_id' => $k['io_id'],
                                        'command' => $k['command'],
                                        'ip_address' => $k['ip_address'],
                                        'require_acknowledge' => $kCall['require_acknowledge'],
                                        'auto_close' => $kCall['ge_auto_close'],
                                        'flashing_toggle' => $kCall['flashing_toggle'],
                                        'auto_close_duration' => ($kCall['ge_auto_close_duration'] > 0) ? $kCall['ge_auto_close_duration'] : 0,
                                        'position_popup' => $kCall['position_popup']
                                    );
                                }
                                else if ($k['pick_event_type'] == 'HTTP'){
                                    $httpEvent[$k['id_http_inventory']] = array(
                                        'description' => $kCall['description'],
                                        'id_pendant_type' => $kCall['id_pendant_type'],
                                        'priority' => $kCall['priority'],
                                        'color_hex' => $kCall['color_hex'],
                                        'desc_global_event' => $k['desc_global_event'],
                                        'pick_event_type' => $k['pick_event_type'],
                                        'global_description' => $k['global_description'],
                                        'global_subject' => $k['global_subject'],
                                        'global_text' => $k['global_text'],
                                        'live_panel' => $kCall['live_panel'],
                                        'id_http' => $k['id_http_inventory'],
                                        'command' => $k['command'],
                                        'ip_address' => $k['ip_address'],
                                        'require_acknowledge' => $kCall['require_acknowledge'],
                                        'auto_close' => $kCall['ge_auto_close'],
                                        'flashing_toggle' => $kCall['flashing_toggle'],
                                        'auto_close_duration' => ($kCall['ge_auto_close_duration'] > 0) ? $kCall['ge_auto_close_duration'] : 0,
                                        'position_popup' => $kCall['position_popup']
                                    );
                                }

                            } //End of Foreach
                        } // End of Count of Template
                    } //End IF Type of Template
                } // End of foreach

                /**
                 * Preparing Send SMS
                 */

                if (count($smsEvent)) {
                    if (!empty($smsUrl)) {
                        $genInfoPatientPosition = $cmd->select("concat(pa.first_name, ' ',pa.last_name) as patient_name, b.name as name_building, m.name_map, r.nb_room")
                            ->from('{{pendant_devices}} pd')
                            ->join('{{residents_of_rooms}} rr', 'pd.id_patient = rr.id_patient')
                            ->join('{{patients}} pa', 'pa.id_patient = pd.id_patient')
                            ->join('{{rooms}} r', 'r.id_room = rr.id_room')
                            ->join('{{maps}} m', 'm.id_map = r.id_map')
                            ->join('{{buildings}} b', 'b.id_building = r.id_building')
                            ->where('pd.serial_number = :serial_number', array(':serial_number'=> $DeviceID))
                            ->queryRow();

                        $cmd->reset();

                        foreach ($smsEvent as $m => $l) {
                            $smsDestination = $cmd->select('name_sms, number_sms')
                                ->from('{{system_sms_numbers}}')
                                ->where('id_system_sms_number=:sms_id', array(':sms_id'=>$m))
                                ->queryRow();
                            $cmd->reset();
                            $smsDestinationName = $smsDestination['name_sms'];
                            if (count($smsDestinationName)) {
                                $smsNumber = $smsDestination['number_sms'];
                                $smsMessage = str_replace('%%BUILDING%%', $genInfoPatientPosition['name_building'], $l['global_text']);
                                $smsMessage = str_replace('%%FLOOR%%', $genInfoPatientPosition['name_map'], $smsMessage);
                                $smsMessage = str_replace('%%ROOM%%', $genInfoPatientPosition['nb_room'], $smsMessage);
                                $smsMessage = str_replace('%%PATIENT%%', $genInfoPatientPosition['patient_name'], $smsMessage);
                                $smsMessage = str_replace('%%RESPONSABLE%%', $smsDestination['name_sms'], $smsMessage);
                                //echo $smsMessage;
                                $smsMessage = html_entity_decode(strip_tags($smsMessage));
                                $url = $smsUrl."&phonenumber={$smsNumber}&text=".urlencode($smsMessage);
                                //echo $url;
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                                $response = curl_exec($ch);
                                //echo $response;  //OK: b555c7e2-1b70-4010-84de-ed6da18128c5
                                $status = (substr($response, 0, 2) == 'OK') ? 1 : 0;


                                $arrForLog = array(
                                    'serial_number' => $DeviceID,
                                    'AntennaInt' => $AntennaInt,
                                    'EventType' => $EventType,
                                    'BaseName' => $BaseName,
                                    'DeviceType' => $DeviceType,
                                    'PendantRxLevel' => $PendantRxLevel,
                                    'LowBattery' => $LowBattery,
                                    'type_notification' => 'sms',
                                    'receiver' => $smsNumber,
                                    'message_sent' => strip_tags($smsMessage),
                                    'response_message' => strip_tags($response),
                                    'status_of_notification' => $status,
                                    'time_stamp' => time(),
                                    'device_description' => $row['description'],
                                    'live_panel' => $l['live_panel'],
                                    'require_acknowledge' => $l['require_acknowledge'],
                                    'auto_close' => $l['auto_close'],
                                    'flashing_toggle' => $l['flashing_toggle'],
                                    'auto_close_duration' => $l['auto_close_duration'],
                                );
                                $jsonResponse[] = array(
                                    'result_code' => $status,
                                    'result_details' => $response,
                                    'notification_type' => 'sms',
                                    'transfer' => false
                                );
                                $this->insertStatus($arrForLog);
                            } //End If Verification of SMS Destination
                        }  //End of foreach
                    }  //End If Verification SMSEvent
                } // End of Preparing to Send SMS
                /**
                 * Preparing Send E-mail
                 */

                if (count($emailEvent)) {
                    $smtpSettings = $cmd->select('*')
                        ->from('{{mail_settings}}')
                        ->limit('1')
                        ->queryRow();
                    $cmd->reset();

                    $genInfoPatientPosition = $cmd->select("concat(pa.first_name, ' ',pa.last_name) as patient_name, b.name as name_building, m.name_map, r.nb_room")
                        ->from('{{pendant_devices}} pd')
                        ->join('{{residents_of_rooms}} rr', 'pd.id_patient = rr.id_patient')
                        ->join('{{patients}} pa', 'pa.id_patient = pd.id_patient')
                        ->join('{{rooms}} r', 'r.id_room = rr.id_room')
                        ->join('{{maps}} m', 'm.id_map = r.id_map')
                        ->join('{{buildings}} b', 'b.id_building = r.id_building')
                        ->where('pd.serial_number = :serial_number', array(':serial_number'=> $DeviceID))
                        ->queryRow();

                    $cmd->reset();
                    if (count($smtpSettings) && count($emailEvent)) {
                        $mail = new YiiMailer();
                        $mail->IsSMTP();
                        //$mail->SMTPDebug = 2;
                        $mail->Host = $smtpSettings['host'];
                        $mail->Port = $smtpSettings['port'];
                        $mail->SMTPAuth = true;
                        $mail->IsHTML(true);
                        $mail->clearView();
                        $mail->clearLayout();
                        $mail->SMTPSecure = $smtpSettings['security_type'];
                        $mail->Username = $smtpSettings['login_name'];
                        $mail->Password = $smtpSettings['passwd'];

                        foreach ($emailEvent as $k => $l) {
                            $emailDestination = $cmd->select('*')
                                ->from('{{system_email}}')
                                ->where('id_system_email=:email_id', array(':email_id'=>$k))
                                ->queryRow();
                            $cmd->reset();
                            $mail->setFrom($smtpSettings['login_name'],$smtpSettings['from_text']);
                            $mail->setTo($emailDestination['email']);
                            $mail->setSubject($l['global_subject']);
                            $mailMessage = $l['global_text'];
                            $mailMessage = str_replace('%%BUILDING%%', $genInfoPatientPosition['name_building'], $mailMessage);
                            $mailMessage = str_replace('%%FLOOR%%', $genInfoPatientPosition['name_map'], $mailMessage);
                            $mailMessage = str_replace('%%ROOM%%', $genInfoPatientPosition['nb_room'], $mailMessage);
                            $mailMessage = str_replace('%%PATIENT%%', $genInfoPatientPosition['patient_name'], $mailMessage);
                            $mailMessage = str_replace('%%RESPONSABLE%%', $emailDestination['name_email'], $mailMessage);
                            $mail->setBody($mailMessage);
                            //$mail->setData(array('message' => $mailMessage, 'name' => $smtpSettings['from_text'], 'description' => ''));
                            if ($mail->send()) {
                                $statusEmail = $mail->getError();
                                $statusOfNotification = 1;
                                //print_r($mail);
                            } else {
                                $statusEmail = $mail->getError();
                                $statusOfNotification = 0;
                                //print_r($mail);
                            }
                            $mail->clearAddresses();

                            $arrForLog = array(
                                'serial_number' => $DeviceID,
                                'AntennaInt' => $AntennaInt,
                                'EventType' => $EventType,
                                'BaseName' => $BaseName,
                                'DeviceType' => $DeviceType,
                                'PendantRxLevel' => $PendantRxLevel,
                                'LowBattery' => $LowBattery,
                                'type_notification' => 'email',
                                'receiver' => $emailDestination['email'],
                                'message_sent' => $mailMessage,
                                'response_message' => $statusEmail,
                                'status_of_notification' => $statusOfNotification,
                                'time_stamp' => time(),
                                'device_description' => $row['description'],
                                'live_panel' => $l['live_panel'],
                                'require_acknowledge' => $l['require_acknowledge'],
                                'auto_close' => $l['auto_close'],
                                'flashing_toggle' => $l['flashing_toggle'],
                                'auto_close_duration' => $l['auto_close_duration'],
                            );
                            $jsonResponse[] = array(
                                'result_code' => $statusOfNotification,
                                'result_details' => $statusEmail,
                                'notification_type' => 'email',
                                'transfer' => false
                            );
                            $this->insertStatus($arrForLog);
                        } //End foreach
                    } //End If verification of email Settings
                }  // End If verification email event

                /**
                 * Preparing VoIP Message
                 */

                if (count($voipEvent)){
                    /*$genInfoPatientPosition = $cmd->select("concat(pa.first_name, ' ',pa.last_name) as patient_name, b.name as name_building, m.name_map, ro.nb_room, ast.voip_url, ei.ext_number, ei.caller_id_internal, ei.caller_id_external, ei.caller_id_name")
                       ->from('{{patients}} AS pa')
                       ->join('{{room_device_patient}} rdp', 'pa.id_patient = rdp.id_patient')
                       ->join('{{rooms}} ro', 'ro.id_room = rdp.id_room')
                       ->join('{{devices}} d', 'd.id_device = rdp.id_device')
                       ->join('{{maps}} m', 'm.id_map = ro.id_map')
                       ->join('{{buildings}} b', 'b.id_building = ro.id_building')
                       ->join('{{asterisk}} ast', 'ast.id_building = d.id_building')
                       ->leftJoin('{{extension_info}} ei', 'ei.id_device = d.id_device')
                       ->where('d.serial_number = :serial_number', array(':serial_number'=> $serial_number))
                       ->queryRow();
                       */
                    $genInfoPatientPosition = $cmd->select("concat(pa.first_name, ' ',pa.last_name) as patient_name, b.name as name_building, m.name_map, r.nb_room")
                        ->from('{{pendant_devices}} pd')
                        ->join('{{residents_of_rooms}} rr', 'pd.id_patient = rr.id_patient')
                        ->join('{{patients}} pa', 'pa.id_patient = pd.id_patient')
                        ->join('{{rooms}} r', 'r.id_room = rr.id_room')
                        ->join('{{maps}} m', 'm.id_map = r.id_map')
                        ->join('{{buildings}} b', 'b.id_building = r.id_building')
                        ->where('pd.serial_number = :serial_number', array(':serial_number'=> $DeviceID))
                        ->queryRow();
                    $cmd->reset();
                    foreach ($voipEvent as $m => $l) {
                        $voipDestination = $cmd->select('name_voice_number, number_to_call')
                            ->from('{{system_voice_number}}')
                            ->where('id_system_voice_number=:voip_id', array(':voip_id'=>$m))
                            ->queryRow();
                        $cmd->reset();
                        $voipDestinationName = $voipDestination['name_voice_number'];
                        if (count($voipDestinationName)) {
                            $voipNumber = $voipDestination['number_to_call'];
                            $voipMessage = str_replace('%%BUILDING%%', $genInfoPatientPosition['name_building'], $l['global_text']);
                            $voipMessage = str_replace('%%FLOOR%%', $genInfoPatientPosition['name_map'], $voipMessage);
                            $voipMessage = str_replace('%%ROOM%%', $genInfoPatientPosition['nb_room'], $voipMessage);
                            $voipMessage = str_replace('%%PATIENT%%', $genInfoPatientPosition['patient_name'], $voipMessage);
                            $voipMessage = str_replace('%%RESPONSABLE%%', $voipDestination['name_voice_number'], $voipMessage);
                            $voipMessage2 = strip_tags($voipMessage);
                            $voipMessage2 = mb_ereg_replace("&nbsp;", " ", $voipMessage2);
                            //$voipMessage2 = mb_convert_encoding($voipMessage2, "UTF-8");
                            $url = $voipInfo;
                            //echo $url;
                            $arrayForJson = array(
                                "Channel" => $voipNumber,
                                //"callerid" => $genInfoPatientPosition['caller_id_external'],
                                "callerid" => uniqid(),
                                "waittime" => 45,
                                "variables" => array(
                                    "notificationBody" => $voipMessage2,
                                    "eventId" =>uniqid()
                                )

                            );
                            $data_string = json_encode($arrayForJson);
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, array('data'=>$data_string));
                            $response = curl_exec($ch);
                            $st = json_decode($response);
                            //print_r($st);
                            //echo $response;  //OK: b555c7e2-1b70-4010-84de-ed6da18128c5
                            $status =  1;

                            $arrForLog = array(
                                'serial_number' => $DeviceID,
                                'AntennaInt' => $AntennaInt,
                                'EventType' => $EventType,
                                'BaseName' => $BaseName,
                                'DeviceType' => $DeviceType,
                                'PendantRxLevel' => $PendantRxLevel,
                                'LowBattery' => $LowBattery,
                                'type_notification' => 'voip',
                                'receiver' => $voipNumber,
                                'message_sent' => $voipMessage2,
                                'response_message' => $response,
                                'status_of_notification' => $status,
                                'time_stamp' => time(),
                                'device_description' => $row['description'],
                                'live_panel' => $l['live_panel'],
                                'require_acknowledge' => $l['require_acknowledge'],
                                'auto_close' => $l['auto_close'],
                                'flashing_toggle' => $l['flashing_toggle'],
                                'auto_close_duration' => $l['auto_close_duration'],
                            );
                            $jsonResponse[] = array(
                                'result_code' => $status,
                                'result_details' => $response,
                                'notification_type' => 'voip',
                                'transfer' => false
                            );
                            $this->insertStatus($arrForLog);
                        } // END If Count VoIP Destination
                    } // End Foreach
                } // End if count of VoIP count


                if (count($ioEvent)){
                    /*$genInfoPatientPosition = $cmd->select("concat(pa.first_name, ' ',pa.last_name) as patient_name, b.name as name_building, m.name_map, ro.nb_room, ast.voip_url, ei.ext_number, ei.caller_id_internal, ei.caller_id_external, ei.caller_id_name")
                       ->from('{{patients}} AS pa')
                       ->join('{{room_device_patient}} rdp', 'pa.id_patient = rdp.id_patient')
                       ->join('{{rooms}} ro', 'ro.id_room = rdp.id_room')
                       ->join('{{devices}} d', 'd.id_device = rdp.id_device')
                       ->join('{{maps}} m', 'm.id_map = ro.id_map')
                       ->join('{{buildings}} b', 'b.id_building = ro.id_building')
                       ->join('{{asterisk}} ast', 'ast.id_building = d.id_building')
                       ->leftJoin('{{extension_info}} ei', 'ei.id_device = d.id_device')
                       ->where('d.serial_number = :serial_number', array(':serial_number'=> $serial_number))
                       ->queryRow();
                       */

                    foreach ($ioEvent as $m => $l) {

                        $url = "http://".$l['ip_address'];
                        if ($url != "") {
                            $arrayForJson = array(
                                'id' => $l['io_id'],
                                'command' => $l['command']
                            );
                            $data_string = json_encode($arrayForJson);
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, array('data'=>$data_string));
                            $response = curl_exec($ch);
                            $st = json_decode($response);
                            //print_r($st);
                            //echo $response;  //OK: b555c7e2-1b70-4010-84de-ed6da18128c5
                            $status =  1;

                            $arrForLog = array(
                                'serial_number' => $DeviceID,
                                'AntennaInt' => $AntennaInt,
                                'EventType' => $EventType,
                                'BaseName' => $BaseName,
                                'DeviceType' => $DeviceType,
                                'PendantRxLevel' => $PendantRxLevel,
                                'LowBattery' => $LowBattery,
                                'type_notification' => 'IOPOS',
                                'receiver' => "",
                                'message_sent' => "",
                                'response_message' => $response,
                                'status_of_notification' => $status,
                                'time_stamp' => time(),
                                'url' => $url,
                                'id_iodevice' => $l['io_id'],
                                'command' => $l['command'],
                                'device_description' => $row['description'],
                                'live_panel' => $l['live_panel'],
                                'require_acknowledge' => $l['require_acknowledge'],
                                'auto_close' => $l['auto_close'],
                                'flashing_toggle' => $l['flashing_toggle'],
                                'auto_close_duration' => $l['auto_close_duration'],
                            );
                            $jsonResponse[] = array(
                                'result_code' => $status,
                                'result_details' => $response,
                                'notification_type' => 'IOPOS',
                                'call_id' => '',
                                'transfer' => false
                            );
                            $this->insertStatus($arrForLog);
                        } // END If Count VoIP Destination
                    } // End Foreach
                } // End if count of VoIP count
                /**
                 * Preparing HTTP Message
                 */

                    if (count($httpEvent)){
                        /*$genInfoPatientPosition = $cmd->select("concat(pa.first_name, ' ',pa.last_name) as patient_name, b.name as name_building, m.name_map, ro.nb_room, ast.voip_url, ei.ext_number, ei.caller_id_internal, ei.caller_id_external, ei.caller_id_name")
                           ->from('{{patients}} AS pa')
                           ->join('{{room_device_patient}} rdp', 'pa.id_patient = rdp.id_patient')
                           ->join('{{rooms}} ro', 'ro.id_room = rdp.id_room')
                           ->join('{{devices}} d', 'd.id_device = rdp.id_device')
                           ->join('{{maps}} m', 'm.id_map = ro.id_map')
                           ->join('{{buildings}} b', 'b.id_building = ro.id_building')
                           ->join('{{asterisk}} ast', 'ast.id_building = d.id_building')
                           ->leftJoin('{{extension_info}} ei', 'ei.id_device = d.id_device')
                           ->where('d.serial_number = :serial_number', array(':serial_number'=> $serial_number))
                           ->queryRow();
                           */

                        foreach ($httpEvent as $m => $l) {

                            $httpLinks = $cmd->select('*')
                                ->from('{{http_inventory}}')
                                ->where('id_http_inventory=:id_http_inventory', array(':id_http_inventory'=>$m))
                                ->queryRow();
                            $cmd->reset();

                            //$url = "http://".$l['ip_address'];
                            if (count($httpLinks)) {
                                $url = urldecode($httpLinks['action_url']);
                                //echo $url;
                                //$data_string = json_encode($arrayForJson);
                                $ch = curl_init();
                                if ($httpLinks['type_of_url'] == 'custom') {
                                    $headers = array();
                                    $varHeaders = explode(';', $httpLinks['additional_header']);
                                    $varHeadersParam = explode('|', substr($varHeaders[0], 0, -1));
                                    $varHeadersValue = explode('|', substr($varHeaders[1], 0, -1));
                                    foreach ($varHeadersParam as $k => $v){
                                        $headers[] = $v.':'.$varHeadersValue[$k];
                                    }
                                    $var_to_send = "";

                                    if (!empty( $httpLinks['custom_variable'])) {
                                        $varCustom = explode(';', $httpLinks['custom_variable']);
                                        $varCustomParam = explode('|', substr($varCustom[0], 0, -1));
                                        $varCustomValue = explode('|', substr($varCustom[1], 0, -1));
                                        foreach ($varCustomParam as $k => $v) {
                                            if ($httpLinks['enconding_message'] == 'xml') {
                                                $var_to_send .= "<{$v}>".$varCustomValue[$k]."</{$v}";
                                            } else if ($httpLinks['enconding_message'] == 'json'){
                                                $var_to_send[$v]= $varCustomValue[$k];
                                            } else {
                                                if (!empty($var_to_send))
                                                    $var_to_send .= "&" . $v . '=' . $varCustomValue[$k];
                                                else
                                                    $var_to_send .= $v . '=' . $varCustomValue[$k];
                                            }
                                        }

                                    }
                                    if (!empty($var_to_send)) {
                                        if ($httpLinks['enconding_message'] == 'xml') {
                                            $var_to_send .= "<msg>".$httpLinks['message_body']."</msg>";
                                            $var_to_send = "<xml>".$var_to_send."</xml>";
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
                                        } else if ($httpLinks['enconding_message'] == 'json'){
                                            $var_to_send .= '&msg='.htmlspecialchars($httpLinks['message_body']);
                                            $var_to_send = json_encode($var_to_send);
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                    'Content-Type: application/json',
                                                    'Content-Length: ' . strlen($var_to_send))
                                            );
                                        } else if ($httpLinks['enconding_message'] == 'ascii'){
                                            $var_to_send .= '&msg='.htmlspecialchars($httpLinks['message_body']);
                                            $var_to_send = iconv('UTF-8', 'ASCII//TRANSLIT', $var_to_send);
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                    'Content-Type: text/html; charset=us-ascii'
                                                )
                                            );
                                        }
                                        else {
                                            $var_to_send .= '&msg='.htmlspecialchars($httpLinks['message_body']);
                                        }
                                    }
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                                    switch ($httpLinks['send_method']){
                                        case "get":
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                                            curl_setopt($ch, CURLOPT_URL, $url.'?'.$var_to_send);
                                            brake;
                                        case "post":
                                            curl_setopt($ch, CURLOPT_POST, 1);
                                            curl_setopt($ch, CURLOPT_URL, $url);
                                            curl_setopt($ch, CURLOPT_POSTFIELDS, $var_to_send);
                                            brake;
                                        case "put":
                                            curl_setopt($ch, CURLOPT_PUT, 1);
                                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                                            curl_setopt($ch, CURLOPT_URL, $url.'?'.$var_to_send);
                                            brake;
                                        case "delete":
                                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                                            curl_setopt($ch, CURLOPT_URL, $url);
                                            brake;
                                    }
                                }

                                //curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                                //curl_setopt($ch, CURLOPT_POST, true);
                                //curl_setopt($ch, CURLOPT_POSTFIELDS, array('data'=>$data_string));
                                $response = curl_exec($ch);
                                $st = json_decode($response);
                                //print_r($st);
                                //echo $response."\n\r";  //OK: b555c7e2-1b70-4010-84de-ed6da18128c5
                                //echo $response;  //OK: b555c7e2-1b70-4010-84de-ed6da18128c5
                                $status =  1;

                                $arrForLog = array(
                                    'serial_number' => $DeviceID,
                                    'AntennaInt' => $AntennaInt,
                                    'EventType' => $EventType,
                                    'BaseName' => $BaseName,
                                    'DeviceType' => $DeviceType,
                                    'PendantRxLevel' => $PendantRxLevel,
                                    'LowBattery' => $LowBattery,
                                    'type_notification' => 'HTTP',
                                    'receiver' => "",
                                    'message_sent' => "",
                                    'response_message' => $response,
                                    'status_of_notification' => $status,
                                    'time_stamp' => time(),
                                    'url' => $url,
                                    'id_http_inventory' => $l['id_http'],
                                    'command' => $l['command'],
                                    'device_description' => $row['description'],
                                    'live_panel' => $l['live_panel'],
                                    'require_acknowledge' => $l['require_acknowledge'],
                                    'auto_close' => $l['auto_close'],
                                    'flashing_toggle' => $l['flashing_toggle'],
                                    'auto_close_duration' => $l['auto_close_duration'],
                                );
                                $jsonResponse[] = array(
                                    'result_code' => $status,
                                    'result_details' => $response,
                                    'notification_type' => 'HTTP',
                                    'call_id' => '',
                                    'transfer' => false
                                );
                                $this->insertStatus($arrForLog);
                            } // END If Count VoIP Destination
                        } // End Foreach
                    } // End if count of VoIP count
            }

            header('Content-Type: application/json');
            echo json_encode($jsonResponse);

            }
        } else {
            echo "No autorisation \n\r".$_SERVER['REMOTE_ADDR'];
        }
    }

    public function insertStatus($arr){
        $connection=Yii::app()->db;
        $cmd = $connection->createCommand();
        //print_r($arr);
        $cmd->insert('{{notification_pendant_log}}', $arr);
    }
}
