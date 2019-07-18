<?php

/**
 * This is the model class for table "{{emergency_contact}}".
 *
 * The followings are the available columns in table '{{emergency_contact}}':
 * @property string $id_emergency_contact
 * @property string $id_patient
 * @property string $name_contact
 * @property string $phone
 * @property string $mobile
 * @property string $email
 * @property string $sms
 * @property string $login_id
 * @property string $passwd
 *
 * The followings are the available model relations:
 * @property Patients $idPatient
 */
class EmergencyContact extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{emergency_contact}}';
	}
    
    public $contact_voip;
    public $contact_sms;
    public $contact_email;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_patient, name_contact, phone, mobile, email, sms, login_id, passwd', 'required'),
			array('id_patient', 'length', 'max'=>10),
			array('name_contact', 'length', 'max'=>80),
			array('phone, mobile, sms', 'length', 'max'=>15),
			array('email', 'length', 'max'=>150),
			array('login_id, passwd', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_emergency_contact, id_patient, name_contact, phone, mobile, email, sms, login_id, passwd', 'safe', 'on'=>'search'),
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
			'id_emergency_contact' => 'Id Emergency Contact',
			'id_patient' => 'Id Patient',
			'name_contact' => 'Name Contact',
			'phone' => 'Phone',
			'mobile' => 'Mobile',
			'email' => 'Email',
			'sms' => 'Sms',
			'login_id' => 'Login',
			'passwd' => 'Passwd',
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

		$criteria->compare('id_emergency_contact',$this->id_emergency_contact,true);
		$criteria->compare('id_patient',$this->id_patient,true);
		$criteria->compare('name_contact',$this->name_contact,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('sms',$this->sms,true);
		$criteria->compare('login_id',$this->login_id,true);
		$criteria->compare('passwd',$this->passwd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmergencyContact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
