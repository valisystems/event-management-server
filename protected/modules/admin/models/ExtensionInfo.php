<?php

/**
 * This is the model class for table "{{extension_info}}".
 *
 * The followings are the available columns in table '{{extension_info}}':
 * @property string $id_extension
 * @property string $id_asterisk
 * @property string $id_device
 * @property integer $ext_number
 * @property string $password
 * @property string $caller_id_internal
 * @property string $caller_id_external
 * @property string $caller_id_name
 * @property string $extension_define
 */
class ExtensionInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{extension_info}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('ext_number', 'numerical', 'integerOnly'=>true),
			array('id_asterisk, id_device', 'length', 'max'=>10),
			array('password, caller_id_internal, caller_id_external, caller_id_name', 'length', 'max'=>70),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_extension, id_asterisk, id_device, ext_number, password, caller_id_internal, caller_id_external, caller_id_name, extension_define', 'safe'),
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
            'idDevice' => array(self::BELONGS_TO, 'Devices', 'id_device'),
            'idAsterisk' => array(self::BELONGS_TO, 'Asterisk', 'id_asterisk'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_extension' => 'Id Extension',
			'id_asterisk' => 'Id Asterisk',
			'id_device' => 'Id Device',
			'ext_number' => 'Ext Number',
			'password' => 'Password',
			'caller_id_internal' => 'Caller Id Internal',
			'caller_id_external' => 'Caller Id External',
			'caller_id_name' => 'Caller Id Name',
            'extension_define' => 'Extension Define'
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

		$criteria->compare('id_extension',$this->id_extension,true);
		$criteria->compare('id_asterisk',$this->id_asterisk,true);
		$criteria->compare('id_device',$this->id_device,true);
		$criteria->compare('ext_number',$this->ext_number);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('caller_id_internal',$this->caller_id_internal,true);
		$criteria->compare('caller_id_external',$this->caller_id_external,true);
		$criteria->compare('caller_id_name',$this->caller_id_name,true);

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
	 * @return ExtensionInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
