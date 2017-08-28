<?php

namespace Aldine;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
    public function blockCount()
    {
        $c = 0;
        foreach ([
            'home-block-1',
            'home-block-2',
            'home-block-3',
            'home-block-4'
        ] as $block) {
            if (is_active_sidebar($block)) {
                $c++;
            }
        }
        return $c;
    }

    public function blocks()
    {
        $blocks = [];
        for ($i = 0; $i < 4; $i++) {
            if (is_active_sidebar("home-block-$i")) {
                $blocks[] = "home-block-$i";
            }
        }

        return $blocks;
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

    public static function latestBooks($offset = null)
    {
        $path = ($offset) ?
            "/wp-json/pressbooks/v2/books?per_page=3&page=$offset" :
            '/wp-json/pressbooks/v2/books?per_page=3';
        $books = wp_remote_get(network_home_url($path));
        $books = json_decode($books['body'], true);
        return $books;
    }
}
