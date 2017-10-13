<?php
/**
 * The template for displaying content in the template-portfolio.php template
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

if( ! function_exists('mfn_content_portfolio') ){
	function mfn_content_portfolio( $query = false, $style = false ){
		global $wp_query;
		$output = '';
		
		$translate['readmore'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-readmore','Read more') : __('Read more','betheme');
		$translate['client'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-client','Client') : __('Client','betheme');
		$translate['date'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-date','Date') : __('Date','betheme');
		$translate['website'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-website','Website') : __('Website','betheme');
		$translate['view'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-view','View website') : __('View website','betheme');
		
		if( ! $query ) $query = $wp_query;
		if( ! $style ){
			if( $_GET && key_exists('mfn-p', $_GET) ){
				$style = esc_html( $_GET['mfn-p'] ); // demo
			} else {
				$style = mfn_opts_get( 'portfolio-layout', 'grid' );
			}
		}
		
		if ( $query->have_posts() ){
			while ( $query->have_posts() ){
				$query->the_post();
				
				$item_class = array();
				$categories = '';
				
				$terms = get_the_terms(get_the_ID(),'portfolio-types');
				if( is_array( $terms ) ){
					foreach( $terms as $term ){
						$item_class[] = 'category-'. $term->slug;
						$categories .= '<a href="'. site_url() .'/portfolio-types/'. $term->slug .'">'. $term->name .'</a>, ';
					}
					$categories = substr( $categories , 0, -2 );
				}
				$item_class[] = get_post_meta( get_the_ID(), 'mfn-post-size', true );
				$item_class[] = has_post_thumbnail() ? 'has-thumbnail' : 'no-thumbnail';
				$item_class = implode(' ', $item_class);

				$external			= mfn_opts_get( 'portfolio-external' );
				$ext_link			= get_post_meta( get_the_ID(), 'mfn-post-link', true );
				$large_image_url 	= wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
				
				
				// item backgrounds	---

				// style: list
				if( $item_bg_image = get_post_meta( get_the_ID(), 'mfn-post-bg', true ) ){
					$item_bg_image = ' background-image:url('. $item_bg_image .');';
				}
				
				// style: masonry hover
				$item_bg_class = 'bg-'. mfn_brightness( mfn_opts_get( 'background-imageframe-link', '#2991d6' ), 169 );
				
				if( $item_bg_color = get_post_meta( get_the_ID(), 'mfn-post-bg-hover', true ) ){
					
					$item_bg_class = 'bg-'. mfn_brightness( $item_bg_color, 169 );
					$item_bg_color = ' background-color:'. hex2rgba( $item_bg_color, 0.9 ) .';';
					
				}

				
				// Image Link ---------------------------------------------------------------------
				
				if( in_array( $external, array('disable','popup') ) ){
				
					// disable details & link popup 
					$link_before 	= '<a class="link" href="'. $large_image_url[0] .'" rel="prettyphoto">';

				} elseif( $external && $ext_link ){
				
					// link to project website
					$link_before 	= '<a class="link" href="'. $ext_link .'" target="'. $external .'">';
				
				} else {
				
					// link to project details
					$link_before 	= '<a class="link" href="'. get_permalink() .'">';
				
				}
				
				
				// Echo ---------------------------------------------------------------------------
				
				$output .= '<li class="portfolio-item isotope-item '. $item_class .'">';
				
				
					if( $style == 'exposure' ){
						// style: Exposure --------------------------------------------------------
						
						
						$output .= $link_before;
						
							// photo ------------------
							$output .= '<div class="image-wrapper scale-with-grid">';
								$output .= get_the_post_thumbnail( get_the_ID(), 'full', array( 'class'=>'scale-with-grid', 'itemprop'=>'image' ) );
								$output .= '<div class="mask"></div>';
							$output .= '</div>';
							
							// title ------------------
							$output .= '<div class="desc-inner">';
								$output .= '<div class="section_wrapper">';
									$output .= '<div class="desc-wrapper-inner">';

										$output .= '<div class="line"></div>';
										$output .= '<h2 class="entry-title" itemprop="headline">'. get_the_title() .'</h2>';
										
										$output .= '<div class="desc-wrappper">';
											$output .= get_the_excerpt();
										$output .= '</div>';
									
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</div>';
						
						$output .= '</a>';
						
						
						// details -------------------
						$output .= '<div class="details-wrapper">';					
							$output .= '<div class="section_wrapper">';
								$output .= '<div class="details-wrapper-inner">';
							
									if( $link = get_post_meta( get_the_ID(), 'mfn-post-link', true ) ){
										$output .= '<div class="column one-fourth website">';
											$output .= '<h5 class="label">'. $translate['website'] .'</h5>';
											$output .= '<h5><a target="_blank" href="'. $link .'"><i class="icon-forward"></i>'. $translate['view'] .'</a></h5>';
										$output .= '</div>';
									}
									
									if( $client = get_post_meta( get_the_ID(), 'mfn-post-client', true ) ){
										$output .= '<div class="column one-fourth client">';
											$output .= '<h5 class="label">'. $translate['client'] .'</h5>';
											$output .= '<h5>'. $client .'</h5>';
										$output .= '</div>';
									}
									
									$output .= '<div class="column one-fourth date">';
										$output .= '<h5 class="label">'. $translate['date'] .'</h5>';
										$output .= '<h5>'. get_the_date() .'</a></h5>';
									$output .= '</div>';

								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';

						
					} elseif( $style == 'masonry-minimal' ){
						// style: Masonry Minimal ---------------------------------------------------
						
						
							$output .= '<div class="image_frame scale-with-grid">';
								$output .= '<div class="image_wrapper">';
									$output .= mfn_post_thumbnail( get_the_ID(), 'portfolio', 'masonry-minimal' );
								$output .= '</div>';
							$output .= '</div>';
						
						
					} elseif( $style == 'masonry-hover' ){
						// style: Masonry Hover ---------------------------------------------------
						
						
						$output .= '<div class="masonry-hover-wrapper">';	
		
							// desc -------------------						
							$output .= '<div class="hover-desc '. $item_bg_class .'" style="'. $item_bg_color .'">';
							
								$output .= '<div class="desc-inner">';
								
									$output .= '<h3 class="entry-title" itemprop="headline">'. $link_before . get_the_title() .'</a></h3>';
									$output .= '<div class="desc-wrappper">';
										$output .= get_the_excerpt();
									$output .= '</div>';
	
								$output .= '</div>';
								
								if( $external != 'disable' ){
									$output .= '<div class="links-wrappper clearfix">';
										if( ! in_array( $external, array('_self','_blank') ) )  $output .= '<a class="zoom" href="'. $large_image_url[0] .'" rel="prettyphoto"><i class="icon-search"></i></a>';
										if( $ext_link ) $output .= '<a class="external" target="_blank" href="'. $ext_link .'" ><i class="icon-forward"></i></a>';
										if( ! $external )  $output .= $link_before. '<i class="icon-link"></i></a>';
									$output .= '</div>';
								}
								
							$output .= '</div>';
						
							// photo ------------------
							$output .= '<div class="image-wrapper scale-with-grid">';
								$output .= $link_before;
									$output .= get_the_post_thumbnail( get_the_ID(), 'full', array( 'class'=>'scale-with-grid', 'itemprop'=>'image' ) );
								$output .= '</a>';
							$output .= '</div>';
										
						$output .= '</div>';
						
						
					} else {
						// style: All -------------------------------------------------------------
						
						
						$output .= '<div class="portfolio-item-fw-bg" style="'. $item_bg_color . $item_bg_image .'">';
						
							$output .= '<div class="portfolio-item-fill"></div>';
							
							if( $style == 'list' ) $output .= '<div class="section_wrapper">'; // style: List | Section Wrapper
							
								// style: List | Desc ---------------------------------------------
								$output .= '<div class="list_style_header">';
									$output .= '<h3 class="entry-title" itemprop="headline">'. $link_before . get_the_title() .'</a></h3>';
									$output .= '<div class="links_wrapper">';
										$output .= '<a href="#" class="button button_js portfolio_prev_js"><span class="button_icon"><i class="icon-up-open"></i></span></a>';
										$output .= '<a href="#" class="button button_js portfolio_next_js"><span class="button_icon"><i class="icon-down-open"></i></span></a>';
										$output .= '<a href="'. get_permalink() .'" class="button button_left button_theme button_js"><span class="button_icon"><i class="icon-link"></i></span><span class="button_label">'. $translate['readmore'] .'</span></a>';
									$output .= '</div>';
								$output .= '</div>';
									
								// style: All | Photo ---------------------------------------------
								$output .= '<div class="image_frame scale-with-grid">';
									$output .= '<div class="image_wrapper">';		
										$output .= mfn_post_thumbnail( get_the_ID(), 'portfolio', $style );
									$output .= '</div>';
								$output .= '</div>';
				
								// style: All | Desc ----------------------------------------------
								$output .= '<div class="desc">';
								
									$output .= '<div class="title_wrapper">';
										$output .= '<h5 class="entry-title" itemprop="headline">'. $link_before . get_the_title() .'</a></h5>';								
										$output .= '<div class="button-love">'. mfn_love() .'</div>';
									$output .= '</div>';
				
									$output .= '<div class="details-wrapper">';
										$output .= '<dl>';
											if( $client = get_post_meta( get_the_ID(), 'mfn-post-client', true ) ){
												$output .= '<dt>'. $translate['client'] .'</dt>';
												$output .= '<dd>'. $client .'</dd>';
											}
											$output .= '<dt>'. $translate['date'] .'</dt>';
											$output .= '<dd>'. get_the_date() .'</dd>';
											if( $link = get_post_meta( get_the_ID(), 'mfn-post-link', true ) ){
												$output .= '<dt>'. $translate['website'] .'</dt>';
												$output .= '<dd><a target="_blank" href="'. $link .'"><i class="icon-forward"></i>'. $translate['view'] .'</a></dd>';
											}
										$output .= '</dl>';
									$output .= '</div>';
									
									$output .= '<div class="desc-wrapper">';
										$output .= get_the_excerpt();
									$output .= '</div>';
									
								$output .= '</div>';
								
							if( $style == 'list' ) $output .= '</div>'; // style: List | end: Section Wrapper
							
						$output .= '</div>';
						
					}
					
					
				$output .= '</li>';
				
			}
		}
		
		return $output;
	}
}
