<?php
/**
 * Template part for displaying the contact form
 *
 * @package Aldine
 */

?>

<?php

$pb_network_contact_form_title = get_option( 'pb_network_contact_form_title' );
$contact_form_title = ( ! empty( $pb_network_contact_form_title ) ) ? $pb_network_contact_form_title : __( 'Contact Us', 'pressbooks-aldine' );
$contact_form_response = \Aldine\Helpers\handle_contact_form_submission();
$honeypot = 'firstname' . wp_rand();

?>

<aside class="contact" id="contact">
	<h2 class="contact__title"><?php echo $contact_form_title; ?></h2>
	<form class="form" action="<?php echo network_home_url( '/#contact' ); ?>" method="post">
		<?php if ( $contact_form_response ) : ?>
		<p class="form__notice form__notice--<?php echo $contact_form_response['status']; ?>"><?php echo $contact_form_response['message']; ?></p>
		<?php endif; ?>
		<?php wp_nonce_field( 'pb_root_contact_form', 'pb_root_contact_form_nonce' ); ?>
		<input type="hidden" name="submitted" value="1">
		<p class="form__row" style="display:none;">
			<input type="text" name="<?php echo $honeypot; ?>" id="<?php echo $honeypot; ?>"/>
			<label for="<?php echo $honeypot; ?>">
				<?php _e( 'Keep this field blank (required)', 'pressbooks-aldine' ); ?>
			</label>
		</p>
		<p class="form__row">
			<input
					id="contact-name"
					<?php if ( isset( $contact_form_response['field'] ) && $contact_form_response['field'] === 'visitor_name' ) : ?>
						class="error"
					<?php endif; ?>
					type="text"
					name="visitor_name"
					<?php if ( $contact_form_response && $contact_form_response['status'] === 'error' ) : ?>
						value="<?php echo $contact_form_response['values']['visitor_name']; ?>"
					<?php endif; ?>
					required
			/>
			<label for="contact-name">
				<?php _e( 'Your name (required)', 'pressbooks-aldine' ); ?>
			</label>
		</p>
		<p class="form__row">
			<input
					id="contact-email"
					<?php if ( isset( $contact_form_response['field'] ) && $contact_form_response['field'] === 'visitor_email' ) : ?>
						class="error"
					<?php endif; ?>
					type="email"
					name="visitor_email"
					<?php if ( $contact_form_response && $contact_form_response['status'] === 'error' ) : ?>
						value="<?php echo $contact_form_response['values']['visitor_email']; ?>"
					<?php endif; ?>
					required
			/>
			<label for="contact-email">
				<?php _e( 'Your email address (required)', 'pressbooks-aldine' ); ?>
			</label>
		</p>
		<p class="form__row">
			<input
					id="contact-institution"
					<?php if ( isset( $contact_form_response['field'] ) && $contact_form_response['field'] === 'visitor_institution' ) : ?>
						class="error"
					<?php endif; ?>
					type="text"
					name="visitor_institution"
					<?php if ( $contact_form_response && $contact_form_response['status'] === 'error' ) : ?>
						value="<?php echo $contact_form_response['values']['visitor_institution']; ?>"
					<?php endif; ?>
					required
			/>
			<label for="contact-institution">
				<?php _e( 'Your institution (required)', 'pressbooks-aldine' ); ?>
			</label>
		</p>
		<p class="form__row">
			<textarea
					id="contact-message"
					<?php if ( isset( $contact_form_response['field'] ) && $contact_form_response['field'] === 'message' ) : ?>
						class="error"
					<?php endif; ?>
					name="message"
					required
			><?php if ( $contact_form_response && $contact_form_response['status'] === 'error' ) : ?>
					<?php echo $contact_form_response['values']['message']; ?>
				<?php endif; ?></textarea>
			<label for="contact-message">
				<?php _e( 'Your message (required)', 'pressbooks-aldine' ); ?>
			</label>
		</p>
		<p class="form__row">
			<input class="button button--small button--outline" type="submit" value="<?php _e( 'Send', 'pressbooks-aldine' ); ?>" /></p>
	</form>
</aside>
