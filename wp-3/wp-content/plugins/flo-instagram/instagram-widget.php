<?php if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'widgets_init', 'flo_widget_instagram' );

function flo_widget_instagram(){
	register_widget( 'widget_flo_instagram' );
}

/**
 * Instagrm_Feed_Widget Class
 */
class widget_flo_instagram extends WP_Widget {
	/** constructor */

	function __construct(){
		$options = array( 'classname' => 'flo-instagram_widget', 'description' => __('FLO Social Widget' , 'flotheme' ) );
		parent::__construct( 'widget_flo_instagram' , __( 'FLO Social Widget' , 'flotheme' )  , $options );

	}
	/* WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );

		// global 	$flo_instagr_padding_top,
		// 	$flo_instagr_padding_right,
		// 	$flo_instagr_padding_bottom,
		// 	$flo_instagr_padding_left,
		// 	$unique_widget_class;

		//get widget information to display on page
		$title = apply_filters( 'widget_title', $instance['title'] );

		if(isset($instance['below_title'])){
			$below_title = $instance['below_title'];
		}else{
			$below_title = '';
		}

		if( ! ( get_option('flo_instagram_user_id') && get_option('flo_instagram_access_token') ) ){
			echo sprintf(__('please set the User ID and Access Token from %s plugin settings %s','flotheme'),'<a href="admin.php?page=flo_instagram" target="_blank">', '</a>');
		}

		if(isset($instance['uid_or_tag'])){
			$uid_or_tag = $instance['uid_or_tag'];
		}else{
			$uid_or_tag = 'user_id';
		}

		if(isset($instance['uid_tag'])){
			$uid_tag = $instance['uid_tag'];
		}else{
			$uid_tag = '';
		}

		if(isset($instance['picture_number'])){
			$picture_number = $instance['picture_number'];
		}else{
			$picture_number = 0;
		}

		if(isset($instance['nr_columns'])){
			$nr_columns = $instance['nr_columns'];
		}else{
			$nr_columns = '6';
		}

		if(isset($instance['show_id_hashtag'])){
			$show_id_hashtag = $instance['show_id_hashtag'];
		}else{
			$show_id_hashtag = false;
		}

		if(isset($instance['user_name'])){
			$user_name = $instance['user_name'];
		}else{
			$user_name = '';
		}

		if(isset($instance['user_id'])){
			$user_id = $instance['user_id'];
		}else{
			$user_id = '';
		}

		if(isset($instance['access_token'])){
			$access_token = $instance['access_token'];
		}else{
			$access_token = '';
		}

		if(isset($instance['link_images'])){
			$picture_size = $instance['picture_size'];
		}else{
			$picture_size = 'thumbnail';
		}

		if(isset($instance['hide_on_mobiles'])){
			$hide_on_mobiles = $instance['hide_on_mobiles'];
		}else{
			$hide_on_mobiles = false;
		}


		if(isset($instance['link_images'])){
			$link_images = $instance['link_images'];
		}else{
			$link_images = false;
		}



		if(isset($instance['show_caption'])){
			$show_caption = $instance['show_caption'];
		}else{
			$show_caption = false;
		}

		if(isset($instance['top_padding'])){ $flo_instagr_padding_top = $instance['top_padding']; }else{ $flo_instagr_padding_top = 0; }
		if(isset($instance['right_padding'])){ $flo_instagr_padding_right = $instance['right_padding']; }else{ $flo_instagr_padding_right = 0; }
		if(isset($instance['bottom_padding'])){ $flo_instagr_padding_bottom = $instance['bottom_padding']; }else{ $flo_instagr_padding_bottom = 0; }
		if(isset($instance['left_padding'])){ $flo_instagr_padding_left = $instance['left_padding']; }else{ $flo_instagr_padding_left = 0; }

		if(isset($instance['debug_mode'])){
			$debug_mode = $instance['debug_mode'];
		}else{
			$debug_mode = false;
		}


		echo $before_widget;
		if ( $title ){
			if(strlen($below_title)){
				$below_title_content = '<div class="below-title-inst">'.$below_title.'</div>';
			}else{
				$below_title_content = '';
			}
			echo $before_title . $title . $below_title_content . $after_title;


		};
		if(isset($instance['user_id']) && '' != $instance['user_id'] && isset($instance['access_token']) && '' != $instance['access_token'] ){
			$insta_user_id = $instance['user_id'];
			$insta_access_token = $instance['access_token'];
		}else{
			$insta_user_id = get_option('flo_instagram_user_id');
			$insta_access_token = get_option('flo_instagram_access_token');
		}

		if($debug_mode){

			// Check requirements
			if (extension_loaded('curl')  ){
				if(get_option('flo_instagram_user_id') && get_option('flo_instagram_access_token')){
					$curl_ver = curl_version();
					echo '<p>Curl is <b>Enabled</b></p>';
					echo '<p>Curl Version Number:<br />'.$curl_ver['version_number'].'</p>';
					echo '<p>User ID:<br />'.get_option('flo_instagram_user_id').'</p>';
					echo '<p>Access Token:<br /><span style="word-wrap:break-word;width:100px;">'.get_option('flo_instagram_access_token').'</span></p>';

					$results = get_recent_data($insta_user_id,$insta_access_token, $uid_or_tag, $uid_tag );
					echo '<p><b>Results</b>:</p>';  //var_dump($results);
					foreach($results['meta'] as $key => $val){
						echo "<p>".$key.": ".$val."</p>";
					}
				}else{
					echo sprintf(__('please set the User ID and Access Token from %s plugin settings %s','flotheme'),'<a href="options-general.php?page=easy-instagram" target="_blank">', '</a>');
				}

			}else{
				echo '<p>Curl is <b>NOT</b> Enabled</p>';
			}
			return;
		}

		?>

		<?php
		if (get_option('flo_instagram_user_id') && get_option('flo_instagram_access_token') ){
			//var_dump($insta_user_id,$insta_access_token);
			$results = get_recent_data($insta_user_id,$insta_access_token, $uid_or_tag, $uid_tag);
		}


		if(!empty($results['data']) && $show_id_hashtag && strlen($user_name) ){
			$profile_link = '<li class="insta-profile-btn"><a href="http://instagram.com/'.$user_name.'/" target="_blank" class="insta-profile">@'.$user_name.'</a></li>';
		}else{
			$profile_link = '';
		}

		$unique_widget_class = 'flo-insta-'.mt_rand(0,9999);
		$i=1;

		$style_options = array('flo_instagr_padding_top' => $flo_instagr_padding_top,
			'flo_instagr_padding_right' => $flo_instagr_padding_right,
			'flo_instagr_padding_bottom' => $flo_instagr_padding_bottom,
			'flo_instagr_padding_left' => $flo_instagr_padding_left,
			'unique_widget_class' => $unique_widget_class
		);
		add_action( 'flo_wp_footer', 'flo_img_insta_spacing', 176, 1 );
		do_action('flo_wp_footer', $style_options);

		// use this action in your theme or plugin to add any html before the ul
		// there are  2 parama available, the widget instance and the fetched data
		do_action('flo_insta_before_widget_ul', $instance, $results);
		if( !empty($hide_on_mobiles) && wp_is_mobile() ){
			return;
		}
		if ($picture_size != 'thumbnail') {
			echo "<ul id='instagram_widget' class='widget-list horizontal_list ".$unique_widget_class." '>";
			//echo '<div class="widget-delimiter">&nbsp;</div>';
			if(!empty($results['data'])){

				$horizontal_list_width = '';
				//if(isset($layput_type) && $layput_type == 'horizontal_list' && isset($nr_columns) && is_numeric($nr_columns)){
				$the_width = 100/$nr_columns;
				$horizontal_list_width = 'style="width:'.($the_width).'%"';
				//}

				$original_pic_size = $picture_size;

				foreach($results['data'] as $index => $item){
					if($picture_number == 0){

						echo sprintf(__('%s Please set the Number of images to show within the widget %s','flotheme'),'<strong>', '</strong>');
						break;
					}

					// use this action to add anything before the images
					// you can use the item data and/or the index if you need the filter
					// to function only afer certain items
					do_action('flo_insta_before_image', $item, $index); 
					echo "<li ".$horizontal_list_width.">";
					
						/*If the user wants large images but croppes, then we should use the thumbnail image*/
						if($picture_size == '320x320_crop' || $picture_size == '640x640_crop'){
							$picture_size = 'thumbnail';
						}

