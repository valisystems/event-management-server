<?php

class EventsMaxivoxController extends Controller
{
	public $layout='/layouts/column1';

	public function init(){
		parent::init();
		$cs = Yii::app()->clientScript; //
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-tab.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/eventsMaxivox.js', CClientScript::POS_END);

	}
	public function actionIndex($building_id = -1)
	{
//		SELECT em.id_event_pendant, d.description, ct.description AS pendant_type_desc, pe.pick_event_type,
//		IF (pe.pick_event_type = "VOIP", p.voice_message,
//		IF (pe.pick_event_type = "TRANSFER", p.voice_message,
//		IF (pe.pick_event_type = "EMAIL", p.email_message,
//		IF (pe.pick_event_type = "SMS", p.text_message, get.desc_global_event)))) as eventMessages  FROM mia_events_pendant_manage em
//		LEFT JOIN mia_pendant_devices d ON d.id_pendant_device = em.id_device
//		LEFT JOIN mia_pendant_type ct ON em.id_pendant_type = ct.id_pendant_type
//		LEFT JOIN mia_global_event_template get ON em.id_global_event = get.id_global_event_template
//		LEFT JOIN mia_pick_pendant_events pe ON em.id_event_pendant = pe.id_event_pendant
//		LEFT JOIN mia_emergency_contact ec ON pe.id_contact = ec.id_emergency_contact
//		LEFT JOIN mia_patients p ON ec.id_patient = p.id_patient

		$criteria=new CDbCriteria;
		$criteria->select = 'em.id_event_maxivox, d.dev_desc, ct.description AS maxivox_type_desc, pe.pick_event_type,
                                IF (pe.pick_event_type = "VOIP", p.voice_message,
                                IF (pe.pick_event_type = "TRANSFER", p.voice_message,
                                IF (pe.pick_event_type = "EMAIL", p.email_message,
                                IF (pe.pick_event_type = "SMS", p.text_message, get.desc_global_event)))) as eventMessages ';
		$criteria->alias = 'em';
		$criteria->join = ' LEFT JOIN '.Yii::app()->db->tablePrefix.'maxivox_device d ON d.id_maxivox_device = em.id_maxivox_device ';
		$criteria->join .= ' LEFT JOIN '.Yii::app()->db->tablePrefix.'maxivox_type ct ON em.id_maxivox_type = ct.id_maxivox_type ';
		$criteria->join .= ' LEFT JOIN '.Yii::app()->db->tablePrefix.'global_event_maxivox_template get ON em.id_global_event = get.id_global_event_maxivox_template ';
		$criteria->join .= ' LEFT JOIN '.Yii::app()->db->tablePrefix.'pick_maxivox_events pe ON em.id_event_maxivox = pe.id_event_maxivox ';
		$criteria->join .= ' LEFT JOIN '.Yii::app()->db->tablePrefix.'emergency_contact ec ON pe.id_contact = ec.id_emergency_contact ';
		$criteria->join .= ' LEFT JOIN '.Yii::app()->db->tablePrefix.'patients p ON ec.id_patient = p.id_patient ';
		if ($building_id > 0) {
			//$criteria->join .= ' INNER JOIN {{residents_of_rooms}} rr ON p.id_patient = rr.id_patient ';
			//$criteria->join .= ' INNER JOIN {{rooms}} r ON r.id_room = rr.id_room ';
			$criteria->condition = 'd.id_building=:id_building';
			$criteria->params = array(':id_building'=>$building_id);
		}
		//$criteria->with=array('dDevice');
		/*$criteria->condition = 'r.id_room=:id_room';
		$criteria->params = array(':id_room'=>$id);*/
		$events = EventsMaxivoxManage::model()->findAll($criteria);
		//print_r($events);exit;

		$sort       = new CSort;
		$sort->attributes = array(
			'dev_desc' => array(
				'asc' => 'dev_desc',
				'desc' => 'dev_desc desc'
			),
			'maxivox_type_desc' => array(
				'asc' => 'maxivox_type_desc',
				'desc' => 'maxivox_type_desc DESC'
			)
		);

		$dataProvider=new CArrayDataProvider($events, array(
			//'id'=>'id_event',
			'keyField' => 'id_event_maxivox',
			'pagination'=>array(
				'pageSize'=>25,
			),
			'sort' =>$sort
		));
		//print_r($dataProvider);exit;
		$this->render('index', array('model'=>$dataProvider));
	}

