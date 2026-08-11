<?php

/**
 * Class Filters
 *
 * @package Pressbooks_Aldine
 */

use Aldine\Filters;

/**
 * Filters test case.
 */
class FiltersTest extends WP_UnitTestCase
{
    public function test_register_query_vars()
    {
        $vars = Filters::registerQueryVars([]);
        $this->assertContains('license', $vars);
        $this->assertContains('subject', $vars);
    }
}
