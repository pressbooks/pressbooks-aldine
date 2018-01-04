<?php

/**
 * @package Aldine
 */

namespace Aldine\Actions;

use PressbooksMix\Assets;

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function setup() {
	$assets = new Assets( 'pressbooks-aldine', 'theme' );
	$assets->setSrcDirectory( 'assets' )->setDistDirectory( 'dist' );

	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		*/
	load_theme_textdomain( 'aldine', get_template_directory() . '/languages' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( [
		'primary-menu' => __( 'Primary Menu', 'pressbooks-aldine' ),
		'network-footer-menu' => __( 'Footer Menu', 'pressbooks-aldine' ),
	] );

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	] );

	// Set up the WordPress core custom header feature.
	add_theme_support( 'custom-header', [
		'default-image' => $assets->getPath( 'images/header.jpg' ),
		'width' => 1920,
		'height' => 884,
		'default-text-color' => '#000',
	] );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', [
		'height' => 40,
		'width' => 265,
		'flex-width' => true,
		'flex-height' => true,
	] );

	// Add editor style.
	add_editor_style( $assets->getPath( 'styles/editor.css' ) );
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function widgets_init() {
	$config = [
		'before_widget' => '<div class="widget %1$s %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	];
	register_sidebar( [
		'name'          => __( 'Front Page Content', 'pressbooks-aldine' ),
		'description'   => __(
			'Add content for your network&rsquo;s front page here. Currently, only text widgets are supported.',
			'aldine'
		),
		'id'            => 'front-page-block',
		'before_widget' => '<div class="block %1$s %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	] );
	register_sidebar( [
		'name'          => __( 'Network Footer Block 1', 'pressbooks-aldine' ),
		'description'   => __(
			'Add content for your network&rsquo;s customizeable footer here.
            Currently, only text and image widgets are supported.
            Content in this widget area will appear in the first row (on mobile) or the first column (on desktops).',
			'aldine'
		),
		'id'            => 'network-footer-block-1',
	] + $config );
	register_sidebar( [
		'name'          => __( 'Network Footer Block 2', 'pressbooks-aldine' ),
		'description'   => __(
			'Add content for your network&rsquo;s customizeable footer here.
            Currently, only text and image widgets are supported.
            Content in this widget area will appear in the second row (on mobile) or the middle column (on desktop).',
			'aldine'
		),
		'id'            => 'network-footer-block-2',
	] + $config );
}

/**
 * Enqueue scripts and styles.
 */
function enqueue_assets() {
	$assets = new Assets( 'pressbooks-aldine', 'theme' );
	$assets->setSrcDirectory( 'assets' )->setDistDirectory( 'dist' );

	wp_enqueue_style( 'aldine/style', $assets->getPath( 'styles/aldine.css' ), false, null );
	wp_enqueue_style( 'aldine/webfonts', 'https://fonts.googleapis.com/css?family=Karla:400,400i,700|Spectral:400,400i,600', false, null );
	wp_enqueue_script( 'aldine/script', $assets->getPath( 'scripts/aldine.js' ), [ 'jquery' ], null, true );
	wp_localize_script(
		'aldine/script',
		'PB_A11y',
		[
			'increase_label' => __( 'Increase Font Size', 'pressbooks-aldine' ),
			'decrease_label' => __( 'Decrease Font Size', 'pressbooks-aldine' ),
		]
	);
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pressbooks_aldine_content_width', 640 );
}

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
