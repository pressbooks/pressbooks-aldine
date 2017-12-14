<?php

/**
 * @package Aldine
 */

namespace Aldine\Actions;

/**
 * Output custom colors as CSS variables.
 *
 * @return void
 */
function output_custom_colors() {
	$colors = [
		'primary',
		'accent',
		'primary_fg',
		'accent_fg',
		'header_text',
	];

	$values = [];

	foreach ( $colors as $k ) {
		$v = get_option( "pb_network_color_$k" );
		if ( $v ) {
			$values[ $k ] = $v;
		}
	}

	$output = '';

	if ( ! empty( $values ) ) {
		$output .= '<style type="text/css">:root{';
		foreach ( $values as $k => $v ) {
			$k = str_replace( '_', '-', $k );
			$output .= "--$k:$v;";
		}
		$output .= '}</style>';
	}

	echo $output;
}

/**
 * Remove Admin Bar callback.
 */
function remove_admin_bar_callback() {
	remove_action( 'wp_head', '_admin_bar_bump_cb' );
}
