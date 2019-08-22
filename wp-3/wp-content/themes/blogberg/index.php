<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Blogberg 1.0.0
 */
get_header();

if( have_posts() ):
	get_template_part( 'template-parts/slider/slider', '' );
?>
	<section class="block-grid" id="main-content">
		<div class="container">
			<div class="row">
				<?php if( blogberg_get_option( 'archive_layout' ) == 'left' ): ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
				<?php
					$class = '';
					$layout_class = '';
					$masonry_class = '';
					blogberg_get_option( 'archive_layout' ) == 'none' ? $class = 'col-12' : $class = 'col-md-8';
					if( blogberg_get_option( 'archive_post_layout' ) == 'grid'){
						$masonry_class = 'masonry-wrapper';
					}
					if( blogberg_get_option( 'archive_post_layout' ) == 'grid' ){
						$layout_class = 'grid-post';
					}elseif( blogberg_get_option( 'archive_post_layout' ) == 'list' ){
						$layout_class = 'list-post';
					}elseif( blogberg_get_option( 'archive_post_layout' ) == 'simple' ){
						$layout_class = 'simple-post';
					}
				?>
				<div class="<?php echo esc_attr( $class ); ?>" id="main-wrap">
					<div class="post-section">	
						<div class="content-wrap">
							<div class="row">
								<?php
									if( is_sticky() ){
										get_template_part( 'template-parts/archive/content', '' );
									}
								?>
							</div>
							<div class="row <?php echo esc_attr( $layout_class ), ' ', esc_attr( $masonry_class ); ?>">
								<?php
									$the_query = new WP_Query( array( 'post__not_in' => get_option( 'sticky_posts' ) ) );
									if ( $the_query->have_posts() ) :
										while ( $the_query->have_posts() ) : $the_query->the_post();
											get_template_part( 'template-parts/archive/content', '' );
										endwhile;
									endif;
								?>
							</div>
						</div>
					</div>
					<?php
						if( !blogberg_get_option( 'disable_pagination' ) ):
							the_posts_pagination( array(
								'next_text' => '<span>'.esc_html__( 'Next', 'blogberg' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Next page', 'blogberg' ) . '</span>',
								'prev_text' => '<span>'.esc_html__( 'Prev', 'blogberg' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Previous page', 'blogberg' ) . '</span>',
								'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'blogberg' ) . ' </span>',
							));
						endif;
					?>
				</div>
				<?php if( blogberg_get_option( 'archive_layout' ) == 'right' ): ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php 
else: 
	get_template_part( 'template-parts/page/content', 'none' );
endif;

get_footer();