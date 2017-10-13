jQuery(document).ready(function($){
	
	jQuery('.mfn-radio-img').click(function(e){
		
		var el 			= $(this);
		var fieldset 	= $(this).closest('fieldset');
		
		fieldset.find('.mfn-radio-img').removeClass('mfn-radio-img-selected');
		el.addClass('mfn-radio-img-selected');
		
		el.find('input[type="radio"]').attr('checked','checked');

	});
	
});