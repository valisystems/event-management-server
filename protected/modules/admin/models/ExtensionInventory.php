<?php

/**
 * This is the model class for table "{{extension_inventory}}".
 *
 * The followings are the available columns in table '{{extension_inventory}}':
 * @property integer $id_extension
 * @property string $id_building
 * @property string $id_map
 * @property string $id_sip_server
 * @property string $ext_number
 * @property string $password
 * @property string $caller_id_internal
 * @property string $caller_id_external
 * @property string $caller_id_name
 * @property string $extension_define
 */
class ExtensionInventory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{extension_inventory}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_building, id_map, id_sip_server, caller_id_internal, caller_id_external, caller_id_name, ext_number, password', 'required'),
			array('id_building, id_map, id_sip_server, ext_number', 'length', 'max'=>10),
			array('password', 'length', 'max'=>100),
			array('extension_define', 'length', 'max'=>1),

			array('caller_id_internal', 'match', 'pattern'=>'/^[0-9]+$/', 'message' => Yii::t("admin/devices", "Invalid character used"), 'allowEmpty' => true),
			array('caller_id_internal', 'length', 'max' =>15, 'message' => Yii::t("admin/devices", "Maximum length reached")),

			array('caller_id_external', 'match', 'pattern'=>'/^[0-9]+$/', 'message' => Yii::t("admin/devices", "Invalid character used")),
			array('caller_id_external', 'length', 'max' =>15, 'message' => Yii::t("admin/devices", "Maximum length reached")),

			array('caller_id_name', 'match', "pattern"=>"/^[a-zA-Z ]+$/", 'message' => Yii::t("admin/devices", "Invalid character used")),
			array('caller_id_name', 'length', 'max'=> 13, 'message' => Yii::t("admin/devices", "Maximum length reached")),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_extension, id_building, id_map, id_sip_server, ext_number, password, caller_id_internal, caller_id_external, caller_id_name, extension_define', 'safe'),
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
			'idBuilding' => array(self::BELONGS_TO, 'Buildings', 'id_building'),
			'idMap' => array(self::BELONGS_TO, 'Maps', 'id_map'),
			'idSipServer' => array(self::BELONGS_TO, 'Asterisk', 'id_asterisk'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_extension' => 'Id Extension',
			'id_building' => 'Building',
			'id_map' => 'Floor',
			'id_sip_server' => 'Sip Server',
			'ext_number' => 'Extension Number',
			'password' => 'Password',
			'caller_id_internal' => 'Caller ID Internal',
			'caller_id_external' => 'Caller ID External',
			'caller_id_name' => 'Caller ID Name',
			'extension_define' => 'Extension Define',
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

		$criteria->compare('id_extension',$this->id_extension);
		$criteria->compare('id_building',$this->id_building,true);
		$criteria->compare('id_map',$this->id_map,true);
		$criteria->compare('id_sip_server',$this->id_sip_server,true);
		$criteria->compare('ext_number',$this->ext_number,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('caller_id_internal',$this->caller_id_internal,true);
		$criteria->compare('caller_id_external',$this->caller_id_external,true);
		$criteria->compare('caller_id_name',$this->caller_id_name,true);
		$criteria->compare('extension_define',$this->extension_define,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExtensionInventory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getFloorList($id_building = -1){
		$data=Maps::model()->findAll('id_building=:id_building',
			array(':id_building'=>(int) $id_building));

		$data=CHtml::listData($data,'id_map','name_map');
		$res = array();
		foreach($data as $value=>$name)
		{
			$res[$value] = $name;
		}
		return $res;
	}
	public function getSipServer($id_building = -1){
		$dd=Asterisk::model()->findAll('id_building=:id_building',
			array(':id_building'=>(int) $id_building));

		//$data=CHtml::listData($data,'id_map','name_map');
		$res = array();
		foreach($dd as $value=>$row)
		{
			$res[$row->id_asterisk] = $row->asterisk_name.'( '.$row->asterisk_url." )";
		}
		return $res;
	}
}
