<?php if ( ! defined( 'ABSPATH' ) ) exit;

	/* this shortcode generate a button that should link to a Instagam profile */
	if (!function_exists('flo_instagram_follow')) {
		function flo_instagram_follow( $atts, $content = null ) {
			$defaults = array( 	'label' => __('Follow me','flotheme'), 
								'instagram_url' => '',
								);


	        extract( shortcode_atts( $defaults, $atts ) );

	        // check if the provided URL is a valid URL address
	        if(preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $instagram_url)){
	        	return '<a href="'.$instagram_url.'" target="_blank" class="flo-instagram-follow-btn" ><span class=" flo-label">'.$label.'</span></a>';
	        }else{
	        	return __('Please provide a valid URl for the Instagram profile page','flotheme');
	        }

	        

		}

		add_shortcode('flo_instagram_follow', 'flo_instagram_follow');
	}

	if (!function_exists('flo_instagram_shortcode')) {
		function flo_instagram_shortcode( $atts, $content = null ) {

			$defaults = array( 	'padding' => '20', 
								'use_pattern' => '',
								'crop' => 0,
								'picture_sizes' =>'standard_resolution',
                                'link' => 0,
								'nr_columns' => 4,
								'hide_mobile' => 0,
								'limit' => 10,
								'user_id' => get_option('flo_instagram_user_id'),
								'access_token' => get_option('flo_instagram_access_token'),
								'hashtag' => '' );


	        extract( shortcode_atts( $defaults, $atts ) );

	        if($hashtag != ''){ // if a hashtag is provided
	        	$uid_or_tag = 'hashtag'; // then we will search images based on hashtag
	        	$uid_tag = $hashtag; // set the hashtag value
	        }else{
	        	$uid_or_tag = 'user_id'; // then we will search images based on user_id
	        	$uid_tag = $user_id; // set the user_id value
	        }

	        // if the user does not provide the user id or the token, then we will use the data from the general settings
	        if($user_id == '' || $access_token == ''){
	        	$user_id = get_option('flo_instagram_user_id');
	        	$access_token = get_option('flo_instagram_access_token');
	        }

	        $results = get_recent_data($user_id,$access_token, $uid_or_tag, $uid_tag);
	        
			if(isset($results['data']) && !empty($results['data']) && sizeof($results['data'])){
				
		   		return flo_render_instagram_images(shortcode_atts( $defaults, $atts ), $results['data'] );
		   	}else{
		   		if(isset($results['meta']['error_message']) && $results['meta']['error_message'] != '' ){
		   			$error_hint = '';
		   			if( (current_user_can('editor') || current_user_can('administrator')) && $results['meta']['error_message'] == 'The access_token provided is invalid.'){
		   				$error_hint = '<p>' . sprintf(__('Try to %s regenerate a new access token %s','flotheme'), '<u><a target="_blank" href="http://docs.flothemes.com/flo-instagram-plugin/#access-token-expiration">', '</a></u>') . '</p>';
		   			}else{
		   				$error_hint = '';
		   			}
		   			return $results['meta']['error_message'] . $error_hint;
		   		}

		   		return $results;
		   	}
		}
		add_shortcode('flo_instagram', 'flo_instagram_shortcode');
	}

	function flo_render_instagram_images($shortcode_attributes, $feed_data ){

		$result = '';
		extract($shortcode_attributes);
		//var_dump($user_id);
		if ( isset($shortcode_attributes['hide_mobile']) && $shortcode_attributes['hide_mobile'] == 1 && $shortcode_attributes && wp_is_mobile() ){
			return;
		}
		if(strlen($use_pattern)){
			$pattern_class = 'instgm-flo-pattern';
		}else{
			$pattern_class = '';
		}

		if(is_numeric($padding)){
			$padding_style = ' padding: '.($padding/2).'px; ';
		}else{
			$padding_style = '';
		}

		if( !isset($crop)){
			$crop = 0;
		}

		$result .= '<div class="flo-shcode-instgm-container  '.$pattern_class.' columns'.$nr_columns.' ">';
	
		$counter = 1;
		$small_imgs_div_oppened = false;

		if(!isset($picture_sizes)){
			$picture_sizes = 'standard_resolution';
		}

		$original_pic_size = $picture_sizes;

		foreach($feed_data as $index => $item){ //deb::e($item);

			$the_remainder = $counter % 10;
			if($the_remainder == 5 || $the_remainder == 6){ // when pattern layout is choosen, then each 5th and 6th image will have a distinct class to make it bigger
				$pattern_img_class = ' big-img ';
			}else{
				$pattern_img_class = ' ';
			}
			
			if( strlen($use_pattern) && ($the_remainder == 1 || $the_remainder == 7) ){
				$result .= '<div class="flo-pattern-small-imgs">';
				$small_imgs_div_oppened = true;
			}

			if(isset($item['caption']['text'])){
				$img_description = $item['caption']['text'];
			}else{
				$img_description = '';
			}

			$fancyBox = $shortcode_attributes['link']? '': 'data-fancybox-group="fancybox_instagram"';
			$img_url = $shortcode_attributes['link']? $item['link']: $item['images']['standard_resolution']['url'];

			// $grid_img_src = $item['images']['standard_resolution']['url'];

			// if(isset($crop) && $crop == 1){ // is user want to have square cropped images 640x640
			// 	$grid_img_src = $item['images']['thumbnail']['url']; // take the thumbnail URL
			// 	$grid_img_src = str_replace('/s150x150/', '/s640x640/', $grid_img_src);
			// }

			/*If the user wants large images but croppes, then we should use the thumbnail image*/
			if($picture_sizes == '320x320_crop' || $picture_sizes == '640x640_crop'){
				$picture_sizes = 'thumbnail';
			}


			$grid_img_src = $item['images'][$picture_sizes]['url'];

			$bg_img_style = '';
			$width_height_attributes = '';
			$bg_class = '';

			if($original_pic_size == '320x320_crop'){
				$grid_img_src = $item['images']['thumbnail']['url'];
				$bg_img_src = $item['images']['low_resolution']['url'];
				$width_height_attributes = 'width="320" height="320"';
				$bg_class = 'crop';
				$dimmension_style = ' max-width: 320px; max-height: 320px; ';
			}
			if($original_pic_size == '640x640_crop'){
				$grid_img_src = $item['images']['thumbnail']['url'];
				$bg_img_src = $item['images']['standard_resolution']['url'];
				$width_height_attributes = 'width="640" height="640"';
				$bg_class = 'crop';
				$dimmension_style = ' max-width: 640px; max-height: 640px; ';
			}

			if(isset($bg_img_src)) {
				$bg_img_style = 'background-image: url('.$bg_img_src.'); ' . $dimmension_style;
			}
			
			

			$before_shortcode_image_block = '';
			$result .= apply_filters('flo_insta_before_shortcode_image_block',$before_shortcode_image_block, $index, $item);
			$result .='<div class="img-block '.$pattern_img_class.'">';
			$before_shortcode_inner_image_block = '';
			$result .= apply_filters('flo_insta_before_shortcode_inner_image_block',$before_shortcode_inner_image_block, $index, $item);
			$result .='<div class="inner-img-block" style="'.$padding_style.'">';
			$result .='<a target="_blank" href="'.$img_url.'" '.$fancyBox.'  rel="colorbox_instagram" class="'.$bg_class.'" style="'.$bg_img_style.'" title="'.esc_attr($img_description).'">';
			$result .='<img src="'.$grid_img_src.'" '.$width_height_attributes.' >';
			$result .='</a>';
			$result .='</div>';
			$after_shortcode_inner_image_block = '';
			$result .= apply_filters('flo_insta_after_shortcode_inner_image_block',$after_shortcode_inner_image_block, $index, $item);
			$result .='</div>';
			$after_shortcode_image_block = '';
			$result .= apply_filters('flo_insta_after_shortcode_image_block',$after_shortcode_image_block, $index, $item);
			if( (strlen($use_pattern) && ($the_remainder == 4 || $the_remainder == 0)) || ( ($counter == $limit || $counter == sizeof($feed_data) ) && $small_imgs_div_oppened ) ){
				$result .= '</div>';
				$small_imgs_div_oppened = false;
			}

			if($counter == $limit){
				
				break;
			}
			$counter++;
		}

		$result .= '</div>';

		return $result;
	
	}
?>