# Validate WCAG Color Contrast for Customizer Color Control

The validator measures the color contrast between 2 or more color controls. It will post a warning if the contrast is less than 4.5

BTW, if the contrast >= 7,  the score is a WCAG AAA. If the contrast is between 7 and 4.5 the score is a WCAG AA.

<img src="assets/wcag-color-contrast.gif" width="650" />

## Demo

I've added this validator to my [customizer demo theme](https://github.com/soderlind/2016-customizer-demo).

## Installing the validator

Clone this repository and include the [javascript code](customizer-validate-wcag-color-contrast.js):

```php
/**
 * Enqueue customizer control scripts.
 */
add_action( 'customize_controls_enqueue_scripts', 'on_customize_controls_enqueue_scripts' );

function on_customize_controls_enqueue_scripts() {
	$handle = 'wcag-validate-customizer-color-contrast';
	$src    = get_stylesheet_directory_uri() . '/js/customizer-validate-wcag-color-contrast.js';
	$deps   = [ 'customize-controls' ];
	wp_enqueue_script( $handle, $src, $deps );

	$exports = [
		'validate_color_contrast' => [
			// key = current color control , values = array with color controls to check color contrast against
			'page_background_color' => [ 'main_text_color', 'secondary_text_color' ],
			'main_text_color'       => [ 'page_background_color' ],
			'secondary_text_color'  => [ 'page_background_color' ],
		],
	];
	wp_scripts()->add_data( $handle, 'data', sprintf( 'var _validateWCAGColorContrastExports = %s;', wp_json_encode( $exports ) ) );
}
```

**Note:** You have to add color control setting ids to the `validate_color_contrast` above. See inline comment.

## Credits ##

- [WCAG contrast ratio measurement and scoring](https://github.com/tmcw/wcag-contrast) - Copyright (c) 2017, Tom MacWright. All rights reserved.
- [hex-rgb](https://github.com/sindresorhus/hex-rgb) - Copyright (c) Sindre Sorhus
- [relative-luminance](https://github.com/tmcw/relative-luminance)



## Copyright and License

The Validate WCAG Color Contrast for Customizer Color Control is copyright 2017 Per Soderlind

The Validate WCAG Color Contrast for Customizer Color Control is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any later version.

The Validate WCAG Color Contrast for Customizer Color Control is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU Lesser General Public License along with the Extension. If not, see http://www.gnu.org/licenses/.
