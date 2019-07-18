<?php

class VodiaManageController extends Controller
{
	public $layout = '/layouts/column1';

	public function init(){
		parent::init();
		$cs = Yii::app()->clientScript; //
		//$cs->registerCssFile(Yii::app()->request->baseUrl . '/assets/css/dataTables.bootstrap.css');
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-tab.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.dataTables.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/dataTables.bootstrap.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/vodiaSettings.js', CClientScript::POS_END);
	}

	public function actionIndex()
	{
		$model = Asterisk::model()->findAll(array('condition' =>"user <> '' AND passwd <> ''"));
		$this->render('index', array(
			'model'=>$model,
		));
	}


	public function actionManage($id_asterisk){
		//Yii::import('application.components.VodiaRest');
		$asterServer = Asterisk::model()->findByPk($id_asterisk);
		$vodia = Yii::app()->vodia;
		//$vodia->setDestUrl('testare');
		$this->render('manageServer', array(
			'model'=>$asterServer,
		));
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