<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'miALERT Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
	'import'=>array(
		'application.components.*',
		'application.modules.admin.models.*',
	),
	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=mialert',
			'emulatePrepare' => true,
            //'emulateParamLogging' => true,
			'username' => 'mialert',
			'password' => 'v3U5Qu9BQF',
			'charset' => 'utf8',
			'tablePrefix'=>'mia_',
		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
                    //'categories' => 'system.db.CDbCommand',
                    //'logFile' => 'db.log',
				),
				array(
					'class'=>'CEmailLogRoute',
					'levels'=>'error, warning',
					'emails'=>'iurie.albu@gmail.com',
				),
			),
		),
	),
);