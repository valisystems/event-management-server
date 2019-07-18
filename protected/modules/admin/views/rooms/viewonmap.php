<?php
/* @var $this RoomsController */
/* @var $model Rooms */

$this->breadcrumbs=array(
	'Rooms'=>array('index'),
	$model->id_room,
);

list($width, $height, $type, $attr) = getimagesize(substr($imgInfo->path_to_img, 1));
?>
<h1>View Rooms #<?php echo $model->nb_room; ?></h1>
<div class="row" id='roomConstruction'>
    <input type="hidden" name="coordinate_on_map" id="coordinate_on_map" value="<?php echo $model->coordinate_on_map;?>" disabled="disbaled"/>
            <?php
            $imgInfo = Maps::model()->findByPk($model->id_map);
            if (!empty($imgInfo->path_to_img)) {
                $left = $top = 10;
                if (!empty($model->coordinate_on_map)) {
                   //list($left, $top) = explode(';',$model->coordinate_on_map);
                }
                $str = '';
                $script = "<script>
                        $(document).ready(function(){
                            $('#coordinate_on_map').canvasAreaDraw({
                                imageUrl: '".Yii::app()->getRequest()->getHostInfo().$imgInfo->path_to_img."',
                                activePoint: false,
                                readOnly: true
                              });
                        });
                    </script>
                ";
                echo $script;
            }
            ?>
</div>
<br />
<div class="row buttons">
	<?php 
    echo CHtml::link( 'Back', array( 'index' ), array('class' => 'btn btn-primary',));
    ?>
</div>