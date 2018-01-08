<?php
/**
 * Aldine Filters
 *
 * @package Aldine
 */

namespace Aldine\Filters;

/**
 * Adds custom classes to the array of body classes.
 *
 * @see https://github.com/roots/sage/blob/master/app/filters.php
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function body_classes( array $classes ) {
	/** Add page slug if it doesn't exist */
	if ( is_single() || is_page() && ! is_front_page() ) {
		if ( ! in_array( basename( get_permalink() ), $classes, true ) ) {
			$classes[] = basename( get_permalink() );
		}
	}

	/** Clean up class names for custom templates */
	$classes = array_map( function ( $class ) {
		return preg_replace( [ '/-php$/', '/^page-template-views/' ], '', $class );
	}, $classes );

	return array_filter( $classes );
}

/**
 * Customize excerpt.
 *
 * @return string
 */
function excerpt_more() {
	return ' &hellip; <a href="' . get_permalink() . '">' . __( 'Continued', 'pressbooks-aldine' ) . '</a>';
}

/**
 * Add style select dropdown to TinyMCE.
 *
 * @param array $buttons The default button array.
 * @return array The modified array.
 */
function add_style_select( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}

/**
 * Add custom block formats to TinyMCE.
 *
 * @param array $init_array The default array.
 * @return array The modified array.
 **/

function add_blocks( $init_array ) {
	$style_formats = [
		[
			'title' => __( 'Standard Block', 'pressbooks-aldine' ),
			'block' => 'div',
			'classes' => [ 'block', 'block--standard' ],
			'wrapper' => true,
		],
		[
			'title' => __( 'Alternate Block', 'pressbooks-aldine' ),
			'block' => 'div',
			'classes' => [ 'block', 'block--alternate' ],
			'wrapper' => true,
		],
		[
			'title' => __( 'Bordered Block', 'pressbooks-aldine' ),
			'block' => 'div',
			'classes' => [ 'block', 'block--bordered' ],
			'wrapper' => true,
		],
		[
			'title' => __( 'Borderless Block', 'pressbooks-aldine' ),
			'block' => 'div',
			'classes' => [ 'block', 'block--borderless' ],
			'wrapper' => true,
		],
		[
			'title' => __( 'Link Button', 'pressbooks-aldine' ),
			'selector' => 'a',
			'classes' => 'button',
		],
	];

	$init_array['style_formats'] = json_encode( $style_formats );

	return $init_array;
}

/**
 * Add things to the menu.
 *
 * @param string $items
 * @param object $args
 * @return string
 */

function adjust_menu( $items, $args ) {
	if ( $args->theme_location === 'primary-menu' ) {
		if ( ! is_front_page() ) {
			$items = sprintf(
				'<li><a href="%1$s">%2$s</a></li>',
				'/',
				__( 'Home', 'pressbooks-aldine' )
			) . $items;
		}
		if ( get_option( 'pb_network_contact_form' ) ) {
			$items .= sprintf(
				'<li><a href="%1$s">%2$s</a></li>',
				'#contact',
				__( 'Contact', 'pressbooks-aldine' )
			);
		}
		if ( ! is_user_logged_in() ) {
			$items .= sprintf(
				'<li><a href="%1$s">%2$s</a></li>',
				wp_login_url( get_permalink() ),
				__( 'Sign In', 'pressbooks-aldine' )
			);
			if ( in_array( get_site_option( 'registration' ), [ 'user', 'all' ], true ) ) {
				$items .= sprintf(
					'<li><a href="%1$s">%2$s</a></li>',
					network_home_url( '/wp-signup.php' ),
					__( 'Sign Up', 'pressbooks-aldine' )
				);
			}
		} else {
			if ( is_super_admin() || is_user_member_of_blog() ) {
				$items .= sprintf(
					'<li><a href="%1$s">%2$s</a></li>',
					admin_url(),
					__( 'Admin', 'pressbooks-aldine' )
				);
			}
			$items .= sprintf(
				'<li><a href="%1$s">%2$s</a></li>',
				wp_logout_url( get_permalink() ),
				__( 'Sign Out', 'pressbooks-aldine' )
			);
		}
		/* @codingStandardsIgnoreStart $items .= sprintf(
			'<li class="header__search js-search"><div class="header__search__form">%s</div></li>',
			get_search_form( false )
		); @codingStandardsIgnoreEnd */
	}

	return $items;
}
