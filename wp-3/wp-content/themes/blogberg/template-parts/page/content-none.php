<?php
/**
* Template for those pages which have no content.
* @since Blogberg 1.0.0
*/
?>
<section class="wrap-detail-page error-404">
	<div class="container">
		<div class="inner-page-content">
			<div class="row">
				<div class="col-12 col-md-8 offset-md-2">
					<div class="content">
						<h1 class="section-title">
							<?php
								if( is_404() ){

									esc_html_e( 'Page Not Found', 'blogberg' ); 
								}else{

									esc_html_e( 'Nothing Found', 'blogberg' ); 
								}
							?>
						</h1>
						<span class="sub-title">
							<?php
								if( is_404() ){

									esc_html_e( 'It looks like nothing was found. Want to try another by search?', 'blogberg' ); 
								}else{

									esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps another searching can help.', 'blogberg' ); 
								}
							?>
						</span>
						<div class="content">
							<?php 
								if( is_404() ){
									get_search_form();
								}else{
									if( current_user_can( 'publish_posts' ) ){
								?>
										<a class="button-primary" href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>">
										    <?php echo esc_html__( 'Add New Post', 'blogberg' ); ?> 
										</a>
								<?php
									}else{
										get_search_form();
									}
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>