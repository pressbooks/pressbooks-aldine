<?php

namespace Aldine;

use Sober\Controller\Controller;

class PageCatalog extends Controller
{
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
              'title' => __('Engineering and Technology', 'aldine'),
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
              'title' => __('Humanities and Arts', 'aldine'),
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
}
