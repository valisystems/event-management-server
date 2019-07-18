<?php

/**
 * This is the model class for table "{{http_inventory}}".
 *
 * The followings are the available columns in table '{{http_inventory}}':
 * @property integer $id_http_inventory
 * @property string $description
 * @property string $type_of_url
 * @property string $action_url
 */
class HttpInventory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{http_inventory}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description', 'length', 'max'=>250),
			array('type_of_url', 'length', 'max'=>6),
			array('action_url', 'safe'),
			array('description, type_of_url, action_url', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_http_inventory, description, type_of_url, type_method_info, send_method, action_url, urlencode, username, password, enconding_message, message_body, region, additional_header, custom_variable', 'safe'),
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
			'id_http_inventory' => 'Id Http Inventory',
			'description' => 'Description',
			'type_of_url' => 'Type Of Url',
			'action_url' => 'Action Url',
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

		$criteria->compare('id_http_inventory',$this->id_http_inventory);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('type_of_url',$this->type_of_url,true);
		$criteria->compare('action_url',$this->action_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HttpInventory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getHttpAction(){
		$data=HttpInventory::model()->findAll();
		$arrTypeServer = array('3cx' => '3CX', 'pbx' => 'PBXnSIP', 'vodia'=>'Vodia', 'custom'=>'Custom');


		$res = array();
		foreach($data as $k)
		{
			$res[$k['id_http_inventory']] = "( ".$arrTypeServer[$k['type_of_url']]." ) ".$k['description'];
		}
		return $res;
	}
}
