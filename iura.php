<?php
    if (isset($_POST['generate'])){

    }
?>
<html>
<head>
    <title>Generate ActivationCode</title>
</head>
<body>
    <div>
        <?php
        if (isset($_POST['generate'])){
            $snMB = (isset($_POST['mb_sn']) && !empty($_POST['mb_sn'])) ? trim($_POST['mb_sn']) : "";
            $macAddress = (isset($_POST['mac_address']) && !empty($_POST['mac_address'])) ? trim($_POST['mac_address']) : "";
            $secret_key = md5(date('Y-m-d'));

            $code = md5(md5(base64_encode($snMB)).md5(base64_encode($macAddress)).$secret_key);

            echo "Activation Key - ".$code."<br/>";
            echo "Secret Key - ".$secret_key."<br/>";

        }
        ?>

    </div>
    <form method="post" action="">
        <table cellpadding="2" cellspacing="2" border="1">
            <tr>
                <td><b>UUID:</b></td>
                <td><input type="text" name="mb_sn" value=""></td>
            </tr>
            <tr>
                <td><b>MAC Address:</b></td>
                <td><input type="text" name="mac_address" value=""></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input  type="submit" name="generate" value="Generate">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>