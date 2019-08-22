<?php //if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/*	Flo Social Feed shortcode
/*-----------------------------------------------------------------------------------*/

$client_id = '57d03ca1bc0a474a95d52162e41c1ba3';

$redirect_uri = 'http://flothemes.weareflo.com/instagram';

$token_url = 'https://api.instagram.com/oauth/authorize/?client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&response_type=code';
			
$flo_shortcodes['flo_instagram'] = array(
	'no_preview' => true,
	'params' => array(
		
		'padding' => array(
				'std' => '20',
				'type' => 'text',
				'label' => __('Padding between images', 'flotheme'),
				'desc' => ''
			),
		'use_pattern' => array(
			'type' => 'select',
			'label' => __('Images Layout', 'flotheme'),
			'desc' => '',
			'options' =>  array( ''=>__('All images will have the same size','flotheme'), 'on'=>__('Images will have different size.','flotheme')) 
		),
		'nr_columns' => array(
			'std' => '4',
			'type' => 'text',
			'label' => __('Number of columns', 'flotheme'),
			'desc' => __('Maximum 8 columns are allowed. This option is taken into account only if images layout is set to "Imges of the same size"','flotheme')
		),
		// 'crop' => array(
		// 	'std' => 0,
		// 	'type' => 'select',
		// 	'label' => __('Crop images 640x640px ?', 'flotheme'),
		// 	'desc' => __('If this option is enambed, then the images which are not square, will be cropped 640x640px','flotheme'),
		// 	'options' =>  array( 0=>__('No','flotheme'), 1=>__('Yes','flotheme'))
		// ),
		'picture_sizes' => array(
			'std' => 0,
			'type' => 'select',
			'label' => __('Picture size', 'flotheme'),
			'desc' => '',
			'options' =>  array('thumbnail' => 'Thumbnail', 'low_resolution' => 'Low Resolution','standard_resolution' => 'Standard Resolution', '320x320_crop' => 'Crop 320x320', '640x640_crop' => 'Crop 640x640')
		),
		'link' => array(
            'std' => 0,
            'type' => 'select',
            'label' => __('Link Images to Instagram', 'flotheme'),
            'desc' => __('If disabled, images will be open in a lightbox instead of directing users to the Instagram post','flotheme'),
            'options' =>  array( 0=>__('No','flotheme'), 1=>__('Yes','flotheme'))
        ),
		'limit' => array(
			'std' => '10',
			'type' => 'text',
			'label' => __('Number of images.', 'flotheme'),
			'desc' => 'Maximum 20'
		),
		
		'explanation' => array(
			'std' => '',
			'type' => 'raw-text',
			'label' => __('For a different account', 'flotheme'),
			'class' => 'flo-explanation',
			'desc' => __('If you want to show images belonging to a different user than the one set up in the plugin settings, then it is necessary to add bellow the User ID and the Access Token for the new user. To generate the Access Token it is necessary to have access to the Instagram account login credentials.','flotheme').sprintf(__('If you do not have an ID and the access token, please visit %s this link  %s to receive a valid token','flotheme'),'<a href="'.$token_url.'" target="_blank">', '</a>')
		),
		'user_id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('User ID', 'flotheme'),
			'desc' => 'Maximum 20'
		),
		'access_token' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Access Token.', 'flotheme'),
			'desc' => 'Maximum 20'
		),
		'hide_mobile' => array(
			'std' => 0,
			'type' => 'select',
			'label' => __('Hide on mobile devices?', 'flotheme'),
			'options' =>  array( 0=>__('No','flotheme'), 1=>__('Yes','flotheme'))
		),

	),
	'shortcode' => '[flo_instagram padding="{{padding}}" use_pattern="{{use_pattern}}" picture_sizes="{{picture_sizes}}" link="{{link}}" nr_columns="{{nr_columns}}" hide_mobile="{{hide_mobile}}" limit="{{limit}}" user_id="{{user_id}}" access_token="{{access_token}}" ]',
	'popup_title' => __('Insert Flo Social Shortcode', 'flotheme')
);

/*-----------------------------------------------------------------------------------*/
/*	Instagram Follow button
/*-----------------------------------------------------------------------------------*/

$flo_shortcodes['flo_instagram_follow'] = array(
	'no_preview' => true,
	'params' => array(
		'label' => array(
				'std' => 'Follow me',
				'type' => 'text',
				'label' => __('Follow button label', 'flotheme'),
				'desc' => ''
			),
		'instagram_url' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Instagram profile URL', 'flotheme'),
				'desc' => __('Enter the profile URL that you want users to follow. i.e. http://instagram.com/zaetsertmd','flotheme')
			),
		
		
	),
	'shortcode' => '[flo_instagram_follow label="{{label}}" instagram_url="{{instagram_url}}" ]',
	'popup_title' => __('Insert Instagram Follow Shortcode', 'flotheme')
);

?>
