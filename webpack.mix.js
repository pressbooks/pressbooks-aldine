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
const views = 'views';
const assets = 'assets';
const dist = 'dist';

mix.setPublicPath( dist );
mix.setResourceRoot( '../' );

// BrowserSync
mix.browserSync( {
	host:  'localhost',
	proxy: 'https://pressbooks.test',
	port:  3000,
	files: [
		'*.php',
		`${inc}/**/*.php`,
		`${views}/**/*.php`,
		`${dist}/**/*.css`,
		`${dist}/**/*.js`,
	],
} );

// Sass
mix.sass( `${assets}/styles/aldine.scss`, `${dist}/styles/aldine.css` );

// Javascript
mix.autoload( { jquery: [ '$', 'window.jQuery', 'jQuery' ] } );

mix
	.js( `${assets}/scripts/aldine.js`, `${dist}/scripts` )
	.js( `${assets}/scripts/customizer.js`, `${dist}/scripts` );

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
} );
