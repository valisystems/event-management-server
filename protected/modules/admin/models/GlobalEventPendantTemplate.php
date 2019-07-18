<?php

/**
 * This is the model class for table "{{global_event_pendant_template}}".
 *
 * The followings are the available columns in table '{{global_event_pendant_template}}':
 * @property integer $id_global_event_pendant_template
 * @property string $desc_global_event
 * @property integer $id_pendant_type
 * @property string $pick_event_type
 * @property string $id_global_message
 * @property string $live_panel
 * @property string $require_acknowledge
 * @property string $auto_close
 * @property string $flashing_toggle
 * @property integer $auto_close_duration
 * @property string $position_popup
 *
 * The followings are the available model relations:
 * @property GlobalMessages $idGlobalMessage
 * @property PendantType $idPendantType
 */
class GlobalEventPendantTemplate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{global_event_pendant_template}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('desc_global_event', 'required'),
			array('id_pendant_type, auto_close_duration', 'numerical', 'integerOnly'=>true),
			array('desc_global_event', 'length', 'max'=>150),
			array('pick_event_type', 'length', 'max'=>8),
			array('id_global_message', 'length', 'max'=>10),
			array('live_panel, require_acknowledge, auto_close, flashing_toggle', 'length', 'max'=>1),
			array('position_popup', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_global_event_pendant_template, desc_global_event, id_pendant_type, pick_event_type, id_global_message, live_panel, require_acknowledge, auto_close, flashing_toggle, auto_close_duration, position_popup', 'safe', 'on'=>'search'),
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
			'idGlobalMessage' => array(self::BELONGS_TO, 'GlobalMessages', 'id_global_message'),
			'idPendantType' => array(self::BELONGS_TO, 'PendantType', 'id_pendant_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_global_event_pendant_template' => Yii::t('admin/globaleventpendant','Global Event Pendant Template'),
			'desc_global_event' => Yii::t('admin/globaleventpendant','Desc Global Event'),
			'id_pendant_type' => Yii::t('admin/globaleventpendant','Pendant Type'),
			'pick_event_type' => Yii::t('admin/globaleventpendant','Pick Event Type'),
			'id_global_message' => Yii::t('admin/globaleventpendant','Global Message'),
			'live_panel' => Yii::t('admin/globaleventpendant','Live Panel'),
			'require_acknowledge' => Yii::t('admin/globaleventpendant','Require Acknowledge'),
			'auto_close' => Yii::t('admin/globaleventpendant','Auto Close'),
			'flashing_toggle' => Yii::t('admin/globaleventpendant','Flashing Toggle'),
			'auto_close_duration' => Yii::t('admin/globaleventpendant','Auto Close Duration'),
			'position_popup' => Yii::t('admin/globaleventpendant','Position Popup'),
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

		$criteria->compare('id_global_event_pendant_template',$this->id_global_event_pendant_template);
		$criteria->compare('desc_global_event',$this->desc_global_event,true);
		$criteria->compare('id_pendant_type',$this->id_pendant_type);
		$criteria->compare('pick_event_type',$this->pick_event_type,true);
		$criteria->compare('id_global_message',$this->id_global_message,true);
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
	 * @return GlobalEventPendantTemplate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
