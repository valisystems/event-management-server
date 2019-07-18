<?php

/**
 * SystemForm class.
 * SystemForm is the data structure for keeping
 * settings form data. It is used by the 'Setting' action of 'DefaultController'.
 */
class SmsNumber extends CActiveRecord
{
    public $site_name;
    public $logo_path;
    public $header;
    public $footer;
    public $default_lang;
      
    public function rules()
	{
		return array(
            array('sms_url','url', 'allowEmpty'=>false),
            array('id_settings, sms_url', 'safe')
			// verifyCode needs to be entered correctly
		);
	} 
     public function tableName()
    {
        return '{{settings}}';
    } 
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
?>