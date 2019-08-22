jQuery(document).ready(function(){

	if(jQuery(window).width() > 600){
		// init fanctbox
		if(jQuery("a[data-fancybox-group^='fancybox_instagram']").length  ){
			jQuery("a[data-fancybox-group^='fancybox_instagram']").colorbox({rel :'colorbox_instagram'});
		}
		
	}else{
		jQuery('.flo-shcode-instgm-container .inner-img-block a[data-fancybox-group^="fancybox_instagram"]').click(function(event) {
			event.preventDefault();
		});
	}

});

function floInstNavigate(dir){
	//alert('.flo-instagram-navigation .fancybox-'+dir );
	jQuery( '.flo-instagram-navigation .fancybox-'+dir ).click();
	if(dir === 'next'){
		jQuery.fancybox.next();	
	}

	if(dir === 'prev'){
		jQuery.fancybox.prev();	
	}
	
}

