<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 11/13/15
 * Time: 19:12
 */
$width = (!empty($model->iframe_width)) ? $model->iframe_width : '80%';
$width = ($model->iframe_width_mesure == '%') ? $width.$model->iframe_width_mesure : $width;
$height = (!empty($model->iframe_height)) ? $model->iframe_height : 600;
?>
<iframe src="<?php echo $model->url_custom_links; ?>" width="<?php echo $width;?>" height="<?php echo $height;?>" border='0'>
</iframe>