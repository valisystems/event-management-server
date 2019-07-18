<?php
class FuncController extends Controller{
    
    
    public $layout = '/layouts/column1';
    public function init(){
        parent::init();
        $cs = Yii::app()->clientScript; //
        /*$cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/form-elements.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.cleditor.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.placeholder.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.inputlimiter.1.3.1.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-timepicker.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/daterangepicker.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.hotkeys.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-wysiwyg.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-colorpicker.min.js', CClientScript::POS_END);*/
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-toggle.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.maskedinput.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/func.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/assets/css/bootstrap-toggle.min.css");

        
    }
    
    public function actionIndex()
    {
        $st = Func::model()->findAll();
        if (count($st) > 0){
            $model = $st;
        } else $model = array();

       //$newModel = $model;
        
        
        $this->render('index', array(
            'modelFunction' => $model,
        ));
    }
    
    public function actionAllSave(){

        //print_r($_POST);exit;
        if (isset($_POST['Func'])) {
            $arrSuccess = array();
            foreach ($_POST['Func'] as $kl){
                if ($kl['id_support_manufactures'])
                    $model = Func::model()->findByPk($kl['id_support_manufactures']);
                else
                    $model = new Func;
                $model->attributes = $kl;
                $valid = $model->validate();
                $id_support_manufactures = $model->id_support_manufactures;
                if ($valid) {
                    if ($model->save()) {
                        if ($id_support_manufactures > 0) {
                            $arrSuccess = array('success'=>'update');
                        } else {
                            $arrSuccess = array('success'=>'yes');
                        }
                    } else {

                    }
                }
            }
            header("Content-Type: text/plain");
            $result=htmlspecialchars(json_encode( $arrSuccess), ENT_NOQUOTES);
            echo $result;
        } else {

        }
        Yii::app()->end();
    }
    public function actionDelete(){

        if(isset($_POST['id_manufacturer']) && $_POST['id_manufacturer'] > 0)
        {
            $modelFunc=Func::model()->findByPk(trim($_POST['id_manufacturer']));
            if ($modelFunc->delete()) {
                $arr = array('status'=>'success');
            } else {
                $arr = array('status'=>'fail');
            }
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
    }
}
?>