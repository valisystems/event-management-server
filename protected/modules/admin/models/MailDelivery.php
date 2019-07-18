<?php

class MailDelivery extends CActiveRecord{
    public $host;
    public $port;
    public $security_type;
    public $login_name;
    public $passwd;
    public $from_text;
    
    public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('host, port, login_name, passwd', 'required'),
			// email has to be a valid email address
            //'tooLarge'=>'The file was larger than {size}MB. Please upload a smaller file.', array('{size}' => $this->MaxSize)),
            array('login_name', 'email'),
            array('security_type, from_text, id_mail_settings', 'safe')
			// verifyCode needs to be entered correctly
		);
	} 
    
    public function tableName()
    {
        return '{{mail_settings}}';
    } 
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
?>