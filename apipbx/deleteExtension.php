<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
include "./includes/conf.php";
if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], $acceptedIP)) {
	require_once "/etc/freepbx.conf";
	require_once $PATH_FREE_PBX_CLASS."freepbx_conf.class.php";
	require_once($PATH_FREE_PBX_CLASS . 'db_connect.php');
	$freepbx_conf =& freepbx_conf::create();
	$amp_conf = array();
	$amp_conf =& $freepbx_conf->parse_amportal_conf("/etc/amportal.conf",$amp_conf);
	
	$arr = json_decode( file_get_contents("php://input"),1);
    /**
	*	[ext_number] => 120021 
	*/
    if (count($arr)) {
		$ext_number = $arr['ext_number'];
        $conn = mysql_connect($amp_conf['AMPDBHOST'], $amp_conf['AMPDBUSER'], $amp_conf['AMPDBPASS']);
        mysql_select_db($amp_conf['AMPDBNAME'], $conn);
		$arrSQL = array(
            'DELETE FROM users WHERE extension = "%%EXTENSION%%"',
            'DELETE FROM devices WHERE id = "%%EXTENSION%%"',
            "DELETE FROM sip WHERE id = '%%EXTENSION%%'",
        );
        
        $asm = new AGI_AsteriskManager();
        if ($asm->connect($astConf['host'], $astConf['user'], $astConf['pass'])) {
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/recording/in/external'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/recording/in/internal'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/recording/out/internal'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/recording/out/external'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/recording/ondemand'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/device'));
			$asm->send_request('DBDel', array('Family'=>'DEVICE', 'Key'=>$ext_number.'/user'));
			$asm->send_request('DBDel', array('Family'=>'DEVICE', 'Key'=>$ext_number.'/type'));
			$asm->send_request('DBDel', array('Family'=>'DEVICE', 'Key'=>$ext_number.'/dial'));
			$asm->send_request('DBDel', array('Family'=>'DEVICE', 'Key'=>$ext_number.'/default_user'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/answermode'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/ccss/cc_agent_policy'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/ccss/cc_offer_timer'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/cfringtimer'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/cidname'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/cidnum'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/concurrency_limit'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/queues/qnostate'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/recording/priority'));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/ringtimer' ));
			$asm->send_request('DBDel', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/voicemail'));				
    	}
    	$patterns = array('%%EXTENSION%%');
        $replace = array($ext_number);
		foreach ($arrSQL as $k){
            $sql = $k;
            $sql = ereg_replace($patterns[0], $replace[0], $sql); 
            mysql_query($sql);
		}
        //echo $sql;
        unset($freepbx_conf);
		unset($amp_conf);
        exec('/var/lib/asterisk/bin/retrieve_conf');
		system('asterisk -rx "core reload"  > /dev/null', $rez);
        echo "EXT_DELETED_SUCCESS";
    }
}
?>