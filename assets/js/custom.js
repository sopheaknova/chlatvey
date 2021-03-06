/*
 * custom.js
 * Custom JS code required by the theme.
 */

jQuery( function($) {

	// Remove no-js class on page load
	$( 'html' ).removeClass( 'no-js' ).addClass( 'js-enabled' );

} );


// document.ready call
jQuery( document ).ready( function($) {

	
	// Navigation drop down effect
	
	$( '.nav-menu ul, .sec-menu ul' ).css( { display: "none" } );
	function showMenu(){
		$( this ).find( 'ul:first' ).css( { visibility: "visible", display: "none" } ).slideDown( 300 );
	};
	function hideMenu(){
		$( this ).find( 'ul:first' ).css( { visibility: "visible", display: "none" } );
	};
	var config = {
		over	: showMenu,
		timeout	: 10,
		out		: hideMenu
	};
	$( '.nav-menu li, .sec-menu li' ).hoverIntent( config );

	
	// Responsive select drop-down for navigation
	
	$( '<div />' ).attr( 'class', 'menu-drop' ).append( '<select />' ).appendTo( '#main-nav .wrap' );

	$( '<option />', {
	   'selected': 'selected',
	   'value'   : '',
	   'text'    : '- Select -'
	} ).appendTo( '#main-nav select' );

	if ( $( '#main-nav' ).html() )
		$( '<optgroup label="Navigation" />' ).appendTo( '#main-nav select' );

	if ( $( '#optional-nav' ).html() )
		$( '<optgroup label="Links" />' ).appendTo( '#main-nav select' );

	$( '.nav-menu a' ).each( function() {
		var depth = $( this ).parents( 'ul' ).length - 1;
		str = $( this ).text();
		indent = new Array( ++depth ).join( '-- ' );
		 var el = $( this );
		 $( '<option />', {
			 'value'   : el.attr( 'href' ),
			 'text'    : indent + str
		 } ).appendTo( '#main-nav optgroup[label^="Navigation"]' );
	} );

	$( '.sec-menu a' ).each( function() {
		var depth = $( this ).parents( 'ul' ).length - 1;
		str = $( this ).text();
		indent = new Array( ++depth ).join( '-- ' );
		 var el = $( this );
		 $( '<option />', {
			 'value'   : el.attr( 'href' ),
			 'text'    : indent + str
		 } ).appendTo( '#main-nav optgroup[label^="Links"]' );
	} );

	$( '#main-nav select' ).change( function() {
	  window.location = $( this ).find( 'option:selected' ).val();
	} );
	
	// Scroll to top button
	$( '.scroll-to-top' ).hide();
	$( window ).scroll( function () {
		if ( $( this ).scrollTop() > 100 ) {
			$( '.scroll-to-top' ).fadeIn( 300 );
		}
		else {
			$( '.scroll-to-top' ).fadeOut( 300 );
		}
	} );
	
	$( '.scroll-to-top a' ).click( function() {
		$( 'html, body' ).animate( { scrollTop:0 }, 500 );
		return false;
	} );

	// Single post slideshow with Flexslider
	$('.flexslider').flexslider();																														  
} )

