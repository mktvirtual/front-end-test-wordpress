jQuery(document).ready(function($){
	
	$('.mfn-icon-select .mfn-icon').click(function(){
		
		var field = $(this).closest('.mfn-icon-field');
		var input = field.find('.mfn-icon-input');
		
		var icon = $(this).attr('data-rel');
		
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		input.val( icon );			
			
	});
	
});