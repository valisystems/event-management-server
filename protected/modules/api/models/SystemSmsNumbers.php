<?php

/**
 * This is the model class for table "{{system_sms_numbers}}".
 *
 * The followings are the available columns in table '{{system_sms_numbers}}':
 * @property string $id_system_sms_number
 * @property string $description_sms
 * @property string $name_sms
 * @property string $number_sms
 *
 * The followings are the available model relations:
 * @property Receiver[] $receivers
 */
class SystemSmsNumbers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{system_sms_numbers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description_sms, name_sms', 'length', 'max'=>250),
			array('number_sms', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_system_sms_number, description_sms, name_sms, number_sms', 'safe', 'on'=>'search'),
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
			'receivers' => array(self::HAS_MANY, 'Receiver', 'id_system_sms_number'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_system_sms_number' => 'Id System Sms Number',
			'description_sms' => 'Description Sms',
			'name_sms' => 'Name Sms',
			'number_sms' => 'Number Sms',
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

		$criteria->compare('id_system_sms_number',$this->id_system_sms_number,true);
		$criteria->compare('description_sms',$this->description_sms,true);
		$criteria->compare('name_sms',$this->name_sms,true);
		$criteria->compare('number_sms',$this->number_sms,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SystemSmsNumbers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
