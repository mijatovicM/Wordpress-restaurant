
// start the popup specefic scripts
// safe to use $
jQuery(document).ready(function($) {
    var flos = {
    	loadVals: function()
    	{
            var shortcode = $('#_flo_shortcode').text(),
    			uShortcode = shortcode;
    		
    		// fill in the gaps eg {{param}}
    		$('.flo-input').each(function() {
    			var input = $(this),
    				id = input.attr('id'),
    				id = id.replace('flo_', ''),		// gets rid of the flo_ prefix
    				re = new RegExp("{{"+id+"}}","g");
    				
    			uShortcode = uShortcode.replace(re, input.val());
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_flo_ushortcode').remove();
    		$('#flo-sc-form-table').prepend('<div id="_flo_ushortcode" class="hidden">' + uShortcode + '</div>');
    	},
    	cLoadVals: function()
    	{
    		var shortcode = $('#_flo_cshortcode').text(),
    			pShortcode = '';
    			shortcodes = '';
    		
    		// fill in the gaps eg {{param}}
    		$('.child-clone-row').each(function() {
    			var row = $(this),
    				rShortcode = shortcode;
    			
    			$('.flo-cinput', this).each(function() {
    				var input = $(this),
    					id = input.attr('id'),
    					id = id.replace('flo_', '')		// gets rid of the flo_ prefix
    					re = new RegExp("{{"+id+"}}","g");
    					
    				rShortcode = rShortcode.replace(re, input.val());
    			});
    	
    			shortcodes = shortcodes + rShortcode + "\n";
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_flo_cshortcodes').remove();
    		$('.child-clone-rows').prepend('<div id="_flo_cshortcodes" class="hidden">' + shortcodes + '</div>');
    		
    		// add to parent shortcode
    		this.loadVals();
    		pShortcode = $('#_flo_ushortcode').text().replace('{{child_shortcode}}', shortcodes);
    		
    		// add updated parent shortcode
    		$('#_flo_ushortcode').remove();
    		$('#flo-sc-form-table').prepend('<div id="_flo_ushortcode" class="hidden">' + pShortcode + '</div>');
    	},
    	children: function()
    	{
    		// assign the cloning plugin
    		$('.child-clone-rows').appendo({
    			subSelect: '> div.child-clone-row:last-child',
    			allowDelete: false,
    			focusFirst: false
    		});
    		
    		// remove button
    		$('.child-clone-row-remove').live('click', function() {
    			var	btn = $(this),
    				row = btn.parent();
    			
    			if( $('.child-clone-row').size() > 1 )
    			{
    				row.remove();
    			}
    			else
    			{
    				alert('You need a minimum of one row');
    			}
    			
    			return false;
    		});
    		
    		// assign jUI sortable
    		$( ".child-clone-rows" ).sortable({
				placeholder: "sortable-placeholder",
				items: '.child-clone-row'
				
			});
    	},
    	resizeTB: function()
    	{
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				floPopup = $('#flo-popup');

            tbWindow.css({
                height: floPopup.outerHeight() + 50,
                width: floPopup.outerWidth(),
                marginLeft: -(floPopup.outerWidth()/2)
            });

			ajaxCont.css({
				paddingTop: 0,
				paddingLeft: 0,
				paddingRight: 0,
				height: (tbWindow.outerHeight()-47),
				overflow: 'auto', // IMPORTANT
				width: floPopup.outerWidth()
			});
			
			$('#flo-popup').addClass('no_preview');
    	},
    	load: function()
    	{
    		var	flos = this,
    			popup = $('#flo-popup'),
    			form = $('#flo-sc-form', popup),
    			shortcode = $('#_flo_shortcode', form).text(),
    			popupType = $('#_flo_popup', form).text(),
    			uShortcode = '';
    		
    		// resize TB
    		flos.resizeTB();
    		$(window).resize(function() { flos.resizeTB() });
    		
    		// initialise
    		flos.loadVals();
    		flos.children();
    		flos.cLoadVals();
    		
    		// update on children value change
    		$('.flo-cinput', form).live('change', function() {
    			flos.cLoadVals();
    		});
    		
    		// update on value change
    		$('.flo-input', form).change(function() {
    			flos.loadVals();
    		});
    		
    		// when insert is clicked
    		$('.flo-insert', form).click(function() {    		 			
    			if(window.tinyMCE)
				{
					
                    if(is_wp_39 === '1'){
                        tinymce.activeEditor.insertContent($('#_flo_ushortcode', form).html());
                    }else{ // backwards compatibility
                        window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, $('#_flo_ushortcode', form).html());
                        //window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, $('#_cosmo_ushortcode', form).html());
                        
                    }
					tb_remove();
				}
    		});
    	}
	}
    
    // run
    $('#flo-popup').livequery( function() { flos.load(); } );
});