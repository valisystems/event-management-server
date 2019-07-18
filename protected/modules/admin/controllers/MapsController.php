<?php

class MapsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/column1';

    public function init(){
        //Yii::import("ext.EUpdateDialog.EUpdateDialog");
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
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/tooltip.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/popover.js', CClientScript::POS_END);
        $cs->registerScript(
            "popOver",
            ' $(document).ready($(function () { 
                    $("[data-toggle=\'popover\']").popover({"html":true, "trigger":"hover"});
                    $(".popover").css("max-width", "750px"); 
            }));',
        CClientScript::POS_READY
        );
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
				'roles'=>array('moderator','administrator'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('administrator'),
			),
			array('deny',  // deny all users
				'roles'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Maps;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Maps']))
		{
			$model->attributes=$_POST['Maps'];
			
            $logo_path = "";
            if (!empty($model->path_to_img) && substr_count($model->path_to_img, '/maps/') == 0) {
                $nameFile = $model->path_to_img;
                $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
                $siteFolder=Yii::getPathOfAlias('webroot').'/upload/maps/';  
                if(rename($tempFolder.$nameFile, $siteFolder.$nameFile))
                {
                    $logo_path = "/upload/maps/".$nameFile;
                    $model->path_to_img = $logo_path;
                }
            }
            
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

		if(isset($_POST['Maps']))
		{
			$model->attributes=$_POST['Maps'];
			$logo_path = "";
            if (!empty($model->path_to_img) && substr_count($model->path_to_img, '/maps/') == 0) {
                $nameFile = $model->path_to_img;
                //$nameFileNew = mb_ereg_replace(" ", "", $nameFile);
                $nameFileNew = preg_replace('/ /', '', $nameFile);
                $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
                $siteFolder=Yii::getPathOfAlias('webroot').'/upload/maps/';  
                if(rename($tempFolder.$nameFile, $siteFolder.$nameFileNew))
                {
                    $logo_path = "/upload/maps/".$nameFileNew;
                    $model->path_to_img = $logo_path;
                }
            }
            if($model->save())
				$this->redirect(array('index'));
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
		$model=new Maps('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Maps']))
			$model->attributes=$_GET['Maps'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Maps the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Maps::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Maps $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='maps-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
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
}