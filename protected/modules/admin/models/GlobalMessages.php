<?php

/**
 * This is the model class for table "{{global_messages}}".
 *
 * The followings are the available columns in table '{{global_messages}}':
 * @property string $id_global_message
 * @property string $global_description
 * @property string $global_subject
 * @property string $global_text
 */
class GlobalMessages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{global_messages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('global_description, global_subject, global_text', 'required'),
            array('global_description', 'length', 'max'=>250),
			array('global_subject', 'length', 'max'=>100),
			array('global_text', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_global_message, global_description, global_subject, global_text', 'safe', 'on'=>'search'),
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
			'id_global_message' => Yii::t('admin/globalmessages','Id Global Message'),
			'global_description' => Yii::t('admin/globalmessages','Global Description'),
			'global_subject' => Yii::t('admin/globalmessages','Global Subject'),
			'global_text' =>Yii::t('admin/globalmessages', 'Global Text'),
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

		$criteria->compare('id_global_message',$this->id_global_message,true);
		$criteria->compare('global_description',$this->global_description,true);
		$criteria->compare('global_subject',$this->global_subject,true);
		$criteria->compare('global_text',$this->global_text,true);

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
	 * @return GlobalMessages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
