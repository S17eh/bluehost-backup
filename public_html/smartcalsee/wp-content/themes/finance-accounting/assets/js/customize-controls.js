( function( api ) {

	// Extends our custom "finance-accounting" section.
	api.sectionConstructor['finance-accounting'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );