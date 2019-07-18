<?php

class DefaultController extends Controller
{
	public $layout = '/layouts/column1';
	public $menu=array();
    public $iura = "";
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
    public function init(){
        parent::init();
        $cs = Yii::app()->clientScript; //d3.min.js
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/highcharts/highcharts.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/highcharts/highcharts-3d.js', CClientScript::POS_END);
        //$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/highcharts/highcharts-more.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/index.js', CClientScript::POS_END);


        /*<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/style.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/retina.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/bootstrap-toggle.min.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/mialert.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/print.css" rel="stylesheet" type="text/css" media="print"/>
*/
        //$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/highcharts/modules/exporting.js', CClientScript::POS_END);
    }
    
    public function actionIndex()
	{
		$this->render('index');
	}
    
    /**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
    /**
	 * Displays the system page
	 */
	/*public function actionSetting()
	{
	   //$model=new SystemForm;
       
       // display the system form
        //$this->render('system',array('model'=>$model));
        //$this->render('setting');
	}
    */
    
    public function actionGeneralInfo(){
        
        $arr = array();
         if (Yii::app()->request->isAjaxRequest) {
            $sql = "SELECT COUNT(id_room) AS nbRoom, SUM(nb_of_seats) AS nbSeats FROM {{rooms}}";
            $roomsInfo = Yii::app()->db->createCommand($sql)->queryRow();

            $sql = "SELECT COUNT(*) FROM {{patients}}";
            $numPatients = Yii::app()->db->createCommand($sql)->queryScalar();

            $numDevices = Yii::app()->db->createCommand('SELECT count(id_device) FROM mia_devices')->queryScalar();
            $sqlEvents = "SELECT sum(IF(type_notification = 'email', 1, 0)) AS emalCount,
                          sum(IF(type_notification = 'sms', 1, 0)) AS smsCount,
                          sum(IF(type_notification = 'voip', 1, 0)) AS voipCount,
                          sum(IF(type_notification = 'TRANSFER', 1, 0)) AS transCount
                          FROM {{notification_log}}";
            $eventsLog = Yii::app()->db->createCommand($sqlEvents)->queryRow();
            $arr['nbRooms'] = (isset($roomsInfo['nbRoom']) && !empty($roomsInfo['nbRoom'])) ? $roomsInfo['nbRoom'] : 0;
            $arr['nbOfSeats'] = (isset($roomsInfo['nbSeats']) && !empty($roomsInfo['nbSeats'])) ? $roomsInfo['nbSeats'] : 0;
            $arr['nbPatients'] = (isset($numPatients) && !empty($numPatients)) ? $numPatients : 0;
            $arr['smsEvent'] = (isset($roomsInfo['smsCount']) && !empty($roomsInfo['smsCount'])) ? $eventsLog['smsCount'] : 0;
            $arr['emailEvent'] = (isset($roomsInfo['emalCount']) && !empty($roomsInfo['emalCount'])) ? $eventsLog['emalCount'] : 0;
            $arr['voipEvent'] = (isset($roomsInfo['voipCount']) && !empty($roomsInfo['voipCount'])) ? $eventsLog['voipCount'] : 0;
            $arr['transCount'] = (isset($roomsInfo['transCount']) && !empty($roomsInfo['transCount'])) ? $eventsLog['transCount'] : 0;
            $arr['activeCalls'] = (isset($numDevices) && !empty($numDevices)) ? $numDevices : 0;
            $arr['responseTimes'] = rand(0, 60);

            $sqlDuration = "select sum(billsec) as duration FROM cdr";
            $totalDurationSec = 0;//Yii::app()->dbcdr->createCommand($sqlDuration)->queryScalar();
            $totalPositioningEvents = Yii::app()->db->createCommand('SELECT COUNT(id_log) FROM {{notification_pendant_log}}')->queryScalar();
             $curTime = date('Y-m-d H:i:s');
             $lastTime = date('Y-m-d H:i:s', mktime(date('H'), 0, 0, date('m') -1, date('d'), date('Y')));
             //echo $lastTime .'-'.$curTime;
             $sqlEvents = "SELECT sum(billsec)  FROM cdr
                                  WHERE disposition IN ('ANSWERED', 'BUSY', 'NO ANSWER') AND
                                  calldate BETWEEN '{$lastTime}' AND '{$curTime}' ORDER BY calldate ASC";
            $callTimeLastMonth = 0;//Yii::app()->dbcdr->createCommand($sqlEvents)->queryScalar();
            $totalDurationSecLastMonth = (!empty($callTimeLastMonth)) ? $callTimeLastMonth : 0;
            $arr['callTimes'] = ceil($totalDurationSec/60);
            $arr['callTimesLastMonth'] = ceil($totalDurationSecLastMonth/60);
            $arr['totalPositioningEvents'] = $totalPositioningEvents;
         }
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
    
    public function actionCallActivity(){
        $jsonArray = array();
        //ini_set('memory_limit', '-1');

        if (Yii::app()->request->isAjaxRequest) {
            $nb_day = (isset($_POST['nb_day'])) ? $_POST['nb_day'] : 1;
            //date_default_timezone_set('UTC');
            switch($nb_day) {
                case 1:
                    $day = date('d');
                    $month = date('m');
                    $year = date('Y');
                    $hour = date('H');
                    $callAnswered = $callMissed = $callHolded = $pentruMine = array();

                    $curTime = date('Y-m-d H:i:s', mktime($hour, 0, 0, $month, $day, $year));
                    $lastTime = date('Y-m-d H:i:s', mktime($hour, 0, 0, $month, $day-1, $year));
                    //echo $lastTime .'-'.$curTime;
                    $sqlEvents = "SELECT calldate, disposition  FROM cdr
                                  WHERE disposition IN ('ANSWERED', 'BUSY', 'NO ANSWER') AND
                                  calldate BETWEEN '{$lastTime}' AND '{$curTime}' ORDER BY calldate ASC";

                    //echo $sqlEvents;
                    $sqlEventsSum = "SELECT SUM(IF(disposition = 'ANSWERED',1,0)) AS canswered, SUM(IF(disposition = 'BUSY',1,0)) AS cbusy, SUM(IF(disposition = 'NO ANSWER',1,0)) AS cnoanswer  FROM cdr
                                      WHERE disposition IN ('ANSWERED', 'BUSY', 'NO ANSWER') AND
                                      calldate BETWEEN '{$lastTime}' AND '{$curTime}' ORDER BY calldate ASC";
                    $result = Yii::app()->dbcdr->createCommand($sqlEvents)->queryAll();
                    $resultSum = Yii::app()->dbcdr->createCommand($sqlEventsSum)->queryAll();

                    foreach ($result as $k) {
                        $data_search = substr($k['calldate'], 0, 13);

                        $pentruMine[$k['disposition']][$data_search] = (isset($pentruMine[$k['disposition']][$data_search])) ? ($pentruMine[$k['disposition']][$data_search]+1) : 1;
                    }

                    foreach ($resultSum as $lm) {

                    }
                    //print_r($pentruMine);
                    foreach ($pentruMine as $kl => $lw) {
                        if (isset($kl) && (trim($kl) == 'ANSWERED') && count($lw) > 0 ) {
                            foreach ($lw as $ld => $lm) {
                                list($year, $month, $day) = explode("-", substr($ld, 0,10));
                                $hour = substr($ld, -2);
                                $curTime = mktime($hour, 0, 0, $month, $day, $year) * 1000;
                                $callAnswered[] = array($curTime, $lm);
                            }
                        }
                        if (isset($kl) && (trim($kl) == 'BUSY') && count($lw) > 0 ) {
                            foreach ($lw as $ld => $lm) {
                                list($year, $month, $day) = explode("-", substr($ld, 0,10));
                                $hour = substr($ld, -2);
                                $curTime = mktime($hour, 0, 0, $month, $day, $year) * 1000;
                                $callMissed[] = array($curTime, $lm);
                            }
                        }
                        if (isset($kl) && ($kl == 'NO ANSWER') && count($lw) > 0 ) {
                            foreach ($lw as $ld => $lm) {
                                list($year, $month, $day) = explode("-", substr($ld, 0,10));
                                $hour = substr($ld, -2);
                                $curTime = mktime($hour, 0, 0, $month, $day, $year) * 1000;
                                $callHolded[] = array($curTime, $lm);
                            }
                        }
                    }
                    //print_r($callAnswered);
                    /*for ($h = 0; $h < 24; $h++){
                        $curTime = mktime($h, 0, 0, $month, $day, $year)*1000;
                        $callAnswered[] = array($curTime, rand(0, 30));
                        $callMissed[] = array($curTime, rand(0, 30));
                        $callHolded[] = array($curTime, rand(0, 30));
                        $pentruMine[] = date('Y-m-d H:i:s', mktime($h, 0, 0, $month, $day, $year));
                    }*/
                    //print_r($callAnswered);
                    $jsonArray['series'][] = array(
                                        'name'=>'Answered',
                                        'data'=>$callAnswered,
                                        'pointStart'=> mktime(0, 0, 0, $month, $day, $year)*1000,
                                        'pointInterval'=> 24 * 3600 * 1000 // one day
                                    );
                    $jsonArray['series'][] = array(
                                        'name'=>'Busy',
                                        'data'=>$callMissed,
                                        'pointStart'=> mktime(0, 0, 0, $month, $day, $year)*1000,
                                        'pointInterval'=> 24 * 3600 * 1000 // one day
                                    );
                    $jsonArray['series'][] = array(
                                        'name'=>'No Answer',
                                        'data'=>$callHolded,
                                        'pointStart'=> mktime(0, 0, 0, $month, $day, $year)*1000,
                                        'pointInterval'=> 24 * 3600 * 1000 // one day
                                    );
                    break;
                case 7:
                    $currNumberOfDay = date('w');
                    if ($currNumberOfDay > 0) {
                        $startDateWeek = explode( '-',date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-($currNumberOfDay-1), date('Y'))));
                        $endDateWeek = explode( '-',date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')+(7 - $currNumberOfDay), date('Y'))));
                    } else {
                        $startDateWeek = explode( '-', date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-7, date('Y'))));
                        $endDateWeek = explode( '-',date('Y-m-d', mktime(0, 0, 0, date('m'),date('d'), date('Y'))));
                    }
                    $day = date('d');
                    $month = date('m');
                    $year = date('Y');
                    $hour = date('H');
                    $callAnswered = $callMissed = $callHolded = $pentruMine = array();

                    $curTime = date('Y-m-d H:i:s', mktime($hour, 0, 0, $month, $day, $year));
                    $lastTime = date('Y-m-d H:i:s', mktime($hour, 0, 0, $month, $day-7, $year));
                    $sqlEvents = "SELECT calldate, disposition  FROM cdr
                                  WHERE disposition IN ('ANSWERED', 'BUSY', 'NO ANSWER') AND
                                  calldate BETWEEN '{$lastTime}' AND '{$curTime}' ORDER BY calldate ASC";

                    //echo $sqlEvents;
                    $result = Yii::app()->dbcdr->createCommand($sqlEvents)->queryAll();

                    foreach ($result as $k) {
                        $data_search = substr($k['calldate'], 0, 13);

                        $pentruMine[$k['disposition']][$data_search] = (isset($pentruMine[$k['disposition']][$data_search])) ? ($pentruMine[$k['disposition']][$data_search]+1) : 1;
                    }
                    //print_r($pentruMine);
                    foreach ($pentruMine as $kl => $lw) {
                        if (isset($kl) && ($kl == 'ANSWERED') && count($lw) > 0 ) {
                            foreach ($lw as $ld => $lm) {
                                list($year, $month, $day) = explode("-", substr($ld, 0,10));
                                $hour = substr($ld, -2);
                                $curTime = mktime($hour, 0, 0, $month, $day, $year) * 1000;
                                $callAnswered[] = array($curTime, $lm);
                            }
                        }
                        if (isset($kl) && ($kl == 'BUSY') && count($lw) > 0 ) {
                            foreach ($lw as $ld => $lm) {
                                list($year, $month, $day) = explode("-", substr($ld, 0,10));
                                $hour = substr($ld, -2);
                                $curTime = mktime($hour, 0, 0, $month, $day, $year) * 1000;
                                $callMissed[] = array($curTime, $lm);
                            }
                        }
                        if (isset($kl) && ($kl == 'NO ANSWER') && count($lw) > 0 ) {
                            foreach ($lw as $ld => $lm) {
                                list($year, $month, $day) = explode("-", substr($ld, 0,10));
                                $hour = substr($ld, -2);
                                $curTime = mktime($hour, 0, 0, $month, $day, $year) * 1000;
                                $callHolded[] = array($curTime, $lm);
                            }
                        }
                    }
                    $jsonArray['series'][] = array(
                                        'name'=>'Answered',
                                        'data'=>$callAnswered,
                                        'pointStart'=> mktime(0, 0, 0, $month, $startDateWeek[2], $year)*1000,
                                        'pointInterval'=> 7 * 24 * 3600 * 1000 // one day
                                    );
                    $jsonArray['series'][] = array(
                                        'name'=>'Busy',
                                        'data'=>$callMissed,
                                        'pointStart'=> mktime(0, 0, 0, $month, $startDateWeek[2], $year)*1000,
                                        'pointInterval'=> 7 * 24 * 3600 * 1000 // one day
                                    );
                    $jsonArray['series'][] = array(
                                        'name'=>'No Answer',
                                        'data'=>$callHolded,
                                        'pointStart'=> mktime(0, 0, 0, $month, $startDateWeek[2], $year)*1000,
                                        'pointInterval'=> 7 * 24 * 3600 * 1000 // one day
                                    );
                    break;
                case 30:
                    $currNumberOfDay = date('t');
                    $day = date('d');
                    $month = date('m');
                    $year = date('Y');
                    $hour = date('H');
                    $startDateWeek = explode( '-', date('Y-m-d', mktime(0, 0, 0, date('m'),'01', date('Y'))));
                    $endDateWeek = explode( '-', date('Y-m-d', mktime(0, 0, 0, date('m'), $currNumberOfDay, date('Y'))));

                    $callAnswered = $callMissed = $callHolded = $pentruMine = array();
                    $curTime = date('Y-m-d H:i:s', mktime($hour, 0, 0, $month, $day, $year));
                    $lastTime = date('Y-m-d H:i:s', mktime($hour, 0, 0, $month-1, $day, $year));
                    $sqlEvents = "SELECT calldate, disposition  FROM cdr
                                  WHERE disposition IN ('ANSWERED', 'BUSY', 'NO ANSWER') AND
                                  calldate BETWEEN '{$lastTime}' AND '{$curTime}' ORDER BY calldate ASC";

                    //echo $sqlEvents;
                    $result = Yii::app()->dbcdr->createCommand($sqlEvents)->queryAll();

                    foreach ($result as $k) {
                        $data_search = substr($k['calldate'], 0, 13);

                        $pentruMine[$k['disposition']][$data_search] = (isset($pentruMine[$k['disposition']][$data_search])) ? ($pentruMine[$k['disposition']][$data_search]+1) : 1;
                    }
                    //print_r($pentruMine);
                    foreach ($pentruMine as $kl => $lw) {
                        if (isset($kl) && ($kl == 'ANSWERED') && count($lw) > 0 ) {
                            foreach ($lw as $ld => $lm) {
                                list($year, $month, $day) = explode("-", substr($ld, 0,10));
                                $hour = substr($ld, -2);
                                $curTime = mktime($hour, 0, 0, $month, $day, $year) * 1000;
                                $callAnswered[] = array($curTime, $lm);
                            }
                        }
                        if (isset($kl) && ($kl == 'BUSY') && count($lw) > 0 ) {
                            foreach ($lw as $ld => $lm) {
                                list($year, $month, $day) = explode("-", substr($ld, 0,10));
                                $hour = substr($ld, -2);
                                $curTime = mktime($hour, 0, 0, $month, $day, $year) * 1000;
                                $callMissed[] = array($curTime, $lm);
                            }
                        }
                        if (isset($kl) && ($kl == 'NO ANSWER') && count($lw) > 0 ) {
                            foreach ($lw as $ld => $lm) {
                                list($year, $month, $day) = explode("-", substr($ld, 0,10));
                                $hour = substr($ld, -2);
                                $curTime = mktime($hour, 0, 0, $month, $day, $year) * 1000;
                                $callHolded[] = array($curTime, $lm);
                            }
                        }
                    }
                    $jsonArray['series'][] = array(
                                        'name'=>'Answered',
                                        'data'=>$callAnswered,
                                        'pointStart'=> mktime(0, 0, 0, $month, $startDateWeek[2], $year)*1000,
                                        'pointInterval'=> 7 * 24 * 3600 * 1000 // one day
                                    );
                    $jsonArray['series'][] = array(
                                        'name'=>'Busy',
                                        'data'=>$callMissed,
                                        'pointStart'=> mktime(0, 0, 0, $month, $startDateWeek[2], $year)*1000,
                                        'pointInterval'=> 7 * 24 * 3600 * 1000 // one day
                                    );
                    $jsonArray['series'][] = array(
                                        'name'=>'No Answer',
                                        'data'=>$callHolded,
                                        'pointStart'=> mktime(0, 0, 0, $month, $startDateWeek[2], $year)*1000,
                                        'pointInterval'=> 7 * 24 * 3600 * 1000 // one day
                                    );
                    break;
            }
        }
        echo CJSON::encode($jsonArray);
        Yii::app()->end();
    }
    public function actionResponseActivity(){
        $jsonArray = array();
        //ini_set('memory_limit', '-1');
        if (Yii::app()->request->isAjaxRequest) {
            $nb_day = (isset($_POST['nb_day'])) ? $_POST['nb_day'] : 1;
            //date_default_timezone_set('UTC');
            switch($nb_day) {
                case 1:
                    $day = date('d');
                    $month = date('m');
                    $year = date('Y');
                    $callAnswered = array();
                    for ($h = 0; $h < 24; $h++){
                        for ($i=0; $i < 60; $i +=10) {
                            $curTime = mktime($h, $i, 0, $month, $day, $year)*1000;
                            $callAnswered[] = array($curTime, rand(0, 30));
                        }
                    }
                    $jsonArray['series'][] = array(
                                        'name'=>'Response Time',
                                        'data'=>$callAnswered,
                                        'pointStart'=> mktime(0, 0, 0, $month, $day, $year)*1000,
                                        'pointInterval'=> 24 * 3600 * 1000 // one day
                                    );
                    break;
                case 7:
                    $currNumberOfDay = date('w');
                    if ($currNumberOfDay > 0) {
                        $startDateWeek = explode( '-',date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-($currNumberOfDay-1), date('Y'))));
                        $endDateWeek = explode( '-',date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')+(7 - $currNumberOfDay), date('Y'))));
                    } else {
                        $startDateWeek = explode( '-', date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-7, date('Y'))));
                        $endDateWeek = explode( '-',date('Y-m-d', mktime(0, 0, 0, date('m'),date('d'), date('Y'))));
                    }
                    $day = date('d');
                    $month = date('m');
                    $year = date('Y');
                    $callAnswered = array();
                    for ($dd = $startDateWeek[2]; $dd <= $endDateWeek[2]; $dd++){
                        for ($h = 0; $h < 24; $h++){
                            $curTime = mktime($h, 0, 0, $month, $dd, $year)*1000;
                            $callAnswered[] = array($curTime, rand(0, 30));
                        }
                    }
                    $jsonArray['series'][] = array(
                                        'name'=>'Response Time',
                                        'data'=>$callAnswered,
                                        'pointStart'=> mktime(0, 0, 0, $month, $startDateWeek[2], $year)*1000,
                                        'pointInterval'=> 7 * 24 * 3600 * 1000 // one day
                                    );
                    break;
                case 30:
                    $currNumberOfDay = date('t');
                    $day = date('d');
                    $month = date('m');
                    $year = date('Y');

                    $startDateWeek = explode( '-', date('Y-m-d', mktime(0, 0, 0, date('m'),'01', date('Y'))));
                    $endDateWeek = explode( '-', date('Y-m-d', mktime(0, 0, 0, date('m'), $currNumberOfDay, date('Y'))));

                    $callAnswered = array();
                    for ($dd = $startDateWeek[2]; $dd <= $endDateWeek[2]; $dd++){
                        for ($h = 0; $h < 24; $h++){
                            $curTime = mktime($h, 0, 0, $month, $dd, $year)*1000;
                            $callAnswered[] = array($curTime, rand(0, 30));
                            $callMissed[] = array($curTime, rand(0, 30));
                            $callHolded[] = array($curTime, rand(0, 30));
                        }
                    }
                    $jsonArray['series'][] = array(
                                        'name'=>'Response Time',
                                        'data'=>$callAnswered,
                                        'pointStart'=> mktime(0, 0, 0, $month, $startDateWeek[2], $year)*1000,
                                        'pointInterval'=> 7 * 24 * 3600 * 1000 // one day
                                    );
                    break;
            }
        }
        echo CJSON::encode($jsonArray);
        Yii::app()->end();
    }
    public function actionGenerationOfAllEvent(){
        $connection=Yii::app()->db;
        $cmd = $connection->createCommand();
        $nodes = $cmd->select('b.*, a.id_asterisk, a.asterisk_url, a.voip_url')
            ->from('{{buildings}} b')
            ->leftJoin('{{asterisk}} a','b.id_building = a.id_building')
            ->queryAll();
        $cmd->reset();
        $countOfEvent = 0;
        $arrOfNotification = array();
        if (count($nodes))
        foreach ($nodes as $k){
            if (isset($k['id_asterisk']) && !empty($k['id_asterisk']) && (empty($k['asterisk_url']) || empty($k['voip_url']) )){
                $countOfEvent++;
                $tmp = array(
                    'icon_color'=>'yellow',
                    'icon' => 'fa fa-hospital-o',
                    'text' => Yii::t('admin/default','For this ').'<b><i>'.$k['name'].'</i></b>'.Yii::t('admin/default',' not have set all fields'),
                    'url' => Yii::app()->createUrl("admin/asterisk/update/",array("id"=>$k['id_asterisk']))
                );
                array_push($arrOfNotification, $tmp);
            } else if (empty($k['id_asterisk'])){
                $countOfEvent++;
                $tmp = array(
                    'icon_color'=>'red',
                    'icon' => 'fa fa-hospital-o',
                    'text' => Yii::t('admin/default','This building ').'<b><i>'.$k['name'].'</i></b>'.Yii::t('admin/default',' not have the Nodes'),
                    'url' => Yii::app()->createUrl("admin/asterisk/create/")
                );
                array_push($arrOfNotification, $tmp);
            }
        }
        if ($countOfEvent > 0) {
            $html = '<ul class="nav navbar-nav pull-right">
					<li class="dropdown hidden-xs">
						<a class="btn dropdown-toggle" data-toggle="dropdown" href="index.html#" id="aIconInfo">
							<i class="fa fa-warning"></i>
							<span class="number">'.$countOfEvent.'</span>
						</a>
						<ul class="dropdown-menu notifications ulHeaderNotification">
							<li class="dropdown-menu-title">
								<span>You have '.$countOfEvent.' notifications</span>
							</li>';
            foreach ($arrOfNotification as $l) {
                $html .= '<li>
                        <a href="'.$l['url'].'">
                            <span class="icon ' . $l['icon_color'] . '"><i class="' . $l['icon'] . '"></i></span>
                            <span class="message">' . $l['text'] . '</span>
                        </a>
                    </li>';
            }
            $html .= '</ul>
                </li>
            </ul>';

            echo $html;
        } else {
            echo "";
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
                'data' => array((int)$logs['csms'], (int)$logs['cemail'], (int)$logs['cvoip'], (int)$logs['ctransfer'], (int)$logs['ccamera'], (int)$logs['ciopos']),
                'stack' => 'EMS'
            );
            $jsonArray['series'][] = array(
                'name' => 'Pendant Notification',
                'data' => array((int)$logsPendant['csms'], (int)$logsPendant['cemail'], (int)$logsPendant['cvoip'], (int)$logsPendant['ctransfer'], (int)$logsPendant['ccamera'], (int)$logsPendant['ciopos']),
                'stack' => 'Pendant'
            );
            $jsonArray['series'][] = array(
                'name' => 'MaxiVox Notification',
                'data' => array((int)$logsMaxiVox['csms'], (int)$logsMaxiVox['cemail'], (int)$logsMaxiVox['cvoip'], (int)$logsMaxiVox['ctransfer'], $logsMaxiVox['ccamera'], (int)$logsMaxiVox['ciopos']),
                'stack' => 'MaxiVox'
            );

            //Yii::log(CVarDumper::dumpAsString(print_r($jsonArray['category'], true), 10),'error','app');
            echo CJSON::encode($jsonArray);
            Yii::app()->end();
        } else {
            echo CJSON::encode(array('series'=>array(),'category'=>array()));
            Yii::app()->end();
        }
    }
    public function actionCustomLinks($id){
        $model = CustomLinks::model()->findByPk($id);
        $this->render('customlinks', array(
            'model'=>$model,
        ));
    }
}