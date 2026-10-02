<?php
/**
 * Coloris Color Control
 *
 * @package Aldine
 */

namespace Aldine\Customizer;

/**
 * Customizer control backed by the Coloris color picker.
 */
class ColorisControl extends \WP_Customize_Control {

	/**
	 * The type of control being rendered.
	 *
	 * @var string
	 */
	public $type = 'coloris';

	/**
	 * Render the control's content.
	 *
	 * @return void
	 */
	public function render_content(): void { // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		$input_id = '_customize-input-' . $this->id;
		?>
		<?php if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>
		<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
		<?php endif; ?>
		<div class="customize-control-content">
			<label for="<?php echo esc_attr( $input_id ); ?>">
				<span class="screen-reader-text"><?php echo esc_html( $this->label ); ?></span>
			</label>
			<input
				id="<?php echo esc_attr( $input_id ); ?>"
				class="coloris"
				type="text"
				maxlength="7"
				value="<?php echo esc_attr( $this->value() ); ?>"
				data-default-color="<?php echo esc_attr( $this->setting->default ); ?>"
				<?php $this->link(); ?>
			/>
		</div>
		<?php
	}
}
