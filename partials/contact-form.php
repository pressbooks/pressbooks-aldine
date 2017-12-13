<?php
/**
 * Template part for displaying the contact form
 *
 * @package Aldine
 */
?>

<?php

$contact_form_title = get_option( 'pb_network_contact_form_title', __( 'Contact Us', 'aldine' ) );
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
			<label class="clip" for="visitor_name"><?php _e( 'Your name*', 'aldine' ); ?></label>
			<input type="text" placeholder="<?php _e( 'Your name*', 'aldine' ); ?>" name="visitor_name" value="<?php if ( $contact_form_response['status'] === 'error' ) :
				echo $contact_form_response['values']['visitor_name'];
			endif; ?>" required></p>
		<p class="form__row<?php if ( isset( $contact_form_response['field'] ) && $contact_form_response['field'] === 'visitor_email' ) : ?> form__row--error<?php endif; ?>">
			<label class="clip" for="visitor_email"><?php _e( 'Your email*', 'aldine' ); ?></label>
			<input type="email" placeholder="<?php _e( 'Your email*', 'aldine' ); ?>" name="visitor_email" value="<?php if ( $contact_form_response['status'] === 'error' ) :
				echo $contact_form_response['values']['visitor_email'];
			endif; ?>" required></p>
		<p class="form__row<?php if ( isset( $contact_form_response['field'] ) && $contact_form_response['field'] === 'visitor_institution' ) : ?> form__row--error<?php endif; ?>">
			<label class="clip" for="visitor_institution"><?php _e( 'Your institution*', 'aldine' ); ?></label>
			<input type="text" placeholder="<?php _e( 'Your institution*', 'aldine' ); ?>" name="visitor_institution" value="<?php if ( $contact_form_response['status'] === 'error' ) :
				echo $contact_form_response['values']['visitor_institution'];
			endif; ?>" required></p>
		<p class="form__row<?php if ( isset( $contact_form_response['field'] ) && $contact_form_response['field'] === 'message' ) : ?> form__row--error<?php endif; ?>">
			<label class="clip" for="message"><?php _e( 'Your message here*', 'aldine' ); ?></label>
			<textarea type="text" placeholder="<?php _e( 'Your message here*', 'aldine' ); ?>" name="message" required><?php if ( $contact_form_response['status'] === 'error' ) :
				echo $contact_form_response['values']['message'];
			endif; ?></textarea></p>
		<p class="form__row"><input class="button button--small button--outline" type="submit" value="<?php _e( 'Send', 'aldine' ); ?>" /></p>
	</form>
</section>
