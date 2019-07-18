<?php

class UpdateEmsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '/layouts/column1';

	public function init(){
		parent::init();
		$cs = Yii::app()->clientScript; //d3.min.js
		$cs->registerScriptFile(Yii::app()->request->baseUrl . '/assets/js/pages/updateems.js', CClientScript::POS_END);
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
		$listUpdate = $listUpdateCustom = array();
		$update_ems_server = Yii::app()->session['siteInfo']['update_ems_server'];
		$update_ems_key = Yii::app()->session['siteInfo']['update_ems_key'];

		$url = $update_ems_server."/getUpdateInfo.php";
		$post = array(
			'ems_key' => $update_ems_key
		);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		//echo $url;
		$response = curl_exec($ch);
		curl_close($ch);
		$model = UpdateInfo::model()->findAll();
		Yii::log(CVarDumper::dumpAsString($model, 10), 'error', 'app');
		if (count($model)) {
			foreach($model as $k) {
				if ($k->update_custom == '0') {
					$listUpdate[$k->update_version] = array(
						"update_name" => $k->update_name,
						"update_description" => $k->update_description,
						"update_path" => $k->update_path,
						"update_custom" => $k->update_custom,
						"update_version" => $k->update_version,
						"update_installed" => $k->update_installed
					);
				} else {
					$listUpdateCustom[$k->update_version] = array(
						"update_name" => $k->update_name,
						"update_description" => $k->update_description,
						"update_path" => $k->update_path,
						"update_custom" => $k->update_custom,
						"update_version" => $k->update_version,
						"update_installed" => $k->update_installed
					);
				}
			}
		}
		Yii::log(CVarDumper::dumpAsString($listUpdate, 10), 'error', 'app');
		$this->render('index', array('response'=>$response, 'existUpdate'=>$listUpdate,'existUpdateCustom'=>$listUpdateCustom));
	}

	public function actionApplyUpdate($actUpdate){
		$update_ems_server = Yii::app()->session['siteInfo']['update_ems_server'];
		$update_ems_key = Yii::app()->session['siteInfo']['update_ems_key'];
		set_time_limit(0);
		$fileName = "update".time();
		$fp = fopen ('/tmp/'.$fileName.'.tar.gz', 'w+');
		if($fp === false){
			throw new Exception('Could not open: /tmp/'.$fileName.'.tar.gz');
		}
		$url = $update_ems_server."/downfile.php";
		$post = array(
			'ems_key' => $update_ems_key,
			'path_file' => $actUpdate
		);

		$urlUpdateInfo = $update_ems_server."/updateDescription.php";

		$ch = curl_init($urlUpdateInfo);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		//echo $url;
		$responseInfo = curl_exec($ch);
		curl_close($ch);

		$infToUpdate = CJSON::decode($responseInfo);

		$ifExist = UpdateInfo::model()->findByAttributes(array('update_version' => $infToUpdate['updateInfo']['update_version'], 'update_custom' =>$infToUpdate['updateInfo']['update_custom']));
		if (empty($ifExist)) {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_TIMEOUT, 50);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			$data = curl_exec($ch);//get curl response
			curl_close($ch);
			fwrite($fp, $data);
			fclose($fp);
			$p = new PharData('/tmp/' . $fileName . '.tar.gz');
			$p->decompress();
			$phar = new PharData('/tmp/' . $fileName . '.tar');
			$phar->extractTo('/tmp/' . $fileName);


			Yii::log(CVarDumper::dumpAsString("sudo " . Yii::getPathOfAlias("webroot") . "/update.sh " . '/tmp/' . $fileName . " " . Yii::getPathOfAlias("webroot"), 10), 'error', 'app');
			$output = shell_exec("sudo " . Yii::getPathOfAlias("webroot") . "/update.sh " . '/tmp/' . $fileName . " " . Yii::getPathOfAlias("webroot"));
			Yii::log(CVarDumper::dumpAsString($output, 10), 'error', 'app');
			$commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
			$runner = new CConsoleCommandRunner();
			$runner->addCommands($commandPath);
			$commandPath = Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';
			$runner->addCommands($commandPath);
			$args = array('yiic', 'migrate', 'up', '--interactive=0');
			ob_start();
			$runner->run($args);
			$output .= "\n" . htmlentities(ob_get_clean(), null, Yii::app()->charset);

			$modelUpdate = new UpdateInfo;
			$modelUpdate->update_name = $infToUpdate['updateInfo']['update_name'];
			$modelUpdate->update_description = $infToUpdate['updateInfo']['update_description'];
			$modelUpdate->update_path = $infToUpdate['updateInfo']['update_path'];
			$modelUpdate->update_time_ins = $infToUpdate['updateInfo']['update_time_ins'];
			$modelUpdate->update_version = $infToUpdate['updateInfo']['update_version'];
			$modelUpdate->update_custom = $infToUpdate['updateInfo']['update_custom'];
			$modelUpdate->update_installed = '1';
			if ($modelUpdate->save()){
				$post = array(
					'ems_key' => $update_ems_key,
					'path_file' => $actUpdate
				);

				$urlUpdateInfo = $update_ems_server."/updateInstalled.php";

				$ch = curl_init($urlUpdateInfo);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
				//echo $url;
				$responseInfo = curl_exec($ch);
				curl_close($ch);
			}
		} else {
			$output = Yii::t('admin/updateEms', 'Update Is Installed');
		}
		$this->render('_updateInfo', array('response'=>$output));


	}

	private function recursiveRemoveDirectory($directory)
	{
		foreach(glob("{$directory}/*") as $file)
		{
			if(is_dir($file)) {
				$this->recursiveRemoveDirectory($file);
			} else {
				unlink($file);
			}
		}
		rmdir($directory);
	}

	private function recurse_copy($src,$dst) {
		$dir = opendir($src);
		@mkdir($dst);
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' ) && $file != "config.php" && $file != "console.php") {
				if ( is_dir($src . '/' . $file) ) {
					$this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
				}
				else {
					//Yii::log(CVarDumper::dumpAsString(Yii::getPathOfAlias("webroot").$dst . '/' . $file, 10),'error','app');
					copy($src . '/' . $file,$dst . '/' . $file);

				}
			}
		}
		closedir($dir);
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