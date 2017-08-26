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
    wp_enqueue_style(
        'aldine/webfonts',
        'https://fonts.googleapis.com/css?family=Karla:400,400i,700|Spectral:400,400i,600',
        false,
        null
    );
    wp_enqueue_style('aldine/main.css', asset_path('styles/main.css'), false, null);
    /* wp_enqueue_style(
        'uio/normalize.css',
        get_theme_file_uri() . '/lib/infusion/src/lib/normalize/css/normalize.css',
        false,
        null
    );
    wp_enqueue_style(
        'uio/fluid.css',
        get_theme_file_uri() . '/lib/infusion/src/framework/core/css/fluid.css',
        false,
        null
    );
    wp_enqueue_style(
        'uio/enactors.css',
        get_theme_file_uri() . '/lib/infusion/src/framework/preferences/css/Enactors.css',
        false,
        null
    );
    wp_enqueue_style(
        'uio/prefseditor.css',
        get_theme_file_uri() . '/lib/infusion/src/framework/preferences/css/PrefsEditor.css',
        false,
        null
    );
    wp_enqueue_style(
        'uio/separatedpanelprefseditor.css',
        get_theme_file_uri() . '/lib/infusion/src/framework/preferences/css/SeparatedPanelPrefsEditor.css',
        false,
        null
    );
    wp_enqueue_script('uio.js', get_theme_file_uri() . '/lib/infusion/infusion-uiOptions.js', ['jquery'], null, true);
    */
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
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Home Block 1', 'aldine'),
        'id'            => 'home-block-1'
    ] + $config);
    register_sidebar([
        'name'          => __('Home Block 2', 'aldine'),
        'id'            => 'home-block-2'
    ] + $config);
    register_sidebar([
        'name'          => __('Home Block 3', 'aldine'),
        'id'            => 'home-block-3'
    ] + $config);
    register_sidebar([
        'name'          => __('Home Block 4', 'aldine'),
        'id'            => 'home-block-4'
    ] + $config);
    register_sidebar([
        'name'          => __('Network Footer Block 1', 'aldine'),
        'id'            => 'network-footer-block-1'
    ] + $config);
    register_sidebar([
        'name'          => __('Network Footer Block 2', 'aldine'),
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
