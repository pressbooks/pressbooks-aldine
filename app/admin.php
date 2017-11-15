<?php

namespace Aldine;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.branding h1 a',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);

    // Add settings
    foreach ([
        [
            'slug' => 'primary',
            'hex' => '#b01109',
            'label' => __('Primary Color', 'aldine'),
            'description' => __('Primary color, used for links and other primary elements.', 'aldine'),
        ],
        [
            'slug' => 'accent',
            'hex' => '#015d75',
            'label' => __('Accent Color', 'aldine'),
            'description' => __('Accent color, used for flourishes and secondary elements.', 'aldine'),
        ],
        [
            'slug' => 'primary_fg',
            'hex' => '#ffffff',
            'label' => __('Primary Foreground Color', 'aldine'),
            'description' => __('Used for text on a primary background.', 'aldine'),
        ],
        [
            'slug' => 'accent_fg',
            'hex' => '#ffffff',
            'label' => __('Accent Foreground Color', 'aldine'),
            'description' => __('Used for text on an accent color background.', 'aldine'),
        ],
    ] as $color) {
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
        'title' => __('Social Media', 'aldine'),
        'priority' => 30,
    ]);
    $wp_customize->add_setting('pb_network_facebook', [
        'type' => 'option',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('pb_network_facebook', [
        'label' => __('Facebook', 'aldine'),
        'section'  => 'pb_network_social',
        'settings' => 'pb_network_facebook',
    ]);
    $wp_customize->add_setting('pb_network_twitter', [
        'type' => 'option',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('pb_network_twitter', [
        'label' => __('Twitter', 'aldine'),
        'section'  => 'pb_network_social',
        'settings' => 'pb_network_twitter',
    ]);

    if (function_exists('pb_meets_minimum_requirements') && pb_meets_minimum_requirements()) {
        $wp_customize->add_section('pb_front_page_catalog', [
            'title' => __('Front Page Catalog', 'aldine'),
            'priority' => 25,
        ]);
        $wp_customize->add_setting('pb_front_page_catalog', [
            'type' => 'option',
        ]);
        $wp_customize->add_control('pb_front_page_catalog', [
            'label' => __('Show Front Page Catalog', 'aldine'),
            'section'  => 'pb_front_page_catalog',
            'settings' => 'pb_front_page_catalog',
            'type' => 'checkbox'
        ]);
        $wp_customize->add_setting('pb_front_page_catalog_title', [
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control('pb_front_page_catalog_title', [
            'label' => __('Front Page Catalog Title', 'aldine'),
            'section'  => 'pb_front_page_catalog',
            'settings' => 'pb_front_page_catalog_title',
        ]);
    }

    $wp_customize->add_section('pb_network_contact_form', [
        'title' => __('Contact Form', 'aldine'),
        'priority' => 25,
    ]);
    $wp_customize->add_setting('pb_network_contact_form', [
        'type' => 'option',
    ]);
    $wp_customize->add_control('pb_network_contact_form', [
        'label' => __('Show Contact Form', 'aldine'),
        'section'  => 'pb_network_contact_form',
        'settings' => 'pb_network_contact_form',
        'type' => 'checkbox'
    ]);
    $wp_customize->add_setting('pb_network_contact_form_title', [
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    $wp_customize->add_control('pb_network_contact_form_title', [
        'label' => __('Contact Form Title', 'aldine'),
        'section'  => 'pb_network_contact_form',
        'settings' => 'pb_network_contact_form_title',
    ]);
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('aldine/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
    wp_localize_script('aldine/customizer.js', 'SAGE_DIST_PATH', get_theme_file_uri() . '/dist/');
});

add_action('customize_controls_enqueue_scripts', function () {
    $handle = 'wcag-validate-customizer-color-contrast';
    $src = get_theme_file_uri() . '/lib/customizer-validate-wcag-color-contrast/customizer-validate-wcag-color-contrast.js';
    $deps = [ 'customize-controls' ];
    wp_enqueue_script($handle, $src, $deps);

    $exports = [
        'validate_color_contrast' => [
            'pb_network_color_primary_fg' => [ 'pb_network_color_primary' ],
            'pb_network_color_accent_fg' => [ 'pb_network_color_accent' ],
        ],
    ];
    wp_scripts()->add_data($handle, 'data', sprintf('var _validateWCAGColorContrastExports = %s;', wp_json_encode($exports)));
});
