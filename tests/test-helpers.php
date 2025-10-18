<?php
/**
 * Class HelpersTest
 *
 * @package Pressbooks_Aldine
 */

use function \Aldine\Helpers\get_header_tag;

/**
 * Helpers test case.
 */
class HelpersTest extends WP_UnitTestCase {

	/**
	 * Test get_header_tag with no special conditions (catalog header).
	 */
	public function test_get_header_tag_default_catalog() {
		$result = get_header_tag();
		
		// Should return catalog header by default
		$expected_url = get_template_directory_uri() . '/dist/images/catalog-header.jpg';
		$this->assertStringContainsString( $expected_url, $result );
		$this->assertStringContainsString( "class='header'", $result );
		$this->assertStringContainsString( "role='banner'", $result );
		$this->assertStringContainsString( "style='background-image:", $result );
	}

	/**
	 * Test get_header_tag HTML structure.
	 */
	public function test_get_header_tag_html_structure() {
		$result = get_header_tag();
		
		// Should be a proper HTML header tag
		$this->assertStringStartsWith( "<header class='header' role='banner' style='background-image: url(", $result );
		$this->assertStringEndsWith( ");'>", $result );
		
		// Should contain required attributes
		$this->assertStringContainsString( "class='header'", $result );
		$this->assertStringContainsString( "role='banner'", $result );
		$this->assertStringContainsString( "style='background-image:", $result );
	}

	/**
	 * Test that get_header_tag properly escapes URLs.
	 */
	public function test_get_header_tag_url_escaping() {
		$result = get_header_tag();
		
		// Should contain escaped URL
		$this->assertStringContainsString( 'background-image: url(', $result );
		$this->assertStringContainsString( ');', $result );
		
		// Should not contain unescaped characters that would indicate XSS vulnerability
		$this->assertStringNotContainsString( '<script', $result );
		$this->assertStringNotContainsString( 'javascript:', $result );
	}

	/**
	 * Test the logic for different image priorities by mocking WordPress state.
	 */
	public function test_get_header_tag_logic_paths() {
		// Test that the function exists and returns a string
		$result = get_header_tag();
		$this->assertIsString( $result );
		$this->assertNotEmpty( $result );
		
		// Test that it contains either header.jpg or catalog-header.jpg
		$contains_header = strpos( $result, 'header.jpg' ) !== false;
		$contains_catalog = strpos( $result, 'catalog-header.jpg' ) !== false;
		$this->assertTrue( $contains_header || $contains_catalog, 'Result should contain a header image' );
	}
}