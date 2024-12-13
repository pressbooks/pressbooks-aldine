export default {
	init() {
		// JavaScript to be fired on all pages
		document.body.classList.replace( 'no-js', 'js' );

		jQuery( $ => {
			$( document ).ready( function () {
				// Sets a -1 tabindex to ALL sections for .focus()-ing
				let sections = document.getElementsByTagName( 'section' );
				for ( let i = 0, max = sections.length; i < max; i++ ) {
					sections[i].setAttribute( 'tabindex', -1 );
					sections[i].className += ' focusable';
				}

				// Scroll to anchor if there's a hash in the URL & anchor exists on the page
				if (document.location.hash && document.location.hash !== '#') {
					const anchorUponArrival = document.location.hash;
					setTimeout(() => {
						const $anchorElement = $(anchorUponArrival);
						if ($anchorElement.length) {
							$anchorElement.scrollTo({ duration: 1500 });
							$anchorElement.trigger('focus');
						} else {
							console.warn(`Anchor element "${anchorUponArrival}" not found in the document.`);
						}
					}, 100);
				}
			} );
			$( '.js-header-nav-toggle' ).on( 'click', event => {
				event.preventDefault();
				$( '.header__nav' ).toggleClass( 'header__nav--active' );
			} );
		} );

		// Check form field validity when focus changes
		const inputs = document.querySelectorAll( 'input, textarea' );
		inputs.forEach( input => {
			input.addEventListener('invalid', () => {
					input.classList.add('error');
				});
			input.addEventListener( 'focus', function () {
				input.classList.remove( 'error' );
			} );
			input.addEventListener('blur', () => {
				if (!input.checkValidity()) {
					input.classList.add('error');
				} else {
					input.classList.remove('error');
				}
			});
		} );
	},
	finalize() {
		// JavaScript to be fired on all pages, after page specific JS is fired
	},
};