						$img_src = $item['images'][$picture_size]['url'];
						$bg_img_style = '';
						$width_height_attributes = '';
						$bg_class = '';

						if($original_pic_size == '320x320_crop'){
							$img_src = $item['images']['thumbnail']['url'];
							$bg_img_src = $item['images']['low_resolution']['url'];
							$width_height_attributes = 'width="320" height="320"';
							$bg_class = 'crop';
							$dimmension_style = ' max-width: 320px; max-height: 320px; ';
						}
						if($original_pic_size == '640x640_crop'){
							$img_src = $item['images']['thumbnail']['url'];
							$bg_img_src = $item['images']['standard_resolution']['url'];
							$width_height_attributes = 'width="640" height="640"';
							$bg_class = 'crop';
							$dimmension_style = ' max-width: 640px; max-height: 640px; ';
						}

						if(isset($bg_img_src)) {
							$bg_img_style = 'background-image: url('.$bg_img_src.'); ' . $dimmension_style;
						}

						echo '<div class="relative '.$bg_class.'" style="'.$bg_img_style.'">';

							if(!empty($link_images)){
								echo "<a href='".$item['link']."' target='_blank'><img src='".$img_src."' ".$width_height_attributes." alt=''/></a>";
							}else{
								//$title = $title . '\"some shit\"';
								echo "<img src='".$img_src."' ".$width_height_attributes." alt=''/>";
							}


