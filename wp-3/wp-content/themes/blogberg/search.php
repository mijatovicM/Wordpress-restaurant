<?php
/**
 * The search template file
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Blogberg 1.0.0
 */
get_header();
if( have_posts() ):
	/**
	* Prints Title and  breadcrumbs for archive pages
	* @since Blogberg 1.0.0
	*/
	blogberg_inner_banner();
?>
<section id="main-content">
	<div class="container">
		<div class="row">
			<div class="col-12" id="main-wrap">
				<div class="row masonry-wrapper">
					<?php 
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/archive/content', '' );
						endwhile;
					?>
				</div>
				<div class="col-12">
					<?php
						if( !blogberg_get_option( 'disable_pagination' ) ):
							the_posts_pagination( array(
								'next_text' => '<span>'.esc_html__( 'Next', 'blogberg' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Next page', 'blogberg' ) . '</span>',
								'prev_text' => '<span>'.esc_html__( 'Prev', 'blogberg' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Previous page', 'blogberg' ) . '</span>',
								'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'blogberg' ) . ' </span>',
							) );
						endif;
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
else: 
	get_template_part( 'template-parts/page/content', 'none' );
endif;
get_footer();