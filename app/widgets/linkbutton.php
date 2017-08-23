<?php

namespace Aldine;

class LinkButton extends \WP_Widget
{
    /**
     * Constructor.
     *
     * @see WP_Widget::__construct()
     *
     */
    public function __construct()
    {
        parent::__construct('linkbutton', __('Link Button', 'pressbooks-aldine'), [
            'description' => esc_html__('Add a styled link button.', 'pressbooks-aldine')
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
        if (! empty($instance['url']) && ! empty($instance['title'])) {
            printf('<a class="button" href="%1$s">%2$s</a>', $instance['url'], apply_filters('widget_title', $instance['title']));
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
        $url = ! empty($instance['url']) ? $instance['url'] : ''; ?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'pressbooks-aldine'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>"></p>
        <p><label for="<?php echo esc_attr($this->get_field_id('url')); ?>"><?php esc_attr_e('URL:', 'pressbooks-aldine'); ?></label>
        <input class="widefat code" id="<?php echo esc_attr($this->get_field_id('url')); ?>" name="<?php echo esc_attr($this->get_field_name('url')); ?>" type="text" value="<?php echo esc_attr($url); ?>"></p>
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
        $instance['url'] = ( ! empty($new_instance['url']) ) ? esc_url($new_instance['url']) : '';
        return $instance;
    }
}
