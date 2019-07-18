<?php

class LivepanelModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
        
        $cs = Yii::app()->clientScript;
        /*$cs->registerCoreScript('jquery');
        $cs->registerCoreScript('jquery.ui');
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery-migrate-1.2.1.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_HEAD);
        // Theme Script
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/custom.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/core.min.js', CClientScript::POS_HEAD);*/
        //$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.autosize.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.maphilight.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.maphilight.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.stickr.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/modules/livepanel/livepanel.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/modules/livepanel/miPositioning.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/modules/livepanel/maxiVoxdevice.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/modernizr.custom.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/classie.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/gnmenu.js', CClientScript::POS_END);
        $cs->registerScript('gmenu', "
            var menuLive = new gnMenu( document.getElementById( 'gn-menu' ) );
        ", CClientScript::POS_READY);
        

		// import the module-level models and components
		$this->setImport(array(
			'livepanel.models.*',
			'livepanel.components.*',
		));
        //Yii::import('application.vendors.freepbx');
        Yii::app()->setComponents(array(
                    'errorHandler'=>array(
                    'errorAction'=>'livepanel/default/error',
                )
            )
        );
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
