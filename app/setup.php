<?php

namespace Aldine;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    $webfonts = 'https://fonts.googleapis.com/css?family=Karla:400,400i,700|Spectral:400,400i,600';
    wp_enqueue_style('aldine/webfonts', $webfonts, false, null);
    wp_enqueue_style('aldine/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('aldine/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);
    wp_localize_script('aldine/main.js', 'SAGE_DIST_PATH', get_theme_file_uri() . '/dist/');
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'network-footer-menu' => __('Network Footer Menu', 'aldine')
    ]);

    /**
     * Enable custom headers
     * @link https://developer.wordpress.org/themes/functionality/custom-headers/
     */
    add_theme_support('custom-header', [
        'default-image' => asset_path('images/header.jpg'),
        'width' => 1920,
        'height' => 884,
        'default-text-color' => '#000',
    ]);

    /**
     * Enable custom logos
     * @link https://developer.wordpress.org/themes/functionality/custom-logo/
     */
    add_theme_support('custom-logo', [
        'height' => 40,
        'width' => 265,
        'flex-width' => true,
        'flex-height' => true,
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="tc ttu">',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Front Page Content', 'aldine'),
        'description'   => __(
            'Add content for your network&rsquo;s front page here. Currently, only text widgets are supported.',
            'aldine'
        ),
        'id'            => 'front-page-block',
        'before_widget' => '<section class="block %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="tc ttu">',
        'after_title'   => '</h3>'
    ]);
    register_sidebar([
        'name'          => __('Network Footer Block 1', 'aldine'),
        'description'   => __(
            'Add content for your network&rsquo;s customizeable footer here.
            Currently, only text and image widgets are supported.
            Content in this widget area will appear in the first row (on mobile) or the first column (on desktops).',
            'aldine'
        ),
        'id'            => 'network-footer-block-1'
    ] + $config);
    register_sidebar([
        'name'          => __('Network Footer Block 2', 'aldine'),
        'description'   => __(
            'Add content for your network&rsquo;s customizeable footer here.
            Currently, only text and image widgets are supported.
            Content in this widget area will appear in the second row (on mobile) or the middle column (on desktop).',
            'aldine'
        ),
        'id'            => 'network-footer-block-2'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});

add_action('wp_head', function () {
    $primary = get_option('pb_network_color_primary');
    $accent = get_option('pb_network_color_accent');
    $primary_fg = get_option('pb_network_color_primary_fg');
    $accent_fg = get_option('pb_network_color_accent_fg');
    $header_text = get_header_textcolor();
    if ($primary || $accent || $primary_fg || $accent_fg || $header_text) { ?>
<style type="text/css">:root {
<?php if ($primary) { ?>
--primary: <?= $primary ?>;
<?php }
if ($accent) { ?>
--accent: <?= $accent ?>;
<?php }
if ($primary_fg) { ?>
--primary-fg: <?= $primary_fg ?>;
<?php }
if ($accent_fg) { ?>
--accent-fg: <?= $accent_fg ?>;
<?php }
if ($header_text) { ?>
--header-text: <?= $header_text ?>;
<?php } ?>
}</style>
    <?php }
});

add_action('wp_head', function () {
    $response = contact_form_submission();
    sage('blade')->share('contact_form_response', $response);
});
