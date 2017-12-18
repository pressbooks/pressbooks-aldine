export default {
	init() {
		// JavaScript to be fired on all pages
		$( 'body' )
			.removeClass( 'no-js' )
			.addClass( 'js' );
		$( '.js-header-menu-toggle' ).click( event => {
			event.preventDefault();
			$( event.currentTarget ).toggleClass( '--active' );
			$( '.js-header-nav' ).toggleClass( '--visible' );
		} );
	},
	finalize() {
		// JavaScript to be fired on all pages, after page specific JS is fired
	},
};
