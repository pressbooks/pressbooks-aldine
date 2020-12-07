<?php
/**
 * Class Filters
 *
 * @package Pressbooks_Aldine
 */

use function \Aldine\Filters\register_query_vars;

/**
 * Filters test case.
 */
class FiltersTest extends WP_UnitTestCase {
	public function test_register_query_vars() {
		$vars = register_query_vars([]);
		$this->assertContains('license', $vars);
		$this->assertContains('subject', $vars);
	}
}
