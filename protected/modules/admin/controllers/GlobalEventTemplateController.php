<?php

class GlobalEventTemplateController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
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
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/globalevent.js', CClientScript::POS_END);
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
		$model=new GlobalEventTemplate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['GlobalEventTemplate']))
		{
			$model->attributes=$_POST['GlobalEventTemplate'];
            $this->receiver = $_POST['GlobalEventTemplate']['receiver'];
            $this->command = (isset($_POST['GlobalEventTemplate']['command']) && !empty($_POST['GlobalEventTemplate']['command'])) ? $_POST['GlobalEventTemplate']['command'] : array();
            //print_r($this->receiver);
			if($model->save()) {
				if (isset($this->receiver)) {
				    if (count($this->receiver)) {
                        foreach ($this->receiver as $l=>$v) {
                            $receiverModel = new Receiver;
                            $receiverModel->id_global_event_pendant_template = -1;
                            $receiverModel->id_global_event_maxivox_template = -1;
                            $receiverModel->id_global_event_template = $model->id_global_event_template;
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
                                $receiverModel->id_command = (isset($this->command[$l]) && !empty($this->command[$l])) ? $this->command[$l] : 0;
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
		if(isset($_POST['GlobalEventTemplate']))
		{
            $model->attributes=$_POST['GlobalEventTemplate'];
            $this->receiver = $_POST['GlobalEventTemplate']['receiver'];
            $this->command = (isset($_POST['GlobalEventTemplate']['command']) && !empty($_POST['GlobalEventTemplate']['command'])) ? $_POST['GlobalEventTemplate']['command'] : array();
			if($model->save()) {
				
                if (isset($this->receiver)) {
                    $criteria = new CDbCriteria;
                    $criteria->addInCondition('id_global_event_template',array($model->id_global_event_template));
                    Receiver::model()->deleteAll($criteria);
                    if (count($this->receiver)) {
                        foreach ($this->receiver as $l=>$v) {
                            $receiverModel = new Receiver;
                            $receiverModel->id_global_event_template = $model->id_global_event_template;
                            $receiverModel->id_global_event_pendant_template = -1;
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
                                $receiverModel->id_command = (isset($this->command[$l]) && !empty($this->command[$l])) ? $this->command[$l] : 0;
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
		$model=new GlobalEventTemplate('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GlobalEventTemplate']))
			$model->attributes=$_GET['GlobalEventTemplate'];

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
		$model=GlobalEventTemplate::model()->findByPk($id);
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
                         <div class="input-group date col-sm-11">
                            <span class="input-group-addon">
                                <i class="fa  fa-close"></i>
                            </span>
                        <div class="controls">';
            if ($_POST['pick_event_type'] == 'EMAIL') {
                $sysModel = new SystemEmail; 
                $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', '', CHtml::listData(SystemEmail::model()->findAll(), 'id_system_email','description_email'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen"));
            } else if ($_POST['pick_event_type'] == 'SMS') {
                $sysModel = new SystemSmsNumbers; 
                $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', '', CHtml::listData($sysModel->model()->findAll(), 'id_system_sms_number','description_sms'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen"));
            } else if ($_POST['pick_event_type'] == 'VOIP') {
                $sysModel = new SystemVoiceNumber;
                $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', '', CHtml::listData($sysModel->model()->findAll(), 'id_system_voice_number', 'descVoice'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen"));
            } else if ($_POST['pick_event_type'] == 'TRANSFER') {
                $sysModel = new SystemVoiceNumber;
                $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', '', CHtml::listData($sysModel->model()->findAll(), 'id_system_voice_number','descVoice'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen"));
            } else if ($_POST['pick_event_type'] == 'CAMERA') {
                $sysModel = new SystemCameras;
                $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', '', CHtml::listData($sysModel->model()->findAll(), 'id_system_camera','name_camera'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen"));
            } else if ($_POST['pick_event_type'] == 'IOPOS') {
                $sysModel = new MipositioningInputDevice;
                $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', '', CHtml::listData($sysModel->model()->findAll(), 'id_input_device','io_name'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
            }
            else if ($_POST['pick_event_type'] == 'HTTP') {
                $sysModel = new HttpInventory;
                $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', '', $sysModel->model()->getHttpAction(), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
            }
            if ($_POST['pick_event_type'] != 'CAMERA')
                $str .= '&nbsp;&nbsp;<a onClick="javascript:addReceiver();" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>';
            if (isset($_POST['emptyDiv']) && !empty($_POST['emptyDiv']))
                $str .= '&nbsp;&nbsp;<a onClick="javascript:delReceiver('.$tt.');" class="btn btn-xs btn-success"><i class="fa fa-trash-o"></i></a>';
            $str .= "</div>";
            $str .= "</div>";
            $str .= "</div><br />";
            if ($_POST['pick_event_type'] == 'IOPOS') {
                $str .= '<div class="controls commandList">';
                $str .= "<label class='control-label'>".Yii::t('admin/globalevent', 'Command')."</label>";
                $str .= '<div class="input-group date col-sm-12">';
                $str .= '<span class="input-group-addon">
							<i class="fa  fa-star-half-o"></i>
						</span>';
                $modelCommand = new Command;
                $str .= CHtml::dropDownList('GlobalEventTemplate[command][]', '', CHtml::listData($modelCommand->model()->findAll(), 'id_command', 'command'), array('class'=>'form-control GlobalEventTemplate_command','style'=>"width: 250px;", 'prompt' => Yii::t('admin/globalevent','Select Command')));
                $str .= '</div></div><br />';
            }
            $str .= "</div>"; 
            echo $str;
        } else echo '';
    }
    
    public function actionReceiverList(){
        $id_global_event = (isset($_POST['id_global_event']) && !empty($_POST['id_global_event'])) ? (int) $_POST['id_global_event'] : -1;
        $pick_event_type = (isset($_POST['pick_event_type']) && !empty($_POST['pick_event_type'])) ? $_POST['pick_event_type'] : "";
        
        if($id_global_event > 0 && $pick_event_type != '') {
            $data=Receiver::model()->findAll('id_global_event_template=:id_global_event_template', 
                  array(':id_global_event_template'=>(int) $id_global_event));
            
            $str = '';
            $cc = 0;
            foreach ($data as $k) {
                $tt = time(); 
                $str .= "<div id='{$tt}'>";
                $str .= "<label class='control-label'>".Yii::t('admin/globalevent', 'Receiver')."</label>";
                $str .= '<div class="input-group date col-sm-12 receiver-list">
                            <div class="input-group date col-sm-11">
                            <span class="input-group-addon">
                                <i class="fa  fa-close"></i>
                            </span>
                            <div class="controls">';
                if ($pick_event_type == 'EMAIL') {
                    $sysModel = new SystemEmail; 
                    $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', $k->id_system_email, CHtml::listData($sysModel->findAll(), 'id_system_email','description_email'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen"));
                } else if ($pick_event_type == 'SMS') {
                    $sysModel = new SystemSmsNumbers; 
                    $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', $k->id_system_sms_number, CHtml::listData($sysModel->model()->findAll(), 'id_system_sms_number','description_sms'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen"));
                } else if ($pick_event_type == 'VOIP') {
                    $sysModel = new SystemVoiceNumber;

                    $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', $k->id_system_voice_number, CHtml::listData($sysModel->model()->findAll(), 'id_system_voice_number', 'descVoice'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen"));
                } else if ($pick_event_type == 'TRANSFER') {
                    $sysModel = new SystemVoiceNumber;
                    $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', $k->id_system_voice_number, CHtml::listData($sysModel->model()->findAll(), 'id_system_voice_number', 'descVoice'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen"));
                } else if ($pick_event_type == 'CAMERA') {
                    $sysModel = new SystemCameras;
                    $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', $k->id_system_camera, CHtml::listData($sysModel->model()->findAll(), 'id_system_camera', 'name_camera'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen"));
                } else if ($pick_event_type == 'IOPOS') {
                    $sysModel = new MipositioningInputDevice;
                    $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', $k->id_iodevice, CHtml::listData($sysModel->model()->findAll(), 'id_input_device','io_name'), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));

                }
                else if ($_POST['pick_event_type'] == 'HTTP') {
                    $sysModel = new HttpInventory;
                    $str .= CHtml::dropDownList('GlobalEventTemplate[receiver][]', $k->id_http_inventory, $sysModel->model()->getHttpAction(), array('class'=>'form-control','style'=>"width: 250px;",'data-rel'=>"chosen", 'prompt' => Yii::t('admin/globalevent','Select Receiver')));
                }
                if ($pick_event_type != 'CAMERA')
                    $str .= '&nbsp;&nbsp;<a onClick="javascript:addReceiver();" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>';
                if ($cc > 0)
                    $str .= '&nbsp;&nbsp;<a onClick="javascript:delReceiver('.$tt.');" class="btn btn-xs btn-success"><i class="fa fa-trash-o"></i></a>';
                $str .= "</div>";
                $str .= "</div>";
                $str .= "</div><br />";
                if ($pick_event_type == 'IOPOS') {
                    $str .= '<div class="controls">';
                    $str .= "<label class='control-label'>".Yii::t('admin/globalevent', 'Command')."</label>";
                    $str .= '<div class="input-group date col-sm-12">';
                    $str .= '<span class="input-group-addon">
							<i class="fa  fa-star-half-o"></i>
						</span>';
                    $modelCommand = new Command;
                    $str .= CHtml::dropDownList('GlobalEventTemplate[command][]', $k->id_command, CHtml::listData($modelCommand->model()->findAll(), 'id_command', 'command'), array('class'=>'form-control GlobalEventTemplate_command','style'=>"width: 250px;", 'prompt' => Yii::t('admin/globalevent','Select Command')));
                    $str .= '</div></div><br />';
                }
                $str .= "</div>";
                $cc++; 
            }
            echo $str;
        } else echo '';
    }
    public function actionCommandList() {
        $str = '<br/><div class="controls commandList">';
        $str .= "<label class='control-label'>".Yii::t('admin/globalevent', 'Command')."</label>";
        $str .= '<div class="input-group date col-sm-12 receiver-list">';
        $str .= '<span class="input-group-addon">
					<i class="fa  fa-star-half-o"></i>
				</span>';
        $modelCommand = new Command;
        $str .= CHtml::dropDownList('GlobalEventTemplate[command][]', '', CHtml::listData($modelCommand->model()->findAll(), 'id_command', 'command'), array('class'=>'form-control GlobalEventTemplate_command','style'=>"width: 250px;", 'prompt' => Yii::t('admin/globalevent','Select Command')));
        $str .= '</div></div>';
        echo $str;
    }
}

