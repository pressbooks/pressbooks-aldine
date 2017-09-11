<?php

namespace Aldine;

use function \Sober\Intervention\intervention;

if (function_exists('\Sober\Intervention\intervention')) {
    intervention('remove-customizer-items', 'static-front-page', 'all');
    intervention('remove-emoji');
    intervention('remove-howdy', __('Hello,', 'aldine'));
    intervention('remove-dashboard-items', ['activity', 'quick-draft']);
    intervention('remove-menu-items', [
        'posts',
        'tools',
        'setting-writing',
        'setting-reading',
        'setting-permalink'
    ], 'all');
    intervention('remove-widgets', [
        'pages',
        'calendar',
        'archives',
        'links',
        'media-audio',
        'meta',
        'search',
        'categories',
        'recent-posts',
        'recent-comments',
        'rss',
        'tag-cloud',
        'custom-menu',
        'custom-html',
        'media-video',
        'akismet',
    ], 'all');
    intervention('remove-toolbar-frontend', 'all');
}
