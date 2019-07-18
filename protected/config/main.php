<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
//Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'miALERT',
    'sourceLanguage' => 'en',
    'language' => 'en',
    'defaultController'=>'site/login',

	// preloading 'log' component
	'preload'=>array('log'),
	'timeZone' => 'America/Toronto',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'ext.YiiMailer.YiiMailer',
        'application.vendor.phpexcel.PHPExcel',
        'ext.yiireport.*',
        //'application.vendor.phpexcel.PHPExcel',
	),
	//'theme'=>'bootstrap',
	'modules'=>array(
		'gii'=>array(
            'generatorPaths'=>array(
                'bootstrap.gii',
			),
			'class'=>'system.gii.GiiModule',
			'password'=>'damian4ik21',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1','192.168.2.112','172.17.0.11','89.28.118.138', '192.168.1.*'),
		),
		'admin',
        'api',
        'livepanel'
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
            'class' => 'WebUser',
            'loginUrl'=>'site/login'
		),
        'authManager' => array(
            // We will use your login manager
            'class' => 'PhpAuthManager',
            // Default role. All who are not administrators, moderators and nick - guests.
            'defaultRoles' => array('guest'),
            'connectionID'=>'db',
        ),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
        'vodia' => array(
            'class' => 'VodiaRest'
        ),
		'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
        'curl' => array(
            'class' => 'ext.curl.Curl',
            'options' => array(),
        ),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=mialert',
			'emulatePrepare' => true,
            //'emulateParamLogging' => true,
			'username' => 'mialert',
			'password' => 'v3U5Qu9BQF',
			'charset' => 'utf8',
			'tablePrefix'=>'mia_',
		),
        'dbcdr'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=asteriskcdrdb',
            'emulatePrepare' => true,
            //'emulateParamLogging' => true,
            'username' => 'freepbxuser',
            'password' => 'SybM85s56Aqt',
            'charset' => 'utf8',
            'class' => 'CDbConnection'
        ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
                    'enabled'=>true
                    //'categories' => 'system.db.CDbCommand',
                    //'logFile' => 'db.log',
				),
				array(
					'class'=>'CEmailLogRoute',
					'levels'=>'error, warning, info, profile',
					'emails'=>'iurie.albu@gmail.com',
                    'except'=>'system.CModule.*'
                    //'categories'=>'system.*',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
        'ePdf' => array(
            'class'         => 'ext.yii-pdf.EYiiPdf',
            'params'        => array(
                'mpdf'     => array(
                    'librarySourcePath' => 'application.vendor.mpdf.*',
                    'constants'         => array(
                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                    ),
                    'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
                    'defaultParams'     => array(
                        'format' => 'Letter',
                    )
                    /*'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                        'mode'              => '', //  This parameter specifies the mode of the new document.
                        'format'            => 'A4', // format A4, A5, ...
                        'default_font_size' => 0, // Sets the default document font size in points (pt)
                        'default_font'      => '', // Sets the default font-family for the new document.
                        'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                        'mgr'               => 15, // margin_right
                        'mgt'               => 16, // margin_top
                        'mgb'               => 16, // margin_bottom
                        'mgh'               => 9, // margin_header
                        'mgf'               => 9, // margin_footer
                        'orientation'       => 'P', // landscape or portrait orientation
                    )*/
                ),
                'HTML2PDF' => array(
                    'librarySourcePath' => 'application.vendor.html2pdf.*',
                    'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
                    'defaultParams'     => array(
                        'format' => 'Letter',
                    )
                    /*'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                        'orientation' => 'P', // landscape or portrait orientation
                        'format'      => 'A4', // format A4, A5, ...
                        'language'    => 'en', // language: fr, en, it ...
                        'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                        'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                        'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                    )*/
                )
            ),
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'iurie.albu@gmail.com',
        'languages'=>array(
            'en'=>'English',
            'fr'=>'French',
            'ro'=>'Romana'
        ),
        'tts_voice'=>array(
            'w'=>'Women',
            'm'=>'Men',
        ),
        'pick_event_type' => array(
            'SMS' => 'SMS',
            'EMAIL' => 'E-mail',
            'VOIP' => 'Voice',
            'TRANSFER' => 'Transfer Call',
            'CAMERA' => 'Camera',
            'IOPOS' => 'I/O Positioning',
            'HTTP' => 'HTTP Action'
        ),
        'event_type' => array(
            'template' => 'From Template (Global)',
            'custom' => Yii::t('admin/rooms','Custom (Specific)'),
        ),
        'mail_security'=>array(
            ''=>'None',
            'ssl'=>'SSL',
            'tls'=>'TLS',
        ),
        'pattern' => array(
            '%%BUILDING%%' => 'Building',
            '%%FLOOR%%' => 'Floor',
            '%%ROOM%%' => 'Room',
            '%%PATIENT%%' => 'Patient',
            '%%RESPONSIBLE%%' => 'Responsible Person'
        ),
        'device_type' => array(
            'button' => 'Button',
            'phone' => 'Phone',
            'camera' => 'Camera'
        ),
        'devicePosition' => array(
            'left' => "On Left",
            'top' => "On Top",
            'right' => "On Right",
            'bottom' => "On Bottom",
            'topleft' => "Top Left",
            'topright' => "Top Right",
            'bottomleft' => "Bottom Left",
            'bottomright' => "Bottom Right",
        ),
        'asterConf' => array(
            'host' => 'localhost', // AGI HOST 
        	'user' => 'livepanel',  // AGI User
        	'pass' => '1234567' // AGI Password
        ),
        'amp_conf' => array(
            'AMPDBUSER'	=> 'freepbxuser',
            'AMPDBPASS'	=> 'SybM85s56Aqt',
            'AMPDBHOST'	=> 'localhost',
            'AMPDBNAME'	=> 'asterisk',
            'AMPDBENGINE' => 'mysql',
            'datasource'	=> '' //for sqlite3
        ),
        'authorizedIP' => array(
            '192.168.1.71',
            '192.168.1.66',
            '172.17.0.11'
        ),
        'link_target' => array(
            'blank' => 'New Window',
            'self' => 'Inside Iframe',
            'parent' => 'Popup Iframe',
        ),
        'location_links' => array(
            'local' => 'Local Link',
            'external' => 'External Link'
        )

        
	),
    
);