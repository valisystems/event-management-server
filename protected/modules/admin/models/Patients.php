<?php

/**
 * This is the model class for table "{{patients}}".
 *
 * The followings are the available columns in table '{{patients}}':
 * @property string $id_patient
 * @property string $first_name
 * @property string $last_name
 * @property string $avatar_path
 * @property string $afliction
 * @property string $language
 * @property string $voice_message
 *
 * The followings are the available model relations:
 * @property EmergencyContact[] $emergencyContacts
 * @property MessagesPatients[] $messagesPatients
 * @property PatientsNotes[] $patientsNotes
 * @property ResidentsOfRooms[] $residentsOfRooms
 * @property RoomDevicePatient[] $roomDevicePatients
 */
class Patients extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $id_building;
    public $id_room;
    public $cameraUrl;
    public $patient_notes;
    public $emergency;
    public $em_id;
    public $em_name;
    public $em_phone;
    public $em_cel;
    public $em_email;
    public $em_sms;
    public $em_login;
    public $em_pass;
    public $nb_room;
    public $url_camera;
    public $patient_name;
    /*public $text_description;
    public $text_message;
    public $email_description;
    public $email_message;
    public $voice_description;
    //public $voice_message;*/
    
	public function tableName()
	{
		return '{{patients}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('first_name, last_name, afliction', 'length', 'max'=>80),
			array('avatar_path', 'length', 'max'=>150),
            //array('text_desc, email_description, voice_description', 'length', 'max'=>150),
			array('language, id_room', 'length', 'max'=>3),
            //array('cameraUrl', 'url'),
            array('first_name, last_name, afliction', 'length', 'max'=>150),
            array('first_name, last_name', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_patient, first_name, last_name, avatar_path, afliction, language, text_desc, email_desc, voice_desc, voice_message, text_message, email_message, id_building, cameraUrl, patient_notes, notes_file, notes, emergency', 'safe'),
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
			'emergencyContacts' => array(self::HAS_MANY, 'EmergencyContact', 'id_patient'),
			'messagesPatients' => array(self::HAS_MANY, 'MessagesPatients', 'id_patient'),
			'cameraPatients' => array(self::HAS_MANY, 'PatientCameras', 'id_patient'),
			'patientsNotes' => array(self::HAS_MANY, 'PatientsNotes', 'id_patient'),
			'residentsOfRooms' => array(self::HAS_MANY, 'ResidentsOfRooms', 'id_patient', 'together'=>true),
			'roomDevicePatients' => array(self::HAS_ONE, 'RoomDevicePatient', 'id_patient'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_patient' => Yii::t('admin/patients', 'Id Patient'),
			'id_room' => Yii::t('admin/patients', 'Room Number'),
			'id_building' => Yii::t('admin/patients', 'Building'),
			'first_name' => Yii::t('admin/patients', 'First Name'),
			'last_name' => Yii::t('admin/patients', 'Last Name'),
			'avatar_path' => Yii::t('admin/patients', 'Avatar'),
			'afliction' => Yii::t('admin/patients', 'Afliction'),
			'language' => Yii::t('admin/patients', 'Language'),
			'voice_message' => Yii::t('admin/patients', 'Voice Message'),
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
        /*
        SELECT p.first_name, p.last_name, p.avatar_path, p.text_desc,ro.nb_room FROM mia_patients p
        INNER JOIN mia_residents_of_rooms rr ON rr.id_patient = p.id_patient
        INNER JOIN mia_rooms ro ON ro.id_room = rr.id_room
        */
		$criteria=new CDbCriteria;
        //$criteria->select = '*';
		$criteria->compare('id_patient',$this->id_patient,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		//$criteria->compare('avatar_path',$this->avatar_path,true);
		//$criteria->compare('afliction',$this->afliction,true);
		$criteria->compare('language',$this->language,true);
		//$criteria->compare('voice_message',$this->voice_message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>25,
            )
		));
	}

	public function searchIndex()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
        /*
        SELECT p.first_name, p.last_name, p.avatar_path, p.text_desc,ro.nb_room FROM mia_patients p
        INNER JOIN mia_residents_of_rooms rr ON rr.id_patient = p.id_patient
        INNER JOIN mia_rooms ro ON ro.id_room = rr.id_room
        */
		$criteria=new CDbCriteria;
        $criteria->select = 'p.id_patient, p.first_name, p.last_name, p.avatar_path, p.text_desc, p.afliction, ro.nb_room';//, pc.url_camera';
        $criteria->alias = 'p';
        $criteria->join .= ' INNER JOIN {{residents_of_rooms}} rr ON rr.id_patient = p.id_patient ';
        $criteria->join .= ' INNER JOIN {{rooms}} ro ON ro.id_room = rr.id_room';

        //$criteria->join .= ' LEFT JOIN {{patient_cameras}} pc ON pc.id_patient = p.id_patient';
		$sort       = new CSort;
		$sort->attributes = array(
			'p.first_name' => array(
				'asc' => 'p.first_name',
				'desc' => 'p.first_name desc'
			),
			'p.afliction' => array(
				'asc' => 'p.afliction',
				'desc' => 'p.afliction desc'
			),
		);
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
	 * @return Patients the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPatientName(){
		return $this->first_name.' '.$this->last_name;
	}
}
