<?php

/**
 * This is the model class for table "{{system_cameras}}".
 *
 * The followings are the available columns in table '{{system_cameras}}':
 * @property integer $id_system_camera
 * @property string $description_camera
 * @property string $name_camera
 * @property string $url_camera
 */
class SystemCameras extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{system_cameras}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description_camera, name_camera, url_camera', 'length', 'max'=>250),
			array('description_camera, name_camera, url_camera', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_system_camera, description_camera, name_camera, url_camera', 'safe', 'on'=>'search'),

			//array('url_camera', 'match', 'pattern' => '/^(http(?:s)?\:\/\/[a-zA-Z0-9\-]+(?:\.[a-zA-Z0-9\-]+)*\.[a-zA-Z]{2,6}(?:\/?|(?:\/[\w\-]+)*)(?:\/?|\/\w+\.[a-zA-Z]{2,4}(?:\?[\w]+\=[\w\-]+)?)?(?:\&[\w]+\=[\w\-]+)*)$/', 'message' => Yii::t("admin/systemcamera", "Invalid url")),
			array('url_camera', 'length', 'max' =>250, 'message' => Yii::t("admin/systemcamera", "Maximum length reached")),

			array('description_camera', 'match', "pattern"=>"/^[a-zA-Z0-9 ]+$/", 'message' => Yii::t("admin/systemcamera", "Invalid character used")),
			array('description_camera', 'length', 'max'=> 200, 'message' => Yii::t("admin/systemcamera", "Maximum length reached")),

			array('name_camera', 'match', "pattern"=>"/^[a-zA-Z0-9 ]+$/", 'message' => Yii::t("admin/systemcamera", "Invalid character used")),
			array('name_camera', 'length', 'max'=> 200, 'message' => Yii::t("admin/systemcamera", "Maximum length reached")),
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
			'id_system_camera' => Yii::t('admin/systemcamera','Id System Camera'),
			'description_camera' => Yii::t('admin/systemcamera','Description Camera'),
			'name_camera' => Yii::t('admin/systemcamera','Name Camera'),
			'url_camera' => Yii::t('admin/systemcamera','Url Camera'),
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

		$criteria->compare('id_system_camera',$this->id_system_camera);
		$criteria->compare('description_camera',$this->description_camera,true);
		$criteria->compare('name_camera',$this->name_camera,true);
		$criteria->compare('url_camera',$this->url_camera,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SystemCameras the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
