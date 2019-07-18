<?php

/**
 * This is the model class for table "{{maps}}".
 *
 * The followings are the available columns in table '{{maps}}':
 * @property string $id_map
 * @property string $name_map
 * @property string $description
 * @property string $id_building
 * @property string $path_to_img
 *
 * The followings are the available model relations:
 * @property Devices[] $devices
 * @property Devices[] $devices1
 * @property Buildings $idBuilding
 * @property ResidentsOfRooms[] $residentsOfRooms
 * @property RoomDevicePatient[] $roomDevicePatients
 * @property Rooms $idMap
 * @property Rooms[] $rooms
 */
class Rooms extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{maps}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name_map', 'length', 'max'=>100),
			array('description, path_to_img', 'length', 'max'=>250),
			array('id_building', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_map, name_map, description, id_building, path_to_img', 'safe', 'on'=>'search'),
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
			'devices' => array(self::HAS_MANY, 'Devices', 'id_map'),
			'devices1' => array(self::HAS_MANY, 'Devices', 'id_room'),
			'idBuilding' => array(self::BELONGS_TO, 'Buildings', 'id_building'),
			'residentsOfRooms' => array(self::HAS_MANY, 'ResidentsOfRooms', 'id_room'),
			'roomDevicePatients' => array(self::HAS_MANY, 'RoomDevicePatient', 'id_room'),
			'idMap' => array(self::BELONGS_TO, 'Rooms', 'id_map'),
			'rooms' => array(self::HAS_MANY, 'Rooms', 'id_map'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_map' => 'Id Map',
			'name_map' => 'Name Map',
			'description' => 'Description',
			'id_building' => 'Id Building',
			'path_to_img' => 'Path To Img',
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

		$criteria->compare('id_map',$this->id_map,true);
		$criteria->compare('name_map',$this->name_map,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('id_building',$this->id_building,true);
		$criteria->compare('path_to_img',$this->path_to_img,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rooms the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
