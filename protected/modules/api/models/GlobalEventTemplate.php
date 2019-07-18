<?php

/**
 * This is the model class for table "{{global_event_template}}".
 *
 * The followings are the available columns in table '{{global_event_template}}':
 * @property string $id_global_event_template
 * @property string $desc_global_event
 * @property string $id_call_type
 * @property string $pick_event_type
 * @property string $id_global_message
 *
 * The followings are the available model relations:
 * @property CallsType $idCallType
 * @property GlobalMessages $idGlobalMessage
 * @property Receiver[] $receivers
 */
class GlobalEventTemplate extends CActiveRecord
{
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
			array('desc_global_event', 'required'),
			array('desc_global_event', 'length', 'max'=>150),
			array('id_call_type, id_global_message', 'length', 'max'=>10),
			array('pick_event_type', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_global_event_template, desc_global_event, id_call_type, pick_event_type, id_global_message', 'safe', 'on'=>'search'),
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
			'idCallType' => array(self::BELONGS_TO, 'CallsType', 'id_call_type'),
			'idGlobalMessage' => array(self::BELONGS_TO, 'GlobalMessages', 'id_global_message'),
			'receivers' => array(self::HAS_MANY, 'Receiver', 'id_global_event_template'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_global_event_template' => 'Id Global Event Template',
			'desc_global_event' => 'Desc Global Event',
			'id_call_type' => 'Id Call Type',
			'pick_event_type' => 'Pick Event Type',
			'id_global_message' => 'Id Global Message',
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

		$criteria->compare('id_global_event_template',$this->id_global_event_template,true);
		$criteria->compare('desc_global_event',$this->desc_global_event,true);
		$criteria->compare('id_call_type',$this->id_call_type,true);
		$criteria->compare('pick_event_type',$this->pick_event_type,true);
		$criteria->compare('id_global_message',$this->id_global_message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
