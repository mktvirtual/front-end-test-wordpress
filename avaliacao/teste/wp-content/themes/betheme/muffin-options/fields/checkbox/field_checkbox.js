jQuery(document).ready(function(){
	
	// delete
	jQuery('.multi-text-remove').click(function(e){
		e.preventDefault();
		jQuery(this).prev('input[type="text"]').val('');
		jQuery(this).parent().fadeOut(300, function(){jQuery(this).remove();});
	});
	
	// add
	jQuery('.multi-text-btn').click(function(){
		var new_input = jQuery('#'+jQuery(this).attr('rel-id')+' li.multi-text-default').clone(true);
		var new_input_val = jQuery(this).siblings('.multi-text-add').val();
		
		if( new_input_val ){
			jQuery(this).prev('input[type="text"]').val('');
			jQuery('#'+jQuery(this).attr('rel-id')).append( new_input );
			jQuery('#'+jQuery(this).attr('rel-id')+' li:last-child')
				.fadeIn(500)
				.removeClass('multi-text-default')
				.children('input')
					.val(new_input_val)
					.attr('name', jQuery(this).attr('rel-name'))
				.parent().children('span')
					.text(new_input_val);
		}
		
	});
	
});