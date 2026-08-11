<?php

/**
 * Featured Books Search Control
 *
 * @package Aldine
 */

namespace Aldine\Customizer;

/**
 * Search Featured Books class
 */
class SearchFeaturedBooks extends \WP_Customize_Control
{
    /**
     * The type of control being rendered.
     *
     * @var string
     */
    public $type = 'search-books';

    /**
     * Render the control's content.
     *
     * @return void
     */
    public function render_content(): void // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {$dc            = \Pressbooks\DataCollector\Book::init();
        $current_id    = intval($this->value());
        $current_title = $current_id
            ? $dc->get($current_id, $dc::TITLE)
            : '';

        include get_template_directory() . '/partials/search-featured-books.php';
    }
}
