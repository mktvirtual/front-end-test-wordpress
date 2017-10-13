function MfnOptions(){
			
	// show 1st at start	
	if( jQuery('#last_tab').val() == 0 ){
		this.tabid = jQuery('.mfn-submenu-a:first').attr('data-rel');
	} else {
		this.tabid = jQuery('#last_tab').val();
	}

	jQuery('#'+this.tabid+'-mfn-section').show();
	jQuery('#'+this.tabid+'-mfn-submenu-li').addClass('active').parent('ul').show().parent('li').addClass('active');
	
	// parent manu click - show childrens and select 1st
	jQuery('.mfn-menu-a').click(function(){
		
		if( ! jQuery(this).parent().hasClass('active') ) {
			
			jQuery('.mfn-menu-li').removeClass('active');
			jQuery('.mfn-submenu').slideUp('fast');
			
			jQuery(this).next('ul').stop().slideDown('fast');
			jQuery(this).parent('li').addClass('active');
			
			jQuery('.mfn-submenu-li').removeClass('active');
			jQuery('.mfn-section').hide();
			
			this.tabid = jQuery(this).next('ul').children('li:first').addClass('active').children('a').attr('data-rel');
			jQuery('#'+this.tabid+'-mfn-section').stop().fadeIn(1200);
			jQuery('#last_tab').val(this.tabid);
		}
		
	});
	
	// submenu click
	jQuery('.mfn-submenu-a').click(function(){
		
		if( ! jQuery(this).parent().hasClass('active') ) {

			jQuery('.mfn-submenu-li').removeClass('active');
			jQuery(this).parent('li').addClass('active');
			
			jQuery('.mfn-section').hide();
			
			this.tabid = jQuery(this).attr('data-rel');
			jQuery('#'+this.tabid+'-mfn-section').stop().fadeIn(1200);
			jQuery('#last_tab').val(this.tabid);
		}
		
	});
	
	// last w menu
	jQuery('.mfn-submenu .mfn-submenu-li:last-child').addClass('last');

	
	// reset
	jQuery( '.reset-pre-confirm' ).click( function(){
		jQuery( this ).closest( '.step-1' ).hide().next().fadeIn( 200 );
	});
	
	jQuery( '.mfn-popup-reset' ).click(function(){
		
		if( jQuery( '.reset-security-code' ).val() != 'r3s3t' ){
			alert( 'Please insert correct security code: r3s3t' );
			return false;
		}
		
		if( confirm( "Are you sure?\n\nClicking this button will reset all custom values across your entire Theme Options panel" ) ){
			jQuery( this ).val( 'Resetting...' );
			return true;
	    } else {
	    	return false;
	    }
	});
	
	
	// import code button
	jQuery('.mfn-import-imp-code-btn').click(function(){
		jQuery('.mfn-import-imp-link-wrapper').hide();
		jQuery('.mfn-import-imp-code-wrapper').stop().fadeIn(500);
	});
	
	// import link button
	jQuery('.mfn-import-imp-link-btn').click(function(){
		jQuery('.mfn-import-imp-code-wrapper').hide();
		jQuery('.mfn-import-imp-link-wrapper').stop().fadeIn(500);
	});
	
	// export code button
	jQuery('.mfn-import-exp-code-btn').click(function(){
		jQuery('.mfn-import-exp-link').hide();
		jQuery('.mfn-import-exp-code').stop().fadeIn(500);
	});
	
	// export link button
	jQuery('.mfn-import-exp-link-btn').click(function(){
		jQuery('.mfn-import-exp-code').hide();
		jQuery('.mfn-import-exp-link').stop().fadeIn(500);
	});
	
}
	
jQuery(document).ready(function(){
	new MfnOptions();
});