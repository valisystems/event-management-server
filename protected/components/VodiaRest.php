<?php
namespace app\components;

//https://vodia.com/documentation/vodia_php_rest_api
class VodiaRest {
    private $destUrl = "";
    private $loginName = "";
    private $loginPass = "";
    private $sessId = "";
    
    private function getRest($url) {
        $params = array('http' => array('method' => 'GET', 
                                      'header' => "Cookie: session=" . $this->sessId . "\r\n"));
                                        
        $context = stream_context_create($params);
        $fp = fopen($url, 'rb', false, $context);

        $metaData = stream_get_meta_data($fp);
        //print_r($metaData);
        $lengthRecord = $metaData['wrapper_data'][3];
        $dataLen = explode(":", $lengthRecord)[1];
        $dataLen = (int)substr($dataLen, 1);
        
        $data = '';
        while (!feof($fp)) {
            $data .= fgets($fp, $dataLen);
            //$data .= fread($fp, $dataLen);
        }
        //$data = fgets($fp, $dataLen+1);
        
        preg_match_all("/HTTP\/1\.[1|0]\s(\d{3})/", $metaData['wrapper_data'][0], $matches);
        $code = end($matches[1]);

        fclose($fp);
        if ($code == 200) {
            return $data;
        } else {
            return "";
        }
    }
    
    private function putRest($url, $data, $login = false)
    {
        $header = "Content-Type: application/json\r\n" . "Content-Length: " . strlen($data) . "\r\n";
        if($login === false) {
            $header .= "Cookie: session=" . $this->sessId . "\r\n";
        }
        $params = array('http' => array('method' => 'PUT', 
                                      'header' => $header,
                                      'content'=> $data));
        $context = stream_context_create($params);

        error_reporting(0);
        if (!$fp = @fopen($url, 'rb', false, $context))
        {
             return;
        }
        error_reporting(E_ALL);
        // findout content length
        $metaData = stream_get_meta_data($fp);
        
        //print_r($metaData);
        preg_match_all("/HTTP\/1\.[1|0]\s(\d{3})/", $metaData['wrapper_data'][0], $matches);
        $code = end($matches[1]);
        if ($code == 200) 
        {
            $lengthRecord = $metaData['wrapper_data'][3]; // get content-length
            $dataLen = explode(":", $lengthRecord)[1]; // number out of string
            $dataLen = substr($dataLen, 1); // remove space

            $data = fread($fp, $dataLen);

            fclose($fp);

            if($login === true) {
                $this->sessId = substr($data, 1, 20);
            }
            return $data;
        } 
        else
        {
            return false;
        }
    }

    private function customRest($url, $method, $data = false)
    {
        $header = "Content-Type: application/json\r\n";
        $header .= "Cookie: session=" . $this->sessId . "\r\n";
        if (!empty($data)) {
            $header .= "Content-Length: " . strlen($data) . "\r\n";
        }
        
        $params = array('http' => array('method' => $method, 
                                       'header' => $header,
                                       'content'=> !empty($data) ? $data : '')
                        );
        $context = stream_context_create($params);
        $fp = fopen($url, 'rb', false, $context);

        // findout content length
        $metaData = stream_get_meta_data($fp);
        $lengthRecord = $metaData['wrapper_data'][3]; // get content-length
        $dataLen = explode(":", $lengthRecord)[1]; // number out of string
        $dataLen = substr($dataLen, 1); // remove space

        $output = fread($fp, $dataLen);
      
        //print_r($metaData);
        preg_match_all("/HTTP\/1\.[1|0]\s(\d{3})/", $metaData['wrapper_data'][0], $matches);
        $code = end($matches[1]);

        fclose($fp);
        if ($code == 200) {
            return $output;
        } else {
            return false;
        }
    }
    
    public function setDestUrl($url) {
      $this->destUrl = $url;
    }

    public function setSession($sess){
        $this->sessId = $sess;
    }

    public function getSession(){
        return $this->sessId;
    }
    
    public function setLoginPass($u, $p) {
      $this->loginName = $u;
      $this->loginPass = $p;
    }
  
    public function login() {
        $loginHash = md5($this->loginPass);
        $args = json_encode(array("name" => "auth", "value" => $this->loginName . " " . $loginHash));
        return $this->putRest($this->destUrl . "/rest/system/session", $args, true);
    }
    
    public function getDomainInfo() {
        $result = $this->getRest($this->destUrl . "/rest/system/domaininfo");
        return $result;
    }
    
    public function getDomains() {
        $result = $this->getRest($this->destUrl . "/rest/system/domains");
        return $result;
    }

    // return "ok"
    public function postDomain($s){
        $set = json_encode($s);
        return $this->customRest($this->destUrl . "/rest/system/domains", 'POST', $set);
    }

    public function putDomainConfig($domain, $s){
        $set = json_encode($s);
        return $this->putRest($this->destUrl . "/rest/domain/" . $domain . "/config", $set);
    }
    
