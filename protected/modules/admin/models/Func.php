<?php

class Func extends CActiveRecord{
    
    public function rules()
	{
		return array(
			// email has to be a valid email address
            //'tooLarge'=>'The file was larger than {size}MB. Please upload a smaller file.', array('{size}' => $this->MaxSize)),
            //array('provisioning_number, notification_number', 'numerical', 'integerOnly'=>true,),
            array('description_manufacture', 'length', 'max'=>250, 'min'=>3),
            array('number_manufacture', 'length', 'max'=>16, 'min'=>3),
            array('id_support_manufactures,description_manufacture, number_manufacture, status_manufacture', 'safe'),
			// verifyCode needs to be entered correctly
		);
	} 
    
    public function tableName()
    {
        return '{{support_manufactures}}';
    } 
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
?>