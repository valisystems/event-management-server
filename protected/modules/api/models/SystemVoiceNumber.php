<?php

/**
 * This is the model class for table "{{system_voice_number}}".
 *
 * The followings are the available columns in table '{{system_voice_number}}':
 * @property string $id_system_voice_number
 * @property string $description_voice_number
 * @property string $name_voice_number
 * @property string $number_to_call
 */
class SystemVoiceNumber extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{system_voice_number}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description_voice_number, name_voice_number, number_to_call', 'required'),
			array('description_voice_number, name_voice_number', 'length', 'max'=>250),
			array('number_to_call', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_system_voice_number, description_voice_number, name_voice_number, number_to_call', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_system_voice_number' => 'Id System Voice Number',
			'description_voice_number' => 'Description Voice Number',
			'name_voice_number' => 'Name Voice Number',
			'number_to_call' => 'Number To Call',
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

		$criteria->compare('id_system_voice_number',$this->id_system_voice_number,true);
		$criteria->compare('description_voice_number',$this->description_voice_number,true);
		$criteria->compare('name_voice_number',$this->name_voice_number,true);
		$criteria->compare('number_to_call',$this->number_to_call,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SystemVoiceNumber the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
