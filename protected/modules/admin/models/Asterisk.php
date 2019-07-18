<?php

/**
 * This is the model class for table "{{asterisk}}".
 *
 * The followings are the available columns in table '{{asterisk}}':
 * @property string $id_asterisk
 * @property string $asterisk_name
 * @property string $asterisk_url
 * @property string $id_building
 * @property integer $limit_of_ext
 */
class Asterisk extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{asterisk}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asterisk_name, asterisk_url, id_building', 'required'),
            //array('limit_of_ext', 'numerical', 'min'=> 1, 'max'=>10, 'integerOnly'=>true, 'tooSmall'=>Yii::t('admin/asterisk','You must order at least 1 piece'), 'tooBig'=>Yii::t('admin/asterisk','You cannot order more than 250 pieces at once'), 'allowEmpty'=>false),
			array('asterisk_name', 'length', 'max'=>150, 'allowEmpty'=>false),
			array('asterisk_url, voip_url', 'url', 'defaultScheme' => 'http://','allowEmpty'=>false),
			array('id_building', 'length', 'max'=>10,'allowEmpty'=>false),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('asterisk_name, asterisk_url, voip_url, id_building, user, passwd', 'safe'),
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
            'building' => array(self::BELONGS_TO, 'Buildings', 'id_building'),
            //'extension'=> array(self::BELONGS_TO, 'ExtensionInfo', "{{extension_info}}()")
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_asterisk' => Yii::t( 'admin/asterisk','Number of Node'),
			'asterisk_name' => Yii::t( 'admin/asterisk','Node Name'),
			'asterisk_url' => Yii::t( 'admin/asterisk','URL to Node'),
			'voip_url' => Yii::t( 'admin/asterisk','URL to VoIP API'),
			'id_building' => Yii::t( 'admin/asterisk','Building'),
			'limit_of_ext' => Yii::t( 'admin/asterisk','Limit Of Ext'),
			'user' => Yii::t( 'admin/asterisk','User Name'),
			'passwd' => Yii::t( 'admin/asterisk','Password'),
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

		$criteria->compare('id_asterisk',$this->id_asterisk,true);
		$criteria->compare('asterisk_name',$this->asterisk_name,true);
		$criteria->compare('asterisk_url',$this->asterisk_url,true);
		$criteria->compare('id_building',$this->id_building,true);
		$criteria->compare('limit_of_ext',$this->limit_of_ext);

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
	 * @return Asterisk the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
