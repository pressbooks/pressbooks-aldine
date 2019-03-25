let mix = require( 'laravel-mix' );
let path = require( 'path' );
let normalizeNewline = require( 'normalize-newline' );
let fs = require( 'fs' );

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


// Normalize Newlines
const normalizeNewlines = ( dir ) => {
	fs.readdirSync( dir ).forEach( function( file ) {
		file = path.join( dir, file );
		fs.readFile( file, 'utf8', function( err, buffer ) {
			if ( err ) return console.log( err );
			buffer = normalizeNewline( buffer );
			fs.writeFile( file, buffer, 'utf8', function( err ) {
				if ( err ) return console.log( err );
			} );
		} );
	} );
};

// BrowserSync
mix.browserSync( {
	host:  'localhost',
	proxy: 'https://pressbooks.test',
	port:  3100,
	files: [
		'*.php',
		`${inc}/**/*.php`,
		`${partials}/**/*.php`,
		`${dist}/**/*.css`,
		`${dist}/**/*.js`,
	],
} );

mix
	.setPublicPath( dist )
	.setResourceRoot( '../' )
	.sass( `${assets}/styles/aldine.scss`, `${dist}/styles/aldine.css` )
	.sass( `${assets}/styles/editor.scss`, `${dist}/styles/editor.css` )
	.autoload( { jquery: [ '$', 'window.jQuery', 'jQuery' ] } )
	.js( `${assets}/scripts/aldine.js`, `${dist}/scripts` )
	.js( `${assets}/scripts/call-to-action.js`, `${dist}/scripts` )
	.js( `${assets}/scripts/catalog-admin.js`, `${dist}/scripts` )
	.js( `${assets}/scripts/customizer.js`, `${dist}/scripts` )
	.js( `${assets}/scripts/page-section.js`, `${dist}/scripts` )
	.copy( `${assets}/fonts`, `${dist}/fonts`, false )
	.copy( `${assets}/images`, `${dist}/images`, false )
	.options( { processCssUrls: false } )
	.then( () => {
		normalizeNewlines( `${dist}/scripts/` );
		normalizeNewlines( `${dist}/styles/` );
	} );

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
