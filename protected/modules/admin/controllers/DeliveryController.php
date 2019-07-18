<?php
class DeliveryController extends Controller{
    
    
    public $layout = '/layouts/column1';
    public function init(){
        parent::init();
        $cs = Yii::app()->clientScript; //
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.placeholder.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.maskedinput.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.inputlimiter.1.3.1.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/delivery.js', CClientScript::POS_END);

        
    }
    public function actionIndex()
    {
        $model = new MailDelivery;
        $model2 = new SmsNumber;
        $st = $model->findAll(array('order'=>'id_mail_settings ASC', 'limit'=>1));
        if (count($st)) 
            $newModel = $st[0];
        else
            $newModel = $model;
        
        $st2 = $model2->findAll(array('order'=>'id_settings ASC', 'limit'=>1));
        if (count($st2)) 
            $newAccessNumber = $st2[0];
        else
            $newAccessNumber = $model2;

        $this->render('index', array(
            'modelMail' => $newModel,
            'modelSms' => $newAccessNumber
        ));
    }
    
    public function actionMailSave(){
        $tmpModel = MailDelivery::model()->find();
        if (count($tmpModel))
            $model = $tmpModel;
        else
            $model = new MailDelivery;

        if (isset($_POST['MailDelivery'])) {
            $model->attributes = $_POST['MailDelivery'];
            $valid = $model->validate();
            if ($valid) {
                $id_mail_settings = (isset($model->id_mail_settings) && !empty($model->id_mail_settings)) ? $model->id_mail_settings : null;
                if (empty($id_mail_settings))
                    $model->isNewRecord = true;

                $host = $model->host;
                $port = $model->port;
                $security_type = $model->security_type;
                $login_name = $model->login_name;
                $passwd = $model->passwd;
                $from_text = $model->from_text;
                
                $arr = array(
                   'host'=>$host,
                   'port'=>$port,
                   'security_type'=>$security_type,
                   'login_name'=>$login_name,
                   'passwd'=>$passwd,
                   'from_text'=>$from_text,
                );

                $arrSuccess = array();


                if (empty($id_mail_settings)) {
                    $transaction=$model->dbConnection->beginTransaction();
                    try {
                        if ($model->save()) 
                        {
                            $transaction->commit();
                            $arrSuccess = array('success'=>'yes');

                        }
                        else
                            $transaction->rollback();
                    } 
                    catch (Exception $e) {
                        $transaction->rollback();
                        throw $e;
                    }
                    
                } else {
                    MailDelivery::model()->updateByPk($id_mail_settings, $arr);
                    $arrSuccess = array('success'=>'update');
                    
                }
                header("Content-Type: text/plain");
                $result=htmlspecialchars(json_encode( $arrSuccess), ENT_NOQUOTES);
                echo $result;
            } else {
                header("Content-Type: text/plain");
                $result=htmlspecialchars(json_encode($model->getErrors()), ENT_NOQUOTES);
                echo $result;
            } 
            Yii::app()->end();
        }
    }

