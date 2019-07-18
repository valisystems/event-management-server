<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property string $id_user
 * @property string $first_name
 * @property string $last_name
 * @property string $login_name
 * @property string $passwd
 * @property string $role
 * @property string $email
 * @property string $phone
 * @property string $company
 * @property string $reports
 * @property string $status
 *
 * The followings are the available model relations:
 * @property UsersNotes[] $usersNotes
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, login_name, company', 'length', 'max'=>50),
            array('first_name, last_name, login_name, passwd, email', 'required'),
			array('passwd', 'length', 'max'=>100, 'on' => 'create'),
			array('role, reports, status', 'length', 'max'=>1),
			array('email', 'length', 'max'=>150),
			array('phone', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_user, first_name, last_name, login_name, passwd, role, email, phone, company, reports, status, access_rules, buildings_rules', 'safe'),
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
			'usersNotes' => array(self::HAS_MANY, 'UsersNotes', 'id_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_user' => Yii::t('admin/users','Id User'),
			'first_name' => Yii::t('admin/users','First Name'),
			'last_name' => Yii::t('admin/users','Last Name'),
			'login_name' => Yii::t('admin/users','Login Name'),
			'passwd' => Yii::t('admin/users','Password'),
			'role' => Yii::t('admin/users','Role'),
			'email' => Yii::t('admin/users','Email'),
			'phone' => Yii::t('admin/users','Phone'),
			'company' => Yii::t('admin/users','Company'),
			'reports' => Yii::t('admin/users','Reports'),
			'status' => Yii::t('admin/users','Status'),
			'access_rules' => Yii::t('admin/users', 'Rules for Access'),
			'buildings_rules' => Yii::t('admin/users', 'Buildings List for Access')
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

		$criteria->compare('id_user',$this->id_user,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('login_name',$this->login_name,true);
		$criteria->compare('passwd',$this->passwd,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('reports',$this->reports,true);
		$criteria->compare('status',$this->status,true);

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
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
