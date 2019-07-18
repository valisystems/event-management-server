<?php

/**
 * This is the model class for table "{{cdr_collect}}".
 *
 * The followings are the available columns in table '{{cdr_collect}}':
 * @property integer $id
 * @property string $sys
 * @property string $primarycallid
 * @property string $callid
 * @property string $cid_from
 * @property string $cid_to
 * @property string $direction
 * @property string $remoteparty
 * @property string $localparty
 * @property string $trunkname
 * @property integer $trunkid
 * @property string $cost
 * @property string $cmc
 * @property string $domain
 * @property string $timestart
 * @property string $timeconnected
 * @property string $timeend
 * @property string $ltime
 * @property string $durationhhmmss
 * @property integer $duration
 * @property string $recordlocation
 * @property string $type
 * @property string $extension
 * @property integer $idleduration
 * @property integer $ringduration
 * @property integer $holdduration
 * @property integer $ivrduration
 * @property string $accountnumber
 * @property string $ipadr
 */
class CdrCollect extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cdr_collect}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('trunkid, duration, idleduration, ringduration, holdduration, ivrduration', 'numerical', 'integerOnly'=>true),
			array('sys', 'length', 'max'=>16),
			array('primarycallid, callid, cid_from, cid_to, remoteparty, localparty, trunkname, domain, recordlocation, extension', 'length', 'max'=>255),
			array('direction', 'length', 'max'=>4),
			array('cost, durationhhmmss, type', 'length', 'max'=>10),
			array('cmc, accountnumber', 'length', 'max'=>20),
			array('ipadr', 'length', 'max'=>40),
			array('timestart, timeconnected, timeend, ltime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sys, primarycallid, callid, cid_from, cid_to, direction, remoteparty, localparty, trunkname, trunkid, cost, cmc, domain, timestart, timeconnected, timeend, ltime, durationhhmmss, duration, recordlocation, type, extension, idleduration, ringduration, holdduration, ivrduration, accountnumber, ipadr', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'sys' => 'Sys',
			'primarycallid' => 'Primarycallid',
			'callid' => 'Callid',
			'cid_from' => 'Cid From',
			'cid_to' => 'Cid To',
			'direction' => 'Direction',
			'remoteparty' => 'Remoteparty',
			'localparty' => 'Localparty',
			'trunkname' => 'Trunkname',
			'trunkid' => 'Trunkid',
			'cost' => 'Cost',
			'cmc' => 'Cmc',
			'domain' => 'Domain',
			'timestart' => 'Timestart',
			'timeconnected' => 'Timeconnected',
			'timeend' => 'Timeend',
			'ltime' => 'Ltime',
			'durationhhmmss' => 'Durationhhmmss',
			'duration' => 'Duration',
			'recordlocation' => 'Recordlocation',
			'type' => 'Type',
			'extension' => 'Extension',
			'idleduration' => 'Idleduration',
			'ringduration' => 'Ringduration',
			'holdduration' => 'Holdduration',
			'ivrduration' => 'Ivrduration',
			'accountnumber' => 'Accountnumber',
			'ipadr' => 'Ipadr',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('sys',$this->sys,true);
		$criteria->compare('primarycallid',$this->primarycallid,true);
		$criteria->compare('callid',$this->callid,true);
		$criteria->compare('cid_from',$this->cid_from,true);
		$criteria->compare('cid_to',$this->cid_to,true);
		$criteria->compare('direction',$this->direction,true);
		$criteria->compare('remoteparty',$this->remoteparty,true);
		$criteria->compare('localparty',$this->localparty,true);
		$criteria->compare('trunkname',$this->trunkname,true);
		$criteria->compare('trunkid',$this->trunkid);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('cmc',$this->cmc,true);
		$criteria->compare('domain',$this->domain,true);
		$criteria->compare('timestart',$this->timestart,true);
		$criteria->compare('timeconnected',$this->timeconnected,true);
		$criteria->compare('timeend',$this->timeend,true);
		$criteria->compare('ltime',$this->ltime,true);
		$criteria->compare('durationhhmmss',$this->durationhhmmss,true);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('recordlocation',$this->recordlocation,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('idleduration',$this->idleduration);
		$criteria->compare('ringduration',$this->ringduration);
		$criteria->compare('holdduration',$this->holdduration);
		$criteria->compare('ivrduration',$this->ivrduration);
		$criteria->compare('accountnumber',$this->accountnumber,true);
		$criteria->compare('ipadr',$this->ipadr,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CdrCollect the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
