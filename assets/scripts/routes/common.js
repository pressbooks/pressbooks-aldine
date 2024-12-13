export default {
	init() {
		// JavaScript to be fired on all pages
		document.body.classList.replace('no-js', 'js');

		// Make all <section> elements focusable
		document.addEventListener('DOMContentLoaded', () => {
			const sections = document.querySelectorAll('section');
			sections.forEach(section => {
				section.setAttribute('tabindex', '-1');
				section.classList.add('focusable');
			});

			// Smooth scroll to anchor if there's a hash in the URL & anchor exists on the page
			if (document.location.hash && document.location.hash !== '#') {
				const anchorElement = document.querySelector(document.location.hash);
				if (anchorElement) {
					anchorElement.scrollIntoView({ behavior: 'smooth' });
					anchorElement.focus();
				} else {
					console.warn(`Anchor element "${document.location.hash}" not found in the document.`);
				}
			}

			// Toggle navigation menu
			const navToggle = document.querySelector('.js-header-nav-toggle');
			if (navToggle) {
				navToggle.addEventListener('click', event => {
					event.preventDefault();
					const navMenu = document.querySelector('.header__nav');
					if (navMenu) {
						navMenu.classList.toggle('header__nav--active');
					}
				});
			}

			// Form validation helpers
			const inputs = document.querySelectorAll('input, textarea');
			inputs.forEach(input => {
				input.addEventListener('invalid', () => {
					input.classList.add('error');
				});
				input.addEventListener('focus', () => {
					input.classList.remove('error');
				});
				input.addEventListener('blur', () => {
					input.checkValidity();
				});
			});
		});
	},
	finalize() {
		// JavaScript to be fired on all pages, after page specific JS is fired
	},
};
