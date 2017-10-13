function MfnUpload(){
	(function($) {

		jQuery( 'img[src=""]' ).attr( 'src', mfn_upload.url );

		jQuery( '.mfn-opts-upload' ).click( function( event ) {   
        	event.preventDefault();
        	
        	var activeFileUploadContext = jQuery( this ).parent();
        	var type = jQuery( 'input', activeFileUploadContext ).attr( 'class' );
        	
        	custom_file_frame = null;

            // Create the media frame.
            custom_file_frame = wp.media.frames.customHeader = wp.media({
            	title: jQuery(this).data( 'choose' ),
            	library: {
            		type: type
            	},
                button: {
                    text: jQuery(this).data( 'update' )
                }
            });

            custom_file_frame.on( "select", function() {
            	var attachment = custom_file_frame.state().get( "selection" ).first();

                // Update value of the targetfield input with the attachment url.
                jQuery( '.mfn-opts-screenshot', activeFileUploadContext ).attr( 'src', attachment.attributes.url );
                jQuery( 'input', activeFileUploadContext )
            		.val( attachment.attributes.url )
            		.trigger( 'change' );

                jQuery( '.mfn-opts-upload', activeFileUploadContext ).hide();
                jQuery( '.mfn-opts-screenshot', activeFileUploadContext ).show();
                jQuery( '.mfn-opts-upload-remove', activeFileUploadContext ).show();
            });

            custom_file_frame.open();
        });

	    jQuery( '.mfn-opts-upload-remove' ).click( function( event ) {
	    	event.preventDefault();
	    	
	        var activeFileUploadContext = jQuery( this ).parent();
	
	        jQuery( 'input', activeFileUploadContext ).val('');
	        jQuery( this ).prev().fadeIn( 'slow' );
	        jQuery( '.mfn-opts-screenshot', activeFileUploadContext ).fadeOut( 'slow' );
	        jQuery( this ).fadeOut( 'slow' );
	    });

	})(jQuery);
}
	
jQuery(document).ready(function($){
	var mfn_upload = new MfnUpload();
});
