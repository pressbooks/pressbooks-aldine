<?php
/**
 * Aldine Filters
 *
 * @package Aldine
 */

namespace Aldine\Filters;

use function Aldine\Helpers\has_sections;

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

	/** Add .has-sections if page content has sections */
	if ( is_single() || is_page() && has_sections( get_the_ID() ) ) {
		$classes[] = 'has-sections';
	}

	/** Clean up class names for custom templates */
	$classes = array_map( function ( $class ) {
		return preg_replace( [ '/-php$/', '/^page-template-views/' ], '', $class );
	}, $classes );

	return array_filter( $classes );
}

/**
 * Add custom query vars for catalog.
 *
 * @param array $vars The array of available query variables.
 *
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
 */
function register_query_vars( $vars ) {
	$vars[] = 'license';
	$vars[] = 'subject';
	return $vars;
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
			'title' => __( 'Page Section', 'pressbooks-aldine' ),
			'block' => 'div',
			'classes' => [ 'page-section' ],
			'wrapper' => true,
		],
		[
			'title' => __( 'Page Section (Accent)', 'pressbooks-aldine' ),
			'block' => 'div',
			'classes' => [ 'page-section', 'page-section--accent' ],
			'wrapper' => true,
		],
		[
			'title' => __( 'Page Section (Bordered)', 'pressbooks-aldine' ),
			'block' => 'div',
			'classes' => [ 'page-section', 'page-section--bordered' ],
			'wrapper' => true,
		],
		[
			'title' => __( 'Page Section (Borderless)', 'pressbooks-aldine' ),
			'block' => 'div',
			'classes' => [ 'page-section', 'page-section--borderless' ],
			'wrapper' => true,
		],
		[
			'title' => __( 'Call to Action', 'pressbooks-aldine' ),
			'inline' => 'a',
			'classes' => [ 'call-to-action' ],
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
		return \Aldine\Helpers\get_default_menu( $items );
	}

	return $items;
}
