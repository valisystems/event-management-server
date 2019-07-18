<?php
class SettingController extends Controller
{
    public $layout = '/layouts/column1';
    
    public function init(){
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
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-toggle.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/assets/css/bootstrap-toggle.min.css");

        //$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
        //$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
        //$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScript('LoadImage',"
            var logoFile = $('#Setting_logo_path').val();
            $('#imgLogo').html(\"<img class='img-responsive img-thumbnail' src='\"+logoFile+\"'>\");
        ",CClientScript::POS_READY);

        
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
    public function actionIndex()
    {
        $model = new Setting;
        $st = $model->findAll(array('order'=>'id_settings ASC', 'limit'=>1));
        //print_r();
        if (count($st)) 
            $newModel = $st[0];
        else
            $newModel = $model;
        $this->render('index', array(
            'model' => $newModel,
        ));
    }
    public function actionSave(){
        $model = new Setting;
        if (isset($_POST['Setting'])) {
            $model->attributes = $_POST['Setting'];
            //$model->discovery = (isset($_POST['Setting']['discovery']) && !empty($_POST['Setting']['discovery']) && $_POST['Setting']['discovery'] == '1') ? '1' : '0';
            //$model->discovery = ($model->discovery)
            //Yii::log(CVarDumper::dumpAsString(array($_POST['Setting'], $model->attributes), 10),'error','app');
            //$valid = $model->validate();
            //Yii::log(CVarDumper::dumpAsString(print_r($valid)."--test", 10),'error','app');
            if ($model->validate()) {
                //Yii::log(CVarDumper::dumpAsString("--test", 10),'error','app');
                $id_settings = $model->id_settings;
                $site_name = $model->site_name;
                $site_email = $model->site_email;
                $header = $model->header;
                $footer = $model->footer;
                $default_lang = $model->default_lang;
                $tts_voice = $model->tts_voice;
                $update_ems_server = $model->update_ems_server;
                $update_ems_key = $model->update_ems_key;
                $discovery = $model->discovery;
                $default_building = $model->default_building;
                $default_map = $model->default_map;
                $logo_path = "";
                if (!empty($model->logo_path) && substr_count($model->logo_path, '/site/') == 0) {
                    $nameFile = $model->logo_path;
                    $tempFolder=Yii::getPathOfAlias('webroot').'/upload/temp/';
                    $siteFolder=Yii::getPathOfAlias('webroot').'/upload/site/';  
                    if(rename($tempFolder.$nameFile, $siteFolder.$nameFile))
                    {
                        $logo_path = "/upload/site/".$nameFile;
                        $model->logo_path = $logo_path;
                    }
                }
                $arr = array(
                   'site_name'=>$site_name,
                   'site_email'=>$site_email,
                   'header'=>$header,
                   'footer'=>$footer,
                   'default_lang'=>$default_lang,
                   'tts_voice'=>$tts_voice,
                   'update_ems_server' => $update_ems_server,
                   'update_ems_key' => $update_ems_key,
                   'discovery' =>$discovery,
                   'default_building'=>$default_building,
                    'default_map' =>$default_map
                );
                if ($logo_path != "")
                    $arr['logo_path'] = $logo_path;
                $arrSuccess = array();
                if (empty($id_settings)) {
                    $transaction=$model->dbConnection->beginTransaction();
                    try {
                        if ($model->save()) 
                        {
                            $transaction->commit();
                            $arrSuccess = array('success'=>'yes');
                            $tmpArr = Yii::app()->session['siteInfo'];
                            $tmpArr["site_name"] = $model->site_name;
                            $tmpArr["site_email"] = $model->site_email;
                            $tmpArr["logo_path"] = $model->logo_path;
                            $tmpArr["header"] = $model->header;
                            $tmpArr["footer"] = $model->footer;
                            $tmpArr["default_lang"] = $model->default_lang;
                            $tmpArr["tts_voice"] = $model->tts_voice;
                            $tmpArr["update_ems_server"] = $model->update_ems_server;
                            $tmpArr["update_ems_key"] = $model->update_ems_key;
                            Yii::app()->session['siteInfo'] = $tmpArr;
                            Yii::app()->user->setFlash('success',Yii::t('admin/patients','Added Successfuly'));
                        }
                        else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error',Yii::t('admin/patients','Added Failury'));
                        }
                    } 
                    catch (Exception $e) {
                        $transaction->rollback();
                        throw $e;
                    }
                    
                } else {
                    Setting::model()->updateByPk($id_settings, $arr);
                    $mod = Setting::model()->findByPk($id_settings);
                    $tmpArr = Yii::app()->session['siteInfo'];
                    $tmpArr["site_name"] = $mod->site_name;
                    $tmpArr["site_email"] = $mod->site_email;
                    $tmpArr["logo_path"] = $mod->logo_path;
                    $tmpArr["header"] = $mod->header;
                    $tmpArr["footer"] = $mod->footer;
                    $tmpArr["default_lang"] = $mod->default_lang;
                    $tmpArr["tts_voice"] = $mod->tts_voice;
                    $tmpArr["update_ems_server"] = $mod->update_ems_server;
                    $tmpArr["update_ems_key"] = $mod->update_ems_key;
                    Yii::app()->session['siteInfo'] = $tmpArr;
                    Yii::app()->user->setFlash('success',Yii::t('admin/patients','Saved Successfuly'));
                    $arrSuccess = array('success'=>'yes', "img_content"=>Yii::app()->baseUrl.$logo_path);
                    
                }
                header("Content-Type: text/plain");
                $result=htmlspecialchars(json_encode( $arrSuccess), ENT_NOQUOTES);
                echo $result;
            } else {
                //Yii::log(CVarDumper::dumpAsString(print_r($model->getError()), 10),'error','app');
                header("Content-Type: text/plain");
                $result=htmlspecialchars(json_encode($model->getErrors()), ENT_NOQUOTES);
                echo $result;
            }
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

    public function actionFloorList(){
        $data=Maps::model()->findAll('id_building=:id_building',
            array(':id_building'=>(int) $_POST['id_building']));

        $data=CHtml::listData($data,'id_map','name_map');
        echo CHtml::tag('option',array('value' => ''),
            CHtml::encode(Yii::t('admin/setting', 'Select Floor')),true);
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }
    }

}
?>