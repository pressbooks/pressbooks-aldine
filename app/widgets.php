<?php

namespace App;

add_action('widgets_init', function () {
    register_widget('Aldine\LinkButton');
    register_widget('Aldine\PageButton');
});
