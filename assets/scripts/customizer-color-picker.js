import Coloris from '@melloware/coloris';
import '@melloware/coloris/dist/coloris.css';

const colorPickerOptions = {
	el: '.coloris',
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

	new MutationObserver( labelSwatchButtons ).observe( customizeControls, {
		childList: true,
		subtree: true,
	} );

	labelSwatchButtons();
}
