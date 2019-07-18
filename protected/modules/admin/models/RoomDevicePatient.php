<?php

/**
 * This is the model class for table "{{room_device_patient}}".
 *
 * The followings are the available columns in table '{{room_device_patient}}':
 * @property string $id_room_device_patient
 * @property string $id_room
 * @property string $id_device
 * @property string $id_patient
 *
 * The followings are the available model relations:
 * @property Devices $idDevice
 * @property Patients $idPatient
 * @property Rooms $idRoom
 */
class RoomDevicePatient extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{room_device_patient}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id_room', 'required'),
			array('id_room, id_device, id_patient', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_room_device_patient, id_room, id_device, id_patient', 'safe'),
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
			'idDevice' => array(self::BELONGS_TO, 'Devices', 'id_device'),
			//'idPatient' => array(self::BELONGS_TO, 'Patients', 'id_patient'),
			'idRoom' => array(self::BELONGS_TO, 'Rooms', 'id_room'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_room_device_patient' => 'Id Room Device Patient',
			'id_room' => 'Id Room',
			'id_device' => 'Id Device',
			'id_patient' => 'Id Patient',
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

		$criteria->compare('id_room_device_patient',$this->id_room_device_patient,true);
		$criteria->compare('id_room',$this->id_room,true);
		$criteria->compare('id_device',$this->id_device,true);
		$criteria->compare('id_patient',$this->id_patient,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RoomDevicePatient the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
