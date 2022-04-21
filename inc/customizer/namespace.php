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
 * @param \WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function customize_register( \WP_Customize_Manager $wp_customize ) {
	// Remove unsupported WP controls, @see \WP_Customize_Manager::register_controls.

	$wp_customize->remove_control( 'display_header_text' );
	$wp_customize->remove_control( 'header_textcolor' );

	// Remove unsupported WP section, @see \WP_Customize_Manager::register_sections.
	$wp_customize->remove_section( 'static_front_page' );

	// Add Pressbooks controls.

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname', [
				'selector'        => '.site-title a',
				'render_callback' => function() {
					bloginfo( 'name' );
				},
			]
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription', [
				'selector'        => '.site-description',
				'render_callback' => function() {
					bloginfo( 'description' );
				},
			]
		);
		$wp_customize->selective_refresh->add_partial(
			'pb_front_page_catalog_title', [
				'selector'        => '#latest-books-title',
				'render_callback' => function() {
					get_option( 'pb_front_page_catalog_title' );
				},
			]
		);
		$wp_customize->selective_refresh->add_partial(
			'pb_network_contact_form_title', [
				'selector'        => '#contact .contact__title',
				'render_callback' => function() {
					get_option( 'pb_network_contact_form_title' );
				},
			]
		);
	}

	foreach ( [
		[
			'slug' => 'primary',
			'hex' => '#b01109',
			'label' => esc_html__( 'Primary Color', 'pressbooks-aldine' ),
			'description' => esc_html__( 'Primary color, used for links and other primary elements.', 'pressbooks-aldine' ),
		],
		[
			'slug' => 'primary_dark',
			'hex' => '#7f0c07',
			'label' => esc_html__( 'Primary Color (Hover)', 'pressbooks-aldine' ),
			'description' => esc_html__( 'Variant of the primary color, used for primary element hover states.', 'pressbooks-aldine' ),
		],
		[
			'slug' => 'accent',
			'hex' => '#015d75',
			'label' => esc_html__( 'Accent Color', 'pressbooks-aldine' ),
			'description' => esc_html__( 'Accent color, used for flourishes and secondary elements.', 'pressbooks-aldine' ),
		],
		[
			'slug' => 'accent_dark',
			'hex' => '#013542',
			'label' => esc_html__( 'Accent Color (Hover)', 'pressbooks-aldine' ),
			'description' => esc_html__( 'Variant of the accent color, used for secondary element hover states.', 'pressbooks-aldine' ),
		],
		[
			'slug' => 'primary_fg',
			'hex' => '#ffffff',
			'label' => esc_html__( 'Primary Foreground Color', 'pressbooks-aldine' ),
			'description' => esc_html__( 'Used for text on a primary background.', 'pressbooks-aldine' ),
		],
		[
			'slug' => 'accent_fg',
			'hex' => '#ffffff',
			'label' => esc_html__( 'Accent Foreground Color', 'pressbooks-aldine' ),
			'description' => esc_html__( 'Used for text on an accent color background.', 'pressbooks-aldine' ),
		],
	] as $color ) {
		$wp_customize->add_setting(
			"pb_network_color_{$color['slug']}", [
				'type' => 'option',
				'default' => $color['hex'],
			]
		);
		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				"pb_network_color_{$color['slug']}",
				[
					'label' => $color['label'],
					'section'  => 'colors',
					'description' => $color['description'],
					'settings' => "pb_network_color_{$color['slug']}",
				]
			)
		);
	}
	$wp_customize->add_section(
		'pb_network_social', [
			'title' => esc_html__( 'Social Media', 'pressbooks-aldine' ),
			'priority' => 30,
		]
	);
	$wp_customize->add_setting(
		'pb_network_facebook', [
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw',
		]
	);
	$wp_customize->add_control(
		'pb_network_facebook', [
			'label' => esc_html__( 'Facebook', 'pressbooks-aldine' ),
			'section'  => 'pb_network_social',
			'settings' => 'pb_network_facebook',
		]
	);
	$wp_customize->add_setting(
		'pb_network_twitter', [
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw',
		]
	);
	$wp_customize->add_control(
		'pb_network_twitter', [
			'label' => esc_html__( 'Twitter', 'pressbooks-aldine' ),
			'section'  => 'pb_network_social',
			'settings' => 'pb_network_twitter',
		]
	);
	$wp_customize->add_setting(
		'pb_network_instagram', [
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw',
		]
	);
	$wp_customize->add_control(
		'pb_network_instagram', [
			'label' => esc_html__( 'Instagram', 'pressbooks-aldine' ),
			'section'  => 'pb_network_social',
			'settings' => 'pb_network_instagram',
		]
	);

	if ( defined( 'PB_PLUGIN_VERSION' ) ) {
		$wp_customize->add_section(
			'pb_front_page_catalog', [
				'title' => esc_html__( 'Front Page Catalog', 'pressbooks-aldine' ),
				'priority' => 25,
			]
		);
		$wp_customize->add_setting(
			'pb_front_page_catalog', [
				'type' => 'option',
			]
		);
		$wp_customize->add_control(
			'pb_front_page_catalog', [
				'label' => esc_html__( 'Show Front Page Catalog', 'pressbooks-aldine' ),
				'section'  => 'pb_front_page_catalog',
				'settings' => 'pb_front_page_catalog',
				'type' => 'checkbox',
			]
		);
		$wp_customize->add_setting(
			'pb_front_page_catalog_title', [
				'type' => 'option',
				'sanitize_callback' => 'sanitize_text_field',
				'default' => esc_html__( 'Our Latest Titles', 'pressbooks-aldine' ),
			]
		);
		$wp_customize->add_control(
			'pb_front_page_catalog_title', [
				'label' => esc_html__( 'Front Page Catalog Title', 'pressbooks-aldine' ),
				'section'  => 'pb_front_page_catalog',
				'settings' => 'pb_front_page_catalog_title',
			]
		);
	}

	$wp_customize->add_section(
		'pb_network_contact_form', [
			'title' => esc_html__( 'Contact Form', 'pressbooks-aldine' ),
			'priority' => 25,
		]
	);
	$wp_customize->add_setting(
		'pb_network_contact_form', [
			'type' => 'option',
		]
	);
	$wp_customize->add_control(
		'pb_network_contact_form', [
			'label' => esc_html__( 'Show Contact Form', 'pressbooks-aldine' ),
			'section'  => 'pb_network_contact_form',
			'settings' => 'pb_network_contact_form',
			'type' => 'checkbox',
		]
	);
	$wp_customize->add_setting(
		'pb_network_contact_form_title', [
			'type' => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default' => esc_html__( 'Contact Us', 'pressbooks-aldine' ),
		]
	);
	$wp_customize->add_control(
		'pb_network_contact_form_title', [
			'label' => esc_html__( 'Contact Form Title', 'pressbooks-aldine' ),
			'section' => 'pb_network_contact_form',
			'settings' => 'pb_network_contact_form_title',
		]
	);
	$wp_customize->add_setting(
		'pb_network_contact_email', [
			'type' => 'option',
			'default' => get_option( 'admin_email', '' ),
			'sanitize_callback' => 'sanitize_email',
		]
	);
	$wp_customize->add_control(
		'pb_network_contact_email', [
			'label' => esc_html__( 'Contact Email', 'pressbooks-aldine' ),
			'section' => 'pb_network_contact_form',
			'settings' => 'pb_network_contact_email',
		]
	);
	$wp_customize->add_setting(
		'pb_network_contact_link', [
			'type' => 'option',
		]
	);
	$wp_customize->add_control(
		'pb_network_contact_link', [
			'label' => esc_html__( 'Contact Link', 'pressbooks-aldine' ),
			'section' => 'pb_network_contact_form',
			'settings' => 'pb_network_contact_link',
		]
	);
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function customize_preview_js() {
	$assets = new Assets( 'pressbooks-aldine', 'theme' );
	$assets->setSrcDirectory( 'assets' )->setDistDirectory( 'dist' );

	wp_enqueue_script( 'aldine/customizer', $assets->getPath( 'scripts/customizer.js' ), [ 'customize-preview' ], false, null );
}

