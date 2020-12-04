<?php
/**
 * Class Filters
 *
 * @package Pressbooks_Aldine
 */

/**
 * Filters test case.
 */
class FiltersTest extends WP_UnitTestCase {
	public function test_register_query_vars() {
		$vars = \Aldine\Helpers\register_query_vars([]);
		$this->assertContains('license', $vars);
		$this->assertContains('subject', $vars);
	}
}
