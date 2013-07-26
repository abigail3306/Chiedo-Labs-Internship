<!DOCTYPE html>
<html>
<head>
  <title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
  <!-- All scripts are called in functions.php -->
  <?php wp_head(); ?>
</head>
<body>



<!--[if IE 7]><div class="ie7"><![endif]-->
<!--[if IE 8]><div class="ie8"><![endif]-->
<!--[if IE 9]><div class="ie9"><![endif]-->
<header>
<nav class="mainmenu">
  <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
</nav>
</header>
