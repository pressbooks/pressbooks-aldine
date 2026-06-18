<?php

use function Aldine\Helpers\render_turnstile;
use function Aldine\Helpers\verify_turnstile;
use function Aldine\Helpers\handle_contact_form_submission;

class TurnstileTest extends WP_UnitTestCase {

	public function test_render_turnstile_no_constant() {
		$this->assertNull( render_turnstile() );
		$this->expectOutputString( '' );
		render_turnstile();
	}

	public function test_render_turnstile_with_constant() {
		define( 'CLOUDFLARE_TURNSTILE_SITE_KEY', '0x4AAAAAAA' );
		$this->expectOutputRegex( '/data-sitekey="0x4AAAAAAA"/' );
		render_turnstile();
		$this->assertTrue( wp_script_is( 'cf-turnstile', 'enqueued' ) );
	}

	public function test_verify_turnstile_no_constant() {
		$this->assertTrue( verify_turnstile() );
	}

	public function test_verify_turnstile_missing_token() {
		define( 'CLOUDFLARE_TURNSTILE_SECRET_KEY', '0x4AAAAAAA' );
		unset( $_POST['cf-turnstile-response'] );
		$this->assertFalse( verify_turnstile() );
	}

	public function test_verify_turnstile_success() {
		define( 'CLOUDFLARE_TURNSTILE_SECRET_KEY', '0x4AAAAAAA' );
		$_POST['cf-turnstile-response'] = 'valid-token';
		add_filter( 'pre_http_request', function () {
			return [ 'body' => wp_json_encode( [ 'success' => true ] ) ];
		} );
		$this->assertTrue( verify_turnstile() );
	}

	public function test_verify_turnstile_failure() {
		define( 'CLOUDFLARE_TURNSTILE_SECRET_KEY', '0x4AAAAAAA' );
		$_POST['cf-turnstile-response'] = 'bad-token';
		add_filter( 'pre_http_request', function () {
			return [ 'body' => wp_json_encode( [ 'success' => false ] ) ];
		} );
		$this->assertFalse( verify_turnstile() );
	}

	public function test_contact_form_rejects_failed_turnstile() {
		define( 'CLOUDFLARE_TURNSTILE_SECRET_KEY', '0x4AAAAAAA' );
		$_POST['pb_root_contact_form_nonce'] = wp_create_nonce( 'pb_root_contact_form' );
		$_POST['submitted'] = '1';
		$_POST['cf-turnstile-response'] = 'bad-token';
		add_filter( 'pre_http_request', function () {
			return [ 'body' => wp_json_encode( [ 'success' => false ] ) ];
		} );
		$result = handle_contact_form_submission();
		$this->assertIsArray( $result );
		$this->assertEquals( 'error', $result['status'] );
		$this->assertEquals( 'cf-turnstile-response', $result['field'] );
	}
}
