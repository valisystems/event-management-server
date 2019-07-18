<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 4/22/16
 * Time: 12:22
 */
$this->breadcrumbs=array(
    'HTTP Inventory'=>array('index'),
    'Create',
);
?>

    <h1>Create HTTP Inventory</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>