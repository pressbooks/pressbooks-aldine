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

    public function contactFormResponse()
    {
        if (isset($_POST['submitted'])) {
            $output = [];
            $name = (isset($_POST['visitor_name'])) ? $_POST['visitor_name'] : false;
            $email = (isset($_POST['visitor_email'])) ? $_POST['visitor_email'] : false;
            $institution = (isset($_POST['visitor_institution'])) ? $_POST['visitor_institution'] : false;
            $message = (isset($_POST['message'])) ? $_POST['message'] : false;
            if (!$name) {
                $output['message'] = __('Name is required.', 'aldine');
                $output['status'] = 'error';
                $output['field'] = 'visitor_name';
            } elseif (!$email) {
                $output['message'] = __('Email is required.', 'aldine');
                $output['status'] = 'error';
                $output['field'] = 'visitor_email';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $output['message'] = __('Email is invalid.', 'aldine');
                $output['status'] = 'error';
                $output['field'] = 'visitor_email';
            } elseif (!$institution) {
                $output['message'] = __('Institution is required.', 'aldine');
                $output['status'] = 'error';
                $output['field'] = 'visitor_institution';
            } elseif (!$message) {
                $output['message'] = __('Message is required.', 'aldine');
                $output['status'] = 'error';
                $output['field'] = 'message';
            } else {
                $sent = wp_mail(
                    get_option('admin_email'),
                    __('Contact Form: ', 'aldine') . $name,
                    sprintf(
                        "From: %1\$s <%2\$s>\n%3\$s",
                        $name,
                        $email,
                        strip_tags($message)
                    ),
                    "From: ${email}\r\nReply-To: ${email}\r\n"
                );
                if ($sent) {
                    $output['message'] = __('Your message was sent!', 'aldine');
                    $output['status'] = 'success';
                } else {
                    $output['message'] = __('Your message could not be sent.', 'aldine');
                    $output['status'] = 'error';
                }
            }
            return $output;
        }
        return false;
    }
}
