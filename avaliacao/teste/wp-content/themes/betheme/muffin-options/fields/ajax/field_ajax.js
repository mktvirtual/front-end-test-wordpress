jQuery(document).ready(function($){
	
	jQuery('.mfn-opts-ajax').click(function(e){
		e.preventDefault();
		
		if( confirm( "Are you sure you want to do this?\nIt can not be restored at a later time! Continue?" ) ){
			
			var el = $(this);
			var ajax 	= el.attr('data-ajax');
			var action 	= el.attr('data-action');
			var param 	= el.attr('data-param');
	
			var post = {
				action		: 'mfn_love_randomize',
				post_type	: param
			};
			
			$.post(ajax, post, function(data){
				el.text(data);
			});
		
		} else {
	    	return false;
	    }

	});
	
});