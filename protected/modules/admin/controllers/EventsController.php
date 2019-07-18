<?php

class EventsController extends Controller
{
	public $layout='/layouts/column1';

	public function init(){
		parent::init();
		$cs = Yii::app()->clientScript; //
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-tab.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/events.js', CClientScript::POS_END);

	}
	public function actionIndex()
	{
		$buildings = Buildings::model()->count();
		if ($buildings == 0){
			$this->redirect('admin/buildings/create');
		}
		$maps = Maps::model()->count();
		if ($maps == 0){
			$this->redirect('admin/buildings');
		}
		$rooms = Rooms::model()->count();
		if ($rooms == 0){
			$this->redirect('admin/rooms/create');
		}
		$patients = Patients::model()->count();
		if ($patients == 0){
			$this->redirect('admin/patients/create');
		}
		$devices = Devices::model()->count();
		if ($devices == 0){
			$this->redirect('admin/devices/create');
		}
		/*$pick = PickEvents::model()->count();
		if ($pick == 0){
			$this->redirect('admin/pickevents/create');
		}*/

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
		/*$criteria->condition = 'r.id_room=:id_room';
		$criteria->params = array(':id_room'=>$id);*/
		$events = EventsManage::model()->findAll($criteria);

		$sort       = new CSort;
		$sort->attributes = array(
			'device_description' => array(
				'asc' => 'device_description',
				'desc' => 'device_description desc'
			),
			'nb_room' => array(
				'asc' => 'nb_room',
				'desc' => 'nb_room desc'
			),
			'call_type_desc' => array(
				'asc' => 'call_type_desc',
				'desc' => 'call_type_desc DESC'
			)
		);

		$dataProvider=new CArrayDataProvider($events, array(
			//'id'=>'id_event',
			'keyField' => 'id_event',
			'pagination'=>array(
				'pageSize'=>25,
			),
			'sort' =>$sort
		));
		//print_r($dataProvider);exit;
		$this->render('index', array('model'=>$dataProvider));
	}
	public function actionFloor($id, $building_id)
	{

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
		$criteria->condition = 'r.id_map=:id_room';
		$criteria->params = array(':id_room'=>$id);
		$events = EventsManage::model()->findAll($criteria);

		$sort       = new CSort;
		$sort->attributes = array(
			'device_description' => array(
				'asc' => 'device_description',
				'desc' => 'device_description desc'
			),
			'nb_room' => array(
				'asc' => 'nb_room',
				'desc' => 'nb_room desc'
			),
			'call_type_desc' => array(
				'asc' => 'call_type_desc',
				'desc' => 'call_type_desc DESC'
			)
		);

		$dataProvider=new CArrayDataProvider($events, array(
			//'id'=>'id_event',
			'keyField' => 'id_event',
			'pagination'=>array(
				'pageSize'=>25,
			),
			'sort' =>$sort
		));
		$this->render('index',array(
			'model'=>$dataProvider,
		));
	}

