<?php 
class WebUser extends CWebUser {
    private $_model = null;

    /**
     * @return string
     */
    public function getRole() {
        if($user = $this->getModel()){
            // в таблице User есть поле role
            switch($user->role){
                case "A":
                    return "administrator";
                    break;
                case "M":
                    return "moderator";
                    break;
                case "U":
                    return "user";
                    break;
                default:
                    return "guest";
                    break;
            }
            return "guest";
        }
    }

    public function convertRoleToText($typeRole){
        $authFile = Yii::getPathOfAlias('application.config.auth').'.php';
        //print_r($authFile);
    }
    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = User::model()->findByPk($this->id, array('select' => 'role'));
        }
        return $this->_model;
    }

    /**
     * @return bool
     */
    public function licenseVerification(){
        //Yii::import("application.models.Settings");
        $result = array();
        $os = strtoupper(php_uname('s'));
        if (substr($os, 0, 3) === 'WIN') {
            $command ='powershell "Get-CimInstance Win32_OperatingSystem | FL SerialNumber"';
            $result = shell_exec($command);
            $txt = explode(":", trim($result));
            $serialNumberMB = $txt[count($txt)-1];
            $result = array();
            $command = 'getmac | findstr /C:"-" 2>&1';
            exec($command, $result);
            $txtMac = substr(trim($result[0]), 0, 17);
        } else {
            exec('sudo dmidecode -t 1 | grep "UUID:"', $result);
            //Yii::log(CVarDumper::dumpAsString(print_r($result, true), 10),'error','app');
            $txt = explode(" ", $result[0]);
            $serialNumberMB = $txt[count($txt)-1];
            $result = array();
            exec('ifconfig -a | grep "eth0"', $result);
            $txtMac = substr($result[0], strpos($result[0], "HWaddr") + 7, 17);
        }



        $criteria = new CDbCriteria;
        $criteria->limit = "1";
        $criteria->order = "id_settings ASC";
        $generalSettings = Settings::model()->find($criteria);
        if (count($generalSettings)) {
            if (empty($generalSettings->activation_key) || empty($generalSettings->secret_key)) {
                return false;
            } else {
                return $this->generateActivationCode(array('motherboard' => $serialNumberMB, 'mac' => $txtMac, 'activation_key' => $generalSettings->activation_key, 'secret_key' => $generalSettings->secret_key));
            }
        } else return false;
    }

    /**
     * @param array $arr
     * @return bool
     */
    private function generateActivationCode($arr = array()){
        $snMB = trim($arr['motherboard']);
        $macAddress = trim($arr['mac']);
        $activation_key = $arr['activation_key'];
        $secret_key = $arr['secret_key'];

        $code = md5(md5(base64_encode($snMB)).md5(base64_encode($macAddress)).$secret_key);

        if ($code == $activation_key) {
            Yii::app()->session['umber']  = md5($activation_key.$secret_key);
            return true;
        }
        else return false;
    }
    public function verifyLicenseOnSession() {
        $arrExclude = array('maxiVoxNotify', 'miPositioning','notificationLookUp', 'cdrCollect');
        if (!in_array(Yii::app()->controller->id, $arrExclude)) {
            $criteria = new CDbCriteria;
            $criteria->limit = "1";
            $criteria->order = "id_settings ASC";
            $generalSettings = Settings::model()->find($criteria);
            $schema = "http://";
            //Yii::log(CVarDumper::dumpAsString(print_r(Yii::app()->session['umber'], true), 10),'error','app');
            if (count($generalSettings)) {
                if (Yii::app()->session['umber'] == md5(($generalSettings->activation_key) . ($generalSettings->secret_key) )) {
                    return true;
                } else {
                    //$this->redirect(array('/site/login'));
//                if (Yii::app()->user->useHttps){
//                    $schema = "https://";
//                }
                    if (Yii::app()->controller->id != 'site')
                        Yii::app()->controller->redirect($schema . Yii::app()->request->serverName . '/site/login');
                    return false;
                }
            } else {
                if (Yii::app()->controller->id != 'site')
                    Yii::app()->controller->redirect($schema . Yii::app()->request->serverName . '/site/activate');
                return false;
            }
        } else {
            return true;
        }
    }
}
?>