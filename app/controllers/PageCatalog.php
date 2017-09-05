<?php

namespace Aldine;

use Sober\Controller\Controller;

class PageCatalog extends Controller
{
    public function licenses()
    {
        $licenses = (new \Pressbooks\Licensing())->getSupportedTypes();
        foreach ($licenses as $key => $value) {
            $licenses[$key] = preg_replace("/\([^)]+\)/", '', $value['desc']);
        }
        return $licenses;
    }

    public function subjectGroups()
    {
        return [
            'business-finance' => [
              'title' => __('Business and Finance', 'aldine'),
              'subjects' => [
                'accounting' => 'Accounting',
                'finance' => 'Finance',
                'information-systems' => 'Information Systems',
                'management' => 'Management',
                'marketing' => 'Marketing',
                'economics' => 'Economics',
              ],
            ],
            'engineering-technology' => [
              'title' => __('Engineering &amp; Technology', 'aldine'),
              'subjects' => [
                'architecture' => 'Architecture',
                'bioengineering' => 'Bioengineering',
                'chemical' => 'Chemical',
                'civil' => 'Civil',
                'electrical' => 'Electrical',
                'mechanical' => 'Mechanical',
                'mining-and-materials' => 'Mining and Materials',
                'urban-planning' => 'Urban Planning',
                'computer-science' => 'Computer Science',
              ],
            ],
            'health-sciences' => [
              'title' => __('Health Sciences', 'aldine'),
              'subjects' => [
                'nursing' => 'Nursing',
                'dentistry' => 'Dentistry',
                'medicine' => 'Medicine',
              ],
            ],
            'humanities-arts' => [
              'title' => __('Humanities &amp; Arts', 'aldine'),
              'subjects' => [
                'archaeology' => 'Archaeology',
                'art' => 'Art',
                'classics' => 'Classics',
                'literature' => 'Literature',
                'history' => 'History',
                'media' => 'Media',
                'music' => 'Music',
                'philosophy' => 'Philosophy',
                'religion' => 'Religion',
                'language' => 'Language',
              ],
            ],
            'reference' => [
              'title' => __('Reference', 'aldine'),
              'subjects' => [
                'student-guides' => 'Student Guides',
                'teaching-guides' => 'Teaching Guides',
              ],
            ],
            'science' => [
              'title' => __('Sciences', 'aldine'),
              'subjects' => [
                'biology' => 'Biology',
                'chemistry' => 'Chemistry',
                'environent-and-earth-sciences' => 'Environment and Earth Sciences',
                'geography' => 'Geography',
                'mathematics' => 'Mathematics',
                'physics' => 'Physics',
              ],
            ],
            'social-sciences' => [
              'title' => __('Social Sciences', 'aldine'),
              'subjects' => [
                'anthropology' => 'Anthropology',
                'gender-studies' => 'Gender Studies',
                'linguistics' => 'Linguistics',
                'museums-libraries-and-information-sciences' => 'Museums, Libraries, and Information Sciences',
                'political-science' => 'Political Science',
                'psychology' => 'Psychology',
                'social-work' => 'Social Work',
                'sociology' => 'Sociology',
              ],
            ],
        ];
    }

    public function totalPages()
    {
        return App::totalPages(9);
    }

    public function books()
    {
        $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $orderby = (get_query_var('orderby')) ? get_query_var('orderby') : 'title';
        $subject = (get_query_var('subject')) ? get_query_var('subject') : '';
        $license = (get_query_var('license')) ? get_query_var('license') : '';
        return App::books($page, 9, $orderby, $license, $subject);
    }
}