	public function actionCreate(){
		$model = new EventsMaxivoxManage;

		if (isset($_POST['EventsMaxivoxManage'])){
			$events = $_POST['EventsMaxivoxManage'];
			if ($events['event_type'] == 'template') {
				//$id_room = $events['id_room'];
				$model->id_maxivox_device = $events['id_maxivox_device'];// => 4
				$model->id_maxivox_type = NULL;// => 4
				$model->event_type = $events['event_type'];// => template
				$model->id_global_event = $events['global_event'];// => 11
				if($model->save()) {
					Yii::app()->user->setFlash('success',Yii::t('admin/eventsmaxivox','Added Events Successfuly'));
				} else {
					Yii::app()->user->setFlash('error',Yii::t('admin/eventsmaxivox','Please try again'));
				}
				$this->redirect(array('index'));
			} else {
				//$id_room = $events['id_room'];
				$model->id_maxivox_device = $events['id_maxivox_device'];// => 4
				$model->id_maxivox_type = $events['maxivox_type'];// => 4
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
					$arr = array('status'=>'success');
					$id_event = $model->id_event_maxivox;
					foreach ($pick_event_type as $k => $v) {
						$mdTemp = new PickMaxivoxEvents();
						$mdTemp->id_event_maxivox = $id_event;
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
					Yii::app()->user->setFlash('success',Yii::t('admin/eventsmaxivox','Added Events Successfuly'));
				} else {
					Yii::app()->user->setFlash('error',Yii::t('admin/eventsmaxivox','Please try again'));
				}
				$this->redirect(array('index'));
			}
		} else {
			echo $this->render('_form', array('model'=>$model));
		}
	}

	public function actionDevicesList() {
		$id = (isset($_POST['id_building']) && !empty($_POST['id_building'])) ? trim($_POST['id_building']) : 0;
		if ($id > 0) {
			$devices = Yii::app()->db->createCommand()
				->select('pd.*')
				->from('{{maxivox_device}} pd')
				//->join('{{residents_of_rooms}} rr', 'pd.id_patient = rr.id_patient')
				//->join('{{rooms}} r', 'pd.id_room = r.id_room')
				->where('pd.id_building=:id', array(':id'=>$id))
				->queryAll();
			$html = "<option value=''>".Yii::t('admin/eventsmaxivox', 'Select Device')."</option>";
			foreach ($devices as $k) {
				//print_r($k);
				$html .= "<option value='".$k['id_maxivox_device']."'>".CHtml::encode($k['dev_desc'])."</option>";
			}

			echo $html;
		}
	}

