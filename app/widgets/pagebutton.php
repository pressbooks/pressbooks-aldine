<?php

namespace Aldine;

class PageButton extends \WP_Widget
{
    /**
     * Constructor.
     *
     * @see WP_Widget::__construct()
     *
     */
    public function __construct()
    {
        parent::__construct('pagebutton', __('Page Button', 'aldine'), [
            'description' => esc_html__('Add a styled button which links to a page.', 'aldine')
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
        echo $args['before_widget'];
        if (! empty($instance['page_id'])) {
            if (empty($instance['title'])) {
                $instance['title'] = get_the_title($instance['page_id']);
            }
            printf('<a class="button" href="%1$s">%2$s</a>', get_permalink($instance['page_id']), apply_filters('widget_title', $instance['title']));
        }
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
        $url = ! empty($instance['page_id']) ? $instance['page_id'] : ''; ?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'aldine'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>"></p>
        <p><label for="<?php echo esc_attr($this->get_field_id('page_id')); ?>"><?php esc_attr_e('Page:', 'aldine'); ?></label>
        <select id="<?php echo esc_attr($this->get_field_id('page_id')); ?>" name="<?php echo esc_attr($this->get_field_name('page_id')); ?>">
            <option value="" <?php selected($instance['page_id'], ''); ?>> -- </a>
            <?php $pages = get_pages();
            foreach ($pages as $page) { ?>
                <option value="<?= $page->ID; ?>" <?php selected(@$instance['page_id'], $page->ID); ?>><?= $page->post_title; ?></option>
            <?php } ?>
        </select></p>
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
        $instance['page_id'] = ( ! empty($new_instance['page_id']) ) ? absint($new_instance['page_id']) : '';
        return $instance;
    }
}
