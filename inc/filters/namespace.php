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
		return preg_replace( [ '/-php$/', '/^page-template-/' ], '', $class );
	}, $classes);

	return array_filter( $classes );
}

/**
 * Customize excerpt.
 */
function excerpt_more() {
	return ' &hellip; <a href="' . get_permalink() . '">' . __( 'Continued', 'aldine' ) . '</a>';
}
