<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php echo CHtml::encode(Yii::app()->session['siteInfo']['site_name']); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
    <!--link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/style.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/retina.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/bootstrap-toggle.min.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/mialert.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/print.css" rel="stylesheet" type="text/css" media="print"/-->
	<!-- end: CSS -->
	

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/respond.min.js"></script>
		
	<![endif]-->
	
	<!-- start: Favicon and Touch Icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/ico/favicon.png">
	<!-- end: Favicon and Touch Icons -->	

	
</head>

<body>
<?php
//print_r(Yii::app()->session['siteInfo']);
?>
<div class="pl">
    <div class="round anti"></div>
</div>
    <!-- start: Header -->
	<header class="navbar">
		<div class="container">
			<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".sidebar-nav.nav-collapse">
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			</button>
			<a id="main-menu-toggle" class="hidden-xs open"><i class="fa fa-bars"></i></a>		
			<?php
                if (Yii::app()->session['siteInfo']['logo_path'] != "") {
                    ?>
                        <a class="navbar-brand col-md-2 col-sm-1 col-xs-2" href="<?php echo Yii::app()->request->baseUrl;?>/admin">
                        <?php
                        echo CHtml::image(Yii::app()->request->baseUrl.Yii::app()->session['siteInfo']['logo_path'],Yii::app()->session['siteInfo']['site_name'],
                                                array(
                                                'height'=>"35",
                                                'class'=>"",
                                                ));
                        ?>
                        </a>                    
                    <?php
                } else {
            ?>
            <a class="navbar-brand col-md-2 col-sm-1 col-xs-2" href="<?php echo Yii::app()->request->baseUrl;?>/admin"><span><?php echo CHtml::encode(Yii::app()->name); ?></span></a>
			<?php }?>
            <!-- start: Header Menu -->
			<div class="nav-no-collapse header-nav" id="headStatusBar">
                <div class="manageHeader"><?php echo Yii::app()->session['siteInfo']['header'];?></div>
			</div>
			<!-- end: Header Menu -->
			
		</div>	
	</header>
	<!-- end: Header -->

		<div class="container">
		<div class="row">
				
			<!-- start: Main Menu -->
			<div id="sidebar-left" class="col-lg-2 col-sm-1 ">
								
				<div class="sidebar-nav nav-collapse collapse navbar-collapse">
                    <?php
                    //print_r($this->userRules);
                    $menuContent = array();

                    if ($this->verifyArrayIfExist('admin/setting', $this->userRules)
                        || $this->verifyArrayIfExist('admin/delivery', $this->userRules)
                        || $this->verifyArrayIfExist('admin/func', $this->userRules)
                        || $this->verifyArrayIfExist('admin/buildings', $this->userRules)
                        || $this->verifyArrayIfExist('admin/asterisk', $this->userRules)
                        || $this->verifyArrayIfExist('admin/customLinks', $this->userRules)
                    ) {
                        array_push($menuContent,
                            array(
                                'label'=>'<i class="fa fa-cog"></i><span class="hidden-sm text">'.Yii::t('admin/index','Setup').'</span><span class="chevron closed"></span>',
                                'url'=>'#',
                                'linkOptions'=>array('class'=>'dropmenu'),
                                'items'=> array(
                                    array(
                                        'label'=>'<i class="fa fa-gears"></i><span class="hidden-sm text">'.Yii::t('admin/index','Appearance').'</span>',
                                        'url'=>'/admin/setting',
                                        'visible'=>in_array(substr('/admin/setting',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-cloud"></i><span class="hidden-sm text">'.Yii::t('admin/index','Messaging').'</span>',
                                        'url'=>array('/admin/delivery'),
                                        'visible'=>in_array(substr('/admin/delivery',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-asterisk"></i><span class="hidden-sm text">'.Yii::t('admin/index','Calling Numbers').'</span>',
                                        'url'=>array('/admin/func'),
                                        'visible'=>in_array(substr('/admin/func',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-building-o"></i><span class="hidden-sm text">'.Yii::t('admin/index','Site / Facility').'</span>',
                                        'url'=>array('/admin/buildings'),
                                        'visible'=>in_array(substr('/admin/buildings',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-hospital-o"></i><span class="hidden-sm text">'.Yii::t('admin/index','Nodes').'</span>',
                                        'url'=>array('/admin/asterisk'),
                                        'visible'=>in_array(substr('/admin/asterisk',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-link"></i><span class="hidden-sm text">'.Yii::t('admin/index','Custom Links').'</span>',
                                        'url'=>array('/admin/customLinks'),
                                        'visible'=>in_array(substr('/admin/customLinks',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-link"></i><span class="hidden-sm text">'.Yii::t('admin/index','Update EMS').'</span>',
                                        'url'=>array('/admin/updateEms'),
                                        'visible'=>in_array(substr('/admin/updateEms',1), $this->userRules)
                                    )
                                )
                            )
                        );
                    }
                    if ( $this->verifyArrayIfExist('admin/vodiaManage', $this->userRules) ) {
                        array_push($menuContent,
                            array(
                                'label'=>'<i class="fa fa-cog"></i><span class="hidden-sm text">'.Yii::t('admin/index','Vodia Manage').'</span><span class="chevron closed"></span>',
                                'url'=>'#',
                                'linkOptions'=>array('class'=>'dropmenu'),
                                'items'=> array(
                                    array(
                                        'label'=>'<i class="fa fa-gears"></i><span class="hidden-sm text">'.Yii::t('admin/index','Vodia Serevrs').'</span>',
                                        'url'=>'/admin/vodiaManage',
                                        'visible'=>in_array(substr('/admin/vodiaManage',1), $this->userRules)
                                    ),

                                )
                            )
                        );
                    }
                    array_push($menuContent, array(
                        'label'=>'<i class="fa fa-bed"></i><span class="hidden-sm text">'.Yii::t('admin/index','Rooms').'</span>',
                        'url'=>array('/admin/rooms'),
                        'visible'=>in_array(substr('/admin/rooms',1), $this->userRules)
                    ));
                    if ( $this->verifyArrayIfExist('admin/staff', $this->userRules) ) {
                        array_push($menuContent, array(
                            'label'=>'<i class="fa fa-cog"></i><span class="hidden-sm text">'.Yii::t('admin/index','Staff Settings').'</span><span class="chevron closed"></span>',
                            'url'=>'#',
                            'linkOptions'=>array('class'=>'dropmenu'),
                            'items'=> array(
                                array(
                                    'label' => '<i class="fa fa-bed"></i><span class="hidden-sm text">' . Yii::t('admin/index', 'Staff') . '</span>',
                                    'url' => array('/admin/staff'),
                                    'visible' => in_array(substr('/admin/staff', 1), $this->userRules)
                                ),
                                array(
                                    'label' => '<i class="fa fa-bed"></i><span class="hidden-sm text">' . Yii::t('admin/index', 'Staff Working Info') . '</span>',
                                    'url' => array('/admin/staffWorking'),
                                    'visible' => in_array(substr('/admin/staff', 1), $this->userRules)
                                ),
                            )
                        ));
                    }
                    array_push($menuContent, array(
                        'label'=>'<i class="fa fa-bed"></i><span class="hidden-sm text">'.Yii::t('admin/index','Extension Inventory').'</span>',
                        'url'=>array('/admin/extensionInventory'),
                        'visible'=>in_array(substr('/admin/extensionInventory',1), $this->userRules)
                    ));
                    if ( $this->verifyArrayIfExist('admin/devices', $this->userRules) || $this->verifyArrayIfExist('admin/maxivoxDevice', $this->userRules) ) {
                        array_push($menuContent,array(
                            'label'=>'<i class="fa fa-dashboard"></i><span class="hidden-sm text">'.Yii::t('admin/index','Equipment').'</span><span class="chevron closed"></span>',
                            'url'=>'#',
                            'linkOptions'=>array('class'=>'dropmenu'),
                            'items'=> array(
                                array(
                                    'label'=>'<i class="fa fa-list-alt"></i><span class="hidden-sm text">'.Yii::t('admin/index','EMS devices').'</span>',
                                    'url'=>array('/admin/devices'),
                                    'visible'=>in_array(substr('/admin/devices',1), $this->userRules)
                                ),

                                array(
                                    'label'=>'<i class="fa fa-forumbee"></i><span class="hidden-sm text">'.Yii::t('admin/index','Positioning devices').'</span>',
                                    'url'=>array('/admin/positioning'),
                                    'visible'=>in_array(substr('/admin/positioning',1), $this->userRules)
                                ),
                                array(
                                    'label'=>'<i class="fa fa-unlink"></i><span class="hidden-sm text">'.Yii::t('admin/index','Pendant Devices').'</span>',
                                    'url'=>array('/admin/pendantDevices'),
                                    'visible'=>in_array(substr('/admin/pendantDevices',1), $this->userRules)
                                ),
                                array(
                                    'label'=>'<i class="fa fa-unlink"></i><span class="hidden-sm text">'.Yii::t('admin/index','Maxivox Devices').'</span>',
                                    'url'=>array('/admin/maxivoxDevice'),
                                    'visible'=>in_array(substr('/admin/maxivoxDevice',1), $this->userRules)
                                ),
                                array(
                                    'label'=>'<i class="fa fa-tty"></i><span class="hidden-sm text">'.Yii::t('admin/index','PBX').'</span>',
                                    'url'=>'/pbxadmin/config.php',
                                    //'visible'=>in_array(substr('/admin/setting',1), $this->userRules)
                                ),
                            )
                        ));
                    }
                    array_push($menuContent, array(
                            'label'=>'<i class="fa fa-wheelchair"></i><span class="hidden-sm text">'.Yii::t('admin/index','Patients').'</span>',
                            'url'=>array('/admin/patients'),
                            'visible'=>in_array(substr('/admin/patients',1), $this->userRules),
                        )
                    );
                    array_push($menuContent,
                        array(
                            'label'=>'<i class="fa fa-cog"></i><span class="hidden-sm text">'.Yii::t('admin/index','Events').'</span><span class="chevron closed"></span>',
                            'url'=>'#',
                            'linkOptions'=>array('class'=>'dropmenu'),
                            'items'=> array(
                                array(
                                    'label'=>'<i class="fa fa-list-alt"></i><span class="hidden-sm text">'.Yii::t('admin/index','EMS events').'</span>',
                                    'url'=>array('/admin/events'),
                                    'visible'=>in_array(substr('/admin/events',1), $this->userRules)
                                ),
                                array(
                                    'label'=>'<i class="fa fa-list-alt"></i><span class="hidden-sm text">'.Yii::t('admin/index','miPositioning events').'</span>',
                                    'url'=>array('/admin/eventsPendant'),
                                    'visible'=>in_array(substr('/admin/eventsPendant',1), $this->userRules)
                                ),
                                array(
                                    'label'=>'<i class="fa fa-list-alt"></i><span class="hidden-sm text">'.Yii::t('admin/index','MaxiVox events').'</span>',
                                    'url'=>array('/admin/eventsMaxivox'),
                                    'visible'=>in_array(substr('/admin/eventsMaxivox',1), $this->userRules)
                                )
                            )
                        )
                    );

                    if ( $this->verifyArrayIfExist('admin/reports', $this->userRules) || $this->verifyArrayIfExist('admin/export', $this->userRules)) {
                        array_push($menuContent, array(
                            'label'=>'<i class="fa fa-bar-chart-o"></i><span class="hidden-sm text">'.Yii::t('admin/index','Reports').'</span><span class="chevron closed"></span>',
                            'url'=>'#',
                            'linkOptions'=>array('class'=>'dropmenu'),
                            'items'=> array(
                                array(
                                    'label'=>'<i class="fa fa-phone"></i><span class="hidden-sm text">'.Yii::t('admin/index','CDR').'</span>',
                                    'url'=>array('/admin/cdr'),
                                    //'visible'=>in_array(substr('/admin/cdr',1), $this->userRules)
                                ),
                                array(
                                    'label'=>'<i class="fa fa-phone"></i><span class="hidden-sm text">'.Yii::t('admin/index','Vodia CDR').'</span>',
                                    'url'=>array('/admin/vodiaCdr'),
                                    //'visible'=>in_array(substr('/admin/cdr',1), $this->userRules)
                                ),
                                array(
                                    'label'=>'<i class="fa fa-tasks"></i><span class="hidden-sm text">'.Yii::t('admin/index','Reports').'</span>',
                                    'url'=>array('/admin/reports'),
                                    'visible'=>in_array(substr('/admin/reports',1), $this->userRules)
                                ),
                                array(
                                    'label'=>'<i class="fa fa-tasks"></i><span class="hidden-sm text">'.Yii::t('admin/index','Event Reports').'</span>',
                                    'url'=>array('/admin/eventsReports'),
                                    'visible'=>in_array(substr('/admin/eventsReports',1), $this->userRules)
                                ),
                                array(
                                    'label'=>'<i class="fa fa-tasks"></i><span class="hidden-sm text">'.Yii::t('admin/index','Event Pendant Reports').'</span>',
                                    'url'=>array('/admin/eventsPendantReports'),
                                    'visible'=>in_array(substr('/admin/eventsPendantReports',1), $this->userRules)
                                ),
                                array(
                                    'label'=>'<i class="fa fa-tasks"></i><span class="hidden-sm text">'.Yii::t('admin/index','Event MaxiVox Reports').'</span>',
                                    'url'=>array('/admin/eventsMaxivoxReports'),
                                    'visible'=>in_array(substr('/admin/eventsMaxivoxReports',1), $this->userRules)
                                ),
                                array(
                                    'label'=>'<i class="fa fa-upload"></i><span class="hidden-sm text">'.Yii::t('admin/index','Export').'</span>',
                                    'url'=>array('/admin/export'),
                                    'visible'=>in_array(substr('/admin/export',1), $this->userRules)
                                ),
                            )
                        ));
                    }
                    if (
                        $this->verifyArrayIfExist('admin/callsType', $this->userRules)
                        || $this->verifyArrayIfExist('admin/pendantType', $this->userRules)
                        || $this->verifyArrayIfExist('admin/maxivoxType', $this->userRules)
                        || $this->verifyArrayIfExist('admin/globalMessages', $this->userRules)
                        || $this->verifyArrayIfExist('admin/systemNotice', $this->userRules)
                        || $this->verifyArrayIfExist('admin/systemVoiceNumber', $this->userRules)
                        || $this->verifyArrayIfExist('admin/systemSmsNumbers', $this->userRules)
                        || $this->verifyArrayIfExist('admin/systemEmail', $this->userRules)
                        || $this->verifyArrayIfExist('admin/notificationSettings', $this->userRules)
                        || $this->verifyArrayIfExist('admin/globalEventTemplate', $this->userRules)
                        || $this->verifyArrayIfExist('admin/globalEventPendantTemplate', $this->userRules)
                        || $this->verifyArrayIfExist('admin/globalEventMaxivoxTemplate', $this->userRules)
                        || $this->verifyArrayIfExist('admin/command', $this->userRules)
                        || $this->verifyArrayIfExist('admin/httpInventory', $this->userRules)
                    ) {
                        array_push($menuContent, array(
                                'label'=>'<i class="fa fa-sliders"></i><span class="hidden-sm text">'.Yii::t('admin/index','NCS Settings').'</span><span class="chevron closed"></span>',
                                'url'=>'#',
                                'linkOptions'=>array('class'=>'dropmenu'),
                                'items'=> array(
                                    array(
                                        'label'=>'<i class="fa fa-barcode"></i><span class="hidden-sm text">'.Yii::t('admin/index','Commands').'</span>',
                                        'url'=>'/admin/command',
                                        'visible'=>in_array(substr('/admin/command',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-barcode"></i><span class="hidden-sm text">'.Yii::t('admin/index','HTTP Inventory').'</span>',
                                        'url'=>'/admin/httpInventory',
                                        'visible'=>in_array(substr('/admin/httpInventory',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-barcode"></i><span class="hidden-sm text">'.Yii::t('admin/index','Call Types').'</span>',
                                        'url'=>'/admin/callsType',
                                        'visible'=>in_array(substr('/admin/callsType',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-ticket"></i><span class="hidden-sm text">'.Yii::t('admin/index','Pendant Types').'</span>',
                                        'url'=>'/admin/pendantType',
                                        'visible'=>in_array(substr('/admin/pendantType',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-ticket"></i><span class="hidden-sm text">'.Yii::t('admin/index','MaxiVox Types').'</span>',
                                        'url'=>'/admin/maxivoxType',
                                        'visible'=>in_array(substr('/admin/maxivoxType',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-tasks"></i><span class="hidden-sm text">'.Yii::t('admin/index','System Messages').'</span>',
                                        'url'=>'/admin/globalMessages',
                                        'visible'=>in_array(substr('/admin/globalMessages',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-edit"></i><span class="hidden-sm text">'.Yii::t('admin/index','System Notices').'</span>',
                                        'url'=>'/admin/systemNotice',
                                        'visible'=>in_array(substr('/admin/systemNotice',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-phone"></i><span class="hidden-sm text">'.Yii::t('admin/index','System Voice Numbers').'</span>',
                                        'url'=>'/admin/systemVoiceNumber',
                                        'visible'=>in_array(substr('/admin/systemVoiceNumber',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-comments-o"></i><span class="hidden-sm text">'.Yii::t('admin/index','System SMS Numbers').'</span>',
                                        'url'=>'/admin/systemSmsNumbers',
                                        'visible'=>in_array(substr('/admin/systemSmsNumbers',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-envelope"></i><span class="hidden-sm text">'.Yii::t('admin/index','System Emails').'</span>',
                                        'url'=>'/admin/systemEmail',
                                        'visible'=>in_array(substr('/admin/systemEmail',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-camera"></i><span class="hidden-sm text">'.Yii::t('admin/index','System Cameras').'</span>',
                                        'url'=>'/admin/systemCameras',
                                        'visible'=>in_array(substr('/admin/systemCameras',1), $this->userRules)
                                    ),
                                    /*array(
                                        'label'=>'<i class="fa fa-upload"></i><span class="hidden-sm text">'.Yii::t('admin/index','Notification Settings').'</span>',
                                        'url'=>'/admin/notificationSettings',
                                        'visible'=>in_array(substr('/admin/notificationSettings',1), $this->userRules)
                                    ),*/
                                    array(
                                        'label'=>'<i class="fa fa-upload"></i><span class="hidden-sm text">'.Yii::t('admin/index','Global Events').'</span>',
                                        'url'=>'/admin/globalEventTemplate',
                                        'visible'=>in_array(substr('/admin/globalEventTemplate',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-upload"></i><span class="hidden-sm text">'.Yii::t('admin/index','Global Events Pendant').'</span>',
                                        'url'=>'/admin/globalEventPendantTemplate',
                                        'visible'=>in_array(substr('/admin/globalEventPendantTemplate',1), $this->userRules)
                                    ),
                                    array(
                                        'label'=>'<i class="fa fa-upload"></i><span class="hidden-sm text">'.Yii::t('admin/index','Global Events MaxiVox').'</span>',
                                        'url'=>'/admin/globalEventMaxivoxTemplate',
                                        'visible'=>in_array(substr('/admin/globalEventMaxivoxTemplate',1), $this->userRules)
                                    ),
                                )
                            )
                        );
                    }

                    if(!empty($this->customLinks)) {
                        $tmpArrayCust = array();
                        foreach ($this->customLinks as $vcl => $cl) {
                            if ($cl['location'] == 'external'){
                                $target = "";
                                $url = $cl['url'];
                                if ($cl['target'] == 'parent'){
                                    $target = array("onClick"=>"createModalLinkContent('".$cl['url']."', '".$cl['desc']."')");
                                    $url = "#";
                                } else if($cl['target'] == 'self'){
                                    $url = array('/admin/default/customLinks/id/'.$vcl);
                                }

                                array_push($tmpArrayCust,
                                    array(
                                        'label'=>'<i class="fa fa fa-cog"></i><span class="hidden-sm text">'.$cl['desc'].'</span>',
                                        'url'=>$url,
                                        'linkOptions'=>$target,
                                        'visible'=>true
                                    )
                                );
                            } else {
                                array_push($tmpArrayCust,
                                    array(
                                        'label'=>'<i class="fa fa fa-cog"></i><span class="hidden-sm text">'.$cl['desc'].'</span>',
                                        'url'=>$cl['url'],
                                        //'linkOptions'=>array('target'=>Yii::app()->params['link_target'][$cl['target']]),
                                        'visible'=>true
                                    )
                                );
                            }
                        }

                        array_push($menuContent, array(
                                'label'=>'<i class="fa fa-sliders"></i><span class="hidden-sm text">'.Yii::t('admin/index','Custom Links').'</span><span class="chevron closed"></span>',
                                'url'=>'#',
                                'linkOptions'=>array('class'=>'dropmenu'),
                                'items'=> $tmpArrayCust
                            )
                        );
                    }

                    /**
                     * Custom Links
                     */


                    /**
                     * End Custom Links
                     */

                    array_push($menuContent, array(
                        'label'=>'<i class="fa fa-male"></i><span class="hidden-sm text">'.Yii::t('admin/index','Users').'</span>',
                        'url'=>array('/admin/users'),
                        'visible'=>in_array(substr('/admin/users',1), $this->userRules)
                    ));
                    array_push($menuContent, array(
                        'label'=>'<i class="fa fa-desktop"></i><span class="hidden-sm text">'.Yii::t('admin/index','Live Panel').'</span>',
                        'url'=>array('/livepanel/default'),
                        'visible'=>in_array(substr('/livepanel/default',1), $this->userRules)
                    ));
                    array_push($menuContent, array(
                        'label'=>'<i class="fa fa-power-off"></i><span class="hidden-sm text">'.Yii::t('admin/index','Logout').'( '.Yii::app()->user->name.' )'.'</span>',
                        'url'=>array('/site/logout'),
                        'visible'=>true
                    )    );

                    //print_r($menuContent);
                    ?>
                <?php $this->widget('zii.widgets.CMenu',array(
                            'htmlOptions' => array( 'class' => 'nav main-menu'),
                            'encodeLabel' => false,
                            'items'=> $menuContent
                        )
                    );
//                        array(
//                        array(
//                            'label'=>'<i class="fa fa-eye"></i><span class="hidden-sm text">'.Yii::t('admin/index','Setup').'</span><span class="chevron closed"></span>',
//                            'url'=>'#',
//                            'linkOptions'=>array('class'=>'dropmenu'),
//                            'items'=> array(
//                                array(
//                                    'label'=>'<i class="fa fa-gears"></i><span class="hidden-sm text">'.Yii::t('admin/index','Appearance').'</span>',
//                                    'url'=>'/admin/setting',
//                                    'visible'=>in_array(substr('/admin/setting',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-cloud"></i><span class="hidden-sm text">'.Yii::t('admin/index','Messaging').'</span>',
//                                    'url'=>array('/admin/delivery'),
//                                    'visible'=>in_array(substr('/admin/delivery',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-asterisk"></i><span class="hidden-sm text">'.Yii::t('admin/index','Calling Numbers').'</span>',
//                                    'url'=>array('/admin/func'),
//                                    'visible'=>in_array(substr('/admin/func',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-building-o"></i><span class="hidden-sm text">'.Yii::t('admin/index','Site / Facility').'</span>',
//                                    'url'=>array('/admin/buildings'),
//                                    'visible'=>in_array(substr('/admin/buildings',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-hospital-o"></i><span class="hidden-sm text">'.Yii::t('admin/index','Nodes').'</span>',
//                                    'url'=>array('/admin/asterisk'),
//                                    'visible'=>in_array(substr('/admin/asterisk',1), $this->userRules)
//                                ),
//                            )
//                        ),
//                        array(
//                            'label'=>'<i class="fa fa-puzzle-piece"></i><span class="hidden-sm text">'.Yii::t('admin/index','Rooms').'</span>',
//                            'url'=>array('/admin/rooms'),
//                            'visible'=>in_array(substr('/admin/rooms',1), $this->userRules)
//                        ),
//                        array(
//                            'label'=>'<i class="fa fa-dashboard"></i><span class="hidden-sm text">'.Yii::t('admin/index','Equipment').'</span><span class="chevron closed"></span>',
//                            'url'=>'#',
//                            'linkOptions'=>array('class'=>'dropmenu'),
//                            'items'=> array(
//                                array(
//                                    'label'=>'<i class="fa fa-user-md"></i><span class="hidden-sm text">'.Yii::t('admin/index','EMS devices').'</span>',
//                                    'url'=>array('/admin/devices'),
//                                    'visible'=>in_array(substr('/admin/devices',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-wrench"></i><span class="hidden-sm text">'.Yii::t('admin/index','PBX').'</span>',
//                                    'url'=>'#',
//                                    //'visible'=>in_array(substr('/admin/setting',1), $this->userRules)
//                                ),
//                            )
//                        ),
//                        array(
//                            'label'=>'<i class="fa fa-wheelchair"></i><span class="hidden-sm text">'.Yii::t('admin/index','Patients').'</span>',
//                            'url'=>array('/admin/patients'),
//                            'visible'=>in_array(substr('/admin/patients',1), $this->userRules)
//                        ),
//                        array(
//                            'label'=>'<i class="fa fa-bar-chart-o"></i><span class="hidden-sm text">'.Yii::t('admin/index','Reports').'</span><span class="chevron closed"></span>',
//                            'url'=>'#',
//                            'linkOptions'=>array('class'=>'dropmenu'),
//                            'items'=> array(
//                                array(
//                                    'label'=>'<i class="fa fa-phone"></i><span class="hidden-sm text">'.Yii::t('admin/index','CDR').'</span>',
//                                    'url'=>'#',
//                                    //'visible'=>in_array(substr('/admin/cdr',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-tasks"></i><span class="hidden-sm text">'.Yii::t('admin/index','Reports').'</span>',
//                                    'url'=>array('/admin/reports'),
//                                    'visible'=>in_array(substr('/admin/reports',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-upload"></i><span class="hidden-sm text">'.Yii::t('admin/index','Export').'</span>',
//                                    'url'=>array('/admin/export'),
//                                    'visible'=>in_array(substr('/admin/export',1), $this->userRules)
//                                ),
//                            )
//                        ),
//                        array(
//                            'label'=>'<i class="fa fa-bar-chart-o"></i><span class="hidden-sm text">'.Yii::t('admin/index','NCS Settings').'</span><span class="chevron closed"></span>',
//                            'url'=>'#',
//                            'linkOptions'=>array('class'=>'dropmenu'),
//                            'items'=> array(
//                                array(
//                                    'label'=>'<i class="fa fa-phone"></i><span class="hidden-sm text">'.Yii::t('admin/index','Call Types').'</span>',
//                                    'url'=>'/admin/callsType',
//                                    'visible'=>in_array(substr('/admin/callsType',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-tasks"></i><span class="hidden-sm text">'.Yii::t('admin/index','System Messages').'</span>',
//                                    'url'=>'/admin/globalMessages',
//                                    'visible'=>in_array(substr('/admin/globalMessages',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-upload"></i><span class="hidden-sm text">'.Yii::t('admin/index','System Notices').'</span>',
//                                    'url'=>'/admin/systemNotice',
//                                    'visible'=>in_array(substr('/admin/systemNotice',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-upload"></i><span class="hidden-sm text">'.Yii::t('admin/index','System Voice Numbers').'</span>',
//                                    'url'=>'/admin/systemVoiceNumber',
//                                    'visible'=>in_array(substr('/admin/systemVoiceNumber',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-upload"></i><span class="hidden-sm text">'.Yii::t('admin/index','System SMS Numbers').'</span>',
//                                    'url'=>'/admin/systemSmsNumbers',
//                                    'visible'=>in_array(substr('/admin/systemSmsNumbers',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-upload"></i><span class="hidden-sm text">'.Yii::t('admin/index','System Emails').'</span>',
//                                    'url'=>'/admin/systemEmail',
//                                    'visible'=>in_array(substr('/admin/systemEmail',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-upload"></i><span class="hidden-sm text">'.Yii::t('admin/index','Notification Settings').'</span>',
//                                    'url'=>'/admin/notificationSettings',
//                                    'visible'=>in_array(substr('/admin/notificationSettings',1), $this->userRules)
//                                ),
//                                array(
//                                    'label'=>'<i class="fa fa-upload"></i><span class="hidden-sm text">'.Yii::t('admin/index','Global Events').'</span>',
//                                    'url'=>'/admin/globalEventTemplate',
//                                    'visible'=>in_array(substr('/admin/globalEventTemplate',1), $this->userRules)
//                                ),
//                            )
//                        ),
//                        array(
//                            'label'=>'<i class="fa fa-male"></i><span class="hidden-sm text">'.Yii::t('admin/index','Users').'</span>',
//                            'url'=>array('/admin/users'),
//                            'visible'=>in_array(substr('/admin/users',1), $this->userRules)
//                        ),
//                        array(
//                            'label'=>'<i class="fa fa-male"></i><span class="hidden-sm text">'.Yii::t('admin/index','Live Panel').'</span>',
//                            'url'=>array('/livepanel/default'),
//                            'visible'=>in_array(substr('/livepanel/default',1), $this->userRules)
//                        ),
//                        array(
//                            'label'=>'<i class="fa fa-power-off"></i><span class="hidden-sm text">'.Yii::t('admin/index','Logout').'( '.Yii::app()->user->name.' )'.'</span>',
//                            'url'=>array('/site/logout'),
//                            //'visible'=>in_array(substr('/admin/export',1), $this->userRules)
//                        ),
//                    ),
                 ?>
				</div>
				<a href="#" id="main-menu-min" class="full visible-md visible-lg"><i class="fa fa-angle-double-left"></i></a>
			</div>
			<!-- end: Main Menu -->
						
			<!-- start: Content -->
			<div id="content" class="col-lg-10 col-sm-11 ">
            <ol class="breadcrumb">
                	<?php if(isset($this->breadcrumbs)):?>
                		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
                			'links'=>$this->breadcrumbs,
                		)); ?><!-- breadcrumbs -->
                	<?php endif?>
            </ol>
			<?php echo $content; ?>
			</div>
			<!-- end: Content -->
				
				</div><!--/row-->		
		
	</div><!--/container-->
	
	
	<div class="modal fade" id="myModal" tabindex="-1" data-target=".bs-example-modal-lg">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Modal title</h4>
				</div>
				<div class="modal-body">
					<iframe height="600" width="100%" src=""></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<div class="clearfix"></div>
	
	<footer>
		
		<div class="row">
			
			<div class="col-sm-2">
				&copy; 2014 Claricom Solutions. <a href="http://claricom.ca">miALERT</a>
			</div><!--/.col-->
			<div class="col-sm-5 text-left hidden-xs">
                <?php echo Yii::app()->session['siteInfo']['footer'];?>
            </div>
			<!--div class="col-sm-7 text-right">
				Powered by: <a href="http://bootstrapmaster.com/demo/genius/" alt="Bootstrap Admin Templates">Genius Dashboard</a> | Based on Bootstrap 3.1.1 | Built with brix.io <a href="http://brix.io" alt="Brix.io - Interface Builder">Interface Builder</a>
			</div--><!--/.col-->	
			
		</div><!--/.row-->	

	</footer>
		

	
	
	<!-- end: JavaScript-->
	
</body>
</html>