/**
 * Load color contrast validation tool
 *
 * @see https://github.com/soderlind/customizer-validate-wcag-color-contrast
 */
function enqueue_color_contrast_validator() {
	$handle = 'wcag-validate-customizer-color-contrast';

	wp_enqueue_script(
		$handle,
		get_template_directory_uri() . '/lib/customizer-validate-wcag-color-contrast/customizer-validate-wcag-color-contrast.js',
		[ 'customize-controls' ]
	);

	$exports = [
		'validate_color_contrast' => [
			'pb_network_color_primary_fg' => [ 'pb_network_color_primary', 'pb_network_color_primary_dark' ],
			'pb_network_color_accent_fg' => [ 'pb_network_color_accent', 'pb_network_color_accent_dark' ],
			'pb_network_color_primary' => [ 'pb_network_color_primary_fg' ],
			'pb_network_color_primary_dark' => [ 'pb_network_color_primary_fg' ],
			'pb_network_color_accent' => [ 'pb_network_color_accent_fg' ],
			'pb_network_color_accent_dark' => [ 'pb_network_color_accent_fg' ],
		],
	];

	wp_scripts()->add_data(
		$handle,
		'data',
		sprintf( 'var _validateWCAGColorContrastExports = %s;', wp_json_encode( $exports ) )
	);
}

/**
 * Contact form UI tweaks (checkbox should toggle either/or)
 */
function enqueue_contact_form_tweaks() {
	$assets = new Assets( 'pressbooks-aldine', 'theme' );
	$assets->setSrcDirectory( 'assets' )->setDistDirectory( 'dist' );
	wp_enqueue_script( 'aldine/customizer-toggle', $assets->getPath( 'scripts/customizer-toggle.js' ) );
}

/**
 * Enqueue pb-a11y hacks in customizer
 */
function enqueue_pb_a11y_in_customizer() {
	$pb_a11y_script = plugin_dir_url( 'pressbooks' ) . 'pressbooks/assets/src/scripts/a11y.js';
	wp_enqueue_script( 'pb-a11y', $pb_a11y_script, [ 'wp-i18n' ], false, true );
}
