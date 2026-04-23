import { createWpViteConfig } from 'pressbooks-build-tools';
import { resolve } from 'path';
import { viteStaticCopy } from 'vite-plugin-static-copy';

export default createWpViteConfig({
	input: {
		// Styles
		'styles/aldine': resolve(__dirname, 'assets/styles/aldine.scss'), // Standalone for aldine/style handle (backward compat)
		'styles/editor': resolve(__dirname, 'assets/styles/editor.scss'), // Standalone for add_editor_style()
		// Scripts (aldine.scss is also imported in aldine.js for bundling, search-featured-books.scss is imported in its JS file)
		'scripts/aldine': resolve(__dirname, 'assets/scripts/aldine.js'),
		'scripts/call-to-action': resolve(__dirname, 'assets/scripts/call-to-action.js'),
		'scripts/catalog-admin': resolve(__dirname, 'assets/scripts/catalog-admin.js'),
		'scripts/customizer': resolve(__dirname, 'assets/scripts/customizer.js'),
		'scripts/customizer-toggle': resolve(__dirname, 'assets/scripts/customizer-toggle.js'),
		'scripts/page-section': resolve(__dirname, 'assets/scripts/page-section.js'),
		'scripts/search-featured-books': resolve(__dirname, 'assets/scripts/search-featured-books.js'),
		'scripts/featured-books': resolve(__dirname, 'assets/scripts/featured-books.js'),
	},
	outDir: 'assets/dist',
	resolve: {
		alias: {
			masonry: 'masonry-layout',
			isotope: 'isotope-layout',
		},
	},
	css: {
		preprocessorOptions: {
			scss: {
				loadPaths: [resolve(__dirname, 'node_modules')],
			},
		},
	},
	plugins: [
		viteStaticCopy({
			targets: [
				{ src: 'assets/fonts/*', dest: 'fonts' },
				{ src: 'assets/images/*', dest: 'images' },
			],
		}),
	],
});
