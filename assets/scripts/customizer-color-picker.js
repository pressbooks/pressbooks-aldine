import '../styles/customizer-color-picker.scss';
import Coloris from '@melloware/coloris';
import '@melloware/coloris/dist/coloris.css';

const colorPickerOptions = {
	el: '.coloris',
	alpha: false,
};

if ( window.PB_Aldine_ColorPicker && window.PB_Aldine_ColorPicker.a11y ) {
	colorPickerOptions.a11y = window.PB_Aldine_ColorPicker.a11y;
}

Coloris.init();

Coloris( colorPickerOptions );

const customizeControls = document.getElementById( 'customize-controls' );

if ( customizeControls ) {
	/**
	 * Labels each Coloris swatch button with its Customizer control title.
	 */
	const labelSwatchButtons = () => {
		customizeControls.querySelectorAll( '.clr-field > button' ).forEach( button => {
			const control = button.closest( '.customize-control' );
			const title = control ? control.querySelector( '.customize-control-title' ) : null;

			if ( title ) {
				button.removeAttribute( 'aria-labelledby' );
				button.setAttribute( 'aria-label', title.textContent.trim() );
			}
		} );
	};

	/**
	 * Wraps dynamically rendered Coloris fields, then labels their swatch buttons.
	 */
	const bindColorisFields = () => {
		Coloris.wrap( '.coloris' );
		labelSwatchButtons();
	};

	new MutationObserver( bindColorisFields ).observe( customizeControls, {
		childList: true,
		subtree: true,
	} );

	bindColorisFields();
}
