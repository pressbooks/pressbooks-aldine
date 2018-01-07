export default {
	init() {
		// JavaScript to be fired on the home page

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
	finalize() {},
};
