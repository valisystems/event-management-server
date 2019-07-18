<?php

/**
 * This is the model class for table "{{pick_events}}".
 *
 * The followings are the available columns in table '{{pick_events}}':
 * @property string $id_pick_event
 * @property string $id_event
 * @property string $pick_event_type
 * @property string $id_contact
 *
 * The followings are the available model relations:
 * @property EventsManage $idEvent
 * @property EmergencyContact $idEmergencyContact
 */
class PickEvents extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pick_events}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_event, pick_event_type, id_contact', 'required'),
			array('id_event, id_contact', 'length', 'max'=>10),
			//array('pick_event_type', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_pick_event, id_event, pick_event_type, id_contact, id_command, id_iodevice, id_http_inventory', 'safe'),
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
			'idEvent' => array(self::BELONGS_TO, 'EventsManage', 'id_event'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_pick_event' => 'Id Pick Event',
			'id_event' => 'Id Event',
			'pick_event_type' => 'Pick Event Type',
			'id_contact' => 'Contact',
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

		$criteria->compare('id_pick_event',$this->id_pick_event,true);
		$criteria->compare('id_event',$this->id_event,true);
		$criteria->compare('pick_event_type',$this->pick_event_type,true);
		$criteria->compare('id_emergency_contact',$this->id_emergency_contact,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PickEvents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
