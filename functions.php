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
add_action('init', 'load_my_scripts');
function load_my_scripts() {
  if (!is_admin()) {
    wp_deregister_script( 'jquery' );
    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js',array(), "1.64");
    wp_register_script('myscript', get_template_directory_uri().'/js/script.js', array("jquery"), false);

    wp_enqueue_script('jquery');
    wp_enqueue_script('myscript');
  }
}

/*
  Load all the styles in this order.
*/
add_action('init', 'load_my_styles');
function load_my_styles() {
  if (!is_admin()) {
    //enque and register styles here 
  }
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
  register_setting( 'themename-settings-group', 'themename_logo_url' ); // this is for the logo
}

function themename_settings_page() {
  ?>
    <div class="wrap">
    <h2>Theme Settings</h2>

      <!-- Image upload -->
      <?php $id = "themename_logo"; $multiple = false; $width = null; $height = null; ?>
      <label>Theme Logo</label>
      <input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id; ?>" />
      <div class="plupload-upload-uic hide-if-no-js <?php if ($multiple): ?>plupload-upload-uic-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-upload-ui">
          <input id="<?php echo $id; ?>plupload-browse-button" type="button" value="<?php esc_attr_e('Upload New logo'); ?>" class="button" />
          <span class="ajaxnonceplu" id="ajaxnonceplu<?php echo wp_create_nonce($id . 'pluploadan'); ?>"></span>
          <?php if ($width && $height): ?>
                  <span class="plupload-resize"></span><span class="plupload-width" id="plupload-width<?php echo $width; ?>"></span>
                  <span class="plupload-height" id="plupload-height<?php echo $height; ?>"></span>
          <?php endif; ?>
          <div class="filelist"></div>
      </div>
      <div class="plupload-thumbs <?php if ($multiple): ?>plupload-thumbs-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-thumbs">
      </div>
      <div class="clear"></div>
      <!-- end image upload -->
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

function themename_displayroles() {
  $wp_roles = new WP_Roles();
  echo "<pre>";
  echo var_dump($wp_roles->roles);
  echo "</pre>";
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
            'imgid' => 0 // will be added per uploader
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
    check_ajax_referer($imgid . 'pluploadan');
 
    // handle file upload
    $status = wp_handle_upload($_FILES[$imgid . 'async-upload'], array('test_form' => true, 'action' => 'plupload_action'));
 
    // send the uploaded file url in response
    update_option("themename_logo_url", $status['url']);
    echo $status['url'];
    exit;
}
?>
