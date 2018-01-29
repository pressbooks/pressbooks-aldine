<?php
/**
 * Aldine functions and hooks
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Aldine
 */

/**
 * Ensure dependencies are loaded
 */
if ( ! class_exists( 'PressbooksMix\\Assets' ) ) {
	$composer = get_template_directory() . '/vendor/autoload.php';
	if ( ! file_exists( $composer ) ) {
		wp_die( sprintf(
			'<h1>%1$s</h1><p>%2$s</p>',
			__( 'Dependencies Missing', 'pressbooks-aldine' ),
			__( 'You must run <code>composer install</code> from the Aldine directory.', 'pressbooks-aldine' )
		) );
	}
	require_once $composer;
}

$includes = [
	'actions',
	'activation',
	'admin',
	'customizer',
	'filters',
	'helpers',
	'tags',
];

foreach ( $includes as $include ) {
	require get_template_directory() . "/inc/$include/namespace.php";
}
require get_template_directory() . '/inc/intervention.php';

add_action( 'after_switch_theme', '\Aldine\Activation\create_default_content', 10 );
add_action( 'after_switch_theme', '\Aldine\Activation\create_menus', 11 );
add_action( 'after_switch_theme', '\Aldine\Activation\assign_menus', 12 );
add_action( 'admin_bar_init', '\Aldine\Actions\remove_admin_bar_callback' );
add_action( 'after_setup_theme', '\Aldine\Actions\setup' );
add_action( 'after_setup_theme', '\Aldine\Actions\content_width', 0 );
add_action( 'wp_head', '\Aldine\Actions\output_custom_colors' );
add_action( 'init', '\Aldine\Actions\add_editor_styles' );
add_filter( 'mce_buttons', '\Aldine\Filters\add_style_select' );
add_filter( 'tiny_mce_before_init', '\Aldine\Filters\add_blocks' );
add_filter( 'body_class', '\Aldine\Filters\body_classes' );
add_filter( 'excerpt_more', '\Aldine\Filters\excerpt_more' );
add_filter( 'query_vars', '\Aldine\Filters\register_query_vars' );
add_filter( 'wp_nav_menu_items', '\Aldine\Filters\adjust_menu', 10, 2 );
add_action( 'widgets_init', '\Aldine\Actions\widgets_init' );
add_action( 'wp_enqueue_scripts', '\Aldine\Actions\enqueue_assets' );
add_action( 'customize_register', '\Aldine\Customizer\customize_register' );
add_action( 'customize_preview_init', '\Aldine\Customizer\customize_preview_js' );

// Catalog page: Network admin controls
add_action( 'admin_enqueue_scripts', '\Aldine\Admin\admin_scripts' );
add_action( 'wp_ajax_pressbooks_aldine_update_catalog', '\Aldine\Admin\update_catalog' );
add_filter( 'wpmu_blogs_columns', '\Aldine\Admin\catalog_columns' );
add_action( 'manage_blogs_custom_column', '\Aldine\Admin\catalog_column', 1, 3 );
add_action( 'manage_sites_custom_column', '\Aldine\Admin\catalog_column', 1, 3 );