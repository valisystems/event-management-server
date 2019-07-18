<?php

class ReportsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
    public $layout = '/layouts/column1';
    
    public function init(){
        parent::init();
        $cs = Yii::app()->clientScript; //d3.min.js
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/highcharts/highcharts.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/highcharts/modules/exporting.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/reports.js', CClientScript::POS_END);
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
		$this->render('index');
	}

    public function actionCodeGraph(){
        if(Yii::app()->request->isAjaxRequest){
            $nb_day = (isset($_POST['nb_day'])) ? $_POST['nb_day'] : 1;
            $logs = Yii::app()->db->createCommand()
                ->select('nl.code, nl.type_notification, nl.current_time, nl.status_of_notification')
                ->from('{{notification_log}} nl')
                ->join('{{calls_type}} ct', 'nl.code = ct.script')
                //->where('DATE(nl.current_time) = DATE(NOW())')
                ->where('nl.current_time BETWEEN NOW() - INTERVAL '.$nb_day.' DAY AND NOW()')
                ->queryAll();
            /*$logs2 = Yii::app()->db->createCommand()
                ->select('nl.code, nl.type_notification, nl.current_time, nl.status_of_notification')
                ->from('{{notification_log}} nl')
                ->join('{{calls_type}} ct', 'nl.code = ct.script')
                ->where('DATE(nl.current_time) = DATE(NOW())')->text;*/
            //print_r($logs2);    
            if (count($logs)) {
                $jsonArray = array();
                $logsCounter = array();
                $listCode = array();
                $jsonArray['category'] = array();
                foreach ($logs as $k) {
                    if (!in_array($k['code'], $jsonArray['category'])) {
                       array_push($jsonArray['category'], $k['code']);
                    }
                    if ($k['status_of_notification'] == '1') {
                        if (isset($logsCounter[$k['code']]['success'])) 
                            $logsCounter[$k['code']]['success']++;
                        else
                            $logsCounter[$k['code']]['success'] = 1;
                    } else if ($k['status_of_notification'] == '0') {
                        if (isset($logsCounter[$k['code']]['fail'])) 
                            $logsCounter[$k['code']]['fail']++;
                        else
                            $logsCounter[$k['code']]['fail'] = 1;
                    }
                }
                /*$tmpArraySuccess = $tmpArrayFail = array();
                foreach ($logsCounter as $kcode => $vcount) {
                    $tmpArraySuccess['data'][]  = array( 'y'=> $vcount['success'], 'x' => $kcode.' Success');
                    $tmpArrayFail['data'][]     = array( 'y'=> $vcount['fail'], 'x' => $kcode. ' Fail');
                }
                
                $jsonArray['main'][] = $tmpArraySuccess;
                $jsonArray['main'][] = $tmpArrayFail;*/
                $callType =  CHtml::listData(CallsType::model()->findAll(), 'script', 'description');
                //Yii::log(CVarDumper::dumpAsString("Template ".print_r($callType, true), 10),'error','app');

                foreach ($jsonArray['category'] as $v) {
                    $tmpArraySuccess[] = (isset($logsCounter[$v]['success']) && count($logsCounter[$v]['success'])) ? $logsCounter[$v]['success'] : 0;
                    $tmpArrayFail[] = (isset($logsCounter[$v]['fail']) && count($logsCounter[$v]['fail'])) ? $logsCounter[$v]['fail'] : 0;
                }
                foreach ($jsonArray['category'] as $k=>$v) {
                    $jsonArray['category'][$k] = (isset($callType[$v]) && !empty($callType[$v])) ? $callType[$v] : $v;
                    //$tmpArraySuccess[] = (isset($logsCounter[$v]['success']) && count($logsCounter[$v]['success'])) ? $logsCounter[$v]['success'] : 0;
                    //$tmpArrayFail[] = (isset($logsCounter[$v]['fail']) && count($logsCounter[$v]['fail'])) ? $logsCounter[$v]['fail'] : 0;
                }
                $jsonArray['series'][] = array(
                    'name' => 'Success',
                    'data' => $tmpArraySuccess
                );
                $jsonArray['series'][] = array(
                    'name' => 'Fail',
                    'data' => $tmpArrayFail
                );
                //Yii::log(CVarDumper::dumpAsString(print_r($jsonArray['category'], true), 10),'error','app');
                echo CJSON::encode($jsonArray);
            } else {
                echo CJSON::encode(array('series'=>array(),'category'=>array()));
            }
            Yii::app()->end();
        } else {
            echo CJSON::encode(array('series'=>array(),'category'=>array()));
            Yii::app()->end();
        }
        
    }

    public function actionNotificationGraph()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $nb_day = (isset($_POST['nb_day'])) ? $_POST['nb_day'] : 1;

            $sqlNotification = "SELECT SUM(IF(type_notification = 'SMS',1,0)) AS csms,
                      SUM(IF(type_notification = 'EMAIL',1,0)) AS cemail,
                      SUM(IF(type_notification = 'VOIP',1,0)) AS cvoip,
                      SUM(IF(type_notification = 'TRANSFER',1,0)) AS ctransfer,
                      SUM(IF(type_notification = 'CAMERA',1,0)) AS ccamera,
                      SUM(IF(type_notification = 'IOPOS',1,0)) AS ciopos
                    FROM {{notification_log}} nl
                    INNER JOIN {{devices}} d ON d.serial_number = nl.serial_number
                    LEFT JOIN {{rooms}} r ON r.id_room = d.id_room
                    WHERE nl.current_time BETWEEN NOW() - INTERVAL {$nb_day} DAY AND NOW()";

            $logs = Yii::app()->db->createCommand($sqlNotification)->queryRow();
            //$text = Yii::app()->db->createCommand($sqlNotification)->where('nl.current_time >= CURDATE() -'.$nb_day)->getText();
            //Yii::log(CVarDumper::dumpAsString($text, 10),'error','app');

            $sqlPendant = "SELECT SUM(IF(type_notification = 'SMS',1,0)) AS csms,
                      SUM(IF(type_notification = 'EMAIL',1,0)) AS cemail,
                      SUM(IF(type_notification = 'VOIP',1,0)) AS cvoip,
                      SUM(IF(type_notification = 'TRANSFER',1,0)) AS ctransfer,
                      SUM(IF(type_notification = 'CAMERA',1,0)) AS ccamera,
                      SUM(IF(type_notification = 'IOPOS',1,0)) AS ciopos
                    FROM {{notification_pendant_log}} nl
                    INNER JOIN {{pendant_devices}} d ON d.serial_number = nl.serial_number
                    INNER JOIN {{patients}} p ON p.id_patient = d.id_patient
                    WHERE nl.current_time BETWEEN NOW() - INTERVAL {$nb_day} DAY AND NOW()";

            $logsPendant = Yii::app()->db->createCommand($sqlPendant)->queryRow();


            $sqlMaxivox = "SELECT SUM(IF(type_notification = 'SMS',1,0)) AS csms,
                      SUM(IF(type_notification = 'EMAIL',1,0)) AS cemail,
                      SUM(IF(type_notification = 'VOIP',1,0)) AS cvoip,
                      SUM(IF(type_notification = 'TRANSFER',1,0)) AS ctransfer,
                      SUM(IF(type_notification = 'CAMERA',1,0)) AS ccamera,
                      SUM(IF(type_notification = 'IOPOS',1,0)) AS ciopos
                    FROM {{notification_maxivox_log}} nl
                    INNER JOIN {{maxivox_device}} d ON d.dev_address = nl.maxivox_address
                    LEFT JOIN {{patients}} p ON p.id_patient = d.id_patient
                    WHERE nl.current_time BETWEEN NOW() - INTERVAL {$nb_day} DAY AND NOW()";

            $logsMaxiVox = Yii::app()->db->createCommand($sqlMaxivox)->queryRow();

            $jsonArray['category'] = array('SMS','E-Mail','VoIP','Transfer Call','Camera','I/O Command');
            $jsonArray['series'][] = array(
                'name' => 'EMS Notification',
                'data' => array((int)$logs['csms'], (int)$logs['cemail'], (int)$logs['cvoip'], (int)$logs['ctransfer'], (int)$logs['ccamera'], (int)$logs['ciopos'])
            );
            $jsonArray['series'][] = array(
                'name' => 'Pendant Notification',
                'data' => array((int)$logsPendant['csms'], (int)$logsPendant['cemail'], (int)$logsPendant['cvoip'], (int)$logsPendant['ctransfer'], (int)$logsPendant['ccamera'], (int)$logsPendant['ciopos'])
            );
            $jsonArray['series'][] = array(
                'name' => 'MaxiVox Notification',
                'data' => array((int)$logsMaxiVox['csms'], (int)$logsMaxiVox['cemail'], (int)$logsMaxiVox['cvoip'], (int)$logsMaxiVox['ctransfer'], $logsMaxiVox['ccamera'], (int)$logsMaxiVox['ciopos'])
            );

            //Yii::log(CVarDumper::dumpAsString(print_r($jsonArray['category'], true), 10),'error','app');
            echo CJSON::encode($jsonArray);
            Yii::app()->end();
        } else {
            echo CJSON::encode(array('series'=>array(),'category'=>array()));
            Yii::app()->end();
        }
    }
}