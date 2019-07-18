<?php

/**
 * This is the model class for table "{{devices}}".
 *
 * The followings are the available columns in table '{{devices}}':
 * @property integer $id_device
 * @property integer $id_building
 * @property integer $id_map
 * @property integer $id_room
 * @property string $device_description
 * @property string $serial_number
 * @property string $language
 * @property integer $activity_timer
 * @property string $activity_timer_status
 * @property integer $nurce_aknowege
 * @property string $nurce_aknowege_status
 * @property integer $call_duration
 * @property integer $auto_test
 * @property string $auto_test_status
 * @property string $comon_area
 * @property integer $id_access_number
 * @property string $type_access_number
 * 
 * 
 * The followings are the available model relations:
 * @property Buildings $idBuilding
 * @property Maps $idMap
 * @property Rooms $idRoom
 * @property ExtensionInfo[] $extensionInfos
 */
class Devices extends CActiveRecord
{
	public $caller_id_internal = "";
    public $caller_id_external = "";
    public $caller_id_name = "";
    public $extension_number = "";
    public $extension_password = "";
    public $id_patient;
    public $id_extension = -1;
    public $nb_room;
    public $extension_define = 0;
    public $ext_number;
    public $viewEditForm = 0;
    public $oldRoom = -1;
    public $patient_name = '';
    
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{devices}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_building, id_map, id_room, device_description, serial_number, language, nurce_aknowege, caller_id_external, caller_id_name, device_type', 'required'),
			array('id_building, id_map, id_room, activity_timer, nurce_aknowege, call_duration, auto_test', 'numerical', 'integerOnly'=>true),
			array('device_description, caller_id_external', 'length', 'max'=>250),
			array('serial_number', 'length', 'max'=>50),

            array('caller_id_internal', 'match', 'pattern'=>'/^[0-9]+$/', 'message' => Yii::t("admin/devices", "Invalid character used"), 'allowEmpty' => true),
            array('caller_id_internal', 'length', 'max' =>15, 'message' => Yii::t("admin/devices", "Maximum length reached")),

            array('caller_id_external', 'match', 'pattern'=>'/^[0-9]+$/', 'message' => Yii::t("admin/devices", "Invalid character used")),
            array('caller_id_external', 'length', 'max' =>15, 'message' => Yii::t("admin/devices", "Maximum length reached")),

            array('caller_id_name', 'match', "pattern"=>"/^[a-zA-Z ]+$/", 'message' => Yii::t("admin/devices", "Invalid character used")),
            array('caller_id_name', 'length', 'max'=> 13, 'message' => Yii::t("admin/devices", "Maximum length reached")),

            array('language', 'length', 'max'=>3),
			//array('activity_timer_status, nurce_aknowege_status, auto_test_status, comon_area', 'length', 'max'=>1),
			array('type_access_number', 'length', 'max'=>10),
            array('coordonate_on_map', 'length', 'max'=>250),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_device, id_building, id_map, id_room, device_description, serial_number, language, activity_timer, activity_timer_status, nurce_aknowege, nurce_aknowege_status, call_duration, auto_test, auto_test_status, comon_area, id_access_number, type_access_number, id_patient, device_type, extension_define, extension_number, coordinate_on_map, position_popup', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
        //Yii::import('application.modules.admin.models.*');
		return array(
			'idBuilding' => array(self::BELONGS_TO, 'Buildings', 'id_building'),
			'idMap' => array(self::BELONGS_TO, 'Maps', 'id_map'),
			'idRoom' => array(self::BELONGS_TO, 'Rooms', 'id_room'),
			'extensionInfos' => array(self::HAS_ONE, 'ExtensionInfo', 'id_device'),
			'roomDevicePatient' => array(self::HAS_ONE, 'RoomDevicePatient', 'id_device'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_device' => Yii::t('admin/devices','Device'),
			'id_building' => Yii::t('admin/devices','Building'),
			'id_map' => Yii::t('admin/devices','Floor'),
			'id_room' => Yii::t('admin/devices','Room'),
			'device_description' => Yii::t('admin/devices','Device Description'),
			'serial_number' => Yii::t('admin/devices','Serial Number'),
			'language' => Yii::t('admin/devices','Language'),
			'activity_timer' => Yii::t('admin/devices','Activity Timer'),
			'activity_timer_status' => Yii::t('admin/devices','Activity Timer Status'),
			'nurce_aknowege' => Yii::t('admin/devices','Nurce Aknowege'),
			'nurce_aknowege_status' => Yii::t('admin/devices','Nurce Aknowege Status'),
			'call_duration' => Yii::t('admin/devices','Call Duration'),
			'auto_test' => Yii::t('admin/devices','Auto Test'),
			'auto_test_status' => Yii::t('admin/devices','Auto Test Status'),
			'comon_area' => Yii::t('admin/devices','Comon Area'),
			'device_type' => Yii::t('admin/devices','Device Type'),
			'ext_number' => Yii::t('admin/devices','Extension Info'),
			//'type_access_number' => Yii::t('admin/devices','Type Access Number'),
			'caller_id_internal' => Yii::t('admin/devices','Caller ID Internal'),
			'caller_id_external' => Yii::t('admin/devices','Caller ID External'),
			'caller_id_name' => Yii::t('admin/devices','Caller ID Name'),
		);
	}
    
