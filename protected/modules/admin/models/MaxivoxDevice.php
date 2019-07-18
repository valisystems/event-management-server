<?php

/**
 * This is the model class for table "{{maxivox_device}}".
 *
 * The followings are the available columns in table '{{maxivox_device}}':
 * @property integer $id_maxivox_device
 * @property string $dev_desc
 * @property string $dev_address
 * @property integer $id_bulding
 * @property integer $id_map
 * @property integer $id_room
 * @property integer $id_patient
 * @property integer $comon_area
 * @property string $coordonate_on_map
 * @property string $position_popup
 */
class MaxivoxDevice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{maxivox_device}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		// Iura test
		return array(
			array('id_building, id_map, dev_desc, dev_address', 'required'),
			//array('id_room', 'required', 'message'=>Yii::t('admin/maxivox', 'Choose the room')),
			array('id_room', 'validateRoom', 'param1', 'param2'),
			array('dev_desc', 'length', 'max'=>150),
			array('dev_address', 'length', 'max'=>20),
			// The following rule is used by search().
			array('coordonate_on_map', 'length', 'max'=>250),
			// @todo Please remove those attributes that should not be searched.
			array('id_maxivox_device, dev_desc, id_building, id_map, id_room, dev_address, coordonate_on_map, comon_area, id_patient, position_popup', 'safe'),
		);
	}

	public function validateRoom($attribute, $params){
		if (!$this->comon_area) {
			if ($this->$attribute == "")
				$this->addError($attribute, Yii::t('admin/maxivox', 'Choose the room.'));
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idBuilding' => array(self::BELONGS_TO, 'Buildings', 'id_building'),
			'idMap' => array(self::BELONGS_TO, 'Maps', 'id_map'),
			'idRoom' => array(self::BELONGS_TO, 'Rooms', 'id_room'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_maxivox_device' => Yii::t('admin/maxivox', 'Maxivox Device ID'),
			'dev_desc' => Yii::t('admin/maxivox', 'Device Description'),
			'dev_address' => Yii::t('admin/maxivox', 'Device Address'),
			'id_building' => Yii::t('admin/devices','Building'),
			'id_map' => Yii::t('admin/devices','Floor'),
			'id_room' => Yii::t('admin/devices','Room'),
			'language' => Yii::t('admin/devices','Language'),
			'comon_area' => Yii::t('admin/devices','Comon Area'),
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

		$sort       = new CSort;
		$sort->attributes = array(
			'dev_desc' => array(
				'asc' => 'dev_desc',
				'desc' => 'dev_desc desc'
			),
			'dev_address' => array(
				'asc' => 'dev_address',
				'desc' => 'dev_address desc'
			)
		);

		$criteria=new CDbCriteria;

		$criteria->compare('id_maxivox_device',$this->id_maxivox_device);
		$criteria->compare('dev_desc',$this->dev_desc,true);
		$criteria->compare('dev_address',$this->dev_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>25,
			),
			'sort' => $sort
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MaxivoxDevice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Returns the floor list by selected Building
	 * @param integer $id_building
	 * @return array of building to can populate dropdown
	 *
	 */

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
	 * Returns the floor list by selected Building
	 * @param integer $id_building
	 * @return array of building to can populate dropdown
	 *
	 */

	public function getRoomList($id_map = -1){
		$data=Rooms::model()->findAll('id_map=:id_map',
			array(':id_map'=>(int) $id_map));

		$data=CHtml::listData($data,'id_room','nb_room');
		$res = array();
		foreach($data as $value=>$name)
		{
			$res[$value] = $name;
		}
		return $res;
	}

	public function getPatients($id_room = -1){
		$data=Patients::model()->with('residentsOfRooms')->findAll('residentsOfRooms.id_room=:id_room',
			array(':id_room'=>(int) $id_room));
		//$data=CHtml::listData($data,'id_patient','first_name,last_name');
		$arr = array();
		$arr[''] = CHtml::encode(Yii::t('admin/devices', 'Select Patient'));
		if ($data) {
			foreach ($data as $k) {
				$arr[$k->id_patient] = CHtml::encode($k->first_name.' '.$k->last_name);
			}
		}
		return $arr;
	}
}
