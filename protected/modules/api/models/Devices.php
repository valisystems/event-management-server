<?php

/**
 * This is the model class for table "{{devices}}".
 *
 * The followings are the available columns in table '{{devices}}':
 * @property string $id_device
 * @property string $id_building
 * @property string $id_map
 * @property string $id_room
 * @property string $device_description
 * @property string $serial_number
 * @property string $language
 * @property integer $activity_timer
 * @property string $activity_timer_status
 * @property integer $nurce_aknowege
 * @property string $nurce_aknowege_status
 * @property integer $call_duration
 * @property integer $auto_test
 * @property string $auto_test_status
 * @property string $comon_area
 * @property integer $id_access_number
 * @property string $type_access_number
 *
 * The followings are the available model relations:
 * @property DeviceNumberCall[] $deviceNumberCalls
 * @property Buildings $idBuilding
 * @property Maps $idMap
 * @property Rooms $idRoom
 * @property EventsManage[] $eventsManages
 * @property ExtensionInfo[] $extensionInfos
 * @property RoomDevicePatient[] $roomDevicePatients
 */
class Devices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{devices}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_building, id_map, id_room, device_description, serial_number, language, activity_timer, nurce_aknowege, call_duration, auto_test, id_access_number, type_access_number', 'required'),
			array('activity_timer, nurce_aknowege, call_duration, auto_test, id_access_number', 'numerical', 'integerOnly'=>true),
			array('id_building, id_map, id_room, type_access_number', 'length', 'max'=>10),
			array('device_description', 'length', 'max'=>250),
			array('serial_number', 'length', 'max'=>50),
			array('language', 'length', 'max'=>3),
			array('activity_timer_status, nurce_aknowege_status, auto_test_status, comon_area', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_device, id_building, id_map, id_room, device_description, serial_number, language, activity_timer, activity_timer_status, nurce_aknowege, nurce_aknowege_status, call_duration, auto_test, auto_test_status, comon_area, id_access_number, type_access_number', 'safe', 'on'=>'search'),
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
			'deviceNumberCalls' => array(self::HAS_MANY, 'DeviceNumberCall', 'id_device'),
			'idBuilding' => array(self::BELONGS_TO, 'Buildings', 'id_building'),
			'idMap' => array(self::BELONGS_TO, 'Maps', 'id_map'),
			'idRoom' => array(self::BELONGS_TO, 'Rooms', 'id_room'),
			'eventsManages' => array(self::HAS_MANY, 'EventsManage', 'id_device'),
			'extensionInfos' => array(self::HAS_MANY, 'ExtensionInfo', 'id_device'),
			'roomDevicePatients' => array(self::HAS_MANY, 'RoomDevicePatient', 'id_device'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_device' => 'Id Device',
			'id_building' => 'Id Building',
			'id_map' => 'Id Map',
			'id_room' => 'Id Room',
			'device_description' => 'Device Description',
			'serial_number' => 'Serial Number',
			'language' => 'Language',
			'activity_timer' => 'Activity Timer',
			'activity_timer_status' => 'Activity Timer Status',
			'nurce_aknowege' => 'Nurce Aknowege',
			'nurce_aknowege_status' => 'Nurce Aknowege Status',
			'call_duration' => 'Call Duration',
			'auto_test' => 'Auto Test',
			'auto_test_status' => 'Auto Test Status',
			'comon_area' => 'Comon Area',
			'id_access_number' => 'Id Access Number',
			'type_access_number' => 'Type Access Number',
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

		$criteria->compare('id_device',$this->id_device,true);
		$criteria->compare('id_building',$this->id_building,true);
		$criteria->compare('id_map',$this->id_map,true);
		$criteria->compare('id_room',$this->id_room,true);
		$criteria->compare('device_description',$this->device_description,true);
		$criteria->compare('serial_number',$this->serial_number,true);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('activity_timer',$this->activity_timer);
		$criteria->compare('activity_timer_status',$this->activity_timer_status,true);
		$criteria->compare('nurce_aknowege',$this->nurce_aknowege);
		$criteria->compare('nurce_aknowege_status',$this->nurce_aknowege_status,true);
		$criteria->compare('call_duration',$this->call_duration);
		$criteria->compare('auto_test',$this->auto_test);
		$criteria->compare('auto_test_status',$this->auto_test_status,true);
		$criteria->compare('comon_area',$this->comon_area,true);
		$criteria->compare('id_access_number',$this->id_access_number);
		$criteria->compare('type_access_number',$this->type_access_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Devices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
