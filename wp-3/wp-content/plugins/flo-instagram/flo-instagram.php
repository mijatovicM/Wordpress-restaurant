<?php
/*
Plugin Name: FLO Social
Description: Display one or more Instagram images

Version: 1.4.8
Author: Flothemes
Author URI: https://flothemes.com/
Licence:
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define('FLO_INST_DIR', plugin_dir_path(__FILE__));
define('FLO_INST_URL', plugin_dir_url(__FILE__));
define('FLO_TINYMCE_URI', plugin_dir_url( __FILE__ ) .'tinymce');

include 'instagram-widget.php';
include 'shortcode.php';
//include 'blocks/flo-instagram-feed.php';


add_action('init', 'flo_instagram_init');
/**
* Registers TinyMCE rich editor buttons
*
* @return	void
*/
function flo_instagram_init(){
	
	// if user does not have privileges to edit posts, or the plugin settings have no USER ID and Access Token set
	if ( (! current_user_can('edit_posts') && ! current_user_can('edit_pages')) || !(get_option('flo_instagram_user_id') && get_option('flo_instagram_access_token') ) )
		return;

	if ( get_user_option('rich_editing') == 'true' )
	{
		add_filter( 'mce_external_plugins', 'flo_add_rich_plugins' ); // filter which is executed when the buttons are about to be loaded
		add_filter( 'mce_buttons', 'flo_register_rich_buttons' ); // filter which is executed when the editor loads the plugins
	}

	load_plugin_textdomain( 'flotheme', false, dirname( plugin_basename( __FILE__ ) ) . "/languages" );
}

// --------------------------------------------------------------------------
	
/**
 * Defins TinyMCE rich editor js plugin
 *
 * @return	void
 */
function flo_add_rich_plugins( $plugin_array )
{ 
	$plugin_array['floShortcodes'] = FLO_TINYMCE_URI . '/plugin.js'; // The JavaScript file that is used to register the TinyMCE plugin through the TinyMCE API
	return $plugin_array;
}

// --------------------------------------------------------------------------

/**
 * Adds TinyMCE rich editor buttons
 *
 * @return	void
 */
function flo_register_rich_buttons( $buttons )
{
	array_push( $buttons, 'flo_button' );
	return $buttons;
}

add_action( 'admin_menu', 'flo_instagram_menu_page' );

function flo_instagram_menu_page(){
	
	// add plugin menu page
	add_menu_page( $page_title  = 'FLO Social Settings', $menu_title = 'FLO Social', $capability = 'activate_plugins', $menu_slug = 'flo_instagram', $function = 'flo_instagram_settings', $icon_url = plugin_dir_url( __FILE__ ).'tinymce/images/icon-1.png', $position = '83.7' );

	//call register settings function
	add_action( 'admin_init', 'flo_register_instagram_settings' );
}

function flo_register_instagram_settings() {
	//register our settings
	register_setting( 'flo_instgram_settings', 'flo_instagram_user_id' );
	register_setting( 'flo_instgram_settings', 'flo_instagram_access_token' );
	register_setting( 'flo_instgram_settings', 'flo_instagram_cache_time' );
}

add_action('admin_init', 'flo_insta_include_scripts');

