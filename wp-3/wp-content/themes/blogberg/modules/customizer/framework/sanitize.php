<?php
/**
 * Sanitize checkbox.
 *
 * @since Blogberg 1.0.0
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
if ( ! function_exists( 'blogberg_sanitize_checkbox' ) ) :
	
function blogberg_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

endif;

/**
 * Sanitize checkbox.
 *
 * @since Blogberg 1.0.0
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
if ( ! function_exists( 'blogberg_sanitize_text' ) ) :
	
function blogberg_sanitize_text( $value ) {
	return sanitize_text_field( $value );
}

endif;

/**
 * Sanitize Dropdown Page.
 *
 * @since Blogberg 1.0.0
 * @param integer $page_id.
 * @return integer Whether the page_id exists and published.
 */
if ( ! function_exists( 'blogberg_sanitize_dropdown_pages' ) ) :
	
function blogberg_sanitize_dropdown_pages( $page_id, $setting ) {

	$page_id = absint( $page_id );
	return ( 'page' === get_post_type( $page_id ) && 'publish' === get_post_status( $page_id ) ) ? $page_id: $setting->default;
}

endif;

/**
 * Sanitize Dropdown Posts.
 *
 * @since Blogberg 1.0.0
 * @param integer $post_id.
 * @return integer Whether the post_id exists and published.
 */
if ( ! function_exists( 'blogberg_sanitize_dropdown_posts' ) ) :
	
function blogberg_sanitize_dropdown_posts( $post_id, $setting ) {

	$post_id = absint( $post_id );

	return ( 'post' === get_post_type( $post_id ) && 'publish' === get_post_status( $post_id ) ) ? $post_id: $setting->default;
}

endif;

/**
 * Sanitize header option.
 *
 * @since Blogberg 1.0.0
 * @param integer $cat_id
 * @return integer
 */
if ( ! function_exists( 'blogberg_sanitize_dropdown_categories' ) ) :
	
function blogberg_sanitize_dropdown_categories( $cat_id, $setting ){
	$cat_id = absint( $cat_id );
	return term_exists( $cat_id, 'category' ) ? $cat_id: $setting->default;
}

endif;

/**
 * Sanitize header option.
 *
 * @since Blogberg 1.0.0
 * @param string $option
 * @return string
 */
if ( ! function_exists( 'blogberg_sanitize_header_type' ) ) :
	
function blogberg_sanitize_choice( $input, $setting ){

	# Ensure input is a slug.
	$input = sanitize_key( $input );
	# Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	# If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}

endif;

/**
 * Function to sanitize number
 *
 * @since Blogberg 1.0.0
 * @param $input
 * @param $setting
 * @return int || float || numeric value
 *
 */
if ( ! function_exists( 'blogberg_sanitize_number' ) ) :
    
function blogberg_sanitize_number ( $input, $setting ) {
    $sanitized_text = sanitize_text_field( $input );
    # If the input is an number, return it; otherwise, return the default
    return ( is_numeric( $sanitized_text ) ? $sanitized_text : $setting->default );
}
endif;
