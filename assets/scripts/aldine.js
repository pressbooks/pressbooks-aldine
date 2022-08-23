// import local dependencies
import catalog from './routes/catalog';
import common from './routes/common';
import home from './routes/home';
import Router from './util/Router';

/** Populate Router instance with DOM routes */
const routes = new Router( {
	// All pages
	common,
	// Home page
	home,
	// Catalog page
	pageTemplatePageCatalog: catalog,
} );

// Load Events
jQuery( document ).ready( () => routes.loadEvents() );
