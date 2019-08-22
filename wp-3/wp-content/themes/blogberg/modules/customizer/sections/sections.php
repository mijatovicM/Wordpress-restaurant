<?php
/**
* Sets sections for Blogberg_Customizer
*
* @since  Blogberg 1.0.0
* @param  array $sections
* @return array Merged array
*/
function Blogberg_Customizer_Sections( $sections ){

	$blogberg_sections = array(
		# Section for Font panel
		'font_family' => array(
			'title' => esc_html__( 'Font Family', 'blogberg' ),
			'panel' => 'fonts'
		),
		'font_size' => array(
			'title' => esc_html__( 'Font Size', 'blogberg' ),
			'panel' => 'fonts'
		),

		# Section for Theme Options panel
		'homepage_options' => array(
			'title' => esc_html__( 'Home Page Options', 'blogberg' ),
			'panel' => 'theme_options'
		),
		'header_options' => array(
			'title' => esc_html__( 'Header Options', 'blogberg' ),
			'panel' => 'theme_options'
		),
		'footer_options' => array(
			'title' => esc_html__( 'Footer Options', 'blogberg' ),
			'panel' => 'theme_options'
		),
		'layout_options' => array(
			'title' => esc_html__( 'Layout Options', 'blogberg' ),
			'panel' => 'theme_options'
		),
		'archive_options' => array(
			'title' => esc_html__( 'Archive Page Options', 'blogberg' ),
			'panel' => 'theme_options'
		),
		'single_options' => array(
			'title' => esc_html__( 'Single Post Page Options', 'blogberg' ),
			'panel' => 'theme_options'
		),
		'page_options' => array(
			'title' => esc_html__( 'Page Options', 'blogberg' ),
			'panel' => 'theme_options'
		),
		'general_options' => array(
			'title' => esc_html__( 'General Options', 'blogberg' ),
			'panel' => 'theme_options'
		)
	);

	return array_merge( $blogberg_sections, $sections );
}
add_filter( 'Blogberg_Customizer_Sections', 'Blogberg_Customizer_Sections' );