    /*
    public function afterSave(){ 
        parent::afterSave();
        if($this->isNewRecord){  
            $aster = Asterisk::model()->findByAttributes(array('id_building'=>$this->id_building));
            $length = 7;
            $chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
            shuffle($chars);
            $password = implode(array_slice($chars, 0, $length));
            
            if (isset($aster)){
                if ($this->extension_define) {
                    $extFinal = $this->extension_number;
                    if ($this->id_extension > 0) {
                        $extInfoPasswd = ExtensionInfo::model()->findByPk($this->id_extension);
                        if (!empty($extInfoPasswd->password)) {
                            $password = $extInfoPasswd->password;
                        }
                    }
                    $data = json_encode(array(
                        'ext_number'=>$extFinal,
                        'caller_id_name' => $this->caller_id_name,
                        'caller_id_internal' => $this->caller_id_internal,
                        'caller_id_external' => $this->caller_id_external,
                        'passwd' => $password
                    ));
                    $output = Yii::app()->curl->post($aster->asterisk_url.'/manageExt.php', $data);
                    if ($output == 'EXT_CREATE_SUCCESS') {
                        $extension_info = new ExtensionInfo;
                        $extension_info->id_device = $this->id_device;
                        $extension_info->id_asterisk = $aster->id_asterisk;
                        $extension_info->caller_id_internal =  $this->caller_id_internal;
                        $extension_info->caller_id_external =  $this->caller_id_external;
                        $extension_info->caller_id_name = $this->caller_id_name;
                        $extension_info->ext_number = $extFinal;
                        $extension_info->password = $password;
                        $extension_info->extension_define = $this->extension_define;
                        $extension_info->save();
                        Yii::app()->user->setFlash('success',Yii::t('admin/devices','Added Extension Successfuly'));
                    } else if ($output == 'EXT_EXIST') {

                    }

                } else {
                    $roomInfo = Rooms::model()->findByPk($this->id_room);
                    $nbRoom = str_replace("-", "", $roomInfo->nb_room);
                    $extFinal = $this->id_building . $nbRoom;
                    $tmpExtension = "";
                    if ($this->id_extension > 0) {
                        $extInfoPasswd = ExtensionInfo::model()->findByPk($this->id_extension);
                        if (!empty($extInfoPasswd->password)) {
                            $password = $extInfoPasswd->password;
                        }
                    }
                    for ($i = 1; $i < 100; $i++) {
                        if ($i < 10)
                            $tmpExtension = $extFinal . '0' . $i;
                        else
                            $tmpExtension = $extFinal . $i;


                        $data = json_encode(array(
                            'ext_number' => $tmpExtension,
                            'caller_id_name' => $this->caller_id_name,
                            'caller_id_internal' => $this->caller_id_internal,
                            'caller_id_external' => $this->caller_id_external,
                            'passwd' => $password
                        ));

                        $output = Yii::app()->curl->post($aster->asterisk_url . '/manageExt.php', $data);
                        if ($output == 'EXT_CREATE_SUCCESS') {
                            $extension_info = new ExtensionInfo;
                            $extension_info->id_device = $this->getPrimaryKey();
                            $extension_info->id_asterisk = $aster->id_asterisk;
                            $extension_info->caller_id_internal = $this->caller_id_internal;
                            $extension_info->caller_id_external = $this->caller_id_external;
                            $extension_info->caller_id_name = $this->caller_id_name;
                            $extension_info->ext_number = $tmpExtension;
                            $extension_info->password = $password;
                            $extension_info->extension_define = $this->extension_define;
                            $extension_info->save();
                            Yii::app()->user->setFlash('success2', Yii::t('admin/devices', 'Added Extension Successfuly'));
                            break;
                        } else if ($output == 'EXT_EXIST') {
                            //Yii::app()->user->setFlash('error2',Yii::t('admin/devices','Extension Exist, try again'));
                        }
                    }
                }
            }
        } else {
            if ($this->oldRoom != $this->id_room) {
                $roomModel = Rooms::model()->findByPk($this->oldRoom);
                $modelExtension = ExtensionInfo::model()->findByAttributes(array('id_device'=>$this->id_device));
                if (count($modelExtension)) {
                    $aster = Asterisk::model()->findByAttributes(array('id_building'=>$roomModel->id_building));
                    if ($aster) {
                        $output = Yii::app()->curl->post($aster->asterisk_url . '/deleteExtension.php', json_encode(array('ext_number' => $modelExtension->ext_number)));

                        //$aster = Asterisk::model()->findByAttributes(array('id_building'=>$this->id_building));
                        $length = 7;
                        $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
                        shuffle($chars);
                        $password = implode(array_slice($chars, 0, $length));

                        if ($this->extension_define) {
                            $extFinal = $this->extension_number;
                            if ($this->id_extension > 0) {
                                $extInfoPasswd = ExtensionInfo::model()->findByPk($this->id_extension);
                                if (!empty($extInfoPasswd->password)) {
                                    $password = $extInfoPasswd->password;
                                }
                            }
                            $data = json_encode(array(
                                'ext_number' => $extFinal,
                                'caller_id_name' => $this->caller_id_name,
                                'caller_id_internal' => $this->caller_id_internal,
                                'caller_id_external' => $this->caller_id_external,
                                'passwd' => $password
                            ));
                            $output = Yii::app()->curl->post($aster->asterisk_url . '/manageExt.php', $data);
                            if ($output == 'EXT_CREATE_SUCCESS') {
                                $extension_info = new ExtensionInfo;
                                $extension_info->id_device = $this->id_device;
                                $extension_info->id_asterisk = $aster->id_asterisk;
                                $extension_info->caller_id_internal = $this->caller_id_internal;
                                $extension_info->caller_id_external = $this->caller_id_external;
                                $extension_info->caller_id_name = $this->caller_id_name;
                                $extension_info->ext_number = $extFinal;
                                $extension_info->password = $password;
                                $extension_info->extension_define = $this->extension_define;
                                $extension_info->save();
                                Yii::app()->user->setFlash('success', Yii::t('admin/devices', 'Added Extension Successfuly'));
                            } else if ($output == 'EXT_EXIST') {

                            }

                        } else {
                            $roomInfo = Rooms::model()->findByPk($this->id_room);
                            $nbRoom = str_replace("-", "", $roomInfo->nb_room);
                            $extFinal = $this->id_building . $nbRoom;
                            $tmpExtension = "";
                            if ($this->id_extension > 0) {
                                $extInfoPasswd = ExtensionInfo::model()->findByPk($this->id_extension);
                                if (!empty($extInfoPasswd->password)) {
                                    $password = $extInfoPasswd->password;
                                }
                            }
                            for ($i = 1; $i < 100; $i++) {
                                if ($i < 10)
                                    $tmpExtension = $extFinal . '0' . $i;
                                else
                                    $tmpExtension = $extFinal . $i;

                                $data = json_encode(array(
                                    'ext_number' => $tmpExtension,
                                    'caller_id_name' => $this->caller_id_name,
                                    'caller_id_internal' => $this->caller_id_internal,
                                    'caller_id_external' => $this->caller_id_external,
                                    'passwd' => $password
                                ));

                                $output = Yii::app()->curl->post($aster->asterisk_url . '/manageExt.php', $data);
                                if ($output == 'EXT_CREATE_SUCCESS') {
                                    $extension_info = new ExtensionInfo;
                                    $extension_info->id_device = $this->id_device;
                                    $extension_info->id_asterisk = $aster->id_asterisk;
                                    $extension_info->caller_id_internal = $this->caller_id_internal;
                                    $extension_info->caller_id_external = $this->caller_id_external;
                                    $extension_info->caller_id_name = $this->caller_id_name;
                                    $extension_info->ext_number = $tmpExtension;
                                    $extension_info->password = $password;
                                    $extension_info->extension_define = $this->extension_define;
                                    $extension_info->save();
                                    Yii::app()->user->setFlash('success2', Yii::t('admin/devices', 'Added Extension Successfuly'));
                                    berak;
                                } else if ($output == 'EXT_EXIST') {
                                    //Yii::app()->user->setFlash('error2',Yii::t('admin/devices','Extension Exist, try again'));
                                }
                            }
                        }
                    }
                }
            } else {
                $extInfo = ExtensionInfo::model()->findByAttributes(array('id_device'=>$this->id_device));
                
                if (count($extInfo)) {
                    if ($extInfo->extension_define ){
                       $oldExtension = $extInfo->ext_number;
                       $oldAsterisk = $extInfo->id_asterisk;
                    } else {
                       $oldExtension = $extInfo->ext_number;
                       $oldAsterisk = $extInfo->id_asterisk;
                    }
                    $asterInfo = Asterisk::model()->findByPk($oldAsterisk);
                    $output = Yii::app()->curl->post($asterInfo->asterisk_url.'/deleteExtension.php', json_encode(array('ext_number'=>$oldExtension)));
                }
                $aster = Asterisk::model()->findByAttributes(array('id_building'=>$this->id_building));
                $length = 7;
                $chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
                shuffle($chars);
                $password = implode(array_slice($chars, 0, $length));
                if ($this->id_extension > 0) {
                    $extInfoPasswd = ExtensionInfo::model()->findByPk($this->id_extension);
                    if (!empty($extInfoPasswd->password)) {
                        $password = $extInfoPasswd->password;
                    }
                }
                if (isset($aster)) {
                    if ($this->extension_define) {
                        $extFinal = $this->extension_number;
                        $data = json_encode(array(
                            'ext_number' => $extFinal,
                            'caller_id_name' => $this->caller_id_name,
                            'caller_id_internal' => $this->caller_id_internal,
                            'caller_id_external' => $this->caller_id_external,
                            'passwd' => $password
                        ));
                        $output = Yii::app()->curl->post($aster->asterisk_url . '/manageExt.php', $data);
                        if ($output == 'EXT_CREATE_SUCCESS') {

                            $extension_info = ExtensionInfo::model()->findByAttributes(array('id_device' => $this->id_device));
                            if (count($extension_info) == 0)
                                $extension_info = new ExtensionInfo;
                            $extension_info->id_device = $this->id_device;
                            $extension_info->id_asterisk = $aster->id_asterisk;
                            $extension_info->caller_id_internal = $this->caller_id_internal;
                            $extension_info->caller_id_external = $this->caller_id_external;
                            $extension_info->caller_id_name = $this->caller_id_name;
                            $extension_info->ext_number = $extFinal;
                            $extension_info->password = $password;
                            $extension_info->extension_define = $this->extension_define;
                            $extension_info->save();
                            Yii::app()->user->setFlash('success', Yii::t('admin/devices', 'Added Extension Successfuly'));
                        } else if ($output == 'EXT_EXIST') {

                        }

                    } else {
                        $roomInfo = Rooms::model()->findByPk($this->id_room);
                        $nbRoom = str_replace("-", "", $roomInfo->nb_room);
                        $extFinal = $this->id_building . $nbRoom;
                        $tmpExtension = "";
                        for ($i = 1; $i < 100; $i++) {
                            if ($i < 10)
                                $tmpExtension = $extFinal . '0' . $i;
                            else
                                $tmpExtension = $extFinal . $i;

                            $data = json_encode(array(
                                'ext_number' => $tmpExtension,
                                'caller_id_name' => $this->caller_id_name,
                                'caller_id_internal' => $this->caller_id_internal,
                                'caller_id_external' => $this->caller_id_external,
                                'passwd' => $password
                            ));

                            $output = Yii::app()->curl->post($aster->asterisk_url . '/manageExt.php', $data);
                            if ($output == 'EXT_CREATE_SUCCESS') {
                                $extension_info = ExtensionInfo::model()->findByAttributes(array('id_device' => $this->id_device));
                                if (count($extension_info) == 0)
                                    $extension_info = new ExtensionInfo;
                                $extension_info->id_device = $this->id_device;
                                $extension_info->id_asterisk = $aster->id_asterisk;
                                $extension_info->caller_id_internal = $this->caller_id_internal;
                                $extension_info->caller_id_external = $this->caller_id_external;
                                $extension_info->caller_id_name = $this->caller_id_name;
                                $extension_info->ext_number = $tmpExtension;
                                $extension_info->password = $password;
                                $extension_info->extension_define = $this->extension_define;
                                $extension_info->save();
                                Yii::app()->user->setFlash('success2', Yii::t('admin/devices', 'Added Extension Successfuly'));
                                break;
                            } else if ($output == 'EXT_EXIST') {
                                //Yii::app()->user->setFlash('error2',Yii::t('admin/devices','Extension Exist, try again'));
                            }
                        }
                    }
                }
            }
        }
    }
*/
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
        //$criteria->distinct = true;
		$criteria->compare('id_device',$this->id_device);
		$criteria->compare('id_building',$this->id_building);
		$criteria->compare('id_map',$this->id_map);
		$criteria->compare('id_room',$this->id_room);
		$criteria->compare('device_description',$this->device_description,true);
        //$criteria->compare('device_description',$this->device_description,true);
		//$criteria->compare('t.serial_number',$this->serial_number,true);
		//$criteria->compare('t.language',$this->language,true);
		//$criteria->compare('t.activity_timer',$this->activity_timer);
		//$criteria->compare('t.activity_timer_status',$this->activity_timer_status,true);
		//$criteria->compare('t.nurce_aknowege',$this->nurce_aknowege);
		//$criteria->compare('t.nurce_aknowege_status',$this->nurce_aknowege_status,true);
		//$criteria->compare('t.call_duration',$this->call_duration);
		//$criteria->compare('t.auto_test',$this->auto_test);
		//$criteria->compare('t.auto_test_status',$this->auto_test_status,true);
		//$criteria->compare('t.comon_area',$this->comon_area,true);
        
