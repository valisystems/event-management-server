<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	/**
	 * @var array of the User Rules
	 */
	public $userRulesPath;

	public $userRules;
	public $customLinks = array();
	public $buildingsRules = array();

    public function init(){
		//Yii::app()->user->verifyLicenseOnSession();
		$cs = Yii::app()->clientScript;
		Yii::app()->clientScript->registerPackage('jquery');
		Yii::app()->clientScript->registerPackage('jquery.ui');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery-migrate-1.2.1.min.js', CClientScript::POS_END);
		//$cs->registerCoreScript('jquery.datetimepicker');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap.min.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.ui.touch-punch.min.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.iframe-transport.js', CClientScript::POS_END);
		// Theme Script
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/custom.min.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/core.min.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.autosize.min.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.datetimepicker.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/moment.min.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/systemnotification.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/allpagesmenu.js', CClientScript::POS_END);


		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/assets/css/bootstrap.min.css");
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/assets/css/jquery-ui-1.10.3.custom.css");
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/assets/css/style.min.css");
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/assets/css/retina.min.css");
		//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/assets/css/bootstrap-toggle.min.css");
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/css/mialert.css");
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/assets/css/print.css", 'print');
		//print_r(Yii::app());


    }
	protected function beforeAction($action)
	{
		Yii::app()->user->verifyLicenseOnSession();
		//echo Yii::app()->homeUrl;
		$this->modulePermission();

		return true;
	}

	protected function modulePermission(){
		if($this->userRulesPath===null){
			$this->userRulesPath = include Yii::getPathOfAlias('application.config.module_permission').'.php';
		}
		$idUser = Yii::app()->user->getId();
		if ($this->userRules === null && !empty($idUser) ) {
			$usersInfo = User::model()->findByPk($idUser);
			$this->userRules = unserialize($usersInfo->access_rules);
			foreach ($this->userRules as $k) {
				if (substr_count($k,'cust_') > 0){
					$id_custom_links = mb_ereg_replace('cust_', '',$k);
					$tmpCustLinks = CustomLinks::model()->findByPk($id_custom_links);
					if (!empty($tmpCustLinks)) {
						$this->customLinks[$tmpCustLinks->id_custom_links] = array(
							'desc' => $tmpCustLinks->desc_custom_links,
							'url' => $tmpCustLinks->url_custom_links,
							'target' => $tmpCustLinks->target_type,
							'location' => $tmpCustLinks->location_links
						);
					}
				}
			}
			//print_r(Yii::app()->userIdentity->_roleType);
			$this->buildingsRules = unserialize($usersInfo->buildings_rules);
		}
	}

	/**
	 * Use for Hide or Show parent menu
	 * @param $haystack
	 * @param $arrayToSearch
	 * @return bool
     */
	protected function verifyArrayIfExist($haystack, $arrayToSearch){
		if (!empty($haystack) && count($arrayToSearch)) {
			foreach ($arrayToSearch as $k){
				if (substr_count($k, $haystack, 0)) {
					return true;
					break;
				}
			}
		} else return false;

	}

}