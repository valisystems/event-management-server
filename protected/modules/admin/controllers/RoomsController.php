<?php

class RoomsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/column1';

    public function init(){
        parent::init();
        $cs = Yii::app()->clientScript; //
        //$cs->registerCssFile(Yii::app()->request->baseUrl . '/assets/css/jquery.dataTables.css');
        $cs->registerCssFile(Yii::app()->request->baseUrl . '/assets/css/dataTables.bootstrap.css');
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.canvasAreaDraw.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-tab.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.dataTables.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/dataTables.bootstrap.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/rooms.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScript('gridFilter',"   
            $(function(){
                //$('#Rooms_nb_room').off('change.yiiGridView keydown.yiiGridView');
                $(document).unbind('change.yiiGridView keydown.yiiGridView');$(document).unbind('click.yiiGridView');
                //console.log($('#Rooms_nb_room').data('events'));
         });
        ", CClientScript::POS_READY);
        Yii::app()->clientscript->scriptMap['jquery.ui.touch-punch.min.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery.ba-bbq.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery.ui.touch-punch.min.js'] = false;
        Yii::app()->clientscript->scriptMap['jquery.ui.touch-punch.min.js'] = false;
        
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
		$model=new Rooms;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Rooms']))
		{
			$model->attributes=$_POST['Rooms'];
            if($model->save()) {
                Yii::app()->user->setFlash('success',Yii::t('admin/patients','Added Successfuly'));
                $this->redirect(array('index'));
            } else {
                Yii::app()->user->setFlash('error',Yii::t('admin/patients','Added Failure'));
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
        
        $data=Maps::model()->find('id_map=:id_map', 
                      array(':id_map'=>(int) $model->id_map));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Rooms']))
		{
			$model->attributes=$_POST['Rooms'];
			if($model->save()) {
                Yii::app()->user->setFlash('success',Yii::t('admin/patients','Updated Successfuly'));
                $this->redirect(array('index'));
            } else {
                Yii::app()->user->setFlash('error',Yii::t('admin/patients','Updated Failury'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
            'maps'=>$data,
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

    public function actionViewonmap($id) {
        $model=$this->loadModel($id);
        $modelMaps = new Maps;
        $imgInfo = $modelMaps->findByPk($model->id_map);
        $this->render('viewonmap',array(
			'model'=>$model,
            'imgInfo'=>$imgInfo
		));
    }
    
	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new Rooms('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Rooms']))
			$model->attributes=$_GET['Rooms'];

		if (isset($_GET['ajax'])) {
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            //Yii::app()->clientscript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-migrate-1.2.1.min.js'] = false;
            Yii::app()->clientscript->scriptMap['bootstrap.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui-1.10.3.custom.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.ui.touch-punch.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.iframe-transport.js'] = false;
            Yii::app()->clientscript->scriptMap['fullcalendar.min.js'] = false;
            Yii::app()->clientscript->scriptMap['custom.min.js'] = false;
            Yii::app()->clientscript->scriptMap['core.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.autosize.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.cleditor.min.js'] = false;
            //Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['rooms.js'] = true;
            $this->renderPartial('index',array(
                'model'=>$model,
            ));
        }
        else {
            $this->render('index',array(
    			'model'=>$model,
    		));
        }
	}
    /**
     * Manages all models.
     */
    public function actionFloor($id, $building_id)
    {
        $this->render('index',array( ));
    }
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Rooms the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Rooms::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    
    
    public function actionFloorList(){
        $data=Maps::model()->findAll('id_building=:id_building', 
                  array(':id_building'=>(int) $_POST['id_building']));
 
        $data=CHtml::listData($data,'id_map','name_map');
        echo CHtml::tag('option',array('value' => ''),
            CHtml::encode(Yii::t('admin/rooms', 'Select Floor')),true);
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                       array('value'=>$value),CHtml::encode($name),true);
        }
    }
    public function actionFloorInfo(){
        if (!empty($_POST['id_map'])){
            $data=Maps::model()->find('id_map=:id_map', 
                      array(':id_map'=>(int) $_POST['id_map']));
            
            if (!empty($data->path_to_img)) {
                $str = '';
                $str .= "<div class='row' id='roomConstruction'>";
                $str .= CHtml::activeHiddenField(New Rooms,"coordinate_on_map"); 
                $str .= "
                    <script>
                        $(document).ready(function(){
                            $('#Rooms_coordinate_on_map').canvasAreaDraw({
                                imageUrl: '".Yii::app()->getRequest()->getHostInfo().$data->path_to_img."'
                              });
                        });
                    </script>
                ";
                $str .= "</div>";
                Yii::app()->clientscript->scriptMap['jquery.canvasAreaDraw.js'] = true;
                //echo $str.$script;
                echo $str;
            }
            
        } else echo "";
    }
    public function actionUpdatePosition(){
        $model=$this->loadModel($_POST['id']);
        if (!empty($_POST['positionRoom'])) {
            $model->coordinate_on_map = trim($_POST['positionRoom']);
            $model->save();
        }
    }

	/**
	 * Performs the AJAX validation.
	 * @param Rooms $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rooms-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionRoomEvent($id){
         if (Yii::app()->request->isAjaxRequest) {
            /*
            SELECT d.device_description, r.id_room, r.nb_room, ct.description AS call_type_desc FROM mia_events_manage AS em
            INNER JOIN mia_devices d ON d.id_device = em.id_device
            INNER JOIN mia_rooms r ON r.id_room = d.id_room
            INNER JOIN mia_calls_type ct ON em.id_call_type = ct.id_call_type
            WHERE r.id_room = 
            
            */
            $criteria=new CDbCriteria;
            $criteria->select = 'em.id_event, d.device_description, r.id_room, r.nb_room, ct.description AS call_type_desc, pe.pick_event_type, 
                                IF (pe.pick_event_type = "VOIP", p.voice_message,
                                IF (pe.pick_event_type = "TRANSFER", p.voice_message,
                                IF (pe.pick_event_type = "EMAIL", p.email_message,
                                IF (pe.pick_event_type = "SMS", p.text_message, get.desc_global_event)))) as eventMessages ';
            $criteria->alias = 'em';
            $criteria->join = ' LEFT JOIN '.Yii::app()->db->tablePrefix.'devices d ON d.id_device = em.id_device ';
            $criteria->join .= ' LEFT JOIN '.Yii::app()->db->tablePrefix.'rooms r ON r.id_room = d.id_room ';
            $criteria->join .= ' LEFT JOIN '.Yii::app()->db->tablePrefix.'calls_type ct ON em.id_call_type = ct.id_call_type ';
            $criteria->join .= ' LEFT JOIN '.Yii::app()->db->tablePrefix.'global_event_template get ON em.id_global_event = get.id_global_event_template ';
            $criteria->join .= ' LEFT JOIN '.Yii::app()->db->tablePrefix.'pick_events pe ON em.id_event = pe.id_event ';
            $criteria->join .= ' LEFT JOIN '.Yii::app()->db->tablePrefix.'emergency_contact ec ON pe.id_contact = ec.id_emergency_contact ';
            $criteria->join .= ' LEFT JOIN '.Yii::app()->db->tablePrefix.'patients p ON ec.id_patient = p.id_patient ';
            //$criteria->with=array('dDevice');
            $criteria->condition = 'r.id_room=:id_room';
            $criteria->params = array(':id_room'=>$id);            
            
    		/*$events = new CActiveDataProvider('EventsManage', array(
    			'criteria'=>$criteria,
                'pagination'=>false,
    		));*/
            $events = EventsManage::model()->findAll($criteria);
            if (count($events) > 0) {
                echo $this->renderPartial('_events_manage', array('model'=>$events),true, false);
            } else {
                echo "<div id_patient='{$id}' id='needInfo'></div><center>".Yii::t("admin/patients","No Data")."</center>";
            }
         }
    }
    public function actionAddEventsRoom($id){
        if (Yii::app()->request->isAjaxRequest) {
            $model = new EventsManage;
            if (isset($_POST['EventsManage'])){
                $events = $_POST['EventsManage'];
                if ($events['event_type'] == 'template') {
                    $id_room = $events['id_room'];
                    $model->id_device = $events['id_device'];// => 4
                    $model->id_call_type = NULL;// => 4
                    $model->event_type = $events['event_type'];// => template
                    $model->id_global_event = $events['global_event'];// => 11
                    if($model->save()) {
                        $arr = array('status'=>'success', 'id_room'=>$id_room);
                    } else {
                        $arr = array('status'=>'fail');
                    }
                    header('Content-Type: application/json');
                    echo json_encode($arr);
                } else {
                    $id_room = $events['id_room'];
                    $model->id_device = $events['id_device'];// => 4
                    $model->id_call_type = $events['calls_type'];// => 4
                    $model->event_type = $events['event_type'];// => template
                    $model->id_global_event = NULL;// => 11
                    $model->live_panel = $events['live_panel'];// => template
                    $model->require_acknowledge = $events['require_acknowledge'];// => template
                    $model->auto_close = $events['auto_close'];// => template
                    $model->flashing_toggle = $events['flashing_toggle'];// => template
                    $model->auto_close_duration = $events['auto_close_duration'];// => template
                    
                    $pick_event_type = $events['pick_event_type'];
                    $id_emergency_contact = $events['id_emergency_contact'];
                    if($model->save()) {
                        $arr = array('status'=>'success', 'id_room'=>$id_room);
                        $id_event = $model->id_event;
                        foreach ($pick_event_type as $k => $v) {
                            $mdTemp = new PickEvents;
                            $mdTemp->id_event = $id_event;
                            $mdTemp->pick_event_type = strtoupper($v);
                            if (strtoupper($v) == 'IOPOS') {
                                $mdTemp->id_contact = 0;
                                $mdTemp->id_command = (isset($id_emergency_command[$k]) && !empty($id_emergency_command[$k])) ? $id_emergency_command[$k] : 0;
                                $mdTemp->id_iodevice = $id_emergency_contact[$k];
                            } else if (strtoupper($v) == 'HTTP'){
                                $mdTemp->id_http_inventory = $id_emergency_contact[$k];
                                $mdTemp->id_iodevice = $mdTemp->id_contact = 0;
                            } else {
                                $mdTemp->id_contact = $id_emergency_contact[$k];
                                $mdTemp->id_iodevice = 0;
                            }
                            $mdTemp->save();
                        }
                    } else {
                        $arr = array('status'=>'fail');
                    }
                    header('Content-Type: application/json');
                    echo json_encode($arr);
                }
            } else {
            
                $model->id_room = $id;
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
                Yii::app()->clientscript->scriptMap['jquery.cleditor.min.js'] = false;
                //Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
                Yii::app()->clientscript->scriptMap['rooms.js'] = true;
                echo $this->renderPartial('_add_room_events', array('model'=>$model),true, false);
            }
        }
    }
    
    public function actionGenerateAfterPickEvent(){
        if (Yii::app()->request->isAjaxRequest) {
            if(isset($_POST['EventsManage'])){
                $genFirstTime = (isset($_POST['genFirstTime']) && empty($_POST['genFirstTime'])) ? $_POST['genFirstTime'] : 1;
                $id_device = (isset($_POST['id_device']) && !empty($_POST['id_device'])) ? $_POST['id_device'] : -1;
                if (isset($_POST['EventsManage']['event_type']) && $_POST['EventsManage']['event_type'] == 'template'){
                    $html = '<div class="col-lg-10">
                                <div class="form-group">
                                <label for="EventsManage_global_event">'.Yii::t('admin/rooms', 'Global Events').'</label>
                                <div class="input-group date col-sm-4">
                                   <span class="input-group-addon">
                                        <i class="fa  fa-comment-o"></i>
                                    </span>
                                    '.
                                    CHtml::dropDownList('EventsManage[global_event]', '', CHtml::listData(GlobalEventTemplate::model()->findAll(), 'id_global_event_template','desc_global_event'), array('class'=>'form-control',
                                        'style'=>"width: 250px;",))
                                    .'
                                </div>
                            </div>
                        </div>';
                    echo $html;
                } else if (isset($_POST['EventsManage']['event_type']) && $_POST['EventsManage']['event_type'] == 'custom') {
                    if ($genFirstTime > 0) {
                        $time = time();
                        $html = '<div class="col-lg-10">
                                    <div class="form-group">
                                    <label for="EventsManage_calls_type">'.Yii::t('admin/rooms', 'Call Type').'</label>
                                    <div class="input-group date col-sm-4">
                                       <span class="input-group-addon">
                                            <i class="fa fa-comment-o"></i>
                                        </span>
                                        '.
                                        CHtml::dropDownList('EventsManage[calls_type]', '', CHtml::listData(CallsType::model()->findAll(), 'id_call_type','description'), array('class'=>'form-control',
                                            'style'=>"width: 250px;",))
                                        .'
                                    </div>
                                </div>
                            </div>';
                        $html .= '<br/>
                            <div id="receiverContent" class="row col-lg-10">
                                <table id="'.$time.'" class="emergencyContact">
                                    <tr>
                                        <td>
                                            <label for="EventsManage_pick_event_type_'.$time.'">'.Yii::t('admin/rooms', 'Pick Event Type').'</label>
                                            <div class="input-group date col-sm-4">
                                               <span class="input-group-addon">
                                                    <i class="fa fa-comment-o"></i>
                                                </span>
                                                '.
                                                CHtml::dropDownList('EventsManage[pick_event_type]['.$time.']', '', Yii::app()->params['pick_event_type'], array('class'=>'form-control',
                                                    'style'=>"width: 250px;",
                                                    'prompt' => Yii::t('admin/rooms','Select Pick Event Type'),
                                                    'onChange'=>'populateEmergencyContact(this, '.$time.');',
                                                    
                                                    ))
                                                .'
                                            </div>
                                        </td>
                                        <td rowspan=2>
                                            &nbsp;&nbsp;<a onClick="javascript:addEventReceiver();" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="EventsManage_id_emergency_contact_'.$time.'">'.Yii::t('admin/rooms', 'Receiver').'</label>
                                            <div class="input-group date col-sm-4">
                                               <span class="input-group-addon">
                                                    <i class="fa fa-comment-o"></i>
                                                </span>
                                                '.
                                                CHtml::dropDownList('EventsManage[id_emergency_contact]['.$time.']', '', array(), array('class'=>'form-control',
                                                    'style'=>"width: 250px;",))
                                                .'
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        ';
                        echo $html;
                    } else if ($genFirstTime == 0) {
                        $id_event = (isset($_POST['id_event']) && !empty($_POST['id_event'])) ? $_POST['id_event'] : -1;
                        $criteria=new CDbCriteria;
                        $criteria->condition = 'id_event=:id_event';
                        $criteria->params = array(':id_event'=>$id_event);   
                        $model = PickEvents::model()->findAll($criteria);
                        $html = '';
                        $cc = 0;
                        $html = '<div class="col-lg-10">
                                    <div class="form-group">
                                    <label for="EventsManage_calls_type">'.Yii::t('admin/rooms', 'Call Type').'</label>
                                    <div class="input-group date col-sm-4">
                                       <span class="input-group-addon">
                                            <i class="fa fa-comment-o"></i>
                                        </span>
                                        '.
                                        CHtml::dropDownList('EventsManage[calls_type]', '', CHtml::listData(CallsType::model()->findAll(), 'id_call_type','description'), array('class'=>'form-control',
                                            'style'=>"width: 250px;",))
                                        .'
                                    </div>
                                </div>
                            </div>';
                        foreach ($model as $k => $v){
                            $time = time().rand(0,100);
                            $id_pick_event = $v['id_pick_event'];// => 2
                            $id_event = $v['id_event'];// => 10
                            $pick_event_type = $v['pick_event_type'];// => SMS
                            $id_contact = $v['id_contact'];// => 4
                            if ($pick_event_type == 'IOPOS'){
                                $id_contact = $v['id_iodevice'];
                            } else if ($pick_event_type == 'HTTP'){
                                $id_contact = $v['id_http_inventory'];
                            }
                            //$id_device = $v['id_device'];
                            
                            $criteriaEmergency = new CDbCriteria;
                            $criteriaEmergency->select = "ec.id_emergency_contact, CONCAT(ec.name_contact,' - ', ec.mobile) AS contact_voip, CONCAT(ec.name_contact,' - ', ec.email) AS contact_email, CONCAT(ec.name_contact,' - ', ec.sms) AS contact_sms";
                            $criteriaEmergency->alias = 'ec';
                            $criteriaEmergency->join = ' INNER JOIN '.Yii::app()->db->tablePrefix.'room_device_patient rdp ON ec.id_patient = rdp.id_patient ';
                            $criteriaEmergency->condition = 'rdp.id_device = :id_device';
                            $criteriaEmergency->params = array(':id_device'=>$id_device);   
                            $modelEmergencyContact = EmergencyContact::model()->findAll($criteriaEmergency);
                            
                            if ($pick_event_type == 'SMS') {
                                $data=CHtml::listData($modelEmergencyContact,'id_emergency_contact','contact_sms');
                            } else if ($pick_event_type == 'EMAIL') {
                                $data=CHtml::listData($modelEmergencyContact,'id_emergency_contact','contact_email');
                            } else  if ($pick_event_type == 'VOIP') {
                                $data=CHtml::listData($modelEmergencyContact,'id_emergency_contact','contact_voip');
                            }  else  if ($pick_event_type == 'TRANSFER') {
                                $data=CHtml::listData($modelEmergencyContact,'id_emergency_contact','contact_voip');
                            } else if ($pick_event_type == 'IOPOS') {
                                $sysModel = new MipositioningInputDevice;
                                $data = CHtml::listData($sysModel->model()->findAll(), 'id_input_device','io_name');
                            }  else  if ($pick_event_type == 'HTTP') {
                                $data=HttpInventory::model()->getHttpAction();
                            }
                           
                            $html .= '<div id="receiverContent" class="row col-lg-10">
                                <table id="'.$time.'" class="emergencyContact">
                                    <tr>
                                        <td>
                                            <label for="EventsManage_pick_event_type_'.$time.'">'.Yii::t('admin/rooms', 'Pick Event Type').'</label>
                                            <div class="input-group date col-sm-4">
                                               <span class="input-group-addon">
                                                    <i class="fa fa-comment-o"></i>
                                                </span>
                                                '.
                                                CHtml::dropDownList('EventsManage[pick_event_type]['.$time.']', $pick_event_type, Yii::app()->params['pick_event_type'], array('class'=>'form-control',
                                                    'style'=>"width: 250px;",
                                                    'prompt' => Yii::t('admin/rooms','Select Pick Event Type'),
                                                    'onChange'=>'populateEmergencyContact(this, '.$time.');',
                                                    
                                                    ))
                                                .'
                                            </div>
                                        </td>
                                        <td rowspan=2>
                                            &nbsp;&nbsp;<a onClick="javascript:addEventReceiver();" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>';
                            if ($cc > 0)
                                $html .= '&nbsp;&nbsp;<a onClick="javascript:delEventReceiver('.$time.');" class="btn btn-xs btn-success"><i class="fa fa-trash-o"></i></a>';                           
                            $html .= '           </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="EventsManage_id_emergency_contact_'.$time.'">'.Yii::t('admin/rooms', 'Receiver').'</label>
                                            <div class="input-group date col-sm-4">
                                               <span class="input-group-addon">
                                                    <i class="fa fa-comment-o"></i>
                                                </span>
                                                '.
                                                CHtml::dropDownList('EventsManage[id_emergency_contact]['.$time.']', $id_contact, $data, array('class'=>'form-control',
                                                    'style'=>"width: 250px;",))
                                                .'
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>';
                            $cc++;
                        }
                        echo $html;
                    }
                } else {
                }
            }        
        }
    }
    function actionUpdateEventsRoom($id, $id_room){
        if (Yii::app()->request->isAjaxRequest) {
            $modelEventsManage=EventsManage::model()->findByPk($id);
            if (isset($_POST['EventsManage'])) {
                $events = $_POST['EventsManage'];
                //print_r($events);
                if ($events['event_type'] == 'template') {
                    $id_room = $events['id_room'];
                    $modelEventsManage->id_device = $events['id_device'];// => 4
                    $modelEventsManage->id_call_type = NULL;// => 4
                    $modelEventsManage->event_type = $events['event_type'];// => template
                    $modelEventsManage->id_global_event = $events['global_event'];// => 11
                    if($modelEventsManage->save()) {
                        PickEvents::model()->deleteAllByAttributes(array('id_event'=>$id));
                        $arr = array('status'=>'success', 'id_room'=>$id_room);
                    } else {
                        $arr = array('status'=>'fail');
                    }
                    header('Content-Type: application/json');
                    echo json_encode($arr);
                } else {
                    $id_room = $events['id_room'];
                    $modelEventsManage->id_device = $events['id_device'];// => 4
                    $modelEventsManage->id_call_type = $events['calls_type'];// => 4
                    $modelEventsManage->event_type = $events['event_type'];// => template
                    $modelEventsManage->id_global_event = NULL;// => 11
                    $modelEventsManage->live_panel = $events['live_panel'];// => template
                    $modelEventsManage->require_acknowledge = $events['require_acknowledge'];// => template
                    $modelEventsManage->auto_close = $events['auto_close'];// => template
                    $modelEventsManage->flashing_toggle = $events['flashing_toggle'];// => template
                    $modelEventsManage->auto_close_duration = $events['auto_close_duration'];// => template
                    $pick_event_type = $events['pick_event_type'];
                    $id_emergency_contact = $events['id_emergency_contact'];
                    if($modelEventsManage->save()) {
                        $arr = array('status'=>'success', 'id_room'=>$id_room, 'events'=>$pick_event_type);
                        $id_event = $id;
                        PickEvents::model()->deleteAllByAttributes(array('id_event'=>$id));
                        //array_push($arr,$pick_event_type);
                        foreach ($pick_event_type as $k => $v) {
                            $mdTemp = new PickEvents;
                            $mdTemp->id_event = $id_event;
                            $mdTemp->pick_event_type = strtoupper($v);
                            if (strtoupper($v) == 'IOPOS') {
                                $mdTemp->id_contact = 0;
                                $mdTemp->id_command = (isset($id_emergency_command[$k]) && !empty($id_emergency_command[$k])) ? $id_emergency_command[$k] : 0;
                                $mdTemp->id_iodevice = $id_emergency_contact[$k];
                            } else if (strtoupper($v) == 'HTTP'){
                                $mdTemp->id_http_inventory = $id_emergency_contact[$k];
                                $mdTemp->id_iodevice = $mdTemp->id_contact = 0;
                            } else {
                                $mdTemp->id_contact = $id_emergency_contact[$k];
                                $mdTemp->id_iodevice = 0;
                            }
                            if ($mdTemp->save()) {
                                array_push($arr, array('status'=>'success', 'id_event'=>$id_event, 'pick_event_type' => $v, 'id_contact' => $id_emergency_contact[$k]));
                            } else {
                                array_push($arr, array('status'=>'fail', 'id_event'=>$id_event, 'pick_event_type' => $v, 'id_contact' => $id_emergency_contact[$k], 'error'=>$mdTemp->getErrors()));
                            }
                        }
                    } else {
                        $arr = array('status'=>'fail');
                    }
                    header('Content-Type: application/json');
                    echo json_encode($arr);
                    exit;
                }
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
                Yii::app()->clientscript->scriptMap['jquery.cleditor.min.js'] = false;
                //Yii::app()->clientscript->scriptMap['bootstrap-wysiwyg.min.js'] = false;
                Yii::app()->clientscript->scriptMap['rooms.js'] = false;
                $modelEventsManage->id_room = $id_room;
                echo $this->renderPartial('_update_room_events', array('model'=>$modelEventsManage),true, false);
            }

        }
    }
    
    public function actionGetEmergencyContactList(){
        if (Yii::app()->request->isAjaxRequest) {
            if(isset($_POST['EventsManage'])) {
                $event_type = $_POST['EventsManage']['event_type'];
                $id_device = $_POST['id_device'];
                
                $criteria=new CDbCriteria;
                $criteria->select = "ec.id_emergency_contact, CONCAT(ec.name_contact,' - ', ec.mobile) AS contact_voip, CONCAT(ec.name_contact,' - ', ec.email) AS contact_email, CONCAT(ec.name_contact,' - ', ec.sms) AS contact_sms";
                $criteria->alias = 'ec';
                $criteria->join = ' INNER JOIN '.Yii::app()->db->tablePrefix.'room_device_patient rdp ON ec.id_patient = rdp.id_patient ';
                $criteria->condition = 'rdp.id_device = :id_device';
                $criteria->params = array(':id_device'=>$id_device);   
                $model = EmergencyContact::model()->findAll($criteria);
                $data = NULL;
                if ($event_type == 'SMS') {
                    $data=CHtml::listData($model,'id_emergency_contact','contact_sms');
                } else if ($event_type == 'EMAIL') {
                    $data=CHtml::listData($model,'id_emergency_contact','contact_email');
                } else  if ($event_type == 'VOIP') {
                    $data=CHtml::listData($model,'id_emergency_contact','contact_voip');
                } else  if ($event_type == 'TRANSFER') {
                    $data=CHtml::listData($model,'id_emergency_contact','contact_voip');
                } else if ($event_type == 'IOPOS') {
                    $sysModel = new MipositioningInputDevice;
                    $data = CHtml::listData($sysModel->model()->findAll(), 'id_input_device','io_name');
                }  else  if ($event_type == 'HTTP') {
                    $data=HttpInventory::model()->getHttpAction();
                }
                if ($data) {
                    echo CHtml::tag('option',array('value' => ''),
                        CHtml::encode(Yii::t('admin/rooms', 'Emergency Contact')),true);
                    foreach($data as $value=>$name)
                    {
                        echo CHtml::tag('option',
                                   array('value'=>$value),CHtml::encode($name),true);
                    }
                } else echo "";
            } else echo "";
        }
    }
    
    public function actionGetNewEmergencyContact(){
        if (Yii::app()->request->isAjaxRequest) {
            $time = time();
            $html = '<table id="'.$time.'" class="emergencyContact">
                        <tr>
                            <td>
                                <label for="EventsManage_pick_event_type_'.$time.'">'.Yii::t('admin/rooms', 'Pick Event Type').'</label>
                                <div class="input-group date col-sm-4">
                                   <span class="input-group-addon">
                                        <i class="fa fa-comment-o"></i>
                                    </span>
                                    '.
                                    CHtml::dropDownList('EventsManage[pick_event_type]['.$time.']', '', Yii::app()->params['pick_event_type'], array('class'=>'form-control',
                                        'style'=>"width: 250px;",
                                        'prompt' => Yii::t('admin/rooms','Select Pick Event Type'),
                                        'onChange'=>'populateEmergencyContact(this, '.$time.');',
                                        
                                        ))
                                    .'
                                </div>
                            </td>
                            <td rowspan=2>
                                &nbsp;&nbsp;<a onClick="javascript:addEventReceiver();" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>
                                &nbsp;&nbsp;<a onClick="javascript:delEventReceiver('.$time.');" class="btn btn-xs btn-success"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="EventsManage_id_emergency_contact_'.$time.'">'.Yii::t('admin/rooms', 'Receiver').'</label>
                                <div class="input-group date col-sm-4">
                                   <span class="input-group-addon">
                                        <i class="fa fa-comment-o"></i>
                                    </span>
                                    '.
                                    CHtml::dropDownList('EventsManage[id_emergency_contact]['.$time.']', '', array(), array('class'=>'form-control',
                                        'style'=>"width: 250px;",))
                                    .'
                                </div>
                            </td>
                        </tr>
                    </table><br/>
            ';
            echo $html;
        }
    }
    
    public function actionDeleteEvents($id) {
        $modelEventRoom = EventsManage::model()->findByPk($id); // ????????????, ??? ?????? ? ID=10 ??????????
        if($modelEventRoom->delete()) {
            $arr = array('status'=>'success');
        } else {
            $arr = array('status'=>'fail');
        }
        header('Content-Type: application/json');
        echo json_encode($arr); 
    }
    
    public function actionAutocomplete(){
        if (Yii::app()->request->isAjaxRequest) {
            $term = Yii::app()->getRequest()->getParam('term');
            $nb_room = (isset($term) && !empty($term)) ? trim($term) : "";
            $criteria = new CDbCriteria;
            // ????????? ???????? ??????
            
            $criteria->addSearchCondition('nb_room', $nb_room);
            $items = Rooms::model()->findAll(array(
                'condition'=>'nb_room LIKE :keyword',
                'params'=>array(
                     ':keyword'=>'%'.strtr($nb_room,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
                   )
                )
            );
            // ???????????? ?????????
            $result = array();
            foreach($items as $item) {
                $result[] = array(
                    'id'=>$item['id_room'],
                    'label'=>$item['nb_room'],
                    'value'=>$item['nb_room'],
                );
            }
            header('Content-Type: application/json');
            echo CJSON::encode($result);
            Yii::app()->end();
        }
    }
    
    public function actionDevInfoAreaPath($id){
        if (Yii::app()->request->isAjaxRequest) {
            $devInfo = Yii::app()->db->createCommand()
                ->select('d.device_description, d.comon_area, rdp.id_patient')
                ->from('{{devices}} d')
                ->leftJoin('{{room_device_patient}} rdp', 'rdp.id_device = d.id_device')
                ->where('d.id_device=:id', array(':id'=>$id))
                ->queryRow();
            if (isset($devInfo) && count($devInfo) && $devInfo['id_patient'] > 0){
                $emergencyCount = EmergencyContact::model()->findAllByAttributes(array('id_patient'=>$devInfo['id_patient']));
                if (count($emergencyCount)) {
                    $devInfo['emergency'] = 1;
                } else $devInfo['emergency'] = NULL;
            }
            echo CJSON::encode($devInfo);
            Yii::app()->end();
        }
    }

    public function actionVerifyRoomNumber(){
        $idBuilding = (isset($_POST['id_building']) &&  !empty($_POST['id_building'])) ? $_POST['id_building'] : "";
        $id_map = (isset($_POST['id_map']) &&  !empty($_POST['id_map'])) ? $_POST['id_map'] : "";
        $nb_room = (isset($_POST['id_room']) &&  !empty($_POST['id_room'])) ? $_POST['id_room'] : "";
        if (!empty($idBuilding) && !empty($id_map) && !empty($nb_room)){
            $model = Rooms::model()->find('id_building=:id_building AND id_map = :id_map AND nb_room=:nb_room', array(':id_building'=>$idBuilding, ':id_map'=>$id_map, ':nb_room'=>$nb_room));
            if(count($model)){
                echo "exist";
            } else {
                echo "no";
            }
        }
    }

    public function actionInformations()
    {
        $start = (isset($_POST['start']) && !empty($_POST['start'])) ? trim($_POST['start']) : 0;
        $length = (isset($_POST['length']) && !empty($_POST['length'])) ? trim($_POST['length']) : 25;
        $search = (isset($_POST['search']['value']) && !empty($_POST['search']['value'])) ? trim($_POST['search']['value']) : "";
        $draw = (isset($_POST['draw']) && !empty($_POST['draw'])) ? trim($_POST['draw']) : 0;
        $order = (isset($_POST['order'])) ? $_POST['order'][0] : array('column' => 0, 'dir' => 'desc');
        $column = array('r.nb_room','b.name', 'm.description', 'm.name_map');
        $id_building = (isset($_POST['id_building']) && !empty($_POST['id_building'])) ? trim($_POST['id_building']) : 0;
        $id_map = (isset($_POST['id_map']) && !empty($_POST['id_map'])) ? trim($_POST['id_map']) : 0;


        $sql = "SELECT SQL_CALC_FOUND_ROWS (0), r.nb_room, r.id_room, b.name, m.description, m.name_map, m.path_to_img, r.nb_of_seats
                FROM {{rooms}} r
                INNER JOIN {{maps}} m ON m.id_map = r.id_map
                INNER JOIN {{buildings}} b ON b.id_building = r.id_building ";

        $whereTXT = "";
        $whereArray = NULL;

        if ($id_building > 0) {
            $whereTXT = " b.id_building = :id_building";
            $whereArray[':id_building'] = $id_building;
        }
        if ($id_map > 0) {
            if ($whereTXT != "")
                $whereTXT .= " AND ";

            $whereTXT .= " m.id_map = :id_map";
            $whereArray[':id_map'] = $id_map;
        }
        if (!empty($search)) {
            if ($whereTXT != "")
                $whereTXT .= " AND ";

            $whereTXT .= " ( r.nb_room LIKE :searchText";
            $whereTXT .= " OR b.name LIKE :searchText";
            $whereTXT .= " OR m.description LIKE :searchText";
            $whereTXT .= " OR r.nb_of_seats LIKE :searchText";
            $whereTXT .= " OR m.name_map LIKE :searchText )";

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
                $htmlData ='';
                $generalInfo = $patientsHtml = $nbOfSeats = $devicesHtml = '';
                $nbOfSeats = '<fieldset>';
                $nbOfSeats .= '<label>'.Yii::t('admin/rooms', 'Number of seats').'</label>';
                $nbOfSeats .= '<div class="row"><div class="col-lg-11">'.$kl['nb_of_seats'].'</div></div>';
                $nbOfSeats .= "</fieldset>";

                $criteria=new CDbCriteria;
                $criteria->select = "p.id_patient, CONCAT(p.first_name, ' ', p.last_name) AS patient_name, pc.url_camera";
                $criteria->alias = 'p';
                $criteria->join = ' INNER JOIN {{room_device_patient}} rdp ON rdp.id_patient = p.id_patient ';
                $criteria->join .= ' INNER JOIN {{patient_cameras}} pc ON p.id_patient = pc.id_patient ';
                $criteria->condition = 'rdp.id_room = :id_room';
                $criteria->params = array(':id_room'=>$kl['id_room']);

                $patients = Patients::model()->findAll($criteria);

                $crDevice=new CDbCriteria;
                $crDevice->condition = 'id_room = :id_room';
                $crDevice->params = array(':id_room'=>$kl['id_room']);

                $devices = Devices::model()->findAll($crDevice);
                if (count($devices)){
                    $devicesHtml = '<fieldset>';
                    $devicesHtml .= '<label>'.Yii::t('admin/rooms', 'List of Devices').'</label>';
                    foreach ($devices as $v) {
                        $devicesHtml .= '<div class="row"><div class="col-lg-11">'.CHtml::link( $v['device_description'].' - '. $v['serial_number'], array( 'devices/update/id/'.$v['id_device']))."</div></div>";
                    }
                    $devicesHtml .= "</fieldset>";
                }

                if (count($patients)) {
                    $patientsHtml = '<fieldset>';
                    $patientsHtml .= '<label>'.Yii::t('admin/rooms', 'List of Patients').'</label>';
                    foreach ($patients as $k) {
                        $cameraURL = ($k['url_camera'] != "") ? ' -  <a href="'.$k['url_camera'].'" target="_blank"><i class="fa fa-eye"></i></a>' : '';
                        $patientsHtml .= '<div class="row"><div class="col-lg-11">'.CHtml::link( $k['patient_name'], array( 'patients/update/id/'.$k['id_patient'])).$cameraURL."</div></div>";
                    }
                    $patientsHtml .= "</fieldset>";
                }
                $generalInfo = $nbOfSeats.$patientsHtml.$devicesHtml;
                $htmlData = "<span title='".$kl['nb_room']."' data-delay='{ \"hide\": \"3000\"}'  data-html='true' data-content='".$generalInfo."' data-toggle='popover' data-trigger='hover' data-placement='right'>".$kl['nb_room']."</span>";

                $action = "<a href='javascript:void(0);' url='".Yii::app()->createUrl("admin/rooms/roomEvent", array("id"=>$kl['id_room']))."' onClick='javascript:return manageEvents(this);'><i class='fa fa-tasks'></i></a>";
                $action .= "&nbsp;&nbsp;<a href='".Yii::app()->createUrl("admin/rooms/update", array("id"=>$kl['id_room']))."'><i class='fa fa-pencil'></i></a>";
                $action .= "&nbsp;&nbsp;<a href='".Yii::app()->createUrl("admin/rooms/delete", array("id"=>$kl['id_room']))."' onClick='javascript:return confirm(\"".Yii::t("admin/rooms", "Are you sure you want to delete this item?")."\")'><i class='fa fa-trash-o'></i></a>";
                $data[] = array(
                    $htmlData,
                    $kl['name'],
                    CHtml::link( '<i class="fa fa-eye"></i>', array( 'rooms/viewonmap/id/'.$kl['id_room'] ), array('class'=>'btn btn-xs btn-success',)).'&nbsp;'.$kl['name_map'],
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
}
