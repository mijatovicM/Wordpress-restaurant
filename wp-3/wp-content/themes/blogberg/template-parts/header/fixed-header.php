<?php
/**
 * Displays fixed header
 * @since Blogberg 1.0.0
 */
?>

<header id="fixed-header" class="wrapper wrap-fixed-header site-header" role="banner">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-7 col-lg-2">
				<?php
					get_template_part( 'template-parts/header/site', 'branding' );
				?>
			</div>
			<div class="col-lg-8 d-none d-lg-block">
				<div class="main-navigation-wrap">
					<div class="container">
						<div class="wrap-nav main-navigation">
							<div id="navigation">
								<nav class="nav">
									<?php echo blogberg_get_menu( 'primary' ); ?>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-5" id="header-bottom-right-outer">
				<div class="header-icons-wrap text-right">
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
</header><!-- fixed header -->