<?php

class GlobalEventPendantTemplateController extends Controller
{
	public $layout = '/layouts/column1';
	public $receiver;
	public $command;

	public function init(){
		parent::init();
		$cs = Yii::app()->clientScript; //
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.cleditor.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.placeholder.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.maskedinput.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.inputlimiter.1.3.1.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-datepicker.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-timepicker.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/daterangepicker.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.hotkeys.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-wysiwyg.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-colorpicker.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-modal.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-dialog.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/globaleventpendant.js', CClientScript::POS_END);
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
		$model=new GlobalEventPendantTemplate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['GlobalEventPendantTemplate']))
		{
			$model->attributes=$_POST['GlobalEventPendantTemplate'];
			$this->receiver = $_POST['GlobalEventPendantTemplate']['receiver'];
			$this->command = $_POST['GlobalEventPendantTemplate']['command'];
			//print_r($this->receiver);
			if($model->save()) {
				if (isset($this->receiver)) {
					if (count($this->receiver)) {
						foreach ($this->receiver as $l => $v) {
							$receiverModel = new Receiver;
							$receiverModel->id_global_event_template = 0;
							$receiverModel->id_global_event_pendant_template = $model->id_global_event_pendant_template;
							$receiverModel->id_global_event_maxivox_template = -1;
							if ($model->pick_event_type == 'SMS') {
								$receiverModel->id_system_sms_number = $v;
							} else if ($model->pick_event_type == 'EMAIL'){
								$receiverModel->id_system_email = $v;
							} else if ($model->pick_event_type == 'VOIP'){
								$receiverModel->id_system_voice_number = $v;
							} else if ($model->pick_event_type == 'TRANSFER'){
								$receiverModel->id_system_voice_number = $v;
							} else if ($model->pick_event_type == 'CAMERA'){
								$receiverModel->id_system_camera = $v;
							} else if ($model->pick_event_type == 'IOPOS'){
								$receiverModel->id_iodevice = $v;
								$receiverModel->id_command = $this->command[$l];
							} else if ($model->pick_event_type == 'HTTP'){
								$receiverModel->id_http_inventory = $v;
							}
							$receiverModel->save();
						}
					}
				}
				Yii::app()->user->setFlash('success',Yii::t('admin/globalmessages','Added Successfuly'));
				$this->redirect(array('index'));
			} else {
				Yii::app()->user->setFlash('error',Yii::t('admin/globalmessages','Added Failury'));
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
		if(isset($_POST['GlobalEventPendantTemplate']))
		{
			$model->attributes=$_POST['GlobalEventPendantTemplate'];

			$this->receiver = $_POST['GlobalEventPendantTemplate']['receiver'];
			$this->command = $_POST['GlobalEventPendantTemplate']['command'];
			if($model->save()) {

				if (isset($this->receiver)) {
					$criteria = new CDbCriteria;
					$criteria->addInCondition('id_global_event_pendant_template',array($model->id_global_event_pendant_template));
					Receiver::model()->deleteAll($criteria);
					if (count($this->receiver)) {
						foreach ($this->receiver as $l =>$v) {
							$receiverModel = new Receiver;
							$receiverModel->id_global_event_pendant_template = $model->id_global_event_pendant_template;
							$receiverModel->id_global_event_template = 0;
							if ($model->pick_event_type == 'SMS') {
								$receiverModel->id_system_sms_number = $v;
							} else if ($model->pick_event_type == 'EMAIL'){
								$receiverModel->id_system_email = $v;
							} else if ($model->pick_event_type == 'VOIP'){
								$receiverModel->id_system_voice_number = $v;
							} else if ($model->pick_event_type == 'TRANSFER'){
								$receiverModel->id_system_voice_number = $v;
							} else if ($model->pick_event_type == 'CAMERA'){
								$receiverModel->id_system_camera = $v;
							} else if ($model->pick_event_type == 'IOPOS'){
								$receiverModel->id_iodevice = $v;
								$receiverModel->id_command = $this->command[$l];
							} else if ($model->pick_event_type == 'HTTP'){
								$receiverModel->id_http_inventory = $v;
							}
							$receiverModel->save();
						}
					}
				}
				/*Yii::app()->user->setFlash('success',Yii::t('admin/globalmessages','Updated Successfuly'));
                $this->redirect(array('index'));
                */
			} else {
				Yii::app()->user->setFlash('error',Yii::t('admin/globalmessages','Updated Failury'));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new GlobalEventPendantTemplate('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GlobalEventPendantTemplate']))
			$model->attributes=$_GET['GlobalEventPendantTemplate'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return GlobalEventTemplate the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=GlobalEventPendantTemplate::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param GlobalEventTemplate $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='global-event-template-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionEventListByPick(){
		if(isset($_POST['pick_event_type']) && !empty($_POST['pick_event_type'])) {
			$str = '';
			$tt = time();
			$str .= "<div id='{$tt}'>";
			$str .= "<label class='control-label'>".Yii::t('admin/globalevent', 'Receiver')."</label>";
			$str .= '<div class="input-group date col-sm-12 receiver-list">
                        <div class="input-group date col-sm-9">
						<span class="input-group-addon">
							<i class="fa  fa-star-half-o"></i>
						</span>
                        <div class="controls">';
			if ($_POST['pick_event_type'] == 'EMAIL') {
				$sysModel = new SystemEmail;
				$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', '', CHtml::listData(SystemEmail::model()->findAll(), 'id_system_email','description_email'), array('class'=>'form-control GlobalEventPendantTemplate_receiver','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
			} else if ($_POST['pick_event_type'] == 'SMS') {
				$sysModel = new SystemSmsNumbers;
				$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', '', CHtml::listData($sysModel->model()->findAll(), 'id_system_sms_number','description_sms'), array('class'=>'form-control GlobalEventPendantTemplate_receiver','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
			} else if ($_POST['pick_event_type'] == 'VOIP') {
				$sysModel = new SystemVoiceNumber;
				$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', '', CHtml::listData($sysModel->model()->findAll(), 'id_system_voice_number', 'descVoice'), array('class'=>'form-control GlobalEventPendantTemplate_receiver','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
			} else if ($_POST['pick_event_type'] == 'TRANSFER') {
				$sysModel = new SystemVoiceNumber;
				$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', '', CHtml::listData($sysModel->model()->findAll(), 'id_system_voice_number','descVoice'), array('class'=>'form-control GlobalEventPendantTemplate_receiver','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
			} else if ($_POST['pick_event_type'] == 'CAMERA') {
				$sysModel = new SystemCameras;
				$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', '', CHtml::listData($sysModel->model()->findAll(), 'id_system_camera','name_camera'), array('class'=>'form-control GlobalEventPendantTemplate_receiver','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
			} else if ($_POST['pick_event_type'] == 'IOPOS') {
				$sysModel = new MipositioningInputDevice;
				$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', '', CHtml::listData($sysModel->model()->findAll(), 'id_input_device','io_name'), array('class'=>'form-control GlobalEventPendantTemplate_receiver','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
			} else if ($_POST['pick_event_type'] == 'HTTP') {
				$sysModel = new HttpInventory;
				$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', '', $sysModel->model()->getHttpAction(), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
			}
			if ($_POST['pick_event_type'] != 'CAMERA')
				$str .= '&nbsp;&nbsp;<a onClick="javascript:addReceiver();" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>';
			if (isset($_POST['emptyDiv']) && !empty($_POST['emptyDiv']))
				$str .= '&nbsp;&nbsp;<a onClick="javascript:delReceiver('.$tt.');" class="btn btn-xs btn-success"><i class="fa fa-trash-o"></i></a>';
			$str .= "</div>";
			$str .= "</div>";
			$str .= "</div><br />";
			if ($_POST['pick_event_type'] == 'IOPOS') {
				$str .= '<br/><div class="controls" data-command-list="command-list">';
				$str .= "<label class='control-label'>".Yii::t('admin/globalevent', 'Command')."</label>";
				$str .= '<div class="input-group date col-sm-12 receiver-list">';
				$str .= '<span class="input-group-addon">
					<i class="fa  fa-star-half-o"></i>
				</span>';
				$modelCommand = new Command;
				$str .= CHtml::dropDownList('GlobalEventPendantTemplate[command][]', '', CHtml::listData($modelCommand->model()->findAll(), 'id_command', 'command'), array('class'=>'form-control GlobalEventPendantTemplate_command','style'=>"width: 250px;", 'prompt' => Yii::t('admin/globalevent','Select Command')));
				$str .= '</div></div><br/>';
			}
			$str .= "</div>";
			echo $str;
		} else echo '';
	}

	public function actionReceiverList(){
		$id_global_event = (isset($_POST['id_global_event']) && !empty($_POST['id_global_event'])) ? (int) $_POST['id_global_event'] : -1;
		$pick_event_type = (isset($_POST['pick_event_type']) && !empty($_POST['pick_event_type'])) ? $_POST['pick_event_type'] : "";

		if($id_global_event > 0 && $pick_event_type != '') {
			$data=Receiver::model()->findAll('id_global_event_pendant_template=:id_global_event_pendant_template',
				array(':id_global_event_pendant_template'=>(int) $id_global_event));

			$str = '';
			$cc = 0;
			foreach ($data as $k) {
				$tt = time();
				$str .= "<div id='{$tt}'>";
				$str .= "<label class='control-label'>".Yii::t('admin/globalevent', 'Receiver')."</label>";
				$str .= '<div class="input-group date col-sm-12 receiver-list">
							<div class="input-group date col-sm-9">
							<span class="input-group-addon">
								<i class="fa  fa-star-half-o"></i>
							</span>
                            <div class="controls">';
				if ($pick_event_type == 'EMAIL') {
					$sysModel = new SystemEmail;
					$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', $k->id_system_email, CHtml::listData($sysModel->findAll(), 'id_system_email','description_email'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
				} else if ($pick_event_type == 'SMS') {
					$sysModel = new SystemSmsNumbers;
					$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', $k->id_system_sms_number, CHtml::listData($sysModel->model()->findAll(), 'id_system_sms_number','description_sms'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
				} else if ($pick_event_type == 'VOIP') {
					$sysModel = new SystemVoiceNumber;

					$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', $k->id_system_voice_number, CHtml::listData($sysModel->model()->findAll(), 'id_system_voice_number', 'descVoice'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
				} else if ($pick_event_type == 'TRANSFER') {
					$sysModel = new SystemVoiceNumber;
					$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', $k->id_system_voice_number, CHtml::listData($sysModel->model()->findAll(), 'id_system_voice_number', 'descVoice'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
				} else if ($pick_event_type == 'CAMERA') {
					$sysModel = new SystemCameras;
					$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', $k->id_system_camera, CHtml::listData($sysModel->model()->findAll(), 'id_system_camera', 'name_camera'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
				} else if ($pick_event_type == 'IOPOS') {
					$sysModel = new MipositioningInputDevice;
					$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', $k->id_iodevice, CHtml::listData($sysModel->model()->findAll(), 'id_input_device','io_name'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
				} else if ($_POST['pick_event_type'] == 'HTTP') {
					$sysModel = new HttpInventory;
					$str .= CHtml::dropDownList('GlobalEventPendantTemplate[receiver][]', $k->id_http_inventory, $sysModel->model()->getHttpAction(), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
				}
				if ($pick_event_type != 'CAMERA')
					$str .= '&nbsp;&nbsp;<a onClick="javascript:addReceiver();" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>';
				if ($cc > 0)
					$str .= '&nbsp;&nbsp;<a onClick="javascript:delReceiver('.$tt.');" class="btn btn-xs btn-success"><i class="fa fa-trash-o"></i></a>';
				$str .= "</div>";
				$str .= "</div>";
				$str .= "</div><br />";
				if ($pick_event_type == 'IOPOS') {
					$str .= '<br/><div class="controls" data-command-list="command-list">';
					$str .= "<label class='control-label'>".Yii::t('admin/globalevent', 'Command')."</label>";
					$str .= '<div class="input-group date col-sm-12">';
					$str .= '<span class="input-group-addon">
							<i class="fa  fa-star-half-o"></i>
						</span>';
					$modelCommand = new Command;
					$str .= CHtml::dropDownList('GlobalEventPendantTemplate[command][]', $k->id_command, CHtml::listData($modelCommand->model()->findAll(), 'id_command', 'command'), array('class'=>'form-control','style'=>"width: 250px;", 'prompt' => Yii::t('admin/globalevent','Select Command')));
					$str .= '</div></div><br/>';
				}
				$str .= "</div>";
				$cc++;
			}
			echo $str;
		} else echo '';
	}

	public function actionCommandList() {
		$str = '<br/><div class="controls commandList" data-command-list="command-list">';
		$str .= "<label class='control-label'>".Yii::t('admin/globalevent', 'Command')."</label>";
		$str .= '<div class="input-group date col-sm-12 receiver-list">';
		$str .= '<span class="input-group-addon">
					<i class="fa  fa-star-half-o"></i>
				</span>';
			$modelCommand = new Command;
			$str .= CHtml::dropDownList('GlobalEventPendantTemplate[command][]', '', CHtml::listData($modelCommand->model()->findAll(), 'id_command', 'command'), array('class'=>'form-control GlobalEventPendantTemplate_command','style'=>"width: 250px;", 'prompt' => Yii::t('admin/globalevent','Select Command')));
		$str .= '</div></div>';
		echo $str;
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