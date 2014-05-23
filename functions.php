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
    wp_register_script('modernizr', get_template_directory_uri().
      '/js/lib/modernizr/modernizr.custom.js', array("jquery"), false);
    wp_register_script('webshim', get_template_directory_uri().
      '/js/lib/js-webshim/minified/polyfiller.js', array("jquery","modernizr"), false);
    wp_register_script('promises', get_template_directory_uri().
      '/js/lib/promises-polyfill/promise-1.0.0.min.js', array(), false);
    wp_register_script('footerscript', get_template_directory_uri().
      '/js/footer.js', array("jquery","webshim","modernizr","promises"), false);

    wp_enqueue_script('jquery');
    wp_enqueue_script('modernizr'); // EXPERIMENTAL - see cheatsheet/index.html
    wp_enqueue_script('webshim'); // EXPERIMENTAL - see cheatsheet/index.html
    wp_enqueue_script('promises'); // EXPERIMENTAL - see cheatsheet/index.html
    wp_enqueue_script('footerscript');
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
//add_filter( 'mce_css', 'tdav_css' );
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
 * JS For the admin page - EXPERIMENTAL
 */
add_action('admin_head', 'themename_custom_admin_js');
function themename_custom_admin_js() {
  global $parent_file;
  
  // The following removes and defoults to page-builder on the edit and add new 
  // post screens when it is set up and installed
  if ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' && isset( $_GET['post'] ) 
       || $parent_file = "post-new.php") {
  ?>
  <script>
    jQuery(document).ready(function() {
      if(jQuery("#content-panels").length > 0) {
        jQuery("#content-panels").click();
        jQuery(".wp-editor-area").text("");
        jQuery(".wp-editor-tabs").remove();
        jQuery("#wp-content-media-buttons").remove();
        jQuery("#wsp-content-media-buttons").remove();
      }
    });
  </script>
  <?php 
  }
}

/*
 * Hide WordPress Version meta tag
 */
add_filter('the_generator', 'wpstarter_remove_version');
function wpstarter_remove_version() {
  return '';
}

/*
 * Adds weekly cron job
 */
add_filter( 'cron_schedules', 'cron_add_weekly' );
function cron_add_weekly( $schedules ) {
  // Adds once weekly to the existing schedules.
  $schedules['weekly'] = array(
    'interval' => 604800,
    'display' => __( 'Once Weekly' )
  );
  return $schedules;
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

/*
 * Removes the autop for the UNNAMED custom post type
 */
/*
 * add_filter('the_content','prefix_custom_formatting');
 * function prefix_custom_formatting($content){
 *   if(get_post_type()=='UNNAMED') return $content;
 *   else return wpautop($content);
 * }
 */

/*
 * Removes the visual editor for the UNNAMED custom post type
 */
/*
 * add_filter( 'user_can_richedit', 'disable_for_UNNAMED' );
 * function disable_for_dng( $default ) {
 *     global $post;
 *     if(get_post_type($post) == "UNNAMED") return false;
 *     return $default;
 * }
 */
?>
