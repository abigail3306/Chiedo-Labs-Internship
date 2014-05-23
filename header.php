<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie-7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie-8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="ie ie-9" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 9]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" /> 
  <title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
  <!-- All scripts are called in functions.php -->
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
<nav class="mainmenu">
  <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
</nav>
</header>
