<?php
/**
 * Aldine Actions
 *
 * @package Aldine
 */

namespace Aldine\Actions;

use PressbooksMix\Assets;
use Spatie\Color\Hex;

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
	load_theme_textdomain( 'pressbooks-aldine', get_template_directory() . '/languages' );

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
	register_nav_menus(
		[
			'primary-menu' => __( 'Primary Menu', 'pressbooks-aldine' ),
			'network-footer-menu' => __( 'Footer Menu', 'pressbooks-aldine' ),
		]
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		]
	);

	// Set up the WordPress core custom header feature.
	add_theme_support(
		'custom-header', [
			'default-image' => get_template_directory_uri() . '/dist/images/header.jpg',
			'width' => 1920,
			'height' => 884,
			'default-text-color' => '#000',
		]
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo', [
			'height' => 40,
			'width' => 265,
			'flex-width' => true,
			'flex-height' => true,
		]
	);

	// Add editor style.
	add_editor_style( $assets->getPath( 'styles/editor.css' ) );

	// Add shortcode buttons.
	add_action( 'init', __NAMESPACE__ . '\register_shortcode_buttons' );

	remove_theme_support( 'widgets-block-editor' );

	// Disables the block editor from managing widgets in the Gutenberg plugin.
	add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
	// Disables the block editor from managing widgets.
	add_filter( 'use_widgets_block_editor', '__return_false' );
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
	register_sidebar(
		[
			'name'          => __( 'Network Footer Block 1', 'pressbooks-aldine' ),
			'description'   => __(
				'Add content for your network&rsquo;s customizeable footer here.
            Currently, only text and image widgets are supported.
            Content in this widget area will appear in the first row (on mobile) or the first column (on desktops).',
				'aldine'
			),
			'id'            => 'network-footer-block-1',
		] + $config
	);
	register_sidebar(
		[
			'name'          => __( 'Network Footer Block 2', 'pressbooks-aldine' ),
			'description'   => __(
				'Add content for your network&rsquo;s customizeable footer here.
            Currently, only text and image widgets are supported.
            Content in this widget area will appear in the second row (on mobile) or the middle column (on desktop).',
				'aldine'
			),
			'id'            => 'network-footer-block-2',
		] + $config
	);
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
}

/**
 * Add editor styles.
 */
function add_editor_styles() {
	$assets = new Assets( 'pressbooks-aldine', 'theme' );
	$assets->setSrcDirectory( 'assets' )->setDistDirectory( 'dist' );
	add_editor_style( $assets->getPath( 'styles/editor.css' ) );
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
	if ( defined( 'PB_PLUGIN_VERSION' ) ) {
		echo \Pressbooks\Admin\Branding\get_customizer_colors();
	} else {
		$colors = [
			'primary',
			'accent',
			'primary_fg',
			'accent_fg',
			'primary_dark',
			'accent_dark',
			'primary_alpha',
			'accent_alpha',
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
}

/**
 * Remove Admin Bar callback.
 */
function remove_admin_bar_callback() {
	remove_action( 'wp_head', '_admin_bar_bump_cb' );
}

/**
 * Hide content editor for Catalog page.
 */
function hide_catalog_content_editor() {
	$post_id = $_GET['post'] ?? null;
	if ( ! isset( $post_id ) ) {
		return;
	}
	$template = get_page_template_slug( $post_id );
	if ( $template === 'page-catalog.php' ) {
		add_action(
			'edit_form_after_title', function() {
				printf( '<p>%s</p>', __( 'This page displays your network catalog, so there is no content to edit.', 'pressbooks-aldine' ) );
			}
		);
		remove_post_type_support( 'page', 'editor' );
		remove_post_type_support( 'page', 'thumbnail' );
	}
}

/**
 * Add dark and alpha variants for customizer colors on update.
 *
 * @param array $option Option
 * @param string $old_value Unused parameter
 * @param string $value Color value
 * @since 1.0.0
 */
function add_color_variants( $option, $old_value, $value ) {
	if ( ! in_array( $option, [ 'pb_network_color_primary', 'pb_network_color_accent' ], true ) ) {
		return;
	}

	$color = Hex::fromString( $value );
	$color = $color->toRgb();
	$color_alpha = $color->toRgba( 0.25 );
	$color_alpha = (string) $color_alpha;

	update_option( $option . '_alpha', $color_alpha );
}

/**
 * Register shortcode buttons.
 *
 * @since 1.1.0
 */
function register_shortcode_buttons() {
	if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	if ( get_user_option( 'rich_editing' ) !== 'true' ) {
		return;
	}

	add_filter( 'mce_external_plugins', '\Aldine\filters\add_buttons' );
	add_filter( 'mce_buttons', '\Aldine\filters\register_buttons' );
}

/**
 * Localize shortcode button strings.
 *
 * @since 1.1.0
 */
function tinymce_l18n() {
	?>
	<script type='text/javascript'>
		const aldine = {
			page_section: {
				'title': '<?php _e( 'Page Section', 'pressbooks-aldine' ); ?>',
				'title_label': '<?php _e( 'Title', 'pressbooks-aldine' ); ?>',
				'standard': '<?php _e( 'Standard', 'pressbooks-aldine' ); ?>',
				'accent': '<?php _e( 'Accent', 'pressbooks-aldine' ); ?>',
				'bordered': '<?php _e( 'Bordered', 'pressbooks-aldine' ); ?>',
				'borderless': '<?php _e( 'Borderless', 'pressbooks-aldine' ); ?>'
			},
			call_to_action: {
				'title': '<?php _e( 'Call to Action', 'pressbooks-aldine' ); ?>',
				'text': '<?php _e( 'Text', 'pressbooks-aldine' ); ?>',
				'link': '<?php _e( 'Link', 'pressbooks-aldine' ); ?>'
			}
		};
	</script>
	<?php
}

/**
 * Remove unwanted menu pages.
 *
 * @since 1.15.0
 */
function remove_menu_items() {
	remove_menu_page( 'edit.php' );
	remove_submenu_page( 'tools.php', 'import.php' );
	remove_submenu_page( 'tools.php', 'export.php' );
	remove_submenu_page( 'tools.php', 'tools.php' );
	remove_submenu_page( 'options-general.php', 'options-writing.php' );
	remove_submenu_page( 'options-general.php', 'options-reading.php' );
	remove_submenu_page( 'options-general.php', 'options-permalink.php' );
}

/**
 * Remove unwanted widgets.
 *
 * @since 1.15.0
 */
function remove_widgets() {
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Widget_Media_Audio' );
	unregister_widget( 'WP_Nav_Menu_Widget' );
	unregister_widget( 'WP_Widget_Custom_HTML' );
	unregister_widget( 'WP_Widget_Media_Video' );
	unregister_widget( 'Akismet_Widget' );
}