function  flo_insta_include_scripts(){

	if( is_admin() ){
		$siteurl = get_option('siteurl');
        if( !empty($siteurl) ){
            $siteurl = rtrim( $siteurl , '/') . '/wp-admin/admin-ajax.php' ;
        }else{
            $siteurl = home_url('/wp-admin/admin-ajax.php');
        }

        
		wp_register_style( 'flo_instagram_admin__stylesheet',plugin_dir_url( __FILE__ ) . 'css/admin-style.css' );
		wp_enqueue_style( 'flo_instagram_admin__stylesheet' );


		// TINYMCE css
		wp_enqueue_style( 'flo-popup', FLO_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );
		
		// TINYMCE js
		wp_enqueue_script( 'jquery-livequery', FLO_TINYMCE_URI . '/js/jquery.livequery.js', false, '1.1.1', false );
		wp_enqueue_script( 'jquery-appendo', FLO_TINYMCE_URI . '/js/jquery.appendo.js', false, '1.0', false );
		wp_enqueue_script( 'base64', FLO_TINYMCE_URI . '/js/base64.js', false, '1.0', false );
		wp_enqueue_script( 'flo-popup', FLO_TINYMCE_URI . '/js/popup.js', false, '1.0', false );

		wp_localize_script( 'jquery', 'floShortcodes', array('plugin_folder' => WP_PLUGIN_URL .'/flo-instagram') );

		// check if the current wp version is > then 3.9
		// we need that for the 
		global $wp_version;
		if( version_compare($wp_version, '3.9', '>=') ){
			$is_wp_39 = '1';
		}else{
			$is_wp_39 = '0';
		}

		wp_localize_script( 'flo-popup', 'is_wp_39', $is_wp_39 );
		
	}
}

add_action('wp_enqueue_scripts', 'flo_instagram_frontend_scripts');
function flo_instagram_frontend_scripts(){
	
	//$file_path = plugin_dir_path( __DIR__ ) . 'flo-instagram.php';
	$file_path = dirname( __FILE__ ) . '/flo-instagram.php';
	
	$plugin_data = get_file_data( $file_path, array(
        'Version' => 'Version'
    ) );
	$version = $plugin_data['Version'];

	//var_dump($version);

	wp_register_style( 'flo_instagram_fontello',plugin_dir_url( __FILE__ ) . 'css/fontello.css' );
	wp_enqueue_style( 'flo_instagram_fontello' );

	/*wp_register_style( 'flo_instagram_fontello_embedded',plugin_dir_url( __FILE__ ) . 'css/fontello-embedded.css' );
	wp_enqueue_style( 'flo_instagram_fontello_embedded' );*/

	wp_register_style( 'flo_instagram_frontend__stylesheet',plugin_dir_url( __FILE__ ) . 'css/style.css', array(), $version );
	wp_enqueue_style( 'flo_instagram_frontend__stylesheet' );


	wp_enqueue_script( 'flo_instagram_colorbox' , plugin_dir_url( __FILE__ ) . 'js/jquery.colorbox-min.js' , array( 'jquery' ),false,$version );
	
	wp_enqueue_script( 'flo_instagram_scripts' , plugin_dir_url( __FILE__ ) . 'js/scripts.js' , array( 'jquery' ),$version,true );
}



