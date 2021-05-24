export default {
	init() {
		// JavaScript to be fired on all pages
		// JavaScript to be fired on all pages
		document.body.classList.remove( 'no-js' );
		document.body.classList.add( 'js' );

		jQuery( $ => {
			$( document ).ready( function () {
				// Sets a -1 tabindex to ALL sections for .focus()-ing
				let sections = document.getElementsByTagName( 'section' );
				for ( let i = 0, max = sections.length; i < max; i++ ) {
					sections[i].setAttribute( 'tabindex', -1 );
					sections[i].className += ' focusable';
				}

				// If there is a '#' in the URL (someone linking directly to a page with an anchor), go directly to that area and focus is
				// Thanks to WebAIM.org for this idea
				if ( document.location.hash && document.location.hash !== '#' ) {
					let anchorUponArrival = document.location.hash;
					setTimeout( function () {
						$( anchorUponArrival ).scrollTo( { duration: 1500 } );
						$( anchorUponArrival ).trigger( 'focus' );
					}, 100 );
				}
			} );
			$( '.js-header-nav-toggle' ).on( 'click', event => {
				event.preventDefault();
				$( '.header__nav' ).toggleClass( 'header__nav--active' );
			} );
		} );
		// Props to Dave Rupert: https://daverupert.com/2017/11/happier-html5-forms/
		const inputs = document.querySelectorAll( 'input, textarea' );

		inputs.forEach( input => {
			input.addEventListener(
				'invalid',
				event => {
					input.classList.add( 'error' );
				},
				false
			);
			input.addEventListener( 'focus', function () {
				input.classList.remove( 'error' );
			} );
			input.addEventListener( 'blur', function () {
				input.checkValidity();
			} );
		} );
	},
	finalize() {
		// JavaScript to be fired on all pages, after page specific JS is fired
	},
};
