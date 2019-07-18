<?php

/**
 * This is the model class for table "{{staff_working}}".
 *
 * The followings are the available columns in table '{{staff_working}}':
 * @property integer $id_staff_working
 * @property string $id_staff
 * @property string $id_extension
 * @property string $selected_rooms
 * @property string $start_work
 */
class StaffWorking extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{staff_working}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_staff, id_extension, start_work', 'required'),
			array('id_staff, id_extension', 'length', 'max'=>10),
			array('selected_rooms', 'length', 'max'=>250),
			//array('start_work', 'default', 'value'=>new CDbExpression('NOW()'), 'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_staff_working, id_staff, id_extension, selected_rooms, start_work', 'safe', 'on'=>'search'),
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
			'id_staff_working' => 'Id Staff Working',
			'id_staff' => 'Id Staff',
			'id_extension' => 'Id Extension',
			'selected_rooms' => 'Selected Rooms',
			'start_work' => 'Start Work',
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

		$criteria->compare('id_staff_working',$this->id_staff_working);
		$criteria->compare('id_staff',$this->id_staff,true);
		$criteria->compare('id_building',$this->id_building,true);
		$criteria->compare('id_map',$this->id_map,true);
		$criteria->compare('id_extension',$this->id_extension,true);
		$criteria->compare('selected_rooms',$this->selected_rooms,true);
		$criteria->compare('start_work',$this->start_work,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StaffWorking the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
