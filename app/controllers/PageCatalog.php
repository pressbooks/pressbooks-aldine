<?php

namespace Aldine;

use Sober\Controller\Controller;

class PageCatalog extends Controller
{
    public function licenses()
    {
        if (function_exists('pb_meets_minimum_requirements') && pb_meets_minimum_requirements()) {
            $licenses = (new \Pressbooks\Licensing())->getSupportedTypes();
            foreach ($licenses as $key => $value) {
                $licenses[$key] = preg_replace("/\([^)]+\)/", '', $value['desc']);
            }
            return $licenses;
        } else {
            return [];
        }
    }

    public function subjectGroups()
    {
        return \Pressbooks\Metadata\get_thema_subjects();
    }

    public function catalogData()
    {
        $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $orderby = (get_query_var('orderby')) ? get_query_var('orderby') : 'title';
        $subject = (get_query_var('subject')) ? get_query_var('subject') : '';
        $license = (get_query_var('license')) ? get_query_var('license') : '';
        return App::catalogData($page, 9, $orderby, $license, $subject);
    }
}
