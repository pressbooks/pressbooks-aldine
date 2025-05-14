/* global PB_Ajax */
jQuery( function ( $ ) {
	/**
	 *
	 * @param container
	 */
	function initSearchControl( container ) {
		const $input   = container.find( '.search-books-input' );
		const $results = container.find( '.search-books-results' );
		const settingId = $input.data( 'setting' );

		$input.on( 'input', function () {
			const term = $( this ).val().trim();
			if ( ! term.length ) {
				$results.empty();
				$input
					.attr( 'aria-expanded', 'false' )
					.removeAttr( 'aria-activedescendant' );
				$results.hide();
				return;
			}

			$.get( PB_Ajax.ajax_url, {
				action: 'pb_search_catalog_books',
				q: term,
			}, function ( response ) {
				$results.empty();
				if ( response.success ) {
					response.data.forEach( function ( item ) {
						const $li = $( '<li>' )
							.attr( {
								role: 'option',
								tabindex: -1,
								id: `search-books-option-${ settingId }-${ item.id }`,
								'data-value': item.id,
							} )
							.text( item.text );

						$results.append( $li );
					} );
					$input.attr( 'aria-expanded', response.data.length > 0 );
					$results.show();
				} else {
					$input
						.attr( 'aria-expanded', 'false' )
						.removeAttr( 'aria-activedescendant' );
				}
			} );
		} );

		$results.on( 'click', 'li', function () {
			const id   = $( this ).data( 'value' );
			const text = $( this ).text();

			$input.val( text );
			wp.customize( settingId, function ( value ) {
				value.set( id );
			} );

			$results.empty();
			$input
				.attr( 'aria-expanded', 'false' )
				.removeAttr( 'aria-activedescendant' );
			$results.hide();
		} );

		$input.on( 'keydown', function ( e ) {
			const $options = $results.find( 'li' );
			let $active    = $results.find( '[aria-selected="true"]' );

			if ( e.key === 'ArrowDown' ) {
				e.preventDefault();
				if ( ! $active.length ) {
					$active = $options.first()
						.focus()
						.attr( 'aria-selected', 'true' );
					$input.attr( 'aria-activedescendant', $active.attr( 'id' ) );
				} else {
					const $next = $active.removeAttr( 'aria-selected' ).next( 'li' );
					if ( $next.length ) {
						$active = $next
							.focus()
							.attr( 'aria-selected', 'true' );
						$input.attr( 'aria-activedescendant', $active.attr( 'id' ) );
					}
				}
			}

			if ( e.key === 'ArrowUp' ) {
				e.preventDefault();
				if ( $active.length ) {
					const $prev = $active.removeAttr( 'aria-selected' ).prev( 'li' );
					if ( $prev.length ) {
						$active = $prev
							.focus()
							.attr( 'aria-selected', 'true' );
						$input.attr( 'aria-activedescendant', $active.attr( 'id' ) );
					}
				}
			}

			if ( e.key === 'Enter' && $active.length ) {
				e.preventDefault();
				$active.click();
			}

			if ( e.key === 'Escape' ) {
				$results.empty();
				$input
					.attr( 'aria-expanded', 'false' )
					.removeAttr( 'aria-activedescendant' );
				$results.hide();
			}
		} );

		$results.on( 'keydown', 'li', function ( e ) {
			const $current = $( this );
			if ( e.key === 'ArrowDown' ) {
				e.preventDefault();
				const $next = $current.next( 'li' );
				if ( $next.length ) {
					$current.removeAttr( 'aria-selected' );
					$next.attr( 'aria-selected', 'true' ).focus();
					$input.attr( 'aria-activedescendant', $next.attr( 'id' ) );
				}
			}
			if ( e.key === 'ArrowUp' ) {
				e.preventDefault();
				const $prev = $current.prev( 'li' );
				if ( $prev.length ) {
					$current.removeAttr( 'aria-selected' );
					$prev.attr( 'aria-selected', 'true' ).focus();
					$input.attr( 'aria-activedescendant', $prev.attr( 'id' ) );
				} else {
					$current.removeAttr( 'aria-selected' );
					$input.focus().removeAttr( 'aria-activedescendant' );
				}
			}
			if ( e.key === 'Enter' ) {
				e.preventDefault();
				$current.click();
			}
			if ( e.key === 'Escape' ) {
				e.preventDefault();
				$results.empty();
				$input
					.attr( 'aria-expanded', 'false' )
					.removeAttr( 'aria-activedescendant' );
				$results.hide();
				$input.focus();
			}
		} );
	}

	wp.customize.control.each( function ( control ) {
		const container = control.container;
		if ( container.find( '.search-books-input' ).length ) {
			initSearchControl( container );
		}
	} );
} );
