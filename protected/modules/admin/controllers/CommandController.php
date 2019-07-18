<?php

class CommandController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '/layouts/column1';

	/**
	 *
	 */
	public function init()
	{
		parent::init();
		$cs = Yii::app()->clientScript; //d3.min.js
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-editable.min.js', CClientScript::POS_END);
		$cs->registerCssFile(Yii::app()->request->baseUrl."/assets/css/bootstrap-editable.css");
		$cs->registerScriptFile(Yii::app()->request->baseUrl . '/assets/js/pages/command.js', CClientScript::POS_END);

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
		$model = new Command('search');
		$this->render('index', array('model' => $model));
	}


	public function actionCreate()
	{
		$model=new Command;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Command']))
		{
			$model->attributes=$_POST['Command'];
			if($model->save()) {
				Yii::app()->user->setFlash('success',Yii::t('admin/command','Added Successfuly'));
				$this->redirect(array('index'));

			} else {
				Yii::app()->user->setFlash('error',Yii::t('admin/command','Added Failure'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionChangeCommand(){
		if (Yii::app()->request->isAjaxRequest) {
			$name = (isset($_POST['name']) && !empty($_POST['name'])) ? trim($_POST['name']): "";
			$value = (isset($_POST['value']) && !empty($_POST['value'])) ? trim($_POST['value']): "";
			$id = (isset($_POST['pk']) && !empty($_POST['pk'])) ? trim($_POST['pk']): "";
			if ($id != "" && $name != "") {
				$modelCommand = Command::model()->findByPk($id);
				if ($name == 'com_name')
					$modelCommand->com_name = $value;
				if ($name == 'command')
					$modelCommand->command = $value;
				$modelCommand->save();
			}
		}
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