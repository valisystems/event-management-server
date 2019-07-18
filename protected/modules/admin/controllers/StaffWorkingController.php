<?php

class StaffWorkingController extends Controller
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
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-tab.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.dataTables.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/dataTables.bootstrap.js', CClientScript::POS_END);


		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.cleditor.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-timepicker.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-toggle.min.js', CClientScript::POS_END);

		$cs->registerCssFile(Yii::app()->request->baseUrl . "/assets/css/bootstrap-datetimepicker.css");
		$cs->registerCssFile(Yii::app()->request->baseUrl."/assets/css/bootstrap-toggle.min.css");
		//$cs->registerCssFile(Yii::app()->request->baseUrl . '/assets/css/dataTables.bootstrap.css');
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/highcharts/highcharts.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/highcharts/highcharts-3d.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/staffworking.js', CClientScript::POS_END);

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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		try {
			$model = new StaffWorking('search');
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
		$column = array('st.start_work','s.first_name','st.position', 'ei.ext_number');
		$id_building = (isset($_POST['id_building']) && !empty($_POST['id_building'])) ? trim($_POST['id_building']) : 0;
		$id_map = (isset($_POST['id_map']) && !empty($_POST['id_map'])) ? trim($_POST['id_map']) : 0;


		$sql = "SELECT SQL_CALC_FOUND_ROWS (0), st.* , b.*, m.*, s.*, ei.*
                FROM {{staff_working}} st
                INNER JOIN {{extension_inventory}} ei ON st.id_extension = ei.id_extension
                INNER JOIN {{staff}} s ON st.id_staff = s.id_staff
				INNER JOIN {{buildings}} b on ei.id_building = b.id_building
				INNER JOIN {{maps}} m ON ei.id_map = m.id_map
                ";

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
			/*if ($whereTXT != "")
				$whereTXT .= " AND ";

			$whereTXT .= " ( st.first_name LIKE :searchText";
			$whereTXT .= " OR st.last_name LIKE :searchText";
			$whereTXT .= " OR st.birth_day LIKE :searchText";
			$whereTXT .= " OR st.avatar_path LIKE :searchText";
			$whereTXT .= " OR st.position LIKE :searchText";
			$whereTXT .= " OR st.description LIKE :searchText";
			$whereTXT .= " OR st.personal_id LIKE :searchText )";

			$whereArray[':searchText'] = "%" . $search . "%";*/

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
			//Yii::log(CVarDumper::dumpAsString($text."\n\r".$whereTXT."\n\r".$id_map, 10),'error','app');

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


				$action = "<a href='".Yii::app()->createUrl("admin/staffWorking/infoWorking", array("id"=>$kl['id_staff'], "id_record"=>$kl['id_staff_working'], 'id_ext' =>$kl['id_extension'], 'dd'=>base64_encode($kl['start_work'])))."'><i class='fa fa-bar-chart'></i></a>";
				$data[] = array( 
					$kl['start_work'],
					$kl['first_name'].' '.$kl['last_name'],
					$kl['position'],
					$kl['caller_id_name'].' ( '.$kl['ext_number'].' ) ',
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
	public function actionInfoWorking($id, $id_record, $id_ext, $dd){

		$arrType = array('acd', 'attendant', 'caller', 'extcall', 'hunt', 'mailbox');
		$criteria = new CDbCriteria;
		$criteria->addNotInCondition('id_staff_working', array($id_record));
		$curDateTime = base64_decode($dd);
		$nextTime = date("Y-m-d H:i:s", strtotime($curDateTime . " +12 hours"));
		//echo $curDateTime.' - '.$nextTime;
		$criteria->addBetweenCondition('start_work',$curDateTime, $nextTime);
		$tmp = StaffWorking::model()->findAllByAttributes(array('id_extension'=>$id_ext), $criteria);
		if (count($tmp) && count($tmp) > 1){
			//echo count($tmp);
		} else {
			$newTmpDate = (isset($tmp[0]['start_work']) && !empty($tmp[0]['start_work'])) ? $tmp[0]['start_work'] : "";
			if(!empty($newTmpDate)) $nextTime = $newTmpDate;
		}
		$extInfo = ExtensionInventory::model()->findByPk($id_ext);
		$cr = new CDbCriteria;
		$cr->addBetweenCondition('timestart',$curDateTime, $nextTime);
		$cr->addSearchCondition('cid_to', $extInfo->ext_number, true, 'AND', 'LIKE');
		$lstOfActivity = CdrCollect::model()->findAll($cr);
		$arr = array();
		if (count($lstOfActivity)) {
			$tmpACD = $tmpAttend = $tmpCaller = $tmpExtCall = $tmpHunt = $tmpMailbox = 0;
			foreach ($lstOfActivity as $k) {
				switch ($k['type']) {
					case "acd":
						$tmpACD++;
						break;
					case "attendant":
						$tmpAttend++;
						break;
					case "caller":
						$tmpCaller++;
						break;
					case "extcall":
						$tmpExtCall++;
						break;
					case "hunt":
						$tmpHunt++;
						break;
					case "mailbox":
						$tmpMailbox++;
						break;
				}
			}

			$arr[] = array('name' => Yii::t('admin/staffworking', 'ACD'), 'data' => array($tmpACD));
			$arr[] = array('name' => Yii::t('admin/staffworking', 'Attendent'), 'data' => array($tmpAttend));
			$arr[] = array('name' => Yii::t('admin/staffworking', 'Called'), 'data' => array($tmpCaller));
			$arr[] = array('name' => Yii::t('admin/staffworking', 'External Call'), 'data' => array($tmpExtCall));
			$arr[] = array('name' => Yii::t('admin/staffworking', 'Hunt'), 'data' => array($tmpHunt));
			$arr[] = array('name' => Yii::t('admin/staffworking', 'Mailbox'), 'data' => array($tmpMailbox));
		}
		Yii::app()->clientScript->registerScript('script', "
    		staffSeries = ".CJSON::encode($arr).";
    		staffWorkingCharts();


		", CClientScript::POS_READY);
		$this->render('staffCharts', array('staff'=>$lstOfActivity));
	}

}