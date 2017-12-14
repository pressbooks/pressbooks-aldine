<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Aldine
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'pressbooks-aldine' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="container">
		<a class="toggle" href="#navigation"><?php _e( 'Toggle menu', 'aldine' ); ?><span class="toggle__icon"></span></a>
		<a class="banner__brand" href="<?php echo home_url( '/' ); ?>"><span class="clip"><?php echo get_bloginfo( 'name', 'display' ); ?></span></a>
		<nav class="banner__navigation" id="navigation">
			<?php if ( function_exists( 'pb_meets_minimum_requirements' ) && pb_meets_minimum_requirements() ) : ?>
				<a class="banner__navigation--catalog" href="<?php echo home_url( '/catalog' ); ?>">Catalog</a>
			<?php endif; ?>
			<?php if ( get_option( 'pb_network_contact_form' ) ) : ?>
				<a class="banner__navigation--contact" href="#contact">Contact</a>
			<?php endif; ?>
			<?php if ( ! is_user_logged_in() ) : ?>
				<a class="banner__navigation--signin" href="<?php echo wp_login_url(); ?>"><?php _e( 'Sign in', 'aldine' ); ?></a>
				<span class="banner__navigation--sep">/</span>
				<a class="banner__navigation--signup" href="<?php echo network_home_url( '/wp-signup.php' ); ?>"><?php _e( 'Sign up', 'aldine' ); ?></a>
			<?php else : ?>
				<a class="banner__navigation--admin" href="<?php echo admin_url(); ?>"><?php _e( 'Admin', 'aldine' ); ?></a>
				<span class="banner__navigation--sep">/</span>
				<a class="banner__navigation--signout" href="<?php echo wp_logout_url(); ?>"><?php _e( 'Sign out', 'aldine' ); ?></a>
			<?php endif; ?>
		</nav>
		<header class="banner__branding">
			<h1><a href="{{ home_url('/' ); ?>"><?php echo get_bloginfo( 'name', 'display' ); ?></a></h1>
			<p><?php echo get_bloginfo( 'description', 'display' ); ?></p>
		</header>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
