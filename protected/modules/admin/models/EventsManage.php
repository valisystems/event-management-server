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
class EventsManage extends CActiveRecord
{
	public $id_room;
	public $id_map;
	public $id_building;
    public $global_event;
    public $device_description;
    public $nb_room;
    public $call_type_desc;
    public $desc_global_event;
    public $eventMessages;
    
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{events_manage}}';
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
			array('id_device, id_notification_settings', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_event, id_device, id_call_type, id_notification_settings, event_type, id_global_event, live_panel, require_acknowledge, flashing_toggle, auto_close, auto_close_duration', 'safe'),
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
			'dCallType' => array(self::BELONGS_TO, 'CallsType', 'id_call_type'),
			'dDevice' => array(self::BELONGS_TO, 'Devices', 'id_device'),
			'dPickEvents' => array(self::HAS_MANY, 'PickEvents', 'id_event'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_event' => 'Event',
			'id_device' => 'Device',
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

		$criteria->compare('id_event',$this->id_event,true);
		$criteria->compare('id_device',$this->id_device,true);
		$criteria->compare('id_call_type',$this->id_call_type,true);
		$criteria->compare('id_notification_settings',$this->id_notification_settings,true);
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
        $criteria->select = 'd.device_description, r.nb_room, ct.description AS call_type_desc';
        $criteria->alias = 'em';
        $criteria->join = ' LEFT JOIN '.Yii::app()->db->tablePrefix.'devices d ON d.id_device = em.id_device ';
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
