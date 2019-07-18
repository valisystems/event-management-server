<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 2/10/16
 * Time: 12:00
 */

class EmsCronCommand extends CConsoleCommand{
    public function actionIndex(){
        Yii::import("application.modules.admin.models.Setting");
        $modelSettings = Setting::model()->find();
        if ($modelSettings) {
            $update_ems_server = $modelSettings->update_ems_server;
            $update_ems_key = $modelSettings->update_ems_key;

            $activation_key = $modelSettings->activation_key;
            $secret_key = $modelSettings->secret_key;

            $result = array();
            exec('sudo dmidecode -t 1 | grep "UUID:"', $result);
            $txt = explode(" ", $result[0]);
            $snMB = $txt[count($txt)-1];
            $result = array();
            exec('ifconfig -a | grep "eth0"', $result);
            $macAddress = substr($result[0], strpos($result[0], "HWaddr") + 7, 17);

            $code = md5(md5(base64_encode($snMB)).md5(base64_encode($macAddress)).$secret_key);

            $activate = ($code == $activation_key) ? "activated" : "notactivate";


            $url = $update_ems_server."/statusEms.php";
            $post = array(
                'ems_key' => $update_ems_key,
                'status' => $activate,
                'mb_serial_number' => $snMB,
                'mac' => $macAddress
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            //echo $url;
            $responseInfo = curl_exec($ch);
            curl_close($ch);

            $infToUpdate = CJSON::decode($responseInfo);
            //echo $update_ems_server." --- ".$update_ems_key .' --- '.$activate;
           if (count($infToUpdate)){
               switch($infToUpdate['action']){
                   case "nothing":
                       break;
                   case 'activate':
                       //activation_key
                       $setting = Setting::model()->find();
                       $setting->activation_key = $infToUpdate['activation_key'];
                       $setting->secret_key = $infToUpdate['secret_key'];

                       $setting->save();
                       break;
                   case "disable":
                        $setting = Setting::model()->find();
                        $setting->activation_key = $setting->secret_key =  "";
                        $setting->save();
                       break;
               }
           }
        }
    }
}