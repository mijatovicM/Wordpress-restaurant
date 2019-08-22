<?php
/**
* Load widget components
*
* @since Blogberg 1.0.0
*/
require_once get_parent_theme_file_path( '/modules/widgets/class-base-widget.php' );
require_once get_parent_theme_file_path( '/modules/widgets/author.php' );
/**
 * Register widgets
 *
 * @since Blogberg 1.0.0
 */
/**
* Load all the widgets
* @since Blogberg 1.0.0
*/
function blogberg_register_widget() {

	$widgets = array(
		'Blogberg_Author_Widget',
	);

	foreach ( $widgets as $key => $value) {
    	register_widget( $value );
	}
}
add_action( 'widgets_init', 'blogberg_register_widget' );

