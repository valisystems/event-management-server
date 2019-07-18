<?php

class DefaultController extends Controller
{
    public $layout = '/layouts/column1';
    
    public function init(){
        parent::init();
    }
    public function actionIndex()
	{
		$model = Buildings::model()->findAll();
        $this->render('index',array(
			'model'=>$model));
	}
    
    public function actionListFloor($id){
        if (Yii::app()->request->isAjaxRequest) {
            $model = Buildings::model()->with('maps')->findByPk($id);
            //$maps = $model->maps();
            
            echo $this->renderPartial('_viewfloors', array('model'=>$model),true, false);
        }
    }
    public function actionListDeviceByFloor($id){
        if (Yii::app()->request->isAjaxRequest) {
            $connection=Yii::app()->db;
            $cmd = $connection->createCommand();
            $row = $cmd->select('d.id_device, d.device_description, d.coordonate_on_map, ei.ext_number, d.position_popup, a.asterisk_url, d.device_classification')
            ->from('{{devices}} d')
            ->leftJoin('{{extension_info}} ei', 'ei.id_device = d.id_device')
            ->leftJoin('{{asterisk}} a', 'ei.id_asterisk = a.id_asterisk')
            ->where('d.id_map = :mapID', array(':mapID'=>$id))
            ->queryAll();
            $newArray = array();
            if (count($row)) {
                foreach($row as $k) {
                    if ($k['device_classification'] == 'mialert' && !empty($k['ext_number']))
                        $newArray[] = $k;
                    if ($k['device_classification'] == 'mipositioning')
                        $newArray[] = $k;
                }
            }
            $cmd->reset();
            $row2 = $cmd->select('d.id_maxivox_device as id_device, d.dev_desc AS device_description, d.position_popup, d.coordonate_on_map')
                ->from('{{maxivox_device}} d')
                ->where('d.id_map = :mapID', array(':mapID'=>$id))
                ->queryAll();
            //Yii::log(CVarDumper::dumpAsString(print_r($row2, true)),'error','app');
            if (count($row2)) {
                foreach($row2 as $l) {
                    $l['device_classification'] = 'maxivox';
                    $newArray[] = $l;
                }
            }
            header('Content-Type: application/json');
            echo json_encode($newArray);
        }
    }
}