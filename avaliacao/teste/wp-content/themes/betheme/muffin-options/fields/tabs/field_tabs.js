jQuery(document).ready(function($){

	// sortable init
	$('.tabs-ul').hover(function(){
		$('.tabs-ul').sortable({ 
			cursor	: 'move',
			opacity	: 0.9
		});
	});
	
	
	// add
	$('.mfn-add-tab').click(function(){
		
		// increase tabs counter
		var tabs_counter = $(this).siblings('.mfn-tabs-count');
		tabs_counter.val(tabs_counter.val()*1 + 1);
		
		var name = $(this).attr('rel-name');
		var tabs_wrapper = $(this).siblings('.tabs-ul');
		var new_tab = tabs_wrapper.children('li.tabs-default').clone(true);

		new_tab.removeClass('tabs-default');	
		new_tab.children('input').attr('name',name+'[title][]');
		new_tab.children('textarea').attr('name',name+'[content][]');

		tabs_wrapper
			.append( new_tab )
			.children('li:last')
				.fadeIn(500);
		
	});
	
	// delete
	$('.mfn-remove-tab').click(function(e){
		e.preventDefault();
		
		// decrease tabs counter
		var tabs_counter = $(this).parents('td').children('.mfn-tabs-count');
		tabs_counter.val(tabs_counter.val()*1 - 1);
		
		$(this).parent().fadeOut(300, function(){$(this).remove();});
	});
	
});