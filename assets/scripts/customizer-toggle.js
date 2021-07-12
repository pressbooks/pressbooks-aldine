document.addEventListener( 'DOMContentLoaded', function () {
	let checkbox = document.getElementById( '_customize-input-pb_network_contact_form' );
	let email = document.getElementById( 'customize-control-pb_network_contact_email' );
	let link = document.getElementById( 'customize-control-pb_network_contact_link' );
	let title = document.getElementById( 'customize-control-pb_network_contact_form_title' );

	checkbox.addEventListener( 'click', toggleReadOnly );

	/**
	 *
	 */
	function toggleReadOnly() {
		if ( checkbox.checked === false ) {
			email.classList.add( 'hidden' );
			email.style.cssText = null;

			title.classList.add( 'hidden' );
			title.style.cssText = null;

			link.classList.remove( 'hidden' );
			link.style.cssText = 'display: list-item;';
		} else {
			email.classList.remove( 'hidden' );
			email.style.cssText = 'display: list-item;';

			title.classList.remove( 'hidden' );
			title.style.cssText = 'display: list-item;';

			link.classList.add( 'hidden' );
			link.style.cssText = null;
		}
	}

	toggleReadOnly();

} );
