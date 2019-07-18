<?php

class BuildingsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '/layouts/column1';
    
    public function init(){
        parent::init();
        Yii::import("ext.EUpdateDialog.EUpdateDialog");
        Yii::import("ext.EFineUploader.EFineUploader");
        
        $cs = Yii::app()->clientScript; //
        //$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.placeholder.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/buildings.js', CClientScript::POS_END);
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
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),*/
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
		$model=new Buildings;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Buildings']))
		{
			$model->attributes=$_POST['Buildings'];
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

		if(isset($_POST['Buildings']))
		{
			$model->attributes=$_POST['Buildings'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via index grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new Buildings('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Buildings']))
			$model->attributes=$_GET['Buildings'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
    
    public function actionViewflors($id){
        $criteria = new CDbCriteria();
        $criteria->condition = 'id_building = :id_building';
        $criteria->params = array('id_building'=>(int)$id);
        $model = new CActiveDataProvider(Maps::model(),
            array(
                'criteria'=>$criteria,
            )
        );
         echo $this->renderPartial('_viewfloors', array('model'=>$model),true, false);
    }
    
    public function actionAddFloor(){
        $modelFloor= new Maps;
        if(isset($_POST['Maps']))
		{
			$modelFloor->attributes=$_POST['Maps'];
			
            $logo_path = "";
            if (!empty($modelFloor->path_to_img) && substr_count($modelFloor->path_to_img, '/maps/') == 0) {
                $nameFile = $modelFloor->path_to_img;
                $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
                $siteFolder=Yii::getPathOfAlias('webroot').'/upload/maps/';  
                if(rename($tempFolder.$nameFile, $siteFolder.$nameFile))
                {
                    $logo_path = "/upload/maps/".$nameFile;
                    $modelFloor->path_to_img = $logo_path;
                }
            }
            
            if($modelFloor->save()) {
                $arr = array('status'=>'success', 'id_building'=> $modelFloor->id_building);
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
            Yii::app()->clientscript->scriptMap['buildings.js'] = false;
            echo $this->renderPartial('_form_add_floor', array('modelFloor'=>$modelFloor),false, true);
        }
    }
    
    
    public function actionUpdateFloor($id){
        $modelFloor=Maps::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Maps']))
		{
			$modelFloor->attributes=$_POST['Maps'];
			$logo_path = "";
            if (!empty($modelFloor->path_to_img) && substr_count($modelFloor->path_to_img, '/maps/') == 0) {
                $nameFile = $modelFloor->path_to_img;
                //$nameFileNew = mb_ereg_replace(" ", "", $nameFile);
                $nameFileNew = preg_replace('/ /', '', $nameFile);
                $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
                $siteFolder=Yii::getPathOfAlias('webroot').'/upload/maps/';  
                if(rename($tempFolder.$nameFile, $siteFolder.$nameFileNew))
                {
                    $logo_path = "/upload/maps/".$nameFileNew;
                    $modelFloor->path_to_img = $logo_path;
                }
            }
            if($modelFloor->save()) {
                $arr = array('status'=>'success', 'id_building'=>$modelFloor->id_building);
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
            Yii::app()->clientscript->scriptMap['buildings.js'] = false;
            $html = $this->renderPartial('_updateFloor', array('modelFloor'=>$modelFloor),false, true);
            echo $html;
		}

		/*$this->render('update',array(
			'model'=>$model,
		));*/
    }
    
    public function actionDeleteFloor($id) {
        $modelFloor=Maps::model()->findByPk($id);
        if ($modelFloor->delete()) {
            $arr = array('status'=>'success');
        } else {
            $arr = array('status'=>'fail');
        }
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
    
    /**
     * Save the image to local server
     * 
     * @return Content of image
     */
    
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
     
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Buildings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Buildings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Buildings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='buildings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
