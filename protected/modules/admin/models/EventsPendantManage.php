<?php

/**
 * This is the model class for table "{{events_pendant_manage}}".
 *
 * The followings are the available columns in table '{{events_pendant_manage}}':
 * @property integer $id_event_pendant
 * @property integer $id_device
 * @property integer $id_pendant_type
 * @property string $event_type
 * @property string $id_global_event
 * @property string $live_panel
 * @property string $require_acknowledge
 * @property string $auto_close
 * @property string $flashing_toggle
 * @property integer $auto_close_duration
 * @property string $position_popup
 *
 * The followings are the available model relations:
 * @property GlobalEventTemplate $idGlobalEvent
 * @property PendantType $idPendantType
 * @property PendantDevices $idDevice
 * @property PickPendantEvents[] $pickPendantEvents
 */
class EventsPendantManage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $id_building;
	public $dev_desc;
	public $pendant_type_desc;
	public $eventMessages;

	public function tableName()
	{
		return '{{events_pendant_manage}}';
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
			array('id_device, id_pendant_type, auto_close_duration', 'numerical', 'integerOnly'=>true),
			array('event_type', 'length', 'max'=>8),
			array('id_global_event', 'length', 'max'=>10),
			array('live_panel, require_acknowledge, auto_close, flashing_toggle', 'length', 'max'=>1),
			array('position_popup', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_event_pendant, id_building, id_device, id_pendant_type, event_type, id_global_event, live_panel, require_acknowledge, auto_close, flashing_toggle, auto_close_duration, position_popup', 'safe', 'on'=>'search'),
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
			'idGlobalEvent' => array(self::BELONGS_TO, 'GlobalEventTemplate', 'id_global_event'),
			'idPendantType' => array(self::BELONGS_TO, 'PendantType', 'id_pendant_type'),
			'idDevice' => array(self::BELONGS_TO, 'PendantDevices', 'id_device'),
			'pickPendantEvents' => array(self::HAS_MANY, 'PickPendantEvents', 'id_event_pendant'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_event_pendant' => Yii::t('admin/eventsPendant','Event Pendant'),
			'id_device' => Yii::t('admin/eventsPendant','Device'),
			'id_building' => Yii::t('admin/eventsPendant','Building'),
			'id_pendant_type' => Yii::t('admin/eventsPendant','Pendant Type'),
			'event_type' => Yii::t('admin/eventsPendant','Event Type'),
			'id_global_event' => Yii::t('admin/eventsPendant','Global Event'),
			'live_panel' => Yii::t('admin/eventsPendant','Live Panel'),
			'require_acknowledge' => Yii::t('admin/eventsPendant','Require Acknowledge'),
			'auto_close' => Yii::t('admin/eventsPendant','Auto Close'),
			'flashing_toggle' => Yii::t('admin/eventsPendant','Flashing Toggle'),
			'auto_close_duration' => Yii::t('admin/eventsPendant','Auto Close Duration'),
			'position_popup' => Yii::t('admin/eventsPendant','Position Popup'),
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

		$criteria->compare('id_event_pendant',$this->id_event_pendant);
		$criteria->compare('id_device',$this->id_device);
		$criteria->compare('id_pendant_type',$this->id_pendant_type);
		$criteria->compare('event_type',$this->event_type,true);
		$criteria->compare('id_global_event',$this->id_global_event,true);
		$criteria->compare('live_panel',$this->live_panel,true);
		$criteria->compare('require_acknowledge',$this->require_acknowledge,true);
		$criteria->compare('auto_close',$this->auto_close,true);
		$criteria->compare('flashing_toggle',$this->flashing_toggle,true);
		$criteria->compare('auto_close_duration',$this->auto_close_duration);
		$criteria->compare('position_popup',$this->position_popup,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventsPendantManage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
