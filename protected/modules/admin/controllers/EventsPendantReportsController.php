<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 03.02.15
 * Time: 20:12
 */
class EventsPendantReportsController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/column1';

    /**
     *
     */
    public function init()
    {
        parent::init();
        $cs = Yii::app()->clientScript; //d3.min.js
        $cs->registerCssFile(Yii::app()->request->baseUrl . '/assets/css/jquery.datetimepicker.css');
        //$cs->registerCssFile(Yii::app()->request->baseUrl . '/assets/css/jquery.dataTables.min.css');
        $cs->registerCssFile(Yii::app()->request->baseUrl . '/assets/css/dataTables.bootstrap.css');
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.placeholder.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.maskedinput.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.inputlimiter.1.3.1.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.dataTables.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/dataTables.bootstrap.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/highcharts/highcharts.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/highcharts/highcharts-more.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl . '/assets/js/pages/eventspendantreports.js', CClientScript::POS_END);
        /*$cs->registerScript(
            "charts",
            ' $(document).ready($(function () {
                    getCodeGraphToday();
            }));',
        CClientScript::POS_READY
        );*/
    }

    public function actionIndex()
    {
        //$objPHPExcel = new PHPExcel();
        $this->render('index');
    }

    public function actionReportSearch(){
        $searchFilter = $daterange = $daterangeTo = $serialNumber = $code = $typeEvent = $receiver = $patient = "";
        $lstPost = explode("&", urldecode($_POST['allData']));
        foreach ($lstPost as $l) {
            $tmp = explode("=", $l);
            $$tmp[0] = $tmp[1];
        }
        $start = (isset($_POST['start']) && !empty($_POST['start'])) ? trim($_POST['start']) : 0;
        $length = (isset($_POST['length']) && !empty($_POST['length'])) ? trim($_POST['length']) : 25;
        $search = (isset($_POST['search']['value']) && !empty($_POST['search']['value'])) ? trim($_POST['search']['value']) : "";
        $draw = (isset($_POST['draw']) && !empty($_POST['draw'])) ? trim($_POST['draw']) : 0;
        $order = (isset($_POST['order'])) ? $_POST['order'][0] : array('column' => 0, 'dir' => 'desc');
        $column = array("nl.current_time", "nl.device_description", "r.nb_room", "nl.receiver", "nl.serial_number", "nl.code", "nl.type_notification");


        if(isset($_POST) && !empty($_POST['allData'])){
            $arrayOfModelsCallTypes = CallsType::model()->findAll();
            $list = CHtml::listData($arrayOfModelsCallTypes, 'script','description' );

            $dateRangeDate = urldecode($daterange).":00";
            $dateRangeDateTo = urldecode($daterangeTo).':00';
            $whereTXT = " nl.current_time >= :dateRangeDate AND nl.current_time <= :dateRangeDateTo ";
            $whereArray[":dateRangeDate"] = $dateRangeDate;
            $whereArray[":dateRangeDateTo"] = $dateRangeDateTo;

            switch($searchFilter){
                case "serialNumberCheck":
                    //$whereTXT = 'nl.serial_number >= :serial_number';
                    $whereTXT .= " AND nl.serial_number LIKE :serialNumber";
                    $whereArray[':serial_number'] = '%'.trim($serialNumber).'%';
                    break;
                case "codeCheck":
                    $whereTXT .= ' AND nl.EventType = :code ';
                    $whereArray[':code'] = trim($code);
                    break;
                case "typeEventCheck":
                    $whereTXT .= ' AND nl.type_notification = :type_notification ';
                    $whereArray[':type_notification'] = trim($typeEvent);
                    break;
                case "receiverCheck":
                    $whereTXT .= ' AND nl.receiver = :receiver ';
                    //$receiver = mb_ereg_replace("(", "", $_POST['receiver']);
                    $tmp = trim($receiver);
//                    $tmp = preg_replace("/\s/","",$tmp);
//                    $tmp = preg_replace("/-/","",$tmp);
//                    $tmp = str_replace("(","",$tmp);
//                    $tmp = str_replace(")","",$tmp);
                    $whereArray[':receiver'] = '%'.$tmp.'%';
                    break;
                case "patientCheck":
                    $whereTXT .= ' AND p.id_patient = :id_patient ';
                    $whereArray[':id_patient'] = trim($patient);
                    break;
            }


            $sql = "SELECT SQL_CALC_FOUND_ROWS (0), nl.serial_number, nl.EventType, nl.type_notification, nl.receiver, nl.message_sent, nl.current_time, nl.response_message, nl.status_of_notification,
                            nl.device_description, CONCAT(p.first_name, ' ', p.last_name) AS patient
                    FROM {{notification_pendant_log}} nl
                    INNER JOIN {{pendant_devices}} d ON d.serial_number = nl.serial_number
                    INNER JOIN {{patients}} p ON p.id_patient = d.id_patient";
               /* ->select("SQL_CALC_FOUND_ROWS (0), nl.serial_number, nl.code, nl.type_notification, nl.receiver, nl.message_sent, nl.current_time, nl.response_message, nl.status_of_notification,
                            nl.device_description, r.nb_room ")
                ->from("mia_notification_log nl")
                ->join('{{devices}} d', 'd.serial_number = nl.serial_number')
                ->leftJoin('{{rooms}} r', 'r.id_room = d.id_room');
                */
            if (!empty($search)) {
                $whereTXT .= " AND ( nl.serial_number LIKE :searchText ";
                $whereTXT .= " OR nl.EventType LIKE :searchText";
                $whereTXT .= " OR nl.type_notification LIKE :searchText";
                $whereTXT .= " OR nl.receiver LIKE :searchText";
                $whereTXT .= " OR nl.message_sent LIKE :searchText";
                $whereTXT .= " OR nl.current_time LIKE :searchText";
                $whereTXT .= " OR nl.response_message LIKE :searchText";
                $whereTXT .= " OR nl.status_of_notification LIKE :searchText";
                $whereTXT .= " OR nl.device_description LIKE :searchText)";
                //$whereTXT .= " OR r.nb_room LIKE :searchText )";
                $whereArray[':searchText'] = "%".$search."%";

            }
            //print_r($whereArray);
            $offset = ($length > 0) ? " LIMIT $start,$length" : "";
            $orderBy = " ORDER BY ".$column[$order['column']].' '.$order['dir'];
            $logs = Yii::app()->db->createCommand($sql.' WHERE '.$whereTXT.$orderBy.$offset);
            //echo $sql.' WHERE '.$whereTXT.$orderBy.$offset;
            //echo $offset;
            //print_r($whereArray);exit;
//            foreach ($whereArray as $wk=>$wl){
//                $logs->bindParam($wk,$wl,PDO::PARAM_STR);
//            }
            //$logs->where($whereTXT, $whereArray);
            //$logs->order($column[$order['column']].' '.$order['dir']);
            //$logs->limit($length, $start);
            $resultArray = array();

            try {
                $resultArray = $logs->queryAll(true, $whereArray);
                //print_r($resultArray);
                $lengthResult = Yii::app()->db->createCommand('SELECT FOUND_ROWS()')->queryScalar();
                //echo $logs->order($column[$order['column']].' '.$order['dir'])->limit($length, $start)->getText();



            } catch (Exception $e) {
                $text = $logs->getText();
                Yii::log(CVarDumper::dumpAsString($text, 10),'error','app');

            }
            if (count($resultArray) > 0) {
                //echo $this->renderPartial('_events_log', array('model'=>$logs, 'listCallType'=>$list),true, false);
                $arr = array();
                //print_r($logs);
                //$lengthResult = count($logs);
                //array_push($arr, array('draw'=>$draw, 'recordsTotal' => $lengthResult, 'recordsFiltered' => $lengthResult));
                $arrPendantType = CHtml::listData(PendantType::model()->findAll(), 'script','description');
                $data = array();
                $end = ($length > $lengthResult) ? $lengthResult : $length;
                foreach ($resultArray as $kl) {
                    $eventType = (isset($kl['type_notification']) && !empty($kl['type_notification'])) ? Yii::app()->params['pick_event_type'][$kl['type_notification']] : "";
                    $callType = (isset($arrPendantType[$kl['EventType']]) && !empty($arrPendantType[$kl['EventType']])) ? $arrPendantType[$kl['EventType']] : $kl['EventType'];
                    $data[] = array(
                        $kl['current_time'],
                        $kl['device_description'],
                        $kl['patient'],
                        $kl['receiver'],
                        $kl['serial_number'],
                        $callType,
                        $eventType
                    );
                }
                header('Content-Type: application/json');
                echo json_encode(array('draw'=>$draw, 'recordsTotal' => $lengthResult, 'recordsFiltered' => $lengthResult, 'data' => $data));

            } else {
                $data = array();
                header('Content-Type: application/json');
                echo json_encode(array('draw'=>$draw, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => $data));
            }

//             {
//                $logs = Yii::app()->db->createCommand()->setFetchMode(PDO::FETCH_ASSOC)
//                    ->select("SQL_CALC_FOUND_ROWS (0), nl.serial_number, nl.code, nl.type_notification, nl.receiver, nl.message_sent, nl.current_time, nl.response_message, nl.status_of_notification,
//                                nl.device_description, r.nb_room ")
//                    ->from("mia_notification_log nl")
//                    ->join('{{devices}} d', 'd.serial_number = nl.serial_number')
//                    ->leftJoin('{{rooms}} r', 'r.id_room = d.id_room');
//
//                $logs->where($whereArray);
//                if (!empty($search)) {
//                    $whereTXT = "nl.serial_number LIKE :searchText";
//                    $condition[] = "nl.code LIKE :searchText";
//                    $condition[] = "nl.type_notification LIKE :searchText";
//                    $condition[] = "nl.receiver LIKE :searchText";
//                    $condition[] = "nl.message_sent LIKE :searchText";
//                    $condition[] = "nl.current_time LIKE :searchText";
//                    $condition[] = "nl.response_message LIKE :searchText";
//                    $condition[] = "nl.status_of_notification LIKE :searchText";
//                    $condition[] = "nl.device_description LIKE :searchText";
//                    $condition[] = "r.nb_room LIKE :searchText";
//                    $cond_arg[':searchText'] = $search;
//                    $logs->where(array('AND', implode(' OR ', $condition)), $cond_arg);
//                }
//                $logs->order($column[$order['column']].' '.$order['dir']);
//                $logs->limit($length, $start);
//
//                $resultArray = $logs->queryAll();
//                $lengthResult = Yii::app()->db->createCommand('SELECT FOUND_ROWS()')->queryScalar();
//            }
            //print_r($logs);

        }
    }

    public function actionReportPdf($searchData){
        $searchFilter = $daterange = $daterangeTo = $serialNumber = $typeEvent = $receiver = $code = "";
        $decodedData = base64_decode($searchData);
        //echo urldecode($decodedData);
        $arrayFromSearch = explode("&",$decodedData);
        foreach ($arrayFromSearch as $k){
            $tmp = explode('=', $k);
            $$tmp[0]=urldecode($tmp[1]);
        }
        $arrayOfModelsCallTypes = CallsType::model()->findAll();
        $list = CHtml::listData($arrayOfModelsCallTypes, 'script','description' );

        if(isset($searchFilter) && !empty($searchFilter)){

            $whereTXT = "";
            $whereArray = array();
            switch($searchFilter){
                case "daterange":
                    $whereArray = array('and', "nl.current_time >= '".$daterange."'", "nl.current_time <= '".$daterangeTo."'");
                    break;
                case "serialNumberCheck":
                    $whereTXT = "";
                    $whereArray =  array('like','nl.serial_number', '%'.trim($serialNumber).'%');
                    break;
                case "codeCheck":
                    $whereTXT = 'nl.EventType = :code';
                    $whereArray =  array(':code'=>$code);
                    break;
                case "typeEventCheck":
                    $whereTXT = 'nl.type_notification = :type_notification';
                    $whereArray =  array(':type_notification'=>$typeEvent);
                    break;
                case "receiverCheck":
                    $whereTXT = '';
                    $tmp = $_POST['receiver'];
//                    $tmp = preg_replace("/\s/","",$tmp);
//                    $tmp = preg_replace("/-/","",$tmp);
//                    $tmp = str_replace("(","",$tmp);
//                    $tmp = str_replace(")","",$tmp);
                    $whereArray =  array('like','nl.receiver', '%'.$tmp.'%');
                    break;
            }
            if ($whereTXT != '') {
                $logs = Yii::app()->db->createCommand()
                    ->select("nl.serial_number, nl.EventType, nl.type_notification, nl.receiver, nl.message_sent, nl.current_time, nl.response_message, nl.status_of_notification,
                                nl.device_description ")
                    ->from("{{notification_pendant_log}} nl")
                    ->join('{{pendant_devices}} d', 'd.serial_number = nl.serial_number')
                    //->leftJoin('{{rooms}} r', 'r.id_room = d.id_room')
                    ->where($whereTXT, $whereArray)
                    ->order('nl.current_time desc')
                    ->queryAll();
            } else {
                $logs = Yii::app()->db->createCommand()
                    ->select("nl.serial_number, nl.EventType, nl.type_notification, nl.receiver, nl.message_sent, nl.current_time, nl.response_message, nl.status_of_notification,
                                nl.device_description ")
                    ->from("{{notification_pendant_log}} nl")
                    ->join('{{pendant_devices}} d', 'd.serial_number = nl.serial_number')
                    //->leftJoin('{{rooms}} r', 'r.id_room = d.id_room')
                    ->where($whereArray)
                    ->order('nl.current_time desc')
                    ->queryAll();
            }
            if (count($logs) > 0) {
                $html2pdf = Yii::app()->ePdf->HTML2PDF('P','Letter', 'en');
                $html2pdf->WriteHTML($this->renderPartial('_events_log', array('model'=>$logs, 'listCallType'=>$list),true));
                return $html2pdf->Output('', 'D');
                //echo $this->renderPartial('_events_log', array('model'=>$logs),true, false);
            } else {
                echo "<div id='needInfo'><center>".Yii::t("admin/patients","No Data")."</center></div>";
            }
        }
    }
    public function actionReportExcel($searchData, $format = 'excel5'){
        $searchFilter = $daterange = $daterangeTo = $serialNumber = $typeEvent = $receiver = $code = $patient = "";
        $decodedData = base64_decode($searchData);
        $arrayFromSearch = explode("&",$decodedData);
        //print_r($arrayFromSearch);
        foreach ($arrayFromSearch as $k){
            $tmp = explode('=', $k);
            $$tmp[0]=urldecode($tmp[1]);
        }
        $arrayOfModelsCallTypes = PendantType::model()->findAll();
        $list = CHtml::listData($arrayOfModelsCallTypes, 'script','description' );
        $searchFilter = (isset($searchFilter) && !empty($searchFilter)) ? $searchFilter : 'datarange';

        if(isset($searchFilter) && !empty($searchFilter)){

            $dateRangeDate = urldecode($daterange).":00";
            $dateRangeDateTo = urldecode($daterangeTo).':00';
            $whereTXT = " nl.current_time >= :dateRangeDate AND nl.current_time <= :dateRangeDateTo ";
            $whereArray[":dateRangeDate"] = $dateRangeDate;
            $whereArray[":dateRangeDateTo"] = $dateRangeDateTo;
            $typeCriteria = "Data Range";
            $searchValue = $dateRangeDate." - ".$dateRangeDateTo;
            switch($searchFilter){
                case "serialNumberCheck":
                    //$whereTXT = 'nl.serial_number >= :serial_number';
                    $typeCriteria = "Serial Number";
                    $searchValue = trim($serialNumber);
                    $whereTXT .= " AND nl.serial_number LIKE :serialNumber";
                    $whereArray[':serial_number'] = '%'.trim($serialNumber).'%';
                    break;
                case "codeCheck":
                    $typeCriteria = "Code";
                    $searchValue = trim($code);
                    $whereTXT .= ' AND nl.EventType = :code';
                    $whereArray[':code'] = trim($code);
                    break;
                case "typeEventCheck":
                    $typeCriteria = "Event Type";
                    $searchValue = trim($typeEvent);
                    $whereTXT .= ' AND nl.type_notification = :type_notification';
                    $whereArray[':type_notification'] = trim($typeEvent);
                    break;
                case "receiverCheck":
                    $typeCriteria = "Receiver";

                    $whereTXT .= ' AND nl.receiver = :receiver';
                    $tmp = trim($receiver);

                    $whereArray[':receiver'] = '%'.$tmp.'%';
                    $searchValue = $tmp;
                    break;
                case "patientCheck":
                    $whereTXT .= ' AND p.id_patient = :id_patient ';
                    $whereArray[':id_patient'] = trim($patient);
                    $typeCriteria = "Receiver";
                    $patientInfo = Patients::model()->findByPk($patient);
                    $searchValue = $patientInfo->first_name.' '.$patientInfo->last_name;
                    break;
            }
            $sql = "SELECT nl.serial_number, nl.EventType, nl.type_notification, nl.receiver, nl.message_sent, nl.current_time, nl.response_message, nl.status_of_notification,
                            nl.device_description, CONCAT(p.first_name, ' ', p.last_name) AS patient
                    FROM {{notification_pendant_log}} nl
                    INNER JOIN {{pendant_devices}} d ON d.serial_number = nl.serial_number
                    INNER JOIN {{patients}} p ON p.id_patient = d.id_patient";

            if (!empty($search)) {
                $whereTXT .= " AND ( nl.serial_number LIKE :searchText ";
                $whereTXT .= " OR nl.EventType LIKE :searchText";
                $whereTXT .= " OR nl.type_notification LIKE :searchText";
                $whereTXT .= " OR nl.receiver LIKE :searchText";
                $whereTXT .= " OR nl.message_sent LIKE :searchText";
                $whereTXT .= " OR nl.current_time LIKE :searchText";
                $whereTXT .= " OR nl.response_message LIKE :searchText";
                $whereTXT .= " OR nl.status_of_notification LIKE :searchText";
                $whereTXT .= " OR nl.device_description LIKE :searchText)";
                $whereArray[':searchText'] = "%".$search."%";

            }
            $orderBy = " ORDER BY current_time DESC ";
            $lg = Yii::app()->db->createCommand($sql.' WHERE '.$whereTXT.$orderBy);
            $logs = $lg->queryAll(true, $whereArray);
            //print_r($logs);
            if (count($logs) > 0) {
                $report = new YiiReport(array('template' => 'eventpendantreport.xls'));
                $callTypeModels = PendantType::model()->findAll();
                $callTypeArray = array();
                foreach ($callTypeModels as $l) {
                    $callTypeArray[$l->script] = $l->description;
                }

                foreach ($logs as $k =>$m) {
                    $logs[$k]['code'] = $callTypeArray[$m['EventType']];
                    $logs[$k]['type_notification'] = Yii::app()->params['pick_event_type'][$m['type_notification']];
                }

                $report->load(array(
                        array(
                            'id' => 'ong',
                            'data' => array(
                                'typeCriteria' => $typeCriteria,
                                'date' => date('d-m-Y H:i'),
                                'searchValue' => $searchValue
                            )
                        ),
                        array(
                            'id' => 'rep',
                            'repeat' => TRUE,
                            'data' => $logs,
                            'minRows' => 1
                        ),

                    )
                );

                //echo $report->render('excel5');
                echo $report->render($format);
                //echo $this->renderPartial('_events_log', array('model'=>$logs),true, false);
            } else {
                echo "<div id='needInfo'><center>".Yii::t("admin/patients","No Data")."</center></div>";
            }
        }
    }

    public function actionReportSearchChart(){
        $searchFilter = $daterange = $daterangeTo = $serialNumber = $code = $typeEvent = $receiver = $patient = "";
        $lstPost = explode("&", urldecode($_POST['allData']));
        foreach ($lstPost as $l) {
            $tmp = explode("=", $l);
            $$tmp[0] = $tmp[1];
        }
        $start = (isset($_POST['start']) && !empty($_POST['start'])) ? trim($_POST['start']) : 0;
        $length = (isset($_POST['length']) && !empty($_POST['length'])) ? trim($_POST['length']) : 25;
        $search = (isset($_POST['search']['value']) && !empty($_POST['search']['value'])) ? trim($_POST['search']['value']) : "";
        $draw = (isset($_POST['draw']) && !empty($_POST['draw'])) ? trim($_POST['draw']) : 0;
        $order = (isset($_POST['order'])) ? $_POST['order'][0] : array('column' => 0, 'dir' => 'desc');
        $column = array("nl.current_time", "nl.device_description", "r.nb_room", "nl.receiver", "nl.serial_number", "nl.code", "nl.type_notification");


        if(isset($_POST) && !empty($_POST['allData'])){
            $arrayOfModelsCallTypes = CallsType::model()->findAll();
            $list = CHtml::listData($arrayOfModelsCallTypes, 'script','description' );

            $dateRangeDate = urldecode($daterange).":00";
            $dateRangeDateTo = urldecode($daterangeTo).':00';
            $whereTXT = " nl.current_time >= :dateRangeDate AND nl.current_time <= :dateRangeDateTo ";
            $whereArray[":dateRangeDate"] = $dateRangeDate;
            $whereArray[":dateRangeDateTo"] = $dateRangeDateTo;

            switch($searchFilter){
                case "serialNumberCheck":
                    //$whereTXT = 'nl.serial_number >= :serial_number';
                    $whereTXT .= " AND nl.serial_number LIKE :serialNumber";
                    $whereArray[':serial_number'] = '%'.trim($serialNumber).'%';
                    break;
                case "codeCheck":
                    $whereTXT .= ' AND nl.EventType = :code ';
                    $whereArray[':code'] = trim($code);
                    break;
                case "typeEventCheck":
                    $whereTXT .= ' AND nl.type_notification = :type_notification ';
                    $whereArray[':type_notification'] = trim($typeEvent);
                    break;
                case "receiverCheck":
                    $whereTXT .= ' AND nl.receiver = :receiver ';
                    //$receiver = mb_ereg_replace("(", "", $_POST['receiver']);
                    $tmp = trim($receiver);
//                    $tmp = preg_replace("/\s/","",$tmp);
//                    $tmp = preg_replace("/-/","",$tmp);
//                    $tmp = str_replace("(","",$tmp);
//                    $tmp = str_replace(")","",$tmp);
                    $whereArray[':receiver'] = '%'.$tmp.'%';
                    break;
                case "patientCheck":
                    $whereTXT .= ' AND p.id_patient = :id_patient ';
                    $whereArray[':id_patient'] = trim($patient);
                    break;
            }


            $sql = "SELECT SUM(IF(type_notification = 'SMS',1,0)) AS csms,
                      SUM(IF(type_notification = 'EMAIL',1,0)) AS cemail,
                      SUM(IF(type_notification = 'VOIP',1,0)) AS cvoip,
                      SUM(IF(type_notification = 'TRANSFER',1,0)) AS ctransfer,
                      SUM(IF(type_notification = 'CAMERA',1,0)) AS ccamera,
                      SUM(IF(type_notification = 'IOPOS',1,0)) AS ciopos
                    FROM {{notification_pendant_log}} nl
                    INNER JOIN {{pendant_devices}} d ON d.serial_number = nl.serial_number
                    INNER JOIN {{patients}} p ON p.id_patient = d.id_patient";
            /* ->select("SQL_CALC_FOUND_ROWS (0), nl.serial_number, nl.code, nl.type_notification, nl.receiver, nl.message_sent, nl.current_time, nl.response_message, nl.status_of_notification,
                         nl.device_description, r.nb_room ")
             ->from("mia_notification_log nl")
             ->join('{{devices}} d', 'd.serial_number = nl.serial_number')
             ->leftJoin('{{rooms}} r', 'r.id_room = d.id_room');
             */
            if (!empty($search)) {
                $whereTXT .= " AND ( nl.serial_number LIKE :searchText ";
                $whereTXT .= " OR nl.EventType LIKE :searchText";
                $whereTXT .= " OR nl.type_notification LIKE :searchText";
                $whereTXT .= " OR nl.receiver LIKE :searchText";
                $whereTXT .= " OR nl.message_sent LIKE :searchText";
                $whereTXT .= " OR nl.current_time LIKE :searchText";
                $whereTXT .= " OR nl.response_message LIKE :searchText";
                $whereTXT .= " OR nl.status_of_notification LIKE :searchText";
                $whereTXT .= " OR nl.device_description LIKE :searchText)";
                //$whereTXT .= " OR r.nb_room LIKE :searchText )";
                $whereArray[':searchText'] = "%".$search."%";

            }
            //print_r($whereArray);
            $logs = Yii::app()->db->createCommand($sql.' WHERE '.$whereTXT);
            //echo $sql.' WHERE '.$whereTXT.$orderBy.$offset;
            //echo $offset;
            //print_r($whereArray);exit;
//            foreach ($whereArray as $wk=>$wl){
//                $logs->bindParam($wk,$wl,PDO::PARAM_STR);
//            }
            //$logs->where($whereTXT, $whereArray);
            //$logs->order($column[$order['column']].' '.$order['dir']);
            //$logs->limit($length, $start);
            $resultArray = array();

            try {
                $resultArray = $logs->queryRow(true, $whereArray);
            } catch (Exception $e) {
                $text = $logs->getText();
                Yii::log(CVarDumper::dumpAsString($text, 10),'error','app');

            }
            if (count($resultArray) > 0) {
                $jsonArray[] = array(
                    'name' => 'Notification Activity',
                    'data' =>  array(
                        array('SMS',(int)$resultArray['csms']),
                        array('E-Mail',(int)$resultArray['cemail']),
                        array('VoIP',(int)$resultArray['cvoip']),
                        array('Transfer Call',(int)$resultArray['ctransfer']),
                        array('Camera',(int)$resultArray['ccamera']),
                        array('I/O Command',(int)$resultArray['ciopos'])
                    ),
                    'dataLabels' => array(
                        'enabled' => 'true',
                        'rotation' => '0',
                        'color' => '#000',
                        'align' => 'right',
                        'format' => '{point.y:.0f}', // one decimal
                        'y' => '20', // 10 pixels down from the top
                        'style' => array(
                            'fontSize' => '13px',
                            'fontFamily' => 'Verdana, sans-serif'
                        )
                    )
                );
                echo CJSON::encode($jsonArray);
                Yii::app()->end();
            } else {
                echo CJSON::encode(array());
                Yii::app()->end();
            }
        }
    }
}