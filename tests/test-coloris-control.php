<?php

use Aldine\Customizer\ColorisControl;

class ColorisControlTest extends WP_UnitTestCase {

	/**
	 * Build a Customizer manager with core settings/controls registered.
	 *
	 * @return WP_Customize_Manager
	 */
	private function make_customize_manager() {
		require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';

		$wp_customize = new WP_Customize_Manager();
		$wp_customize->register_controls();

		return $wp_customize;
	}

	public function test_render_content_outputs_coloris_input() {
		$wp_customize = $this->make_customize_manager();
		$wp_customize->add_setting(
			'pb_network_color_primary', [
				'type' => 'option',
				'default' => '#b01109',
			]
		);

		$control = new ColorisControl(
			$wp_customize,
			'pb_network_color_primary',
			[
				'label' => 'Primary Color',
				'section' => 'colors',
				'settings' => 'pb_network_color_primary',
			]
		);

		ob_start();
		$control->render_content();
		$html = ob_get_clean();

		$this->assertSame( 'coloris', $control->type );
		$this->assertStringContainsString( 'class="coloris"', $html );
		$this->assertStringContainsString( 'type="text"', $html );
		$this->assertStringContainsString( 'value="#b01109"', $html );
		$this->assertStringContainsString( 'data-customize-setting-link="pb_network_color_primary"', $html );
	}
}
