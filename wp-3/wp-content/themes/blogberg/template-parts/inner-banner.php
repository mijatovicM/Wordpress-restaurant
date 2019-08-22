<?php
/**
* Template for Inner Banner Section for all the inner pages
*
* @since Blogberg 1.0.0
*/
?>

<?php if( blogberg_get_option( 'page_header_layout' ) == 'header_layout_one' ):
	if( is_home() ){ ?>
		<section class="section-banner-wrap section-banner-two">
			<div class="wrap-inner-banner" style="background-image: url('<?php header_image(); ?>')">
				<div class="banner-overlay">
					<div class="container">
						<header class="page-header">
							<div class="inner-header-content">
								<?php 
									if( is_single() && !blogberg_get_option( 'disable_single_date' ) ){
										blogberg_pro_time_link();
									}
								?>
								<h1 class="page-title"><?php echo wp_kses_post( $args[ 'title' ] ); ?></h1>
								<?php if( $args[ 'description' ] ): ?>
									<div class="page-description">
										<?php echo wp_kses_post( $args[ 'description' ] ); ?>
									</div>
								<?php endif; ?>
							</div>
						</header>
					</div>
				</div>
			</div>
			<?php if(!is_front_page() && !blogberg_get_option( 'disable_bradcrumb' ) ): ?>
				<div class="breadcrumb-wrap">
					<div class="container">
						<?php 
							blogberg_breadcrumb();
						?>
					</div>
				</div>
			<?php endif; ?>
		</section>
	<?php }else{ ?>
		<section class="section-banner-wrap section-banner-one">
			<div class="wrap-inner-banner">
				<div class="container">
					<header class="page-header">
						<div class="inner-header-content">
							<?php 
								if( is_single() && !blogberg_get_option( 'disable_single_date' ) ){
									blogberg_time_link();
								}
							?>
							<h1 class="page-title"><?php echo wp_kses_post( $args[ 'title' ] ); ?></h1>
							<?php if( $args[ 'description' ] ): ?>
								<div class="page-description">
									<?php echo wp_kses_post( $args[ 'description' ] ); ?>
								</div>
							<?php endif; ?>
						</div>
					</header>
				</div>
			</div>
			<?php if(!is_front_page() && !blogberg_get_option( 'disable_bradcrumb' ) ): ?>
				<div class="breadcrumb-wrap">
					<div class="container">
						<?php 
							blogberg_breadcrumb();
						?>
					</div>
				</div>
			<?php endif; ?>
		</section>
	<?php } ?>
<?php endif; ?>