        $criteria->with = array('idBuilding', 'idMap', 'idRoom');
		//$criteria->compare('id_access_number',$this->id_access_number);
		//$criteria->compare('type_access_number',$this->type_access_number,true);
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>25,
            ),
		));
	}
    
    /**
     * Returns the floor list by selected Building
     * @param integer $id_building
     * @return array of building to can populate dropdown
     * 
     */
    
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
    
  
    /**
     * Returns the floor list by selected Building
     * @param integer $id_building
     * @return array of building to can populate dropdown
     * 
     */
    
    public function getRoomList($id_map = -1){
        $data=Rooms::model()->findAll('id_map=:id_map', 
                  array(':id_map'=>(int) $id_map));
 
        $data=CHtml::listData($data,'id_room','nb_room');
        $res = array();
        foreach($data as $value=>$name)
        {
            $res[$value] = $name;
        }
        return $res;
    } 

    

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Devices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getPatients($id_room = -1){
        $data=Patients::model()->with('residentsOfRooms')->findAll('residentsOfRooms.id_room=:id_room', 
                  array(':id_room'=>(int) $id_room));
        //$data=CHtml::listData($data,'id_patient','first_name,last_name');
        $arr = array();
        $arr[''] = CHtml::encode(Yii::t('admin/devices', 'Select Patient'));
        if ($data) {
            foreach ($data as $k) {
                $arr[$k->id_patient] = CHtml::encode($k->first_name.' '.$k->last_name);
            }
        }
        return $arr;
        /*echo CHtml::tag('option',array('value' => ''),
            CHtml::encode(Yii::t('admin/devices', 'Select Patient')),true);
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                       array('value'=>$value),CHtml::encode($name),true);
        }*/
    }
    
}
