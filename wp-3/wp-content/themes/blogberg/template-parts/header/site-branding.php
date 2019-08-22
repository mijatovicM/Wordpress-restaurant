<?php
/**
 * Displays header site branding
 * @since Blogberg 1.0.0
 */
?>

<?php if( !blogberg_get_option( 'site_identity_options' ) == 'site_identity_hide_all' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_show_all' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_title_only' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_tagline_only' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_logo_title' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_logo_tagline' ): ?>
	<div class="site-branding-outer">
		<div class="site-branding">
		<?php
			if( !blogberg_get_option( 'site_identity_options' ) == 'site_identity_hide_all' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_show_all' || !blogberg_get_option( 'site_identity_options' ) == 'site_identity_title_only' || !blogberg_get_option( 'site_identity_options' ) == 'site_identity_tagline_only' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_logo_title' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_logo_tagline' ){
				the_custom_logo();
			}

			if( display_header_text() ){
				
				if ( is_front_page() && !is_home() ){
					if( get_bloginfo( 'name' ) && ( !blogberg_get_option( 'site_identity_options' ) == 'site_identity_hide_all' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_show_all' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_title_only' || !blogberg_get_option( 'site_identity_options' ) == 'site_identity_tagline_only' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_logo_title' || !blogberg_get_option( 'site_identity_options' ) == 'site_identity_logo_tagline' ) ){
						?>
							<h1 class="site-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?>
								</a>
							</h1>
						<?php
					}

				}else {
					if( get_bloginfo( 'name' ) && ( !blogberg_get_option( 'site_identity_options' ) == 'site_identity_hide_all' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_show_all' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_title_only' || !blogberg_get_option( 'site_identity_options' ) == 'site_identity_tagline_only' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_logo_title' || !blogberg_get_option( 'site_identity_options' ) == 'site_identity_logo_tagline' ) ){
						?>
							<p class="site-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
									<?php bloginfo( 'name' ); ?>
								</a>
							</p>
						<?php
					}
				}
				
				if( get_bloginfo( 'description' ) && ( !blogberg_get_option( 'site_identity_options' ) == 'site_identity_hide_all' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_show_all' || !blogberg_get_option( 'site_identity_options' ) == 'site_identity_title_only' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_tagline_only' || !blogberg_get_option( 'site_identity_options' ) == 'site_identity_logo_title' || blogberg_get_option( 'site_identity_options' ) == 'site_identity_logo_tagline' ) ){
					?>
						<p class="site-description">
							<?php echo get_bloginfo( 'description', 'display' ); ?>
						</p>
					<?php
				}
			}
		?>
		</div><!-- .site-branding -->
	</div>
<?php endif; ?>