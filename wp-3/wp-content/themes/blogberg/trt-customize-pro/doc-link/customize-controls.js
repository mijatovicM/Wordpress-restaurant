( function( api ) {

	// Extends our custom "doc-link" section.
	api.sectionConstructor['doc-link'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
