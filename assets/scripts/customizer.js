import $ from 'jquery';

wp.customize( 'blogname', value => {
	value.bind( to => $( '.brand a' ).text( to ) );
} );
