<?php

class PatientsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
    public $layout = '/layouts/column1';
    
    public function init(){
        parent::init();
        $cs = Yii::app()->clientScript; //
        $cs->registerCssFile(Yii::app()->request->baseUrl . '/assets/css/dataTables.bootstrap.css');
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.cleditor.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.placeholder.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.maskedinput.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.inputlimiter.1.3.1.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.dataTables.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/dataTables.bootstrap.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/patients.js', CClientScript::POS_END);
        $cs->registerCss(
            1,
            'div.popover{max-width:750px;}');
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
				'actions'=>array('create','update'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Patients;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Patients']))
		{
			$model->attributes=$_POST['Patients'];
			//print_r($_POST);
            if (!empty($model->avatar_path) && substr_count($model->avatar_path, '/avatar/') == 0) {
                $nameFile = $model->avatar_path;
                $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
                $siteFolder=Yii::getPathOfAlias('webroot').'/upload/avatar/';  
                if(rename($tempFolder.$nameFile, $siteFolder.$nameFile))
                {
                    $logo_path = "/upload/avatar/".$nameFile;
                    $model->avatar_path = $logo_path;
                }
            }
            if($model->save()){
                $id_patient = $model->id_patient;
                if (isset($_POST['Patients']['cameraUrl']) && count($_POST['Patients']['cameraUrl'])) {
                    $cameras = $_POST['Patients']['cameraUrl'];
                    foreach ($cameras as $cam) {
                        $urlPatient = new PatientCameras;
                        $urlPatient->id_patient = $id_patient;
                        $urlPatient->desc_camera = $cam['desc'];
                        $urlPatient->url_camera = $cam['url'];
                        $urlPatient->save();
                    }
                }
                if (isset($_POST['Patients']['emergency']) && count($_POST['Patients']['emergency'])) {
                    foreach ($_POST['Patients']['emergency'] as $kl) {
                        $modEmergency = new EmergencyContact;
                        $modEmergency->attributes = $kl;
                        $modEmergency->id_patient = $id_patient;
                        //$modEmergency->passwd = md5($modEmergency->passwd);
                        $modEmergency->save();
                    }
                }
                
                if (isset($_POST['Patients']['patient_notes']) && count($_POST['Patients']['patient_notes'])) {
                        foreach ($_POST['Patients']['patient_notes'] as $kn) {
                            if (count($kn)) {
                                $modPatientNotes = new PatientsNotes;
                                $modPatientNotes->id_patient = $id_patient;
                                $nameFile = $kn['notes_file'];
                                $modPatientNotes->notes = $kn['notes'];
                                $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
                                $notesFolder=Yii::getPathOfAlias('webroot').'/upload/notes/';  
                                if ($nameFile != "") {
                                    if(rename($tempFolder.$nameFile, $notesFolder.$nameFile))
                                    {
                                        $logo_path = "/upload/notes/".$nameFile;
                                        $modPatientNotes->file_url = $logo_path;
                                    }
                                }
                                $modPatientNotes->save();
                            }
                        }
                }
                if (isset($_POST['Patients']['id_room']) && !empty($_POST['Patients']['id_room'])) {
                    $id_room = $_POST['Patients']['id_room'];
                    $modResidenceOfRoom = new ResidentsOfRooms;
                    $modResidenceOfRoom->id_patient = $id_patient;
                    $modResidenceOfRoom->id_room = $id_room;
                    $modResidenceOfRoom->save();
                }
                
                Yii::app()->user->setFlash('success',Yii::t('admin/patients','Added Successfuly'));
                $this->redirect(array('index'));
            } else {
                Yii::app()->user->setFlash('error',Yii::t('admin/patients','Added Failury'));
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
        //print_r($_POST['Patients']);exit;

		if(isset($_POST['Patients']))
		{
			$model->attributes=$_POST['Patients'];
            if (!empty($model->avatar_path) && substr_count($model->avatar_path, '/avatar/') == 0) {
                $nameFile = $model->avatar_path;
                $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
                $siteFolder=Yii::getPathOfAlias('webroot').'/upload/avatar/';  
                if(rename($tempFolder.$nameFile, $siteFolder.$nameFile))
                {
                    $logo_path = "/upload/avatar/".$nameFile;
                    $model->avatar_path = $logo_path;
                }
            }
            if($model->save()){
                $id_patient = $model->id_patient;
                if (isset($_POST['Patients']['cameraUrl']) && count($_POST['Patients']['cameraUrl'])) {
                    $cameras = $_POST['Patients']['cameraUrl'];
                    //print_r($cameras);
                    foreach ($cameras as $cam) {
                        if (!empty($cam['desc'])) {
                            $urlPatient = new PatientCameras;
                            $urlPatient->id_patient = $id_patient;
                            $urlPatient->desc_camera = $cam['desc'];
                            $urlPatient->url_camera = $cam['url'];
                            $urlPatient->save();
                        }
                    }
                }
                if (isset($_POST['Patients']['emergency']) && count($_POST['Patients']['emergency'])) {
                    foreach ($_POST['Patients']['emergency'] as $kl) {
                        if (isset($kl['id_emergency_contact']) && $kl['id_emergency_contact'] > 0) {
                            $modEmergency = EmergencyContact::model()->findByPk($kl['id_emergency_contact']);
                            $modEmergency->attributes = $kl;
                            $modEmergency->id_patient = $id_patient;
                            $modEmergency->save();
                        } else {
                            $modEmergency = new EmergencyContact;
                            $modEmergency->attributes = $kl;
                            $modEmergency->id_patient = $id_patient;
                            $modEmergency->save();
                        }
                    }
                }
                
                if (isset($_POST['Patients']['patient_notes']) && count($_POST['Patients']['patient_notes'])) {
                        foreach ($_POST['Patients']['patient_notes'] as $kn) {
                            if (count($kn)) {
                                $modPatientNotes = new PatientsNotes;
                                $modPatientNotes->id_patient = $id_patient;
                                $nameFile = $kn['notes_file'];
                                $modPatientNotes->notes = $kn['notes'];
                                $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
                                $notesFolder=Yii::getPathOfAlias('webroot').'/upload/notes/';  
                                if ($nameFile != "") {
                                    if(rename($tempFolder.$nameFile, $notesFolder.$nameFile))
                                    {
                                        $logo_path = "/upload/notes/".$nameFile;
                                        $modPatientNotes->file_url = $logo_path;
                                    }
                                }
                                $modPatientNotes->save();
                            }
                        }
                }
                if (isset($_POST['Patients']['id_room']) && !empty($_POST['Patients']['id_room'])) {
                    $id_room = $_POST['Patients']['id_room'];
                    $modResidenceOfRoom = ResidentsOfRooms::model()->find('id_patient=:id_patient', array(':id_patient'=>(int) $id_patient));
                    $modResidenceOfRoom->id_patient = $id_patient;
                    $modResidenceOfRoom->id_room = $id_room;
                    $modResidenceOfRoom->save();
                }
                Yii::app()->user->setFlash('success',Yii::t('admin/patients','Updated Successfuly'));
                $this->redirect(array('index'));
            } else {
                Yii::app()->user->setFlash('error',Yii::t('admin/patients','Updated Failure'));
            }
		} else {
            $res = ResidentsOfRooms::model()->findByAttributes(array('id_patient'=>$id));
           $model->id_room = $res->id_room;
        }

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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
//		$model=new Patients('search');
//		$model->unsetAttributes();  // clear any default values
//		if(isset($_GET['Patients']))
//			$model->attributes=$_GET['Patients'];
        $criteria=new CDbCriteria;

        //$criteria->compare('id_map',$id);
        $criteria->select = '*, r.nb_room, r.id_room, r.id_map, r.id_building';
        $criteria->alias = 'pat';
        $criteria->join = 'INNER JOIN {{residents_of_rooms}} as rdp ON rdp.id_patient = pat.id_patient';
        $criteria->join .= ' LEFT JOIN {{rooms}} as r ON rdp.id_room = r.id_room';


        $dataProvide = new CActiveDataProvider('Patients', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>25,
            ),
        ));

		$this->render('index',array(
			'model'=>$dataProvide,
		));
	}
    public function actionFloor($id, $building_id)
    {

        $criteria=new CDbCriteria;

        //$criteria->compare('id_map',$id);
        $criteria->select = '*, r.nb_room, r.id_room';
        $criteria->alias = 'pat';
        $criteria->join = 'INNER JOIN {{residents_of_rooms}} as rdp ON rdp.id_patient = pat.id_patient';
        $criteria->join .= ' LEFT JOIN {{rooms}} as r ON rdp.id_room = r.id_room';
        $criteria->condition = 'r.id_map = :id_map';
        $criteria->params = array(':id_map'=>$id);


        $dataProvide = new CActiveDataProvider('Patients', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>25,
            ),
        ));

        //print_r($dataProvide);exit;
        $this->render('index',array(
            'model'=>$dataProvide,
        ));
    }
    public function actionInformations()
    {
        $start = (isset($_POST['start']) && !empty($_POST['start'])) ? trim($_POST['start']) : 0;
        $length = (isset($_POST['length']) && !empty($_POST['length'])) ? trim($_POST['length']) : 25;
        $search = (isset($_POST['search']['value']) && !empty($_POST['search']['value'])) ? trim($_POST['search']['value']) : "";
        $draw = (isset($_POST['draw']) && !empty($_POST['draw'])) ? trim($_POST['draw']) : 0;
        $order = (isset($_POST['order'])) ? $_POST['order'][0] : array('column' => 0, 'dir' => 'desc');
        $column = array('pat.first_name', 'pat.last_name', 'pat.afliction', 'pat.text_desc', 'r.nb_room', 'b.name', 'm.description', 'm.name_map');
        $id_building = (isset($_POST['id_building']) && !empty($_POST['id_building'])) ? trim($_POST['id_building']) : 0;
        $id_map = (isset($_POST['id_map']) && !empty($_POST['id_map'])) ? trim($_POST['id_map']) : 0;


        $sql = "SELECT SQL_CALC_FOUND_ROWS (0), pat.id_patient, pat.first_name, pat.last_name, pat.afliction, pat.text_desc, r.nb_room, r.id_room, b.name, m.description, m.name_map, m.path_to_img
                FROM {{patients}} pat
                INNER JOIN {{residents_of_rooms}} as rdp ON rdp.id_patient = pat.id_patient
                INNER JOIN {{rooms}} r ON r.id_room = rdp.id_room
                INNER JOIN {{maps}} m ON m.id_map = r.id_map
                INNER JOIN {{buildings}} b ON b.id_building = r.id_building";

        $whereTXT = "";
        $whereArray = NULL;

        if ($id_building > 0) {
            $whereTXT = " b.id_building = :id_building";
            $whereArray[':id_building'] = $id_building;
        }
        if ($id_map > 0) {
            if ($whereTXT != "")
                $whereTXT .= " AND ";

            $whereTXT .= " m.id_map = :id_map";
            $whereArray[':id_map'] = $id_map;
        }
        if (!empty($search)) {
            if ($whereTXT != "")
                $whereTXT .= " AND ";

            $whereTXT .= " ( pat.first_name LIKE :searchText ";
            $whereTXT .= " OR pat.last_name LIKE :searchText";
            $whereTXT .= " OR pat.afliction LIKE :searchText";
            $whereTXT .= " OR pat.text_desc LIKE :searchText";
            $whereTXT .= " OR r.nb_room LIKE :searchText";
            $whereTXT .= " OR b.name LIKE :searchText";
            $whereTXT .= " OR m.description LIKE :searchText";
            $whereTXT .= " OR m.name_map LIKE :searchText )";

            $whereArray[':searchText'] = "%" . $search . "%";

        }
        $offset = ($length > 0) ? " LIMIT $start,$length" : "";
        $orderBy = " ORDER BY " . $column[$order['column']] . ' ' . $order['dir'];
        if ($whereTXT != "")
            $logs = Yii::app()->db->createCommand($sql . ' WHERE ' . $whereTXT . $orderBy . $offset);
        else
            $logs = Yii::app()->db->createCommand($sql.' '. $whereTXT . $orderBy . $offset);

        $resultArray = array();
        //print_r($whereArray);
        try {
            //print_r($whereArray);
            if ($whereTXT != "")
                $resultArray = $logs->queryAll(true, $whereArray);
            else
                $resultArray = $logs->queryAll();
            //print_r($resultArray);
            $lengthResult = Yii::app()->db->createCommand('SELECT FOUND_ROWS()')->queryScalar();
            //echo $logs->order($column[$order['column']].' '.$order['dir'])->limit($length, $start)->getText();
            $text = $logs->getText();
            //Yii::log(CVarDumper::dumpAsString(print_r($resultArray, true)."\n\r".$text, 10),'error','app');

        } catch (Exception $e) {
            $text = $logs->getText();
            //$txtArr = print_r($whereArray, true);
            //Yii::log(CVarDumper::dumpAsString(print_r($whereArray, true)."\n\r".$text, 10),'error','app');

        }
        if (count($resultArray) > 0) {
            $arr = array();
            $data = array();
            //$column = array("pat.first_name, pat.last_name, pat.afliction, pat.text_desc, r.nb_room, b.name, m.description, m.name_map");
            $end = ($length > $lengthResult) ? $lengthResult : $length;
            foreach ($resultArray as $kl) {
                $htmlData ='';
                $crCamera = new CDbCriteria;
                $crCamera->condition = 'id_patient = :id_patient';
                $crCamera->params = array(':id_patient'=>$kl['id_patient']);

                $mdCamera = PatientCameras::model()->findAll($crCamera);
                //Yii::log(CVarDumper::dumpAsString(print_r($mdCamera, true)."\n\r".$text, 10),'error','app');
                if (count($mdCamera)) {
                    $content = "";
                    foreach ($mdCamera as $k) {
                        $content .= "<div class=\"thumbnail\">".CHtml::image($k->url_camera,$kl['first_name'].' '.$kl['last_name'], array('width'=>'128px'))."</div>";
                    }
                    $htmlData = "<span title='".$kl['nb_room']."'  data-html='true' data-content='".$content."' data-toggle='popover' data-trigger='hover' data-placement='right' onClick=\"javascript:openCameraView('".$k->url_camera."')\" style='cursor:pointer'>".$kl['nb_room']."</span>";
                } else {
                    $htmlData = $kl['nb_room'];
                }

                $action = "<a href='#' url='".Yii::app()->createUrl("admin/patients/manageNotes", array("id"=>$kl['id_patient']))."' onClick='javascript:return manageNotes(this);'><i class='fa fa-book'></i></a>";
                $action .= "&nbsp;&nbsp;<a href='".Yii::app()->createUrl("admin/patients/update", array("id"=>$kl['id_patient']))."'><i class='fa fa-pencil'></i></a>";
                $action .= "&nbsp;&nbsp;<a href='".Yii::app()->createUrl("admin/patients/delete", array("id"=>$kl['id_patient']))."'><i class='fa fa-trash-o'></i></a>";
                $data[] = array(
                    $kl['first_name'],
                    $kl['last_name'],
                    $kl['afliction'],
                    $kl['name'],
                    CHtml::link( '<i class="fa fa-eye"></i>', array( 'rooms/viewonmap/id/'.$kl['id_room'] ), array('class'=>'btn btn-xs btn-success',)).'&nbsp;'.$kl['name_map'],
                    $htmlData,
                    $action
                );
            }
            header('Content-Type: application/json');
            echo json_encode(array('draw' => $draw, 'recordsTotal' => $lengthResult, 'recordsFiltered' => $lengthResult, 'data' => $data));

        } else {
            $data = array();
            header('Content-Type: application/json');
            echo json_encode(array('draw'=>$draw, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => $data));
        }
    }
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Patients the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Patients::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Patients $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='patients-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionSaveavatar(){
        $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
    
        //mkdir($tempFolder, 0777, TRUE);
        //mkdir($tempFolder.'chunks', 0777, TRUE);
    
        Yii::import("ext.EFineUploader.qqFileUploader");
    
        $uploader = new qqFileUploader();
        $uploader->allowedExtensions = array('jpg','jpeg', 'bmp', 'gif', 'png');
        $uploader->sizeLimit = 6 * 1024 * 1024;//maximum file size in bytes
        $uploader->chunksFolder = $tempFolder.'chunks';
    
        $result = $uploader->handleUpload($tempFolder);
        $result['filename'] = $uploader->getUploadName();
        //$result['folder'] = $webFolder;
    
        $uploadedFile=$tempFolder.$result['filename'];
    
        header("Content-Type: text/plain");
        $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result;
        Yii::app()->end();
     }
     
     public function actionFloorRoomList(){
        //print_r($this->id);
        if (!empty($_POST['id_building'])){
            $id_building = (int) $_POST['id_building'];
            $id_room = (isset($_POST['id_room']) && !empty($_POST['id_room'])) ? ((int) $_POST['id_room']) : -1;
            $rooms = Yii::app()->db->createCommand()
                ->select('r.id_room, r.nb_room, m.id_map, m.name_map')
                ->from('{{rooms}} r')
                ->join('{{maps}} m', 'r.id_map=m.id_map')
                ->where('m.id_building=:id', array(':id'=>$id_building))
                ->queryAll();
            $floorRoomArray = array();
            foreach ($rooms as $v) {
                $floorRoomArray[$v['id_map']]['name'] = $v['name_map'];
                $floorRoomArray[$v['id_map']]['rooms'][] = array('id_room' => $v['id_room'], 'nb'=> $v['nb_room']);
            }
            $html = "";
            foreach ($floorRoomArray as $kk=>$vv) {
                //print_r($kk);
                if (count($vv['rooms']) > 0) {
                    $html .= '<optgroup label="'.$vv['name'].'">';
                    foreach ($vv['rooms'] as $rr) {
                        if ($id_room == $rr['id_room'])
                            $html .= '<option value="'.$rr['id_room'].'" SELECTED>'.CHtml::encode($rr['nb'])."</option>";
                        else
                            $html .= '<option value="'.$rr['id_room'].'">'.CHtml::encode($rr['nb'])."</option>";
                    }
                    $html .= '</optgroup>';

                }
            }
            echo $html;
           //$data = CHtml::listData($floorRoomArray,'id_room','nb','group');
           //echo $data;
        }
     }
     
     public function actionCameraUrl(){
        $tt = time(); 
        $str = "";
        $str .= "<div id='{$tt}' class='row'>";
        $str .= '   <div class="col-lg-4">';
        $str .= '            <label class="control-label" for="Patients[cameraUrl]['.$tt.'][desc]">'.Yii::t('admin/patients', 'Camera Description').'</label>';
        $str .= '            <div class="input-group date col-sm-4">';
        $str .= '                <span class="input-group-addon">';
        $str .= '                    <i class="fa  fa-eye-slash"></i>';
        $str .= '                </span>';
        $str .=  CHtml::textField('Patients[cameraUrl]['.$tt.'][desc]', '', array('class'=>'form-control','style'=>"width: 250px;")); 
        $str .= '           </div><br />';
        $str .= '   </div>';
        $str .= '   <div class="col-lg-4">';
        $str .= '       <label class="control-label" for="Patients[cameraUrl]['.$tt.'][url]">'.Yii::t('admin/patients', 'Camera Url').'</label>';
        $str .= '       <div class="input-group date col-sm-12">
                            <span class="input-group-addon">
                                <i class="fa  fa-external-link"></i>
                            </span>';
        $str .= CHtml::textField('Patients[cameraUrl]['.$tt.'][url]', '', array('class'=>'form-control','style'=>"width: 250px;")); 
        $str .= '        </div>';
        $str .= '</div>';
        $str .= '   <div class="col-lg-2" style="padding-top: 35px;">';
        $str .= '<a onClick="javascript:addCameraUrl();" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>';
        $str .= '&nbsp;&nbsp;<a onClick="javascript:delCameraUrl('.$tt.');" class="btn btn-xs btn-success"><i class="fa fa-trash-o"></i></a>';
        $str .= '   </div>';

        $str .= "</div>";
        echo $str;
     }
     
     public function actionSaveafiles(){
        $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
    
        //mkdir($tempFolder, 0777, TRUE);
        //mkdir($tempFolder.'chunks', 0777, TRUE);
    
        Yii::import("ext.EFineUploader.qqFileUploader");
    
        $uploader = new qqFileUploader();
        $uploader->allowedExtensions = array('jpg','jpeg', 'bmp', 'gif', 'png', 'pdf', 'doc', 'docx');
        $uploader->sizeLimit = 6 * 1024 * 1024;//maximum file size in bytes
        $uploader->chunksFolder = $tempFolder.'chunks';
    
        $result = $uploader->handleUpload($tempFolder);
        $result['filename'] = $uploader->getUploadName();
        //$result['folder'] = $webFolder;
    
        $uploadedFile=$tempFolder.$result['filename'];
    
        header("Content-Type: text/plain");
        $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result;
        Yii::app()->end();
     }
     
     public function actionPatientNotes(){
        $tt = time(); 
        $str = ""; 
        $str .= '<div class="row" id="'.$tt.'">
            <div class="col-sm-6">
                <div class="col-sm-9">
                    <label class="control-label" for="notes">'.Yii::t('admin/patients','notes').'</label>
    				<div class="controls">';
        $str .= CHtml::textArea('Patients[notes][]','', array('class'=>'cleditor')); 
    	$str .= '			</div>
                </div>
            </div>';
        $str .= '    <div class="col-sm-3">
                <label class="control-label" for="description_email">'.Yii::t('admin/patients','notes_file').'</label>';
        $str .= CHtml::hiddenField('Patients[notes_file][]',''); 
        ob_start();
        $this->widget('ext.EFineUploader.EFineUploader',
                            array(
                                'id'=>'NotesFiles'.$tt,
                                'config'=>array(
                                    'autoUpload'=>true,
                                    'request'=>array(
                                        'endpoint'=>$this->createUrl('patients/saveafiles'),// OR $this->createUrl('files/upload'),
                                        'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                                    ),
                                   'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
                                   'chunking'=>array('enable'=>true,'partSize'=>50),//bytes
                                   'validation'=>array(
                                        'allowedExtensions'=>array('jpg','jpeg', 'bmp', 'gif', 'png', 'pdf', 'doc', 'docx'),
                                        'sizeLimit'=>6 * 1024 * 1024,//maximum file size in bytes
                                        'minSizeLimit'=>0.01*1024*1024,// minimum file size in bytes
                                   ),
                                   'callbacks'=>array(
                                      'onComplete'=>"js:function(id, name, response){ // for test purpose
                                         $('#Patients_notes_file').val(response.filename);
                                       }",
                                       //'onError'=>"js:function(id, name, errorReason){ }",
                                      'onValidateBatch' => "js:function(fileOrBlobData) {}", // because of crash
                                    ),
                                ),
                                
                            )
                        );
        $str .= ob_get_contents();
        ob_end_clean();
        $str .= '    </div>
            <div class="col-sm-3">
                <a onClick="javascript:addNotes();" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>
                &nbsp;&nbsp;<a onClick="javascript:delCameraUrl('.$tt.');" class="btn btn-xs btn-success"><i class="fa fa-trash-o"></i></a>
            </div>
        </div>';
        echo $str;
        
     }
     
     public function actionGetEmergencyContact(){
        if (isset($_POST['id_patient']) && !empty($_POST['id_patient'])) {
            $id_patient = $_POST['id_patient'];
            $emergency = EmergencyContact::model()->findAll('id_patient=:id_patient',array(':id_patient' => $id_patient)); 
            
            $str = '';
            if (count($emergency)) {
                $cc = 0;
                foreach($emergency as $k) {
                    $today = time().rand(0,999999999);
                    $str .= "<tr id='". $today ."'>";
                    $str .= '<td><input type="hidden" id="Patients_em_id'. $today .'" name="Patients[emergency]['. $today .'][id_emergency_contact]" value="'.$k->id_emergency_contact.'"/> <input type="text" id="Patients_em_name'. $today .'" name="Patients[emergency]['. $today .'][name_contact]" value="'.$k->name_contact.'" style="width:100px" class="form-control" maxlength="250" size="60"></td>';
                    $str .= '<td><input type="text" id="Patients_em_phone'. $today .'" name="Patients[emergency]['. $today .'][phone]" value="'.$k->phone.'"  style="width:100px" class="form-control" maxlength="250" size="60"></td>';
                    $str .= '<td><input type="text" id="Patients_em_cel'. $today .'" name="Patients[emergency]['. $today .'][mobile]" value="'.$k->mobile.'"  style="width:100px" class="form-control" maxlength="250" size="60"></td>';
                    $str .= '<td><input type="text" id="Patients_em_email'. $today .'" name="Patients[emergency]['. $today .'][email]" value="'.$k->email.'"  style="width:100px" class="form-control" maxlength="250" size="60"></td>';
                    $str .= '<td><input type="text" id="Patients_em_sms'. $today .'" name="Patients[emergency]['. $today .'][sms]" value="'.$k->sms.'"  style="width:100px" class="form-control" maxlength="250" size="60"></td>';
                    $str .= '<td><input type="text" id="Patients_em_login'. $today .'" name="Patients[emergency]['. $today .'][login_id]" value="'.$k->login_id.'"  style="width:100px" class="form-control" maxlength="250" size="60"></td>';
                    $str .= '<td><input type="password" id="Patients_em_pass'. $today .'" name="Patients[emergency]['. $today .'][passwd]" value="'.$k->passwd.'"  style="width:100px" class="form-control" maxlength="250" size="60"></td>';
                    $str .= "<td><a class='btn btn-xs btn-success' onClick='javascript:removeRow(this, ".$k->id_emergency_contact.", \"".Yii::t('admin/patients', 'Are you sure you want to delete this item?')."\");'><i class='fa fa-trash-o'></i></a></td>";
                    $str .= "</tr>";
                }
            }
            echo $str;
        }
     }
     

     public function actionGetNotes(){
        if (isset($_POST['id_patient']) && !empty($_POST['id_patient'])) {
            $id_patient = $_POST['id_patient'];
            $notesModel = PatientsNotes::model()->findAll('id_patient=:id_patient',array(':id_patient' => $id_patient)); 
            if ($notesModel) {
                $arr = array();
                $html = "";
                foreach ($notesModel as $k) {
                    $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
                       '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
                       '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
                       '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
                    );
                    $text = preg_replace($search, '', $k->notes);
                    $html .= "<tr>";
                    $html .= "<td><span title='".substr($text, 0, 150)."&hellip;' data-html='true' data-content='".$k->notes."' data-toggle='popover' data-trigger='hover' data-placement='right'>".substr($text, 0, 150)."&hellip;</span>";
                    $html .= "</td><td style='width:80px;text-align:right;'>";
                    if (!empty($k->file_url) && $k->file_url != "")
                        $html .= "<a href='".Yii::app()->getRequest()->getHostInfo().$k->file_url."' target='_blank'><i class='fa fa-file'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    $html .= "<a href='javascript:void(0);' onClick='javascript:removeNotesRow(".$k->id_patients_notes.", ".$id_patient.",\"".Yii::t('admin/patients', 'Are you sure you want to delete this item?')."\");'><i class='fa fa-trash-o'></i></a></td>";
                    $html .= "</tr>";
                }
                
                if ($html != '') {
                    echo '<div class=""><div class="box"><div class="box-content"><div class="todo"><table class="table table-bordered table-striped table-condensed">'.$html."</table></div></div></div></div><br/>";
                }
                else
                    echo "";
            }
        }
     }
     public function actionPatientInfo($id){
        $model = $this->loadModel($id)->findByPk($id);
        $first_name = $model->first_name;
        $html = $model->first_name.' '.$model->last_name."<br/>"
                .$model->text_desc."";
        echo $html;
     }
     
     public function actionManageNotes($id){
        if (Yii::app()->request->isAjaxRequest) {
            $notesModel=new CActiveDataProvider('PatientsNotes', array(
               'criteria' => array(
                  'condition' => 'id_patient = :id_patient',
                  'params' => array(':id_patient' => $id),
               ),
            ));
            if ($notesModel->totalItemCount > 0) {
                echo $this->renderPartial('_notes_list', array('model'=>$notesModel),true, false);
            } else {
                echo "<div id_patient='{$id}' id='needInfo'></div><center>".Yii::t("admin/patients","No Data")."</center>";
            }
        }
     }
     public function actionUpdateNotes($id){
        $modelNotes = PatientsNotes::model()->findByPk($id);
        if (isset($_POST['PatientsNotes'])) {
            $modelNotes->notes = $_POST['PatientsNotes']['notes'];
            $nameFile = $_POST['PatientsNotes']['file_url'];
            if (!empty($nameFile) && substr_count($nameFile, '/notes/') == 0){
                $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
                $notesFolder=Yii::getPathOfAlias('webroot').'/upload/notes/';  
                if ($nameFile != "") {
                    if(rename($tempFolder.$nameFile, $notesFolder.$nameFile))
                    {
                        $logo_path = "/upload/notes/".$nameFile;
                        $modelNotes->file_url = $logo_path;
                    }
                }
            }
            if($modelNotes->save()) {
                $arr = array('status'=>'success', 'id_patient'=>$modelNotes->id_patient);
            } else {
                $arr = array('status'=>'fail');
            }
            header('Content-Type: application/json');
            echo json_encode($arr);
        } else {
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            //Yii::app()->clientscript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-migrate-1.2.1.min.js'] = false;
            Yii::app()->clientscript->scriptMap['bootstrap.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui-1.10.3.custom.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.ui.touch-punch.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.ui.touch-punch.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.iframe-transport.js'] = false;
            Yii::app()->clientscript->scriptMap['fullcalendar.min.js'] = false;
            Yii::app()->clientscript->scriptMap['custom.min.js'] = false;
            Yii::app()->clientscript->scriptMap['core.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.autosize.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.cleditor.min.js'] = false;
            //Yii::app()->clientscript->scriptMap['bootstrap-wysiwyg.min.js'] = false;
            Yii::app()->clientscript->scriptMap['patients.js'] = false;
            echo $this->renderPartial('_form_update_notes', array('model'=>$modelNotes),false, true);
        }
     }
     public function actionAddNotes(){
        if (Yii::app()->request->isAjaxRequest) {
            
            $modelNotes = new PatientsNotes;
            if (isset($_POST['PatientsNotes'])) {
                $modelNotes->attributes = $_POST['PatientsNotes'];
                //$modelNotes->id_patient = $_POST['PatientsNotes']['id_patient'];
                //$modelNotes->notes = $_POST['PatientsNotes']['notes'];
                $nameFile = $modelNotes->file_url;
                if (!empty($nameFile) && substr_count($nameFile, '/notes/') == 0){
                    $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
                    $notesFolder=Yii::getPathOfAlias('webroot').'/upload/notes/';  
                    if ($nameFile != "") {
                        if(rename($tempFolder.$nameFile, $notesFolder.$nameFile))
                        {
                            $logo_path = "/upload/notes/".$nameFile;
                            $modelNotes->file_url = $logo_path;
                        }
                    }
                }
                if($modelNotes->save()) {
                    $arr = array('status'=>'success', 'id_patient'=>$modelNotes->id_patient);
                } else {
                    $arr = array('status'=>'fail');
                }
                header('Content-Type: application/json');
                echo json_encode($arr);                
            } else {
                Yii::app()->clientscript->scriptMap['jquery.js'] = false;
                Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
                //Yii::app()->clientscript->scriptMap['jquery.yiiactiveform.js'] = false;
                Yii::app()->clientscript->scriptMap['jquery-migrate-1.2.1.min.js'] = false;
                Yii::app()->clientscript->scriptMap['bootstrap.min.js'] = false;
                Yii::app()->clientscript->scriptMap['jquery-ui-1.10.3.custom.min.js'] = false;
                Yii::app()->clientscript->scriptMap['jquery.ui.touch-punch.min.js'] = false;
                Yii::app()->clientscript->scriptMap['jquery.ui.touch-punch.min.js'] = false;
                Yii::app()->clientscript->scriptMap['jquery.iframe-transport.js'] = false;
                Yii::app()->clientscript->scriptMap['fullcalendar.min.js'] = false;
                Yii::app()->clientscript->scriptMap['custom.min.js'] = false;
                Yii::app()->clientscript->scriptMap['core.min.js'] = false;
                Yii::app()->clientscript->scriptMap['jquery.autosize.min.js'] = false;
                Yii::app()->clientscript->scriptMap['jquery.cleditor.min.js'] = false;
                //Yii::app()->clientscript->scriptMap['bootstrap-wysiwyg.min.js'] = false;
                Yii::app()->clientscript->scriptMap['patients.js'] = false;
                echo $this->renderPartial('_form_add_notes', array('model'=>$modelNotes),false, true);
            }
        }
     }
     public function actionDeleteNotes($id){
        $modelNotes = PatientsNotes::model()->findByPk($id);
        if (!empty($modelNotes->file_url) && $modelNotes->file_url != "")
            $file_url = ".".$modelNotes->file_url;
        else
            $file_url = "";
        if ($modelNotes->delete()) {
            if ($file_url != "" && !empty($file_url))
                unlink($file_url);
            $arr = array('status'=>'success');
        } else {
            $arr = array('status'=>'fail');
        }
        header('Content-Type: application/json');
        echo json_encode($arr);
     }
     
     public function actionFormImportCSV(){
        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-migrate-1.2.1.min.js'] = false;
            Yii::app()->clientscript->scriptMap['bootstrap.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui-1.10.3.custom.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.ui.touch-punch.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.ui.touch-punch.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.iframe-transport.js'] = false;
            Yii::app()->clientscript->scriptMap['fullcalendar.min.js'] = false;
            Yii::app()->clientscript->scriptMap['custom.min.js'] = false;
            Yii::app()->clientscript->scriptMap['core.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.autosize.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.cleditor.min.js'] = false;
            Yii::app()->clientscript->scriptMap['patients.js'] = false;
            echo $this->renderPartial('_form_import_csv', array(),false, true);
        }
     }
     
     public function actionImportFromCSVUpload(){
        $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
        Yii::import("ext.EFineUploader.qqFileUploader");
    
        $uploader = new qqFileUploader();
        $uploader->allowedExtensions = array('csv');
        $uploader->sizeLimit = 6 * 1024 * 1024;//maximum file size in bytes
        $uploader->chunksFolder = $tempFolder.'chunks';
    
        $result = $uploader->handleUpload($tempFolder);
        $result['filename'] = $uploader->getUploadName();
    
        $uploadedFile=$tempFolder.$result['filename'];
    
        header("Content-Type: text/plain");
        $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result;
        Yii::app()->end();
     }
     
     public function actionImportFromCvs(){
        if (Yii::app()->request->isAjaxRequest) {
            $nameFile = (isset($_POST['nameFile']) && !empty($_POST['nameFile'])) ? trim($_POST['nameFile']) : "";
            if ($nameFile != "") {
                $row = 1;
                if (($handle = fopen(Yii::getPathOfAlias('webroot').'/upload/temp/'.$nameFile, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $first_name = $last_name = $afliction = $lang = NULL;
                        if ($row > 1) {
                            list($first_name, $last_name, $afliction, $lang) = explode(';', $data[0]);
                            $mdPatients = new Patients;
                            $mdPatients->first_name = $first_name;
                            $mdPatients->last_name = $last_name;
                            $mdPatients->afliction = $afliction;
                            $mdPatients->save();
                        }
                        $row++;
                    }
                    Yii::app()->user->setFlash('success',Yii::t('admin/patients','Imported Successfuly'));
                    unlink(Yii::getPathOfAlias('webroot').'/upload/temp/'.$nameFile);
                    fclose($handle);
                    $arr = array('status'=>'success');
                    header('Content-Type: application/json');
                    echo json_encode($arr);
                }
            }
        }
     }
     
     public function actionGetRoomInformation(){
        if (Yii::app()->request->isAjaxRequest) {
            $id_patient = (isset($_POST['id_patient']) && !empty($_POST['id_patient'])) ? trim($_POST['id_patient']) : "";
            $rooms = Yii::app()->db->createCommand()
            ->select('r.id_building, r.id_map, r.id_room')
            ->from('{{residents_of_rooms}} rr')
            ->join('{{rooms}} r', 'r.id_room = rr.id_room')
            ->where('rr.id_patient=:id', array(':id'=>$id_patient))
            ->queryRow();
            echo CJSON::encode($rooms);
        }
     }
     
    public function actionGetCameraUrl(){
        if (Yii::app()->request->isAjaxRequest) {
            $id_patient = (isset($_POST['id_patient']) && !empty($_POST['id_patient'])) ? trim($_POST['id_patient']) : "";
            $cameraModel = PatientCameras::model()->findAll('id_patient=:id_patient',array(':id_patient' => $id_patient)); 
            $html = "";
            foreach ($cameraModel as $k) {
                    $html .= "<tr>";
                    $html .= "<td>".$k->desc_camera."</td>";
                    $html .= "<td style='width:30px'><span title='".$k->idPatient->first_name.' '.$k->idPatient->last_name."' data-html='true' data-content='<img src=\"".$k->url_camera."\" border=0 width=320/>' data-toggle='popover' data-trigger='hover' data-placement='left'><a href='".$k->url_camera."' target='_blank'><i class='fa fa-eye'></i></a></span></td><td style='width:50px'><a href='javascript:void(0);' onClick='return editCamera(".$k->id_patient_cameras.");'><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href='javascript:void(0);' onClick='return deleteUrlCameraFromUpdate(".$k->id_patient_cameras.','.$id_patient.",  \"".Yii::t('admin/patients', 'Are you sure you want to delete this item?')."\");'><i class='fa fa-trash-o'></i></a></td>";
                    $html .= "</tr>";
                }
                
                if ($html != '') {
                    echo '<div class=" col-sm-11"><div class="box"><div class="box-content"><div class="todo"><table class="table table-bordered table-striped table-condensed">'.$html."</table></div></div></div></div><br/>";
                }
                else
                    echo "";
        }
     }
    public function actionUpdateCamera(){
        if (Yii::app()->request->isAjaxRequest) {
            //print_r($_POST);
            if (isset($_POST['id_patient_cameras']) && !empty($_POST['id_patient_cameras']) &&
                isset($_POST['desc']) && !empty($_POST['desc']) &&
                isset($_POST['url']) && !empty($_POST['url'])
            ) {
                $id_patient_camera = (isset($_POST['id_patient_cameras']) && !empty($_POST['id_patient_cameras'])) ? (int) $_POST['id_patient_cameras'] : 0;
                $desc = (isset($_POST['desc']) && !empty($_POST['desc'])) ? trim($_POST['desc']) : "";
                $url = (isset($_POST['url']) && !empty($_POST['url'])) ? trim($_POST['url']) : "";
                $cameraModel = PatientCameras::model()->findByPk($id_patient_camera);
                $cameraModel->desc_camera = $desc;
                $cameraModel->url_camera = $url;
                $id_patient = $cameraModel->id_patient;
                if ($cameraModel->save()) {
                    $arr = array('status'=>'success', 'id_patient'=>$id_patient);
                } else {
                    $arr = array('status'=>'fail');
                }
                header('Content-Type: application/json');
                echo json_encode($arr);
            } else echo "";
            //$cameraModel = PatientCameras::model()->findByPk($id);
        } else echo "";
    }
    public function actionDelCamera($id){
        if (Yii::app()->request->isAjaxRequest) {
            //$id_patient = (isset($_POST['id_patient']) && !empty($_POST['id_patient'])) ? trim($_POST['id_patient']) : "";
            $cameraModel = PatientCameras::model()->findByPk($id);

            if ($cameraModel->delete()) {
                $arr = array('status'=>'success');
            } else {
                $arr = array('status'=>'fail');
            }
            header('Content-Type: application/json');
            echo json_encode($arr);

        }
    }
     
     public function actionFormCameraEdit($id){
        $cameraModel = PatientCameras::model()->findByPk($id);
        $html = "<form id='cameraEdit'><div class='row'>";
        $html .= CHtml::hiddenField('id_patient_cameras', $cameraModel->id_patient_cameras);
        $html .= "<div class=' col-lg-10'>";
        $html .= '   <div class="row">';
        $html .= '            <label class="control-label" for="desc">'.Yii::t('admin/patients', 'Camera Description').'</label>';
        $html .= '            <div class="input-group date col-sm-4">';
        $html .= '                <span class="input-group-addon">';
        $html .= '                    <i class="fa  fa-eye-slash"></i>';
        $html .= '                </span>';
        $html .=  CHtml::textField('desc', $cameraModel->desc_camera, array('class'=>'form-control','style'=>"width: 250px;")); 
        $html .= '           </div><br />';
        $html .= '   </div>';
        $html .= '   <div class="row">';
        $html .= '       <label class="control-label" for="url">'.Yii::t('admin/patients', 'Camera Url').'</label>';
        $html .= '       <div class="input-group date col-sm-8">
                            <span class="input-group-addon">
                                <i class="fa fa-external-link"></i>
                            </span>';
        $html .= CHtml::textField('url', $cameraModel->url_camera, array('class'=>'form-control','style'=>"width: 250px;")); 
        $html .= '        </div>';
        $html .= '</div><br />';
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</form>";
        echo $html;
     }
     
     public function actionDeleteEmergencyContact(){
         if (Yii::app()->request->isAjaxRequest) {
            $id_emergency_contact = (isset($_POST['id_emergency_contact']) && !empty($_POST['id_emergency_contact'])) ? trim($_POST['id_emergency_contact']) : "";
            $emergency = EmergencyContact::model()->findByPk($id_emergency_contact);
            if (count($emergency)) {
                if ($emergency->delete()){
                    $arr = array('status'=>'success');
                } else {
                    $arr = array('status'=>'fail');
                }
                header('Content-Type: application/json');
                echo json_encode($arr);
            }
         }
     }
     public function actionAddInsertUpdateNotes(){
        if (Yii::app()->request->isAjaxRequest){
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-migrate-1.2.1.min.js'] = false;
            Yii::app()->clientscript->scriptMap['bootstrap.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui-1.10.3.custom.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.ui.touch-punch.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.ui.touch-punch.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.iframe-transport.js'] = false;
            Yii::app()->clientscript->scriptMap['fullcalendar.min.js'] = false;
            Yii::app()->clientscript->scriptMap['custom.min.js'] = false;
            Yii::app()->clientscript->scriptMap['core.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.autosize.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.cleditor.min.js'] = false;
            Yii::app()->clientscript->scriptMap['patients.js'] = false;
            
            $modelNotes = new PatientsNotes;
            echo $this->renderPartial('_form_insert_notes', array('model'=>$modelNotes),false, true);
        }
     }
}
