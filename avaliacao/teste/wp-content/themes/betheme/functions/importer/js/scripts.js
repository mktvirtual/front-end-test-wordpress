(function($){
	
	"use strict";
	
	$(document).ready(function(){
		
		var importer	= $( '#mfn-wrapper.mfn-demo-data' );
		var overlay 	= $( '#mfn-overlay' );
		var popup 		= $( '#mfn-demo-popup' );

		
		/**
		 * Filters
		 * 
		 * Filter demos by Category
		 * 
		 * @param el object
		 */
		function filter( el ){
			
			var filter 	= el.attr( 'data-filter' );
			var demos	= $( '.demos', importer );
			
			$( '.demo-search input', importer ).val('');
			
			el.addClass( 'active' )
				.siblings().removeClass( 'active' );
			
			if( filter == '*' ){

				$( '.item', demos ).hide().stop(true,true).fadeIn();
				
			} else {

				$( '.item', demos ).hide();
				$( '.item.category-' + filter, demos ).stop( true, true ).fadeIn();

			}
		}
		
		$( '.filters', importer ).on( 'click', 'li', function(){
			filter( $(this) );
		});
		
		
		/**
		 * Search
		 *
		 * @param el object
		 */
		function search( el ){
			
			var filter 	= el.val().replace('&','').replace(/ /g,'').toLowerCase();
			var demos	= $( '.demos', importer );
			
			if( filter.length ){

				$( '.item', demos ).hide();
				$( '.item[data-id *= '+ filter +']', demos ).stop(true,true).fadeIn();

				$( '.filters li.active', importer ).removeClass('active');
				
			} else {
				
				$( '.item', demos ).hide().stop(true,true).fadeIn( 200 );
				
				$( '.filters li:first', importer ).addClass('active');
				
			}
			
		}
		
		$( '.demo-search input', importer ).bindWithDelay( 'keyup', function(){
			search( $(this) );
		}, 300);
		
		
		/**
		 * Item | Open
		 * 
		 * Open item details on click
		 */
		$( '.demos', importer ).on( 'click', '.item', function(e){

			overlay.fadeIn( 200 );
			
			$( this ).addClass( 'active' )
				.siblings().removeClass( 'active' );

			var el = $( '.item-inner', this );

			// scroll if active item is not fully visible
			
		    setTimeout( function(){
		    	
		    	var elT = el.offset().top;
			    var elB = el.offset().top + el.outerHeight();
			    
			    var scrT = $(window).scrollTop() + $( '#wpadminbar' ).height();
			    var scrB = $(window).scrollTop() + $(window).height();
		    	
		    	if( elT < scrT ){
		    		
		    		// offset top
		    		
		    		jQuery( 'html, body' ).animate({ 
		    			scrollTop: elT - $( '#wpadminbar' ).height() - 5
		    		}, 300);
		    		
		    	} else if( elB > scrB ) {
		    		
		    		// offset bottom
		    		
		    		var diff = elB - scrB;
		    		var scroll = scrT + diff + 5
		    		
		    		if( scroll > elT ){
		    			scroll = elT;
		    		}
		    		
		    		jQuery( 'html, body' ).animate({ 
		    			scrollTop: scroll - $( '#wpadminbar' ).height() -5
		    		}, 200);
		    		
		    	}
		    	
    		}, 400);

		});
		

		/**
		 * Item | Close
		 * 
		 * Close item detail on close button click
		 */
		$( '.demos', importer ).on( 'click', '.close', function(e){

			overlay.fadeOut( 200 );
			
			$( '.demos .item.active' ).removeClass( 'active' );
			
			e.stopPropagation();
		});

		
		/**
		 * Item | Import
		 * Popup | Open
		 * 
		 * Open import popup on import button click
		 */
		$( '.demos', importer ).on( 'click', '.mfn-button-import', function(e){
			
			var item = $( this ).closest( '.item' );

			$( '#input-demo', importer ).val( item.data( 'id' ) );
			
			$( '.item-image', popup ).css( 'background-position', item.find( '.item-image' ).css( 'background-position' ) );
			$( '.item-title', popup ).text( item.data( 'name' ) );

			// animations
			
			$( '.demos .item.active' ).removeClass( 'active' );
			e.stopPropagation();

			// reset to default
			
			$( '.popup-step', popup ).hide().first().show(); 
			
			$( '.popup-step.step-2 input', popup ).removeAttr( 'checked' )
			$( '.popup-step.step-2 input.checked', popup ).attr( 'checked', 'checked' );
			
			// open popup
			
			popup.addClass('active');	
		});	
		
		
		/**
		 * Popup | Close
		 * 
		 * Close popup on cakcel button click
		 */
		popup.on( 'click', '.mfn-button-cancel', function(){
			
			popup.removeClass( 'active' );
			overlay.fadeOut( 200 );
			
		});
		
				
		/**
		 * Popup | Next screen
		 * 
		 * Change step screen
		 */
		popup.on( 'click', '.mfn-button-next', function(){

			var step = $( this ).closest( '.popup-step' );
			step.hide().next().fadeIn(200);
			
		});

		
		/**
		 * Popup | Import Options
		 * 
		 * Activate checkboxes for selected radiobox, etc.
		 */
		$( '.import-options', popup ).on( 'click', 'label', function(){
			
			var parent = $( this ).closest( '.import-options' );

			parent.addClass( 'active' )
				.siblings().removeClass( 'active' );
			
			$( 'input.radio-type', parent ).attr( 'checked', 'checked' );
			
		});
		
		
		/**
		 * Popup | Submit
		 * 
		 * Submit form
		 */
		popup.on( 'click', '.mfn-button-submit', function(){
			
			var parent = $( this ).closest( '.popup-step' );

			var type = $( '.radio-type:checked', parent ).val();
			$( '#input-type', importer ).val( type );
			
			var data = $( '.radio-data:checked', parent ).val();
			$( '#input-data', importer ).val( data );
			
			var attachments = $( '.checkbox-attachments:checked', parent ).val();
			$( '#input-attachments', importer ).val( attachments );

			// next step
			$( this ).closest( '.popup-step' ).hide().next().fadeIn( 200 );
			
			// disable popup close
			overlay.unbind( 'click' );

			// form submit
			$( '#form-submit', importer ).click();
			
		});
		
		
		/**
		 * Item / Popup | Close
		 * 
		 * Close overlay, item details, popup on overlay click
		 */
		overlay.on( 'click', function(){
			
			$( this ).fadeOut( 200 );
			
			popup.removeClass( 'active' );
			$( '.demos .item.active' ).removeClass( 'active' );
			
		});
				
		
		/**
		 * Keyboard navigation
		 * 
		 * Previous / next item. Use keyboard left & right arrows
		 */
		$( 'body' ).keypress(function( event ) {
			if( $( '.item.active', importer ).length ){

				// <- arrow
				if( event.keyCode == 37 ){
					var prev = $( '.item.active', importer ).prev();
					if( prev.length ){
						$( '.item.active', importer ).removeClass( 'active' );
						prev.addClass( 'active' );
					}	
				}
				
				// -> arrow
				if( event.keyCode == 39 ){
					var next = $( '.item.active', importer ).next();
					if( next.length ){
						$( '.item.active', importer ).removeClass( 'active' );
						next.addClass( 'active' );
					}	
				}
				
			}

		});

		
	});

})(jQuery);


/**
 * bindWithDelay jQuery plugin
 * 
 * Brian Grinstead | http://github.com/bgrins/bindWithDelay | http://briangrinstead.com/files/bindWithDelay | MIT license
 */
!function(i){i.fn.bindWithDelay=function(n,u,t,e,d){return i.isFunction(u)&&(d=e,e=t,t=u,u=void 0),t.guid=t.guid||i.guid&&i.guid++,this.each(function(){function l(){var n=i.extend(!0,{},arguments[0]),u=this,l=function(){o=null,t.apply(u,[n])};d||(clearTimeout(o),o=null),o||(o=setTimeout(l,e))}var o=null;l.guid=t.guid,i(this).bind(n,u,l)})}}(jQuery);