    public function getDomainSettings($domain) {
        $result = $this->getRest($this->destUrl . "/rest/domain/" . $domain . "/settings");
        return $result;
    }
    
    public function putDomainSettings($domain, $s) {
        $set = json_encode($s);
        $this->putRest($this->destUrl . "/rest/domain/" . $domain . "/settings/", $set);
    }

    // return true
    public function deleteDomain($domain) {
        return $this->customRest($this->destUrl . "/rest/system/domains/" . $domain, "DELETE");
    }
    
    public function getUserList($domain, $type) {
        $result = $this->getRest($this->destUrl . "/rest/domain/" . $domain . "/userlist/" . $type);
        return $result;
    }
    
    public function getUserSettings($domain, $account) {
        $result = $this->getRest($this->destUrl . "/rest/domain/" . $domain . "/user_settings/" . $account);
        return $result;
    }
    
    public function putUserSettings($domain, $account, $s) {
        $set = json_encode($s);
        $this->putRest($this->destUrl . "/rest/domain/" . $domain . "/user_settings/" . $account, $set);
    }
    
    public function createAccount($domain, $s) {
      $set = json_encode($s);
      $this->putRest($this->destUrl . "/rest/domain/" . $domain . "/addacc/", $set);
    }
    
    public function domainAction($domain, $s) {
      $set = json_encode($s);
      $this->putRest($this->destUrl . "/rest/domain/" . $domain . "/domain_action/", $set);
    }
    
    public function getDomainTrunks($domain) {
      $result = $this->getRest($this->destUrl . "/rest/domain/" . $domain . "/domain_trunks/");
      return $result;
    }
    
    public function createTrunk($domain, $s) {
      $set = json_encode($s);
      $this->putRest($this->destUrl . "/rest/domain/" . $domain . "/domain_trunks/", $set);
    }
    
    public function setTrunkSettings($domain, $trunk, $s) {
      $set = json_encode($s);
      $this->putRest($this->destUrl . "/rest/domain/" . $domain . "/edit_trunk/" . $trunk, $set);
    }
    
    public function getTrunkSettings($domain, $trunk) {
      $result = $this->getRest($this->destUrl . "/rest/domain/" . $domain . "/edit_trunk/" . $trunk);
      return $result;
    }
    
    public function getDialplans($domain) {
      $result = $this->getRest($this->destUrl . "/rest/domain/" . $domain . "/dialplans/");
      return $result;
    }
    
    public function createDialplan($domain, $s) {
      $set = json_encode($s);
      $this->putRest($this->destUrl . "/rest/domain/" . $domain . "/dialplans/", $set);
    }
    
    public function setDialplanSettings($domain, $dp, $s) {
      $set = json_encode($s);
      $this->putRest($this->destUrl . "/rest/domain/" . $domain . "/edit_dialplan/" . $dp, $set);
    }
    
    public function getDialplanSettings($domain, $dp) {
      $result = $this->getRest($this->destUrl . "/rest/domain/" . $domain . "/edit_dialplan/" . $dp);
      return $result;
    }
    
    public function getAdrbook($domain) {
      $result = $this->getRest($this->destUrl . "/rest/domain/" . $domain . "/adrbook/");
      return $result;
    }
    
    public function createAdr($domain, $s) {
      $set = json_encode($s);
      $this->putRest($this->destUrl . "/rest/domain/" . $domain . "/adrbook/", $set);
    }
    
    public function setAdr($domain, $adr, $s) {
      $set = json_encode($s);
      $this->putRest($this->destUrl . "/rest/domain/" . $domain . "/edit_adrbook/" . $adr, $set);
    }
    
    public function getAdr($domain, $adr) {
      $result = $this->getRest($this->destUrl . "/rest/domain/" . $domain . "/edit_adrbook/" . $adr);
      return $result;
    }
    
    public function getWebLangList($domain) {
      $result = $this->getRest($this->destUrl . "/rest/domain/" . $domain . "/account/" . "40" . "/list" . "/list_languages");
      return $result;
    }

    public function getDids(){
      $result = $this->getRest($this->destUrl .  "/rest/system/did");
      return $result;
    }

    public function setDid($s){
        // set format
        /*$s = [
            'cmd' => 'add',
            'did' => $putData['did'],
            'dom' => $putData['domain_id'],
            'user' => $putData['user_id']
            //'out' => false
        ];
        */
        // delete format
        /*  $data = [
            'cmd' => 'delete',
            'did' => $delete_did
            //'out' => false
        ];
      */
      $set = json_encode($s);
      $result = $this->putRest($this->destUrl .  "/rest/system/did", $set);
      return $result;
    }

    public function getWallboard($domain, $ext, $acd)
    {
        $result = $this->getRest($this->destUrl . "/rest/user/" . $ext . "@" . $domain . "/wallboard/" . $acd);
        return $result;
    }
}
