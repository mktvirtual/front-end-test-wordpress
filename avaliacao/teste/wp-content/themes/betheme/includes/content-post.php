<?php
/**
 * The template for displaying content in the index.php template
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

if( ! function_exists('mfn_content_post') ){
	function mfn_content_post( $query = false, $style = false, $images_only = false ){
		global $wp_query;
		$output = '';
	
		$translate['published'] 	= mfn_opts_get('translate') ? mfn_opts_get('translate-published','Published by') : __('Published by','betheme');
		$translate['at'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-at','at') : __('at','betheme');
		$translate['categories'] 	= mfn_opts_get('translate') ? mfn_opts_get('translate-categories','Categories') : __('Categories','betheme');
		$translate['like'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-like','Do you like it?') : __('Do you like it?','betheme');
		$translate['readmore'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-readmore','Read more') : __('Read more','betheme');
	
		if( ! $query ) $query = $wp_query;
		if( ! $style ){
			if( $_GET && key_exists('mfn-b', $_GET) ){
				$style = esc_html( $_GET['mfn-b'] ); // demo
			} else {
				$style = mfn_opts_get( 'blog-layout', 'classic' );
			}
		}
		
		$count = 0;
		$post['posts'] = "";
		if ( $query->have_posts() ){
			while ( $query->have_posts() ){
				$query->the_post();
				$count++;
				
				// classes
				
				$post_class =  array('post-item','isotope-item','clearfix');
				if( ! mfn_post_thumbnail( get_the_ID() ) ) $post_class[] = 'no-img';
				if( post_password_required() ) $post_class[] = 'no-img';
				$post_class[] = 'author-'. mfn_slug( get_the_author_meta( 'user_login' ) );
				$post_class = implode(' ', get_post_class( $post_class ));
				
				// background color | Style - Masonry Tiles
				
				$bg_color = get_post_meta( get_the_ID(), 'mfn-post-bg', true );
				if( $bg_color && $style == 'masonry tiles' ){
					$bg_color = 'style="background-color:'. $bg_color .';"';
				}
				
				
				$output .= '<div class="'. $post_class .'" '. $bg_color .'>';
				
				/*
					// icon | Style == Masonry Tiles
					if( $style == 'masonry tiles' ){
						
						if( get_post_format() == 'video' ){
							
							$output .=  '<i class="post-format-icon icon-play"></i>';
							
						} elseif( get_post_format() == 'quote' ){
							
							$output .=  '<i class="post-format-icon icon-quote"></i>';
							
						} elseif( get_post_format() == 'link' ){
							
							$output .=  '<i class="post-format-icon icon-link"></i>';
							
						} elseif( get_post_format() == 'audio' ){	// for future use
							
							$output .=  '<i class="post-format-icon icon-music-line"></i>';
							
						} else {
							
							$rev_slider = get_post_meta( get_the_ID(), 'mfn-post-slider', true );
							$lay_slider = get_post_meta( get_the_ID(), 'mfn-post-slider-layer', true );
							
							if( $rev_slider || $lay_slider ){
								$output .=  '<i class="post-format-icon icon-code"></i>';
							}
							
						}

					}
			
					
					// date | Style == Timeline
					$output .= '<div class="date_label">'. get_the_date() .'</div>';*/
					
					
					// photo --------------------------------------------------------------------------
					if( ! post_password_required() ){
						
						if( $style == 'masonry tiles' ){
							
							// photo | Style != Masonry Tiles
							
							$output .= '<div class="post-photo-wrapper scale-with-grid">';				
								$output .= '<div class="image_wrapper_tiles">';				
									$output .= get_the_post_thumbnail( get_the_ID(), 'full', array( 'class'=>'scale-with-grid', 'itemprop'=>'image' ) );
								$output .= '</div>';
							$output .= '</div>';
	
						} else {
							
							// photo | Style == *
							
							// Post Image
							$post_format = mfn_post_thumbnail_type( get_the_ID() );
							if( $images_only ){
								$post_format = $images_only;
							}
							
							
							$output .= '<div class="image_frame post-photo-wrapper scale-with-grid '. $post_format .'">';
								$output .= '<div class="image_wrapper">';
									$output .= mfn_post_thumbnail( get_the_ID(), 'blog', $style, $images_only );
									
								$output .= '</div>';
								$output .= '<div class="post-desc-wrapper">';
									switch ($count) {
										case 1:
											$output .= '<div class="post-desc post-1">';
											$text = "SAIBA MAIS";
											break;
										case 2:
											$output .= '<div class="post-desc post-2">';
											$text = "CONTINUE LENDO";
											break;
										case 3:
											$output .= '<div class="post-desc post-3">';
											$text = "SAIBA MAIS";
											break;
										case 4:
											$output .= '<div class="post-desc post-4">';
											$text = "SAIBA MAIS";
											break;	
									}
									
										// title -------------------------------------
										$output .= '<div class="post-title">';	
												// default ----------------------------
												$output .= '<h2 class="entry-title" itemprop="headline"><a href="'. get_permalink() .'">'. get_the_title() .'</a></h2>';
											}
											
										$output .= '</div>';
					
										// content -------------------------------------
										$output .= '<div class="post-excerpt">'. get_the_excerpt() .'</div>';
										$output .= '<div class="read-more">'. $text .'</div>';
										
										
										
										
										
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</div>';
					}
				
					// desc ---------------------------------------------------------------------------
					
				
				$output .= '</div>';
				
			}
		}
		
		return $output;
	}
}
