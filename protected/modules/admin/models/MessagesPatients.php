<?php

/**
 * This is the model class for table "{{messages_patients}}".
 *
 * The followings are the available columns in table '{{messages_patients}}':
 * @property string $id_message_patient
 * @property string $id_patient
 * @property string $messages_type
 * @property string $text_message
 *
 * The followings are the available model relations:
 * @property Patients $idPatient
 */
class MessagesPatients extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{messages_patients}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('messages_type, text_message', 'required'),
			array('id_patient', 'length', 'max'=>10),
			array('messages_type', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_message_patient, id_patient, messages_type, text_message', 'safe', 'on'=>'search'),
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
			'id_message_patient' => 'Id Message Patient',
			'id_patient' => 'Id Patient',
			'messages_type' => 'Messages Type',
			'text_message' => 'Text Message',
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

		$criteria->compare('id_message_patient',$this->id_message_patient,true);
		$criteria->compare('id_patient',$this->id_patient,true);
		$criteria->compare('messages_type',$this->messages_type,true);
		$criteria->compare('text_message',$this->text_message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MessagesPatients the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
