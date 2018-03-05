<?php
/**
 * Aldine Shortcodes
 *
 * @package Aldine
 */

namespace Aldine\Shortcodes;

/**
 * Shortcode for Page Section.
 *
 * @param array $atts
 * @param string $content
 *
 * @return string
 */
function page_section( $atts, $content = null ) {
	$atts = shortcode_atts(
		[
			'title' => '',
			'variant' => '',
		],
		$atts,
		'aldine_page_section'
	);

	return sprintf(
		'<div class="page-section%1$s">%2$s%3$s</div>',
		( $atts['variant'] ) ? " page-section--{$atts['variant']}" : '',
		( $atts['title'] ) ? "<h2>{$atts['title']}</h2>" : '',
		$content
	);
}

/**
 * Shortcode for custom Call to Action.
 *
 * @param array $atts
 *
 * @return string
 */
function call_to_action( $atts ) {
	$atts = shortcode_atts(
		[
			'link' => '#',
			'text' => 'Call To Action',
		],
		$atts,
		'aldine_call_to_action'
	);

	return sprintf(
		'<a class="call-to-action" href="%1$s" title="%2$s">%2$s</a>',
		$atts['link'],
		$atts['text']
	);
}