						echo '</div>';
					echo "</li>";
					// use this action to add anything after the images
					// you can use the item data and/or the index if you need the filter
					// to function only for certain items
					do_action('flo_insta_after_image', $item, $index); 
					if($i == $picture_number){
						echo apply_filters('flo_insta_widget_profile_link', $profile_link); // output the buttont that links to user profile
						echo "</ul>";

						break;
					}else{
						$i++;
					}
				}
			}else{
				if( current_user_can('editor') || current_user_can('administrator') ){
					$results = get_recent_data($insta_user_id,$insta_access_token, $uid_or_tag, $uid_tag );

					if(isset($results['meta'])){
						foreach($results['meta'] as $key => $val){
							echo "<p>".$key.": ".$val."</p>";
							if('error_message' == $key && 'The access_token provided is invalid.' == $val){
								echo sprintf(__('Try to %s regenerate a new access token %s','flotheme'), '<u><a target="_blank" href="http://docs.flothemes.com/flo-instagram-plugin/#access-token-expiration">', '</a></u>');
							}
						}
					}
				}
				
			}
		}elseif($picture_size == 'thumbnail'){ //deb::e($results['data']);
			echo "<ul id='instagram_widget_thumb' class='widget-list horizontal_list ".$unique_widget_class."'>";
			if(!empty($results['data'])){

				$horizontal_list_width = '';
				if(isset($nr_columns) && $nr_columns != 1 ){
					$the_width = 100/$nr_columns;
					$horizontal_list_width = 'style="width:'.$the_width.'%"';
				}

				foreach($results['data'] as $index => $item){ //deb::e($item);
					if($picture_number == 0){

						echo sprintf(__('%s Please set the Number of images to show within the widget %s','flotheme'),'<strong>', '</strong>');
						break;
					}

					// use this action to add anything before the images
					// you can use the item data and/or the index if you need the filter
					// to function only for certain items
					do_action('flo_insta_before_image', $item, $index); 
					echo "<li ".$horizontal_list_width.">";
					echo '<div class="relative">';
					if(!empty($link_images)){
						echo "<a href='".$item['link']."' target='_blank'><img src='".$item['images'][$picture_size]['url']."' alt='".$title." image'/></a>";
					}else{
						echo "<img src='".$item['images'][$picture_size]['url']."' alt=''/>";
					}

					echo '</div>';

					echo "</li>";
					// use this action to add anything after the images
					// you can use the item data and/or the index if you need the filter
					// to function only for certain items
					do_action('flo_insta_after_image', $item, $index); 
					if($i == $picture_number){
						echo apply_filters('flo_insta_widget_profile_link', $profile_link); // output the buttont that links to user profile
						echo "</ul>";
						break;
					}else{
						$i++;
					}
				}
			}else{
				if( current_user_can('editor') || current_user_can('administrator') ){
					$results = get_recent_data($insta_user_id,$insta_access_token, $uid_or_tag, $uid_tag );

					if(isset($results['meta'])){
						foreach($results['meta'] as $key => $val){
							echo "<p>".$key.": ".$val."</p>";
							if('error_message' == $key && 'The access_token provided is invalid.' == $val){
								echo sprintf(__('Try to %s regenerate a new access token %s','flotheme'), '<u><a target="_blank" href="http://docs.flothemes.com/flo-instagram-plugin/#access-token-expiration">', '</a></u>');
							}
						}
					}
				}
			}
		}else{
			echo "<strong>".__('The user currently does not have any images...','flotheme')."</strong>";
		}
		// use this action in your theme or plugin to add any html before the ul
		// there are  2 parama available, the widget instance and the fetched data
		do_action('flo_insta_after_widget_ul', $instance, $results); 
		echo $after_widget;
	}

	/* WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//update setting with information form widget form
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['below_title'] = strip_tags($new_instance['below_title']);
		$instance['uid_or_tag'] = strip_tags($new_instance['uid_or_tag']);
		$instance['uid_tag'] = strip_tags($new_instance['uid_tag']);
		$instance['picture_number'] = strip_tags($new_instance['picture_number']);


		$instance['nr_columns'] = strip_tags($new_instance['nr_columns']);
		$instance['show_id_hashtag'] = strip_tags($new_instance['show_id_hashtag']);
		$instance['user_name'] = strip_tags($new_instance['user_name']);
		$instance['user_id'] = strip_tags($new_instance['user_id']);
		$instance['access_token'] = strip_tags($new_instance['access_token']);

		$instance['picture_size'] = strip_tags($new_instance['picture_size']);
		$instance['hide_on_mobiles'] = strip_tags($new_instance['hide_on_mobiles']);
		$instance['link_images'] = strip_tags($new_instance['link_images']);
		$instance['top_padding'] = strip_tags($new_instance['top_padding']);
		$instance['right_padding'] = strip_tags($new_instance['right_padding']);
		$instance['bottom_padding'] = strip_tags($new_instance['bottom_padding']);
		$instance['left_padding'] = strip_tags($new_instance['left_padding']);

		$instance['debug_mode'] = strip_tags($new_instance['debug_mode']);

		return $instance;
	}

	/* WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );


			if(isset($instance[ 'below_title' ])){
				$below_title = esc_attr( $instance[ 'below_title' ] );
			}else{
				$below_title = '';
			}

			if(isset($instance[ 'uid_or_tag' ])){
				$uid_or_tag = esc_attr( $instance[ 'uid_or_tag' ] );
			}else{
				$uid_or_tag = 'user_id';
			}

			if(isset($instance[ 'uid_tag' ])){
				$uid_tag = esc_attr( $instance[ 'uid_tag' ] );
			}else{
				$uid_tag = '';
			}

			if(isset($instance[ 'picture_number' ])){
				$picture_number = esc_attr( $instance[ 'picture_number' ] );
			}else{
				$picture_number = 4;
			}



			if(isset($instance[ 'nr_columns' ]) && is_numeric($instance[ 'nr_columns' ]) ){
				$nr_columns = esc_attr( $instance[ 'nr_columns' ] );
			}else{
				$nr_columns = 1;
			}

			if(isset($instance[ 'show_id_hashtag' ])){
				$show_id_hashtag = esc_attr( $instance[ 'show_id_hashtag' ] );
			}else{
				$show_id_hashtag = false;
			}
			if(isset($instance[ 'user_name' ])){
				$user_name = esc_attr( $instance[ 'user_name' ] );
			}else{
				$user_name = '';
			}

			if(isset($instance[ 'user_id' ])){
				$user_id = esc_attr( $instance[ 'user_id' ] );
			}else{
				$user_id = '';
			}

			if(isset($instance[ 'access_token' ])){
				$access_token = esc_attr( $instance[ 'access_token' ] );
			}else{
				$access_token = '';
			}

			if(isset($instance[ 'picture_size' ])){
				$picture_size = esc_attr( $instance[ 'picture_size' ] );
			}else{
				$picture_size = 'thumbnail';
			}

			if(isset($instance[ 'show_likes' ])){
				$show_likes = esc_attr( $instance[ 'show_likes' ] );
			}else{
				$show_likes = false;
			}

			if(isset($instance[ 'show_caption' ])){
				$show_caption = esc_attr( $instance[ 'show_caption' ] );
			}else{
				$show_caption = false;
			}

			if(isset($instance[ 'hide_on_mobiles' ])){
				$hide_on_mobiles = esc_attr( $instance[ 'hide_on_mobiles' ] );
			}else{
				$hide_on_mobiles = false;
			}

			if(isset($instance[ 'link_images' ])){
				$link_images = esc_attr( $instance[ 'link_images' ] );
			}else{
				$link_images = false;
			}

			if(isset($instance[ 'top_padding' ])){ $top_padding = esc_attr( $instance[ 'top_padding' ] ); }else{ $top_padding = 0; }
			if(isset($instance[ 'right_padding' ])){ $right_padding = esc_attr( $instance[ 'right_padding' ] ); }else{ $right_padding = 0; }
			if(isset($instance[ 'bottom_padding' ])){ $bottom_padding = esc_attr( $instance[ 'bottom_padding' ] ); }else{ $bottom_padding = 0; }
			if(isset($instance[ 'left_padding' ])){ $left_padding = esc_attr( $instance[ 'left_padding' ] ); }else{ $left_padding = 0; }


			if(isset($instance[ 'debug_mode' ])){
				$debug_mode = esc_attr( $instance['debug_mode'] );
			}else{
				$debug_mode = false;
			}

		}
		else {
			$title = __( 'Title', 'flotheme' );
			$below_title = '';
			$uid_or_tag = 'user_id';

			$uid_tag = '';
			$username = __( 'Username', 'flotheme' );
			$picture_size = 'thumbnail';
			$picture_number = 0;
			$show_id_hashtag = false;
			$user_name = '';
			$nr_columns = 1;
			$show_likes = false;
			$show_caption = false;
			$hide_on_mobiles = false;
			$link_images = false;
			$top_padding = 0;
			$right_padding = 0;
			$bottom_padding = 0;
			$left_padding = 0;
			$user_id = '';
			$access_token = '';

			$debug_mode = false;
		}


		$picture_sizes = array('thumbnail' => 'Thumbnail', 'low_resolution' => 'Low Resolution','standard_resolution' => 'Standard Resolution', '320x320_crop' => 'Crop 320x320', '640x640_crop' => 'Crop 640x640');

		$u_name_class = '';
		// set the visibility class for the grid and list options
		// if('grid' == $layput_type){
		// 	$grid_visibility = '';
		// 	$list_visibility = ' hide ';
		// }else{

		$list_visibility = '';

		if( $show_id_hashtag ){
			$u_name_class = '';
		}
		//}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','flotheme'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>


		<p>
			<label for="<?php echo $this->get_field_id('below_title'); ?>"><?php _e('Below title label:','flotheme'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('below_title'); ?>" name="<?php echo $this->get_field_name('below_title'); ?>" type="text" value="<?php echo $below_title; ?>" />
		</p>

		<p>
			<?php
			if( ! ( get_option('flo_instagram_user_id') && get_option('flo_instagram_access_token') ) ){
				echo sprintf(__('please set the User ID and Access Token from %s plugin settings %s','flotheme'),'<a href="admin.php?page=flo_instagram" target="_blank">', '</a>');
			}
			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('picture_number'); ?>"><?php _e('Number of Images:','flotheme'); ?></label>
			<select id="<?php echo $this->get_field_id('picture_number'); ?>" name="<?php echo $this->get_field_name('picture_number'); ?>">
				<?php for($i=1;$i<31;$i++):?>
					<option value="<?php echo $i;?>" <?php if($i == $picture_number){echo 'selected="selected"';};?>><?php echo $i;?></option>
				<?php endfor;?>
			</select>
		</p>

		<p  class="horzontal-list-opt ">
			<label for="<?php echo $this->get_field_id('nr_columns'); ?>"><?php _e('Number of columns:','flotheme'); ?></label>
			<select id="<?php echo $this->get_field_id('nr_columns'); ?>" name="<?php echo $this->get_field_name('nr_columns'); ?>">

				<?php for($i=1;$i<=12;$i++):?>
					<option value="<?php echo $i;?>" <?php if($i == $nr_columns){echo 'selected="selected"';};?>><?php echo $i;?></option>
				<?php endfor;?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('picture_size'); ?>"><?php _e('Picture Size:','flotheme'); ?></label>
			<select id="<?php echo $this->get_field_id('picture_size'); ?>" name="<?php echo $this->get_field_name('picture_size'); ?>">
				<?php foreach($picture_sizes as $item => $val):?>
					<option value="<?php echo $item;?>" <?php if($item == $picture_size){echo 'selected="selected"';};?>><?php echo $val;?></option>
				<?php endforeach;?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('link_images'); ?>"><?php _e('Link images to full image:','flotheme'); ?></label>
			<input class="" id="<?php echo $this->get_field_id('link_images'); ?>" name="<?php echo $this->get_field_name('link_images'); ?>" type="checkbox" <?php echo (($link_images)? "CHECKED":''); ?> />
		</p>

		<p class="horzontal-list-opt ">
			<label for="<?php echo $this->get_field_id('show_likes'); ?>"><?php _e('Show profile link:','flotheme'); ?></label>
			<input  id="<?php echo $this->get_field_id('show_id_hashtag'); ?>" name="<?php echo $this->get_field_name('show_id_hashtag'); ?>" type="checkbox" class="show-profile-url" <?php echo (($show_id_hashtag)? "CHECKED":''); ?> />
		</p>

		<p class="horzontal-list-opt ">
			<label for="<?php echo $this->get_field_id('hide_on_mobiles'); ?>"><?php _e('Hide widget on mobile devices?','flotheme'); ?></label>
			<input class="" id="<?php echo $this->get_field_id('hide_on_mobiles'); ?>" name="<?php echo $this->get_field_name('hide_on_mobiles'); ?>" type="checkbox" <?php echo (($hide_on_mobiles)? "CHECKED":''); ?> />
		</p>

		<p class=" profile-u-name <?php echo $u_name_class; ?>">
			<label for="<?php echo $this->get_field_id('user_name'); ?>"><?php _e('User name:','flotheme'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('user_name'); ?>" name="<?php echo $this->get_field_name('user_name'); ?>" type="text" value="<?php echo $user_name; ?>" />
			<span class="generic-hint "><?php _e('User name is necessary to create the profile link','flotheme'); ?></span>
		</p>

		<fieldset class="different-user">
			<?php 
				$client_id = '57d03ca1bc0a474a95d52162e41c1ba3';
	
				$redirect_uri = 'http://flothemes.com/instagram';

				$token_url = 'https://api.instagram.com/oauth/authorize/?client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&response_type=code';
			?>
			<span class="generic-hint "><?php _e('If you want to show images belonging to a different user than the one set up in the plugin settings, then it is necessary to add bellow the User ID and the Access Token for the new user. To generate the Access Token it is necessary to have access to the Instagram account login credentials.','flotheme'); echo sprintf(__('If you do not have an ID and the access token, please visit %s this link  %s to receive a valid token','flotheme'),'<a href="'.$token_url.'" target="_blank">', '</a>') ?></span>
			<p class=" profile-u-id ">
				<label for="<?php echo $this->get_field_id('user_id'); ?>"><?php _e('User ID:','flotheme'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('user_id'); ?>" name="<?php echo $this->get_field_name('user_id'); ?>" type="text" value="<?php echo $user_id; ?>" />

			</p>

			<p class=" profile-token ">
				<label for="<?php echo $this->get_field_id('access_token'); ?>"><?php _e('Access Token:','flotheme'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" type="text" value="<?php echo $access_token; ?>" />

			</p>
		</fieldset>


		<p>
			<label for="<?php echo $this->get_field_id('top_padding'); ?>"><?php _e('Image top padding:','flotheme'); ?></label>
			<input class="digit spacing" id="<?php echo $this->get_field_id('top_padding'); ?>" name="<?php echo $this->get_field_name('top_padding'); ?>" type="text" value="<?php echo $top_padding; ?>" />
			<span class="generic-hint "><?php _e('px','flotheme'); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('right_padding'); ?>"><?php _e('Image right padding:','flotheme'); ?></label>
			<input class="digit spacing" id="<?php echo $this->get_field_id('right_padding'); ?>" name="<?php echo $this->get_field_name('right_padding'); ?>" type="text" value="<?php echo $right_padding; ?>" />
			<span class="generic-hint "><?php _e('px','flotheme'); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('bottom_padding'); ?>"><?php _e('Image bottom padding:','flotheme'); ?></label>
			<input class="digit spacing" id="<?php echo $this->get_field_id('bottom_padding'); ?>" name="<?php echo $this->get_field_name('bottom_padding'); ?>" type="text" value="<?php echo $bottom_padding; ?>" />
			<span class="generic-hint "><?php _e('px','flotheme'); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('left_padding'); ?>"><?php _e('Image left padding:','flotheme'); ?></label>
			<input class="digit spacing" id="<?php echo $this->get_field_id('left_padding'); ?>" name="<?php echo $this->get_field_name('left_padding'); ?>" type="text" value="<?php echo $left_padding; ?>" />
			<span class="generic-hint "><?php _e('px','flotheme'); ?></span>
		</p>


		<p>
			<label for="<?php echo $this->get_field_id('debug_mode'); ?>"><?php _e('Debug Mode:','flotheme'); ?></label>
			<input class="" id="<?php echo $this->get_field_id('debug_mode'); ?>" name="<?php echo $this->get_field_name('debug_mode'); ?>" type="checkbox" <?php echo (($debug_mode)? "CHECKED":''); ?> />
		</p>

		<script>
			function sh_layout_options(sel){

				console.log(sel.value);

				if( sel.value == 'grid' ){
					jQuery('.horzontal-list-opt').hide();
					jQuery('.grid-opt').show();
				}else{
					jQuery('.horzontal-list-opt').show();
					jQuery('.grid-opt').hide();
				}

			}

			jQuery(document).ready(function() {
				jQuery(".show-profile-url").bind('change', function() {
					if(jQuery(this).attr("checked")) {
						jQuery('.profile-u-name').show();
					}
					else {
						jQuery('.profile-u-name').hide();
					}
				});
			});

		</script>
		<?php
	}



} // class Instagrm_Feed_Widget

// register Instagrm widget

?>
