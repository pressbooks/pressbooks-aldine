import Typed from 'typed.js';

document.addEventListener( 'DOMContentLoaded', function () {
	let options = {
		strings: [ 'open textbook', 'scholarly monograph', 'thesis', 'reference guide', 'essay collection', 'student portfolio', 'position paper', 'training manual', 'research report', 'collected works' ],
		typeSpeed: 80,
		backSpeed: 40,
		backDelay: 400,
		loop: false,
	};

	new Typed( '#typed', options );

	const hideButton = document.querySelector( '.button-toggle' );

	hideButton.addEventListener( 'click', function () {
		const password = document.querySelector( '.password' );
		password.setAttribute( 'type', password.getAttribute( 'type' ) === 'password' ? 'text' : 'password' );
		const eye = document.querySelector( '.open' );
		const closed = document.querySelector( '.closed' );
		eye.classList.toggle( 'hide' );
		closed.classList.toggle( 'hide' );
	} );
} );