	public function actionGenerateAfterPickEvent(){
		if (Yii::app()->request->isAjaxRequest) {
			if(isset($_POST['EventsMaxivoxManage'])){
				$genFirstTime = (isset($_POST['genFirstTime']) && empty($_POST['genFirstTime'])) ? $_POST['genFirstTime'] : 1;
				$id_device = (isset($_POST['id_device']) && !empty($_POST['id_device'])) ? $_POST['id_device'] : -1;
				if (isset($_POST['EventsMaxivoxManage']['event_type']) && $_POST['EventsMaxivoxManage']['event_type'] == 'template'){
					$html = '<div class="col-lg-10">
                                <div class="form-group">
                                <label for="EventsMaxivoxManage_global_event">'.Yii::t('admin/eventsmaxivox', 'Global Events').'</label>
                                <div class="input-group date col-sm-4">
                                   <span class="input-group-addon">
                                        <i class="fa  fa-star-half-o"></i>
                                    </span>
                                    '.
						CHtml::dropDownList('EventsMaxivoxManage[global_event]', '', CHtml::listData(GlobalEventMaxivoxTemplate::model()->findAll(), 'id_global_event_maxivox_template','desc_global_event'), array('class'=>'form-control',
							'style'=>"width: 250px;",))
						.'
                                </div>
                            </div>
                        </div>';
					echo $html;
				} else if (isset($_POST['EventsMaxivoxManage']['event_type']) && $_POST['EventsMaxivoxManage']['event_type'] == 'custom') {
					//echo "Genfirst - ".$genFirstTime;
					if ($genFirstTime > 0) {
						$time = time();
						$html = '<div class="col-lg-10">
                                    <div class="form-group">
                                    <label for="EventsMaxivoxManage_maxivox_type">'.Yii::t('admin/eventsmaxivox', 'MaxiVox Type').'</label>
                                    <div class="input-group date col-sm-4">
                                       <span class="input-group-addon">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </span>
                                        '.
							CHtml::dropDownList('EventsMaxivoxManage[maxivox_type]', '', CHtml::listData(MaxivoxType::model()->findAll(), 'id_maxivox_type','description'), array('class'=>'form-control',
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
                                            <label for="EventsMaxivoxManage_pick_event_type_'.$time.'">'.Yii::t('admin/eventsmaxivox', 'Pick Event MaxiVox Type').'</label>
                                            <div class="input-group date col-sm-4">
                                               <span class="input-group-addon">
                                                    <i class="fa fa-eyedropper"></i>
                                                </span>
                                                '.
							CHtml::dropDownList('EventsMaxivoxManage[pick_event_type]['.$time.']', '', Yii::app()->params['pick_event_type'], array('class'=>'form-control noTransfer',
								'style'=>"width: 250px;",
								'prompt' => Yii::t('admin/eventsmaxivox','Select Pick Event Type'),
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
                                            <label for="EventsMaxivoxManage_id_emergency_contact_'.$time.'">'.Yii::t('admin/eventsmaxivox', 'Receiver').'</label>
                                            <div class="input-group date col-sm-4">
                                               <span class="input-group-addon">
                                                    <i class="fa fa-bookmark"></i>
                                                </span>
                                                '.
							CHtml::dropDownList('EventsMaxivoxManage[id_emergency_contact]['.$time.']', '', array(), array('class'=>'form-control',
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
						$criteria->condition = 'id_event_maxivox=:id_event_maxivox';
						$criteria->params = array(':id_event_maxivox'=>$id_event);
						$model = PickMaxivoxEvents::model()->findAll($criteria);
						$html = '';
						$cc = 0;
						$html = '<div class="col-lg-10">
                                    <div class="form-group">
                                    <label for="EventsPendantManage_maxivox_type">'.Yii::t('admin/eventsmaxivox', 'MaxiVox Type').'</label>
                                    <div class="input-group date col-sm-4">
                                       <span class="input-group-addon">
                                            <i class="fa fa-cubes"></i>
                                        </span>
                                        '.
							CHtml::dropDownList('EventsMaxivoxManage[maxivox_type]', '', CHtml::listData(MaxivoxType::model()->findAll(), 'id_maxivox_type','description'), array('class'=>'form-control',
								'style'=>"width: 250px;",))
							.'
                                    </div>
                                </div>
                            </div>';
						//print_r($model);
						foreach ($model as $k => $v){
							$time = time().rand(0,100);
							//$id_pick_event = $v['id_pick_event_pendant'];// => 2
							$id_event = $v['id_event_maxivox'];// => 10
							$pick_event_type = $v['pick_event_type'];// => SMS
							$id_contact = $v['id_contact'];// => 4
							if ($pick_event_type == 'IOPOS') {
								$id_contact = $v['id_iodevice'];
							} else if ($pick_event_type == 'HTTP') {
								$id_contact = $v['id_http_inventory'];
							}

							$id_command = $v['id_command'];// => 4
							//$id_device = $v['id_device'];

							$criteria=new CDbCriteria;
							$criteria->select = "ec.id_emergency_contact, CONCAT(ec.name_contact,' - ', ec.mobile) AS contact_voip, CONCAT(ec.name_contact,' - ', ec.email) AS contact_email, CONCAT(ec.name_contact,' - ', ec.sms) AS contact_sms";
							$criteria->alias = 'ec';
							$criteria->join = ' INNER JOIN {{maxivox_device}} pd ON ec.id_patient = pd.id_patient ';
							$criteria->condition = 'pd.id_maxivox_device = :id_device';
							$criteria->params = array(':id_device'=>$id_device);
							$modelEmergencyContact = EmergencyContact::model()->findAll($criteria);


							$data = array();
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
							} else if ($pick_event_type == 'HTTP') {
								$data = HttpInventory::model()->getHttpAction();
							}

							$html .= '<div id="receiverContent" class="row col-lg-10">
                                <table id="'.$time.'" class="emergencyContact">
                                    <tr>
                                        <td>
                                            <label for="EventsMaxivoxManage_pick_event_type_'.$time.'">'.Yii::t('admin/rooms', 'Pick Event Type').'</label>
                                            <div class="input-group date col-sm-4">
                                               <span class="input-group-addon">
                                                    <i class="fa fa-eyedropper"></i>
                                                </span>
                                                '.
								CHtml::dropDownList('EventsMaxivoxManage[pick_event_type]['.$time.']', $pick_event_type, Yii::app()->params['pick_event_type'], array('class'=>'form-control noTransfer',
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
                                            <label for="EventsMaxivoxManage_id_emergency_contact_'.$time.'">'.Yii::t('admin/eventsmaxivox', 'Receiver').'</label>
                                            <div class="input-group date col-sm-4">
                                               <span class="input-group-addon">
                                                    <i class="fa fa-bookmark"></i>
                                                </span>
                                                '.
								CHtml::dropDownList('EventsMaxivoxManage[id_emergency_contact]['.$time.']', $id_contact, $data, array('class'=>'form-control',
									'style'=>"width: 250px;",));

							$html .='</div>';
							if ($pick_event_type == 'IOPOS') {
								$html .= '<br/><div class="controls commandList">'
									. "<label class='control-label'>" . Yii::t('admin/globalevent', 'Command') . "</label>"
									. '<div class="input-group date col-sm-12 receiver-list">'
									. '<span class="input-group-addon">
										<i class="fa  fa-star-half-o"></i>
									</span>';
								$modelCommand = new Command;
								$html .= CHtml::dropDownList('EventsMaxivoxManage[command][' . $time . ']', $id_command, CHtml::listData($modelCommand->model()->findAll(), 'id_command', 'command'), array('class' => 'form-control EventsManage_command', 'style' => "width: 250px;", 'prompt' => Yii::t('admin/globalevent', 'Select Command')));
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

	public function actionDevInfoAreaPath($id){
		if (Yii::app()->request->isAjaxRequest) {
			$devInfo = Yii::app()->db->createCommand()
				->select('d.dev_desc, rdp.id_patient,d.comon_area')
				->from('{{maxivox_device}} d')
				->leftJoin('{{room_device_patient}} rdp', 'rdp.id_device = d.id_room')
				->where('d.id_maxivox_device=:id', array(':id'=>$id))
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

	public function actionGetNewEmergencyContact(){
		if (Yii::app()->request->isAjaxRequest) {
			$time = time();
			$html = '<table id="'.$time.'" class="emergencyContact">
                        <tr>
                            <td>
                                <label for="EventsMaxivoxManage_pick_event_type_'.$time.'">'.Yii::t('admin/eventsmaxivox', 'Pick Event Type').'</label>
                                <div class="input-group date col-sm-4">
                                   <span class="input-group-addon">
                                        <i class="fa fa-eyedropper"></i>
                                    </span>
                                    '.
				CHtml::dropDownList('EventsMaxivoxManage[pick_event_type]['.$time.']', '', Yii::app()->params['pick_event_type'], array('class'=>'form-control noTransfer',
					'style'=>"width: 250px;",
					'prompt' => Yii::t('admin/eventsmaxivox','Select Pick Event Type'),
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
                                <label for="EventsMaxivoxManage_id_emergency_contact_'.$time.'">'.Yii::t('admin/rooms', 'Receiver').'</label>
                                <div class="input-group date col-sm-4">
                                   <span class="input-group-addon">
                                        <i class="fa fa-bookmark"></i>
                                    </span>
                                    '.
				CHtml::dropDownList('EventsMaxivoxManage[id_emergency_contact]['.$time.']', '', array(), array('class'=>'form-control',
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
			if(isset($_POST['EventsMaxivoxManage'])) {
				$event_type = $_POST['EventsMaxivoxManage']['event_type'];
				$id_device = $_POST['id_device'];

				$criteria=new CDbCriteria;
				$criteria->select = "ec.id_emergency_contact, CONCAT(ec.name_contact,' - ', ec.mobile) AS contact_voip, CONCAT(ec.name_contact,' - ', ec.email) AS contact_email, CONCAT(ec.name_contact,' - ', ec.sms) AS contact_sms";
				$criteria->alias = 'ec';
				$criteria->join = ' INNER JOIN {{maxivox_device}} pd ON ec.id_patient = pd.id_patient ';
				$criteria->condition = 'pd.id_maxivox_device = :id_device';
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
				} else  if ($event_type == 'HTTP') {
					$data=HttpInventory::model()->getHttpAction();
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
				} else echo CHtml::tag('option',array('value' => ''),
					CHtml::encode(Yii::t('admin/eventsmaxivox', 'No Emergency Contact')),true);
			} else echo CHtml::tag('option',array('value' => ''),
				CHtml::encode(Yii::t('admin/eventsmaxivox', 'No Emergency Contact')),true);
		}
	}
	public function actionUpdate($id){
		$modelEventsManage=EventsMaxivoxManage::model()->findByPk($id);
		if (isset($_POST['EventsMaxivoxManage'])) {
			$events = $_POST['EventsMaxivoxManage'];
			//print_r($events);
			if ($events['event_type'] == 'template') {
				//$id_room = $events['id_room'];
				$modelEventsManage->id_maxivox_device = $events['id_maxivox_device'];// => 4
				$modelEventsManage->id_maxivox_type = "";// => 4
				$modelEventsManage->event_type = $events['event_type'];// => template
				$modelEventsManage->id_global_event = $events['global_event'];// => 11
				if($modelEventsManage->save()) {
					PickMaxivoxEvents::model()->deleteAllByAttributes(array('id_event_maxivox'=>$id));
					Yii::app()->user->setFlash('success',Yii::t('admin/eventsmaxivox','Updated Events Successfuly'));
				} else {
					Yii::app()->user->setFlash('error',Yii::t('admin/eventsmaxivox','Please try again'));
				}
				$this->redirect(array('index'));
			} else {
				$modelEventsManage->id_maxivox_device = $events['id_maxivox_device'];// => 4
				$modelEventsManage->id_maxivox_type = $events['maxivox_type'];// => 4
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
					$arr = array('status'=>'success', 'events'=>$pick_event_type);
					$id_event = $id;
					PickMaxivoxEvents::model()->deleteAllByAttributes(array('id_event_maxivox'=>$id));
					//array_push($arr,$pick_event_type);
					foreach ($pick_event_type as $k => $v) {
						$mdTemp = new PickMaxivoxEvents();
						$mdTemp->id_event_maxivox = $id_event;
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
					Yii::app()->user->setFlash('success',Yii::t('admin/eventsmaxivox','Updated Events Successfuly'));
				} else {
					Yii::app()->user->setFlash('error',Yii::t('admin/eventsmaxivox','Please try again'));
				}
				$this->redirect(array('index'));
			}
		} else {
			//$modelEventsManage->id_room = $modelEventsManage->dDevice->id_room;
			//$modelEventsManage->id_building = $modelEventsManage->idDevice->id_building;
			//$modelEventsManage->id_map = $modelEventsManage->idDevice->id_map;
//			SELECT r.id_building FROM mia_pendant_devices pd
//			INNER JOIN mia_residents_of_rooms rr ON pd.id_patient = rr.id_patient
//			INNER JOIN mia_rooms r ON r.id_room = rr.id_room


			$buildingInfo = Yii::app()->db->createCommand()
				->select('r.id_building')
				->from('{{maxivox_device}} pd')
				->join('{{rooms}} r', 'pd.id_room = r.id_room')
				->where('pd.id_maxivox_device = :id_maxivox_device', array(':id_maxivox_device'=>$modelEventsManage->id_maxivox_device))
				->queryScalar();

			$modelEventsManage->id_building = $buildingInfo;
			//print_r($buildingInfo);

			//print_r($modelEventsManage);
			Yii::app()->clientScript->registerScript('gridFilter',"
            $(function(){
                //$('#EventsMaxivoxManage_id_maxivox_device').change();
                $('#ajax_loader').ajaxStart(function(){
					$(this).show();
				});
                $('#EventsMaxivoxManage_id_building').change();
                setTimeout(function(){
	               	$('#EventsMaxivoxManage_id_maxivox_device').val(".$modelEventsManage->id_maxivox_device.");
					$('#EventsMaxivoxManage_event_type').val($('#event_type_tmp').attr('tochange'));
					$('#EventsMaxivoxManage_event_type').change();

                }, 4000);

			 });

        ", CClientScript::POS_READY);
			echo $this->render('update', array('model'=>$modelEventsManage),true, false);
		}
	}

	public function actionDelete($id){
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
	public function loadModel($id)
	{
		$model=EventsMaxivoxManage::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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
		$str .= CHtml::dropDownList('EventsMaxivoxManage[command]['.$randomNumber.']', '', CHtml::listData($modelCommand->model()->findAll(), 'id_command', 'command'), array('class'=>'form-control EventsMaxivoxManage_command','style'=>"width: 250px;", 'prompt' => Yii::t('admin/globalevent','Select Command')));
		$str .= '</div></div>';
		echo $str;
	}
}