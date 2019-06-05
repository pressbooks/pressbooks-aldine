document.addEventListener( 'DOMContentLoaded', function () {
	let checkbox = document.getElementById( '_customize-input-pb_network_contact_form' );
	let email = document.querySelector( '#_customize-input-pb_network_contact_email' );
	let link = document.querySelector( '#_customize-input-pb_network_contact_link' );
	let title = document.querySelector( '#_customize-input-pb_network_contact_form_title' );

	checkbox.addEventListener( 'click', toggleReadOnly );

	function toggleReadOnly(){
		if ( checkbox.checked === false ){
			email.setAttribute( 'readonly', 'readonly' );
			title.setAttribute( 'readonly', 'readonly' );

			link.removeAttribute( 'readonly' );
		} else {
			email.removeAttribute( 'readonly' );
			title.removeAttribute( 'readonly' );

			link.setAttribute( 'readonly', 'readonly' );
		}
	}

	toggleReadOnly();

} )
