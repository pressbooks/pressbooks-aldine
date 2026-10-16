<?php

/**
 * Aldine Shortcodes
 *
 * @package Aldine
 */

namespace Aldine;

use function Aldine\Helpers\get_featured_books;

class Shortcodes
{
    /**
     * Shortcode for Page Section.
     *
     * @param array $atts Shortcode attributes
     * @param string $content Page content
     *
     * @return string
     */
    public static function pageSection($atts, $content = null)
    {
        $atts = shortcode_atts(
            [
                'title' => '',
                'variant' => '',
            ],
            $atts,
            'aldine_page_section'
        );

        return sprintf(
            '<div class="page-section%1$s">%2$s%3$s</div>',
            ($atts['variant']) ? " page-section--{$atts['variant']}" : '',
            ($atts['title']) ? "<h2>{$atts['title']}</h2>" : '',
            $content
        );
    }

    /**
     * Shortcode for custom Call to Action.
     *
     * @param array $atts Shortcode attributes
     *
     * @return string
     */
    public static function callToAction($atts)
    {
        $atts = shortcode_atts(
            [
                'link' => '#',
                'url' => false,
                'text' => __('Call To Action', 'pressbooks-aldine'),
            ],
            $atts,
            'aldine_call_to_action'
        );

        // Fallback for shortcodes using the old url attribute.
        if ($atts['link'] === '#' && $atts['url']) {
            $atts['link'] = $atts['url'];
        }

        return sprintf(
            '<a class="call-to-action" href="%1$s" title="%2$s">%2$s</a>',
            $atts['link'],
            $atts['text']
        );
    }

    /**
     * Shortcode to display featured books anywhere.
     *
     * Usage: [latest-titles title="Custom Title"]
     *
     * @param array $atts Shortcode attributes.
     * @return string HTML markup of featured books.
     */
    public static function latestTitlesShortcode($atts): string
    {
        $atts = shortcode_atts([
            'title' => get_option('pb_front_page_catalog_title', __('Our Latest Titles', 'pressbooks-aldine')),
        ], $atts, 'latest-titles');

        $books = get_featured_books();
        if (empty($books) || empty($books['books'])) {
            return '';
        }

        $output  = '<div id="latest-books" class="latest-books">';
        $output .= '<h2 id="latest-books-title">' . esc_html($atts['title']) . '</h2>';
        $output .= '<div class="books">';
        foreach ($books['books'] as $book) {
            ob_start();
            $template = locate_template('partials/featured-book.php', false, false);
            if ($template) {
                include $template;
            }
            $output .= ob_get_clean();
        }
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}
