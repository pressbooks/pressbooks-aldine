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
    $wp_customize->add_section('pb_network_social', [
        'title' => __('Social Media', 'aldine'),
        'priority' => 30,
    ]);
    $wp_customize->add_setting('pb_network_facebook', [
        'type' => 'option',
    ]);
    $wp_customize->add_control('pb_network_facebook', [
        'label' => __('Facebook', 'aldine'),
        'section'  => 'pb_network_social',
        'settings' => 'pb_network_facebook',
    ]);
    $wp_customize->add_setting('pb_network_twitter', [
        'type' => 'option',
    ]);
    $wp_customize->add_control('pb_network_twitter', [
        'label' => __('Twitter', 'aldine'),
        'section'  => 'pb_network_social',
        'settings' => 'pb_network_twitter',
    ]);
    $wp_customize->add_section('pb_network_catalog', [
        'title' => __('Catalog', 'aldine'),
        'priority' => 20,
    ]);
    $wp_customize->add_setting('pb_front_page_catalog');
    $wp_customize->add_control('pb_front_page_catalog', [
        'label' => __('Show Front Page Catalog', 'aldine'),
        'section'  => 'pb_network_catalog',
        'settings' => 'pb_front_page_catalog',
        'type' => 'checkbox'
    ]);
    $wp_customize->add_setting('pb_front_pa ge_catalog_title');
    $wp_customize->add_control('pb_front_page_catalog_title', [
        'label' => __('Front Page Catalog Title', 'aldine'),
        'section'  => 'pb_network_catalog',
        'settings' => 'pb_front_page_catalog_title',
    ]);

});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('aldine/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});
