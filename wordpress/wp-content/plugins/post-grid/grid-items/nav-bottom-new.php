<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access
	
	
	$class_post_grid_functions = new class_post_grid_functions();
	
	$load_more_text = $class_post_grid_functions->load_more_text();
	
	
	
	
	
	
	
	
	
	$html.= '<div class="pagination '.$pagination_theme.'">';
	
	
	
	if($max_num_pages==0){
		
		$max_num_pages = $wp_query->max_num_pages;
	}
	
	//var_dump($pagination_type);
	
	
if($grid_type=='grid'){
	
	
	if($pagination_type=='normal'){
		
		
			$html.= '<div class="paginate">';

			$big = 999999999; // need an unlikely integer

			$html.= paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, $paged ),
				'total' => $max_num_pages,
				'prev_text'          => $pagination_prev_text,
				'next_text'          => $pagination_next_text,
				) );
		
		
			$html.= '</div >';	

		}
	elseif($pagination_type=='jquery'){
		
		
			$html .= '<div class="pager-list pager-list-'.$post_id.'"></div >';
			
			

		$html .= '<script>
			jQuery(document).ready(function($) {
				
					$(function(){
					
						$("#post-grid-'.$post_id.'").mixItUp({
				pagination: {
					limit: '.$filterable_post_per_page.',
					prevButtonHTML: "'.$pagination_prev_text.'",
					nextButtonHTML: "'.$pagination_next_text.'",
	
					
				},
				selectors: {
					filter: ".filter",
					pagersWrapper: ".pager-list-'.$post_id.'",
					
					
				},';
				
		if(!empty($active_filter) && $active_filter!= 'all')
			{
			

			$html .= '
			load: {
				filter: ".'.$active_filter.'"
			}, ';

			}

				$html .= 'controls: {
					enable: true
				}
				
						});
					
					});
					
			
					
					
			});		
		</script>';	

		
		
		$html .= '<style type="text/css">
		
				#post-grid-'.$post_id.' .grid-items .mix{
				  display: none;
				}
	
				
				</style>
				';
		
			
		
		
		
		
		
		}
	
	elseif($pagination_type=='loadmore'){
		
			if(!empty($paged))
				{
					$paged = $paged+1;
				}
			
			$html .= '<div grid_id="'.$post_id.'" class="load-more" paged="'.$paged.'" per_page="'.$posts_per_page.'" >'.$load_more_text.'</div >';
		
		}
	
	elseif($pagination_type=='infinite'){
		
			
			$html .= '<div grid_id="'.$post_id.'" class="infinite-scroll" paged="'.$paged.'" per_page="'.$posts_per_page.'" ><i class="fa fa-arrow-down"></i></div >';
		
		}	
	
	
	}
	
elseif($grid_type=='filterable'){
	
		if($pagination_type=='jquery'){
			$html .= '<div class="pager-list pager-list-'.$post_id.'"></div >';

			$html .= '<script>
				jQuery(document).ready(function($) {
					
						$(function(){
						
							$("#post-grid-'.$post_id.'").mixItUp({
					pagination: {
						limit: '.$filterable_post_per_page.',
						prevButtonHTML: "'.$pagination_prev_text.'",
						nextButtonHTML: "'.$pagination_next_text.'",
		
						
					},
					selectors: {
						filter: ".filter",
						pagersWrapper: ".pager-list-'.$post_id.'",
						
						
					},';
					
			if(!empty($active_filter) && $active_filter!= 'all')
				{
				
	
				$html .= '
				load: {
					filter: ".'.$active_filter.'"
				}, ';
	
				}
	
					$html .= 'controls: {
						enable: true
					}
					
							});
						
						});
						
				
						
						
				});		
			</script>';	
	
			
			
			$html .= '<style type="text/css">
			
					#post-grid-'.$post_id.' .grid-items .mix{
					  display: none;
					}
		
					
					</style>
					';
			
				
		}
	
	}
	
/*


	
		if($pagination_type=='pagination'){
			
			if($nav_top_filter=='yes'){
				
				$html .= '<div class="pager-list pager-list-'.$post_id.'"></div >';
				}
			else{
				$html .= '<div class="paginate">';
				


				$big = 999999999; // need an unlikely integer

				$html .= paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, $paged ),
					'total' => $max_num_pages,
					'prev_text'          => $pagination_prev_text,
					'next_text'          => $pagination_next_text,
					) );


	
			
				//$pagination_base = add_query_arg( $paging, '%#%' );
				
				//	$html .= paginate_links( array(
					//	'type' 		=> '',
				//		'base' 		=> $pagination_base,
				//		'format' 	=> '?'. $paging .'=%#%',
				//		'current' 	=> max( 1, $wp_query->get('paged') ),
				//		'total' 	=> $max_num_pages,
				//		'prev_text'          => $pagination_prev_text,
				//		'next_text'          => $pagination_next_text,	
						
						
				//	));
			
			
		
			
			
			
			
			
			

			
				$html .= '</div >';	
				
				}
	
			
			}
			
		elseif($pagination_type=='jquery-pagination'){
			
			$html .= '<div class="pager-list pager-list-'.$post_id.'"></div >';
			
			

		$html .= '<script>
			jQuery(document).ready(function($) {
				
					$(function(){
					
						$("#post-grid-'.$post_id.'").mixItUp({
				pagination: {
					limit: '.$filterable_post_per_page.',
					prevButtonHTML: "'.$pagination_prev_text.'",
					nextButtonHTML: "'.$pagination_next_text.'",
	
					
				},
				selectors: {
					filter: ".filter",
					pagersWrapper: ".pager-list-'.$post_id.'",
					
					
				},';
				
		if(!empty($active_filter) && $active_filter!= 'all')
			{
			

			$html .= '
			load: {
				filter: ".'.$active_filter.'"
			}, ';

			}

				$html .= 'controls: {
					enable: true
				}
				
						});
					
					});
					
			
					
					
			});		
		</script>';	

		
		
		$html .= '<style type="text/css">
		
				#post-grid-'.$post_id.' .grid-items .mix{
				  display: none;
				}
	
				
				</style>
				';
		
			
			
			}
			
		elseif($pagination_type=='load_more'){
			
			if(!empty($paged))
				{
					$paged = $paged+1;
				}
			
			$html .= '<div grid_id="'.$post_id.'" class="load-more" paged="'.$paged.'" per_page="'.$posts_per_page.'" >'.__('Load more',post_grid_textdomain).'</div >';
	
			
			}
			

			
			
			
			




*/
	
	
	
	
	$html .= '</div >';	