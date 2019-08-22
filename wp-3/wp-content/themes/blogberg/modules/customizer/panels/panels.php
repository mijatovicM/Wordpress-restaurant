<?php
/**
* Sets the panels and returns to Blogberg_Customizer
*
* @since  Blogberg 1.0.0
* @param  array An array of the panels
* @return array
*/
function Blogberg_Customizer_Panels( $panels ){

	$panels = array(
		'fonts' => array(
			'title' => esc_html__( 'Fonts', 'blogberg' ),
			'priority' => 60
		),
		'theme_options' => array(
			'title' => esc_html__( 'Theme Options', 'blogberg' ),
			'priority' => 100
		)
	);

	return $panels;	
}
add_filter( 'Blogberg_Customizer_Panels', 'Blogberg_Customizer_Panels' );