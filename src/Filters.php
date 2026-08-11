<?php

/**
 * Aldine Filters
 *
 * @package Aldine
 */

namespace Aldine;

use PressbooksFrontendTools\Assets;
use PressbooksFrontendTools\AssetType;

use function Aldine\Helpers\has_sections;

class Filters
{
    /**
     * Adds custom classes to the array of body classes.
     *
     * @see https://github.com/roots/sage/blob/master/app/filters.php
     *
     * @param array $classes Classes for the body element.
     * @return array
     */
    public static function bodyClasses(array $classes)
    {
        /** Add page slug if it doesn't exist */
        if (is_single() || is_page() && ! is_front_page()) {
            if (! in_array(basename(get_permalink()), $classes, true)) {
                $classes[] = basename(get_permalink());
            }
        }

        /** Add .has-sections if page content has sections */
        if (is_single() || is_front_page() || is_page() && has_sections(get_the_ID())) {
            $classes[] = 'has-sections';
        }

        /** Clean up class names for custom templates */
        $classes = array_map(
            function ($class) {
                return preg_replace([ '/-php$/', '/^page-template-views/' ], '', $class);
            },
            $classes
        );

        return array_filter($classes);
    }

    /**
     * Add custom query vars for catalog.
     *
     * @param array $vars The array of available query variables.
     *
     * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
     */
    public static function registerQueryVars($vars)
    {
        $vars[] = 'license';
        $vars[] = 'subject';
        return $vars;
    }

    /**
     * Customize excerpt.
     *
     * @return string
     */
    public static function excerptMore()
    {
        return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'pressbooks-aldine') . '</a>';
    }

    /**
     * Add things to the menu.
     *
     * @param string $items Items
     * @param object $args Args
     * @return string
     */
    public static function adjustMenu($items, $args)
    {
        if ($args->theme_location === 'primary-menu') {
            return \Aldine\Helpers\get_default_menu($items);
        }

        return $items;
    }

    /**
     * Add TinyMCE Buttons.
     *
     * @param array $plugin_array Plugin array
     * @since 1.1.0
     */
    public static function addButtons($plugin_array)
    {
        $assets = new Assets('pressbooks-aldine', AssetType::THEME);

        $plugin_array['aldine_call_to_action'] = $assets->getAssetUrl('assets/scripts/call-to-action.js');
        $plugin_array['aldine_page_section'] = $assets->getAssetUrl('assets/scripts/page-section.js');
        return $plugin_array;
    }

    /**
     * Register TinyMCE Buttons.
     *
     * @param array $buttons TinyMCE Buttons
     * @since 1.1.0
     */
    public static function registerButtons($buttons)
    {
        $c = count($buttons);
        $i = $c - 2;
        $new_items = [ 'aldine_page_section', 'aldine_call_to_action' ];
        array_splice($buttons, $i, 0, $new_items);
        return $buttons;
    }
}
