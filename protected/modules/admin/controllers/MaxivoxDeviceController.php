<?php

class MaxivoxDeviceController extends Controller
{
	public $layout = '/layouts/column1';
	public function init(){
		parent::init();
		$cs = Yii::app()->clientScript; //
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.canvasAreaDraw.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-modal.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-dialog.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/maxidevices.js', CClientScript::POS_END);
		//$assetFolder = Yii::app()->assetManager->publish(  Yii::app()->request->baseUrl. '' );
		Yii::app()->clientScript->scriptMap = array(
			'jquery-ui-1.10.3.custom.min.css' => false
		);
		Yii::app()->clientScript->registerCssFile( Yii::app()->request->baseUrl . '/assets/css/modules/admin/pages/devices.css' );

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
				'actions'=>array('index','view','create','update'),
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
		$model = new MaxivoxDevice('search');
		$model->unsetAttributes();  // clear any default values

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionCreate()
	{
		$model = new MaxivoxDevice;
		if (isset($_POST['ajax']) && $_POST['ajax']=='maxivox-devices-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['MaxivoxDevice'])) {
			$model->attributes=$_POST['MaxivoxDevice'];
			if($model->save()) {
				Yii::app()->user->setFlash('success',Yii::t('admin/maxivox','Added Successfuly'));
				$this->redirect(array('index'));

			} else {
				Yii::app()->user->setFlash('error',Yii::t('admin/maxivox','Added Failury'));
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

		//$model = new MaxivoxDevice;
		if (isset($_POST['ajax']) && $_POST['ajax']=='maxivox-devices-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['MaxivoxDevice']))
		{
			$model->attributes=$_POST['MaxivoxDevice'];
			if($model->save()) {
				Yii::app()->user->setFlash('success',Yii::t('admin/maxivox','Updated Successfuly'));
				$this->redirect(array('index'));

			} else {
				Yii::app()->user->setFlash('error',Yii::t('admin/maxivox','Updated Failure'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Get All Floor of the selected building
	 *
	 * @return array of the floors for populate dropdown
	 */
	public function actionFloorList(){
		$data=Maps::model()->findAll('id_building=:id_building',
			array(':id_building'=>(int) $_POST['id_building']));

		$data=CHtml::listData($data,'id_map','name_map');
		echo CHtml::tag('option',array('value' => ''),
			CHtml::encode(Yii::t('admin/maxivox', 'Select Floor')),true);
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
				array('value'=>$value),CHtml::encode($name),true);
		}
	}


	/**
	 * Get All Room of the selected floor
	 *
	 * @return array of the floors for populate dropdown
	 */
	public function actionRoomList(){
		$data=Rooms::model()->findAll('id_map=:id_map',
			array(':id_map'=>(int) $_POST['id_map']));

		$data=CHtml::listData($data,'id_room','nb_room');
		echo CHtml::tag('option',array('value' => ''),
			CHtml::encode(Yii::t('admin/maxivox', 'Select Room')),true);
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
				array('value'=>$value),CHtml::encode($name),true);
		}
	}


	public function actionFloorInfo($id){
		if (!empty($id)){
			$data=Maps::model()->find('id_map=:id_map',
				array(':id_map'=>(int) $id));

			if (!empty($data->path_to_img)) {
				$str = '';
				$script = '<script>
                    $( "#devicePosition" ).draggable(
                        {
                            containment: "#roomConstruction",
                            scroll: false,
                            stop: function() {
                                var pPlan = $("#roomConstruction").position();

                                var p = $( "#devicePosition" );
                                var position = p.position();
                                $("#coordinate_on_map").val((parseInt(position.left) - parseInt(pPlan.left))+";"+(parseInt(position.top) - parseInt(pPlan.top)));

                            }
                        }
                    );
                    //$( "#roomPosition" ).offset({top:10, left: 10});
                </script>
                ';

				//Yii::app()->clientScript->registerScript("dragScript",$script);
				list($width, $height, $type, $attr) = getimagesize(substr($data->path_to_img, 1));
				$str .= '<div id="roomConstruction" style="clear:both;width:auto !important;">';
				$str .= '<input id="coordinate_on_map" name="MaxivoxDevice[coordonate_on_map]" type="hidden"/>';
				$str .= '<input id="coordinate_convas" name="coordinate_convas" type="hidden"/>';
				$str .= "<img src='".$data->path_to_img."' border=0 usemap='#roomPositionsMap' id='roomPositionsImg'/>";
				$str .= "<div id='devicePosition' class='btn btn-sm btn-success draggable ui-widget-content' style='width: auto !important;'>&nbsp;&nbsp;</div>";
				$str .= '</div>';
				echo $str.$script;
			}

		} else echo "";
	}



	public function actionRoomCoordonate($id){
		if (!empty($id)){
			$data = Rooms::model()->findByPk($id);
			$str = '<input type="hidden" name="coordinate_on_map" id="coordinate_on_map" class="canvas-area" data-image-url="'.$data->idMap->path_to_img.'" value="'.$data->coordinate_on_map.'"/>';
			$arr = array('pathImage'=>$data->idMap->path_to_img, 'coordinate'=>$data->coordinate_on_map);
			header('Content-Type: application/json');
			echo json_encode($arr);

			//echo $str;
		}
	}
	public function actionVerifySerialNumber(){
		$serial_number = (isset($_POST['SerialNumber']) && !empty($_POST['SerialNumber'])) ? $_POST['SerialNumber'] : "";
		if (!empty($serial_number)){
			$model = MaxivoxDevice::model()->find('dev_address=:serial_number', array(':serial_number'=>$serial_number));
			if(count($model)){
				echo "exist";
			} else {
				echo "no";
			}
		}
	}

	public function actionAddPatient($id){
		//$model2 = new ResidentsOfRooms;
		//$model = $model2->model()->findByPk($id);

		$model=$this->loadModel($id);
		$status = 'nothing';
		if(isset($_POST['id_patient']) && !empty($_POST['id_patient']) && isset($_POST['id_room']) && !empty($_POST['id_room']))
		{
			$id_patient = $_POST['id_patient'];
			$id_room = $_POST['id_room'];
			$id_device = $id;

			if ($model->comon_area == 1) {
				$model->id_patient = null;
			} else {
				$model->id_patient = $id_patient;
			}

			if ($model->save()) {
				$status = 'success_add';
			} else {
				$status = 'fail_add';
			}
		}

		echo $this->renderPartial('_addPatient_form', array('model'=>$model, 'status' => $status),true);
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
		$model=MaxivoxDevice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}