<?php

class PositioningController extends Controller
{
    public $layout = '/layouts/column1';
    public function init(){
        parent::init();
        $cs = Yii::app()->clientScript; //
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-modal.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-dialog.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/jquery.chosen.min.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/pages/positioning.js', CClientScript::POS_END);
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/assets/js/bootstrap-editable.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl."/assets/css/bootstrap-editable.css");
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
        $criteria=new CDbCriteria;
        //$criteria->compare('id_map',$id);
        $criteria->condition = 'device_classification = :device_classification';
        $criteria->params = array(':device_classification'=>'mipositioning');

        $dataProvide = new CActiveDataProvider('Devices', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>25,
            ),
        ));

        $this->render('index', array('model'=>$dataProvide));
    }
    /**
     * Manages all models.
     */
    public function actionFloor($id, $building_id)
    {

        $criteria=new CDbCriteria;
        $criteria->condition = 'device_classification = :device_classification AND id_map = :id_map';
        $criteria->params = array(':device_classification'=>'mipositioning', ':id_map' =>$id);

        $dataProvide = new CActiveDataProvider('Devices', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>25,
            ),
        ));
        $this->render('index',array(
            'model'=>$dataProvide,
        ));
    }

    public function actionAddNew(){
        $model = new Devices;
        $this->performAjaxValidation($model);

        $this->renderPartial('_add', array('model'=>$model));

    }

    public function actionChangeIO(){
        if (Yii::app()->request->isAjaxRequest) {
            $name = (isset($_POST['name']) && !empty($_POST['name'])) ? trim($_POST['name']): "";
            $value = (isset($_POST['value']) && !empty($_POST['value'])) ? trim($_POST['value']): "";
            $id = (isset($_POST['pk']) && !empty($_POST['pk'])) ? trim($_POST['pk']): "";
            if ($id != "" && $name != "") {
                $modelIO = MipositioningInputDevice::model()->findByPk($id);
                if ($name == 'io_name')
                    $modelIO->io_name = $value;
                if ($name == 'io_id')
                    $modelIO->io_id = $value;
                $modelIO->save();
            }
        }
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
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Positioning;
        $modelInput = new MipositioningInputDevice;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['ajax']) && $_POST['ajax']=='devices-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['Positioning']))
        {
            $model->attributes=$_POST['Positioning'];
            $model->comon_area = 1;
            $model->activity_timer = 0;
            $model->nurce_aknowege = 0;
            $model->call_duration = 0;
            $model->auto_test = 0;
            $model->id_access_number = 0;
            $model->type_access_number = '';
            $model->device_classification = 'mipositioning';
            //$model->id_room = 0;
            //$model->caller_id_internal = $model->caller_id_external = 0;
            //$model->caller_id_name = "24";
            if($model->save()) {
                if (isset($_POST['io'])){
                    foreach($_POST['io'] as $k) {
                        $ioModel = new MipositioningInputDevice;
                        $ioModel->io_id = $k['io_id'];
                        $ioModel->io_name = $k['io_name'];
                        $ioModel->id_device = $model->id_device;
                        $ioModel->save();
                    }
                }
                Yii::app()->user->setFlash('success',Yii::t('admin/devices','Added Device Successfuly'));
                $this->redirect(array('index'));
            } else {
                Yii::app()->user->setFlash('error',Yii::t('admin/devices','Please try again'));
            }
        }

        $this->render('create',array(
            'model'=>$model,
            'modelInput' => $modelInput
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
        $modelInput = MipositioningInputDevice::model()->findAllByAttributes(array('id_device'=>$id));

        if (isset($_POST['ajax']) && $_POST['ajax']=='devices-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        //$model->oldRoom = $model->id_room;
        if(isset($_POST['Positioning']))
        {
            $model->attributes=$_POST['Positioning'];
            $model->comon_area = 1;
            $model->device_classification = 'mipositioning';
            if($model->save()) {
                if (isset($_POST['io'])){
                    foreach($_POST['io'] as $k) {
                        $ioModel = new MipositioningInputDevice;
                        $ioModel->io_id = $k['io_id'];
                        $ioModel->io_name = $k['io_name'];
                        $ioModel->id_device = $model->id_device;
                        $ioModel->save();
                    }
                }
                $this->redirect(array('index'));
            }
        }

        $this->render('update',array(
            'model'=>$model,
            'modelInput' => $modelInput
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        Devices::model()->findByPk($id)->delete();
        Yii::app()->user->setFlash('success',Yii::t('admin/devices','Device Deleted Successfuly'));
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));

    }

    /**
     * Get All Floor of the selected building
     *
     * @return array of the floors for populate dropdown
     */
    public function actionFloorList(){
        $data=Maps::model()->findAll('id_building=:id_building',
            array(':id_building'=>(int) $_POST['id_building']));

        $data=CHtml::listData($data,'id_map','name_map');
        echo CHtml::tag('option',array('value' => ''),
            CHtml::encode(Yii::t('admin/devices', 'Select Floor')),true);
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }
    }

    /**
     * Get All Room of the selected floor
     *
     * @return array of the floors for populate dropdown
     */
    public function actionRoomList(){
        $data=Rooms::model()->findAll('id_map=:id_map',
            array(':id_map'=>(int) $_POST['id_map']));

        $data=CHtml::listData($data,'id_room','nb_room');
        echo CHtml::tag('option',array('value' => ''),
            CHtml::encode(Yii::t('admin/devices', 'Select Room')),true);
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Devices the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Positioning::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Rooms $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='devices-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAddPatient($id){
        //$model2 = new ResidentsOfRooms;
        //$model = $model2->model()->findByPk($id);

        $model=$this->loadModel($id);
        $status = 'nothing';
        echo $this->renderPartial('_addPatient_form', array('model'=>$model, 'status' => $status),true);
    }

    public function actionFloorInfo($id){
        if (!empty($id)){
            $data=Maps::model()->find('id_map=:id_map',
                array(':id_map'=>(int) $id));

            if (!empty($data->path_to_img)) {
                $str = '';
                $script = '<script>
                    $( "#devicePosition" ).draggable(
                        {
                            containment: "#roomConstruction", 
                            scroll: false,
                            stop: function() {
                                var pPlan = $("#roomConstruction").position();

                                var p = $( "#devicePosition" );
                                var position = p.position();
                                $("#coordinate_on_map").val((parseInt(position.left) - parseInt(pPlan.left))+";"+(parseInt(position.top) - parseInt(pPlan.top)));
                            }
                        }
                    );
                    //$( "#roomPosition" ).offset({top:10, left: 10});
                </script>
                ';

                //Yii::app()->clientScript->registerScript("dragScript",$script);
                list($width, $height, $type, $attr) = getimagesize(substr($data->path_to_img, 1));
                $str .= '<div id="roomConstruction" style="clear:both">';
                $str .= "<img src='".$data->path_to_img."' border=0 usemap='#roomPositionsMap' id='roomPositionsImg'/>";
                $str .= "<div id='devicePosition' class='btn btn-sm btn-danger draggable ui-widget-content'>&nbsp;&nbsp;</div>";
                $str .= '</div>';
                echo $str.$script;
            }

        } else echo "";
    }

    public function actionRoomCoordonate($id){
        if (!empty($id)){
            $data = Rooms::model()->findByPk($id);
            $str = "<map name='roomPositionsMap' id='roomPositionsMap'>";
            $str .= "<area id='".$data->nb_room."' class='droppable' shape='poly' coords='".$data->coordinate_on_map."' href='#'>";
            $str .= "</map>";

            echo $str;
        }
    }

    public function actionVerifySerialNumber(){
        $serial_number = (isset($_POST['SerialNumber']) && !empty($_POST['SerialNumber'])) ? $_POST['SerialNumber'] : "";
        if (!empty($serial_number)){
            $model = Devices::model()->find('serial_number=:serial_number', array(':serial_number'=>$serial_number));
            if(count($model)){
                echo "exist";
            } else {
                echo "no";
            }
        }
    }

    public function actionRemoveIODevice(){
        $id_input_device = (isset($_POST['id_io_device']) && !empty($_POST['id_io_device'])) ? $_POST['id_io_device'] : 0;
        $model = MipositioningInputDevice::model()->findByPk($id_input_device);
        if ($model->delete()){
            echo "yes";
        } else {
            echo "no";
        }

    }

}