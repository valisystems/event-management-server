<?php
if (count($model)){
    foreach ($model->maps() as $k){
        echo CHtml::button($k->name_map, array('class'=>'btn btn-xs btn-success', 'onClick' => 'javascript:viewMaps(this)', 'id_map'=>$k->id_map, 'img_map' => $k->path_to_img,  'data-toggle'=>"Iura"))."&nbsp;&nbsp;";
    }
}
?>