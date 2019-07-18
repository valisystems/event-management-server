<?php

/**
 * This is the model class for table "{{notification_settings}}".
 *
 * The followings are the available columns in table '{{notification_settings}}':
 * @property string $id_notification_setting
 * @property string $alarm_sound
 * @property integer $escalation_interval
 * @property integer $number_of_retry
 */
class NotificationSettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    
	public function tableName()
	{
		return '{{notification_settings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('escalation_interval, number_of_retry', 'numerical', 'integerOnly'=>true),
            array('alarm_sound, escalation_interval, number_of_retry', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_notification_setting, alarm_sound, escalation_interval, number_of_retry', 'safe'),
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
			'id_notification_setting' => Yii::t('admin/notificationsettings', 'Id Notification Setting'),
			'alarm_sound' => Yii::t('admin/notificationsettings', 'Alarm Sound'),
			'escalation_interval' => Yii::t('admin/notificationsettings', 'Escalation Interval'),
			'number_of_retry' => Yii::t('admin/notificationsettings', 'Number Of Retries'),
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

		$criteria->compare('id_notification_setting',$this->id_notification_setting,true);
		$criteria->compare('alarm_sound',$this->alarm_sound,true);
		$criteria->compare('escalation_interval',$this->escalation_interval);
		$criteria->compare('number_of_retry',$this->number_of_retry);

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
	 * @return NotificationSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
