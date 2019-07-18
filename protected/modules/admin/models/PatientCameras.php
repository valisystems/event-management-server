<?php

/**
 * This is the model class for table "{{patient_cameras}}".
 *
 * The followings are the available columns in table '{{patient_cameras}}':
 * @property string $id_patient_cameras
 * @property string $id_patient
 * @property string $url_camera
 *
 * The followings are the available model relations:
 * @property Patients $idPatient
 */
class PatientCameras extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{patient_cameras}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url_camera', 'required'),
			array('id_patient', 'length', 'max'=>10),
			array('url_camera, desc_camera', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_patient_cameras, id_patient, url_camera, desc_camera', 'safe'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_patient_cameras' => 'Id Patient Cameras',
			'id_patient' => 'Id Patient',
			'url_camera' => 'Url Camera',
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

		$criteria->compare('id_patient_cameras',$this->id_patient_cameras,true);
		$criteria->compare('id_patient',$this->id_patient,true);
		$criteria->compare('url_camera',$this->url_camera,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PatientCameras the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}