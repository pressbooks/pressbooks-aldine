<?php

namespace Aldine;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteLogo()
    {
        $custom_logo_id = get_theme_mod('custom_logo');
        if (has_custom_logo()) {
            return wp_get_attachment_image($custom_logo_id, 'original');
        } else {
            return file_get_contents(get_theme_file_path() . '/dist/' . svg_path('images/logo.svg'));
        }
    }

    public function siteName()
    {
        return get_bloginfo('name');
    }

    public function networkFacebook()
    {
        return get_option('pb_network_facebook');
    }

    public function networkTwitter()
    {
        return get_option('pb_network_twitter');
    }

    public static function networkFooter($index)
    {
        if ($index === 2) {
            if (get_option('pb_network_facebook')
                || get_option('pb_network_twitter')
                || is_active_sidebar("network-footer-block-$index")
            ) {
                return "network-footer-block-$index";
            } else {
                return 'empty';
            }
        }
        return (is_active_sidebar("network-footer-block-$index")) ? "network-footer-block-$index" : 'empty';
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

    public function contactFormTitle()
    {
        $title = get_option('pb_network_contact_form_title');
        if ($title) {
            return $title;
        }

        return __('Contact Us', 'aldine');
    }

    public function currentPage()
    {
        if (is_front_page()) {
            return (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            return (get_query_var('paged')) ? get_query_var('paged') : 1;
        }
    }

    public function currentSubject()
    {
        return (get_query_var('pb_subject')) ? get_query_var('pb_subject') : '';
    }

    public function currentLicense()
    {
        return (get_query_var('pb_license')) ? get_query_var('pb_license') : '';
    }

    public function currentOrderBy()
    {
        return (get_query_var('orderby')) ? get_query_var('orderby') : 'title';
    }

    public static function previousPage($page)
    {
        return ($page > 1) ? $page - 1 : 0;
    }

    public static function nextPage($page, $per_page = 10)
    {
        return ($page < App::totalPages($per_page)) ? $page + 1 : 0;
    }

    public static function totalPages($per_page = 10)
    {
        $request = new \WP_REST_Request('GET', '/pressbooks/v2/books');
        $request->set_query_params([
            'per_page' => $per_page,
        ]);
        $response = rest_do_request($request);
        return $response->headers['X-WP-TotalPages'];
    }

    public static function books($page = 1, $per_page = 10, $orderby = 'title', $license = '', $subject = '')
    {
        $request = new \WP_REST_Request('GET', '/pressbooks/v2/books');
        $request->set_query_params([
            'page' => $page,
            'per_page' => $per_page,
        ]);
        $response = rest_do_request($request);
        $data = rest_get_server()->response_to_data($response, true);
        $books = [];
        foreach ($data as $key => $book) {
            $book['title'] = $book['metadata']['name'];
            $book['date-published'] = (isset($book['metadata']['datePublished'])) ?
                $book['metadata']['datePublished'] :
                '';
            $book['subject'] = (isset($book['metadata']['keywords'])) ? $book['metadata']['keywords'] : '';
            $books[] = $book;
        }
        if ($orderby === 'latest') {
            return wp_list_sort($books, $orderby, 'desc');
        } else {
            return wp_list_sort($books, $orderby);
        }
    }
}
