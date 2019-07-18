<?php

class HttpInventoryController extends Controller
{
	public $layout = '/layouts/column1';


	public function init(){
		parent::init();
		Yii::import('application.models.*');
		$cs = Yii::app()->clientScript; //
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-tab.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.dataTables.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/dataTables.bootstrap.js', CClientScript::POS_END);

		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-tab.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.dataTables.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/dataTables.bootstrap.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-toggle.min.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/assets/css/bootstrap-toggle.min.css");
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/httpInventory.js', CClientScript::POS_END);
		$cs->registerCss('http', '
		.modal-body {
			max-height: calc(100vh - 210px);
			overflow-y: auto;
		}
		');

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
		$model = HttpInventory::model()->findAll();
		$this->render('index', array('model'=>$model));
	}

	public function actionCreate(){
		$model = new HttpInventory;
		if(isset($_POST['HttpInventory']))
		{
			$model->attributes=$_POST['HttpInventory'];
			if($model->save()) {
				Yii::app()->user->setFlash('success',Yii::t('admin/command','Added Successfuly'));
				$this->redirect(array('index'));

			} else {
				Yii::app()->user->setFlash('error',Yii::t('admin/command','Added Failure'));
			}
		}
		$this->render('create', array('model'=>$model));
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

		if(isset($_POST['HttpInventory']))
		{
			$model->attributes=$_POST['HttpInventory'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('_form_edit',array(
			'model'=>$model,
		));
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
		$model=HttpInventory::model()->findByPk($id);
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
}