function flo_instagram_settings(){
	
	$client_id = '57d03ca1bc0a474a95d52162e41c1ba3';
	
	$redirect_uri = 'http://flothemes.weareflo.com/instagram';

	$token_url = 'https://api.instagram.com/oauth/authorize/?client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&response_type=code&hl=en';

	$token_msg = sprintf(__('If you do not have an ID or access token, please visit %s Get Access token %s to receive a valid token','flotheme'),'<a href="'.$token_url.'" target="_blank">', '</a>');
		
?>
	<div class="wrap flo-instagram-settings">
		<h2><?php _e('FLO Social Settings','flotheme'); ?></h2>

		<form method="post" action="options.php">
		    <?php settings_fields( 'flo_instgram_settings' ); ?>
		    <?php do_settings_sections( 'flo_instgram_settings' ); ?>
		    <table class="form-table">
		        <tr valign="top">
			        <th scope="row"><?php _e('User ID','flotheme'); ?></th>
			        <td><input type="text" name="flo_instagram_user_id" value="<?php echo get_option('flo_instagram_user_id'); ?>" /></td>
		        </tr>
		         
		        <tr valign="top">
			        <th scope="row"><?php _e('Access Token','flotheme'); ?></th>
			        <td><input type="text" name="flo_instagram_access_token" value="<?php echo get_option('flo_instagram_access_token'); ?>" /></td>
		        </tr>
		        
		        <tr valign="top">
		        	<td scope="row" colspan="2"><?php echo $token_msg ?></td>
		        </tr>

		        <tr valign="top">
			        <th scope="row"><?php _e('Cache time (in minutes)','flotheme'); ?></th>
			        <td>
			        	<input type="text" name="flo_instagram_cache_time" value="<?php echo get_option('flo_instagram_cache_time'); ?>" />
			        	<br/>
			        	<?php _e('For better performance, we recommend to set this value to at least 60, <br> 
			        			wich will store each feed for 60 minutes in the cache. If you are using <br>
			        			feeds that are updated not so often, you can set this value to even several days. <br> 
			        			Setting this option to 0, or leaving it empty will avoid caching the results.'); 

			        		echo sprintf(__('To clear the cache access this %s link %s.','flotheme'),'<a href="'.get_site_url().'?delete_flo_insta_transient=1" target="_blank">','</a>')
			        	?>
			        </td>
		        </tr>
		        
		    </table>
		    
		    <?php submit_button(); ?>

		</form>

	</div>

<?php
}


/**
 * retrieve the instagram data
 *
 * @params string user_id - the user ID that registered the Instagram Application
 * 			string access_token - the access_token for the Instagram 
 *			string uid_or_tag - tells for what criteria to retrieve images, by user_id or by hashtag
 *			string uid_tag - the value for  the criteria specified above
 * @return mixed - The instagram feed info, or the error message
 */
function get_recent_data($user_id, $access_token, $uid_or_tag = 'user_id', $uid_tag = ''){

	$get_api_data = true;
	$api_url = '';
	$nr_images_found = 0;

	$global_insta_data = array();

	$i=1;
	// we will iterate untill we have 30 images or before making 20 iterations
	while ( $nr_images_found < 30 && $get_api_data && $i < 20) {
		
		// echo 'iteration: '.$i;
		// var_dump($get_api_data);
		// var_dump($nr_images_found);
		// echo '========================<br><br>';

		$insta_data = get_page_recent_data($user_id, $access_token, $uid_or_tag = 'user_id', $uid_tag = '', $api_url);

		if($nr_images_found == 0) {
			$global_insta_data = $insta_data;
		}else{
			$global_insta_data['data'] = array_merge($global_insta_data['data'], $insta_data['data']);
		}

		if(isset($insta_data['data'])) {

			$nr_images_found = $nr_images_found + sizeof($insta_data['data']);
			
			if( !isset($insta_data['pagination']['next_url'] ) ) { // if there is no next page, the we stop the iteration
				$get_api_data = false;
			}else{
				// update the api url with the next page URL
				$api_url = $insta_data['pagination']['next_url'];
			}
		}

		if($insta_data === NULL) { // we usually get here when the User Id and Token is not provided
			break;
		}

		$i++;
	}

 	return $global_insta_data;
}


/**
 * retrieve the instagram data on a given API page
 *
 * @params string user_id - the user ID that registered the Instagram Application
 * 			string access_token - the access_token for the Instagram 
 *			string uid_or_tag - tells for what criteria to retrieve images, by user_id or by hashtag
 *			string uid_tag - the value for  the criteria specified above
 * @return mixed - The instagram feed info, or the error message
 */
function get_page_recent_data($user_id, $access_token, $uid_or_tag = 'user_id', $uid_tag = '', $api_url = ''){
	// June 1st 2016 - Instagram API rules have changed
	// hardcode this to user_id only, because flothemes APP is allowed to show only 
	// the users own photos
	$uid_or_tag = 'user_id'; 
	if($uid_or_tag == 'user_id' ){
		// If user has provided a user_id, we override it
		if(isset($uid_tag) && is_numeric($uid_tag)){
			$user_id = $uid_tag;
		}
		if(is_numeric(trim($user_id))){
			// recent images
			if(isset($api_url) && $api_url != '') {
				$apiurl = $api_url;
			}else{
				$apiurl = "https://api.instagram.com/v1/users/".trim($user_id)."/media/recent/?count=40&access_token=".$access_token;	
			}
			
		}else{
			_e('Please provide a numeric User ID','flotheme');
			return;
		}
		
	}else if(strlen($uid_tag)){
		// images by tag
		$apiurl = "https://api.instagram.com/v1/tags/".$uid_tag."/media/recent?count=40&access_token=".$access_token;

	}else{
		_e('Please provide a valid User ID or Hashtag','flotheme');
		return;
	}

	$flo_instagram_cache_time = get_option('flo_instagram_cache_time');

	// if the caching time wasn't set by the user, we enforce 60min to avoid being blocked by the Instagram
	if( !(is_numeric($flo_instagram_cache_time) && $flo_instagram_cache_time > 0) ){
		$flo_instagram_cache_time = 60;
	}

	
	// option to delete the transient via a get parameter
	// we may need that when a new acces tocken is generated
	if(isset($_GET['delete_flo_insta_transient']) &&  1 == $_GET['delete_flo_insta_transient'] ){
		delete_transient(md5($apiurl));
	}

	// Let's see if we have a cached version of instagram feed
  $saved_instagram_images = get_transient(md5($apiurl));

  if ($saved_instagram_images !== false){
      $response = $saved_instagram_images; 


  }else{
  	$response = wp_remote_get( $apiurl, array('sslverify' => false) );	

  	set_transient(md5($apiurl), $response, 60*$flo_instagram_cache_time );
  }	
	

	//deb_e($response);
	
	//$response = wp_remote_get( $apiurl, array('sslverify' => false) );
	if(is_wp_error($response)){
		echo $response->get_error_message();
		return;
	}else{
		$data = json_decode( $response['body'], true );	
	}
	
//var_dump($data);
	return $data;
}


///Fix for timeouts after 5000 milliseconds
function flo_smushit_filter_timeout_time($time) {
    $time = 60; //new number of seconds
    return $time;
}

///////
add_filter( 'http_request_timeout', 'flo_smushit_filter_timeout_time');



add_action('admin_head', 'flo_add_intagram_tc_button');

function flo_add_intagram_tc_button() {
    global $typenow;
    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
    return;
    }
    
    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "flo_add_instagram_tinymce_plugin");
        add_filter('mce_buttons', 'flo_register_instagram_my_tc_button');
    }
}

