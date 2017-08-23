<?php

namespace Aldine;

class LatestBooks extends \WP_Widget
{
    /**
     * Constructor.
     *
     * @see WP_Widget::__construct()
     *
     */
    public function __construct()
    {
        parent::__construct('latestbooks', __('Latest Books', 'aldine'), [
            'description' => esc_html__('Your network&#8217;s latest books.', 'aldine')
        ]);
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        $number = (! empty($instance['number'])) ? absint($instance['number']) : 3;
        if (!$number) {
            $number = 3;
        }
        if (empty($instance['title'])) {
            $instance['title'] = __('Latest Books', 'aldine');
        }
        echo $args['before_widget'];
        echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        $books = wp_remote_get(home_url('/wp-json/pressbooks/v2/books'));
        $books = json_decode($books['body'], true);
        echo '<div class="books">';
        for ($i = 0; $i < $number; $i++) {
            printf(
                '<div class="book">
                    <a class="subject" href="">TK</a>
                    <a class="title" href="%1$s">%2$s</a>
                    <a class="read-more" href="%1$s">%3$s</a>
                </div>',
                $books[$i]['link'],
                $books[$i]['metadata']['name'],
                __('About this book &rarr;', 'aldine')
            );
        }
        echo '</div>';
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $title = ! empty($instance['title']) ? $instance['title'] : '';
        $number = ! empty($instance['number']) ? absint($instance['number']) : 3; ?>
        <p><label for="<?= $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input
            class="widefat"
            id="<?= $this->get_field_id('title'); ?>"
            name="<?= $this->get_field_name('title'); ?>"
            type="text"
            value="<?= $title; ?>" /></p>
        <p><label for="<?= $this->get_field_id('number'); ?>"><?php _e('Number of books to show:'); ?></label>
        <input
            class="tiny-text"
            id="<?= $this->get_field_id('number'); ?>"
            name="<?= $this->get_field_name('number'); ?>"
            type="number"
            step="1"
            min="1"
            value="<?= $number; ?>"
            size="3" /></p>
    <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = ( ! empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['number'] = (int) $new_instance['number'];
        return $instance;
    }
}
