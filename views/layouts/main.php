<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div>
		
	<?php
		$this->widget('application.extensions.SMenu.SMenu',
			array(
				"menu"=>array(
					array("label"=>"Home", "url"=>array("route"=>"/site/index")),
					array("label"=>"Items", "url"=>array(),				
						array("label"=>"Firm info", "url"=>array("route"=>"/firm/admin")),
						array("label"=>"Price structure", "url"=>array("route"=>"/PriceStructure")),
						array("label"=>"Load file", "url"=>array("route"=>"/FileLoad")),
						array("label"=>"File processing", "url"=>array("route"=>"/Uploads")),
						array("label"=>"Department", "url"=>array("route"=>"/department")),
						array("label"=>"Employee", "url"=>array("route"=>"/employee")),
					),
					array("label"=>"About", "url"=>array("route"=>"/site/page?view=about")),
					array("label"=>"Contact", "url"=>array("route"=>"/site/contact")),
					array("label"=>"Login", 'url'=>array("route"=>'/site/login'), 'visible'=>Yii::app()->user->isGuest),
					array("label"=>'Logout ('.Yii::app()->user->name.')', 'url'=>array("route"=>'/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),	
			"stylesheet"=>"menu_blue.css",
			"menuID"=>"myMenu",
			"delay"=>3
			)
		);
	?>	
	</div><!-- mainmenu -->
	
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	
	

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
