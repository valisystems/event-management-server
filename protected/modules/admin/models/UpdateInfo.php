<?php

/**
 * This is the model class for table "{{update_info}}".
 *
 * The followings are the available columns in table '{{update_info}}':
 * @property integer $id_update
 * @property string $update_name
 * @property string $update_description
 * @property string $update_path
 * @property string $update_time_ins
 * @property string $update_version
 * @property string $update_custom
 * @property string $custom_inventory
 * @property string $update_installed
 */
class UpdateInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{update_info}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('update_name', 'length', 'max'=>50),
			array('update_path', 'length', 'max'=>250),
			array('update_version', 'length', 'max'=>10),
			array('update_custom, update_installed', 'length', 'max'=>1),
			array('update_description, update_time_ins', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_update, update_name, update_description, update_path, update_time_ins, update_version, update_custom, update_installed', 'safe', 'on'=>'search'),
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
			'id_update' => 'Id Update',
			'update_name' => 'Update Name',
			'update_description' => 'Update Description',
			'update_path' => 'Update Path',
			'update_time_ins' => 'Update Time Ins',
			'update_version' => 'Update Version',
			'update_custom' => 'Update Custom',
			'custom_inventory' => 'Custom Inventory',
			'update_installed' => 'Update Installed',
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

		$criteria->compare('id_update',$this->id_update);
		$criteria->compare('update_name',$this->update_name,true);
		$criteria->compare('update_description',$this->update_description,true);
		$criteria->compare('update_path',$this->update_path,true);
		$criteria->compare('update_time_ins',$this->update_time_ins,true);
		$criteria->compare('update_version',$this->update_version,true);
		$criteria->compare('update_custom',$this->update_custom,true);
		$criteria->compare('custom_inventory',$this->custom_inventory,true);
		$criteria->compare('update_installed',$this->update_installed,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UpdateInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
