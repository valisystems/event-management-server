<?php

class CustomLinksController extends Controller
{
	public $layout='/layouts/column1';

	public function init(){
		parent::init();
		$cs = Yii::app()->clientScript; //
		//$cs->registerCssFile(Yii::app()->request->baseUrl . '/assets/css/jquery.dataTables.css');
		$cs->registerCssFile(Yii::app()->request->baseUrl . '/assets/css/dataTables.bootstrap.css');
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.dataTables.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/dataTables.bootstrap.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-editable.min.js', CClientScript::POS_END);
		$cs->registerCssFile(Yii::app()->request->baseUrl."/assets/css/bootstrap-editable.css");
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/customlinks.js', CClientScript::POS_END);

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

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionCreate()
	{
		$model=new CustomLinks('create');

		// uncomment the following code to enable ajax-based validation
		/*
        if(isset($_POST['ajax']) && $_POST['ajax']==='custom-links-create-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        */

		if(isset($_POST['CustomLinks']))
		{
			$model->attributes=$_POST['CustomLinks'];
			if($model->validate())
			{
				if($model->save()) {
					Yii::app()->user->setFlash('success',Yii::t('admin/command','Added Successfuly'));
					$this->redirect(array('index'));

				} else {
					Yii::app()->user->setFlash('error',Yii::t('admin/command','Added Failure'));
				}
				Yii::app()->end();
			}
		}
		$this->render('create',array('model'=>$model));
		Yii::app()->end();
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

		if(isset($_POST['CustomLinks']))
		{
			$model->attributes=$_POST['CustomLinks'];
			if($model->validate()) {
				if($model->save()) {
					Yii::app()->user->setFlash('success',Yii::t('admin/command','Updated Successfuly'));
					$this->redirect(array('index'));

				} else {
					Yii::app()->user->setFlash('error',Yii::t('admin/command','Updated Failure'));
				}
				Yii::app()->end();
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionInformations()
	{
		$start = (isset($_POST['start']) && !empty($_POST['start'])) ? trim($_POST['start']) : 0;
		$length = (isset($_POST['length']) && !empty($_POST['length'])) ? trim($_POST['length']) : 25;
		$search = (isset($_POST['search']['value']) && !empty($_POST['search']['value'])) ? trim($_POST['search']['value']) : "";
		$draw = (isset($_POST['draw']) && !empty($_POST['draw'])) ? trim($_POST['draw']) : 0;
		$order = (isset($_POST['order'])) ? $_POST['order'][0] : array('column' => 0, 'dir' => 'desc');
		$column = array('desc_custom_links','url_custom_links', 'target_type', 'location_links');


		$sql = "SELECT SQL_CALC_FOUND_ROWS (0), cl.* FROM {{custom_links}} cl";

		$whereTXT = "";
		$whereArray = NULL;

		if (!empty($search)) {
			if ($whereTXT != "")
				$whereTXT .= " AND ";

			$whereTXT .= " ( desc_custom_links LIKE :searchText";
			$whereTXT .= " OR url_custom_links LIKE :searchText";
			$whereTXT .= " OR target_type LIKE :searchText";
			$whereTXT .= " OR location_links LIKE :searchText )";

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
				$action = "&nbsp;&nbsp;<a href='".Yii::app()->createUrl("admin/customLinks/update", array("id"=>$kl['id_custom_links']))."'><i class='fa fa-pencil'></i></a>";
				$action .= "&nbsp;&nbsp;<a href='".Yii::app()->createUrl("admin/customLinks/delete", array("id"=>$kl['id_custom_links']))."' onClick='javascript:return confirm(\"".Yii::t('admin/customLinks', 'Are you sure you want to delete this item?')."\")'><i class='fa fa-trash-o'></i></a>";

				$data[] = array(
					$kl['desc_custom_links'],
					"<a href='".$kl['url_custom_links']."' target='_blank'>".$kl['url_custom_links']."</a>",
					Yii::app()->params['link_target'][$kl['target_type']],
					//"<a href='#' class='custom_edit' data-type='select' source='getCustomLocation()' data-name='location_links' data-pk='".$kl['id_custom_links']."' data-url='/admin/customLinks/changeCustomLinks' data-title='Custom Links'>".Yii::app()->params['location_links'][$kl['location_links']]."</a>",
					Yii::app()->params['location_links'][$kl['location_links']],
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

	function actionCustomLocation(){
		$locationLinks = Yii::app()->params['location_links'];
		$locationArray = array();
		foreach ($locationLinks as $ll => $lm) {
			$locationArray[] = array('value'=>$ll, 'text' => $lm);
		}

		echo CJSON::encode($locationArray);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CallsType the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CustomLinks::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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
}