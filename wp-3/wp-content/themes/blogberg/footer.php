<?php
/**
 * The template for displaying the footer
 * Contains the closing of the body tag and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since Blogberg 1.0.0
 */
?>
	</div> <!-- site main end -->
	<div class="instagram-wrapper">
		<div class="container">
			<?php 
				/**
				* Prints Instagram
				* 
				* @since Blogberg 1.0.0
				*/
				if( blogberg_get_option( 'enable_instagram' ) ){
					echo do_shortcode( blogberg_get_option( 'insta_shortcode' ) );
				}
			?>
		</div>
	</div>
	
	
	<?php
	$footer_layout_class = '';
	if( blogberg_get_option( 'footer_layout' ) == 'footer_one' ){
		$footer_layout_class = 'site-footer-primary';
	}
	?>
	<footer id="colophon" class="site-footer <?php echo esc_attr( $footer_layout_class ); ?>">
		<?php get_template_part('template-parts/footer/top', 'footer'); ?>
		<div class="bottom-footer">
			<?php if( blogberg_get_option( 'footer_layout' ) == 'footer_one' ): ?>
				<div class="container">
					<?php if( !blogberg_get_option( 'disable_footer_logo' ) ): ?>
						<div class="footer-logo">
							<p>
							<?php
								if( !blogberg_get_option( 'site_identity_options' ) == 'site_identity_hide_all' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_show_all' || !blogberg_get_option( 'site_identity_options' ) == 'site_identity_title_only' || !blogberg_get_option( 'site_identity_options' ) == 'site_identity_tagline_only' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_logo_title' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_logo_tagline' ){
									the_custom_logo();
								}
							?>
							</p>
						</div>
					<?php endif; ?>
					<?php if ( has_nav_menu( 'footer' ) ): ?>
						<div class="footer-menu-wrap">
							<?php echo blogberg_get_menu( 'footer' ); ?>
						</div>
					<?php endif; ?>
					<?php if( has_nav_menu( 'social' )): ?>
						<div class="socialgroup">
							<?php echo blogberg_get_menu( 'social' ); ?>
						</div>
					<?php endif; ?>
					<?php get_template_part('template-parts/footer/site', 'info'); ?>
				</div>
			<?php endif; ?>
		</div>
	</footer>
	<?php wp_footer(); ?>
	</body>
</html>