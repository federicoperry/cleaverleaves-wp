/**
 * Mediac Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Customizer preview reload changes asynchronously.
 */
( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title,  .site-description' ).css( {
					'clip': 'auto',
					'position': 'static'
				} );

				$( '.site-title a' ).css( {
					'color': to
				} );
			}
		} );
	} );


	//Update site link color in real time...
	wp.customize( 'page_bg', function( value ) {
		value.bind( function( newval ) {
			$('#page').css('background-color', newval );
		} );
	} );


	//Update site link color in real time...
	wp.customize( 'body_text_color', function( value ) {
		value.bind( function( newval ) {
			$('body').css('color', newval );
		} );
	} );



	//Update site link color in real time...
	wp.customize( 'topbar_bg', function( value ) {
		value.bind( function( newval ) {
			$('#opal-topbar').css('background-color', newval );
		} );
	} );

	//Update site link color in real time...
	wp.customize( 'topbar_color', function( value ) {
		value.bind( function( newval ) {
			$('#opal-topbar, #opal-topbar a, #opal-topbar span').css('color', newval );
		} );
	} );



	//Update site link color in real time...
	wp.customize( 'footer_bg', function( value ) {
		value.bind( function( newval ) {
			$('#opal-footer').css('background-color', newval );
		} );
	} );

	//Update site link color in real time...
	wp.customize( 'footer_color', function( value ) {
		value.bind( function( newval ) {
			$('#opal-footer, #opal-footer a').css('color', newval );
		} );
	} );

	//Update site link color in real time...
	wp.customize( 'footer_heading_color', function( value ) {
		value.bind( function( newval ) {
			$('#opal-footer h2, #opal-footer h3, #opal-footer h4').css('color', newval );
		} );
	} );
} )( jQuery );