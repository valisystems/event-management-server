<?php

/**
 * This is the model class for table "{{receiver}}".
 *
 * The followings are the available columns in table '{{receiver}}':
 * @property string $id_receiver
 * @property string $id_global_event_template
 * @property string $id_system_sms_number
 * @property string $id_system_email
 *
 * The followings are the available model relations:
 * @property GlobalEventTemplate $idGlobalEventTemplate
 * @property SystemSmsNumbers $idSystemSmsNumber
 * @property SystemEmail $idSystemEmail
 */
class Receiver extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{receiver}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id_global_event_template', 'required'),
			array('id_global_event_template, id_global_event_pendant_template, id_global_event_maxivox_template, id_system_sms_number, id_system_email, id_command, id_iodevice', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_receiver, id_global_event_template, id_system_sms_number, id_system_email, id_http_inventory, id_global_event_pendant_template, id_global_event_maxivox_template, id_command, id_iodevice', 'safe'),
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
			'idGlobalEventTemplate' => array(self::BELONGS_TO, 'GlobalEventTemplate', 'id_global_event_template'),
			'idSystemSmsNumber' => array(self::BELONGS_TO, 'SystemSmsNumbers', 'id_system_sms_number'),
			'idSystemEmail' => array(self::BELONGS_TO, 'SystemEmail', 'id_system_email'),
			'idCommand' => array(self::BELONGS_TO, 'Command', 'id_command'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_receiver' => 'Id Receiver',
			'id_global_event_template' => 'Id Global Event Template',
			'id_system_sms_number' => 'Id System Sms Number',
			'id_system_email' => 'Id System Email',
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

		$criteria->compare('id_receiver',$this->id_receiver,true);
		$criteria->compare('id_global_event_template',$this->id_global_event_template,true);
		$criteria->compare('id_system_sms_number',$this->id_system_sms_number,true);
		$criteria->compare('id_system_email',$this->id_system_email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Receiver the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
