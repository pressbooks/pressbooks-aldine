<?php

namespace Aldine;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);
    $wp_customize->add_section('pb_network_colors', [
        'title' => __('Color Scheme', 'aldine'),
        'priority' => 20,
    ]);
    $wp_customize->add_setting('pb_network_primary_color', [
        'type' => 'option',
        'default' => '#b01109',
    ]);
    $wp_customize->add_control(new \WP_Customize_Color_Control(
        $wp_customize,
        'pb_network_primary_color',
        [
            'label' => __('Primary Color', 'aldine'),
            'section'  => 'pb_network_colors',
            'settings' => 'pb_network_primary_color',
        ]
    ));
    $wp_customize->add_setting('pb_network_secondary_color', [
        'type' => 'option',
        'default' => '#015d75',
    ]);
    $wp_customize->add_control(new \WP_Customize_Color_Control(
        $wp_customize,
        'pb_network_secondary_color',
        [
            'label' => __('Secondary Color', 'aldine'),
            'section'  => 'pb_network_colors',
            'settings' => 'pb_network_secondary_color',
        ]
    ));
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
    $wp_customize->add_section('pb_front_page_content', [
        'title' => __('Front Page Content', 'aldine'),
        'priority' => 20,
    ]);
    for ($i = 1; $i < 5; $i++) {
        $wp_customize->add_setting("pb_front_page_block_${i}_title", [
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("pb_front_page_block_${i}_title", [
            'label' => sprintf(__('Block %d Title', 'aldine'), $i),
            'section'  => 'pb_front_page_content',
            'settings' => "pb_front_page_block_${i}_title",
        ]);
        $wp_customize->add_setting("pb_front_page_block_${i}_content", [
            'type' => 'option',
            'sanitize_callback' => 'sanitize_textarea_field',
        ]);
        $wp_customize->add_control("pb_front_page_block_${i}_content", [
            'label' => sprintf(__('Block %d Content', 'aldine'), $i),
            'type' => 'textarea',
            'section'  => 'pb_front_page_content',
            'settings' => "pb_front_page_block_${i}_content",
        ]);
        $wp_customize->add_setting("pb_front_page_block_${i}_button_title", [
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("pb_front_page_block_${i}_button_title", [
            'label' => sprintf(__('Block %d Button Title', 'aldine'), $i),
            'section'  => 'pb_front_page_content',
            'settings' => "pb_front_page_block_${i}_button_title",
        ]);
        $wp_customize->add_setting("pb_front_page_block_${i}_button_url", [
            'type' => 'option',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control("pb_front_page_block_${i}_button_url", [
            'label' => sprintf(__('Block %d Button URL', 'aldine'), $i),
            'section'  => 'pb_front_page_content',
            'settings' => "pb_front_page_block_${i}_button_url",
        ]);
    }
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
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('aldine/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
    wp_localize_script('aldine/customizer.js', 'SAGE_DIST_PATH', get_theme_file_uri() . '/dist/');
});
