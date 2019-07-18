<?php

/**
 * This is the model class for table "{{mipositioning_input_device}}".
 *
 * The followings are the available columns in table '{{mipositioning_input_device}}':
 * @property integer $input_device
 * @property string $maxivox_address
 * @property string $io_name
 * @property string $io_id
 * @property string $id_device
 */
class MipositioningInputDevice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mipositioning_input_device}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('io_name, io_id', 'length', 'max'=>50),
			array('id_device', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_input_device, io_name, io_id, id_device', 'safe'),
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
			'id_input_device' => 'Input Device',
			'io_name' => 'Io Name',
			'io_id' => 'Io',
			'id_device' => 'Id Device',
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

		$criteria->compare('id_input_device',$this->id_input_device);
		$criteria->compare('io_name',$this->io_name,true);
		$criteria->compare('io_id',$this->io_id,true);
		$criteria->compare('id_device',$this->id_device,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MipositioningInputDevice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
