<?php

namespace Aldine;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
    public function blockCount()
    {
        global $_wp_sidebars_widgets;
        if (empty($_wp_sidebars_widgets)) {
            $_wp_sidebars_widgets = get_option('sidebars_widgets', []);
        }
        $sidebars_widgets_count = $_wp_sidebars_widgets;
        if (isset($sidebars_widgets_count['front-page-block'])) {
            return count($sidebars_widgets_count['front-page-block']);
        }
        return 1;
    }

    public function totalPages()
    {
        $books = wp_remote_get(network_home_url('/wp-json/pressbooks/v2/books?per_page=3'));
        return $books['headers']['x-wp-totalpages'];
    }

    public function currentPage()
    {
        return get_query_var('page', 1);
    }

    public function previousPage()
    {
        return (get_query_var('page', 1) > 1) ? get_query_var('page') - 1 : 0;
    }

    public function nextPage()
    {
        return (get_query_var('page', 1) < FrontPage::totalPages()) ? get_query_var('page', 1) + 1 : 0;
    }

    public function latestBooksTitle()
    {
        $title = get_option('pb_front_page_catalog_title');
        if ($title) {
            return $title;
        }

        return __('Our Latest Titles', 'aldine');
    }

    public static function latestBooks($page = 1, $per_page = 3)
    {
        $books = wp_remote_get(network_home_url("/wp-json/pressbooks/v2/books?per_page=$per_page&page=$page"));
        $books = json_decode($books['body'], true);
        return $books;
    }
}
