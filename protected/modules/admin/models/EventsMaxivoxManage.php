<?php

/**
 * This is the model class for table "{{events_manage}}".
 *
 * The followings are the available columns in table '{{events_manage}}':
 * @property string $id_event
 * @property string $id_device
 * @property string $id_call_type
 * @property string $id_notification_settings
 * @property string $event_type
 * @property string $id_global_event
 *
 * The followings are the available model relations:
 * @property CallsType $idCallType
 * @property Devices $idDevice
 * @property PickEvents[] $pickEvents
 */
class EventsMaxivoxManage extends CActiveRecord
{
	public $id_room;
	public $id_map;
	public $id_building;
    public $global_event;
    public $dev_desc;
    public $nb_room;
    public $maxivox_type_desc;
    public $desc_global_event;
    public $eventMessages;
    
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{events_maxivox_manage}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_type', 'required'),
			array('id_maxivox_device', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_event, id_maxivox_device, id_maxivox_type, event_type, id_global_event, live_panel, require_acknowledge, flashing_toggle, auto_close, auto_close_duration', 'safe'),
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
			'dMaxivoxType' => array(self::BELONGS_TO, 'MaxivoxType', 'id_maxivox_type'),
			'dMaxivoxDevice' => array(self::BELONGS_TO, 'MaxivoxDevices', 'id_maxivox_device'),
			'dPickMaxivoxEvents' => array(self::HAS_MANY, 'PickMaxivoxEvents', 'id_event_maxivox'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_event_maxivox' => 'Event',
			'id_maxivox_device' => 'Device',
			'id_room' => 'Room',
			'id_building' => 'Building',
			'id_call_type' => 'Call Type',
			'id_notification_settings' => 'Notification Settings',
			'event_type' => 'Event Type',
            'live_panel' => Yii::t('admin/eventsmanage','View on Live Panel'), 
            'require_acknowledge' => Yii::t('admin/eventsmanage','Require Acknowledge'), 
            'flashing_toggle' => Yii::t('admin/eventsmanage','Flashing Toggle'), 
            'auto_close' => Yii::t('admin/eventsmanage','Auto Close'), 
            'auto_close_duration' => Yii::t('admin/eventsmanage','Auto Close Duration')
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

		$criteria->compare('id_event_maxivox',$this->id_event_maxivox,true);
		$criteria->compare('id_maxivox_device',$this->id_maxivox_device,true);
		$criteria->compare('id_maxivox_type',$this->id_maxivox_type,true);
		//$criteria->compare('id_notification_settings',$this->id_notification_settings,true);
		$criteria->compare('pick_event_type',$this->pick_event_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
	public function searchByRoom()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		/*$criteria=new CDbCriteria;

		$criteria->compare('id_event',$this->id_event,true);
		$criteria->compare('id_device',$this->id_device,true);
		$criteria->compare('id_call_type',$this->id_call_type,true);
		$criteria->compare('id_notification_settings',$this->id_notification_settings,true);
		$criteria->compare('pick_event_type',$this->pick_event_type,true);*/
        
        $criteria=new CDbCriteria;
        $criteria->select = 'd.dev_desc, r.nb_room, ct.description AS maxivox_type_desc';
        $criteria->alias = 'em';
        $criteria->join = ' LEFT JOIN '.Yii::app()->db->tablePrefix.'maxivox_device d ON d.id_maxivox_device = em.id_maxivox_device ';
        $criteria->join .= ' LEFT JOIN '.Yii::app()->db->tablePrefix.'rooms r ON r.id_room = d.id_room ';
        $criteria->join .= ' LEFT JOIN '.Yii::app()->db->tablePrefix.'calls_type ct ON em.id_call_type = ct.id_call_type ';
        //$criteria->with=array('dDevice');
        $criteria->condition = 'r.id_room=:id_room';
        $criteria->params = array(':id_room'=>$this->id_room);  

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventsManage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
