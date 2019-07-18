<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 2/10/16
 * Time: 15:22
 */

defined('YII_DEBUG') or define('YII_DEBUG',true);

$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/console.php';
require_once($yii);

// creating and running console application
Yii::createConsoleApplication($configFile)->run();