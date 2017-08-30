<?php

namespace Aldine;

use Sober\Controller\Controller;

class App extends Controller
{
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
}
