<?php

/**
 * Aldine functions and hooks
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Aldine
 */

/**
 * Ensure dependencies are loaded (PSR-4 classes + namespaced function files).
 */
$composer = get_template_directory() . '/vendor/autoload.php';
if (! file_exists($composer)) {
    wp_die(
        sprintf(
            '<h1>%1$s</h1><p>%2$s</p>',
            __('Dependencies Missing', 'pressbooks-aldine'),
            __('You must run <code>composer install</code> from the Aldine directory.', 'pressbooks-aldine')
        )
    );
}
require_once $composer;

add_action('after_switch_theme', [\Aldine\Activation::class, 'createDefaultContent'], 10);
add_action('after_switch_theme', [\Aldine\Activation::class, 'createMenus'], 11);
add_action('after_switch_theme', [\Aldine\Activation::class, 'assignMenus'], 12);
add_action('admin_bar_init', [\Aldine\Actions::class, 'removeAdminBarCallback']);
add_action('after_setup_theme', [\Aldine\Actions::class, 'setup']);
add_action('after_setup_theme', [\Aldine\Actions::class, 'contentWidth'], 0);
add_action('wp_head', [\Aldine\Actions::class, 'outputCustomColors']);
add_action('init', [\Aldine\Actions::class, 'addEditorStyles']);
add_action('admin_init', [\Aldine\Actions::class, 'hideCatalogContentEditor']);
foreach ([ 'post.php', 'post-new.php' ] as $hook) {
    add_action("admin_head-$hook", [\Aldine\Actions::class, 'tinymceL18N']);
}
add_filter('body_class', [\Aldine\Filters::class, 'bodyClasses']);
add_filter('excerpt_more', [\Aldine\Filters::class, 'excerptMore']);
add_filter('query_vars', [\Aldine\Filters::class, 'registerQueryVars']);
add_filter('wp_nav_menu_items', [\Aldine\Filters::class, 'adjustMenu'], 10, 2);
add_filter('the_content', 'apply_shortcodes');
add_filter('show_admin_bar', '__return_false');
add_action('widgets_init', [\Aldine\Actions::class, 'widgetsInit']);
add_action('widgets_init', [\Aldine\Actions::class, 'removeWidgets']);
add_action('wp_enqueue_scripts', [\Aldine\Actions::class, 'enqueueAssets']);
add_action('updated_option', [\Aldine\Actions::class, 'addColorVariants'], 10, 3);
add_action('customize_register', [\Aldine\Customizer::class, 'customizeRegister']);
add_action('customize_preview_init', [\Aldine\Customizer::class, 'customizePreviewJs']);
add_action('customize_controls_enqueue_scripts', [\Aldine\Customizer::class, 'enqueueColorContrastValidator']);
add_action('customize_controls_enqueue_scripts', [\Aldine\Customizer::class, 'featuredBooksScripts']);
add_action('customize_controls_enqueue_scripts', [\Aldine\Customizer::class, 'enqueueContactFormTweaks']);
add_action('customize_controls_enqueue_scripts', [\Aldine\Customizer::class, 'enqueuePbA11YInCustomizer']);
add_action('customize_controls_enqueue_scripts', [\Aldine\Customizer::class, 'enqueueCatalogSearchControlAssets']);
add_action('wp_ajax_pb_search_catalog_books', [\Aldine\Customizer::class, 'ajaxSearchCatalogBooks']);

// Shortcodes.
add_shortcode('aldine_page_section', [\Aldine\Shortcodes::class, 'pageSection']);
add_shortcode('aldine_call_to_action', [\Aldine\Shortcodes::class, 'callToAction']);
add_shortcode('latest-titles', [\Aldine\Shortcodes::class, 'latestTitlesShortcode']);

// Catalog page: Network admin controls.
add_action('admin_enqueue_scripts', [\Aldine\Admin\Catalog::class, 'adminScripts']);
add_action('wp_ajax_pressbooks_aldine_update_catalog', [\Aldine\Admin\Catalog::class, 'updateCatalog']);
add_filter('wpmu_blogs_columns', [\Aldine\Admin\Catalog::class, 'catalogColumns']);
add_action('manage_blogs_custom_column', [\Aldine\Admin\Catalog::class, 'catalogColumn'], 1, 3);
add_action('manage_sites_custom_column', [\Aldine\Admin\Catalog::class, 'catalogColumn'], 1, 3);

// Remove unwanted menu pages.
add_action('admin_menu', [\Aldine\Actions::class, 'removeMenuItems']);

// Remove unwanted actions.
remove_action('before_delete_post', '_reset_front_page_settings_for_post');
remove_action('wp_trash_post', '_reset_front_page_settings_for_post');

add_action('init', [ \Aldine\Admin\PageLanguageMetabox::class, 'init' ]);
