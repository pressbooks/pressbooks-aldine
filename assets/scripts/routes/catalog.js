const jQueryBridget = require('jquery-bridget');
const Isotope = require('isotope-layout');

export default {
	init() {
		// JavaScript to be fired on the catalog page
		(function() {
			// Get all the <h2> headings
			const headings = document.querySelectorAll('fieldset h2');

			Array.prototype.forEach.call(headings, heading => {
				// Give each <h3> a toggle button child
				heading.innerHTML = `
				<button type="button" aria-expanded="false">
					${heading.textContent}
					<svg aria-hidden="true" focusable="false" class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="currentColor" fill-rule="evenodd"></path></svg>
				</button>
			  `;

				// Function to create a node list
				// of the content between this <h2> and the next
				const getContent = elem => {
					let elems = [];
					while (
						elem.nextElementSibling &&
						elem.nextElementSibling.tagName !== 'H2'
					) {
						elems.push(elem.nextElementSibling);
						elem = elem.nextElementSibling;
					}

					// Delete the old versions of the content nodes
					elems.forEach(node => {
						node.parentNode.removeChild(node);
					});

					return elems;
				};

				// Assign the contents to be expanded/collapsed (array)
				let contents = getContent(heading);

				// Create a wrapper element for `contents` and hide it
				let wrapper = document.createElement('div');
				wrapper.hidden = true;

				// Add each element of `contents` to `wrapper`
				contents.forEach(node => {
					wrapper.appendChild(node);
				});

				// Add the wrapped content back into the DOM
				// after the heading
				heading.parentNode.insertBefore(wrapper, heading.nextElementSibling);

				// Assign the button
				let btn = heading.querySelector('button');

				btn.onclick = () => {
					// Cast the state as a boolean
					let expanded = btn.getAttribute('aria-expanded') === 'true' || false;

					// Switch the state
					btn.setAttribute('aria-expanded', !expanded);
					// Switch the content's visibility
					wrapper.hidden = expanded;
				};
			});
		})();

		(function() {
			// Get all the <h3> headings
			const headings = document.querySelectorAll('fieldset h3');

			Array.prototype.forEach.call(headings, heading => {
				// Give each <h3> a toggle button child
				heading.innerHTML = `
				<button type="button" aria-expanded="false">
					${heading.textContent}
					<svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="currentColor" fill-rule="evenodd"></path></svg>
				</button>
			  `;

				// Function to create a node list
				// of the content between this <h2> and the next
				const getContent = elem => {
					let elems = [];
					while (
						elem.nextElementSibling &&
						elem.nextElementSibling.tagName !== 'H3'
					) {
						elems.push(elem.nextElementSibling);
						elem = elem.nextElementSibling;
					}

					// Delete the old versions of the content nodes
					elems.forEach(node => {
						node.parentNode.removeChild(node);
					});

					return elems;
				};

				// Assign the contents to be expanded/collapsed (array)
				let contents = getContent(heading);

				// Create a wrapper element for `contents` and hide it
				let wrapper = document.createElement('div');
				wrapper.hidden = true;

				// Add each element of `contents` to `wrapper`
				contents.forEach(node => {
					wrapper.appendChild(node);
				});

				// Add the wrapped content back into the DOM
				// after the heading
				heading.parentNode.insertBefore(wrapper, heading.nextElementSibling);

				// Assign the button
				let btn = heading.querySelector('button');

				btn.onclick = () => {
					// Cast the state as a boolean
					let expanded = btn.getAttribute('aria-expanded') === 'true' || false;

					// Switch the state
					btn.setAttribute('aria-expanded', !expanded);
					// Switch the content's visibility
					wrapper.hidden = expanded;
				};
			});
		})();

		jQuery($ => {
			jQueryBridget('isotope', Isotope, $);
			let $grid = $('.books');
			$grid.isotope({
				itemSelector: '.book',
				getSortData: {
					title: '.book__title a',
					subject: '[data-subject]',
					latest: '[data-date-published]',
				},
				sortAscending: {
					title: true,
					subject: false,
					latest: false,
				},
			});
			let licenses = document.querySelector('.license-filters');
			let subjects = document.querySelector('.subject-filters');
			let sorts = document.querySelector('.sorts');
			licenses.addEventListener('click', function(event) {
				if (event.target.type !== 'radio') {
					return;
				}
				let license = '';
				let subject = '';
				if (subjects.querySelector('input[type="radio"]:checked').value) {
					subject = `[data-subject="${
						subjects.querySelector('input[type="radio"]:checked').value
					}"]`;
				}
				license = `[data-license="${event.target.value}"]`;
				alert(`[data-license="${event.target.value}"]${subject}`);
				$grid.isotope({
					filter: `[data-license="${event.target.value}"]${subject}`,
				});
			});
			subjects.addEventListener('click', function(event) {
				if (event.target.type !== 'radio') {
					return;
				}
				let license = '';
				let subject = '';
				if (licenses.querySelector('input[type="radio"]:checked').value) {
					license = `[data-license="${
						licenses.querySelector('input[type="radio"]:checked').value
					}"]`;
				}
				subject = `[data-subject="${event.target.value}"]`;
				alert(`${license}[data-subject="${event.target.value}"]`);
				$grid.isotope({
					filter: `${license}${subject}`,
				});
			});
			sorts.addEventListener('click', function(event) {
				if (event.target.type !== 'radio') {
					return;
				}
				$grid.isotope({ sortBy: event.target.value });
			});
			// 	$('.filters > a').click(e => {
			// 		e.preventDefault();
			// 		$('.filters').toggleClass('is-active');
			// 		$('.filter-groups > div').removeClass('is-active');
			// 	});
			// 	$('.filter-groups .subjects > a').click(e => {
			// 		e.preventDefault();
			// 		let id = $(e.currentTarget).attr('href');
			// 		$(`.filter-groups .subjects:not(${id})`).removeClass('is-active');
			// 		$(`.filter-groups ${id}`).toggleClass('is-active');
			// 	});
			// 	$('.licenses > a').click(e => {
			// 		e.preventDefault();
			// 		let id = $(e.currentTarget).attr('href');
			// 		$(id).toggleClass('is-active');
			// 	});
			// 	$('.subjects .filter-list a').click(e => {
			// 		e.preventDefault();
			// 		if ($(e.currentTarget).hasClass('is-active')) {
			// 			$('.subjects .filter-list a').removeClass('is-active');
			// 			$('.subjects').removeClass('has-active-child');
			// 		} else {
			// 			$('.subjects .filter-list a').removeClass('is-active');
			// 			$(e.currentTarget).addClass('is-active');
			// 			$('.subjects').removeClass('has-active-child');
			// 			$(e.currentTarget)
			// 				.parent()
			// 				.parent()
			// 				.parent('.subjects')
			// 				.addClass('has-active-child');
			// 		}
			// 		let subjectValue = $('.subjects .filter-list a.is-active').attr(
			// 			'data-filter'
			// 		);
			// 		let licenseValue = $('.licenses .filter-list a.is-active').attr(
			// 			'data-filter'
			// 		);
			// 		if (typeof licenseValue === 'undefined') {
			// 			licenseValue = '';
			// 		} else {
			// 			licenseValue = `[data-license="${licenseValue}"]`;
			// 		}
			// 		if (typeof subjectValue === 'undefined') {
			// 			subjectValue = '';
			// 		} else {
			// 			subjectValue = `[data-subject="${subjectValue}"]`;
			// 		}
			// 		$grid.isotope({ filter: `${subjectValue}${licenseValue}` });
			// 	});
			// 	$('.licenses .filter-list a').click(e => {
			// 		e.preventDefault();
			// 		if ($(e.currentTarget).hasClass('is-active')) {
			// 			$('.licenses .filter-list a').removeClass('is-active');
			// 			$('.licenses').removeClass('has-active-child');
			// 		} else {
			// 			$('.licenses .filter-list a').removeClass('is-active');
			// 			$(e.currentTarget).addClass('is-active');
			// 			$('.licenses').addClass('has-active-child');
			// 		}
			// 		let subjectValue = $('.subjects .filter-list a.is-active').attr(
			// 			'data-filter'
			// 		);
			// 		let licenseValue = $('.licenses .filter-list a.is-active').attr(
			// 			'data-filter'
			// 		);
			// 		if (typeof licenseValue === 'undefined') {
			// 			licenseValue = '';
			// 		} else {
			// 			licenseValue = `[data-license="${licenseValue}"]`;
			// 		}
			// 		if (typeof subjectValue === 'undefined') {
			// 			subjectValue = '';
			// 		} else {
			// 			subjectValue = `[data-subject="${subjectValue}"]`;
			// 		}
			// 		$grid.isotope({ filter: `${subjectValue}${licenseValue}` });
			// 	});
			// 	$('.sort > a').click(e => {
			// 		e.preventDefault();
			// 		$('.sort').toggleClass('is-active');
			// 	});
			// 	$('.sorts a').click(e => {
			// 		e.preventDefault();
			// 		let sortBy = $(e.currentTarget).attr('data-sort');
			// 		$('.sorts a').removeClass('is-active');
			// 		$(e.currentTarget).addClass('is-active');
			// 		$grid.isotope({ sortBy: sortBy });
			// 	});
		});
	},
	finalize() {},
};
