<?php
/**
 * Aldine functions and definitions
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
use PressbooksMix\Assets;

$includes = [
	'actions',
	'activation',
	'customizer',
	'filters',
	'helpers',
	'tags',
];

foreach ( $includes as $include ) {
	require get_template_directory() . "/inc/$include/namespace.php";
}
require get_template_directory() . '/inc/intervention.php';

add_action( 'admin_init', '\\Aldine\\Activation\\create_default_content' );
add_action( 'admin_bar_init', '\\Aldine\\Actions\\remove_admin_bar_callback' );
add_action( 'wp_head', '\\Aldine\\Actions\\output_custom_colors' );
add_filter( 'body_class', '\\Aldine\\Filters\\body_classes' );
add_filter( 'excerpt_more', '\\Aldine\\Filters\\excerpt_more' );

if ( ! function_exists( 'pressbooks_aldine_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function pressbooks_aldine_setup() {
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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( [
			'network-footer-menu' => __( 'Network Footer Menu', 'pressbooks-aldine' ),
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
endif;
add_action( 'after_setup_theme', 'pressbooks_aldine_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pressbooks_aldine_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pressbooks_aldine_content_width', 640 );
}
add_action( 'after_setup_theme', 'pressbooks_aldine_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pressbooks_aldine_widgets_init() {
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
add_action( 'widgets_init', 'pressbooks_aldine_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function pressbooks_aldine_scripts() {
	$assets = new Assets( 'pressbooks-aldine', 'theme' );
	$assets->setSrcDirectory( 'assets' )->setDistDirectory( 'dist' );

	wp_enqueue_style( 'aldine/style', $assets->getPath( 'styles/aldine.css' ), false, null );
	wp_enqueue_style( 'aldine/webfonts', 'https://fonts.googleapis.com/css?family=Karla:400,400i,700|Spectral:400,400i,600', false, null );
	wp_enqueue_script( 'aldine/script', $assets->getPath( 'scripts/aldine.js' ), [ 'jquery' ], null, true );
}
add_action( 'wp_enqueue_scripts', 'pressbooks_aldine_scripts' );

add_action( 'customize_register', '\\Aldine\\Customizer\\customize_register' );
add_action( 'customize_preview_init', '\\Aldine\\Customizer\\customize_preview_js' );

