<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
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
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/style.min.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/retina.min.css" rel="stylesheet">
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
<!-- start: Header -->
<div class="pl">
	<div class="round anti"></div>
</div>
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
			<div class="nav-no-collapse header-nav">
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
					$menuContent = array();
					if (Yii::app()->user->role == 'administrator' || Yii::app()->user->role == 'moderator'){
						$url = array('/admin');
					} else {
						$url = array('/');
					}

					array_push($menuContent, array('label'=>'<i class="fa fa-home"></i><span class="hidden-sm text">Home</span>', 'url'=>$url,'linkOptions'=>array()));

					if (Yii::app()->user->role == 'user' && isset($this->userRules) && !empty($this->userRules)) {
						array_push($menuContent, array(
							'label'=>'<i class="fa fa-male"></i><span class="hidden-sm text">'.Yii::t('admin/index','Live Panel').'</span>',
							'url'=>array('/livepanel/default'),
							'visible'=>in_array(substr('/livepanel/default',1), $this->userRules)
						));
					}
					array_push($menuContent, array('label'=>'<i class="fa fa-eye"></i><span class="hidden-sm text">Login</span>', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest,'linkOptions'=>array('class'=>'')));
					array_push($menuContent, array('label'=>'<i class="fa fa-eye"></i><span class="hidden-sm text">Logout ('.Yii::app()->user->name.')</span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest,'linkOptions'=>array('class'=>'dropmenu')));

						$this->widget('zii.widgets.CMenu',array(
                    'htmlOptions' => array( 'class' => 'nav main-menu'),
                    'encodeLabel' => false,
            		'items' => $menuContent,
            	)); ?>
                </div>
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
</body>
</html>
