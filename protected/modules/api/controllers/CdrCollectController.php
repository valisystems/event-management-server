<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 11/26/15
 * Time: 14:39
 */

class CdrCollectController extends Controller
{
    public $autorizatedIP = array();
    /*public function init()
    {
        $criteria=new CDbCriteria;
        //$criteria->compare('id_map',$id);
        $criteria->addCondition('device_classification = :device_classification');
        $criteria->addCondition('ip_address <> ""');
        $criteria->params = array(':device_classification'=>'mipositioning');

        $this->autorizatedIP = array_values(CHtml::listData(Devices::model()->findAll($criteria),'ip_address', "ip_address"));
    }*/

    public function actionIndex()
    {
        //Yii::log(CVarDumper::dumpAsString(var_dump(file_get_contents("php://input"), true), 10),'error','app');
        //if(isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"] == "application/json") {
            $json = json_decode(file_get_contents("php://input"));
            //Yii::log(CVarDumper::dumpAsString(var_dump($json), 10),'error','app');
            if($json->action == "call-data-record") {

                //Yii::log(CVarDumper::dumpAsString(print_r($json, true), 10),'error','app');
                // Check if the request comes from the expected IP address:
                $remote = $_SERVER["REMOTE_ADDR"];
                //$result = $mysqli->query("SELECT * FROM system WHERE code='$system' AND adr='$remote'");
                //if($result == FALSE || $result->num_rows != 1) exit("System not found or request from wrong IP address");

                //curl -i -H "Accept: application/json" -H "Content-Type: application/json" -X POST -d  '{"action":"call-data-record", "System":"5L5ATHHMQ6FX","PrimaryCallID":"eb900885-621ad3ec@192.168.1.144","CallID":"eb900885-621ad3ec@192.168.1.144","From":"\"1118\" <sip:1118@localhost>","To":"\"VADIM LICA\" <sip:1117@localhost>","Direction":"I","RemoteParty":"\"1118\" <sip:1118@localhost>","LocalParty":"\"VADIM LICA\" <sip:1117@localhost>","TrunkName":"","TrunkID":"","Cost":"","CMC":"","Domain":"localhost","TimeStart":"2015-11-28 09:21:42","TimeConnected":"2015-11-28 09:21:42","TimeEnd":"2015-11-28 09:21:54","LocalTime":"2015-11-28 09:21:42","DurationHHMMSS":"0:00:12","Duration":"12","RecordLocation":"","RecordUsers":"","Type":"attendant","Extension":"1118","IdleDuration":"128","RingDuration":"0","HoldDuration":"0","IvrDuration":"0","AccountNumber":"","IPAdr":"udp:192.168.1.144:5060","Quality":"VQSessionReport: CallTerm\r\nLocalMetrics:\r\nTimestamps:START=2015-11-28T09:21:42Z STOP=2015-11-28T09:21:54Z\r\nCallID:eb900885-621ad3ec@192.168.1.144\r\nFromID:\"1118\" <sip:1118@192.168.1.197>;tag=58a0a7b18d28deb0o0\r\nToID:<sip:1117@192.168.1.197>;tag=7f8f6bfd56\r\nSessionDesc:PT=0 PD=PCMU SR=8000 FD=30 FO=240 FPP=1 PPS=33 PLC=3\r\nLocalAddr:IP=192.168.1.197 PORT=49882 SSRC=0x3289dd80\r\nRemoteAddr:IP=192.168.1.144 PORT=16424 SSRC=0x5e4c3e14\r\nx-UserAgent:Vodia-PBX/5.3.1a\r\nx-SIPterm:SDC=OK SDR=AN\r\nPacketLoss:NLR=0.0 JDR=0.0\r\nBurstGapLoss:BLD=0.0 BD=0 GLD=0.0 GD=0 GMIN=16\r\nDelay:RTD=0 ESD=0 IAJ=0\r\nQualityEst:MOSLQ=4.1 MOSCQ=4.1\r\n"}' http://mialert.teleportvideo.com/api/cdrCollect
                // curl -i -H "Accept: application/json" -H "Content-Type: application/json" -X POST -d  "{'action':'call-data-record'}" http://mialert.teleportvideo.com/api/cdrCollect

                // Add the row:
               /* $query = sprintf("INSERT INTO cdr (sys,primarycallid,callid,cid_from,cid_to,direction,remoteparty,localparty,trunkname,trunkid,cost,cmc,domain,timestart,timeconnected,timeend,ltime,durationhhmmss,duration,recordlocation,type,extension,idleduration,ringduration,holdduration,ivrduration,accountnumber,ipadr) values ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
               */
                $model = new CdrCollect;
                //$model->System = $json->System;
                $arr = array(
                "sys" => $json->System,
                "primarycallid" => $json->PrimaryCallID,
                "callid" => $json->CallID,
                "cid_from" => $json->From,
                "cid_to" => $json->To,
                "direction" => $json->Direction,
                "remoteparty" => $json->RemoteParty,
                "localparty" => $json->LocalParty,
                "trunkname" => $json->TrunkName,
                "trunkid" => $json->TrunkID,
                "cost" => $json->Cost,
                "cmc" => $json->CMC,
                "domain" => $json->Domain,
                "timestart" => $json->TimeStart,
                "timeconnected" => $json->TimeConnected,
                "timeend" => $json->TimeEnd,
                "ltime" => $json->LocalTime,
                "durationhhmmss" => $json->DurationHHMMSS,
                "duration" => $json->Duration,
                "recordlocation" => $json->RecordLocation,
                "type" => $json->Type,
                "extension" => $json->Extension,
                "idleduration" => $json->IdleDuration,
                "ringduration" => $json->RingDuration,
                "holdduration" => $json->HoldDuration,
                "ivrduration" => $json->IvrDuration,
                "accountnumber" => $json->AccountNumber,
                "ipadr" => $json->IPAdr);

                //Yii::log(CVarDumper::dumpAsString(print_r($arr, true), 10),'error','app');


                $model->attributes = $arr;

                if($model->save()){
                    //Yii::log(CVarDumper::dumpAsString("Submit Success", 10),'error','app');
                } else {
                    echo "Jopa";
                }

            }
        /*} else {
            echo "ceva numi place";
        }
*/
        Yii::app()->end();
        //$this->render('index');
    }
    public function actionTest()
    {
        return "Vasea";
    }
}