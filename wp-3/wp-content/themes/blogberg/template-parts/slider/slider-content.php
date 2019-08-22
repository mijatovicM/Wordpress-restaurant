<?php
/**
 * Template part for displaying slider content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Blogberg 1.0.0
 */
?>
<?php
	$class = '';
	if( blogberg_get_option( 'slider_content_alignment' ) == 'center' ){
		$class = 'text-center';
	}
?>
<div class="banner-overlay">
	<div class="slide-inner <?php echo esc_attr( $class ); ?>">
		<article class="post">
			<div class="post-content">
				<?php
				if( 'post' == get_post_type() ):
					$blogberg_cat = blogberg_get_the_category();
					if( $blogberg_cat ):
				?>
						<span class="entry-meta-cat">
							<?php
								$term_link = get_category_link( $blogberg_cat[ 0 ]->term_id );
							?>
							<a href="<?php echo esc_url( $term_link ); ?>">
								<?php echo esc_html( $blogberg_cat[0]->name ); ?>
							</a>
						</span>
				<?php
					endif;
				endif;
				?>
				<header class="post-title">
					<h2>
						<a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
					</h2>
				</header>
				<?php 
					if('post' == get_post_type() ){ 
				?>
					<div class="meta-tag">
						<?php if( !blogberg_get_option( 'disable_archive_date' ) ): ?>
							<div class="meta-time">
								<a href="<?php echo esc_url( blogberg_get_day_link() ); ?>" >
									<?php echo esc_html(get_the_date('M j, Y')); ?>
								</a>
							</div>
						<?php endif; ?>
						<?php if( !blogberg_get_option( 'disable_archive_author' ) ): ?>
							<div class="meta-author">
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
									<?php echo get_the_author(); ?>
								</a>
							</div>
						<?php endif; ?>
						<?php if( !blogberg_get_option( 'disable_archive_comment_link' ) ): ?>
							<div class="meta-comment">
								<a href="<?php comments_link(); ?>">
									<?php echo absint( wp_count_comments( get_the_ID() )->approved ); ?>
								</a>
							</div>
						<?php endif; ?>
					</div>
				<?php } ?>
				<div class="button-container">
					<a href="<?php the_permalink(); ?>" class="button-outline">
						<?php echo blogberg_get_option( 'slider_button_text' ); ?>
					</a>
				</div>
			</div>
		</article>
	</div>
</div>

