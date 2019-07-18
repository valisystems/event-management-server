<?php
class MapFloorController extends Controller{
    
    
    public $layout = '/layouts/column1';
    public function init(){
        parent::init();
        Yii::import("ext.EUpdateDialog.EUpdateDialog");
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

        
    }
    public function actions() {
        return array(
            'update' => 'application.controllers.actions.updateAction',
            'delete' => 'application.controllers.actions.deleteAction',
            'create' => 'application.controllers.actions.createAction',
        );
    }
    public function actionIndex()
    {
        $model = new MapFloor;
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['MapFloor']))
                $model->attributes=$_GET['MapFloor'];
        $this->render('index',
            array('modelMapFloor' => $model)
        );
        
        
        /*if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['id'])){
                $model = MapFloor::model()->findByPk($id);
                $model->status = "???????????";
                //$model->save();
                
                $criteria=new CDbCriteria(array(
                    'condition'=>'status="?? ?????????"',
                    'order'=>'update_time DESC',
                ));
                $dataProvider=new CActiveDataProvider('MapFloor', array(
                    'pagination'=>array(
                        'pageSize'=>5,
                    ),
                    'criteria'=>$criteria,
                ));
                
                $this->renderPartial('_grid', array('dataProvider'=>$dataProvider));
            }
        }*/
    }
    
    public function actionGrid()
    {
        if(!Yii::app()->request->isAjaxRequest) throw new CHttpException('Url should be requested via ajax only');
        $model=new MapFloor('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['MapFloor']))
                $model->attributes=$_GET['MapFloor'];

        $this->renderPartial('_grid',array(
                'model'=>$model,
        ), false, true);
    }
    public function actionDelete(){
        print_r($_GET);
    }
    
    public function actionAddNew(){
        $model = new MapFloor;
        $this->performAjaxValidation($model);
        
        $flag = true;
        
        if (isset($_POST['MapFloor'])) {
            $flag = false;
            $model->attributes = $_POST['MapFloor'];
            
            if ($model->save()) {
                
            }
        }
        if ($flag) {
            $this->renderPartial('addDialog', array('model'=>$model), false, true);
        }
    }
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='mapFloor-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
?>