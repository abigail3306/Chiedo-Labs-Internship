<?php
/*
  Adds widgetable areas
  can be called it theme with dynamic_sidebar( 'name here' );
  see http://codex.wordpress.org/Widgetizing_Themes for dynamic info
*/
// if ( function_exists('register_sidebar') ) register_sidebar(array(
  // 'name' => "Sidebar name"
// ));

/*
  Image link to none by default
*/
update_option('image_default_link_type','none');

/*
 * Add thumbnail support
 */
add_theme_support( 'post-thumbnails' );

/*
  Register wordpress menu so that the custom menu can be used
*/
add_action( 'init', 'themename_register_my_menus' );
function themename_register_my_menus() {
  register_nav_menu('header-menu',__( 'Header menu' ));
  register_nav_menu('footer-menu',__( 'Footer menu' ));
}

/*
  Load all the scripts in this order.
*/
add_action('init', 'themename_load_my_scripts');
function themename_load_my_scripts() {
  if (!is_admin()) {
    wp_deregister_script( 'jquery' );
    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js',array(), "1.10.2");
    wp_register_script('myscript', get_template_directory_uri().'/js/script.js', array("jquery"), false);
    wp_register_script('html5shiv', get_template_directory_uri().'/js/html5shiv.js', array("jquery"), false);

    //run html5shiv if the browser is less than IE9
    if(preg_match('/(?i)msie (2|3|4|5|6|7|8)/',$_SERVER['HTTP_USER_AGENT'])) wp_enqueue_script('html5shiv');

    wp_enqueue_script('jquery');
    wp_enqueue_script('myscript');
  }
}

/*
  Load all the styles in this order.
*/
add_action('init', 'themename_load_my_styles');
function themename_load_my_styles() {
  if (!is_admin()) {
    //wp_register_style("bootstrap", get_template_directory_uri()."/bootstrap/css/bootstrap-responsive.css");
    //wp_register_style("bootstrap-responsive", get_template_directory_uri()."/bootstrap/css/bootstrap.css",array("bootstrap"));
    //wp_register_style("style", get_template_directory_uri()."/style.css", array("bootstrap","bootstrap-responsive"));
    wp_register_style("style", get_template_directory_uri()."/style.css");

    //wp_enqueue_style('bootstrap');
    //wp_enqueue_style('bootstrap-responsive');
    wp_enqueue_style('style');
  }
}

/*
 *
 *  Adds a filter to append the default stylesheet to the tinymce editor. EXPERIMENTAL
 *
 */
add_filter( 'mce_css', 'tdav_css' );
if ( ! function_exists('tdav_css') ) {
  function tdav_css($wp) {
    $wp .= ',' . get_bloginfo('stylesheet_url');
  return $wp;
  }
}

function themename_displayroles() {
  $wp_roles = new WP_Roles();
  echo "<pre>";
  echo var_dump($wp_roles->roles);
  echo "</pre>";
}

/**
 * Remove default wordpress dashboard wigets except a few
 */
add_action('wp_dashboard_setup', 'themename_remove_dashboard_widgets' );
function themename_remove_dashboard_widgets() {
  global $wp_meta_boxes;

  $wp_meta_boxes['dashboard']['normal']['core']['dashboard_primary'] = $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'];
  
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

}

/**
 * Rename admin menus
 */
//add_filter( 'gettext', 'themename_rename_admin_menus' );
//add_filter( 'ngettext', 'themename_rename_admin_menus' );
function themename_rename_admin_menus( $translated ) {  
    $translated = str_replace( 'Settings', 'WP Settings', $translated );
    return $translated;
}

/*
Remove admin menu pages and redesignate them
*/
add_action( 'admin_menu', 'themename_update_menu_pages' );
function themename_update_menu_pages() {
  remove_menu_page('link-manager.php');
  remove_menu_page('edit-comments.php');	
  //remove_menu_page('plugins.php');	
  //remove_menu_page('themes.php');	
  //remove_menu_page('users.php');	
  //remove_menu_page('tools.php');	
  
  //add_submenu_page('options-general.php','Plugins', 'Plugins', 'administrator', 'plugins.php');
  //add_submenu_page('options-general.php','Themes', 'Themes', 'administrator', 'themes.php');
  //add_submenu_page('options-general.php','Tools', 'Tools', 'administrator', 'tools.php');
  //add_submenu_page('options-general.php','Users', 'Users', 'administrator', 'users.php');

  //add_menu_page('Menus','Menus','administrator','nav-menus.php');

}

/*
Remove admin pages from wordpress admin bar
*/
add_action( 'wp_before_admin_bar_render', 'themename_clean_admin_bar' );
function themename_clean_admin_bar() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('comments');
  $wp_admin_bar->remove_menu('new-content');
  $wp_admin_bar->remove_menu('themes');
}

/**
 * Remove default wordpress widgets except text
 */
add_action('widgets_init', 'themename_unregister_default_wp_widgets', 1);
function themename_unregister_default_wp_widgets() {
  unregister_widget('WP_Widget_Pages');
  unregister_widget('WP_Widget_Calendar');
  unregister_widget('WP_Widget_Archives');
  unregister_widget('WP_Widget_Links');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Widget_Search');
  unregister_widget('WP_Widget_Text');
  unregister_widget('WP_Nav_Menu_Widget');
  unregister_widget('WP_Widget_Categories');
  unregister_widget('WP_Widget_Recent_Posts');
  unregister_widget('WP_Widget_Recent_Comments');
  unregister_widget('WP_Widget_RSS');
  unregister_widget('WP_Widget_Tag_Cloud');
}

/*
 * Creates a shortcode for the client to make editing their content easier.
 * Obviously the appropriate css also needs to be generated.
 */
/*
 * add_shortcode('one_third', 'themename_one_third');
 * function themename_one_third( $atts, $content = null ) {
 *   return '<div class="one_third">' . do_shortcode($content) . '</div>';
 * }
 */

/*
 * CSS For the admin page
 */
add_action('admin_head', 'themename_custom_admin_css');
function themename_custom_admin_css() {
?>
  <style>
  </style>
<?php
}

/*
 * Add ins so you can grab post content by the ID
 */
/*
 * add_shortcode("add-in","themename_add_in"); 
 * function themename_add_in($atts, $content = null) {
 *   extract(shortcode_atts(array(
 *     "id" => 0
 *   ), $atts));
 *   $post = get_post($id); 
 *   $content = $post->post_content;
 * 
 *   return $content;
 * }
 */

?>
