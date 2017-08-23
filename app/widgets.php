<?php

namespace Aldine;

add_action('widgets_init', function () {
    foreach ([
        'WP_Widget_Pages',
        'WP_Widget_Calendar',
        'WP_Widget_Archives',
        'WP_Widget_Links',
        'WP_Widget_Media_Audio',
        'WP_Widget_Meta',
        'WP_Widget_Search',
        'WP_Widget_Categories',
        'WP_Widget_Recent_Posts',
        'WP_Widget_Recent_Comments',
        'WP_Widget_Tag_Cloud'
    ] as $widget) {
        unregister_widget($widget);
    }
    register_widget('Aldine\LatestBooks');
    register_widget('Aldine\LinkButton');
    register_widget('Aldine\PageButton');
});