	public function actionCreate(){
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
					Yii::app()->user->setFlash('success',Yii::t('admin/events','Added Events Successfuly'));
				} else {
					Yii::app()->user->setFlash('error',Yii::t('admin/events','Please try again'));
				}
				$this->redirect(array('index','id'=>$model->id_room));
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
				$id_emergency_command = (isset($events['command']) && !empty($events['command'])) ? $events['command'] : array();
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
					Yii::app()->user->setFlash('success',Yii::t('admin/events','Added Events Successfuly'));
				} else {
					Yii::app()->user->setFlash('error',Yii::t('admin/events','Please try again'));
				}
				$this->redirect(array('index','id'=>$model->id_room));
			}
		} else {
			echo $this->render('_form_events', array('model'=>$model));
		}
	}


	public function actionFloorRoomList(){
		//print_r($this->id);
		if (!empty($_POST['id_building'])){
			$id_building = (int) $_POST['id_building'];
			$id_room = (isset($_POST['id_room']) && !empty($_POST['id_room'])) ? ((int) $_POST['id_room']) : -1;
			$rooms = Yii::app()->db->createCommand()
				->select('r.id_room, r.nb_room, m.id_map, m.name_map')
				->from('{{rooms}} r')
				->join('{{maps}} m', 'r.id_map=m.id_map')
				->where('m.id_building=:id', array(':id'=>$id_building))
				->queryAll();
			$floorRoomArray = array();
			foreach ($rooms as $v) {
				$floorRoomArray[$v['id_map']]['name'] = $v['name_map'];
				$floorRoomArray[$v['id_map']]['rooms'][] = array('id_room' => $v['id_room'], 'nb'=> $v['nb_room']);
			}
			$html = "";
			foreach ($floorRoomArray as $kk=>$vv) {
				//print_r($kk);
				if (count($vv['rooms']) > 0) {
					$html .= '<optgroup label="'.$vv['name'].'">';
					foreach ($vv['rooms'] as $rr) {
						if ($id_room == $rr['id_room'])
							$html .= '<option value="'.$rr['id_room'].'" SELECTED>'.CHtml::encode($rr['nb'])."</option>";
						else
							$html .= '<option value="'.$rr['id_room'].'">'.CHtml::encode($rr['nb'])."</option>";
					}
					$html .= '</optgroup>';

				}
			}
			echo "<option>".Yii::t('admin/events', 'Select Room')."</option>".$html;
			//$data = CHtml::listData($floorRoomArray,'id_room','nb','group');
			//echo $data;
		}
	}

	public function actionDevicesList(){
		$html = "<option value=''>".Yii::t('admin/events', 'Select Device')."</option>";
		if (!empty($_POST['id_room'])){
			$id_room = $_POST['id_room'];
			$devices = Devices::model()->findAll('id_room=:id_room',array(':id_room' => $id_room));
			foreach ($devices as $k) {
				$html .= "<option value='{$k->id_device}'>{$k->device_description}</option>";
			}
		}

		echo $html;
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
                                        <i class="fa  fa-star-half-o"></i>
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
                                            <i class="fa fa-ellipsis-v"></i>
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
                                                    <i class="fa fa-eyedropper"></i>
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
                                        <td id="td_'.$time.'">
                                            <label for="EventsManage_id_emergency_contact_'.$time.'">'.Yii::t('admin/rooms', 'Receiver').'</label>
                                            <div class="input-group date col-sm-4">
                                               <span class="input-group-addon">
                                                    <i class="fa fa-bookmark"></i>
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
                                            <i class="fa fa-cubes"></i>
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
							$id_contact = $v['id_contact'];
							if ($pick_event_type == 'IOPOS'){
								$id_contact = $v['id_iodevice'];
							} else if ($pick_event_type == 'HTTP'){
								$id_contact = $v['id_http_inventory'];
							}
							//$id_contact = ($pick_event_type == 'IOPOS') ? $v['id_iodevice'] : $v['id_contact'];// => 4
							$id_command = $v['id_command'];// => 4

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
                                                    <i class="fa fa-eyedropper"></i>
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
                                        <td id="td_'.$time.'">
                                            <label for="EventsManage_id_emergency_contact_'.$time.'">'.Yii::t('admin/rooms', 'Receiver').'</label>
                                            <div class="input-group date col-sm-4">
                                               <span class="input-group-addon">
                                                    <i class="fa fa-bookmark"></i>
                                                </span>
                                                '.
								CHtml::dropDownList('EventsManage[id_emergency_contact]['.$time.']', $id_contact, $data, array('class'=>'form-control',
									'style'=>"width: 250px;",))
								.'
                                            </div>';
							if ($pick_event_type == 'IOPOS') {
								$html .= '<br/><div class="controls commandList">'
								. "<label class='control-label'>" . Yii::t('admin/globalevent', 'Command') . "</label>"
								. '<div class="input-group date col-sm-12 receiver-list">'
								. '<span class="input-group-addon">
					<i class="fa  fa-star-half-o"></i>
				</span>';
								$modelCommand = new Command;
								$html .= CHtml::dropDownList('EventsManage[command][' . $time . ']', $id_command, CHtml::listData($modelCommand->model()->findAll(), 'id_command', 'command'), array('class' => 'form-control EventsManage_command', 'style' => "width: 250px;", 'prompt' => Yii::t('admin/globalevent', 'Select Command')));
								$html .= '</div></div>';
							}
		$html .= '            </td>
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

	public function actionGetNewEmergencyContact(){
		if (Yii::app()->request->isAjaxRequest) {
			$time = time();
			$html = '<table id="'.$time.'" class="emergencyContact">
                        <tr>
                            <td>
                                <label for="EventsManage_pick_event_type_'.$time.'">'.Yii::t('admin/rooms', 'Pick Event Type').'</label>
                                <div class="input-group date col-sm-4">
                                   <span class="input-group-addon">
                                        <i class="fa fa-eyedropper"></i>
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
                            <td id="td_'.$time.'">
                                <label for="EventsManage_id_emergency_contact_'.$time.'">'.Yii::t('admin/rooms', 'Receiver').'</label>
                                <div class="input-group date col-sm-4">
                                   <span class="input-group-addon">
                                        <i class="fa fa-bookmark"></i>
                                    </span>
                                    '.
				CHtml::dropDownList('EventsManage[id_emergency_contact]['.$time.']', '', array(), array('class'=>'form-control',
					'style'=>"width: 250px;",))
				.'
                                </div>
                            </td>
                        </tr>
                    </table>
            ';
			echo $html;
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
				} else if ($event_type == 'HTTP') {
					$data = HttpInventory::model()->getHttpAction();
				}
				if ($data) {
					if ($event_type == 'IOPOS')
						echo CHtml::tag('option',array('value' => ''),
							CHtml::encode(Yii::t('admin/rooms', 'Select I/O Device')),true);
					else
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

	public function actionUpdate($id){
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
					Yii::app()->user->setFlash('success',Yii::t('admin/events','Updated Events Successfuly'));
				} else {
					Yii::app()->user->setFlash('error',Yii::t('admin/events','Please try again'));
				}
				$this->redirect(array('index','id'=>$modelEventsManage->id_room));
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
				$id_emergency_command = (isset($events['command']) && !empty($events['command'])) ? $events['command'] : array();
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

						try {
							//Yii::log(CVarDumper::dumpAsString(print_r($mdTemp, true), 10),'error','app');

							if ($mdTemp->save()) {
								array_push($arr, array('status' => 'success', 'id_event' => $id_event, 'pick_event_type' => $v, 'id_contact' => $id_emergency_contact[$k]));
							} else {
								array_push($arr, array('status' => 'fail', 'id_event' => $id_event, 'pick_event_type' => $v, 'id_contact' => $id_emergency_contact[$k], 'error' => $mdTemp->getErrors()));
							}
						} catch (Exception $e) {

							Yii::log(CVarDumper::dumpAsString($mdTemp->getErrors(), 10),'error','app');
						}
					}

					Yii::app()->user->setFlash('success',Yii::t('admin/events','Updated Events Successfuly'));
				} else {
					Yii::app()->user->setFlash('error',Yii::t('admin/events','Please try again'));
				}
				$this->redirect(array('index','id'=>$modelEventsManage->id_room));
			}
		} else {
			$modelEventsManage->id_room = $modelEventsManage->dDevice->id_room;
			$modelEventsManage->id_building = $modelEventsManage->dDevice->id_building;
			$modelEventsManage->id_map = $modelEventsManage->dDevice->id_map;
			Yii::app()->clientScript->registerScript('gridFilter',"
            $(function(){
                //$('#EventsManage_id_device').change();
                $('#EventsManage_id_building').change();
                setTimeout(function(){
					$('#EventsManage_event_type').val($('#event_type_tmp').attr('tochange'));
					$('#EventsManage_event_type').change();
                }, 2000);

			 });

        ", CClientScript::POS_READY);
			echo $this->render('update', array('model'=>$modelEventsManage),true, false);
		}
	}

	public function actionCommandList() {
		$randomNumber = (isset($_POST['randomNumber']) && !empty($_POST['randomNumber'])) ? trim($_POST['randomNumber']) : "";
		$str = '<br/><div class="controls commandList">';
		$str .= "<label class='control-label'>".Yii::t('admin/globalevent', 'Command')."</label>";
		$str .= '<div class="input-group date col-sm-12 receiver-list">';
		$str .= '<span class="input-group-addon">
					<i class="fa  fa-star-half-o"></i>
				</span>';
		$modelCommand = new Command;
		$str .= CHtml::dropDownList('EventsManage[command]['.$randomNumber.']', '', CHtml::listData($modelCommand->model()->findAll(), 'id_command', 'command'), array('class'=>'form-control EventsManage_command','style'=>"width: 250px;", 'prompt' => Yii::t('admin/globalevent','Select Command')));
		$str .= '</div></div>';
		echo $str;
	}
}