function flo_add_instagram_tinymce_plugin($plugin_array) {
    $plugin_array['flo_instagram_tc_button'] = plugins_url( 'flo-instagram/tinymce/plugin.js' ); // CHANGE THE BUTTON SCRIPT HERE
    return $plugin_array;
}

function flo_register_instagram_my_tc_button($buttons) {

	// insert our button before the wp_adv (toolbar) toggle button
	$key = array_search( 'wp_adv', $buttons );
	$inserted = array( 'flo_instagram_tc_button' );
	array_splice( $buttons, $key, 0, $inserted );

	return $buttons;
}


function flo_img_insta_spacing( $options ){


	if(is_array($options)){
		extract($options);	
	}
	
	if(isset($unique_widget_class)){
?>
	<style>
		.flo-instagram_widget .horizontal_list<?php echo '.'.$unique_widget_class; ?> li:not(.insta-profile-btn){
			<?php  
				if(isset($flo_instagr_padding_top) && is_numeric($flo_instagr_padding_top)){
					?>padding-top: <?php echo $flo_instagr_padding_top.'px;';
				}
			?>
			<?php  
				if(isset($flo_instagr_padding_right) && is_numeric($flo_instagr_padding_right)){
					?>padding-right: <?php echo $flo_instagr_padding_right.'px;';
				}
			?>
			<?php  
				if(isset($flo_instagr_padding_bottom) && is_numeric($flo_instagr_padding_bottom)){
					?>padding-bottom: <?php echo $flo_instagr_padding_bottom.'px;';
				}
			?>
			<?php  
				if(isset($flo_instagr_padding_left) && is_numeric($flo_instagr_padding_left)){
					?>padding-left: <?php echo $flo_instagr_padding_left.'px;';
				}
			?>
		}
	</style>
<?php
	}
}

?>
