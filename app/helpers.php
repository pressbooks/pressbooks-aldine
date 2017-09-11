<?php

namespace Aldine;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    if (remove_action('wp_head', 'wp_enqueue_scripts', 1)) {
        wp_enqueue_scripts();
    }

    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param $asset
 * @return string
 */
function svg_path($asset)
{
    return sage('assets')->get($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                        "{$template}.blade.php",
                        "{$template}.php",
                    ];
                });
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 *
 * Catch a contact form submission.
 *
 * @return false | array
 */
function contact_form_submission()
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
                sprintf(__('Contact Form Submission from %s', 'aldine'), $name),
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
