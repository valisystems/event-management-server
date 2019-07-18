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
	*	[caller_id_name] => Albu Iurie 
    *   [caller_id_internal] = Home 120021
    *   [caller_id_external] = 416858687
	*	[passwd] => 1234
	*/
	if (count($arr)) {
		$ext_number = $arr['ext_number'];
		$caller_id_name = $arr['caller_id_name'];
		$caller_id_internal = $arr['caller_id_internal'];
		$caller_id_external = $arr['caller_id_external'];
		$passwd = $arr['passwd'];
        $conn = mysql_connect($amp_conf['AMPDBHOST'], $amp_conf['AMPDBUSER'], $amp_conf['AMPDBPASS']);
        mysql_select_db($amp_conf['AMPDBNAME'], $conn);
		$arrSQL = array(
            'INSERT INTO users (extension,password,name,voicemail,ringtimer,noanswer,recording,outboundcid,sipname,noanswer_cid,busy_cid,chanunavail_cid,noanswer_dest,busy_dest,chanunavail_dest) values ("%%EXTENSION%%", "", "%%CALLER_ID%%", "novm", "0", "", "", "\"%%CALLER_ID%%\" <%%CALLER_ID_EXTERNAL%%>", "", "", "", "", "", "", "")',
            'INSERT INTO devices (id,tech,dial,devicetype,user,description,emergency_cid) values ("%%EXTENSION%%","sip","SIP/%%EXTENSION%%","fixed","%%EXTENSION%%","%%CALLER_ID%%","")',
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','secret','%%PASSWD%%',2)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','dtmfmode','inband',3)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','canreinvite','no',4)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','context','from-internal',5)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','host','dynamic',6)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','trustrpid','yes',7)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','sendrpid','no',8)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','type','friend',9)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','nat','yes',10)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','port','5060',11)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','qualify','yes',12)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','qualifyfreq','60',13)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','transport','tcp,udp,tls',14)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','encryption','no',15)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','callgroup','',16)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','pickupgroup','',17)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','disallow','',18)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','allow','',19)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','dial','SIP/%%EXTENSION%%',20)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','accountcode','',21)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','mailbox','%%EXTENSION%%@device',22)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','deny','0.0.0.0/0.0.0.0',23)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','permit','0.0.0.0/0.0.0.0',24)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','account','%%EXTENSION%%',25)",
            "INSERT INTO sip (id, keyword, data, flags) values ('%%EXTENSION%%','callerid','device <%%EXTENSION%%>',26)",
            //"UPDATE admin SET value = 'true' WHERE variable = 'need_reload'"
        );
        $sql = '';
        $sqlExtIfExist = "SELECT * FROM users WHERE extension = '".$ext_number."'";
        $rr = mysql_query($sqlExtIfExist);
        $num_rows = mysql_num_rows($rr);
        if ($num_rows == 0) { 
            /**
             * Command Line Insert Information of extension 
             */
            $asm = new AGI_AsteriskManager();
            if ($asm->connect($astConf['host'], $astConf['user'], $astConf['pass'])) {
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/recording/in/external', 'Val'=>'always' ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/recording/in/internal', 'Val'=>'always' ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/recording/out/internal', 'Val'=>'always' ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/recording/out/external', 'Val'=>'always' ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/recording/ondemand', 'Val'=>'disabled' ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/device', 'Val'=>$ext_number ));
    			$asm->send_request('DBPut', array('Family'=>'DEVICE', 'Key'=>$ext_number.'/user', 'Val'=>$ext_number ));
    			$asm->send_request('DBPut', array('Family'=>'DEVICE', 'Key'=>$ext_number.'/type', 'Val'=>'fixed' ));
    			$asm->send_request('DBPut', array('Family'=>'DEVICE', 'Key'=>$ext_number.'/dial', 'Val'=>"SIP/".$ext_number ));
    			$asm->send_request('DBPut', array('Family'=>'DEVICE', 'Key'=>$ext_number.'/default_user', 'Val'=>$ext_number ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/answermode', 'Val'=>'disabled' ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/ccss/cc_agent_policy', 'Val'=>'generic' ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/ccss/cc_offer_timer', 'Val'=>30 ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/cfringtimer', 'Val'=>0 ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/cidname', 'Val'=>$caller_id_name ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/cidnum', 'Val'=>$caller_id_internal ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/concurrency_limit', 'Val'=>0 ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/queues/qnostate', 'Val'=>'usestate' ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/recording/priority', 'Val'=>0 ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/ringtimer', 'Val'=>0 ));
    			$asm->send_request('DBPut', array('Family'=>'AMPUSER', 'Key'=>$ext_number.'/voicemail', 'Val'=>'default' ));				
    		}

            $patterns = array('%%EXTENSION%%', '%%PASSWD%%', '%%CALLER_ID%%', '%%CALLER_ID_EXTERNAL%%');
            $replace = array($ext_number, $passwd, $caller_id_name, $caller_id_external);
    		foreach ($arrSQL as $k){
                $sql = $k;
                $sql = mb_ereg_replace($patterns[0], $replace[0], $sql);
                $sql = mb_ereg_replace($patterns[1], $replace[1], $sql);
                $sql = mb_ereg_replace($patterns[2], $replace[2], $sql);
                $sql = mb_ereg_replace($patterns[3], $replace[3], $sql);
                mysql_query($sql);
    		}
            //echo $sql;
            unset($freepbx_conf);
			unset($amp_conf);
            exec('/var/lib/asterisk/bin/retrieve_conf');
    		system('asterisk -rx "core reload"  > /dev/null', $rez);
            echo "EXT_CREATE_SUCCESS";
        } else {
            echo "EXT_EXIST";
        } 
		
	}
} else {
	//print_r($acceptedIP);
	echo "Dute acasa - ".$_SERVER['REMOTE_ADDR'];
}
?>