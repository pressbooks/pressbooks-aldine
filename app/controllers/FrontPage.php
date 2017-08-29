<?php

namespace Aldine;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
    public function blockCount()
    {
        $c = 0;
        for ($i = 1; $i < 5; $i++) {
            if (get_option("pb_front_page_block_${i}_content")) {
                $c++;
            }
        }
        return $c;
    }

    public function blocks()
    {
        $blocks = [];
        for ($i = 1; $i < 5; $i++) {
            $block = [];
            $title = get_option("pb_front_page_block_${i}_title");
            $content = get_option("pb_front_page_block_${i}_content");
            $button_title = get_option("pb_front_page_block_${i}_button_title");
            $button_url = get_option("pb_front_page_block_${i}_button_url");
            if ($title) {
                $block['title'] = $title;
            }
            if ($content) {
                $block['content'] = wpautop($content);
            }
            if ($button_title && $button_url) {
                $block['button_title'] = $button_title;
                $block['button_url'] = $button_url;
            }
            $blocks[] = $block;
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
