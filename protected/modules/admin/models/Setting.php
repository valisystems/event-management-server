<?php

/**
 * SystemForm class.
 * SystemForm is the data structure for keeping
 * settings form data. It is used by the 'Setting' action of 'DefaultController'.
 */
class Setting extends CActiveRecord
{
    public $site_name;
    public $logo_path;
    public $header;
    public $footer;
    public $default_lang;
      
    public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('site_name, site_email', 'required'),
			// email has to be a valid email address
            //'tooLarge'=>'The file was larger than {size}MB. Please upload a smaller file.', array('{size}' => $this->MaxSize)),
            array('site_email', 'email'),
            array('update_ems_server', 'url'),
            array('sms_url','url', 'allowEmpty'=>true),
            //array('discovery', 'numerical'),
            array('header, footer, logo_path, default_lang, id_settings, tts_voice, sms_url, update_ems_server, update_ems_key, discovery, default_building, default_map', 'safe')
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
    public function beforeValidate() {
        //Yii::log(CVarDumper::dumpAsString(print_r($this->discovery), 10),'error','app');
        return parent::beforeValidate();
    }
    public function getFloorList($id_building = -1){
        $data=Maps::model()->findAll('id_building=:id_building',
            array(':id_building'=>(int) $id_building));

        $data=CHtml::listData($data,'id_map','name_map');
        $res = array();
        foreach($data as $value=>$name)
        {
            $res[$value] = $name;
        }
        return $res;
    }
}
?>