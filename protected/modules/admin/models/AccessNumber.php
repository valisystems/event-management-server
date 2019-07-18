<?php

class AccessNumber extends CActiveRecord{
    public $provisioning_number;
    public $notification_number;
    
    public function rules()
	{
		return array(
			// name, email, subject and body are required
			//array('host, port, login_name, passwd', 'required'),
			// email has to be a valid email address
            //'tooLarge'=>'The file was larger than {size}MB. Please upload a smaller file.', array('{size}' => $this->MaxSize)),
            array('provisioning_number, notification_number, id_access_number', 'safe')
			// verifyCode needs to be entered correctly
		);
	} 
    
    public function tableName()
    {
        return '{{access_number}}';
    } 
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
?>