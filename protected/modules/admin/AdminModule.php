<?php

class AdminModule extends CWebModule
{
	public function init()
	{
        //Yii::app()->user->verifyLicenseOnSession();
	}

	public function beforeControllerAction($controller, $action)
	{
        if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
//            $cs = Yii::app()->clientScript;
//            $cs->registerCoreScript('jquery');
//            $cs->registerCoreScript('jquery.ui');
//            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery-migrate-1.2.1.min.js', CClientScript::POS_END);
//            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap.min.js', CClientScript::POS_END);
//            //$cs->registerCoreScript('jquery.datetimepicker');
//            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.datetimepicker.js', CClientScript::POS_END);
//            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/moment.min.js', CClientScript::POS_END);
//            //$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_HEAD);
//            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.ui.touch-punch.min.js', CClientScript::POS_END);
//            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.iframe-transport.js', CClientScript::POS_END);
//            // Theme Script
//            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/custom.min.js', CClientScript::POS_END);
//            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/core.min.js', CClientScript::POS_END);
//            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.autosize.min.js', CClientScript::POS_END);
//            $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/systemnotification.js', CClientScript::POS_END);
//
//
//            $cs->registerCssFile(Yii::app()->request->baseUrl."/assets/css/bootstrap.min.css");
//            //$cs->registerCssFile(Yii::app()->request->baseUrl."/assets/css/jquery-ui-1.10.3.custom.css");
//            $cs->registerCssFile(Yii::app()->request->baseUrl."/assets/css/style.min.css");
//            $cs->registerCssFile(Yii::app()->request->baseUrl."/assets/css/retina.min.css");
//            $cs->registerCssFile(Yii::app()->request->baseUrl."/assets/css/print.css");
//            $cs->registerCssFile(Yii::app()->request->baseUrl."/assets/css/bootstrap-toggle.min.css");
//            $cs->registerCssFile(Yii::app()->request->baseUrl."/css/mialert.css");

            //$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/vasea.js', CClientScript::POS_HEAD);
            //$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/vasea.js', CClientScript::POS_HEAD);
    
    
    		// this method is called when the module is being created
    		// you may place code here to customize the module or the application
    
    		// import the module-level models and components
    		$this->setImport(array(
    			'admin.models.*',
    			'admin.components.*',
    		));
            Yii::app()->setComponents(array(
                        'errorHandler'=>array(
                        'errorAction'=>'admin/default/error',
                    )
                )
            );

            if (Yii::app()->user->role != 'administrator' && Yii::app()->user->role != 'moderator') {
                Yii::app()->request->redirect('/site');
            }
            return true;
		}
		else
			return false;
	}
    
}
