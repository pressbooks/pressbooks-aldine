<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Aldine
 */

?>

<?php

$network_facebook = get_option( 'pb_network_facebook' );
$network_twitter = get_option( 'pb_network_twitter' );
$network_instagram = get_option( 'pb_network_instagram' );
$pb_network_contact_form = get_option( 'pb_network_contact_form' );
$pb_network_contact_link = get_option( 'pb_network_contact_link' );

if ( $pb_network_contact_form ) {
	$contact_link = network_home_url( '/#contact' );
} else {
	if ( ! empty( $pb_network_contact_link ) ) {
		$contact_link = $pb_network_contact_link;
	} else {
		/**
		 * Filter the "Contact" link.
		 *
		 * @since Pressbooks 5.6.0
		 */
		$contact_link = apply_filters( 'pb_contact_link', '' );
	}
}

?>

	</div><!-- #content -->

	<?php
	if ( $pb_network_contact_form ) :
		include( locate_template( 'partials/contact-form.php' ) );
	endif;
	?>

	<footer class="footer" role="contentinfo">
	<div class="footer__inner">
		<div class="footer__network">
			<?php if ( is_active_sidebar( 'network-footer-block-1' ) ) { ?>
				<div class="footer__network__block footer__network__block--1">
					<?php dynamic_sidebar( 'network-footer-block-1' ); ?>
				</div>
			<?php } ?>
			<?php if ( is_active_sidebar( 'network-footer-block-2' ) || ! empty( $network_facebook ) || ! empty( $network_twitter ) || ! empty( $network_instagram ) ) { ?>
				<div class="footer__network__block footer__network__block--2">
					<?php dynamic_sidebar( 'network-footer-block-2' ); ?>
					<div class="social-media">
						<?php if ( ! empty( $network_facebook ) ) { ?>
							<?php /* translators: %s network name */ ?>
							<a class="facebook" href="<?php echo $network_facebook; ?>" title="<?php printf( __( '%s on Facebook', 'pressbooks-aldine' ), get_bloginfo( 'name', 'display' ) ); ?>">
								<svg class="icon--svg">
									<use href="#facebook" />
								</svg>
								<?php /* translators: %s network name */ ?>
								<span class="screen-reader-text"><?php printf( __( '%s on Facebook', 'pressbooks-aldine' ), get_bloginfo( 'name', 'display' ) ); ?></span>
							</a>
						<?php } ?>
						<?php if ( ! empty( $network_twitter ) ) { ?>
							<?php /* translators: %s network name */ ?>
							<a class="twitter" href="<?php echo $network_twitter; ?>" title="<?php printf( __( '%s on Twitter', 'pressbooks-aldine' ), get_bloginfo( 'name', 'display' ) ); ?>">
								<svg class="icon--svg">
									<use href="#twitter" />
								</svg>
								<?php /* translators: %s network name */ ?>
								<span class="screen-reader-text"><?php printf( __( '%s on Twitter', 'pressbooks-aldine' ), get_bloginfo( 'name', 'display' ) ); ?></span>
							</a>
						<?php } ?>
						<?php if ( ! empty( $network_instagram ) ) { ?>
							<?php /* translators: %s network name */ ?>
							<a class="instagram" href="<?php echo $network_instagram; ?>" title="<?php printf( __( '%s on Instagram', 'pressbooks-aldine' ), get_bloginfo( 'name', 'display' ) ); ?>">
								<svg class="icon--svg">
									<use href="#instagram" />
								</svg>
								<?php /* translators: %s network name */ ?>
								<span class="screen-reader-text"><?php printf( __( '%s on Instagram', 'pressbooks-aldine' ), get_bloginfo( 'name', 'display' ) ); ?></span>
							</a>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
			<div class="footer__network__block footer__network__menu">
				<?php wp_nav_menu( [ 'theme_location' => 'network-footer-menu' ] ); ?>
			</div>
		</div>
		<section class="footer__pressbooks">
			<a class="footer__pressbooks__icon" href="https://pressbooks.com" title="Pressbooks">
				<?php // TODO. ?>
				<svg class="icon--svg">
					<use xlink:href="#icon-pressbooks" />
				</svg>
			</a>
			<div class="footer__pressbooks__links">
				<?php /* translators: %s Pressbooks */ ?>
				<p class="footer__pressbooks__links__title"><a href="https://pressbooks.com"><?php printf( __( 'Powered by %s', 'pressbooks-aldine' ), '<span class="pressbooks">Pressbooks</span>' ); ?></a></p>
				<ul class="footer__pressbooks__links__list">
					<li class="footer__pressbooks__links__list-item footer__pressbooks__links__list-item-guide-tutorials"><a href="https://pressbooks.com/support/"><?php _e( 'Guides and Tutorials', 'pressbooks-aldine' ); ?></a></li>
					<li class="footer__pressbooks__links__list-item footer__pressbooks__links__list-item-pressbooks-directory">|<a href="https://pressbooks.directory"><?php _e( 'Pressbooks Directory', 'pressbooks-aldine' ); ?></a></li>
					<?php if ( $contact_link ) : ?>
						<li class="footer__pressbooks__links__list-item footer__pressbooks__links__list-item-contact">|<a href="<?php echo $contact_link; ?>"><?php _e( 'Contact', 'pressbooks-aldine' ); ?></a></li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="footer__pressbooks__social">
				<a class="facebook" href="https://www.youtube.com/user/pressbooks" title="<?php _e( 'Pressbooks on YouTube', 'pressbooks-aldine' ); ?>">
					<img class="youtube-link" src="<?php bloginfo( 'template_directory' ); ?>/assets/images/yt_icon_mono_dark.png" alt="YouTube">
					<span class="screen-reader-text"><?php _e( 'Pressbooks on YouTube', 'pressbooks-aldine' ); ?></span>
				</a>
				<a class="twitter" href="https://twitter.com/intent/follow?screen_name=pressbooks" title="<?php _e( 'Pressbooks on Twitter', 'pressbooks-aldine' ); ?>">
					<svg class="icon--svg">
						<use href="#twitter" />
					</svg>
				<span class="screen-reader-text"><?php _e( 'Pressbooks on Twitter', 'pressbooks-aldine' ); ?></span></a>
			</div>
		</section>
	</div><!-- .container -->
</footer><!-- .footer -->

</div> <!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
