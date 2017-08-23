<?php

namespace Aldine;

use Sober\Controller\Controller;

class Aldine extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'aldine');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'aldine'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'aldine');
        }
        return get_the_title();
    }
}
