<?php

/**
 * This is the model class for table "{{maps}}".
 *
 * The followings are the available columns in table '{{maps}}':
 * @property integer $id_map
 * @property string $name_map
 * @property string $description
 * @property string $id_building
 * @property string $path_to_img
 */
class Maps extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{maps}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('name_map, id_building','required'),
			array('name_map', 'length', 'max'=>100),
			array('description, path_to_img', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_map, name_map, description, id_building, path_to_img', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
        return array(
            'building' => array(self::BELONGS_TO, 'Buildings', 'id_building')
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_map' => Yii::t( 'admin/maps', 'Nb. Map'),
			'name_map' => Yii::t( 'admin/maps', 'Name Map'),
			'description' => Yii::t( 'admin/maps', 'Description'),
			'id_building' => Yii::t( 'admin/maps', 'Building'),
			'path_to_img' => Yii::t( 'admin/maps', 'Path To Img'),
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
		$criteria->compare('id_map',$this->id_map);
		$criteria->compare('name_map',$this->name_map);
		$criteria->compare('description',$this->description);
		$criteria->compare('id_building',$this->id_building);
		$criteria->compare('path_to_img',$this->path_to_img);
        //$criteria->with = array('building');
        //$criteria->compare('building.name',$this->id_building,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            /*'pagination'=>array(
                'pageSize'=>25,
            ),*/
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Maps the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}