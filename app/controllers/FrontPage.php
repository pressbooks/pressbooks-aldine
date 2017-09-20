<?php

namespace Aldine;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
    public function blockCount()
    {
        global $_wp_sidebars_widgets;
        if (!empty($_wp_sidebars_widgets['front-page-block'])) {
            return count($_wp_sidebars_widgets['front-page-block']);
        }
        return 1;
    }

    public function latestBooksTitle()
    {
        $title = get_option('pb_front_page_catalog_title');
        if ($title) {
            return $title;
        }

        return __('Our Latest Titles', 'aldine');
    }

    public function catalogData()
    {
        $page = (get_query_var('page')) ? get_query_var('page') : 1;
        return App::catalogData($page, 3);
    }
}
