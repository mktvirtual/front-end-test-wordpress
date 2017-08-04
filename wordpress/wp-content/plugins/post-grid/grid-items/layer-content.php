<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access

	$class_post_grid_functions = new class_post_grid_functions();
	
	$post_grid_layout_content = get_option( 'post_grid_layout_content' );
	
	if(empty($post_grid_layout_content)){
		$layout = $class_post_grid_functions->layout_content($layout_content);
		}
	else{
		
		if(!empty($post_grid_layout_content[$layout_content])){
			$layout = $post_grid_layout_content[$layout_content];
			
			}
		else{
			$layout = array();
			}
		
		
		
		
		}
		

		
		

	$html_content = '';

	$html.='<div class="layer-content">';

	foreach($layout as $item_id=>$item_info){
		
		$item_key = $item_info['key'];
		
		if(!empty($item_info['char_limit'])){
			$char_limit = $item_info['char_limit'];	
			}

			
		if(!empty($item_info['link_target'])){
			$link_target = $item_info['link_target'];	
			}			
		else{
			$link_target = '';
			}
			
			
		
		
		if($item_key=='title'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			$html_content.= apply_filters('post_grid_filter_grid_item_title',wp_trim_words(get_the_title(), $char_limit,''));
			$html_content.='</div>';
			}
			
		elseif($item_key=='title_link'){

				$html_content.= '<a target="'.$link_target.'" class="element element_'.$item_id.' '.$item_key.'" href="'.get_permalink().'">'.apply_filters('post_grid_filter_grid_item_title',wp_trim_words(get_the_title(), $char_limit,'')).'</a>';

			}			
			
		elseif($item_key=='content'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			$the_content = get_the_content();
			$html_content.= apply_filters('post_grid_filter_grid_item_content', $the_content);	
			
			//$html_content.= apply_filters( 'the_content', get_the_content() );
			$html_content.='</div>';
			}	
			
		elseif($item_key=='read_more'){
	
			if(!empty($item_info['read_more_text'])){
				$read_more_text = $item_info['read_more_text'];	
				}
			else{
				
					
				
				
				$read_more_text = apply_filters('post_grid_filter_grid_item_read_more', __('Read more.', post_grid_textdomain));
				
				
				}


				$html_content.= '<a target="'.$link_target.'" class="element element_'.$item_id.' '.$item_key.'"  href="'.get_permalink().'">'.$read_more_text.'</a>';

			}
			
			
			
		elseif($item_key=='thumb'){
			
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
			$thumb_url = $thumb['0'];
	

			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			if(!empty($thumb_url)){
				$html_content.= '<img src="'.$thumb_url.'" />';
				}
			$html_content.='</div>';
			}			
			
		elseif($item_key=='thumb_link'){
			
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
			$thumb_url = $thumb['0'];
	

			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			
			if(!empty($thumb_url)){
				$html_content.= '<a href="'.get_permalink().'"><img src="'.$thumb_url.'" /></a>';
				}
				
			$html_content.='</div>';
			}			
			
			
		
			
			
		elseif($item_key=='excerpt'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			
			//var_dump(get_the_excerpt());
			$the_content = get_the_excerpt();
			
			$excerpt_removed_shortcode = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', strip_shortcodes($the_content));
			
			$html_content.= apply_filters('post_grid_filter_grid_item_excerpt',wp_trim_words($excerpt_removed_shortcode, $char_limit,''));		

			//$html_content.= wp_trim_words(get_the_excerpt(), $char_limit,'');
			$html_content.='</div>';
			}

			
	
		elseif($item_key=='excerpt_read_more'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			
			$read_more_text = apply_filters('post_grid_filter_grid_item_read_more', __('Read more.', post_grid_textdomain));
			
			$html_content.= wp_trim_words(strip_shortcodes(get_the_excerpt()), $char_limit,'').' <a target="'.$link_target.'" class="read-more" href="'.get_permalink().'">'.$read_more_text.'</a>';
			$html_content.='</div>';
			}
			
		elseif($item_key=='post_date'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			$html_content.= apply_filters('post_grid_filter_grid_item_post_date', get_the_date());	
			
			//$html_content.= get_the_date();
			$html_content.='</div>';
			}			
			
		elseif($item_key=='author'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			$html_content.= apply_filters('post_grid_filter_grid_item_author', get_the_author());			
			
			//$html_content.= get_the_author();
			$html_content.='</div>';
			}	
			
			
		elseif($item_key=='author_link'){
			//$html_content.='<div   >';
			$html_content.= '<a class="element element_'.$item_id.' '.$item_key.'" href="'.get_author_posts_url(get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' )).'">'.get_the_author().'</a>';			
			//$html_content.='</div>';
			}			
			
			
			
			
		elseif($item_key=='categories'){
			
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
				$categories = get_the_category();
				$separator = ' ';
				$output = '';
				if ( ! empty( $categories ) ) {
					foreach( $categories as $category ) {
						$html_content .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'post_grid_textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
					}
					$html_content.= trim( $output, $separator );
				}
			$html_content.='</div>';
		}					
			
		elseif($item_key=='tags'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
				$posttags = get_the_tags();
				if ($posttags) {
				  foreach($posttags as $tag){
					$html_content.= '<a href="#">'.$tag->name . '</a> ';
					}
				}
			$html_content.='</div>';
		}
		
		elseif($item_key=='comments_count'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			
				$comments_number = get_comments_number( get_the_ID() );
				
				if(comments_open()){
					
					if ( $comments_number == 0 ) {
							$html_content.= __('No Comments',post_grid_textdomain);
						} elseif ( $comments_number > 1 ) {
							$html_content.= $comments_number . __(' Comments',post_grid_textdomain);
						} else {
							$html_content.= __('1 Comment',post_grid_textdomain);
						}
		
					}
			$html_content.='</div>';
		}	
		
		
		elseif($item_key=='comments'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			$html_content.= '<h3 class="comment-content ">'.__('Comments', post_grid_textdomain).'</h3>';
			
			
			$comments_count =  wp_count_comments(get_the_ID());
			$total_comments = $comments_count->approved;
			
			//var_dump(get_the_ID());
	
			
			if($total_comments <= 0)
				{
	
					$html_content.= '<div class="comment no-comment">';
					$html_content.= '<p class="comment-content ">'.__('No comments yet',post_grid_textdomain).'</p>';											
					
					$html_content.= '</div>';
					
				}
			else
				{
	
					
					$comments = get_comments(array(
						'post_id' => get_the_ID(),
						'status' => 'approve',
						'number' => 5,				
						'order' => 'ASC',
					));
			
	
	
	
					if(empty($comments))
						{
	
							$html_content.= '<div class="comment no-more-comment">';
							$html_content.= '<p class="comment-content ">'.__('No More comments',post_grid_textdomain).'';											
							$html_content.= '</p>';							
							$html_content.= '</div>';
	
						}
					else
						{
							
							$html_content.= '<div id="comments" class="comments-area">';							
							$html_content.= '<ol class="commentlist">';
							
							foreach($comments as $comment) :
							
							
								$comment_ID = $comment->comment_ID;
								$comment_author = $comment->comment_author;							
								$comment_author_email = $comment->comment_author_email;
								$comment_content = $comment->comment_content;						
								$comment_date = $comment->comment_date;						
							
							
							
							
								$html_content.= '<li class="comment">';
								$html_content.= '<article id="" class="comment">';	
								$html_content.= '<header class="comment-meta comment-author vcard">';
								
								$html_content.= get_avatar($comment_author_email, 50);	
								
								$html_content.= '<cite><b class="fn">'.$comment_author.'</b></cite>';								
								$html_content.= '<time >'.$comment_date.'</time>';								
																									
								$html_content.= '</header>';								
								$html_content.= '<section class="comment-content comment">';
								$html_content.= '<p>'.$comment_content.'</p>';									
								$html_content.= '</section>';															

								$html_content.= '</article>';								
													
								$html_content.= '</li>';
								
							endforeach;
							
							$html_content.= '</ol>';
							$html_content.= '</div>';							
							
						}
	
	
	
				
				}




			$html_content.='</div>';
		}		
		
		
		elseif($item_key=='wc_full_price'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			
				$is_product = get_post_type( get_the_ID() );
				$active_plugins = get_option('active_plugins');
				if(in_array( 'woocommerce/woocommerce.php', (array) $active_plugins ) && $is_product=='product'){
				global $woocommerce, $product;
				
				$full_price = $product->get_price_html();
				
				$html_content.=$full_price;
				}
			$html_content.='</div>';
		}
		
			
		elseif($item_key=='wc_add_to_cart'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			
				$is_product = get_post_type( get_the_ID() );
				$active_plugins = get_option('active_plugins');
				if(in_array( 'woocommerce/woocommerce.php', (array) $active_plugins ) && $is_product=='product'){
				global $woocommerce, $product;
				
					
					$add_to_cart = do_shortcode('[add_to_cart show_price="false" id="'.get_the_ID().'"]');
					$html_content.= $add_to_cart;
					
				}
			$html_content.='</div>';
		}	

		
		
		elseif($item_key=='edd_price'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			
				$is_download = get_post_type( get_the_ID() );
				$active_plugins = get_option('active_plugins');
				if(in_array( 'easy-digital-downloads/easy-digital-downloads.php', (array) $active_plugins ) && $is_download=='download'){

				
				$edd_price = edd_price(get_the_ID(),false);

				$html_content.= $edd_price;
					
				}
			$html_content.='</div>';
		}		
			
		
		
		elseif($item_key=='edd_add_to_cart'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			
				$is_download = get_post_type( get_the_ID() );
				$active_plugins = get_option('active_plugins');
				if(in_array( 'easy-digital-downloads/easy-digital-downloads.php', (array) $active_plugins ) && $is_download=='download'){

				$purchase_link = do_shortcode('[purchase_link id="'.get_the_ID().'" text="'.__('Add to Cart','post_grid_textdomain').'" style="button"]'  );
				$html_content.= $purchase_link;
					
				}
			$html_content.='</div>';
		}			
		
		
		
		elseif($item_key=='share_button'){
			$html_content.='<div class="element element_'.$item_id.' '.$item_key.'"  >';
			
			$html_share_buttons = '';
			
			$html_share_buttons.= '
			<span class="fb">
				<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u='.get_permalink().'"> </a>
			</span>
			<span class="twitter">
				<a target="_blank" href="https://twitter.com/intent/tweet?url='.get_permalink().'&text='.get_the_title().'"></a>
			</span>
			<span class="gplus">
				<a target="_blank" href="https://plus.google.com/share?url='.get_permalink().'"></a>
			</span>';
			
			$html_content.= apply_filters('post_grid_filter_share_buttons',$html_share_buttons);			

			$html_content.='</div>';

		}			
		
		elseif($item_key=='hr'){

			$html_content.= '<hr class="element element_'.$item_id.' '.$item_key.'"  />';

		}		
		
		else{
			$html_content.= '';
			}	
		
		
						
					
			

		}
	
	
	
	$html.= apply_filters('post_grid_filter_html_content', $html_content);
	$html.='</div>'; // .layer-content