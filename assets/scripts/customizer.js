import $ from 'jquery';

wp.customize( 'blogname', value => {
	value.bind( to => $( '.home .entry-title' ).text( to ) );
} );

wp.customize( 'blogdescription', value => {
	value.bind( to => $( '.home .entry-description' ).text( to ) );
} );
