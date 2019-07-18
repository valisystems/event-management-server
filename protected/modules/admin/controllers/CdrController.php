<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 4/28/15
 * Time: 22:58
 */

class CdrController extends Controller
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
        $cs->registerScriptFile(Yii::app()->request->baseUrl . '/assets/js/jquery.placeholder.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl . '/assets/js/jquery.maskedinput.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl . '/assets/js/jquery.inputlimiter.1.3.1.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl . '/assets/js/jquery.dataTables.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl . '/assets/js/dataTables.bootstrap.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/highcharts/highcharts.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/highcharts/highcharts-more.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl . '/assets/js/pages/cdr.js', CClientScript::POS_END);
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

    public function actionGetCdr(){
        if(isset($_POST) && !empty($_POST['allData'])){

            $searchFilter = $daterange = $daterangeTo = $clidnumber = $cnum_mod = $clidname = $cnam_mod = $destin = $dst_mod = $between = $betweenand = $disposition = "";
            $cnum_neg = $cnam_neg = $dst_neg = false;
            $lstPost = explode("&", urldecode($_POST['allData']));
            foreach ($lstPost as $l) {
                $tmp = explode("=", $l);
                //print_r($tmp);
                $$tmp[0] = $tmp[1];
            }
            $start = (isset($_POST['start']) && !empty($_POST['start'])) ? trim($_POST['start']) : 0;
            $length = (isset($_POST['length']) && !empty($_POST['length'])) ? trim($_POST['length']) : 25;
            $search = (isset($_POST['search']['value']) && !empty($_POST['search']['value'])) ? trim($_POST['search']['value']) : "";
            $draw = (isset($_POST['draw']) && !empty($_POST['draw'])) ? trim($_POST['draw']) : 0;
            $order = (isset($_POST['order'])) ? $_POST['order'][0] : array('column' => 0, 'dir' => 'desc');
            $whereTXT = "";
            $offset =  " LIMIT 50";
            $orderBy = "";
            //$whereArray = array();
            $dateRangeDate = urldecode($daterange).":00";
            $dateRangeDateTo = urldecode($daterangeTo).':00';
            $whereTXT = "calldate >= :dateRangeDate AND calldate <= :dateRangeDateTo";
            $whereArray = array(":dateRangeDate"=>$dateRangeDate, ":dateRangeDateTo"=>$dateRangeDateTo);

            switch ($searchFilter) {
                case "CallerIDNumberCheck":
                    $notCNum = ($cnum_neg == true) ? ' NOT ' : "";
                    switch ($cnum_mod) {
                        case "begins_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $clidnumber."%";
                            break;
                        case "contains":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$clidnumber."%";
                            break;
                        case "ends_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$clidnumber;
                            break;
                        case "exact":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $clidnumber;
                            break;
                    }
                    break;
                case "CallerIdNameCheck":
                    $notCNum = ($cnam_neg == true) ? ' NOT ' : "";
                    switch ($cnam_mod) {
                        case "begins_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $clidname."%";
                            break;
                        case "contains":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$clidname."%";
                            break;
                        case "ends_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$clidname;
                            break;
                        case "exact":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $clidname;
                            break;
                    }
                    break;
                case "DestinationCheck":
                    $notCNum = ($dst_neg == true) ? ' NOT ' : "";
                    switch ($dst_mod) {
                        case "begins_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $destin."%";
                            break;
                        case "contains":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$destin."%";
                            break;
                        case "ends_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$destin;
                            break;
                        case "exact":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $destin;
                            break;
                    }
                    break;
                case "durationCheck":
                    $billsec = urldecode($between).":00";
                    $billsecTo = urldecode($betweenand).':00';
                    $whereTXT .= " AND "."billsec >= :billsec AND billsec <= :billsecTo";
                    $whereArray[":billsec"] = $billsec;
                    $whereArray[":billsecTo"] = $billsecTo;
                    break;
                case "dispositionCheck":
                    $whereTXT .= " AND disposition = :disposition";
                    $whereArray[':disposition'] = $disposition;
                    break;
            }
            if (!empty($search)) {
                $whereTXT .= " AND ( calldate LIKE :searchText ";
                $whereTXT .= " OR clid LIKE :searchText";
                $whereTXT .= " OR src LIKE :searchText";
                $whereTXT .= " OR dst LIKE :searchText";
                $whereTXT .= " OR billsec LIKE :searchText";
                $whereTXT .= " OR disposition LIKE :searchText )";
                $whereArray[':searchText'] = "%".$search."%";

            }
            $column = array("calldate", "clid", "src", "dst", "billsec", "disposition");
            $offset = ($length > 0) ? " LIMIT $start,$length" : "";
            $orderBy = " ORDER BY ".$column[$order['column']].' '.$order['dir'];

            $sql = "SELECT SQL_CALC_FOUND_ROWS (0), calldate, clid, src, dst, billsec, disposition FROM cdr";

            $logs = Yii::app()->dbcdr->createCommand($sql.' WHERE '.$whereTXT.$orderBy.$offset);
            $resultArray = array();

            try {
                $resultArray = $logs->queryAll(true, $whereArray);
                $lengthResult = Yii::app()->dbcdr->createCommand('SELECT FOUND_ROWS()')->queryScalar();
            } catch (Exception $e) {
                $text = $logs->getText();
                Yii::log(CVarDumper::dumpAsString($text, 10),'error','app');
            }
            if (count($resultArray) > 0) {
                $arr = array();
                $data = array();
                foreach ($resultArray as $kl) {
                    $data[] = array(
                        $kl['calldate'],
                        $kl['clid'],
                        $kl['src'],
                        $kl['dst'],
                        $kl['billsec'],
                        $kl['disposition']
                    );
                }
                header('Content-Type: application/json');
                echo json_encode(array('draw'=>$draw, 'recordsTotal' => $lengthResult, 'recordsFiltered' => $lengthResult, 'data' => $data));

            } else {
                $data = array();
                header('Content-Type: application/json');
                echo json_encode(array('draw'=>$draw, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => $data));
            }
        }
    }
    public function actionReportExcel($searchData, $format = 'excel5'){
        if(isset($searchData) && !empty($searchData)){

            $searchFilter = $daterange = $daterangeTo = $clidnumber = $cnum_mod = $clidname = $cnam_mod = $destin = $dst_mod = $between = $betweenand = $disposition = "";
            $cnum_neg = $cnam_neg = $dst_neg = false;
            $decodedData = base64_decode($searchData);
            $arrayFromSearch = explode("&",$decodedData);
            foreach ($arrayFromSearch as $k){
                $tmp = explode('=', $k);
                $$tmp[0]=urldecode($tmp[1]);
            }

            $dateRangeDate = urldecode($daterange).":00";
            $dateRangeDateTo = urldecode($daterangeTo).':00';
            $whereTXT = "calldate >= :dateRangeDate AND calldate <= :dateRangeDateTo";
            $whereArray = array(":dateRangeDate"=>$dateRangeDate, ":dateRangeDateTo"=>$dateRangeDateTo);
            $typeCriteria = $searchValue = "";
            switch ($searchFilter) {
                case "CallerIDNumberCheck":
                    $notCNum = ($cnum_neg == true) ? ' NOT ' : "";
                    $typeCriteria = "Caller ID Number";
                    $searchValue = trim($clidnumber);
                    switch ($cnum_mod) {
                        case "begins_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $clidnumber."%";
                            break;
                        case "contains":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$clidnumber."%";
                            break;
                        case "ends_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$clidnumber;
                            break;
                        case "exact":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $clidnumber;
                            break;
                    }
                    break;
                case "CallerIdNameCheck":
                    $notCNum = ($cnam_neg == true) ? ' NOT ' : "";
                    $typeCriteria = "Caller ID Name";
                    $searchValue = trim($clidname);
                    switch ($cnam_mod) {
                        case "begins_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $clidname."%";
                            break;
                        case "contains":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$clidname."%";
                            break;
                        case "ends_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$clidname;
                            break;
                        case "exact":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $clidname;
                            break;
                    }
                    break;
                case "DestinationCheck":
                    $notCNum = ($dst_neg == true) ? ' NOT ' : "";
                    $typeCriteria = "Destination";
                    $searchValue = trim($destin);
                    switch ($dst_mod) {
                        case "begins_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $destin."%";
                            break;
                        case "contains":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$destin."%";
                            break;
                        case "ends_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$destin;
                            break;
                        case "exact":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $destin;
                            break;
                    }
                    break;
                case "durationCheck":
                    $typeCriteria = "Duration";

                    $billsec = urldecode($between).":00";
                    $billsecTo = urldecode($betweenand).':00';
                    $searchValue = $billsec.' - '.$billsecTo;
                    $whereTXT .= " AND "."billsec >= :billsec AND billsec <= :billsecTo";
                    $whereArray[":billsec"] = $billsec;
                    $whereArray[":billsecTo"] = $billsecTo;
                    break;
                case "dispositionCheck":
                    $typeCriteria = "Disposition";
                    $whereTXT .= " AND disposition = :disposition";
                    $whereArray[':disposition'] = $disposition;
                    $searchValue = $disposition;
                    break;
            }
            if (!empty($search)) {
                $whereTXT .= " AND ( calldate LIKE :searchText ";
                $whereTXT .= " OR clid LIKE :searchText";
                $whereTXT .= " OR src LIKE :searchText";
                $whereTXT .= " OR dst LIKE :searchText";
                $whereTXT .= " OR billsec LIKE :searchText";
                $whereTXT .= " OR disposition LIKE :searchText )";
                $whereArray[':searchText'] = "%".$search."%";

            }
            $column = array("calldate", "clid", "src", "dst", "billsec", "disposition");
            $orderBy = " ORDER BY calldate DESC";

            $sql = "SELECT calldate, clid, src, dst, billsec, disposition FROM cdr";

            $logs = Yii::app()->dbcdr->createCommand($sql.' WHERE '.$whereTXT);
            $resultArray = array();

            try {
                $resultArray = $logs->queryAll(true, $whereArray);
            } catch (Exception $e) {
                $text = $logs->getText();
                Yii::log(CVarDumper::dumpAsString($text, 10),'error','app');
            }

            if (count($resultArray) > 0) {
                $report = new YiiReport(array('template' => 'cdrreport.xls'));
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
                            'data' => $resultArray,
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

//
//
//
//
//
//            if (count($resultArray) > 0) {
//                $arr = array();
//                $data = array();
//                foreach ($resultArray as $kl) {
//                    $data[] = array(
//                        $kl['calldate'],
//                        $kl['clid'],
//                        $kl['src'],
//                        $kl['dst'],
//                        $kl['billsec'],
//                        $kl['disposition']
//                    );
//                }
//                header('Content-Type: application/json');
//                echo json_encode(array('draw'=>$draw, 'recordsTotal' => $lengthResult, 'recordsFiltered' => $lengthResult, 'data' => $data));
//
//            } else {
//                $data = array();
//                header('Content-Type: application/json');
//                echo json_encode(array('draw'=>$draw, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => $data));
//            }
        }
    }
    public function actionGetCdrChart(){
        if(isset($_POST) && !empty($_POST['allData'])){

            $searchFilter = $daterange = $daterangeTo = $clidnumber = $cnum_mod = $clidname = $cnam_mod = $destin = $dst_mod = $between = $betweenand = $disposition = "";
            $cnum_neg = $cnam_neg = $dst_neg = false;
            $lstPost = explode("&", urldecode($_POST['allData']));
            foreach ($lstPost as $l) {
                $tmp = explode("=", $l);
                //print_r($tmp);
                $$tmp[0] = $tmp[1];
            }
            $start = (isset($_POST['start']) && !empty($_POST['start'])) ? trim($_POST['start']) : 0;
            $length = (isset($_POST['length']) && !empty($_POST['length'])) ? trim($_POST['length']) : 25;
            $search = (isset($_POST['search']['value']) && !empty($_POST['search']['value'])) ? trim($_POST['search']['value']) : "";
            $draw = (isset($_POST['draw']) && !empty($_POST['draw'])) ? trim($_POST['draw']) : 0;
            $order = (isset($_POST['order'])) ? $_POST['order'][0] : array('column' => 0, 'dir' => 'desc');
            $whereTXT = "";
            $offset =  " LIMIT 50";
            $orderBy = "";
            //$whereArray = array();
            $dateRangeDate = urldecode($daterange).":00";
            //Yii::log(CVarDumper::dumpAsString($dateRangeDate, 10),'error','app');
            $tmpDateTimeFrom = explode(" ", $dateRangeDate);
            $tmpDateFrom = explode("/", $tmpDateTimeFrom[0]);
            //Yii::log(CVarDumper::dumpAsString(print_r($tmpDateTimeFrom, true), 10),'error','app');

            $dateRangeDateTo = urldecode($daterangeTo).':00';
            $tmpDateTimeTo = explode(" ", $dateRangeDateTo);
            $tmpDateTo = explode('/', $tmpDateTimeTo[0]);
            $whereTXT = "calldate >= :dateRangeDate AND calldate <= :dateRangeDateTo";
            $whereArray = array(":dateRangeDate"=>$dateRangeDate, ":dateRangeDateTo"=>$dateRangeDateTo);



            switch ($searchFilter) {
                case "CallerIDNumberCheck":
                    $notCNum = ($cnum_neg == true) ? ' NOT ' : "";
                    switch ($cnum_mod) {
                        case "begins_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $clidnumber."%";
                            break;
                        case "contains":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$clidnumber."%";
                            break;
                        case "ends_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$clidnumber;
                            break;
                        case "exact":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $clidnumber;
                            break;
                    }
                    break;
                case "CallerIdNameCheck":
                    $notCNum = ($cnam_neg == true) ? ' NOT ' : "";
                    switch ($cnam_mod) {
                        case "begins_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $clidname."%";
                            break;
                        case "contains":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$clidname."%";
                            break;
                        case "ends_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$clidname;
                            break;
                        case "exact":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $clidname;
                            break;
                    }
                    break;
                case "DestinationCheck":
                    $notCNum = ($dst_neg == true) ? ' NOT ' : "";
                    switch ($dst_mod) {
                        case "begins_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $destin."%";
                            break;
                        case "contains":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$destin."%";
                            break;
                        case "ends_with":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = "%".$destin;
                            break;
                        case "exact":
                            $whereTXT .= " AND ".$notCNum." clid LIKE :clid";
                            $whereArray[':clid'] = $destin;
                            break;
                    }
                    break;
                case "durationCheck":
                    $billsec = urldecode($between).":00";
                    $billsecTo = urldecode($betweenand).':00';
                    $whereTXT .= " AND "."billsec >= :billsec AND billsec <= :billsecTo";
                    $whereArray[":billsec"] = $billsec;
                    $whereArray[":billsecTo"] = $billsecTo;
                    break;
                case "dispositionCheck":
                    $whereTXT .= " AND disposition = :disposition";
                    $whereArray[':disposition'] = $disposition;
                    break;
            }
            if (!empty($search)) {
                $whereTXT .= " AND ( calldate LIKE :searchText ";
                $whereTXT .= " OR clid LIKE :searchText";
                $whereTXT .= " OR src LIKE :searchText";
                $whereTXT .= " OR dst LIKE :searchText";
                $whereTXT .= " OR billsec LIKE :searchText";
                $whereTXT .= " OR disposition LIKE :searchText )";
                $whereArray[':searchText'] = "%".$search."%";

            }
            $column = array("calldate", "clid", "src", "dst", "billsec", "disposition");

            $sql = "SELECT SUM(IF(disposition = 'ANSWERED',1,0)) AS canswered, SUM(IF(disposition = 'BUSY',1,0)) AS cbusy, SUM(IF(disposition = 'NO ANSWER',1,0)) AS cnoanswer  FROM cdr";

            $logs = Yii::app()->dbcdr->createCommand($sql.' WHERE '.$whereTXT);
            $resultArray = array();

            try {
                $resultArray = $logs->queryRow(true, $whereArray);
                //Yii::log(CVarDumper::dumpAsString(print_r($resultArray, true), 10),'error','app');
            } catch (Exception $e) {
                $text = $logs->getText();
                Yii::log(CVarDumper::dumpAsString($text, 10),'error','app');
            }
            $jsonArray = array();
            if (count($resultArray) > 0) {
                $jsonArray[] = array(
                    'name' => 'Call Activity',
                    'data' =>  array(
                        array('Answered',(int)$resultArray['canswered']),
                        array('Busy',(int)$resultArray['cbusy']),
                        array('No Answer',(int)$resultArray['cnoanswer'])
                    ),
                    'dataLabels' => array(
                        'enabled' => 'true',
                        'rotation' => '0',
                        'color' => '#000',
                        'align' => 'right',
                        'format' => '{point.y:.0f}', // one decimal
                        'y' => '10', // 10 pixels down from the top
                        'style' => array(
                            'fontSize' => '13px',
                            'fontFamily' => 'Verdana, sans-serif'
                        )
                    )
                );

                echo CJSON::encode($jsonArray);
                Yii::app()->end();

            } else {
                echo CJSON::encode($jsonArray);
                Yii::app()->end();
            }
        }
    }
}

/*

[{
    "name":"Call Activity",
    "data":[
        ["Answered","2023386"],
        ["Busy","1"],
        ["No Answer","82"]
    ],
    "dataLabels":{
        "enabled":"true",
        "rotation":"-90",
        "color":"#FFFFFF",
        "align":"right",
        "format":"{point.y:.1f}",
        "y":"10",
        "style":{
            "fontSize":"13px",
            "fontFamily":"Verdana, sans-serif"
        }
    }
}]

 */