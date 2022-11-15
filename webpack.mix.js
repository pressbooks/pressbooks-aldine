let mix = require( 'laravel-mix' );

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

const inc = 'inc';
const partials = 'partials';
const assets = 'assets';
const dist = 'dist';

mix.setPublicPath( dist );
mix.setResourceRoot( '../' );

// BrowserSync
mix.browserSync( {
	host: 'localhost',
	proxy: 'https://pressbooks.test',
	port: 3100,
	files: [
		'*.php',
		`${inc}/**/*.php`,
		`${partials}/**/*.php`,
		`${dist}/**/*.css`,
		`${dist}/**/*.js`,
	],
} );

// Sass
mix.sass( `${assets}/styles/aldine.scss`, `${dist}/styles/aldine.css` );
mix.sass( `${assets}/styles/editor.scss`, `${dist}/styles/editor.css` );

// Javascript
mix.autoload( { jquery: [ '$', 'window.jQuery', 'jQuery' ] } );

mix
	.js( `${assets}/scripts/aldine.js`, `${dist}/scripts` )
	.js( `${assets}/scripts/call-to-action.js`, `${dist}/scripts` )
	.js( `${assets}/scripts/catalog-admin.js`, `${dist}/scripts` )
	.js( `${assets}/scripts/customizer.js`, `${dist}/scripts` )
	.js( `${assets}/scripts/customizer-toggle.js`, `${dist}/scripts` )
	.js( `${assets}/scripts/page-section.js`, `${dist}/scripts` );

// Assets
mix
	.copy( `${assets}/fonts`, `${dist}/fonts`, false )
	.copy( `${assets}/images`, `${dist}/images`, false );

// Options
mix.options( { processCssUrls: false } );

// Source maps when not in production.
if ( ! mix.inProduction() ) {
	mix.sourceMaps();
}

// Hash and version files in production.
if ( mix.inProduction() ) {
	mix.version();
}

// Add Isotope support.
mix.webpackConfig( {
	resolve: {
		alias: {
			masonry: 'masonry-layout',
			isotope: 'isotope-layout',
		},
	},
	stats: {
		children: true
	}
} );
