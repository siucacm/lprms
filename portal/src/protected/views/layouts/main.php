<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/tabber-min.js"></script>
    <style type="text/css">@import url('<?php echo Yii::app()->request->baseUrl; ?>/css/tabber.css');</style>
</head>

<body>
	<div id="header">
		<div class="title"><?php //echo CHtml::encode(Yii::app()->name); ?></div>
		<div class="tagline"></div>
	</div>
	
	<!-- begin content -->
	<?php echo $content; ?>
	<!-- end content -->

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by SIUC ACM.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

	<div id="nav">
		<?php
			$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'News', 'url'=>array('/post/index')),
				array('label'=>'Events', 'url'=>array('/event/index')),
				array('label'=>'People', 'url'=>array('/user/index')),
				array('label'=>'Account', 'url'=>array('/site/dashboard')),
				array('label'=>'Chat on IRC', 'url'=>array('/site/page', 'view'=>'chat')),
				array('label'=>'Administration', 'url'=>array('/site/admin'), 'visible'=>(!Yii::app()->user->isGuest && User::getCurrentUser()->role != NULL && User::getCurrentUser()->role->is_admin)),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Register', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/account/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<div id="breadcrumbs"><?php $this->widget('zii.widgets.CBreadcrumbs', array('links'=>$this->breadcrumbs, )); ?></div><!-- breadcrumbs -->
	
</body>
</html>