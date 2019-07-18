<?php

class StaffController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '/layouts/column1';

	const DS = DIRECTORY_SEPARATOR;

	public function init(){
		parent::init();
		$cs = Yii::app()->clientScript; //
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-tab.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.dataTables.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/dataTables.bootstrap.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.cleditor.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-timepicker.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-toggle.min.js', CClientScript::POS_END);

		$cs->registerCssFile(Yii::app()->request->baseUrl . "/assets/css/bootstrap-datetimepicker.css");
		$cs->registerCssFile(Yii::app()->request->baseUrl."/assets/css/bootstrap-toggle.min.css");
		$cs->registerCssFile(Yii::app()->request->baseUrl . '/assets/css/dataTables.bootstrap.css');
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/staff.js', CClientScript::POS_END);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			//'accessControl', // perform access control for CRUD operations
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$model=new Staff;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Staff']))
		{
			$model->attributes=$_POST['Staff'];
			if (!empty($model->avatar_path) && substr_count($model->avatar_path, '/avatarstaff/') == 0) {
				$nameFile = $model->avatar_path;
				$tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
				$siteFolder=Yii::getPathOfAlias('webroot').'/upload/avatarstaff/';
				if(rename($tempFolder.$nameFile, $siteFolder.$nameFile))
				{
					$logo_path = "/upload/avatarstaff/".$nameFile;
					$model->avatar_path = $logo_path;
				}
			}
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('_form',array(
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


		if(isset($_POST['Staff']))
		{
			$model->attributes=$_POST['Staff'];
			if (!empty($model->avatar_path) && substr_count($model->avatar_path, '/avatarstaff/') == 0) {
				$nameFile = $model->avatar_path;
				$tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
				$siteFolder=Yii::getPathOfAlias('webroot').'/upload/avatarstaff/';
				if(rename($tempFolder.$nameFile, $siteFolder.$nameFile))
				{
					$logo_path = "/upload/avatarstaff/".$nameFile;
					$model->avatar_path = $logo_path;
				}
			}
			if($model->save())
				$this->redirect(array('index'));
		}

		Yii::app()->clientScript->registerScript('LoadImage',"
            var logoFile = $('#Staff_avatar_path').val();
            $('#imgLogo').html(\"<img class='img-responsive img-thumbnail' src='\"+logoFile+\"' width='150'>\");
        ",CClientScript::POS_READY);
		$this->render('_form',array(
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		try {
			$model = new Staff('search');
			$model->unsetAttributes();  // clear any default values
			if (isset($_GET['Staff']))
				$model->attributes = $_GET['Staff'];

			if (isset($_GET['ajax'])) {
				Yii::app()->clientscript->scriptMap['jquery.js'] = false;
				Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
				Yii::app()->clientscript->scriptMap['jquery-migrate-1.2.1.min.js'] = false;
				Yii::app()->clientscript->scriptMap['bootstrap.min.js'] = false;
				Yii::app()->clientscript->scriptMap['jquery-ui-1.10.3.custom.min.js'] = false;
				Yii::app()->clientscript->scriptMap['jquery.ui.touch-punch.min.js'] = false;
				Yii::app()->clientscript->scriptMap['jquery.iframe-transport.js'] = false;
				Yii::app()->clientscript->scriptMap['fullcalendar.min.js'] = false;
				Yii::app()->clientscript->scriptMap['custom.min.js'] = false;
				Yii::app()->clientscript->scriptMap['core.min.js'] = false;
				Yii::app()->clientscript->scriptMap['jquery.autosize.min.js'] = false;
				Yii::app()->clientscript->scriptMap['jquery.cleditor.min.js'] = false;
				Yii::app()->clientscript->scriptMap['staff.js'] = true;
				$this->renderPartial('index', array(
					'model' => $model,
				));
			} else {
				$this->render('index', array(
					'model' => $model,
				));
			}
		} catch (Exception $e){
			echo $e->getMessage();
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Staff the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Staff::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Staff $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='staff-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionInformations()
	{
		$start = (isset($_POST['start']) && !empty($_POST['start'])) ? trim($_POST['start']) : 0;
		$length = (isset($_POST['length']) && !empty($_POST['length'])) ? trim($_POST['length']) : 25;
		$search = (isset($_POST['search']['value']) && !empty($_POST['search']['value'])) ? trim($_POST['search']['value']) : "";
		$draw = (isset($_POST['draw']) && !empty($_POST['draw'])) ? trim($_POST['draw']) : 0;
		$order = (isset($_POST['order'])) ? $_POST['order'][0] : array('column' => 0, 'dir' => 'desc');
		$column = array('st.first_name','st.last_name','st.birth_day','st.position','st.staff_status');
		$id_building = (isset($_POST['id_building']) && !empty($_POST['id_building'])) ? trim($_POST['id_building']) : 0;
		//$id_map = (isset($_POST['id_map']) && !empty($_POST['id_map'])) ? trim($_POST['id_map']) : 0;


		$sql = "SELECT SQL_CALC_FOUND_ROWS (0), st.id_staff, st.first_name, st.last_name, st.birth_day, st.avatar_path, st.position, st.description, st.personal_id, st.pin_code, st.staff_status, st.id_building
                FROM {{staff}} st";

		$whereTXT = "";
		$whereArray = NULL;

		if ($id_building > 0) {
			$whereTXT = " st.id_building = :id_building";
			$whereArray[':id_building'] = $id_building;
		}
		if (!empty($search)) {
			if ($whereTXT != "")
				$whereTXT .= " AND ";

			$whereTXT .= " ( st.first_name LIKE :searchText";
			$whereTXT .= " OR st.last_name LIKE :searchText";
			$whereTXT .= " OR st.birth_day LIKE :searchText";
			$whereTXT .= " OR st.avatar_path LIKE :searchText";
			$whereTXT .= " OR st.position LIKE :searchText";
			$whereTXT .= " OR st.description LIKE :searchText";
			$whereTXT .= " OR st.personal_id LIKE :searchText )";

			$whereArray[':searchText'] = "%" . $search . "%";

		}
		$offset = ($length > 0) ? " LIMIT $start,$length" : "";
		$orderBy = " ORDER BY " . $column[$order['column']] . ' ' . $order['dir'];
		if ($whereTXT != "")
			$logs = Yii::app()->db->createCommand($sql . ' WHERE ' . $whereTXT . $orderBy . $offset);
		else
			$logs = Yii::app()->db->createCommand($sql.' '. $whereTXT . $orderBy . $offset);

		$resultArray = array();
		try {
			if ($whereTXT != "")
				$resultArray = $logs->queryAll(true, $whereArray);
			else
				$resultArray = $logs->queryAll();

			$lengthResult = Yii::app()->db->createCommand('SELECT FOUND_ROWS()')->queryScalar();
			$text = $logs->getText();

		} catch (Exception $e) {
			$text = $logs->getText();
			//Yii::log(CVarDumper::dumpAsString(print_r($whereArray, true)."\n\r".$text, 10),'error','app');

		}
		if (count($resultArray) > 0) {
			$arr = array();
			$data = array();
			$end = ($length > $lengthResult) ? $lengthResult : $length;
			foreach ($resultArray as $kl) {
				$htmlData ='';
				$generalInfo = $patientsHtml = $nbOfSeats = $devicesHtml = '';
				$status = (isset($kl['staff_status']) && !empty($kl['staff_status'])) ? Yii::t('admin/staff', 'Yes') : Yii::t('admin/staff', 'No');


				$action = "<a href='#' url='".Yii::app()->createUrl("admin/staff/manageNotes", array("id"=>$kl['id_staff']))."' onClick='javascript:return manageNotes(this);'><i class='fa fa-book'></i></a>";
				$action .= "&nbsp;&nbsp;<a href='".Yii::app()->createUrl("admin/staff/update", array("id"=>$kl['id_staff']))."'><i class='fa fa-pencil'></i></a>";
				$action .= "&nbsp;&nbsp;<a href='".Yii::app()->createUrl("admin/staff/delete", array("id"=>$kl['id_staff']))."' onClick='javascript:return confirm(\"".Yii::t("admin/rooms", "Are you sure you want to delete this item?")."\")'><i class='fa fa-trash-o'></i></a>";
				$data[] = array(
					$kl['first_name'],
					$kl['last_name'],
					$kl['birth_day'],
					$kl['position'],
					$kl['personal_id'],
					$status,
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

	public function actionSaveimage(){
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

	public function actionStaffNotes(){
		$tt = time();
		$str = "";
		$str .= '<div class="row" id="'.$tt.'">
            <div class="col-sm-6">
                <div class="col-sm-9">
                    <label class="control-label" for="notes">'.Yii::t('admin/staff','notes').'</label>
    				<div class="controls">';
		$str .= CHtml::textArea('StaffNotes[notes][]','', array('class'=>'cleditor'));
		$str .= '			</div>
                </div>
            </div>';
		$str .= '    <div class="col-sm-3">
                <label class="control-label" for="description_email">'.Yii::t('admin/staff','notes_file').'</label>';
		$str .= CHtml::hiddenField('StaffNotes[notes_file][]','');
		ob_start();
		$this->widget('ext.EFineUploader.EFineUploader',
			array(
				'id'=>'NotesFiles'.$tt,
				'config'=>array(
					'autoUpload'=>true,
					'request'=>array(
						'endpoint'=>$this->createUrl('staff/saveafiles'),// OR $this->createUrl('files/upload'),
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
                                         $('#Staff_notes_file').val(response.filename);
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
	public function actionManageNotes($id){
		if (Yii::app()->request->isAjaxRequest) {
			$notesModel=new CActiveDataProvider('StaffNotes', array(
				'criteria' => array(
					'condition' => 'id_staff = :id_staff',
					'params' => array(':id_staff' => $id),
				),
			));
			if ($notesModel->totalItemCount > 0) {
				echo $this->renderPartial('_notes_list', array('model'=>$notesModel),true, false);
			} else {
				echo "<div id_staff='{$id}' id='needInfo'></div><center>".Yii::t("admin/staff","No Data")."</center>";
			}
		}
	}
	public function actionUpdateNotes($id){
		$modelNotes = StaffNotes::model()->findByPk($id);
		if (isset($_POST['StaffNotes'])) {
			$modelNotes->notes = $_POST['StaffNotes']['notes'];
			$nameFile = $_POST['StaffNotes']['file_url'];
			if (!empty($nameFile) && substr_count($nameFile, '/notesstaff/') == 0){
				$tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
				$notesFolder=Yii::getPathOfAlias('webroot').'/upload/notesstaff/';
				if ($nameFile != "") {
					if(rename($tempFolder.$nameFile, $notesFolder.$nameFile))
					{
						$logo_path = "/upload/notesstaff/".$nameFile;
						$modelNotes->file_url = $logo_path;
					}
				}
			}
			if($modelNotes->save()) {
				$arr = array('status'=>'success', 'id_staff'=>$modelNotes->id_staff);
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
			Yii::app()->clientscript->scriptMap['staff.js'] = false;
			echo $this->renderPartial('_form_update_notes', array('model'=>$modelNotes),false, true);
		}
	}
	public function actionAddNotes(){
		if (Yii::app()->request->isAjaxRequest) {

			$modelNotes = new StaffNotes;
			if (isset($_POST['StaffNotes'])) {
				$modelNotes->attributes = $_POST['StaffNotes'];
				//$modelNotes->id_patient = $_POST['PatientsNotes']['id_patient'];
				//$modelNotes->notes = $_POST['PatientsNotes']['notes'];
				$nameFile = $modelNotes->file_url;
				if (!empty($nameFile) && substr_count($nameFile, '/notesstaff/') == 0){
					$tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
					$notesFolder=Yii::getPathOfAlias('webroot').'/upload/notesstaff/';
					if ($nameFile != "") {
						if(rename($tempFolder.$nameFile, $notesFolder.$nameFile))
						{
							$logo_path = "/upload/notesstaff/".$nameFile;
							$modelNotes->file_url = $logo_path;
						}
					}
				}
				if($modelNotes->save()) {
					$arr = array('status'=>'success', 'id_staff'=>$modelNotes->id_staff);
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
				Yii::app()->clientscript->scriptMap['staff.js'] = false;
				echo $this->renderPartial('_form_add_notes', array('model'=>$modelNotes),false, true);
			}
		}
	}
	public function actionDeleteNotes($id){
		$modelNotes = StaffNotes::model()->findByPk($id);
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
}
