<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<?php Display::meta(); ?>
		<style type="text/css" media="screen">
                    @import url(<?php echo LPRMS::theme_dir(); ?>/style.css);
		</style>
		<title><?php echo LPRMS::name(); ?></title>
	</head>

	<body>
		<div id="header">
			<div id="header_l"></div>
                        <div id="header_r"><?php Widget::ajax_slideshow(); ?></div>
		</div>

		<div id="navigation">
			<?php Display::menu(); ?>
		</div>
		<div id="ticker">
		<?php Widget::ticker(); ?>
		</div>
		<div id="content">