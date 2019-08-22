<?php
/**
 * Displays header layout one
 * @since Blogberg 1.0.0
 */
?>

<header id="masthead" class="wrapper site-header site-header-primary" role="banner">
	<?php if( display_header_text() || has_custom_logo() ): ?>
		<div class="top-header">
			<div class="container">
				<div class="main-navigation-wrap">
					<div class="row align-items-center">
						<div class="col-lg-9 d-none d-lg-block">
							<div class="wrap-nav main-navigation">
								<div id="navigation" class="d-none d-lg-block">
									<nav class="nav">
										<?php echo blogberg_get_menu( 'primary' ); ?>
									</nav>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-12">
							<div class="header-icons-wrap text-right">
								<div class="socialgroup">
									<?php echo blogberg_get_menu( 'social' ); ?>
								</div>
								<?php get_template_part('template-parts/header/header', 'search'); ?>
								<?php
									$hamburger_menu_class = '';
									if( blogberg_get_option( 'disable_hamburger_menu_icon' ) ){
										$hamburger_menu_class = 'd-inline-block d-lg-none';
									}
								?>
								<span class="alt-menu-icon <?php echo esc_attr( $hamburger_menu_class ); ?>">
									<a class="offcanvas-menu-toggler" href="#">
										<span class="icon-bar"></span>
									</a>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="site-branding-wrap">
		<div class="container">
			<?php
				get_template_part( 'template-parts/header/site', 'branding' );
			?>
		</div>
	</div>
	<!-- Search form structure -->
	<div class="header-search-wrap">
		<div id="search-form">
			<?php get_search_form(); ?>
		</div>
	</div>
</header>