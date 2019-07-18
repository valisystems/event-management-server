<?php

// http://vodia.com/documentation/huntgroups
$host_address = '10.0.1.39:8090';
$admin_username = 'admin';
$admin_password = 'C1aricom0';

$note = '';
$account = '';
$destination = '';
// $_GET['src'] // e.g 4444@ariole.claricomip.com
// $_GET['dst'] // destination e.g 5555
if (! empty($_GET['src']) && ! empty($_GET['dst']))
{
	$account = $_GET['src'];
	$destination = $_GET['dst'];
	getVodiaPBXDids($host_address, $admin_username, $admin_password, $account, $destination);
}
else
{
	$note =  "Please enter Account and Destination";
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Hunt Group Calls</title>
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="huntgroupcall.js" ></script>
</head>
<body>
	<?php
		if (! empty($note))
		{
			echo  '<b>' . $note . '</b> <br/>';
		}
	?>
	<form method="GET">
		<label>Account: </label>
		<input type="text" name="src" value="<?php echo $account; ?>" />

		<label>Destination: </label>
		<input type="text" name="dst" value="<?php echo $destination; ?>" />

		<input type="Submit" value="Submit">
	</form>

	<button id="ajax_hunt_call">Make Ajax hunt CAll</button>
</body>
</html>


<?php
// get list of DID - Domains - users
function getVodiaPBXDids($host_address , $admin_username, $admin_password, $account, $destination)
{
    $base_64_hash = base64_encode($admin_username . ':' . $admin_password);
    $url = "http://" . $host_address . "/rest/hunt/" . $account . "/dial/" . $destination;
    $header = array(
        "Host: " .  $host_address,
        'Origin: http://' . $host_address,
        "User-Agent: " . $_SERVER['HTTP_USER_AGENT'],
        "Accept: " . "*/*",
        "DNT:" . "1",
        "Authorization: Basic ". $base_64_hash
    );
    return _vodiapbx_curl_call('GET', $url, $header);
}

// curl calls
function _vodiapbx_curl_call($method, $url, $header, $params = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    //curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
    if ($method == 'POST'){
        curl_setopt($ch, CURLOPT_POST, TRUE);
    }
    if (! empty($params))
    {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $output = curl_exec($ch);
    if(curl_errno($ch))
    {
        var_dump(curl_getinfo($ch));
        echo curl_errno($ch) . "\n";
        echo 'error:' . curl_er;
    }
    else
    {
        //var_dump(curl_getinfo($ch));
        //print_r($output);
        curl_close($ch);
        return trim($output);
    }
}