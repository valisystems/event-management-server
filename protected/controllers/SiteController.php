<?php

class SiteController extends Controller
{
	public function init(){
		parent::init();
		$cs = Yii::app()->clientScript;
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.icheck.min.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/login.js', CClientScript::POS_END);
	}
	public function beforeControllerAction($controller, $action)
	{


		if(parent::beforeControllerAction($controller, $action))
		{
			// import the module-level models and components
			Yii::app()->setComponents(array(
					'errorHandler'=>array(
						'errorAction'=>'admin/default/error',
					)
				)
			);
			return true;
		}
		else
			return false;
	}


	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

//	protected function afterAction($action)
//	{
//		Yii::app()->user->verifyLicenseOnSession();
//	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		if (!Yii::app()->user->licenseVerification()) {
			$this->redirect('/site/activate');
		}
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		if (!Yii::app()->user->licenseVerification()) {
			$this->redirect('/site/activate');
		}
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (!Yii::app()->user->licenseVerification()) {
			$this->redirect('/site/activate');
		}
		$model=new LoginForm('login');
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
        //print_r($_POST);
        //echo Yii::app()->user->returnUrl;die();
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];

			// validate user input and redirect to the previous page if valid
			if ($model->validate() && $model->login()) {

				//$this->redirect(Yii::app()->user->returnUrl);
				if (Yii::app()->user->role == 'administrator' || Yii::app()->user->role == 'moderator') {
					//echo "aici";exit;
					$settingsModel = Settings::model()->find();
					if (count($settingsModel)) {
						Yii::app()->session['siteInfo'] = array(
							"site_name" => $settingsModel->site_name,
							"site_email" => $settingsModel->site_email,
							"logo_path" => $settingsModel->logo_path,
							"header" => $settingsModel->header,
							"footer" => $settingsModel->footer,
							"default_lang" => $settingsModel->default_lang,
							"tts_voice" => $settingsModel->tts_voice,
							"provisioning_number" => $settingsModel->provisioning_number,
							"notification_number" => $settingsModel->notification_number,
							"extension_limit_number" => $settingsModel->extension_limit_number,
							"sms_url" => $settingsModel->sms_url,
							"update_ems_server" => $settingsModel->update_ems_server,
							"update_ems_key" => $settingsModel->update_ems_key
						);
					} else {
						Yii::app()->session['siteInfo'] = array(
							"site_name" => "miALERT",
							"site_email" => "",
							"logo_path" => "",
							"header" => "",
							"footer" => "",
							"default_lang" => "en",
							"tts_voice" => "",
							"provisioning_number" => "",
							"notification_number" => "",
							"extension_limit_number" => "",
							"sms_url" => "",
						);
					}
					//print_r(Yii::app()->session['siteInfo']);exit;

					$this->redirect('/admin');
				} else
					$this->redirect('/site');

			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionLoginStaff()
	{
		if (!Yii::app()->user->licenseVerification()) {
			$this->redirect('/site/activate');
		}
		$model=new LoginForm('loginStaff');
		//$model->scenario = 'loginStaff'; // set the scenario
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='staff-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		//echo Yii::app()->user->returnUrl;die();
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			Yii::import('application.modules.admin.models.Staff');
			Yii::import('application.modules.admin.models.ExtensionInventory');
			Yii::import('application.modules.admin.models.Buildings');
			Yii::import('application.modules.admin.models.Maps');
			// validate user input and redirect to the previous page if valid
			if ($model->validate()) {
				//print_r(array($model->username, $model->password));
				try {
					$staffInfo = Staff::model()->findByAttributes(array('personal_id' => $model->username, 'pin_code' => $model->password), 'staff_status = :status', array(':status'=>'1'));
					//var_dump($staffInfo);
				} catch (Exception $e){
					echo $e->getMessage();
				}

				$extInfo = ExtensionInventory::model()->findByAttributes(array('ext_number' => $model->extension));
				//$this->redirect(Yii::app()->user->returnUrl);
				if (isset($staffInfo) && count($staffInfo) && isset($extInfo) && count($extInfo)) {
					//echo "aici";exit;
					if (!empty($staffInfo->id_staff) && !empty($extInfo->id_extension)){
						Yii::app()->session['stafInfo'] = array(
							'id_staff' => $staffInfo->id_staff,
							'name' => $staffInfo->first_name.' '.$staffInfo->last_name,
							'avatar' => $staffInfo->avatar_path,
							'ext_id' => $extInfo->id_extension,
							'id_building' => $extInfo->id_building,
							'buildingName' => $extInfo->idBuilding->name,
							'id_map' =>  $extInfo->id_map,
							'name_map' =>  $extInfo->idMap->name_map,
							'ext_number' => $extInfo->ext_number
						);
						$this->redirect('/site/staffStartDate');
					} else
						$this->redirect('/site/staffLogin');


				} else
					$this->redirect('/site/staffLogin');

			}
		}
		// display the login form
		$this->render('loginStaff',array('model'=>$model));
	}
	public function actionStaffStartDate(){
		// display the login form
		$this->render('startStaffDay',array());
	}


	public function actionActivate(){
		$model = new Settings;

		//
		Yii::app()->clientscript->scriptMap['systemnotification.js'] = false;
		if (isset($_POST['Settings'])) {
			$model->attributes = $_POST['Settings'];
			$valid = $model->validate();
			if ($valid){
				$id_settings = $model->id_settings;
				if ($id_settings > 0) $model->isNewRecord = false;
				if ($model->isNewRecord) {
					$model->id_settings = 1;
					if ($model->save()) {
						Yii::app()->user->setFlash('success', Yii::t('site/activate', 'Added Successfuly'));
					} else {
						Yii::app()->user->setFlash('error', Yii::t('site/activate', 'Added Failury'));
					}
				} else {
					$criteria = new CDbCriteria;
					$criteria->limit = "1";
					$criteria->order = "id_settings ASC";
					$criteria->condition = "id_settings=:id_settings";
					$criteria->params = array(":id_settings"=>$id_settings);

					$model = Settings::model()->find($criteria);
					$model->activation_key = $_POST['Settings']['activation_key'];
					$model->secret_key = $_POST['Settings']['secret_key'];
					if ($model->save()) {
						Yii::app()->user->setFlash('success', Yii::t('site/activate', 'Updated Successfuly'));
					} else {
						Yii::app()->user->setFlash('error', Yii::t('site/activate', 'Updated Failury'));
					}
				}
			}
		}
		if (Yii::app()->user->licenseVerification()) {
			$this->redirect('/site/login');
		}


		$criteria = new CDbCriteria;
		$criteria->limit = "1";
		$criteria->order = "id_settings ASC";

		$model = Settings::model()->find($criteria);
		if (empty($model->id_settings))
			$model = new Settings;

		$this->render('activate',array('model'=>$model));

	}


	public function actionStaffCheckIn(){
		print_r($_POST);
		$model = new StaffWorking;
		if (isset($_POST) && !empty($_POST['staff_rooms'])){
			$roomSelected = "";
			if (count($_POST['staff_rooms'])) {
				foreach($_POST['staff_rooms'] as $k){
					$roomSelected .= $k.",";
				}

				if ($roomSelected != "")
					$roomSelected = substr($roomSelected, 0, -1);
			}

//			Yii::app()->session['stafInfo'] = array(
//				'id_staff' => $staffInfo->id_staff,
//				'name' => $staffInfo->first_name.' '.$staffInfo->last_name,
//				'avatar' => $staffInfo->avatar_path,
//				'ext_id' => $extInfo->id_extension,
//				'id_building' => $extInfo->id_building,
//				'buildingName' => $extInfo->idBuilding->name,
//				'id_map' =>  $extInfo->id_map,
//				'name_map' =>  $extInfo->idMap->name_map,
//				'ext_number' => $extInfo->ext_number
//			);
			if (!empty($roomSelected) && count(Yii::app()->session['stafInfo'])) {
				$tmpArray = Yii::app()->session['stafInfo'];
				$model->id_staff = $tmpArray['id_staff'];
				$model->id_extension = $tmpArray['ext_id'];
				$model->selected_rooms = $roomSelected;
				$model->start_work = new CDbExpression('NOW()');
				$valid = $model->validate();
				if ($valid && $model->save()){
					Yii::app()->session['stafInfo'] = array();
					$this->redirect(Yii::app()->homeUrl);
					Yii::app()->end();
				} else {

					echo $valid;
				}
				//$model->start_work = Yii::app()->cd
			}
		}
	}
    
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}