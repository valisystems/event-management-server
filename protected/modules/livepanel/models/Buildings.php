<?php

/**
 * This is the model class for table "{{buildings}}".
 *
 * The followings are the available columns in table '{{buildings}}':
 * @property string $id_building
 * @property string $name
 * @property string $address
 *
 * The followings are the available model relations:
 * @property Asterisk[] $asterisks
 * @property Devices[] $devices
 * @property Maps[] $maps
 * @property Rooms[] $rooms
 */
class Buildings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{buildings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>100),
			array('address', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_building, name, address', 'safe', 'on'=>'search'),
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
			'asterisks' => array(self::HAS_MANY, 'Asterisk', 'id_building'),
			'devices' => array(self::HAS_MANY, 'Devices', 'id_building'),
			'maps' => array(self::HAS_MANY, 'Maps', 'id_building'),
			'rooms' => array(self::HAS_MANY, 'Rooms', 'id_building'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_building' => 'Id Building',
			'name' => 'Name',
			'address' => 'Address',
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

		$criteria->compare('id_building',$this->id_building,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Buildings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
