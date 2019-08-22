<?php
/**
 * Prints an accessibility-friendly link to edit a post or page.
 *
 * This also gives us a little context about what exactly we're editing
 * (post or page?) so that users understand a bit more where they are in terms
 * of the template hierarchy and their content. Helpful when/if the single-page
 * layout with multiple posts/pages shown gets confusing.
 *
 * @since Blogberg 1.0.0
 * @return void
 */
if ( ! function_exists( 'blogberg_edit_link' ) ) :

function blogberg_edit_link( $echo = true ) {

	if( ! $echo ){
		ob_start();
	}

	edit_post_link(
		sprintf(
			# translators: %s: Name of current post
			__( 'EDIT<span class="screen-reader-text"> "%s"</span>', 'blogberg' ),
			the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);

	if( ! $echo ){
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
}
endif;

/**
 * Prints Author's name with a link, posted date and number of Total Comments.
 *
 * @since  Blogberg 1.0.0
 * @return void
 */

if ( ! function_exists( 'blogberg_entry_footer' ) ) :
	
	function blogberg_entry_footer() {

		# Get the author name; wrap it in a link.
		?>
		<?php if( !blogberg_get_option( 'disable_single_date' ) || !blogberg_get_option( 'disable_single_tag_links' ) || !blogberg_get_option( 'disable_single_cat_links' ) ): ?>
			<footer class="post-footer">
				<?php if( is_single() && 'post' == get_post_type() && !blogberg_get_option( 'disable_single_post_format' ) ): ?>
            		<div class="post-format-outer">
            			<span class="post-format">
            				<span class="kfi <?php echo esc_attr( blogberg_get_icon_by_post_format() ); ?>"></span>
            			</span>
            		</div>
            	<?php endif; ?>
	            <div class="detail">
	            	<!-- Hide this section in single page  -->
	            	<?php ! is_single() && ! is_author() ? blogberg_posted_by() : '' ; ?>
					<?php if( is_single() && 'post' == get_post_type() && !blogberg_get_option( 'disable_single_tag_links' ) ): ?>
						<?php if( get_the_tag_list() ): ?>
							<div class="tag-links">
								<span class="screen-reader-text">
									<?php echo esc_html__( 'Tags', 'blogberg' ); ?>
								</span>
								<?php echo get_the_tag_list( '', ' ' ); ?>
							</div>
						<?php endif; ?>

					<?php endif; ?>
					<?php if( get_the_category_list() && !blogberg_get_option( 'disable_single_cat_links' ) ): ?>
						<div class="cat-links">
							<span class="screen-reader-text">
								<?php echo esc_html__( 'Categories', 'blogberg' ); ?>
							</span>
							<span class="categories-list">
								<?php echo get_the_category_list( ' ' ); ?>
							</span>
						</div>
					<?php endif; ?>
				</div>
			</footer>
		<?php endif; ?>
	<?php
	}
endif;

/**
 * Prints Posts title with link, edit link and a category
 *
 * @since  Blogberg 1.0.0
 * @uses   blogberg_edit_link()
 * @return void
 */
if ( ! function_exists( 'blogberg_entry_header' ) ) :

function blogberg_entry_header() {

	if( ! is_single() ){ 
		$cat = blogberg_get_the_category();
		$edit_link = '';
			if( get_edit_post_link()){
				$edit_link = blogberg_edit_link( false );
		}
	?>
		<header class="post-title">
			<?php if ( ! empty( $cat ) ): ?>
				<span class="cat">
					<?php
					echo sprintf( '<a href="%s" >%s</a>',
							esc_url( get_category_link( $cat[ 0 ]->term_id ) ),
							esc_html( $cat[ 0 ]->name )
						);
					echo $edit_link;
					?>
				</span>
			<?php endif; ?>
			<?php
			if( 'post' == get_post_type() )
				$edit_link = '';

			the_title( '<h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' . $edit_link . '</h2>' );
			?>
		</header>
<?php
	}
}
endif;

/**
 * Prints HTML with author avatar, name.
 * 
 *  @since Blogberg 1.0.0
 *  @uses blogberg_time_link();
 *  @return void
 */
if ( ! function_exists( 'blogberg_posted_on' ) ) :

function blogberg_posted_by() {
?>
	<span class="author">
	    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
	        <?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
	    </a>
	</span>
	<span class="author-name">
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
			<?php echo get_the_author(); ?>
		</a>
	</span>
<?php
}
endif;

/**
 * Gets a nicely formatted string for the published date.
 *
 * @since Blogberg 1.0.0
 * @return string
 */
if ( ! function_exists( 'blogberg_time_link' ) ) :

function blogberg_time_link() {

	$time_string = '<span class="entry-date published" datetime="%1$s">%2$s</span>';
	
	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ),
		get_the_date()
	);
?>
	<span class="screen-reader-text"><?php echo esc_html__( 'Posted on', 'blogberg' ); ?></span>
	<span class="posted-on">
		<a href="<?php echo esc_url( blogberg_get_day_link() ); ?>" rel="bookmark">
			<?php echo wp_kses_post( $time_string ); ?>
		</a>
	</span>
	<?php		
}
endif;

if( !function_exists( 'blogberg_get_day_link' ) ):
/**
* Returns the permalink of Post day
*
* @since Blogberg 1.0.0
* @return url
*/
function blogberg_get_day_link(){
	return get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') );
}
endif;
