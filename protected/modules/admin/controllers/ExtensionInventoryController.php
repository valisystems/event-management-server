<?php

class ExtensionInventoryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '/layouts/column1';

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
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/extensionInventory.js', CClientScript::POS_END);
	}
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
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
		$model=new ExtensionInventory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ExtensionInventory']))
		{
			$model->attributes=$_POST['ExtensionInventory'];
			if($model->save())
				$this->redirect(array('index'));
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

		if(isset($_POST['ExtensionInventory']))
		{
			$model->attributes=$_POST['ExtensionInventory'];
			if($model->save())
				$this->redirect(array('index'));
		}

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
			$model = new ExtensionInventory('search');
			$model->unsetAttributes();  // clear any default values
			if (isset($_GET['ExtensionInventory']))
				$model->attributes = $_GET['ExtensionInventory'];

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
	 * @return ExtensionInventory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ExtensionInventory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ExtensionInventory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='extension-inventory-form')
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
		$column = array('ei.ext_number','ei.caller_id_internal','ei.caller_id_external','ei.caller_id_name');
		$id_building = (isset($_POST['id_building']) && !empty($_POST['id_building'])) ? trim($_POST['id_building']) : 0;
		$id_map = (isset($_POST['id_map']) && !empty($_POST['id_map'])) ? trim($_POST['id_map']) : 0;


		$sql = "SELECT SQL_CALC_FOUND_ROWS (0), ei.*
                FROM {{extension_inventory}} ei";

		$whereTXT = "";
		$whereArray = NULL;

		if ($id_building > 0) {
			$whereTXT = " ei.id_building = :id_building";
			$whereArray[':id_building'] = $id_building;
		}
		if ($id_map > 0) {
			if ($whereTXT != "")
				$whereTXT .= " AND ";

			$whereTXT .= " ei.id_map = :id_map";
			$whereArray[':id_map'] = $id_map;
		}
		if (!empty($search)) {
			if ($whereTXT != "")
				$whereTXT .= " AND ";

			$whereTXT .= " ( ei.ext_number LIKE :searchText";
			$whereTXT .= " OR ei.caller_id_internal LIKE :searchText";
			$whereTXT .= " OR ei.caller_id_external LIKE :searchText";
			$whereTXT .= " OR ei.caller_id_name LIKE :searchText)";

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
			//Yii::log(CVarDumper::dumpAsString($whereArray."\n\r".$text, 10),'error','app');

		} catch (Exception $e) {
			$text = $logs->getText();
			Yii::log(CVarDumper::dumpAsString(print_r($whereArray, true)."\n\r".$text, 10),'error','app');

		}
		if (count($resultArray) > 0) {
			$arr = array();
			$data = array();
			$end = ($length > $lengthResult) ? $lengthResult : $length;
			foreach ($resultArray as $kl) {
				$htmlData ='';
				$generalInfo = $patientsHtml = $nbOfSeats = $devicesHtml = '';
				//$status = (isset($kl['staff_status']) && !empty($kl['staff_status'])) ? Yii::t('admin/staff', 'Yes') : Yii::t('admin/staff', 'No');


				$action = "&nbsp;&nbsp;<a href='".Yii::app()->createUrl("admin/extensionInventory/update", array("id"=>$kl['id_extension']))."'><i class='fa fa-pencil'></i></a>";
				$action .= "&nbsp;&nbsp;<a href='".Yii::app()->createUrl("admin/extensionInventory/delete", array("id"=>$kl['id_extension']))."' onClick='javascript:return confirm(\"".Yii::t("admin/rooms", "Are you sure you want to delete this item?")."\")'><i class='fa fa-trash-o'></i></a>";
				$data[] = array(
					$kl['ext_number'],
					$kl['caller_id_internal'],
					$kl['caller_id_external'],
					$kl['caller_id_name'],
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

	public function actionFloorList(){
		$data=Maps::model()->findAll('id_building=:id_building',
			array(':id_building'=>(int) $_POST['id_building']));

		$data=CHtml::listData($data,'id_map','name_map');
		echo CHtml::tag('option',array('value' => ''),
			CHtml::encode(Yii::t('admin/extensionInventory', 'Select Floor')),true);
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
				array('value'=>$value),CHtml::encode($name),true);
		}
	}

	public function actionSipServer()
	{
		$data=Asterisk::model()->findAll('id_building=:id_building',
			array(':id_building'=>(int) $_POST['id_building']));

		echo CHtml::tag('option',array('value' => ''),
			CHtml::encode(Yii::t('admin/extensionInventory', 'Select SIP Server')),true);
		$res = array();
		foreach($data as $value=>$row)
		{
			$res[$row->id_asterisk] = $row->asterisk_name.'( '.$row->asterisk_url." )";
			echo CHtml::tag('option',
				array('value'=>$row->id_asterisk),CHtml::encode($row->asterisk_name.'( '.$row->asterisk_url." )"),true);
		}
		return $res;
	}
}
