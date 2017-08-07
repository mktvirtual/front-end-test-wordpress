<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


						
						
	$post_format = get_post_format( get_the_ID() );
	
	if($post_format == 'video' || $post_format == 'audio' || $post_format == 'link' || $post_format == 'quote')
		{
		
		}
		
	elseif($post_format=='gallery')
		{
			
		}							
		
	else
		{

				$html .= '<div class="hover-items">';
				$html_hover = '';
				
				if($post_grid_hover_items_zoom_display == 'yes')
					{
						$html_hover .= '<a title="Zoom." class="zoom"></a>';
					}
				
				if($post_grid_hover_items_link_display == 'yes')
					{
						$html_hover .= '<a title="Read More." href="'.get_the_permalink(get_the_ID()).'" class="post-link"></a>';
					}								
				
				if($post_grid_hover_items_share_display == 'yes')
					{
						$html_hover .= '<div class="share-button">
						<a class="fb" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u='.get_permalink(get_the_ID()).'"> </a>
						<a class="twitter" target="_blank" href="https://twitter.com/intent/tweet?url='.get_permalink(get_the_ID()).'&text='.get_the_title(get_the_ID()).'"></a>
						<a class="gplus" target="_blank" href="https://plus.google.com/share?url='.get_permalink(get_the_ID()).'"></a>
								</div>

						';	
					}								
				
				$html .= apply_filters( 'post_grid_filter_hover', $html_hover );

				$html .= '</div >';	

			

		}
						
						
						
						
						
					
					