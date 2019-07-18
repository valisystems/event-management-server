<?php

/**
 * This is the model class for table "{{staff}}".
 *
 * The followings are the available columns in table '{{staff}}':
 * @property integer $id_staff
 * @property string $first_name
 * @property string $last_name
 * @property string $birth_day
 * @property string $avatar_path
 * @property string $position
 * @property string $description
 * @property string $personal_id
 * @property string $pin_code
 * @property string $staff_status
 * @property string $id_building
 */
class Staff extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{staff}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_building', 'required'),
			array('first_name, last_name', 'length', 'max'=>100),
			array('avatar_path', 'length', 'max'=>250),
			array('position', 'length', 'max'=>150),
			array('personal_id, pin_code', 'length', 'max'=>30),
			array('staff_status', 'length', 'max'=>1),
			array('id_building', 'length', 'max'=>10),
			array('birth_day, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_staff, first_name, last_name, birth_day, avatar_path, position, description, personal_id, pin_code, staff_status, id_building', 'safe'),
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
			'id_staff' => 'Id Staff',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'birth_day' => 'Birth Day',
			'avatar_path' => 'Avatar Path',
			'position' => 'Position',
			'description' => 'Description',
			'personal_id' => 'Personal ID',
			'pin_code' => 'Pin Code',
			'staff_status' => 'Staff Status',
			'id_building' => 'Building',
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

		$criteria->compare('id_staff',$this->id_staff);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('birth_day',$this->birth_day,true);
		$criteria->compare('avatar_path',$this->avatar_path,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('personal_id',$this->personal_id,true);
		$criteria->compare('pin_code',$this->pin_code,true);
		$criteria->compare('staff_status',$this->staff_status,true);
		$criteria->compare('id_building',$this->id_building,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>25,
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Staff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
