<?php

/**
 * This is the model class for table "{{pendant_type}}".
 *
 * The followings are the available columns in table '{{pendant_type}}':
 * @property integer $id_call_type
 * @property string $description
 * @property string $script
 * @property integer $priority
 * @property string $color_hex
 */
class PendantType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{pendant_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('priority', 'numerical', 'integerOnly'=>true),
			array('description, script', 'length', 'max'=>150),
			array('color_hex', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_pendant_type, description, script, priority, color_hex', 'safe', 'on'=>'search'),
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
			'id_pendant_type' => Yii::t('admin/pendanttype','Id Pendant Type'),
			'description' => Yii::t('admin/pendanttype','Description'),
			'script' => Yii::t('admin/pendanttype','Identificator'),
			'priority' => Yii::t('admin/pendanttype','Priority'),
			'color_hex' => Yii::t('admin/pendanttype','Color Hex'),
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

		$criteria->compare('id_pendant_type',$this->id_pendant_type);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('script',$this->script,true);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('color_hex',$this->color_hex,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PendantType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
