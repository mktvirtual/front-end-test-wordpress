jQuery(document).ready(function($)
	{





		$(document).on('click', '#post_grid_metabox .slider_navs_style', function()
			{
				//alert('Hello');
				
				var val = $(this).val();
				nav = $('.slider-navs');

				if(nav.hasClass(val)){
					$('.slider-navs').removeClass(val);
							
					}
				else{

					$('.slider-navs').removeClass('round');
					$('.slider-navs').removeClass('round-border');					
					$('.slider-navs').removeClass('semi-round');					
					$('.slider-navs').removeClass('square');	
					$('.slider-navs').removeClass('square-border');	
					$('.slider-navs').removeClass('square-shadow');									
					
													
					$('.slider-navs').addClass(val);

					}	

			})








		$(document).on('click', '#post_grid_metabox .slider_dots_style', function()
			{

				var val = $(this).val();
				nav = $('.slider-dots');

				if(nav.hasClass(val)){
					$('.slider-dots').removeClass(val);
							
					}
				else{

					$('.slider-dots').removeClass('round');
					$('.slider-dots').removeClass('round-border');					
					$('.slider-dots').removeClass('semi-round');					
					$('.slider-dots').removeClass('square');					
					$('.slider-dots').removeClass('square-border');	
					$('.slider-dots').removeClass('square-shadow');						
					
	
									
					$('.slider-dots').addClass(val);

					}	

			})



		$(document).on('click', '#post_grid_metabox .slider_navs_positon', function()
			{

				var val = $(this).val();
				nav = $('.slider-navs');

				if(nav.hasClass(val)){
					$('.slider-navs').removeClass(val);
							
					}
				else{

					$('.slider-navs').removeClass('top-left');
					$('.slider-navs').removeClass('top-right');
					$('.slider-navs').removeClass('middle');
					$('.slider-navs').removeClass('bottom-left');	
					$('.slider-navs').removeClass('bottom-right');
					
					$('.slider-navs').addClass(val);

					}	

			})






		$(document).on('click', '#post_grid_metabox .nav_top_search', function()
			{
				//alert('Hello');
				
				var grid_type = $(this).val();
			
				if(grid_type=='yes'){
					
					$('.nav-top-search').fadeIn();
					}
				else{
					$('.nav-top-search').fadeOut();
					}
				
				//$('.slider-navs').css('display','none');				

			})



		$(document).on('click', '#post_grid_metabox .per_page_count', function()
			{
				//alert('Hello');
				
				var grid_type = $(this).val();
			
				if(grid_type=='yes'){
					
					$('.per-page-count').fadeIn();
					}
				else{
					$('.per-page-count').fadeOut();
					}
				
				//$('.slider-navs').css('display','none');				

			})








		$(document).on('click', '#post_grid_metabox .slider_navs', function()
			{
				//alert('Hello');
				
				var grid_type = $(this).val();
			
				if(grid_type=='true'){
					
					$('.slider-navs').fadeIn();
					}
				else{
					$('.slider-navs').fadeOut();
					}
				
				//$('.slider-navs').css('display','none');				

			})
			
			
			
			
		$(document).on('click', '#post_grid_metabox .slider_dots', function()
			{
				//alert('Hello');
				
				var grid_type = $(this).val();
			
				if(grid_type=='true'){
					
					$('.slider-dots').fadeIn();
					}
				else{
					$('.slider-dots').fadeOut();
					}
				
				//$('.slider-navs').css('display','none');				
				
				
				
			})
						
			
			
			
			
			



		$(document).on('click', '#post_grid_metabox .grid_type', function()
			{
			
				var grid_type = $(this).val();
			
				
				$('.grid-type').css('display','none');				
				$('.grid-type-'+grid_type).fadeIn();
				
				
			})



		$(document).on('click', '#post_grid_metabox .pagination_type', function()
			{
			
				var pagination_type = $(this).val();
			
				
				$('.pagination-type').css('display','none');				
				$('.pagination-'+pagination_type).fadeIn();
				
				
			})



		$(document).on('click', '#post_grid_metabox .nav_filter', function()
			{
			
				var nav_filter = $(this).val();
			
				
				$('.filter-menu').css('display','none');				
				$('.filter-menu.'+nav_filter).fadeIn();
				
				
			})







		$(document).on('click', '.post-grid-settings .export-content-layouts', function(){
				
					jQuery.ajax(
						{
					type: 'POST',
					context: this,
					url: post_grid_ajax.post_grid_ajaxurl,
					data: {"action": "post_grid_export_content_layouts",},
					success: function(data)
							{	
								$(this).html('Export Done!');

								window.open(data,'_blank');


							}
						});

			})

		$(document).on('click', '.post-grid-settings .remove_export_content_layout', function()
			{

				var file_url = $(this).attr('file-url');
				
				if(confirm('Do you really want to remove ?')){
					
					
										
					jQuery.ajax(
						{
					type: 'POST',
					url: post_grid_ajax.post_grid_ajaxurl,
					context:this,
					data: {"action": "post_grid_ajax_remove_export_content_layout","file_url":file_url},
					success: function(data)
							{	
								//alert('Deleted');
								$(this).html('Deleted');

							}
						});
					
					}

			})



		$(document).on('click', '.post-grid-settings .remove-layout', function()
			{
				var layout_id = $(this).attr('layout-id');
				
				if(confirm('Do you really want to remove "'+layout_id+'" ?')){
					
					
										
					jQuery.ajax(
						{
					type: 'POST',
					url: post_grid_ajax.post_grid_ajaxurl,
					context:this,
					data: {"action": "post_grid_remove_content_layout_ajax","layout_id":layout_id},
					success: function(data)
							{	
								$(this).parent().remove();

							}
						});
					
					}

				
				
			})









		$(document).on('click', '.post-grid-settings .reset-content-layouts', function()
			{
				
				if(confirm("Do you really want to reset ?" )){
					
					jQuery.ajax(
						{
					type: 'POST',
					context: this,
					url: post_grid_ajax.post_grid_ajaxurl,
					data: {"action": "post_grid_reset_content_layouts",},
					success: function(data)
							{	
								$(this).html('Reset Done!');
															
								
							}
						});
					
					}

			})


		$(document).on('click', '.post-grid-settings .import-content-layouts', function()
			{
				
					var layouts_data = $('.import-content-layouts-data').val();
					
				
					jQuery.ajax(
						{
					type: 'POST',
					context: this,
					url: post_grid_ajax.post_grid_ajaxurl,
					data: {"action": "post_grid_import_content_layouts","layouts_data":layouts_data},
					success: function(data)
							{	
								$(this).html('Import Done!');
								$('.import-content-layouts-data').val('');

								//window.open(data,'_blank');


							}
						});

			})










		$(document).on('change', '#post_grid_metabox .select-layout-content', function()
			{
				var layout = $(this).val();		
			
				
				jQuery.ajax(
					{
				type: 'POST',
				url: post_grid_ajax.post_grid_ajaxurl,
				data: {"action": "post_grid_layout_content_ajax","layout":layout},
				success: function(data)
						{	
							//jQuery(".layout-content").html(data);
							jQuery("#post_grid_metabox .layer-content").html(data);
						}
					});
				
			})	

		
		
		$(document).on('click', '#post_grid_metabox .meta-query-list .remove', function()
			{
				
				if(confirm("Do you really want remove ?")){
					$(this).parent().parent().remove();
					}				

				
			})			
		

		
		
		
		
		$(document).on('click', '#post_grid_metabox .post_types', function()
			{
				
				var post_types = $(this).val();
				var post_id = $(this).attr('post_id');	
				
				
				
				jQuery.ajax(
					{
				type: 'POST',
				url: post_grid_ajax.post_grid_ajaxurl,
				data: {"action": "post_grid_get_categories","post_types":post_types,"post_id":post_id},
				success: function(data)
						{	

							jQuery("#post_grid_metabox .categories-container").html(data);
							
						}
					});
				
			})
		
		

		
		
		
		
		$(document).on('click', '#post_grid_metabox .clear-categories', function()
			{
				//alert('Hello');
				$('.categories option').prop('selected', false);
				
			})		
		
		
		$(document).on('click', '#post_grid_metabox .clear-post-types', function()
			{
				//alert('Hello');
				$('.post_types option').prop('selected', false);
				
			})		
		
		
		



	});	







