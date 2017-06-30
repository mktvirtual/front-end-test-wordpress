jQuery(document).ready( function($){
	
		$( '.bsm-pro-notification' ).on( 'click', function(){
			$.ajax({
				url: bsm_admin_localized.admin_ajax_url,
				data: {
					action: 'bsm_portfolio_dismiss_pro_notice'
				},
				success: function( data ){
				}
			});
		});

    var custom_uploader;

    $('#upload_image_button').live( 'click', function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            //attachment = custom_uploader.state().get('selection').first().toJSON();
			custom_uploader.state().get('selection').each( function( data ){
				
				$('#bsm-images-container').append('<li class="bsm-image-container"> \
					<img src="' + data.toJSON().url + '" class="bsm-image bsm-thumbnail" /> \
					<input type="hidden" name="bsm-image-id[]" value="' + data.toJSON().id + '" />\
					<label class="bsm-image-title">' + data.toJSON().title + '</label> \
					<img src="' + bsm_admin_localized.plugin_admin_url + 'assets/drag-icon.png" class="bsm-image-move" title="move" alt="Drag and Drop to Move" />\
					<img src="' + bsm_admin_localized.plugin_admin_url + 'assets/remove-icon.png" class="bsm-image-remove" title="remove" alt="Click to remove image" />\
				</li>');
			} );
			$('p.bsm-warning').css('display','block');
        });
 
        //Open the uploader dialog
        custom_uploader.open();

    });
	$('img.bsm-image-remove').live('click', function (e){
		$(this).parent('li').remove();
		$('p.bsm-warning').css('display','block');
	});
	$( "#bsm-images-container" ).sortable();
	$( "#bsm-images-container" ).on( 'sortupdate', function( event, ui){
		$('p.bsm-warning').css('display','block');
	});
	
	$( "#bsm-images-container" ).disableSelection();
 
});