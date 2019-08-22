<?php
/** 
* Template for Off canvas Menu
* @since Blogberg 1.0.0
*/
?>
<div id="offcanvas-menu">
	<div class="close-offcanvas-menu">
		<span class="kfi kfi-close-alt2"></span>
	</div>
	<div class="header-search-wrap">
		<?php get_search_form(); ?>
	</div>
	<div id="primary-nav-offcanvas" class="offcanvas-navigation d-xl-none d-lg-block">
		<?php echo blogberg_get_menu( 'primary' ); ?>
	</div>
	<div id="secondary-nav-offcanvas" class="offcanvas-navigation d-none d-lg-block">
		<?php blogberg_get_menu( 'secondary' ); ?>
	</div>
	<div class="top-header-right">
		<div class="socialgroup">
			<?php blogberg_get_menu( 'social' ); ?>
		</div>
	</div>
</div>