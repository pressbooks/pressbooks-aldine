<?php
/**
 * Template part for displaying the contact form
 *
 * @package Aldine
 */
?>

<?php

$contact_form_title = get_option( 'pb_network_contact_form_title', __( 'Contact Us', 'pressbooks-aldine' ) );
$contact_form_response = \Aldine\Helpers\handle_contact_form_submission();

?>

<section class="contact" id="contact">
	<h2><?php echo $contact_form_title; ?></h2>
	<form class="form" action="<?php echo network_home_url( '/#contact' ); ?>" method="post">
		<?php if ( $contact_form_response ) : ?>
		<p class="form__notice form__notice--<?php echo $contact_form_response['status']; ?>"><?php echo $contact_form_response['message']; ?></p>
		<?php endif; ?>
		<?php wp_nonce_field( 'pb_root_contact_form', 'pb_root_contact_form_nonce' ); ?>
		<input type="hidden" name="submitted" value="1">
		<p class="form__row<?php if ( isset( $contact_form_response['field'] ) && $contact_form_response['field'] === 'visitor_name' ) : ?> form__row--error<?php endif; ?>">
			<input type="text" aria-label="<?php _e( 'Your name (required)', 'pressbooks-aldine' ); ?>" placeholder="<?php _e( 'Your name*', 'pressbooks-aldine' ); ?>" name="visitor_name" value="<?php if ( $contact_form_response['status'] === 'error' ) :
				echo $contact_form_response['values']['visitor_name'];
			endif; ?>" required></p>
		<p class="form__row<?php if ( isset( $contact_form_response['field'] ) && $contact_form_response['field'] === 'visitor_email' ) : ?> form__row--error<?php endif; ?>">
			<input type="email" aria-label="<?php _e( 'Your email address (required)', 'pressbooks-aldine' ); ?>" placeholder="<?php _e( 'Your email*', 'pressbooks-aldine' ); ?>" name="visitor_email" value="<?php if ( $contact_form_response['status'] === 'error' ) :
				echo $contact_form_response['values']['visitor_email'];
			endif; ?>" required></p>
		<p class="form__row<?php if ( isset( $contact_form_response['field'] ) && $contact_form_response['field'] === 'visitor_institution' ) : ?> form__row--error<?php endif; ?>">
			<input type="text" aria-label="<?php _e( 'Your institution (required)', 'pressbooks-aldine' ); ?>" placeholder="<?php _e( 'Your institution*', 'pressbooks-aldine' ); ?>" name="visitor_institution" value="<?php if ( $contact_form_response['status'] === 'error' ) :
				echo $contact_form_response['values']['visitor_institution'];
			endif; ?>" required></p>
		<p class="form__row<?php if ( isset( $contact_form_response['field'] ) && $contact_form_response['field'] === 'message' ) : ?> form__row--error<?php endif; ?>">
			<textarea type="text" aria-label="<?php _e( 'Your message (required)', 'pressbooks-aldine' ); ?>" placeholder="<?php _e( 'Your message here*', 'pressbooks-aldine' ); ?>" name="message" required><?php if ( $contact_form_response['status'] === 'error' ) :
				echo $contact_form_response['values']['message'];
			endif; ?></textarea></p>
		<p class="form__row"><input class="button button--small button--outline" type="submit" value="<?php _e( 'Send', 'pressbooks-aldine' ); ?>" /></p>
	</form>
</section>
