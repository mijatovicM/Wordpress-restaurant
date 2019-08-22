<?php
/**
 * Template part for displaying slider section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Blogberg 1.0.0
 */

$slider_layout_class = '';
$slider_type_class = '';

if( blogberg_get_option( 'slider_layout' ) == 'slider_layout_one' ){
	$slider_layout_class = 'block-slider-one';
}

if( blogberg_get_option( 'slider_type' ) == 'box' ){
	$slider_type_class = 'container';
}

$posts_per_page_count = blogberg_get_option( 'slider_posts_number' );
$slider_id = blogberg_get_option( 'slider_category' );

$args = array(
	'posts_per_page'      => $posts_per_page_count,
	'offset'              => 0,
	'category'            => $slider_id,
	'ignore_sticky_posts' => 1
);
$posts_array = get_posts( $args );
$show_slider = count( $posts_array ) > 0 && !blogberg_get_option( 'disable_slider' ) && is_home();

if( $show_slider ){
	?>
	<section class="block-slider <?php echo esc_attr( $slider_layout_class ); ?>">
		<div class="<?php echo esc_attr( $slider_type_class ); ?>">
			<?php
			if( !blogberg_get_option( 'disable_slider_control' ) ):
				if( blogberg_get_option( 'slider_layout' ) == 'slider_layout_one' ){ ?>
					<div class="controls"></div>
					<div class="owl-pager" id="slide-pager"></div>
				<?php
				}else {
				?>
					<div class="controls">
						<div class="owl-pager" id="slide-pager"></div>
					</div>
				<?php
				}
			endif;
			?>
			<div class="home-slider owl-carousel">
				<?php
					foreach ( $posts_array as $post ) : setup_postdata( $post );
						$image = blogberg_get_thumbnail_url( array( 'size' => 'blogberg-1200-710' ) );
				?>
					<div class="slide-item" style="background-image: url( <?php echo esc_url( $image ); ?> );">
						<?php get_template_part( 'template-parts/slider/slider', 'content' ); ?>
					</div>
				<?php
					endforeach;
					wp_reset_postdata();
				?>
			</div>
			<div id="after-slider"></div>
		</div>
	</section>
	<?php //slider layout end
}else {
		/**
		* Prints Title and breadcrumbs for archive pages
		* @since Blogberg 1.0.0
		*/
	blogberg_inner_banner();
}