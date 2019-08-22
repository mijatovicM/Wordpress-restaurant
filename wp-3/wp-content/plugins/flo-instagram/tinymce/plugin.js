(function ()
{
	// create floShortcodes plugin
	tinymce.create("tinymce.plugins.floShortcodes",
	{
		init: function ( ed, url )
		{
			ed.addCommand("floPopup", function ( a, params )
			{
				var popup = params.identifier;
				
				// load thickbox
				tb_show("Insert Flo Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
			});
		},
		createControl: function ( btn, e )
		{
			if ( btn == "flo_button" )
			{	
				var a = this;
				
				var btn = e.createSplitButton('flo_button', {
                    title: "Insert Flo Shortcode",
					image: floShortcodes.plugin_folder +"/tinymce/images/icon.png",
					icons: false
                });

                btn.onRenderMenu.add(function (c, b)
				{	
					a.addWithPopup( b, "Instagram feed", "flo_instagram" );
					a.addWithPopup( b, "Instagram follow button", "flo_instagram_follow" );
					
				});
                
                return btn;
			}
			
			return null;
		},
		addWithPopup: function ( ed, title, id ) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand("floPopup", false, {
						title: title,
						identifier: id
					})
				}
			})
		},
		addImmediate: function ( ed, title, sc) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
				}
			})
		} 
	});
	
	// add floShortcodes plugin
	tinymce.PluginManager.add("floShortcodes", tinymce.plugins.floShortcodes);
})();

/*  WP 3.9 compatibility  */

function floCreateShortcodeButton(name, tb_name, button_url, theme){
	return ''+
	+'{'+
        'text: '+ name +','+
        'value: '+ name +','+
        'onclick: function() {'+
        '    tb_show("Insert Flo Shortcode", ' + button_url + '/popup.php?popup='+tb_name+'&width=800);'+
        '}'+
    '},';
}




(function() {
    tinymce.PluginManager.add('flo_instagram_tc_button', function( editor, url ) {

    	editor.addButton( 'flo_instagram_tc_button', {
            title: 'Flo Instagram Plugin',
            type: 'menubutton',
            icon: 'icon flo-insta-icon',
            menu: [

                {
                    text: 'Instagram feed',
                    value: 'Instagram feed',
                    onclick: function() {
                        tb_show("Insert instagram Shortcode", url + "/popup.php?popup=" + 'flo_instagram' + "&width=" + 800);
                    }
                },
                {
                    text: 'Instagram follow button',
                    value: 'Instagram follow button',
                    onclick: function() {
                        tb_show("Insert instagram Shortcode", url + "/popup.php?popup=" + 'flo_instagram_follow' + "&width=" + 800);
                    }
                },
                
                
                
           ]
        });
    });
})();