    public function actionTestEmail(){
        if (Yii::app()->request->isAjaxRequest) {
            $connection=Yii::app()->db;
            $cmd = $connection->createCommand();
            $smtpSettings = $cmd->select('*')
                ->from('{{mail_settings}}')
                ->limit('1')
                ->queryRow();
            $cmd->reset();
            $email_to_send = (isset($_POST['email_to_send']) && !empty($_POST['email_to_send'])) ? trim($_POST['email_to_send']) : "";
            if (count($smtpSettings) && !empty($email_to_send)) {
                $mail = new YiiMailer();
                $mail->IsSMTP();
                //$mail->SMTPDebug = 2;
                $mail->Host = $smtpSettings['host'];
                $mail->Port = $smtpSettings['port'];
                $mail->SMTPAuth = true;
                $mail->IsHTML(true);
                $mail->clearView();
                $mail->clearLayout();
                $mail->SMTPSecure = $smtpSettings['security_type'];
                $mail->Username = $smtpSettings['login_name'];
                $mail->Password = $smtpSettings['passwd'];

                $mail->setFrom($smtpSettings['login_name'],$smtpSettings['from_text']);
                $mail->setTo($email_to_send);
                $mail->setSubject(Yii::t('admin/delivery', "Test Email"));
                $mail->setBody(Yii::t('admin/delivery', "E-mail test, please not reply to this e-mail."));

                if ($mail->send()) {
                    $statusEmail = $mail->getError();
                    $statusOfNotification = 1;
                    //print_r($mail);
                    $arr = array('success'=>'Successfuly Send');
                } else {
                    $statusEmail = $mail->getError();
                    $statusOfNotification = 0;
                    //print_r($mail);
                    $arr = array('error'=>'Not Send', 'msg' => $statusEmail);
                }

                header("Content-Type: text/plain");
                $result=htmlspecialchars(json_encode( $arr), ENT_NOQUOTES);
                echo $result;
            }
        }
    }

    public function actionTestSMS(){
        if (Yii::app()->request->isAjaxRequest) {
            $your_sms = (isset($_POST['sms_to_send']) && !empty($_POST['sms_to_send'])) ? trim($_POST['sms_to_send']) : "";
            $settingsModel = Settings::model()->find();
            $smsUrl = $settingsModel->sms_url;
            $tmp = $your_sms;
            $tmp = preg_replace("/\s/","",$tmp);
            $tmp = preg_replace("/-/","",$tmp);
            $tmp = str_replace("(","",$tmp);
            $tmp = str_replace(")","",$tmp);
            $your_sms = $tmp;
            if ($your_sms != "" && !empty($smsUrl)) {
                $smsNumber = $your_sms;
                $url = $smsUrl . "&phonenumber={$smsNumber}&text=" . urlencode(Yii::t('admin/delivery', "Test SMS"));

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                $response = curl_exec($ch);
                //print_r($response);
                //echo $response;  //OK: b555c7e2-1b70-4010-84de-ed6da18128c5
                $status = 1;//(substr($response, 0, 2) == 'OK') ? 1 : 0;
                header("Content-Type: text/plain");
                if ($status)
                    $result=htmlspecialchars(json_encode( array('success'=>Yii::t('admin/delivery', "Successfuly Sended"))), ENT_NOQUOTES);
                else
                    $result=htmlspecialchars(json_encode( array('error'=>"Not Send", "msg" => Yii::t('admin/delivery', "SMS not sended"), 'response'=>$response)), ENT_NOQUOTES);
                echo $result;
            }
        }
    }
    
    public function actionSmsSave(){
        $model = new SmsNumber;
        if (isset($_POST['SmsNumber'])) {
            $model->attributes = $_POST['SmsNumber'];
            $valid = $model->validate();
            if ($valid) {
                $id_settings = $model->id_settings;
                $sms_url = $model->sms_url;
                
                $arr = array(
                   'sms_url'=>$sms_url,
                );

                $arrSuccess = array();
                if (empty($id_settings)) {
                    $transaction=$model->dbConnection->beginTransaction();
                    try {
                        if ($model->save()) 
                        {
                            $transaction->commit();
                            $arrSuccess = array('success'=>'yes');

                        }
                        else
                            $transaction->rollback();
                    } 
                    catch (Exception $e) {
                        $transaction->rollback();
                        throw $e;
                    }
                    
                } else {
                    SmsNumber::model()->updateByPk($id_settings, $arr);
                    $arrSuccess = array('success'=>'update');
                    
                }
                header("Content-Type: text/plain");
                $result=htmlspecialchars(json_encode( $arrSuccess), ENT_NOQUOTES);
                echo $result;
            } else {
                header("Content-Type: text/plain");
                $result=htmlspecialchars(json_encode($model->getErrors()), ENT_NOQUOTES);
                echo $result;
            } 
            Yii::app()->end();
        }
    }
}

?>