<?php

class UsersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
    public $layout = '/layouts/column1';
    public $oldPassword;
    
    public function init(){
		parent::init();
		$cs = Yii::app()->clientScript; //
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/form-elements.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.cleditor.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.placeholder.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.maskedinput.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.inputlimiter.1.3.1.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-timepicker.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/daterangepicker.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.hotkeys.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-wysiwyg.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-colorpicker.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-toggle.min.js', CClientScript::POS_END);
        //$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
        //$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/users.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScript('LoadImage',"
            var logoFile = $('#Setting_logo_path').val();
            $('#imgLogo').html(\"<img class='img-responsive img-thumbnail' src='\"+logoFile+\"'>\");
        ",CClientScript::POS_READY);

        
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
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
            $model->passwd = MD5($model->passwd);
			if($model->save()){
                Yii::app()->user->setFlash('success',Yii::t('admin/users','Added Successfuly'));
                $this->redirect(array('index'));
            } else {
                Yii::app()->user->setFlash('error',Yii::t('admin/users','Added Failury'));
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
        $oldPassword = $model->passwd;
		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
            if (!empty($model->passwd))
                $model->passwd = MD5($model->passwd);
            else
                $model->passwd = $oldPassword;
			if($model->save()){
                Yii::app()->user->setFlash('success',Yii::t('admin/users','Updated Successfuly'));
                $this->redirect(array('index'));
            } else {
                Yii::app()->user->setFlash('error',Yii::t('admin/users','Updated Failury'));
            }
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionManageAccessRules($id){
		$model=$this->loadModel($id);
		echo $this->renderPartial('_access_rules', array('model'=>$model),true, false);
	}

	public function actionUpdateAccessRules($id){
		$model=$this->loadModel($id);
		$statusUpdate = array();
		if (isset($_POST['access_rules'])) {
			$access_rules = (isset($_POST['access_rules']) && !empty($_POST['access_rules'])) ? serialize($_POST['access_rules']) : array();
			if (count($access_rules)) {
				$model->access_rules = $access_rules;

				if ($model->save()) {
					$statusUpdate = array('status' => 'y', 'msg' => Yii::t('admin/users', 'Rules updated successfully'));
				} else {
					$statusUpdate = array('status' => 'n', 'msg' => Yii::t('admin/users', 'Rules updated failed'));
				}
			} else {
				$statusUpdate = array('status' => 'n', 'msg' => Yii::t('admin/users', 'Not selected rules'));
			}
		} else $statusUpdate = array('status' => 'n', 'msg' => Yii::t('admin/users', 'Not selected rules'));
		header('Content-Type: application/json');
		echo json_encode($statusUpdate);
	}

	public function actionManageBuildingsRules($id){
		$model=$this->loadModel($id);
		echo $this->renderPartial('_buildings_rules', array('model'=>$model),true, false);
	}

	public function actionUpdateBuildingsRules($id){
		$model=$this->loadModel($id);
		$statusUpdate = array();
		if (isset($_POST['buildings_rules'])) {
			$buildings_rules = (isset($_POST['buildings_rules']) && !empty($_POST['buildings_rules'])) ? serialize($_POST['buildings_rules']) : array();
			if (count($buildings_rules)) {
				$model->buildings_rules = $buildings_rules;

				if ($model->save()) {
					$statusUpdate = array('status' => 'y', 'msg' => Yii::t('admin/users', 'Rules updated successfully'));
				} else {
					$statusUpdate = array('status' => 'n', 'msg' => Yii::t('admin/users', 'Rules updated failed'));
				}
			} else {
				$statusUpdate = array('status' => 'n', 'msg' => Yii::t('admin/users', 'Not selected rules'));
			}
		} else $statusUpdate = array('status' => 'n', 'msg' => Yii::t('admin/users', 'Not selected rules'));
		header('Content-Type: application/json');
		echo json_encode($statusUpdate);
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
