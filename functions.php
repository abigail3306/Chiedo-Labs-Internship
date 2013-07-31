<?php
/*
  Adds widgetable areas
  can be called it theme with dynamic_sidebar( 'name here' );
  see http://codex.wordpress.org/Widgetizing_Themes for dynamic info
*/
if ( function_exists('register_sidebar') ) register_sidebar(array(
  'name' => "Sidebar name"
));

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
    //wp_register_script('html5shiv', get_template_directory_uri().'/js/html5shiv.js', array("jquery"), false);

    //run html5shiv if the browser is less than IE9
    //if(preg_match('/(?i)msie (2|3|4|5|6|7|8)/',$_SERVER['HTTP_USER_AGENT'])) wp_enqueue_script('html5shiv');

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
  Create a theme settings page
*/
add_action('admin_menu', 'themename_create_menu');
function themename_create_menu() {
  add_menu_page('Theme Settings', 'Theme Settings', 'administrator', __FILE__, 'themename_settings_page');
  add_action( 'admin_init', 'themename_register_settings' );
}

function themename_register_settings() {
  register_setting( 'themename-settings-group', 'themename_option_1' );
  register_setting( 'themename-settings-group', 'themename_option_2' );
  register_setting( 'themename-settings-group', 'themename_option_3' );
}

/*
IMAGE UPLOAD
credits to  - http://www.krishnakantsharma.com/2012/01/image-uploads-on-wordpress-admin-screens-using-jquery-and-new-plupload/
*/
add_action( 'admin_enqueue_scripts', 'plu_admin_enqueue' );
function plu_admin_enqueue() {
    if(!is_admin()) return;
    wp_enqueue_script('plupload-all');
 
    wp_register_script('myplupload', get_template_directory_uri().'/myplupload/myplupload.js', array('jquery'));
    wp_enqueue_script('myplupload');
}

add_action("admin_head", "plupload_admin_head");
function plupload_admin_head() {
    $plupload_init = array(
        'runtimes' => 'html5,silverlight,flash,html4',
        'browse_button' => 'plupload-browse-button', // will be adjusted per uploader
        'container' => 'plupload-upload-ui', // will be adjusted per uploader
        'drop_element' => 'drag-drop-area', // will be adjusted per uploader
        'file_data_name' => 'async-upload', // will be adjusted per uploader
        'multiple_queues' => true,
        'max_file_size' => wp_max_upload_size() . 'b',
        'url' => admin_url('admin-ajax.php'),
        'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
        'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
        'filters' => array(array('title' => __('Allowed Files'), 'extensions' => '*')),
        'multipart' => true,
        'urlstream_upload' => true,
        'multi_selection' => false, // will be added per uploader
         // additional post data to send to our ajax hook
        'multipart_params' => array(
            '_ajax_nonce' => "", // will be added per uploader
            'action' => 'plupload_action', // the ajax action name
            'imgid' => 0,
            'optionname' => 0
        )
    );
?>
<script type="text/javascript">
    var base_plupload_config=<?php echo json_encode($plupload_init); ?>;
</script>
<?php
}

add_action('wp_ajax_plupload_action', "g_plupload_action");
function g_plupload_action() {
 
    // check ajax noonce
    $imgid = $_POST["imgid"];
    $optionname = $_POST["optionname"];
    check_ajax_referer($imgid . 'pluploadan');
 
    // handle file upload
    $status = wp_handle_upload($_FILES[$imgid . 'async-upload'], array('test_form' => true, 'action' => 'plupload_action'));
 
    // send the uploaded file url in response
    update_option($optionname, $status['url']);
    echo $status['url'];
    exit;
}
/*
Display the plupload form
*/
function plupload_add_uploadable_img($id,$optionname,$label,$buttontext) {
?>
  <?php register_setting( 'themename-settings-group', $optionname ); ?>

  <div class="plupload-form-style">
        <label><?php echo $label; ?></label>
        <input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id; ?>" />
        <div class="plupload-upload-uic hide-if-no-js" id="<?php echo $id; ?>plupload-upload-ui">
            <input type="hidden" class="optionname" name="optionname" id="<?php echo $optionname; ?>" />
            <input id="<?php echo $id; ?>plupload-browse-button" type="button" value="<?php esc_attr_e("$buttontext"); ?>" class="button" />
            <span class="ajaxnonceplu" id="ajaxnonceplu<?php echo wp_create_nonce($id . 'pluploadan'); ?>"></span>
        </div>
        <div class="plupload-thumbs" id="<?php echo $id; ?>plupload-thumbs">
          <?php if(get_option($optionname)) :?>
            <img id="<?php echo $id; ?>" src="<?php echo get_option($optionname); ?>" />
          <?php endif; ?>
        </div>
        <div class="clear"></div>
  </div>
<?
}

/*
The theme settings page
*/
function themename_settings_page() {
  ?>
    <style>
      .plupload-form-style img { max-width: 400px; }
      label { width: 200px; float: left; display: block; }
      form div, .plupload-form-style div { margin-top: 10px; }
      .textarealabel { float: none; }
    </style>

    <div class="wrap">
    <h2>Theme Settings</h2>
      <?php 
        plupload_add_uploadable_img("themename_img_1","themename_logo_url","Theme logo","Upload new logo"); 
        plupload_add_uploadable_img("themename_img_2","themename_logo_url_goop","Random","Upload random"); 
      ?>

      <form method="post" action="options.php">
        <?php settings_fields( 'themename-settings-group' ); ?>
          <div>
            <label>Option 1</label>
            <input type="text" name="themename_option_1" value="<?php echo get_option('themename_option_1'); ?>" />
          </div>
          <div>
            <label>Option 2</label>
            <input type="text" name="themename_option_2" value="<?php echo get_option('themename_option_2'); ?>" />
          </div>
          <div>
            <label class="textarealabel">Option 3</label>
            <?php wp_editor( get_option('themename_option_3'), 'themename_option_3', $settings = array("textarea_name" => "themename_option_3" ) ); ?>
          </div>
          <?php submit_button(); ?>
      </form>
    </div>
  <?php 
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
  remove_menu_page('plugins.php');	
  remove_menu_page('themes.php');	
  remove_menu_page('users.php');	
  //remove_menu_page('tools.php');	
  
  add_submenu_page('options-general.php','Plugins', 'Plugins', 'administrator', 'plugins.php');
  add_submenu_page('options-general.php','Themes', 'Themes', 'administrator', 'themes.php');
  //add_submenu_page('options-general.php','Tools', 'Tools', 'administrator', 'tools.php');
  add_submenu_page('options-general.php','Users', 'Users', 'administrator', 'users.php');

  add_menu_page('Menus','Menus','administrator','nav-menus.php');

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
function themename_one_third( $atts, $content = null ) {
  return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'themename_one_third');

?>
