<?php

/**
 * This is the model class for table "{{global_event_template}}".
 *
 * The followings are the available columns in table '{{global_event_template}}':
 * @property string $id_global_event_template
 * @property string $id_call_type
 * @property string $pick_event_type
 * @property string $id_global_message
 *
 * The followings are the available model relations:
 * @property GlobalMessages $idGlobalMessage
 * @property Receiver[] $receivers
 */
class GlobalEventTemplate extends CActiveRecord
{
    public $receiver;

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{global_event_template}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_call_type, id_global_message', 'length', 'max'=>10),
            array('id_call_type, pick_event_type, id_global_message, desc_global_event, receiver', 'required'),
            array('desc_global_event', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_call_type, pick_event_type, id_global_message, desc_global_event, receiver, live_panel, require_acknowledge, flashing_toggle, auto_close, auto_close_duration', 'safe'),
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
            'idCallsType' => array(self::BELONGS_TO, 'CallsType', 'id_call_type'),
			'receivers' => array(self::HAS_MANY, 'Receiver', 'id_global_event_template'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_global_event_template' => Yii::t('admin/globalevent','Id Global Event Template'),
			'id_call_type' => Yii::t('admin/globalevent','Call Type'),
			'desc_global_event' => Yii::t('admin/globalevent','Description'),
			'pick_event_type' => Yii::t('admin/globalevent','Pick Event Type'),
			'id_global_message' => Yii::t('admin/globalevent','Global Message'),
            'live_panel' => Yii::t('admin/globalevent','View on Live Panel'), 
            'require_acknowledge' => Yii::t('admin/globalevent','Require Acknowledge'), 
            'flashing_toggle' => Yii::t('admin/globalevent','Flashing Toggle'), 
            'auto_close' => Yii::t('admin/globalevent','Auto Close'), 
            'auto_close_duration' => Yii::t('admin/globalevent','Auto Close Duration')
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

		//$criteria->compare('id_global_event_template',$this->id_global_event_template,true);
		$criteria->compare('id_call_type',$this->id_call_type,true);
		$criteria->compare('pick_event_type',$this->pick_event_type,true);
		$criteria->compare('desc_global_event',$this->desc_global_event,true);
		$criteria->compare('id_global_message',$this->id_global_message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>25,
            ),
		));
	}

	public function getDescVoice(){
		return $this->desc_global_event.'( ';
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GlobalEventTemplate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
