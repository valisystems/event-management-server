<?php

/**
 * This is the model class for table "{{pendant_devices}}".
 *
 * The followings are the available columns in table '{{pendant_devices}}':
 * @property integer $id_pendant_device
 * @property string $description
 * @property string $serial_number
 * @property string $pendant_type
 * @property string $id_patient
 *
 * The followings are the available model relations:
 * @property Patients $idPatient
 */
class PendantDevices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pendant_devices}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description', 'length', 'max'=>150),
			array('serial_number', 'length', 'max'=>20),
			array('id_patient', 'length', 'max'=>11),
			array('id_pendant_type', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_pendant_device, description, serial_number, id_pendant_type, id_patient', 'safe'),
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
			'idPendantType' => array(self::BELONGS_TO, 'PendantType', 'id_pendant_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_pendant_device' => Yii::t('admin/pendantdevice','Id Pendant Device'),
			'description' => Yii::t('admin/pendantdevice','Description'),
			'serial_number' => Yii::t('admin/pendantdevice','Serial Number'),
			'id_pendant_type' => Yii::t('admin/pendantdevice','Pendant Type'),
			'id_patient' => Yii::t('admin/pendantdevice','Patient')
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
		$sort       = new CSort;
		$sort->attributes = array(
			'description' => array(
				'asc' => 'description',
				'desc' => 'description desc'
			),
			'serial_number' => array(
				'asc' => 'serial_number',
				'desc' => 'serial_number desc'
			),
			'id_pendant_type' => array(
				'asc' => 'idPendantType.description',
				'desc' => 'idPendantType.description DESC'
			),
			'id_patient' => array(
				'asc' => 'idPatient.first_name',
				'desc' => 'idPatient.first_name DESC'
			)
		);

		$criteria->compare('id_pendant_device',$this->id_pendant_device);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('serial_number',$this->serial_number,true);
		$criteria->compare('id_pendant_type',$this->id_pendant_type,true);
		$criteria->compare('id_patient',$this->id_patient,true);

		$criteria->with = array('idPatient','idPendantType');

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
	 * @return PendantDevices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
