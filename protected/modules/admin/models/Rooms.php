<?php

/**
 * This is the model class for table "{{rooms}}".
 *
 * The followings are the available columns in table '{{rooms}}':
 * @property integer $id_room
 * @property string $nb_room
 * @property integer $nb_of_seats
 * @property string $coordinate_on_map
 * @property integer $id_map
 */
class Rooms extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	private $idRoom;
	public function tableName()
	{
		return '{{rooms}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nb_of_seats, id_map, nb_room, coordinate_on_map, id_building', 'required'),
            array('nb_of_seats, id_map', 'numerical', 'integerOnly'=>true),
			array('nb_room', 'length', 'max'=>10),
			array('coordinate_on_map', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_room, nb_room, nb_of_seats, coordinate_on_map, id_building, id_map', 'safe'),
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
//            'idBuilding' => array(self::HAS_ONE, 'Buildings', 'id_building'),
//            'map' => array(self::HAS_ONE, 'Maps', 'id_map'),
//            'device' => array(self::HAS_MANY, 'Devices', 'id_room')

			'devices' => array(self::HAS_MANY, 'Devices', 'id_room'),
            'residentsOfRooms' => array(self::HAS_MANY, 'ResidentsOfRooms', 'id_room'),
            'roomDevicePatients' => array(self::HAS_MANY, 'RoomDevicePatient', 'id_room'),
            'idBuilding' => array(self::BELONGS_TO, 'Buildings', 'id_building'),
            'idMap' => array(self::BELONGS_TO, 'Maps', 'id_map'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_room' => Yii::t('admin/rooms','Id Room'),
			'nb_room' => Yii::t('admin/rooms','Room number'),
			'nb_of_seats' => Yii::t('admin/rooms','Number of beds'),
			'coordinate_on_map' => Yii::t('admin/rooms','Coordinate on map'),
			'id_map' => Yii::t('admin/rooms','Map'),
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

		$criteria->compare('id_room',$this->id_room);
		$criteria->compare('nb_room',$this->nb_room,true);
		$criteria->compare('nb_of_seats',$this->nb_of_seats);
		$criteria->compare('coordinate_on_map',$this->coordinate_on_map,true);
		$criteria->compare('id_map',$this->id_map);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>25,
            ),
		));
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

	public function beforeDelete()
	{
		$this->idRoom = $this->id_room;
		return parent::beforeDelete();
	}
	public function afterDelete()
	{
		$modDevices = Devices::model()->findAll("id_room = :id_room", array(':id_room'=> $this->idRoom));
		$maxDevices = MaxivoxDevice::model()->findAll("id_room = :id_room", array(':id_room'=> $this->idRoom));
		Devices::model()->updateAll(array('id_room'=>0), 'id_room = :id_room', array(':id_room'=>$this->idRoom));
		MaxivoxDevice::model()->updateAll(array('id_room'=>0), 'id_room = :id_room', array(':id_room'=>$this->idRoom));
		RoomDevicePatient::model()->deleteAll('id_room=:id_room', array(':id_room'=>$this->idRoom));
		ResidentsOfRooms::model()->deleteAll('id_room=:id_room', array(':id_room'=>$this->idRoom));

		Yii::log(CVarDumper::dumpAsString(print_r($modDevices, true), 10),'error','app');
		foreach ($modDevices as $k) {
			EventsManage::model()->deleteAll('id_device = :id_device', array(':id_device' => $k->id_device));
		}
		foreach ($maxDevices as $k) {
			EventsMaxivoxManage::model()->deleteAll('id_maxivox_device = :id_device', array(':id_device' => $k->id_maxivox_device));
		}
		return parent::afterDelete();
	}
}
