<?php

/**
 * This is the model class for table "{{pick_pendant_events}}".
 *
 * The followings are the available columns in table '{{pick_pendant_events}}':
 * @property integer $id_pick_pendant_event
 * @property integer $id_event_pendant
 * @property string $pick_event_type
 * @property string $id_contact
 *
 * The followings are the available model relations:
 * @property EventsPendantManage $idEventPendant
 */
class PickPendantEvents extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pick_pendant_events}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_event_pendant', 'numerical', 'integerOnly'=>true),
			array('pick_event_type', 'length', 'max'=>8),
			array('id_contact', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_pick_pendant_event, id_event_pendant, pick_event_type, id_contact, id_command, id_iodevice', 'safe'),
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
			'idEventPendant' => array(self::BELONGS_TO, 'EventsPendantManage', 'id_event_pendant'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_pick_pendant_event' => 'Id Pick Pendant Event',
			'id_event_pendant' => 'Id Event Pendant',
			'pick_event_type' => 'Pick Event Type',
			'id_contact' => 'Id Contact',
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

		$criteria->compare('id_pick_pendant_event',$this->id_pick_pendant_event);
		$criteria->compare('id_event_pendant',$this->id_event_pendant);
		$criteria->compare('pick_event_type',$this->pick_event_type,true);
		$criteria->compare('id_contact',$this->id_contact,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PickPendantEvents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
