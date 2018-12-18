wp.customize( 'blogname', value => {
	value.bind( to => document.querySelector( '.home .entry-title' ).textContent = to );
} );

wp.customize( 'blogdescription', value => {
	value.bind( to => document.querySelector( '.home .entry-description' ).textContent = to );
} );
