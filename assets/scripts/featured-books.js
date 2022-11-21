/**
 * Disallow duplicate books in the featured books list.
 */
window.addEventListener( 'load', function () {
	const selects = document.querySelectorAll( '#sub-accordion-section-pb_front_page_catalog select' );
	/**
	 *
	 * @param current
	 * @param value
	 */
	let checkOtherValues = function ( current, value ) {
		selects.forEach( function ( select ) {
			if ( current.id !== select.id && select.value === value ) {
				select.selectedIndex = -1;
			}
		} );
	};
	selects.forEach( function ( select ) {
		select.addEventListener( 'change', function ( event ) {
			checkOtherValues( event.target, event.target.value );
		} );
	} );
} );
