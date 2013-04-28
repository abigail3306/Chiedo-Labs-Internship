<?php
/*
  Register wordpress menu so that the custom menu can be used
*/
function register_my_menus() {
  register_nav_menu('header-menu',__( 'Header menu' ));
  register_nav_menu('footer-menu',__( 'Footer menu' ));
}
add_action( 'init', 'register_my_menus' );

/*
  Load all the scripts in this order.
*/
function load_my_scripts() {
  wp_deregister_script( 'jquery' );
  wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js',array(), "1.64");
  wp_register_script('myscript', get_template_directory_uri().'/js/script.js', array("jquery"), false);

  wp_enqueue_script('jquery');
  wp_enqueue_script('myscript');
}
if (!is_admin()) add_action('init', 'load_my_scripts');
?>
