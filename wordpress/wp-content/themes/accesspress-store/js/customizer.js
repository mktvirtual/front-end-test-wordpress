/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title' ).text( to );
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
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );
	    //Breadcrumbs us background image
	    wp.customize( 'breadcrumb_archive_image', function( value ) {
		    value.bind( function( to ) {
		    	$('.entry-header').css('background-image', 'url(' + to + ')' );
		    } );
	    } );

	    wp.customize( 'breadcrumb_single_image', function( value ) {
		    value.bind( function( to ) {
		    	$('.entry-header').css('background-image', 'url(' + to + ')' );
		    } );
	    } );

	    wp.customize( 'breadcrumb_page_image', function( value ) {
		    value.bind( function( to ) {
		    	$('.page_header_wrap').css('background-image', 'url(' + to + ')' );
		    } );
	    } );

	    wp.customize( 'breadcrumb_post_image', function( value ) {
		    value.bind( function( to ) {
		    	$('.page_header_wrap').css('background-image', 'url(' + to + ')' );
		    } );
	    } );

} )( jQuery );