<?php

use function Aldine\Helpers\handle_contact_form_submission;

class ContactFormTest extends WP_UnitTestCase {

	public function test_validation_filter_can_block_submission() {
		$wp_mail_called = false;
		add_filter( 'pre_wp_mail', function () use ( &$wp_mail_called ) {
			$wp_mail_called = true;
			return false;
		} );

		add_filter( 'pressbooks_aldine_contact_form_submission_valid', '__return_false' );

		$_POST['pb_root_contact_form_nonce'] = wp_create_nonce( 'pb_root_contact_form' );
		$_POST['submitted'] = '1';
		$_POST['visitor_name'] = 'John Doe';
		$_POST['visitor_email'] = 'john@example.com';
		$_POST['visitor_institution'] = 'Test University';
		$_POST['message'] = 'Test message';

		$result = handle_contact_form_submission();

		$this->assertIsArray( $result );
		$this->assertEquals( 'error', $result['status'] );
		$this->assertFalse( $wp_mail_called, 'wp_mail should not be called when validation filter blocks submission' );
	}

	public function test_contact_form_succeeds_without_plugin_block() {
		add_filter( 'pre_wp_mail', '__return_true' );

		$_POST['pb_root_contact_form_nonce'] = wp_create_nonce( 'pb_root_contact_form' );
		$_POST['submitted'] = '1';
		$_POST['visitor_name'] = 'Jane Doe';
		$_POST['visitor_email'] = 'jane@example.com';
		$_POST['visitor_institution'] = 'Test College';
		$_POST['message'] = 'Hello, this is a test.';

		$result = handle_contact_form_submission();

		$this->assertIsArray( $result );
		$this->assertEquals( 'success', $result['status'] );
	}

	public function test_before_submit_action_outputs_content() {
		add_action( 'pressbooks_aldine_contact_form_before_submit', function () {
			echo '<div class="my-captcha">My CAPTCHA</div>';
		} );

		ob_start();
		do_action( 'pressbooks_aldine_contact_form_before_submit' );
		$output = ob_get_clean();

		$this->assertStringContainsString( 'my-captcha', $output );
		$this->assertStringContainsString( 'My CAPTCHA', $output );
	}
}
