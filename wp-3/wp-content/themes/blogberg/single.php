<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @since Blogberg 1.0.0
 */
get_header();

# Print banner with breadcrumb and post title.
blogberg_inner_banner();
?>
<section class="wrap-detail-page" id="main-content">
	<div class="container">
		<?php $feature_image_class = 'col-lg-12'; ?>
		<div class="row">
			<div class="<?php echo esc_attr( $feature_image_class ); ?>">
				<?php if( has_post_thumbnail() && !blogberg_get_option( 'disable_single_feature_image' ) ): ?>
				    <div class="post-thumbnail">
				        <?php the_post_thumbnail( 'blogberg-1200-710' ); ?>
				    </div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<?php if( blogberg_get_option( 'single_layout' ) == 'left' ): ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
			<?php $class = ''; ?>
			<?php
				if( blogberg_get_option( 'single_layout' ) == 'none' ) {
					$class = 'col-lg-12';
				}else {
					$class = 'col-lg-8';
				}
			?>
			<div class="<?php echo esc_attr( $class ); ?>">
				<main id="main" class="post-main-content" role="main">
					<?php
						# Loop Start
						while( have_posts() ): the_post();

							# Print posts respect to the post format
							get_template_part( 'template-parts/single/content', get_post_format() );

							# Print the author details of this post
							if( 'post' == get_post_type() && !blogberg_get_option( 'disable_single_author' ) ) {
								get_template_part( 'template-parts/single/content', 'author-detail' );
							}

							# If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

							# Navigate the post. Next post and Previou post.
							$post_navigation_prev_text = blogberg_get_option( 'single_post_nav_prev' );
							$post_navigation_next_text = blogberg_get_option( 'single_post_nav_next' );

							if ( 'post' === get_post_type() ){
								the_post_navigation( array(
									'prev_text' => '<span class="nav-label">' . $post_navigation_prev_text . '</span><span class="nav-title">%title</span>',
									'next_text' => '<span class="nav-label">' . $post_navigation_next_text . '</span><span class="nav-title">%title</span>',
								) );
							}

						# Loop End
						endwhile; 
					?>
				</main>
			</div>
			<?php if( blogberg_get_option( 'single_layout' ) == 'right' ): ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
