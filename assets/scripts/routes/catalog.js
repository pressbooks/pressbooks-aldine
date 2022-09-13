const Isotope = require( 'isotope-layout' );
const jQueryBridget = require( 'jquery-bridget' );

export default {
	/**
	 *
	 */
	init() {
		// JavaScript to be fired on the catalog page
		( function () {
			// Get all the <h2> headings
			const headings = document.querySelectorAll( 'fieldset h2' );

			Array.prototype.forEach.call( headings, heading => {
				// Give each <h3> a toggle button child
				heading.innerHTML = `
				<button type="button" aria-expanded="false">
					${ heading.textContent }
					<svg aria-hidden="true" focusable="false" class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="currentColor" fill-rule="evenodd"></path></svg>
				</button>
			  `;

				// Function to create a node list
				// of the content between this <h2> and the next
				/**
				 * @param elem
				 */
				const getContent = elem => {
					let elems = [];
					while (
						elem.nextElementSibling &&
						elem.nextElementSibling.tagName !== 'H2'
					) {
						elems.push( elem.nextElementSibling );
						elem = elem.nextElementSibling;
					}

					// Delete the old versions of the content nodes
					elems.forEach( node => {
						node.parentNode.removeChild( node );
					} );

					return elems;
				};

				// Assign the contents to be expanded/collapsed (array)
				let contents = getContent( heading );

				// Create a wrapper element for `contents` and hide it
				let wrapper = document.createElement( 'div' );
				wrapper.hidden = true;

				// Add each element of `contents` to `wrapper`
				contents.forEach( node => {
					wrapper.appendChild( node );
				} );

				// Add the wrapped content back into the DOM
				// after the heading
				heading.parentNode.insertBefore( wrapper, heading.nextElementSibling );

				// Assign the button
				let btn = heading.querySelector( 'button' );

				/**
				 *
				 */
				btn.onclick = () => {
					// Cast the state as a boolean
					let expanded = btn.getAttribute( 'aria-expanded' ) === 'true' || false;

					// Switch the state
					btn.setAttribute( 'aria-expanded', ! expanded );
					// Switch the content's visibility
					wrapper.hidden = expanded;
				};
			} );
		} )();

		( function () {
			// Get all the <h3> headings
			const headings = document.querySelectorAll( 'fieldset h3' );

			Array.prototype.forEach.call( headings, heading => {
				// Give each <h3> a toggle button child
				heading.innerHTML = `
				<button type="button" aria-expanded="false">
					${ heading.innerHTML }
					<svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="currentColor" fill-rule="evenodd"></path></svg>
				</button>
			  `;

				// Function to create a node list
				// of the content between this <h2> and the next
				/**
				 * @param elem
				 */
				const getContent = elem => {
					let elems = [];
					while (
						elem.nextElementSibling &&
						elem.nextElementSibling.tagName !== 'H3'
					) {
						elems.push( elem.nextElementSibling );
						elem = elem.nextElementSibling;
					}

					// Delete the old versions of the content nodes
					elems.forEach( node => {
						node.parentNode.removeChild( node );
					} );

					return elems;
				};

				// Assign the contents to be expanded/collapsed (array)
				let contents = getContent( heading );

				// Create a wrapper element for `contents` and hide it
				let wrapper = document.createElement( 'div' );
				wrapper.hidden = true;

				// Add each element of `contents` to `wrapper`
				contents.forEach( node => {
					wrapper.appendChild( node );
				} );

				// Add the wrapped content back into the DOM
				// after the heading
				heading.parentNode.insertBefore( wrapper, heading.nextElementSibling );

				// Assign the button
				let btn = heading.querySelector( 'button' );

				/**
				 *
				 */
				btn.onclick = () => {
					// Cast the state as a boolean
					let expanded = btn.getAttribute( 'aria-expanded' ) === 'true' || false;

					// Switch the state
					btn.setAttribute( 'aria-expanded', ! expanded );
					// Switch the content's visibility
					wrapper.hidden = expanded;
				};
			} );
		} )();

		jQuery( $ => {
			jQueryBridget( 'isotope', Isotope, $ );
			let $grid = $( '.books' );
			$grid.isotope( {
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
			} );
			let licenses = document.querySelector( '.license-filters' );
			let subjects = document.querySelector( '.subject-filters' );
			let institutions = document.querySelector( '.institution-filters' );
			let sorts = document.querySelector( '.sorts' );
			let clearFilters = document.querySelector( '.clear-filters' );
			clearFilters.hidden = false;
			licenses.addEventListener( 'click', function ( event ) {
				if ( event.target.type !== 'radio' ) {
					return;
				}

				const subject = subjects.querySelector( 'input[type="radio"]:checked' ).value
					? `[data-subject="${ subjects.querySelector( 'input[type="radio"]:checked' ).value }"]`
					: '';
				const institution = institutions.querySelector( 'input[type="radio"]:checked' ).value
					? `[data-institution*="${ institutions.querySelector( 'input[type="radio"]:checked' ).value }"]`
					: '';
				const license = event.target.value
					? `[data-license="${ event.target.value }"]`
					: '';

				const filterValue = subject || license || institution ? `${ subject }${ license }${ institution }` : '*';

				$grid.isotope( { filter: filterValue } );
			} );
			institutions.addEventListener( 'click', function ( event ) {
				if ( event.target.type !== 'radio' ) {
					return;
				}

				const subject = subjects.querySelector( 'input[type="radio"]:checked' ).value
					? `[data-subject="${ subjects.querySelector( 'input[type="radio"]:checked' ).value }"]`
					: '';
				const license = licenses.querySelector( 'input[type="radio"]:checked' ).value
					? `[data-license="${ licenses.querySelector( 'input[type="radio"]:checked' ).value }"]`
					: '';
				const institution = event.target.value
					? `[data-institution*="${ event.target.value }"]`
					: '';

				const filterValue = subject || license || institution ? `${ subject }${ license }${ institution }` : '*';

				$grid.isotope( { filter: filterValue } );
			} );
			subjects.addEventListener( 'click', function ( event ) {
				if ( event.target.type !== 'radio' ) {
					return;
				}

				const license = licenses.querySelector( 'input[type="radio"]:checked' ).value
					? `[data-license="${ licenses.querySelector( 'input[type="radio"]:checked' ).value }"]`
					: '';
				const institution = institutions.querySelector( 'input[type="radio"]:checked' ).value
					? `[data-institution*="${ institutions.querySelector( 'input[type="radio"]:checked' ).value }"]`
					: '';
				const subject = event.target.value
					? `[data-subject="${ event.target.value }"]`
					: '';

				const filterValue = subject || license || institution ? `${ subject }${ license }${ institution }` : '*';

				$grid.isotope( { filter: filterValue } );
			} );
			clearFilters.addEventListener( 'click', function () {
				let allLicenses = document.getElementById( 'all-licenses' );
				let allSubjects = document.getElementById( 'all-subjects' );
				let allInstitutions = document.getElementById( 'all-institutions' );
				allLicenses.checked = true;
				allSubjects.checked = true;
				allInstitutions.checked = true;
				$grid.isotope( { filter: '*' } );
			} );
			sorts.addEventListener( 'click', function ( event ) {
				if ( event.target.type !== 'radio' ) {
					return;
				}
				$grid.isotope( { sortBy: event.target.value } );
			} );
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
		} );
	},
	/**
	 *
	 */
	finalize() {},
};
