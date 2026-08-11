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

$network_linkedin = get_option('pb_network_linkedin');
$network_youtube = get_option('pb_network_youtube');
$network_bluesky = get_option('pb_network_bluesky');
$network_facebook = get_option('pb_network_facebook');
$network_twitter = get_option('pb_network_twitter');
$network_instagram = get_option('pb_network_instagram');
$pb_network_contact_form = get_option('pb_network_contact_form');
$pb_network_contact_link = get_option('pb_network_contact_link');

if ($pb_network_contact_form) {
    $contact_link = network_home_url('/#contact');
} else {
    if (! empty($pb_network_contact_link)) {
        $contact_link = $pb_network_contact_link;
    } else {
        /**
         * Filter the "Contact" link.
         *
         * @since Pressbooks 5.6.0
         */
        $contact_link = apply_filters('pb_contact_link', '');
    }
}

?>

	</div><!-- #content -->

	<?php
    if ($pb_network_contact_form) :
        include(locate_template('partials/contact-form.php'));
    endif;
?>

	<footer class="footer" role="contentinfo">
	<div class="footer__inner">
		<div class="footer__network">
			<?php if (is_active_sidebar('network-footer-block-1')) { ?>
				<div class="footer__network__block footer__network__block--1">
					<?php dynamic_sidebar('network-footer-block-1'); ?>
				</div>
			<?php } ?>
			<?php if (is_active_sidebar('network-footer-block-2') || ! empty($network_linkedin) || ! empty($network_youtube) || ! empty($network_bluesky) || ! empty($network_facebook) || ! empty($network_twitter) || ! empty($network_instagram)) { ?>
				<div class="footer__network__block footer__network__block--2">
					<?php dynamic_sidebar('network-footer-block-2'); ?>
					<div class="social-media">
						<?php if (! empty($network_linkedin)) { ?>
							<?php /* translators: %s network name */ ?>
							<a class="linkedin" href="<?php echo $network_linkedin; ?>">
								<svg class="icon--svg" role="none" aria-hidden="true" focusable="false">
									<use href="#linkedin" />
								</svg>
								<?php /* translators: %s network name */ ?>
								<span class="screen-reader-text"><?php printf(__('%s on LinkedIn', 'pressbooks-aldine'), get_bloginfo('name', 'display')); ?></span>
							</a>
						<?php } ?>
						<?php if (! empty($network_youtube)) { ?>
							<?php /* translators: %s network name */ ?>
							<a class="linkedin" href="<?php echo $network_youtube; ?>">
								<svg class="icon--svg" role="none" aria-hidden="true" focusable="false">
									<use href="#youtube" />
								</svg>
								<?php /* translators: %s network name */ ?>
								<span class="screen-reader-text"><?php printf(__('%s on YouTube', 'pressbooks-aldine'), get_bloginfo('name', 'display')); ?></span>
							</a>
						<?php } ?>
						<?php if (! empty($network_bluesky)) { ?>
							<?php /* translators: %s network name */ ?>
							<a class="bluesky" href="<?php echo $network_bluesky; ?>">
								<svg class="icon--svg" role="none" aria-hidden="true" focusable="false">
									<use href="#bluesky" />
								</svg>
								<?php /* translators: %s network name */ ?>
								<span class="screen-reader-text"><?php printf(__('%s on Bluesky', 'pressbooks-aldine'), get_bloginfo('name', 'display')); ?></span>
							</a>
						<?php } ?>
						<?php if (! empty($network_facebook)) { ?>
							<?php /* translators: %s network name */ ?>
							<a class="facebook" href="<?php echo $network_facebook; ?>">
								<svg class="icon--svg" role="none" aria-hidden="true" focusable="false">
									<use href="#facebook" />
								</svg>
								<?php /* translators: %s network name */ ?>
								<span class="screen-reader-text"><?php printf(__('%s on Facebook', 'pressbooks-aldine'), get_bloginfo('name', 'display')); ?></span>
							</a>
						<?php } ?>
						<?php if (! empty($network_twitter)) { ?>
							<?php /* translators: %s network name */ ?>
							<a class="twitter" href="<?php echo $network_twitter; ?>">
								<svg class="icon--svg" role="none" aria-hidden="true" focusable="false">
									<use href="#twitter" />
								</svg>
								<?php /* translators: %s network name */ ?>
								<span class="screen-reader-text"><?php printf(__('%s on X', 'pressbooks-aldine'), get_bloginfo('name', 'display')); ?></span>
							</a>
						<?php } ?>
						<?php if (! empty($network_instagram)) { ?>
							<?php /* translators: %s network name */ ?>
							<a class="instagram" href="<?php echo $network_instagram; ?>">
								<svg class="icon--svg">
									<use href="#instagram" />
								</svg>
								<?php /* translators: %s network name */ ?>
								<span class="screen-reader-text"><?php printf(__('%s on Instagram', 'pressbooks-aldine'), get_bloginfo('name', 'display')); ?></span>
							</a>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
			<div class="footer__network__block footer__network__menu">
				<?php wp_nav_menu([ 'theme_location' => 'network-footer-menu' ]); ?>
			</div>
		</div>
		<section class="footer__pressbooks">
			<a class="footer__pressbooks__icon" href="https://pressbooks.com">
				<svg class="icon--svg" role="none" aria-hidden="true" focusable="false">
					<use xlink:href="#icon-pressbooks" />
				</svg>
				<span class="screen-reader-text"><?php _e('Pressbooks', 'pressbooks-aldine'); ?></span>
			</a>
			<div class="footer__pressbooks__links">
				<?php /* translators: %s Pressbooks */ ?>
				<p class="footer__pressbooks__links__title"><a href="https://pressbooks.com"><?php printf(__('Powered by %s', 'pressbooks-aldine'), '<span class="pressbooks">Pressbooks</span>'); ?></a></p>
				<ul class="footer__pressbooks__links__list">
					<li class="footer__pressbooks__links__list-item footer__pressbooks__links__list-item-guide"><a href="https://guide.pressbooks.com"><?php _e('Pressbooks User Guide', 'pressbooks-aldine'); ?></a></li>
					<li class="footer__pressbooks__links__list-item footer__pressbooks__links__list-item-pressbooks-directory">|<a href="https://pressbooks.directory"><?php _e('Pressbooks Directory', 'pressbooks-aldine'); ?></a></li>
					<?php if ($contact_link) : ?>
						<li class="footer__pressbooks__links__list-item footer__pressbooks__links__list-item-contact">|<a href="<?php echo $contact_link; ?>"><?php _e('Contact', 'pressbooks-aldine'); ?></a></li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="footer__pressbooks__social">
				<a class="youtube" href="https://www.youtube.com/user/pressbooks">
					<svg class="icon--svg" role="none" aria-hidden="true" focusable="false">
						<use href="#youtube" />
					</svg>
					<span class="screen-reader-text"><?php _e('Pressbooks on YouTube', 'pressbooks-aldine'); ?></span>
				</a>
				<a class="linkedin" href="https://www.linkedin.com/company/pressbooks/?originalSubdomain=ca">
					<svg class="icon--svg" role="none" aria-hidden="true" focusable="false">
						<use href="#linkedin" />
					</svg>
					<span class="screen-reader-text"><?php _e('Pressbooks on LinkedIn', 'pressbooks-aldine'); ?></span></a>
			</div>
		</section>
	</div><!-- .container -->
</footer><!-- .footer -->

</div> <!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
