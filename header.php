<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie-7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie-8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="ie ie-9" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 9]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" /> 
	<link rel="stylesheet" href="var/www/html/wordpress/wp-content/themes/Chiedo Labs 2.0/style.css">

  <title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
  <!-- All scripts are called in functions.php -->
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>
<header>

<div class="main-header">
	<div class="c-sec mob-hidden"><a href="front-page.php"><img src="<?php echo get_template_directory_uri() ?>/images/logo.png"/></a>
	</div>

	<div class="hidden mob-block ctr"></div>

	<a class="bbb" href="#"><img src="<?php echo get_template_directory_uri() ?>/images/black-seal-96-50-chiedolabs-90007705.png"></img>
	</a>
</div> 

<nav class="main-menu">
  <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
</nav>

<div class="info-bar">
	<div class="contact-us">
		<b>EMAIL US:</b>
		<a href="#">labs@chie.do</a>
		<b>CALL US:</b>
		<a href="#">430.391.0503</a>
	</div>
	<div class="clear">
	</div>
</div>

</header>


