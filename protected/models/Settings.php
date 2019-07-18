<?php

/**
 * This is the model class for table "{{settings}}".
 *
 * The followings are the available columns in table '{{settings}}':
 * @property string $id_settings
 * @property string $site_name
 * @property string $site_email
 * @property string $logo_path
 * @property string $header
 * @property string $footer
 * @property string $default_lang
 * @property string $tts_voice
 * @property string $provisioning_number
 * @property string $notification_number
 * @property integer $extension_limit_number
 * @property string $sms_url
 */
class Settings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{settings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('extension_limit_number', 'numerical', 'integerOnly'=>true),
			array('site_name, site_email', 'length', 'max'=>100),
			array('activation_key, secret_key', 'length', 'max'=>100),
			array('logo_path', 'length', 'max'=>150),
			array('default_lang, tts_voice', 'length', 'max'=>3),
			array('provisioning_number, notification_number', 'length', 'max'=>12),
			array('sms_url', 'length', 'max'=>200),
			array('header, footer', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_settings, site_name, site_email, logo_path, header, footer, default_lang, tts_voice, provisioning_number, notification_number, extension_limit_number, sms_url, activation_key, secret_key', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_settings' => 'Id Settings',
			'site_name' => 'Site Name',
			'site_email' => 'Site Email',
			'logo_path' => 'Logo Path',
			'header' => 'Header',
			'footer' => 'Footer',
			'default_lang' => 'Default Lang',
			'tts_voice' => 'Tts Voice',
			'provisioning_number' => 'Provisioning Number',
			'notification_number' => 'Notification Number',
			'extension_limit_number' => 'Extension Limit Number',
			'sms_url' => 'Sms Url',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_settings',$this->id_settings,true);
		$criteria->compare('site_name',$this->site_name,true);
		$criteria->compare('site_email',$this->site_email,true);
		$criteria->compare('logo_path',$this->logo_path,true);
		$criteria->compare('header',$this->header,true);
		$criteria->compare('footer',$this->footer,true);
		$criteria->compare('default_lang',$this->default_lang,true);
		$criteria->compare('tts_voice',$this->tts_voice,true);
		$criteria->compare('provisioning_number',$this->provisioning_number,true);
		$criteria->compare('notification_number',$this->notification_number,true);
		$criteria->compare('extension_limit_number',$this->extension_limit_number);
		$criteria->compare('sms_url',$this->sms_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Settings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
