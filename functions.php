<?php
/*
  Register wordpress menu so that the custom menu can be used
*/
add_action( 'init', 'register_my_menus' );
function register_my_menus() {
  register_nav_menu('header-menu',__( 'Header menu' ));
  register_nav_menu('footer-menu',__( 'Footer menu' ));
}

/*
  Load all the scripts in this order.
*/
if (!is_admin()) add_action('init', 'load_my_scripts');
function load_my_scripts() {
  wp_deregister_script( 'jquery' );
  wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js',array(), "1.64");
  wp_register_script('myscript', get_template_directory_uri().'/js/script.js', array("jquery"), false);

  wp_enqueue_script('jquery');
  wp_enqueue_script('myscript');
}

/*
  Create a theme settings page
*/
add_action('admin_menu', 'themename_create_menu');
function themename_create_menu() {
  add_menu_page('Theme Settings', 'Theme Settings', 'administrator', __FILE__, 'themename_settings_page');
  add_action( 'admin_init', 'register_themename_settings' );
}

function register_themename_settings() {
  register_setting( 'themename-settings-group', 'themename_option_1' );
  register_setting( 'themename-settings-group', 'themename_option_2' );
  register_setting( 'themename-settings-group', 'themename_option_3' );
  //all options can be retrieved with this: get_option('home_page_post_title');
}

function themename_settings_page() {
  ?>
    <div class="wrap">
    <h2>Theme Settings</h2>
      <form method="post" action="options.php">
        <?php settings_fields( 'themename-settings-group' ); ?>
          <div>
            Option 1
            <input type="text" name="themename_option_1" value="<?php echo get_option('themename_option_1'); ?>" />
          </div>
          <div>
            Option 2
            <input type="text" name="themename_option_2" value="<?php echo get_option('themename_option_2'); ?>" />
          </div>
          <div>
            Option 3
            <?php wp_editor( get_option('themename_option_3'), 'themename_option_3', $settings = array("textarea_name" => "themename_option_3" ) ); ?>
          </div>
          <?php submit_button(); ?>
      </form>
    </div>
  <?php 
} 

?>
