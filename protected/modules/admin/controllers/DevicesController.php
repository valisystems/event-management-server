<?php

class DevicesController extends Controller
{
	public $layout = '/layouts/column1';
    public function init(){
        parent::init();
        $cs = Yii::app()->clientScript; //
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.canvasAreaDraw.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-modal.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-dialog.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/devices.js', CClientScript::POS_END);
        //$assetFolder = Yii::app()->assetManager->publish(  Yii::app()->request->baseUrl. '' );
        Yii::app()->clientScript->scriptMap = array(
            'jquery-ui-1.10.3.custom.min.css' => false
        );
        Yii::app()->clientScript->registerCssFile( Yii::app()->request->baseUrl . '/assets/css/modules/admin/pages/devices.css' );

    }
    /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update'),
				'roles'=>array('moderator','administrator'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'roles'=>array('administrator'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}    
    
    public function actionIndex()
	{
        $criteria=new CDbCriteria;
        //$criteria->compare('id_map',$id);
        $criteria->condition = 'device_classification = :device_classification';
        $criteria->params = array(':device_classification'=>'mialert');

        $dataProvide = new CActiveDataProvider('Devices', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>25,
            ),
        ));
        $this->render('index', array('model'=>$dataProvide));
	}
    /**
     * Manages all models.
     */
    public function actionFloor($id, $building_id)
    {

        $criteria=new CDbCriteria;
        //$criteria->compare('id_map',$id);
        $criteria->condition = 'device_classification = :device_classification AND id_map = :id_map';
        $criteria->params = array(':device_classification'=>'mialert', ':id_map' => $id);


        $dataProvide = new CActiveDataProvider('Devices', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>25,
            ),
        ));
        $this->render('index',array(
            'model'=>$dataProvide,
        ));
    }
    
    public function actionAddNew(){
		$model = new Devices;
         $this->performAjaxValidation($model);
         
        $this->renderPartial('_add', array('model'=>$model));
        
    }
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Devices;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Devices']))
		{
			$model->attributes=$_POST['Devices'];
            $model->activity_timer = 0;
            $model->call_duration = 0;
            $model->auto_test = 0;
            $model->id_access_number = 0;
            $model->type_access_number = "";
			if($model->save()) {
                if ($model->comon_area){
                    $modelExtension2 = new RoomDevicePatient;
                    $modelExtension2->id_room = $model->id_room;
                    $modelExtension2->id_device = $model->id_device;
                    $modelExtension2->id_patient = -1;
                    $modelExtension2->save();
                }
				Yii::app()->user->setFlash('success',Yii::t('admin/devices','Added Device Successfuly'));
                $this->redirect(array('index'));
            } else {
                Yii::app()->user->setFlash('error',Yii::t('admin/devices','Please try again'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
    
    /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        $model->oldRoom = $model->id_room;
		if(isset($_POST['Devices']))
		{
			$model->attributes=$_POST['Devices'];
			if($model->save()) {
                if ($model->comon_area) {
                    $modelExtension = RoomDevicePatient::model()->findByAttributes(array('id_device'=>$id));
                    //print_r($modelExtension);
                    if ($modelExtension) {
                        $modelExtension->id_room = $model->id_room;
                        $modelExtension->id_device = $id;
                        $modelExtension->id_patient = -1;
                        $modelExtension->save();
                    } else {
                        $modelExtension2 = new RoomDevicePatient;
                        $modelExtension2->id_room = $model->id_room;
                        $modelExtension2->id_device = $id;
                        $modelExtension2->id_patient = -1;
                        $modelExtension2->save();
                    }
                }
                $this->redirect(array('index'));
            }
		}
        //Yii::app()->clientscript->scriptMap['jquery-ui-1.10.3.custom.min.css'] = false;

		$this->render('update',array(
			'model'=>$model,
		));
	}

    /**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$modelExtension = ExtensionInfo::model()->findByAttributes(array('id_device'=>$id));
        if (count($modelExtension)) {
            $asteriskServer = Asterisk::model()->findByPk($modelExtension->id_asterisk);
            if (isset($asteriskServer)) {
                $extNumber = $modelExtension->ext_number;
                $aster_url = $asteriskServer->asterisk_url;
                $data = json_encode(array(
                    'ext_number' => $extNumber,
                ));
                $output = Yii::app()->curl->post($aster_url . '/deleteExtension.php', $data);
                if ($output == 'EXT_DELETED_SUCCESS') {
                    Yii::app()->user->setFlash('success2', Yii::t('admin/devices', 'Extension Deleted Successfuly'));
                }
            }
        }
        Devices::model()->findByPk($id)->delete();
        Yii::app()->user->setFlash('success',Yii::t('admin/devices','Device Deleted Successfuly'));
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        
	}    
        
    /**
     * Get All Floor of the selected building
     * 
     * @return array of the floors for populate dropdown
     */
    public function actionFloorList(){
        $data=Maps::model()->findAll('id_building=:id_building', 
                  array(':id_building'=>(int) $_POST['id_building']));
 
        $data=CHtml::listData($data,'id_map','name_map');
        echo CHtml::tag('option',array('value' => ''),
            CHtml::encode(Yii::t('admin/devices', 'Select Floor')),true);
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                       array('value'=>$value),CHtml::encode($name),true);
        }
    }

    /**
     * Get All Room of the selected floor
     * 
     * @return array of the floors for populate dropdown
     */
    public function actionRoomList(){
        $data=Rooms::model()->findAll('id_map=:id_map', 
                  array(':id_map'=>(int) $_POST['id_map']));
 
        $data=CHtml::listData($data,'id_room','nb_room');
        echo CHtml::tag('option',array('value' => ''),
            CHtml::encode(Yii::t('admin/devices', 'Select Room')),true);
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                       array('value'=>$value),CHtml::encode($name),true);
        }
    }
    
    
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Devices the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Devices::model()->findByPk($id);
        
        $modelExtension = ExtensionInfo::model()->findByAttributes(array('id_device'=>$id));
        //print_r($modelExtension);
        if ($modelExtension) {
            $model->caller_id_internal = $modelExtension->caller_id_internal;
            $model->caller_id_external = $modelExtension->caller_id_external;
            $model->caller_id_name = $modelExtension->caller_id_name;
            $model->id_extension = $modelExtension->id_extension;
            $model->extension_password = $modelExtension->password;
            $model->extension_number = $modelExtension->ext_number;
            $model->extension_define = $modelExtension->extension_define;
		} else {
            $model->caller_id_internal = "";
            $model->caller_id_external = "";
            $model->caller_id_name = "";
            $model->id_extension = "";
            $model->extension_password = "";
            $model->extension_number = "";
            $model->extension_define = "";
        }
        if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
        return $model;
	}    
    
	/**
	 * Performs the AJAX validation.
	 * @param Rooms $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='devices-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionAddPatient($id){
        //$model2 = new ResidentsOfRooms;
        //$model = $model2->model()->findByPk($id);
        
        $model=$this->loadModel($id);
        $status = 'nothing';
        if(isset($_POST['id_patient']) && !empty($_POST['id_patient']) && isset($_POST['id_room']) && !empty($_POST['id_room']))
		{
			$id_patient = $_POST['id_patient'];
            $id_room = $_POST['id_room'];
            $id_device = $id;
            $modelExtension = RoomDevicePatient::model()->findByAttributes(array('id_device'=>$id));
			//print_r($modelExtension);
            if ($modelExtension) {
                $modelExtension->id_room = $id_room;
                $modelExtension->id_device = $id_device;
                $modelExtension->id_patient = $id_patient;
                if ($modelExtension->save()){
                    $status = 'success_add';
                } else {
                    $status = 'fail_add';
                }
            } else {
                $modelExtension2 = new RoomDevicePatient;
                $modelExtension2->id_room = $id_room;
                $modelExtension2->id_device = $id_device;
                $modelExtension2->id_patient = $id_patient;
                if ($modelExtension2->save()){
                    $status = 'success_update';
                } else {
                    $status = 'fail_update';
                }
            }
            //if($model->save())
		} else {
            $modelExtension = RoomDevicePatient::model()->findByAttributes(array('id_device'=>$id));
            if (count($modelExtension)) {
                $model->id_patient = $modelExtension->id_patient;
            }
		}
        
        echo $this->renderPartial('_addPatient_form', array('model'=>$model, 'status' => $status),true);
    }
    
    public function actionManageExtension($id){
        if(isset($_POST['Devices'])) {
            $devArray = $_POST['Devices'];
            $id_extension = (isset($devArray['id_extension']) && !empty($devArray['id_extension']) && $devArray['id_extension'] > 0) ? $devArray['id_extension'] : -1;
            $extension_define = (isset($devArray['extension_define']) && !empty($devArray['extension_define']) && $devArray['extension_define'] > 0) ? true : false;
            $extension_number = (isset($devArray['extension_number']) && !empty($devArray['extension_number']) && !empty($devArray['extension_number'])) ? $devArray['extension_number'] : NULL;
            $id_building = (isset($devArray['id_building']) && !empty($devArray['id_building']) && $devArray['id_building'] > 0) ? $devArray['id_building'] : -1;
            $id_device = (isset($devArray['id_device']) && !empty($devArray['id_device']) && $devArray['id_device'] > 0) ? $devArray['id_device'] : -1;
            $id_room = (isset($devArray['id_room']) && !empty($devArray['id_room']) && $devArray['id_room'] > 0) ? $devArray['id_room'] : -1;
            $caller_id_internal = (isset($devArray['caller_id_internal']) && !empty($devArray['caller_id_internal']) && !empty($devArray['caller_id_internal'])) ? $devArray['caller_id_internal'] : "";
            $caller_id_external = (isset($devArray['caller_id_external']) && !empty($devArray['caller_id_external']) && !empty($devArray['caller_id_external'])) ? $devArray['caller_id_external'] : "";
            $caller_id_name = (isset($devArray['caller_id_name']) && !empty($devArray['caller_id_name']) && !empty($devArray['caller_id_name'])) ? $devArray['caller_id_name'] : "";

            $length = 7;
            $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
            shuffle($chars);
            $password = implode(array_slice($chars, 0, $length));
            $output = "";

            $aster = Asterisk::model()->findByAttributes(array('id_building' => $id_building));
            //Asterisk::model()->find
            if (count($aster)) {
                if ($extension_define) {
                    if ($id_extension > 0) {
                        $extInfoPasswd = ExtensionInfo::model()->findByPk($id_extension);
                        if (!empty($extInfoPasswd->password)) {
                            $password = $extInfoPasswd->password;
                        }
                    }
                    $data = json_encode(array(
                        'ext_number' => $extension_number,
                        'caller_id_name' => $caller_id_name,
                        'caller_id_internal' => $caller_id_internal,
                        'caller_id_external' => $caller_id_external,
                        'passwd' => $password
                    ));
                    if ($id_extension > 0) {
                        $extInfo = ExtensionInfo::model()->findByPk($id_extension);

                        if ($extInfo->ext_number == 0 && !empty($extInfo->ext_number)) {
                            $output = Yii::app()->curl->post($aster->asterisk_url . '/manageExt.php', $data);
                        } else {
                            $output = Yii::app()->curl->post($aster->asterisk_url . '/deleteExtension.php', json_encode(array('ext_number' => $extInfo->ext_number)));
                            $output = Yii::app()->curl->post($aster->asterisk_url . '/manageExt.php', $data);
                        }
                    } else {
                        $output = Yii::app()->curl->post($aster->asterisk_url . '/manageExt.php', $data);
                    }
                    if ($output == 'EXT_CREATE_SUCCESS') {
                        if ($id_extension > 0) {
                            $extInfo = ExtensionInfo::model()->findByPk($id_extension);
                            $extInfo->id_device = $id_device;
                            $extInfo->id_asterisk = $aster->id_asterisk;
                            $extInfo->caller_id_internal = $caller_id_internal;
                            $extInfo->caller_id_external = $caller_id_external;
                            $extInfo->caller_id_name = $caller_id_name;
                            $extInfo->ext_number = $extension_number;
                            $extInfo->password = $password;
                            $extInfo->save();
                            Yii::app()->user->setFlash('success', Yii::t('admin/devices', 'Updated Extension Successfuly'));
                        } else {
                            $extension_info = new ExtensionInfo;
                            $extension_info->id_device = $id_device;
                            $extension_info->id_asterisk = $aster->id_asterisk;
                            $extension_info->caller_id_internal = $caller_id_internal;
                            $extension_info->caller_id_external = $caller_id_external;
                            $extension_info->caller_id_name = $caller_id_name;
                            $extension_info->ext_number = $extension_number;
                            $extension_info->password = $password;
                            $extension_info->save();
                            Yii::app()->user->setFlash('success', Yii::t('admin/devices', 'Added Extension Successfuly'));
                        }
                    } else if ($output == 'EXT_EXIST') {
                        Yii::app()->user->setFlash('success', Yii::t('admin/devices', 'Extension Exist'));
                    }
                } else {
                    $roomInfo = Rooms::model()->findByPk($id_room);
                    $nbRoom = str_replace("-", "", $roomInfo->nb_room);
                    $extFinal = $id_building . $nbRoom;
                    $tmpExtension = "";
                    for ($i = 1; $i < 10; $i++) {
                        if ($i < 10)
                            $tmpExtension = $extFinal . '0' . $i;
                        else
                            $tmpExtension = $extFinal . $i;
                        if ($id_extension > 0) {
                            $extInfoPasswd = ExtensionInfo::model()->findByPk($id_extension);
                            if (!empty($extInfoPasswd->password)) {
                                $password = $extInfoPasswd->password;
                            }
                        }
                        $data = json_encode(array(
                            'ext_number' => $tmpExtension,
                            'caller_id_name' => $caller_id_name,
                            'caller_id_internal' => $caller_id_internal,
                            'caller_id_external' => $caller_id_external,
                            'passwd' => $password
                        ));

                        if ($id_extension > 0) {
                            $extInfo = ExtensionInfo::model()->findByPk($id_extension);

                            if ($extInfo->ext_number == 0 && !empty($extInfo->ext_number)) {
                                $output = Yii::app()->curl->post($aster->asterisk_url . '/manageExt.php', $data);
                            } else {
                                $output = Yii::app()->curl->post($aster->asterisk_url . '/deleteExtension.php', json_encode(array('ext_number' => $extInfo->ext_number)));
                                $output = Yii::app()->curl->post($aster->asterisk_url . '/manageExt.php', $data);
                            }
                        } else {
                            $output = Yii::app()->curl->post($aster->asterisk_url . '/manageExt.php', $data);
                        }
                        if ($output == 'EXT_CREATE_SUCCESS') {
                            if ($id_extension > 0) {
                                $extInfo = ExtensionInfo::model()->findByPk($id_extension);
                                $extInfo->id_device = $id_device;
                                $extInfo->id_asterisk = $aster->id_asterisk;
                                $extInfo->caller_id_internal = $caller_id_internal;
                                $extInfo->caller_id_external = $caller_id_external;
                                $extInfo->caller_id_name = $caller_id_name;
                                $extInfo->ext_number = $tmpExtension;
                                $extInfo->password = $password;
                                $extInfo->save();
                                Yii::app()->user->setFlash('success', Yii::t('admin/devices', 'Updated Extension Successfuly'));
                            } else {
                                $extension_info = new ExtensionInfo;
                                $extension_info->id_device = $id_device;
                                $extension_info->id_asterisk = $aster->id_asterisk;
                                $extension_info->caller_id_internal = $caller_id_internal;
                                $extension_info->caller_id_external = $caller_id_external;
                                $extension_info->caller_id_name = $caller_id_name;
                                $extension_info->ext_number = $tmpExtension;
                                $extension_info->password = $password;
                                $extension_info->save();
                                Yii::app()->user->setFlash('success', Yii::t('admin/devices', 'Added Extension Successfuly'));
                            }
                            break;
                        }
                    }
                }
            } else {
                Yii::app()->user->setFlash('warning',Yii::t('admin/devices','Sorry, for this building you not have the Node'));
            }
        }
        $model=$this->loadModel($id);
        if (isset($_POST['viewEditForm']) && $_POST['viewEditForm'] == 1)
            $model->viewEditForm = 1;
        echo $this->renderPartial('_manageExtension_form', array('model'=>$model),true);
    }
    public function actionDeleteExtension($id){
        $extModel = ExtensionInfo::model()->findByPk($id);
        $aster = Asterisk::model()->findByPk($extModel->id_asterisk);
        if (isset($aster)){
            $output = Yii::app()->curl->post($aster->asterisk_url . '/deleteExtension.php', json_encode(array('ext_number' => $extModel->ext_number)));
            if ($output == 'EXT_DELETED_SUCCESS') {
                $extModel->delete();
                Yii::app()->user->setFlash('success', Yii::t('admin/devices', 'Device Deleted Successfuly'));
            }
        }
    }
    public function actionFloorInfo($id){
        if (!empty($id)){
            $data=Maps::model()->find('id_map=:id_map', 
                      array(':id_map'=>(int) $id));
            
            if (!empty($data->path_to_img)) {
                $str = '';
                $script = '<script>
                    $( "#devicePosition" ).draggable(
                        {
                            containment: "#roomConstruction", 
                            scroll: false,
                            stop: function() {
                                var pPlan = $("#roomConstruction").position();

                                var p = $( "#devicePosition" );
                                var position = p.position();
                                $("#coordinate_on_map").val((parseInt(position.left) - parseInt(pPlan.left))+";"+(parseInt(position.top) - parseInt(pPlan.top)));

                            }
                        }
                    );
                    //$( "#roomPosition" ).offset({top:10, left: 10});
                </script>
                ';
                
                //Yii::app()->clientScript->registerScript("dragScript",$script);
                list($width, $height, $type, $attr) = getimagesize(substr($data->path_to_img, 1));
                $str .= '<div id="roomConstruction" style="clear:both;width:auto !important;">';
                $str .= '<input id="coordinate_on_map" name="Devices[coordonate_on_map]" type="hidden"/>';
                $str .= '<input id="coordinate_convas" name="coordinate_convas" type="hidden"/>';
                $str .= "<img src='".$data->path_to_img."' border=0 usemap='#roomPositionsMap' id='roomPositionsImg'/>";
                $str .= "<div id='devicePosition' class='btn btn-sm btn-danger draggable ui-widget-content' style='width: auto !important;'>&nbsp;&nbsp;</div>";
                $str .= '</div>';
                echo $str.$script;
            }
            
        } else echo "";
    }
    
    public function actionRoomCoordonate($id){
        if (!empty($id)){
            $data = Rooms::model()->findByPk($id);
            $str = "<map name='roomPositionsMap' id='roomPositionsMap'>";
            $str .= "<area id='".$data->nb_room."' class='droppable' shape='poly' coords='".$data->coordinate_on_map."' href='#'>";
            $str .= "</map>";

            $str = '<input type="hidden" name="coordinate_on_map" id="coordinate_on_map" class="canvas-area" data-image-url="'.$data->idMap->path_to_img.'" value="'.$data->coordinate_on_map.'"/>';
            $arr = array('pathImage'=>$data->idMap->path_to_img, 'coordinate'=>$data->coordinate_on_map);
            header('Content-Type: application/json');
            echo json_encode($arr);

            //echo $str;
        }
    }

    public function actionVerifySerialNumber(){
        $serial_number = (isset($_POST['SerialNumber']) && !empty($_POST['SerialNumber'])) ? $_POST['SerialNumber'] : "";
        if (!empty($serial_number)){
            $model = Devices::model()->find('serial_number=:serial_number', array(':serial_number'=>$serial_number));
            if(count($model)){
                echo "exist";
            } else {
                echo "no";
            }
        }
    }

}