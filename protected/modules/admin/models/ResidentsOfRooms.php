<?php

/**
 * This is the model class for table "{{residents_of_rooms}}".
 *
 * The followings are the available columns in table '{{residents_of_rooms}}':
 * @property string $id_resident_of_room
 * @property string $id_room
 * @property string $id_patient
 *
 * The followings are the available model relations:
 * @property Patients $idPatient
 * @property Rooms $idRoom
 */
class ResidentsOfRooms extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{residents_of_rooms}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_room, id_patient', 'required'),
			array('id_room, id_patient', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_resident_of_room, id_room, id_patient', 'safe'),
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
			'idPatient' => array(self::BELONGS_TO, 'Patients', 'id_patient'),
			'idRoom' => array(self::BELONGS_TO, 'Rooms', 'id_room'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_resident_of_room' => 'Id Resident Of Room',
			'id_room' => 'Id Room',
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

		$criteria->compare('id_resident_of_room',$this->id_resident_of_room,true);
		$criteria->compare('id_room',$this->id_room,true);
		$criteria->compare('id_patient',$this->id_patient,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ResidentsOfRooms the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
