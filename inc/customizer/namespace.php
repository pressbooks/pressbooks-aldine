<?php
/**
 * Aldine Theme Customizer
 *
 * @package Aldine
 */

namespace Aldine\Customizer;

use PressbooksMix\Assets;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function customize_register( \WP_Customize_Manager $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', [
			'selector'        => '.site-title a',
			'render_callback' => __NAMESPACE__ . '\\customize_partial_blogname',
		] );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', [
			'selector'        => '.site-description',
			'render_callback' => __NAMESPACE__ . '\\customize_partial_blogdescription',
		] );
	}

	foreach ( [
		[
			'slug' => 'primary',
			'hex' => '#b01109',
			'label' => __( 'Primary Color', 'aldine' ),
			'description' => __( 'Primary color, used for links and other primary elements.', 'aldine' ),
		],
		[
			'slug' => 'accent',
			'hex' => '#015d75',
			'label' => __( 'Accent Color', 'aldine' ),
			'description' => __( 'Accent color, used for flourishes and secondary elements.', 'aldine' ),
		],
		[
			'slug' => 'primary_fg',
			'hex' => '#ffffff',
			'label' => __( 'Primary Foreground Color', 'aldine' ),
			'description' => __( 'Used for text on a primary background.', 'aldine' ),
		],
		[
			'slug' => 'accent_fg',
			'hex' => '#ffffff',
			'label' => __( 'Accent Foreground Color', 'aldine' ),
			'description' => __( 'Used for text on an accent color background.', 'aldine' ),
		],
	] as $color ) {
		$wp_customize->add_setting("pb_network_color_{$color['slug']}", [
			'type' => 'option',
			'default' => $color['hex'],
		]);
		$wp_customize->add_control(new \WP_Customize_Color_Control(
			$wp_customize,
			"pb_network_color_{$color['slug']}",
			[
				'label' => $color['label'],
				'section'  => 'colors',
				'description' => $color['description'],
				'settings' => "pb_network_color_{$color['slug']}",
			]
		));
	}
	$wp_customize->add_section('pb_network_social', [
		'title' => __( 'Social Media', 'aldine' ),
		'priority' => 30,
	]);
	$wp_customize->add_setting('pb_network_facebook', [
		'type' => 'option',
		'sanitize_callback' => 'esc_url_raw',
	]);
	$wp_customize->add_control('pb_network_facebook', [
		'label' => __( 'Facebook', 'aldine' ),
		'section'  => 'pb_network_social',
		'settings' => 'pb_network_facebook',
	]);
	$wp_customize->add_setting('pb_network_twitter', [
		'type' => 'option',
		'sanitize_callback' => 'esc_url_raw',
	]);
	$wp_customize->add_control('pb_network_twitter', [
		'label' => __( 'Twitter', 'aldine' ),
		'section'  => 'pb_network_social',
		'settings' => 'pb_network_twitter',
	]);

	if ( function_exists( 'pb_meets_minimum_requirements' ) && pb_meets_minimum_requirements() ) {
		$wp_customize->add_section('pb_front_page_catalog', [
			'title' => __( 'Front Page Catalog', 'aldine' ),
			'priority' => 25,
		]);
		$wp_customize->add_setting('pb_front_page_catalog', [
			'type' => 'option',
		]);
		$wp_customize->add_control('pb_front_page_catalog', [
			'label' => __( 'Show Front Page Catalog', 'aldine' ),
			'section'  => 'pb_front_page_catalog',
			'settings' => 'pb_front_page_catalog',
			'type' => 'checkbox',
		]);
		$wp_customize->add_setting('pb_front_page_catalog_title', [
			'type' => 'option',
			'sanitize_callback' => 'sanitize_text_field',
		]);
		$wp_customize->add_control('pb_front_page_catalog_title', [
			'label' => __( 'Front Page Catalog Title', 'aldine' ),
			'section'  => 'pb_front_page_catalog',
			'settings' => 'pb_front_page_catalog_title',
		]);
	}

	$wp_customize->add_section('pb_network_contact_form', [
		'title' => __( 'Contact Form', 'aldine' ),
		'priority' => 25,
	]);
	$wp_customize->add_setting('pb_network_contact_form', [
		'type' => 'option',
	]);
	$wp_customize->add_control('pb_network_contact_form', [
		'label' => __( 'Show Contact Form', 'aldine' ),
		'section'  => 'pb_network_contact_form',
		'settings' => 'pb_network_contact_form',
		'type' => 'checkbox',
	]);
	$wp_customize->add_setting('pb_network_contact_form_title', [
		'type' => 'option',
		'sanitize_callback' => 'sanitize_text_field',
	]);
	$wp_customize->add_control('pb_network_contact_form_title', [
		'label' => __( 'Contact Form Title', 'aldine' ),
		'section'  => 'pb_network_contact_form',
		'settings' => 'pb_network_contact_form_title',
	]);
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function customize_preview_js() {
	$assets = new Assets( 'pressbooks-aldine', 'theme' );
	$assets->setSrcDirectory( 'assets' )->setDistDirectory( 'dist' );

	wp_enqueue_script( 'aldine/customizer', $assets->getPath( 'scripts/customizer.js' ), [ 'customize-preview' ], false, null );
	wp_enqueue_script( 'wcag-validate-customizer-color-contrast', get_template_directory_uri() . '/lib/customizer-validate-wcag-color-contrast/customizer-validate-wcag-color-contrast.js', [ 'customize-controls' ] );

	$exports = [
		'validate_color_contrast' => [
			'pb_network_color_primary_fg' => [ 'pb_network_color_primary' ],
			'pb_network_color_accent_fg' => [ 'pb_network_color_accent' ],
		],
	];
	wp_scripts()->add_data(
		'wcag-validate-customizer-color-contrast',
		'data',
		sprintf( 'var _validateWCAGColorContrastExports = %s;', wp_json_encode( $exports ) )
	);
}
