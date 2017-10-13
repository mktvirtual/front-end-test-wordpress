<?php
/**
 * Shortcodes.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */


/* ---------------------------------------------------------------------------
 * Column One Sixth [one_sixth] [/one_sixth]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_one_sixth' ) )
{
	function sc_one_sixth( $attr, $content = null )
	{
		$output  = '<div class="column one-sixth">';
		$output .= do_shortcode($content);
		$output .= '</div>'."\n";

		return $output;
	}
}

/* ---------------------------------------------------------------------------
 * Column One Fifth [one_fifth] [/one_fifth]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_one_fifth' ) )
{
	function sc_one_fifth( $attr, $content = null )
	{
		$output  = '<div class="column one-fifth">';
		$output .= do_shortcode($content);
		$output .= '</div>'."\n";

		return $output;
	}
}

/* ---------------------------------------------------------------------------
 * Column One Fourth [one_fourth] [/one_fourth]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_one_fourth' ) )
{
	function sc_one_fourth( $attr, $content = null )
	{
		$output  = '<div class="column one-fourth">';
		$output .= do_shortcode($content);
		$output .= '</div>'."\n";

		return $output;
	}
}

/* ---------------------------------------------------------------------------
 * Column One Third [one_third] [/one_third]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_one_third' ) )
{
	function sc_one_third( $attr, $content = null )
	{
		$output  = '<div class="column one-third">';
		$output .= do_shortcode($content);
		$output .= '</div>'."\n";

		return $output;
	}
}

/* ---------------------------------------------------------------------------
 * Column Two Fifth [two_fifth] [/two_fifth]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_two_fifth' ) )
{
	function sc_two_fifth( $attr, $content = null )
	{
		$output  = '<div class="column two-fifth">';
		$output .= do_shortcode($content);
		$output .= '</div>'."\n";

		return $output;
	}
}

/* ---------------------------------------------------------------------------
 * Column One Second [one_second] [/one_second]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_one_second' ) )
{
	function sc_one_second( $attr, $content = null )
	{
		$output  = '<div class="column one-second">';
		$output .= do_shortcode($content);
		$output .= '</div>'."\n";

		return $output;
	}
}

/* ---------------------------------------------------------------------------
 * Column Two Fifth [three_fifth] [/three_fifth]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_three_fifth' ) )
{
	function sc_three_fifth( $attr, $content = null )
	{
		$output  = '<div class="column three-fifth">';
		$output .= do_shortcode($content);
		$output .= '</div>'."\n";

		return $output;
	}
}

/* ---------------------------------------------------------------------------
 * Column Two Third [two_third] [/two_third]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_two_third' ) )
{
	function sc_two_third( $attr, $content = null )
	{
		$output  = '<div class="column two-third">';
		$output .= do_shortcode($content);
		$output .= '</div>'."\n";

		return $output;
	}
}

/* ---------------------------------------------------------------------------
 * Column Three Fourth [three_fourth] [/three_fourth]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_three_fourth' ) )
{
	function sc_three_fourth( $attr, $content = null )
	{
		$output  = '<div class="column three-fourth">';
		$output .= do_shortcode($content);
		$output .= '</div>'."\n";

		return $output;
	}
}

/* ---------------------------------------------------------------------------
 * Column Two Fifth [four_fifth] [/four_fifth]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_four_fifth' ) )
{
	function sc_four_fifth( $attr, $content = null )
	{
		$output  = '<div class="column four-fifth">';
		$output .= do_shortcode($content);
		$output .= '</div>'."\n";

		return $output;
	}
}

/* ---------------------------------------------------------------------------
 * Column Two Fifth [five_sixth] [/five_sixth]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_five_sixth' ) )
{
	function sc_five_sixth( $attr, $content = null )
	{
		$output  = '<div class="column five-sixth">';
		$output .= do_shortcode($content);
		$output .= '</div>'."\n";

		return $output;
	}
}

/* ---------------------------------------------------------------------------
 * Column One [one] [/one]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_one' ) )
{
	function sc_one( $attr, $content = null )
	{
		$output  = '<div class="column one">';
		$output .= do_shortcode($content);
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Code [code] [/code]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_code' ) )
{
	function sc_code( $attr, $content = null )
	{
		$output  = '<pre>';
			$output .= do_shortcode(htmlspecialchars($content));
		$output .= '</pre>'."\n";
		
	    return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Article Box [article_box] [/article_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_article_box' ) )
{
	function sc_article_box( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image' 	=> '',
			'slogan' 	=> '',
			'title' 	=> '',
			'link' 		=> '',
			'target' 	=> '',
			'animate' 	=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}	
		
		$output = '<div class="article_box">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
				if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
				
					$output .= '<div class="photo_wrapper">';
						$output .= '<img class="scale-with-grid" src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
					$output .= '</div>';
					
					$output .= '<div class="desc_wrapper">';
						if( $slogan ) $output .= '<p>'. $slogan .'</p>';
						if( $title ) $output .= '<h4>'. $title .'</h4>';
						$output .= '<i class="icon-right-open themecolor"></i>';
					$output .= '</div>';
					
				if( $link ) $output .= '</a>';
			if( $animate ) $output .= '</div>'."\n";
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Helper [helper] [/helper]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_helper' ) )
{
	function sc_helper( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title' 	=> '',
			'title_tag' => 'h4',
			
			'title1' 	=> '',
			'content1' 	=> '',
			'link1' 	=> '',
			'target1' 	=> '',
			'class1' 	=> '',
			
			'title2' 	=> '',			
			'content2' 	=> '',
			'link2' 	=> '',
			'target2' 	=> '',
			'class2' 	=> '',
				
		), $attr));
		
		// target
		$target1 = $target1 ? 'target="_blank"' : false;
		$target2 = $target2 ? 'target="_blank"' : false;
	
		$output = '<div class="helper">';

			$output .= '<div class="helper_header">';
			
				if( $title ){
					$output .= '<'. $title_tag .' class="title">'. $title .'</'. $title_tag .'>';
				}
				
				$output .= '<div class="links">';
				
					if( $title1 ){
						if( $link1 ){
							$output .= '<a class="link link-1 '. $class1 .'" href="'. $link1 .'" '. $target1 .'>'. $title1 .'</a>';
						} else {
							$output .= '<a class="link link-1 toggle" href="#" data-rel="1">'. $title1 .'</a>';
						}
					}
					
					if( $title2 ){
						if( $link2 ){
							$output .= '<a class="link link-2 '. $class2 .'" href="'. $link2 .'" '. $target2 .'>'. $title2 .'</a>';
						} else {
							$output .= '<a class="link link-2 toggle" href="#" data-rel="2">'. $title2 .'</a>';
						}
					}

				$output .= '</div>';
				
			$output .= '</div>';
			
			$output .= '<div class="helper_content">';
				
				if( ! $link1 ) $output .= '<div class="item item-1">'. do_shortcode( $content1 ) .'</div>';
				
				if( ! $link2 ) $output .= '<div class="item item-2">'. do_shortcode( $content2 ) .'</div>';
				
			$output .= '</div>';

		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Before After [before_after] [/before_after]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_before_after' ) )
{
	function sc_before_after( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image_before' 	=> '',
			'image_after' 	=> '',
			'classes' 		=> '',
		), $attr));
		
		// image | visual composer fix
		$image_before = mfn_vc_image( $image_before );
		$image_after = mfn_vc_image( $image_after );
		
		$output = '<div class="before_after twentytwenty-container">';
			$output .= '<img class="scale-with-grid" src="'. $image_before .'" alt="'. mfn_get_attachment_data( $image_before, 'alt' ) .'" width="'. mfn_get_attachment_data( $image_before, 'width' ) .'" height="'. mfn_get_attachment_data( $image_before, 'height' ) .'"/>';
			$output .= '<img class="scale-with-grid" src="'. $image_after .'" alt="'. mfn_get_attachment_data( $image_after, 'alt' ) .'" width="'. mfn_get_attachment_data( $image_after, 'width' ) .'" height="'. mfn_get_attachment_data( $image_after, 'height' ) .'"/>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Flat Box [flat_box] [/flat_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_flat_box' ) )
{
	function sc_flat_box( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image' 		=> '',
			'title' 		=> '',
			'icon' 			=> 'icon-lamp',
			'icon_image' 	=> '',
			'background' 	=> '',
			'link' 			=> '',
			'target' 		=> '',
			'animate' 		=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		$icon_image = mfn_vc_image( $icon_image );
		
		// background
		if( $background ) $background = 'style="background-color:'. $background .'"';
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}

		$output = '<div class="flat_box">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
			
				if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
				
					$output .= '<div class="photo_wrapper">';
						$output .= '<div class="icon themebg" '. $background .'>';
							if( $icon_image ){
								$output .= '<img class="scale-with-grid" src="'. $icon_image .'" alt="'. mfn_get_attachment_data( $icon_image, 'alt' ) .'" width="'. mfn_get_attachment_data( $icon_image, 'width' ) .'" height="'. mfn_get_attachment_data( $icon_image, 'height' ) .'"/>';
							} else {
								$output .= '<i class="'. $icon .'"></i>';
							}	
						$output .= '</div>';
						$output .= '<img class="photo scale-with-grid" src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
					$output .= '</div>';
					
					$output .= '<div class="desc_wrapper">';
						if( $title ) $output .= '<h4>'. $title .'</h4>';
						if( $content )$output .= '<div class="desc">'. do_shortcode($content) .'</div>';
					$output .= '</div>';
					
				if( $link ) $output .= '</a>';
				
			if( $animate ) $output .= '</div>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Flat Box [feature_box] [/feature_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_feature_box' ) )
{
	function sc_feature_box( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image' 		=> '',
			'title' 		=> '',
			'background' 	=> '',	
			'link' 			=> '',
			'target' 		=> '',		
			'animate' 		=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// background
		if( $background ) $background = 'style="background-color:'. $background .'"';
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}

		$output = '<div class="feature_box">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
				
				$output .= '<div class="feature_box_wrapper" '. $background .'>';
				
					$output .= '<div class="photo_wrapper">';
						if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
							$output .= '<img class="scale-with-grid" src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'" />';
						if( $link ) $output .= '</a>';
					$output .= '</div>';
					
					$output .= '<div class="desc_wrapper">';							
						if( $title ) $output .= '<h4>'. $title .'</h4>';
						if( $content )$output .= '<div class="desc">'. do_shortcode($content) .'</div>';							
					$output .= '</div>';
					
				$output .= '</div>';
			
			if( $animate ) $output .= '</div>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Photo Box [photo_box] [/photo_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_photo_box' ) )
{
	function sc_photo_box( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image' 	=> '',
			'title' 	=> '',
			'align' 	=> '',
			'link' 		=> '',
			'target' 	=> '',
			'greyscale' => '',
			'animate' 	=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		// class
		$class = '';
		if( $align ) 		$class .= ' pb_'. $align;
		if( $greyscale )	$class .= ' greyscale';
		if( !$content )		$class .= ' without-desc';

		$output = '<div class="photo_box '. $class .'">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
				if( $title ) $output .= '<h4>'. $title .'</h4>';
				
				if( $image ){
					$output .= '<div class="image_frame">';
						$output .= '<div class="image_wrapper">';
							if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';;
								$output .= '<div class="mask"></div>';
								$output .= '<img class="scale-with-grid" src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
							if( $link ) $output .= '</a>';
						$output .= '</div>';
					$output .= '</div>';
				}
				
				if( $content ) $output .= '<div class="desc">'. do_shortcode($content) .'</div>';	
			if( $animate ) $output .= '</div>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Zoom Box [zoom_box] [/zoom_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_zoom_box' ) )
{
	function sc_zoom_box( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image' 		=> '',
			'bg_color' 		=> '#000',
			'content_image' => '',
			'link' 			=> '',
			'target' 		=> '',
		), $attr));
		
		// image | visual composer fix
		$image 			= mfn_vc_image( $image );
		$content_image 	= mfn_vc_image( $content_image );
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}

		$output = '<div class="zoom_box">';
			if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
			
				$output .= '<div class="photo">';
					$output .= '<img class="scale-with-grid" src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
				$output .= '</div>';
				
				$output .= '<div class="desc" style="background-color:'. hex2rgba( $bg_color, 0.8 ) .';">';
					$output .= '<div class="desc_wrap">';
				
						if( $content_image ){
							$output .= '<div class="desc_img">';
								$output .= '<img class="scale-with-grid" src="'. $content_image .'" alt="'. mfn_get_attachment_data( $content_image, 'alt' ) .'" width="'. mfn_get_attachment_data( $content_image, 'width' ) .'" height="'. mfn_get_attachment_data( $content_image, 'height' ) .'"/>';
							$output .= '</div>';
						}
						
						if( $content ){
							$output .= '<div class="desc_txt">';
								$output .= do_shortcode( $content );
							$output .= '</div>';
						}
					
					$output .= '</div>';
				$output .= '</div>';
				
			if( $link ) $output .= '</a>';					
		$output .= '</div>'."\n";		

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Sliding Box [sliding_box] [/sliding_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_sliding_box' ) )
{
	function sc_sliding_box( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image' 	=> '',
			'title' 	=> '',
			'link' 		=> '',
			'target' 	=> '',
			'animate' 	=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		$output = '<div class="sliding_box">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
				if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
				
					$output .= '<div class="photo_wrapper">';
						$output .= '<img class="scale-with-grid" src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
					$output .= '</div>';
					
					$output .= '<div class="desc_wrapper">';
						if( $title ) $output .= '<h4>'. $title .'</h4>';
					$output .= '</div>';
					
				if( $link ) $output .= '</a>';
			if( $animate ) $output .= '</div>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Story Box [story_box] [/story_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_story_box' ) )
{
	function sc_story_box( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image' 	=> '',
			'style' 	=> '',
			'title' 	=> '',
			'link' 		=> '',
			'target' 	=> '',
			'animate' 	=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}	
		
		$output = '<div class="story_box '. $style .'">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
				if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
				
					$output .= '<div class="photo_wrapper">';
						$output .= '<img class="scale-with-grid" src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
					$output .= '</div>';
					
					$output .= '<div class="desc_wrapper">';
						if( $title ){
							$output .= '<h3 class="themecolor">'. $title .'</h3>';
							$output .= '<hr class="hr_color">';
						}	
						$output .= '<div class="desc">'. do_shortcode( $content ) .'</div>';
					$output .= '</div>';
	
				if( $link ) $output .= '</a>';
			if( $animate ) $output .= '</div>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Trailer Box [trailer_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_trailer_box' ) )
{
	function sc_trailer_box( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image' 	=> '',
			'slogan' 	=> '',
			'title' 	=> '',
			'link' 		=> '',
			'target' 	=> '',
			'animate' 	=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		$output = '<div class="trailer_box">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
				if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
				
					$output .= '<img class="scale-with-grid" src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
					$output .= '<div class="desc">';
						if( $slogan ) $output .= '<div class="subtitle">'. $slogan .'</div>';
						if( $title )  $output .= '<h2>'. $title .'</h2>';
						$output .= '<div class="line"></div>';
					$output .= '</div>';
					
				if( $link ) $output .= '</a>';
			if( $animate ) $output .= '</div>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Promo Box [promo_box] [/promo_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_promo_box' ) )
{
	function sc_promo_box( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image' 	=> '',
			'title' 	=> '',
			'btn_text' 	=> '',
			'btn_link' 	=> '',
			'position' 	=> 'left',
			'border' 	=> '',
			'target' 	=> '',
			'animate' 	=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// border
		if( $border ){
			$border = 'has_border';
		} else {
			$border = 'no_border';
		}
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
				
		$output = '<div class="promo_box '. $border .'">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
				$output .= '<div class="promo_box_wrapper promo_box_'. $position .'">';
	
					$output .= '<div class="photo_wrapper">';
						if( $image ) $output .= '<img class="scale-with-grid" src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
					$output .= '</div>';
					
					$output .= '<div class="desc_wrapper">';
						if( $title )$output .= '<h2>'. $title .'</h2>';
						if( $content ) $output .= '<div class="desc">'. do_shortcode($content) .'</div>';
						if( $btn_link ) $output .= '<a href="'. $btn_link .'" class="button button_left button_theme button_js" '. $target .'><span class="button_icon"><i class="icon-layout"></i></span><span class="button_label">'. $btn_text .'</span></a>';
					$output .= '</div>';
					
				$output .= '</div>';
			if( $animate ) $output .= '</div>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Share Box [share_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_share_box' ) )
{
	function sc_share_box( $attr, $content = null )
	{
		$output = '<div class="share_wrapper share_item">';
		
			$output .= '<span class="st_facebook_vcount" displayText="Facebook"></span>';
			$output .= '<span class="st_twitter_vcount" displayText="Tweet"></span>';
			$output .= '<span class="st_pinterest_vcount" displayText="Pinterest"></span>';
			
			$output .= '<script src="http'. mfn_ssl() .'://w'. mfn_ssl() .'.sharethis.com/button/buttons.js"></script>';
			$output .= '<script>stLight.options({publisher: "1390eb48-c3c3-409a-903a-ca202d50de91", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>';
			
		$output .= '</div>';

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * How It Works [how_it_works] [/how_it_works]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_how_it_works' ) )
{
	function sc_how_it_works( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image' 	=> '',
			'number' 	=> '',
			'title' 	=> '',
			
			'border' 	=> '',
			'style' 	=> '',
			
			'link' 		=> '',
			'target' 	=> '',
			
			'animate' 	=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// border
		if( $border ){
			$border = 'has_border';
		} else {
			$border = 'no_border';
		}
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
				
		$output = '<div class="how_it_works '. esc_attr( $border ) .' '. esc_attr( $style ) .'">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
			
					if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
						$output .= '<div class="image">';
							$output .= '<img src="'. $image .'" class="scale-with-grid" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'">';
							if( $number ) $output .= '<span class="number">'. $number .'</span>';
						$output .= '</div>';
					if( $link ) $output .= '</a>';
					
					if( $title ) $output .= '<h4>'. $title .'</h4>';
					$output .= '<div class="desc">'. do_shortcode($content) .'</div>';
				
			if( $animate ) $output .= '</div>'."\n";
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Blog [blog]
* --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_blog' ) )
{
	function sc_blog( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'count'				=> 2,
			'style'				=> 'classic',
			'columns'			=> 3,
			'images'			=> '',
			
			'category'			=> '',
			'category_multi'	=> '',
			
			'exclude_id'		=> '',
			'filters'			=> '',
			'more'				=> '',
			
			'pagination'		=> '',
			'load_more'			=> '',
			
			'greyscale'			=> '',
			'margin'			=> '',
					
			'events'			=> '',			
		), $attr));
		
		$translate['filter'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-filter','Filter by') : __('Filter by','betheme');
		$translate['tags'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-tags','Tags') : __('Tags','betheme');
		$translate['authors'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-authors','Authors') : __('Authors','betheme');
		$translate['all'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-item-all','All') : __('All','betheme');
		$translate['categories'] 	= mfn_opts_get('translate') ? mfn_opts_get('translate-categories','Categories') : __('Categories','betheme');

		
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
		$args = array(
			'posts_per_page'		=> intval($count),
			'paged' 				=> $paged,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 0,
		);
		
		// private
		if( is_user_logged_in() ){
			$args['post_status'] = array( 'publish', 'private' );
		}
		
		// Include events | The events calendar
		if( $events ){
			$args['post_type'] = array( 'post', 'tribe_events' );
		}

		// categories
		if( $category_multi ){
			$args['category_name'] = trim( $category_multi );
		} elseif( $category ){
			$args['category_name'] = $category;
		}
		
		// exclude posts
		if( $exclude_id ){
			$exclude_id = str_replace( ' ', '', $exclude_id );
			$args['post__not_in'] = explode( ',', $exclude_id );
		}

		$query_blog = new WP_Query( $args );
		
		
		// classes
		$classes = $style;
		
		if( $greyscale ) 	$classes .= ' greyscale';
		if( $margin ) 		$classes .= ' margin'; 
		if( ! $more ) 		$classes .= ' hide-more'; 
		if( in_array( $style, array('masonry','masonry tiles') ) ){
			$classes .= ' isotope';
		}

		
		$output = '<div class="column_filters">';
		

			// Echo | Filters
			if( $filters && in_array( $style, array('masonry','masonry tiles') ) && ! $category && ! $category_multi ){
				
				$filters_class = '';
				if( $filters != 1 ){
					$filters_class .= ' only '. $filters;
				}
				
				$output .= '<div id="Filters" class="isotope-filters '. $filters_class .'" data-parent="column_filters">';
				
					$output .= '<ul class="filters_buttons">';
						$output .= '<li class="label">'. $translate['filter'] .'</li>';
						$output .= '<li class="categories"><a class="open" href="#"><i class="icon-docs"></i>'. $translate['categories'] .'<i class="icon-down-dir"></i></a></li>';
						$output .= '<li class="tags"><a class="open" href="#"><i class="icon-tag"></i>'. $translate['tags'] .'<i class="icon-down-dir"></i></a></li>';
						$output .= '<li class="authors"><a class="open" href="#"><i class="icon-user"></i>'. $translate['authors'] .'<i class="icon-down-dir"></i></a></li>';
					$output .= '</ul>';
											
					$output .= '<div class="filters_wrapper">';
					
						// categories
						$output .= '<ul class="categories">';						
							$output .= '<li class="reset current-cat"><a class="all" data-rel="*" href="#">'. $translate['all'] .'</a></li>';
							if( $categories = get_categories() ){
								foreach( $categories as $category ){
									$output .= '<li class="'. $category->slug .'"><a data-rel=".category-'. $category->slug .'" href="'. get_term_link($category) .'">'. $category->name .'</a></li>';
								}
							}
							$output .= '<li class="close"><a href="#"><i class="icon-cancel"></i></a></li>';
						$output .= '</ul>';
						
						// tags
						$output .= '<ul class="tags">';
							$output .= '<li class="reset current-cat"><a class="all" data-rel="*" href="#">'. $translate['all'] .'</a></li>';
							if( $tags = get_tags() ){
								foreach( $tags as $tag ){
									$output .= '<li class="'. $tag->slug .'"><a data-rel=".tag-'. $tag->slug .'" href="'. get_tag_link($tag) .'">'. $tag->name .'</a></li>';
								}
							}
							$output .= '<li class="close"><a href="#"><i class="icon-cancel"></i></a></li>';
						$output .= '</ul>';
						
						// authors
						$output .= '<ul class="authors">';
							$output .= '<li class="reset current-cat"><a class="all" data-rel="*" href="#">'. $translate['all'] .'</a></li>';
							$authors = mfn_get_authors();
							if( is_array( $authors ) ){
								foreach( $authors as $auth ){
									$output .= '<li class="'. mfn_slug( $auth->data->user_login ) .'"><a data-rel=".author-'. mfn_slug( $auth->data->user_login ) .'" href="'. get_author_posts_url($auth->ID) .'">'. $auth->data->display_name .'</a></li>';
								}
							}
							$output .= '<li class="close"><a href="#"><i class="icon-cancel"></i></a></li>';
						$output .= '</ul>';
	
					$output .= '</div>';
					
				$output .= '</div>'."\n";
			}
			
			
			// Echo | Main Content
			$output .= '<div class="blog_wrapper isotope_wrapper clearfix">';
			
				$output .= '<div class="posts_group lm_wrapper col-'. $columns .' '. $classes .'">';

					$images_only = false;
					if( $load_more || $images ){
						$images_only = 'images_only';
					}

					$output .= mfn_content_post( $query_blog, $style ,$images_only );
										
				$output .= '</div>';
	
				if( $pagination ) $output .= mfn_pagination( $query_blog, $load_more );
				
			$output .= '</div>'."\n";
		
		
		$output .= '</div>'."\n";
		
		
		wp_reset_postdata();

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Blog Slider [blog_slider]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_blog_slider' ) )
{
	function sc_blog_slider( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title'				=> '',
			'count'				=> 5,
			'category'			=> '',
			'category_multi'	=> '',
			'more'				=> '',
			'style'				=> '',
			'navigation'		=> '',
		), $attr));

		$translate['readmore'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-readmore','Read more') : __('Read more','betheme');
		
		// classes
		$classes = '';
		if( ! $more )		$classes .= ' hide-more';
		if( $style )		$classes .= ' '. $style;
		if( $navigation )	$classes .= ' '. $navigation;
		
		$args = array(
			'posts_per_page'		=> intval($count),
			'no_found_rows'			=> 1,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 0,
		);
		
		// private
		if( is_user_logged_in() ){
			$args['post_status'] = array('publish','private');
		}
		
		// categories
		if( $category_multi ){
			$args['category_name'] = trim( $category_multi );
		} elseif( $category ){
			$args['category_name'] = $category;
		}

		$query_blog = new WP_Query( $args );

		$output = '<div class="blog_slider clearfix '. $classes .'" data-count="'. $query_blog->post_count .'">';
		
			$output .= '<div class="blog_slider_header">';		
				if( $title ) $output .= '<h4 class="title">'. $title .'</h4>';	
			$output .= '</div>';
			
			$output .= '<ul class="blog_slider_ul">';				
				while ( $query_blog->have_posts() ){
					$query_blog->the_post();
	
					$output .= '<li class="'. implode(' ',get_post_class()).'">';
						$output .= '<div class="item_wrapper">';
					
							if( get_post_format() == 'quote'){
								$output .= '<blockquote>';
									$output .= '<a href="'. get_permalink() .'">';
										$output .= get_the_title();
									$output .= '</a>';
								$output .= '</blockquote>';
							} else {
								$output .= '<div class="image_frame scale-with-grid">';
									$output .= '<div class="image_wrapper">';
										$output .= '<a href="'. get_permalink() .'">';
											$output .= get_the_post_thumbnail( get_the_ID(), 'blog-portfolio', array('class'=>'scale-with-grid' ) );
										$output .= '</a>';
									$output .= '</div>';
								$output .= '</div>';	
							}
							
							$output .= '<div class="date_label">'. get_the_date() .'</div>';
							
							$output .= '<div class="desc">';
								if( get_post_format() != 'quote') $output .= '<h4><a href="'. get_permalink() .'">'. get_the_title() .'</a></h4>';
								$output .= '<hr class="hr_color" />';
								$output .= '<a href="'. get_permalink() .'" class="button button_left button_js"><span class="button_icon"><i class="icon-layout"></i></span><span class="button_label">'. $translate['readmore'] .'</span></a>';
							$output .= '</div>';
							
						$output .= '</div>';
					$output .= '</li>';
				}
				wp_reset_postdata();					
			$output .= '</ul>';
			
			$output .= '<div class="slider_pager slider_pagination"></div>';

		$output .= '</div>'."\n";
		
		wp_reset_postdata();

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Blog News [blog_news]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_blog_news' ) )
{
	function sc_blog_news( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title'				=> '',
			'count'				=> 5,
			'style'				=> '',
			'category'			=> '',
			'category_multi'	=> '',
			'excerpt'			=> '',
			'link'				=> '',
			'link_title'		=> '',
		), $attr));
		
		$args = array(
			'posts_per_page'		=> intval($count),
			'no_found_rows'			=> 1,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 0,
		);
		
		// private
		if( is_user_logged_in() ){
			$args['post_status'] = array('publish','private');
		}
		
		// categories
		if( $category_multi ){
			$args['category_name'] = trim( $category_multi );
		} elseif( $category ){
			$args['category_name'] = $category;
		}
		
		// featured first
		if( $style == 'featured' ){
			$first = true;
		} else {
			$first = false;
		}

		$query_blog = new WP_Query( $args );
		
		$output = '<div class="Latest_news '. esc_attr( $style ) .'">';
			if( $title ) $output .= '<h3 class="title">'. $title .'</h3>';
			
			$output .= '<ul class="ul-first">';
				
				while( $query_blog->have_posts() ){
					$query_blog->the_post();
			
					$output .= '<li class="'. implode( ' ', get_post_class() ).'">';
					
						$output .= '<div class="photo">';
							$output .= '<a href="'. get_permalink() .'">';
								$output .= get_the_post_thumbnail( get_the_ID(), 'blog-portfolio', array('class'=>'scale-with-grid' ) );
							$output .= '</a>';
						$output .= '</div>';
						
						$output .= '<div class="desc">';
						
							if( $first ){
								$output .= '<h4><a href="'. get_permalink() .'">'. get_the_title() .'</a></h4>';
							} else {
								$output .= '<h5><a href="'. get_permalink() .'">'. get_the_title() .'</a></h5>';
							}
	
							$output .= '<div class="desc_footer">';
								$output .= '<span class="date"><i class="icon-clock"></i> '. get_the_date() .'</span>';
								if( comments_open() ) $output .= '<i class="icon-comment-empty-fa"></i> <a href="'. get_comments_link() .'" class="post-comments">'. get_comments_number() .'</a>';
								$output .= '<div class="button-love">'. mfn_love() .'</div>';
							$output .= '</div>';
							
							if( $excerpt == '1' || ( $first && $excerpt == 'featured' ) ) $output .= '<div class="post-excerpt">'. get_the_excerpt() .'</div>';
							
						$output .= '</div>';
						
					$output .= '</li>';
					
					if( $first ){
						
						$output .= '</ul>';			
						$output .= '<ul class="ul-second">';
					
						$first = false;
					}
			
				}
				
				wp_reset_postdata();
			$output .= '</ul>';
			
			if( $link ) $output .= '<a class="button button_js" href="'. $link .'"><span class="button_icon"><i class="icon-layout"></i></span><span class="button_label">'. $link_title .'</span></a>';
			
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Blog Teaser [blog_teaser]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_blog_teaser' ) )
{
	function sc_blog_teaser( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title'				=> '',		
			'title_tag'			=> 'h3',

			'category'			=> '',
			'category_multi'	=> '',
			
// 			'link'				=> '',
// 			'link_title'		=> '',
			'margin'			=> '',
		), $attr));
		
		$args = array(
			'posts_per_page'		=> 3,
			'no_found_rows'			=> 1,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 0,
		);
		
		$translate['published'] = mfn_opts_get('translate') ? mfn_opts_get('translate-published','Published by') : __('Published by','betheme');
		$translate['at'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-at','at') : __('at','betheme');
		
		// title tag
		$title_tag = intval( str_replace( 'h', '', trim( $title_tag ) ) );
		
		// class
		$class = '';
		if( ! $margin ){
			$class .= 'margin-no';
		}
		
		// private
		if( is_user_logged_in() ){
			$args['post_status'] = array('publish','private');
		}
		
		// categories
		if( $category_multi ){
			$args['category_name'] = trim( $category_multi );
		} elseif( $category ){
			$args['category_name'] = $category;
		}

		$query_blog = new WP_Query( $args );
		
		$output = '<div class="blog-teaser '. esc_attr( $class ) .'">';
		
			if( $title ) $output .= '<h3 class="title">'. $title .'</h3>';
		
			$output .= '<ul class="teaser-wrapper">';

				$first = true;
				
				while( $query_blog->have_posts() ){
					$query_blog->the_post();
					
					$output .= '<li class="'. implode( ' ', get_post_class() ).'">';
						
						$output .= '<div class="photo-wrapper scale-with-grid">';
							$output .= get_the_post_thumbnail( get_the_ID(), 'blog-portfolio', array( 'class' => 'scale-with-grid' ) );
						$output .= '</div>';

						$output .= '<div class="desc-wrapper">';
							$output .= '<div class="desc">';
								
								if( mfn_opts_get( 'blog-meta' ) ){
									$output .= '<div class="post-meta clearfix">';
											
										$output .= '<span class="author">';
											$output .= '<span class="label">'. $translate['published'] .' </span>';
											$output .= '<i class="icon-user"></i> ';
											$output .= '<a href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ) .'">'. get_the_author_meta( 'display_name' ) .'</a>';
										$output .= '</span> ';
											
										$output .= '<span class="date">';
											$output .= '<span class="label">'. $translate['at'] .' </span>';
											$output .= '<i class="icon-clock"></i> ';
											$output .= '<span class="post-date">'. get_the_date() .'</span>';
										$output .= '</span>';
		
										// .post-comments | Style == Masonry Tiles
										if( comments_open() && mfn_opts_get( 'blog-comments' ) ){
											$output .= '<span class="comments">';
												$output .= '<i class="icon-comment-empty-fa"></i> <a href="'. get_comments_link() .'" class="post-comments">'. get_comments_number() .'</a>';
											$output .= '</span>';
										}
										
									$output .= '</div>';
								}

								$output .= '<div class="post-title">';
									$output .= '<h'. $title_tag .'><a href="'. get_permalink() .'">'. get_the_title() .'</a></h'. $title_tag .'>';
								$output .= '</div>';
						
							$output .= '</div>';
						$output .= '</div>';

					$output .= '</li>';
					
					if( $first ){
						$title_tag++;
						$first = false;
					}
					
				}
				wp_reset_postdata();
			
			$output .= '</ul>';

		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Shop Slider [shop_slider]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_shop_slider' ) )
{
	function sc_shop_slider( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title'			=> '',
			'count'			=> 5,
			'show'			=> '',
			'category'		=> '',
			'orderby' 		=> 'date',
			'order' 		=> 'DESC',
		), $attr));

		$args = array(
			'post_type' 			=> 'product',
			'posts_per_page' 		=> intval( $count ),
			'paged' 				=> -1,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'ignore_sticky_posts'	=> 1
		);

		// show
		if( $show == 'featured' ){
			
			// featured ------------------------------
			$args['meta_key'] 		= '_featured';
			$args['meta_value'] 	= 'yes';
			
		} elseif( $show == 'onsale' ){

			// onsale --------------------------------
			/*
			$args['meta_query'] = array(
				array(
					'key'           => '_sale_price',
					'value'         => 0,
					'compare'       => '>',
					'type'          => 'numeric'
				),
			);
			*/
			
			$args['post__in'] =  array_merge( array( 0 ), wc_get_product_ids_on_sale() );
			
		} elseif( $show == 'best-selling' ){
			
			// best-selling --------------------------
			$args['meta_key'] 		= 'total_sales';
			$args['orderby'] 		= 'meta_value_num';
			
		}
		
		// category
		if( $category ) $args['product_cat'] = $category;

		$query_shop = new WP_Query();
		$query_shop->query( $args );
		
		$output = '<div class="shop_slider">';
		
			$output .= '<div class="blog_slider_header">';
			
				if( $title ) $output .= '<h4 class="title">'. $title .'</h4>';
				
			$output .= '</div>';
				
			$output .= '<ul class="shop_slider_ul">';				
				while ( $query_shop->have_posts() ){
					$query_shop->the_post();
					global $product;
					
					$output .= '<li class="'. implode(' ',get_post_class()).'">';
						$output .= '<div class="item_wrapper">';
		
							if( mfn_opts_get( 'shop-images' ) == 'secondary') {
								
								$output .= '<div class="hover_box hover_box_product" ontouchstart="this.classList.toggle(\'hover\');">';
									$output .= '<a href="'. get_the_permalink() .'">';
										$output .= '<div class="hover_box_wrapper">';
											
											$output .= get_the_post_thumbnail( null, 'shop_catalog', array('class'=>'visible_photo scale-with-grid' ) );
											
											if ( $attachment_ids = $product->get_gallery_attachment_ids() ) {
												$secondary_image_id = $attachment_ids['0'];
												$output .= wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'hidden_photo scale-with-grid' ) );
											}
										
										$output .= '</div>';
									$output .= '</a>';
									if ($product->is_on_sale()) $output .= '<span class="onsale"><i class="icon-star"></i></span>';
								$output .= '</div>';
								
							} else {
						
								$output .= '<div class="image_frame scale-with-grid product-loop-thumb">';
									$output .= '<div class="image_wrapper">';
									
										$output .= '<a href="'. get_the_permalink() .'">';
											$output .= '<div class="mask"></div>';
											$output .= get_the_post_thumbnail( null, 'shop_catalog', array('class'=>'scale-with-grid' ) );
										$output .= '</a>';
										
										$output .= '<div class="image_links">';
											$output .= '<a class="link" href="'. get_the_permalink() .'"><i class="icon-link"></i></a>';
										$output .= '</div>';
										
									$output .= '</div>';
									if ($product->is_on_sale()) $output .= '<span class="onsale"><i class="icon-star"></i></span>';
								$output .= '</div>';
	
							}
							
							$output .= '<div class="desc">';
								$output .= '<h4><a href="'. get_the_permalink() .'">'. get_the_title() .'</a></h4>';
								if ( $price_html = $product->get_price_html() ) $output .= '<span class="price">'. $price_html .'</span>';
							$output .= '</div>';
					
						$output .= '</div>';
					$output .= '</li>';
				}
				wp_reset_postdata();					
			$output .= '</ul>';
			
			$output .= '<div class="slider_pager slider_pagination"></div>';

		$output .= '</div>'."\n";
		
		wp_reset_postdata();

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Contact Box [contact_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_contact_box' ) )
{
	function sc_contact_box( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title'			=> '',
			'address' 		=> '',
			'telephone'		=> '',
			'telephone_2'	=> '',
			'fax'			=> '',
			'email' 		=> '',
			'www' 			=> '',
			'image' 		=> '',
			'animate' 		=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// background
		if( $image ) $image = 'style="background-image:url('. $image .');"';
		
		$output = '';
		if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
			$output .= '<div class="get_in_touch" '. $image .'>';

				if( $title ) $output .= '<h3>'. $title .'</h3>';
				$output .= '<div class="get_in_touch_wrapper">';
					$output .= '<ul>';
						if( $address ){
							$output .= '<li class="address">';
								$output .= '<span class="icon"><i class="icon-location"></i></span>';
								$output .= '<span class="address_wrapper">'. $address .'</span>';
							$output .= '</li>';
						}
						if( $telephone ){
							$output .= '<li class="phone phone-1">';
								$output .= '<span class="icon"><i class="icon-phone"></i></span>';
								$output .= '<p><a href="tel:'. str_replace(' ', '', $telephone) .'">'. $telephone .'</a></p>';
							$output .= '</li>';
						}
						if( $telephone_2 ){
							$output .= '<li class="phone phone-2">';
								$output .= '<span class="icon"><i class="icon-phone"></i></span>';
								$output .= '<p><a href="tel:'. str_replace(' ', '', $telephone_2) .'">'. $telephone_2 .'</a></p>';
							$output .= '</li>';
						}
						if( $fax ){
							$output .= '<li class="phone fax">';
								$output .= '<span class="icon"><i class="icon-print"></i></span>';
								$output .= '<p><a href="fax:'. str_replace(' ', '', $fax) .'">'. $fax .'</a></p>';
							$output .= '</li>';
						}
						if( $email ){
							$output .= '<li class="mail">';
								$output .= '<span class="icon"><i class="icon-mail"></i></span>';
								$output .= '<p><a href="mailto:'. $email .'">'. $email .'</a></p>';
							$output .= '</li>';
						}
						if( $www ){
							
							if( strpos( $www, 'http' ) === 0 ){
								$url = $www;
								$www = str_replace( 'http://', '', $www );
								$www = str_replace( 'https://', '', $www );
							} else {
								$url = 'http'. mfn_ssl() .'://'. $www;
							}
							
							$output .= '<li class="www">';
								$output .= '<span class="icon"><i class="icon-link"></i></span>';
								$output .= '<p><a target="_blank" href="'. $url .'">'. $www .'</a></p>';
							$output .= '</li>';
						}
					$output .= '</ul>';
				$output .= '</div>';				
			
			$output .= '</div>'."\n";
		if( $animate ) $output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Popup [popup][/popup]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_popup' ) )
{
	function sc_popup( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title'			=> '',
			'padding'		=> '',
			'button' 		=> '',
			'uid'			=> 'popup-'. uniqid(),
		), $attr));

		// padding
		if( $padding ){
			$padding = 'style="padding:'. $padding .'px;"';
		} else {
			$padding = false;
		}
		
		$output = '';

		if( $button ){
			$output .= '<a href="#'. $uid .'" rel="prettyphoto" class="popup-link button button_js"><span class="button_label">'. $title .'</span></a>';
		} else {
			$output .= '<a href="#'. $uid .'" rel="prettyphoto" class="popup-link">'. $title .'</a>';
		}
		
		$output .= '<div id="'. $uid .'" class="popup-content">';
			$output .= '<div class="popup-inner" '. $padding .'>'. do_shortcode($content) .'</div>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Info Box [info_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_info_box' ) )
{
	function sc_info_box( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title'			=> '',
			'image' 		=> '',
			'animate' 		=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// background
		if( $image ) $image = 'style="background-image:url('. $image .');"';
		
		$output = '';
		if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
			$output .= '<div class="infobox" '. $image .'>';

				if( $title ) $output .= '<h3>'. $title .'</h3>';
				$output .= '<div class="infobox_wrapper">';
					$output .= do_shortcode($content);
				$output .= '</div>';
					
			$output .= '</div>'."\n";
		if( $animate ) $output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Opening hours [opening_hours]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_opening_hours' ) )
{
	function sc_opening_hours( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title'			=> '',
			'image' 		=> '',
			'animate' 		=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// background
		if( $image ) $image = 'style="background-image:url('. $image .');"';
		
		$output = '';
		if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
			$output .= '<div class="opening_hours" '. $image .'>';
			
		
				if( $title ) $output .= '<h3>'. $title .'</h3>';
				$output .= '<div class="opening_hours_wrapper">';
					$output .= do_shortcode($content);
				$output .= '</div>';

			$output .= '</div>'."\n";
		if( $animate ) $output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Divider [divider]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_divider' ) )
{
	function sc_divider( $attr, $content = null )
	{
	    extract(shortcode_atts(array(
		    'height' 		=> 0,
		    'style' 		=> '',		// default, dots, zigzag
		    'line'			=> '',		// default, narrow, wide, 0 = no_line
		    'themecolor'	=> '',
	    ), $attr));
	    
	    // classes
	    $class = '';
	    if( $themecolor ) 	$class .= ' hr_color';
	    
		// height
		if( $height ){
			$inlinecss = 'style="margin: 0 auto '. intval( $height ) .'px;"';
		} else {
			$inlinecss = '';
		}
	    
	    switch( $style ){
	    	case 'dots':
	    		$output = '<div class="hr_dots" '. $inlinecss .'><span></span><span></span><span></span></div>'."\n";
	    		break;
	    	case 'zigzag':
	    		$output = '<div class="hr_zigzag" '. $inlinecss .'><i class="icon-down-open"></i><i class="icon-down-open"></i><i class="icon-down-open"></i></div>'."\n";
	    		break;
	    	default:
	    		if( $line == 'narrow' ){
	    			$output = '<hr class="hr_narrow '. $class .'" '. $inlinecss .'/>'."\n";
	    		} elseif( $line == 'wide' ) {
	    			$output = '<div class="hr_wide '. $class .'" '. $inlinecss .'><hr /></div>'."\n";
	    		} elseif( $line ) {
	    			$output = '<hr class="'. $class .'" '. $inlinecss .'/>'."\n";
	    		} else {
	    			$output = '<hr class="no_line" '. $inlinecss .'/>'."\n";
	    		}
	    }
	    
	    return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Fancy Divider [fancy_divider]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_fancy_divider' ) )
{
	function sc_fancy_divider( $attr, $content = null )
	{
	    extract(shortcode_atts(array(
		    'style' 		=> 'stamp',
		    'color_top' 	=> '',
		    'color_bottom' 	=> '',
	    ), $attr));
	    
	    $output = '<div class="fancy-divider">';
	    
		    switch( $style ){
		    	
		    	case 'circle up':
		    		$output .= '<svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100%" version="1.1" xmlns="https://www.w3.org/2000/svg" style="background: '. $color_top .';">';
		    			$output .= '<path d="M0 100 C50 0 50 0 100 100 Z" style="fill: '. $color_bottom .'; stroke: '. $color_bottom .';">';
		    		$output .= '</svg>';
		    		break;
		    	
		    	case 'circle down':
		    		$output .= '<svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100%" version="1.1" xmlns="https://www.w3.org/2000/svg" style="background: '. $color_bottom .';">';
		    			$output .= '<path d="M0 0 C50 100 50 100 100 0 Z" style="fill: '. $color_top .'; stroke: '. $color_top .';">';
		    		$output .= '</svg>';
		    		break;
		    		
		    	case 'curve up':
		    		$output .= '<svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100%" version="1.1" xmlns="https://www.w3.org/2000/svg" style="background: '. $color_top .';">';
		    			$output .= '<path d="M0 100 C 20 0 50 0 100 100 Z" style="fill: '. $color_bottom .'; stroke: '. $color_bottom .';">';
		    		$output .= '</svg>';
		    		break;
		    	
		    	case 'curve down':
		    		$output .= '<svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100%" version="1.1" xmlns="https://www.w3.org/2000/svg" style="background: '. $color_bottom .';">';
		    			$output .= '<path d="M0 0 C 50 100 80 100 100 0 Z" style="fill: '. $color_top .'; stroke: '. $color_top .';">';
		    		$output .= '</svg>';
		    		break;
		    	
		    	case 'triangle up':
		    		$output .= '<svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100%" version="1.1" xmlns="https://www.w3.org/2000/svg" style="background: '. $color_top .';">';
		    			$output .= '<path d="M0 100 L50 2 L100 100 Z" style="fill: '. $color_bottom .'; stroke: '. $color_bottom .';">';
		    		$output .= '</svg>';
		    		break;
		    		
		    	case 'triangle down':
		    		$output .= '<svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100%" version="1.1" xmlns="https://www.w3.org/2000/svg" style="background: '. $color_bottom .';">';
		    			$output .= '<path d="M0 0 L50 100 L100 0 Z" style="fill: '. $color_top .'; stroke: '. $color_top .';">';
		    		$output .= '</svg>';
		    		break;
		    		
		    	default:
		    		$output .= '<svg preserveAspectRatio="none" viewBox="0 0 100 102" height="100" width="100%" version="1.1" xmlns="https://www.w3.org/2000/svg" style="background: '. $color_bottom .';">';
		    			$output .= '<path d="M0 0 Q 2.5 40 5 0 Q 7.5 40 10 0Q 12.5 40 15 0Q 17.5 40 20 0Q 22.5 40 25 0Q 27.5 40 30 0Q 32.5 40 35 0Q 37.5 40 40 0Q 42.5 40 45 0Q 47.5 40 50 0 Q 52.5 40 55 0Q 57.5 40 60 0Q 62.5 40 65 0Q 67.5 40 70 0Q 72.5 40 75 0Q 77.5 40 80 0Q 82.5 40 85 0Q 87.5 40 90 0Q 92.5 40 95 0Q 97.5 40 100 0 Z" style="fill: '. $color_top .'; stroke: '. $color_top .';">';
		    		$output .= '</svg>';
		    		
		    }
	    
	    $output .= '</div>';
	    
	    return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Google Font [google_font]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_google_font' ) )
{
	function sc_google_font( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'font' 				=> '',
			'size' 				=> '25',
			'weight'			=> '400',
			'italic'			=> '',
			'letter_spacing' 	=> '',
			'color'				=> '',
			'subset' 			=> '',
		), $attr));
		
		// style
		$style 		= array();
		$style[] 	= "font-family:'". $font ."',Arial,Tahoma,sans-serif;";
		$style[] 	= "font-size:". $size ."px;";
		$style[] 	= "line-height:". $size ."px;";
		$style[] 	= "font-weight:". $weight .";";
		$style[] 	= "letter-spacing:". $letter_spacing ."px;";
		if( $color ) $style[] = "color:". $color .";";

		// italic
		if( $italic ){
			$style[] = "font-style:italic;";
			$weight = $weight .'italic';
		}
		
		$style 		= implode( '', $style );

		// subset
		if( $subset ){
			$subset	= '&amp;subset='. str_replace( ' ', '', $subset );
		} else {
			$subset = false;	
		}	
		
		// slug
		$font_slug	= str_replace( ' ', '+', $font );
		wp_enqueue_style( $font_slug, 'http'. mfn_ssl() .'://fonts.googleapis.com/css?family='. $font_slug .':'. $weight . $subset );

// 		$output = '<link type="text/css" rel="stylesheet" href="http'. mfn_ssl() .'://fonts.googleapis.com/css?family='. $font_slug .':'. $weight . $subset .'">'."\n";

		$output = '<div class="google_font" style="'. $style .'">'. do_shortcode( $content ) .'</div>'."\n";
		
	    return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Sidebar Widget [sidebar_widget]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_sidebar_widget' ) )
{
	function sc_sidebar_widget( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'sidebar' 		=> '',
		), $attr));
		
		$output = '';
		
		if( $sidebar !== '' && $sidebar !== false ){
			
			$sidebars = mfn_opts_get( 'sidebars' );
			$sidebar = $sidebars[$sidebar];
			
			ob_start();
			dynamic_sidebar( $sidebar );
			$output = ob_get_clean();
		}
		
	    return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Pricing Item [pricing_item] [/pricing_item]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_pricing_item' ) )
{
	function sc_pricing_item( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image'			=> '',
			'title'			=> '',
			'currency' 		=> '',
			'currency_pos' 	=> '',
			'price' 		=> '',
			'period' 		=> '',
			'subtitle' 		=> '',
			'link_title'	=> '',
			'link' 			=> '',
			'target' 		=> '',
			'icon' 			=> '',
			'featured' 		=> '',
			'style' 		=> 'box',
			'animate' 		=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		// classes
		$classes = '';
		if( $currency_pos ) $classes .= ' cp-'. $currency_pos;
		if( $featured ) 	$classes .= ' pricing-box-featured';
		if( $style ) 		$classes .= ' pricing-box-'. $style;
	
		$output = '<div class="pricing-box '. $classes .'">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
			
				$output .= '<div class="plan-header">';
				
					if( $image ){
						$output .= '<div class="image">';
							$output .= '<img src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
						$output .= '</div>';
					}
				
					if( $title ) $output .= '<h2>'. $title .'</h2>';	
					if( $price ){ 
						$output .= '<div class="price">';
							if( $currency_pos != 'right' ) $output .= '<sup class="currency">'. $currency .'</sup>';
							$output .= '<span>'. $price .'</span>';
							if( $currency_pos == 'right' ) $output .= '<sup class="currency">'. $currency .'</sup>';
							$output .= '<sup class="period">'. $period .'</sup>';
						$output .= '</div>';
						$output .= '<hr class="hr_color" />';
					}
					if( $subtitle ) $output .= '<p class="subtitle"><big>'. $subtitle .'</big></p>';
				$output .= '</div>';
				
				if( $content ){
					$output .= '<div class="plan-inside">';
						$output .= do_shortcode($content);
					$output .= '</div>';
				}
				
				if( $link ){
					
					// button icon
					if( $icon ){
						$icon = '<span class="button_icon"><i class="'. $icon .'"></i></span>';
						$icon_class = 'button_left';
					} else {
						$icon = false;
						$icon_class = false;
					}
					
					$output .= '<div class="plan-footer">';
						$output .= '<a href="'. $link .'" class="button button_theme button_js '. $icon_class .'" '. $target .'>'. $icon .'<span class="button_label">'. $link_title .'</span></a>';
					$output .= '</div>';
				}
			
			if( $animate ) $output .= '</div>';
		$output .= '</div>'."\n";
			
	    return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Call to Action [call_to_action] [/call_to_action]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_call_to_action' ) )
{
	function sc_call_to_action( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title' 		=> '',
			'icon' 			=> '',
			'link' 			=> '',
			'button_title'	=> '',
			'class' 		=> '',
			'target' 		=> '',
			'animate' 		=> '',
		), $attr));
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		// FIX | prettyphoto
		if( strpos( $class, 'prettyphoto' ) !== false ){
			$class 	= str_replace( 'prettyphoto', '', $class );
			$rel 	= 'rel="prettyphoto"';
		} else {
			$rel 	= false;
		}
		
		$output = '<div class="call_to_action">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
			
				$output .= '<div class="call_to_action_wrapper">';
				
					$output .= '<div class="call_left">';
						$output .= '<h3>'. $title .'</h3>';
					$output .= '</div>';
					
					$output .= '<div class="call_center">';
					
						if( $button_title ){
							// Button
							if( $link ) $output .= '<a href="'. $link .'" class="button button_js '. $class .'" '. $rel .' '. $target .'>';
								if( $icon ) $output .= '<span class="button_icon"><i class="'. $icon .'"></i></span>';
								$output .= '<span class="button_label">'. $button_title .'</span>';
							if( $link ) $output .= '</a>';
						} else {
							// Big Icon Link
							if( $link ) $output .= '<a href="'. $link .'" class="'. $class .'" '. $rel .' '. $target .'>';
								$output .= '<span class="icon_wrapper"><i class="'. $icon .'"></i></span>';
							if( $link ) $output .= '</a>';
						}
	
					$output .= '</div>';
					
					$output .= '<div class="call_right">';
						$output .= '<div class="desc">'. do_shortcode($content) .'</div>';
					$output .= '</div>';
					
				$output .= '</div>';
			
			if( $animate ) $output .= '</div>';
		$output .= '</div>'."\n";
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Chart [chart]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_chart' ) )
{
	function sc_chart( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title' 		=> '',
			'percent' 		=> '',
			'label' 		=> '',
			'icon'	 		=> '',
			'image'	 		=> '',
			'line_width'	=> '',	
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// color
		if( $_GET && key_exists( 'mfn-c', $_GET ) ){
			$color = '#D69942';
		} else {
			$color =  mfn_opts_get( 'color-counter', '#2991D6' );
		}
		
		// line width
		if( $line_width ) $line_width = 'data-line-width="'. intval( $line_width ) .'"';
		
		$output = '<div class="chart_box">';
			$output .= '<div class="chart" data-percent="'. intval( $percent ) .'" data-bar-color="'.  $color .'" '. $line_width .'>';
				if( $image ){
					$output .= '<div class="image"><img class="scale-with-grid" src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/></div>';
				} elseif( $icon ){
					$output .= '<div class="icon"><i class="'. $icon .'"></i></div>';
				} else {
					$output .= '<div class="num">'. $label .'</div>';
				}
			$output .= '</div>';
			$output .= '<p><big>'. $title .'</big></p>';
		$output .= '</div>'."\n";
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Countdown [countdown]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_countdown' ) )
{
	function sc_countdown( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'date' 			=> '12/30/2016 12:00:00',
			'timezone'	 	=> '0',
		), $attr));
		
		$translate['days'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-days','days') : __('days','betheme');
		$translate['hours'] 	= mfn_opts_get('translate') ? mfn_opts_get('translate-hours','hours') : __('hours','betheme');
		$translate['minutes'] 	= mfn_opts_get('translate') ? mfn_opts_get('translate-minutes','minutes') : __('minutes','betheme');
		$translate['seconds']	= mfn_opts_get('translate') ? mfn_opts_get('translate-seconds','seconds') : __('seconds','betheme');
		
		$output = '<div class="downcount clearfix" data-date="'. $date .'" data-offset="'. $timezone .'">';
		
			$output .= '<div class="column one-fourth column_quick_fact">';
				$output .= '<div class="quick_fact">';
					$output .= '<div data-anim-type="zoomIn" class="animate zoomIn">';
						$output .= '<div class="number-wrapper">';
							$output .= '<div class="number days">00</div>';
						$output .= '</div>';
						$output .= '<h3 class="title">'. $translate['days'] .'</h3>';
						$output .= '<hr class="hr_narrow">';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
			
			$output .= '<div class="column one-fourth column_quick_fact">';
				$output .= '<div class="quick_fact">';
					$output .= '<div data-anim-type="zoomIn" class="animate zoomIn">';
						$output .= '<div class="number-wrapper">';
							$output .= '<div class="number hours">00</div>';
						$output .= '</div>';
						$output .= '<h3 class="title">'. $translate['hours'] .'</h3>';
						$output .= '<hr class="hr_narrow">';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
			
			$output .= '<div class="column one-fourth column_quick_fact">';
				$output .= '<div class="quick_fact">';
					$output .= '<div data-anim-type="zoomIn" class="animate zoomIn">';
						$output .= '<div class="number-wrapper">';
							$output .= '<div class="number minutes">00</div>';
						$output .= '</div>';
						$output .= '<h3 class="title">'. $translate['minutes'] .'</h3>';
						$output .= '<hr class="hr_narrow">';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
			
			$output .= '<div class="column one-fourth column_quick_fact">';
				$output .= '<div class="quick_fact">';
					$output .= '<div data-anim-type="zoomIn" class="animate zoomIn">';
						$output .= '<div class="number-wrapper">';
							$output .= '<div class="number seconds">00</div>';
						$output .= '</div>';
						$output .= '<h3 class="title">'. $translate['seconds'] .'</h3>';
						$output .= '<hr class="hr_narrow">';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
			
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Counter [counter]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_counter' ) )
{
	function sc_counter( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'icon' 			=> '',
			'color' 		=> '',
			'image' 		=> '',
			'number' 		=> '',
			'prefix' 		=> '',
			'label' 		=> '',
			'title' 		=> '',
			'type'	 		=> 'vertical',
			'animate'	 	=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// color
		if( $color ){
			$color = 'style="color:'. $color .';"';
		} else {
			$color = false;
		}
		
		$animate_math = mfn_opts_get('math-animations-disable') ? false : 'animate-math';
		
		$output = '<div class="counter counter_'. $type .' '. $animate_math .'">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
			
				$output .= '<div class="icon_wrapper">';
					if( $image ){
						$output .= '<img src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
					} elseif( $icon ){
						$output .= '<i class="'. $icon .'" '. $color .'></i>';
					}
				$output .= '</div>';
				
				$output .= '<div class="desc_wrapper">';
					if( $number ){
						$output .= '<div class="number-wrapper">';
							if( $prefix ) $output .= '<span class="label prefix">'. $prefix .'</span>';
							$output .= '<span class="number" data-to="'. $number .'">'. $number .'</span>';
							if( $label ) $output .= '<span class="label postfix">'. $label .'</span>';
						$output .= '</div>';
					}
					if( $title )  $output .= '<p class="title">'. $title .'</p>';
				$output .= '</div>';
			
			if( $animate ) $output .= '</div>'."\n";
		$output .= '</div>'."\n";
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Icon [icon]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_icon' ) )
{
	function sc_icon( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'type' => '',
		), $attr));
		
		$output = '<i class="'. $type .'"></i>';
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Icon Block [icon_block]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_icon_block' ) )
{
	function sc_icon_block( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'icon'	=> '',
			'align'	=> '',
			'color'	=> '',
			'size'	=> 25,
		), $attr));

		// classes
		$class = '';
		if( $align ) $class .= ' icon_'. $align;
		if( $color ){
			$color = ' color:'. $color .';';
		} else {
			$class .= ' themecolor';
		}
			
		$output = '<span class="single_icon '. $class .'">';
			$output .= '<i style="font-size: '. $size .'px; line-height: '. $size .'px; '. $color .'" class="'. $icon .'"></i>';
		$output .= '</span>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Image [image]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_image' ) )
{
	function sc_image( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'src'			=> '',
			'width'			=> '',
			'height'		=> '',
			'border'		=> '',
			'alt'			=> '',
			'caption'		=> '',
			'margin'		=> '',
			'margin_top'	=> '',	// alias for: margin
			'margin_bottom'	=> '',
			'align'			=> 'none',
			'stretch'		=> '',
			'link'			=> '',
			'link_image'	=> '',
			'target'		=> '',
			'hover'			=> '',
			'greyscale'		=> '',
			'animate'		=> '',
		), $attr));	
		
		// margin
		if( $margin_top ) $margin = $margin_top;
		
		if( $margin || $margin_bottom ){
			$margin_tmp = '';
			if( $margin ) $margin_tmp .= 'margin-top:'. intval( $margin ) .'px;';
			if( $margin_bottom ) $margin_tmp .= 'margin-bottom:'. intval( $margin_bottom ) .'px;';
			$margin = 'style="'. $margin_tmp .'"';
		} else {
			$margin = false;
		}
		
		
		// target
		if( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		
		// double link
		if( $link & $link_image ){
			$double_link = 'double';
		} else {
			$double_link = false;
		}
			
		
		// DIV image_frame | classes ----------------------
		$class_div 	= '';
		
		// align
		if( $align ) $class_div .= ' align'. $align;
		
		// stretch
		if( $stretch == 'ultrawide' ){
			$class_div .= ' stretch-ultrawide';
		} elseif( $stretch ){
			$class_div .= ' stretch';
		}
		
		// border
		if( $border ){
			$class_div .= ' has_border';
		} else {
			$class_div .= ' no_border';
		}
		
		// greyscale
		if( $greyscale ) $class_div .= ' greyscale';
		
		// hover
		if( $hover ) $class_div .= ' hover-disable';
		
		
		// width x height, alt ----------------------------
		
		// deprecated since 13.1
		if( $width ) $class_div .= ' inline-block';

		if( ! $width ) 	$width 	= mfn_get_attachment_data( $src, 'width' );
		if( ! $height ) $height = mfn_get_attachment_data( $src, 'height' );
				
		if( $width )	$width = 'width="'. $width .'"';
		if( $height )	$height = 'height="'. $height .'"';
		
		if( ! $alt )	$alt = mfn_get_attachment_data( $src, 'alt' );
		
		
		// prettyPhoto ------------------------------------

		// link_all
		$link_all = $link;
		
		if( $link_all ){
			$rel 		= false;
		} else {
			$link_all 	= $link_image;
			$rel 		= 'rel="prettyphoto"';
			$target 	= false;
		}

		$output = '';
		if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
		
			if( $link || $link_image ) {

				$output .= '<div class="image_frame image_item scale-with-grid'. $class_div .'" '. $margin .'>';
					$output .= '<div class="image_wrapper">';
						$output .= '<a href="'. $link_all .'" '. $rel .' '. $target .'>';
							$output .= '<div class="mask"></div>';
							$output .= '<img class="scale-with-grid" src="'. $src .'" alt="'. $alt .'" '.$width.' '.$height.' />';
						$output .= '</a>';
						$output .= '<div class="image_links '. $double_link .'">';
							if( $link_image ) $output .= '<a href="'. $link_image .'" class="zoom" rel="prettyphoto"><i class="icon-search"></i></a>';
							if( $link ) $output .= '<a href="'. $link .'" class="link" '. $target .'><i class="icon-link"></i></a>';
						$output .= '</div>';
					$output .= '</div>';
					if( $caption ) $output .= '<p class="wp-caption-text">'. $caption .'</p>';					
				$output .= '</div>'."\n";

			} else {
				
				$output .= '<div class="image_frame image_item no_link scale-with-grid'. $class_div .'" '. $margin .'>';
					$output .= '<div class="image_wrapper">';
						$output .= '<img class="scale-with-grid" src="'. $src .'" alt="'. $alt .'" '.$width.' '.$height.' />';
					$output .= '</div>';
					if( $caption ) $output .= '<p class="wp-caption-text">'. $caption .'</p>';
				$output .= '</div>'."\n";
				
			}
			
		if( $animate ) $output .= '</div>'."\n";

	    return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Hover Box [hover_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_hover_box' ) )
{
	function sc_hover_box( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image'			=> '',
			'image_hover'	=> '',
			'link'			=> '',
			'target'		=> '',
		), $attr));

		// image | visual composer fix
		$image = mfn_vc_image( $image );
		$image_hover = mfn_vc_image( $image_hover );
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		$output = '<div class="hover_box">';
			if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
				$output .= '<div class="hover_box_wrapper">';
					$output .= '<img class="visible_photo scale-with-grid" src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
					$output .= '<img class="hidden_photo scale-with-grid" src="'. $image_hover .'" alt="'. mfn_get_attachment_data( $image_hover, 'alt' ) .'" width="'. mfn_get_attachment_data( $image_hover, 'width' ) .'" height="'. mfn_get_attachment_data( $image_hover, 'height' ) .'"/>';
				$output .= '</div>';
			if( $link ) $output .= '</a>';
		$output .= '</div>'."\n";
		
	    return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Hover Color [hover_color]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_hover_color' ) )
{
	function sc_hover_color( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'background'		=> '',
			'background_hover'	=> '',
			'border'			=> '',
			'border_hover'		=> '',
			'border_width'		=> '',
			'padding'			=> '',
			'link'				=> '',
			'class'				=> '',
			'target'			=> '',
			'style'				=> '',
		), $attr));

		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		// padding
		if( $padding ){
			$padding = 'style="padding:'. $padding .';"';
		} else {
			$padding = false;
		}

		// FIX | prettyphoto
		if( strpos( $class, 'prettyphoto' ) !== false ){
			$class 	= str_replace( 'prettyphoto', '', $class );
			$rel 	= 'rel="prettyphoto"';
		} else {
			$rel 	= false;
		}
		
		$output = '<div class="hover_color" style="background:'. $background_hover .';border-color:'. $border_hover .';'. esc_attr( $style ) .'" ontouchstart="this.classList.toggle(\'hover\');">';
			$output .= '<div class="hover_color_bg" style="background:'. $background .';border-color:'. $border .';border-width:'. $border_width .';">';
				if( $link ) $output .= '<a href="'. $link .'" class="'. esc_attr( $class ) .'" '. $rel .' '. $target .'>';
					$output .= '<div class="hover_color_wrapper" '. $padding .'>';
						$output .= do_shortcode($content);
					$output .= '</div>';
				if( $link ) $output .= '</a>';
			$output .= '</div>'."\n";
		$output .= '</div>'."\n";		
		
	    return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Quick Fact [quick_fact]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_quick_fact' ) )
{
	function sc_quick_fact( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'heading' 	=> '',
			'title' 	=> '',
			'number' 	=> '',
			'prefix' 	=> '',
			'label' 	=> '',
			'align' 	=> 'center',		
			'animate' 	=> '',
		), $attr));
		
		$animate_math = mfn_opts_get('math-animations-disable') ? false : 'animate-math';

		$output = '<div class="quick_fact align_'. $align .' '. $animate_math .'">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
			
				if( $heading ) $output .= '<h4 class="title">'. $heading .'</h4>';
				if( $number ){
					$output .= '<div class="number-wrapper">';
						if( $prefix ) $output .= '<span class="label prefix">'. $prefix .'</span>';
						$output .= '<span class="number" data-to="'. $number .'">'. $number .'</span>';
						if( $label ) $output .= '<span class="label postfix">'. $label .'</span>';
					$output .= '</div>';
				}
				if( $title ) $output .= '<h3 class="title">'. $title .'</h3>';
				$output .= '<hr class="hr_narrow" />';
				$output .= '<div class="desc">'. do_shortcode($content) .'</div>';
			
			if( $animate ) $output .= '</div>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Button [button]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_button' ) )
{
	function sc_button( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title' 		=> 'Button',
			'link' 			=> '',
			'target' 		=> '',
			'align' 		=> '',
			
			'icon' 			=> '',
			'icon_position' => 'left',

			'color' 		=> '',
			'font_color'	=> '',
			
			'large' 		=> '', // deprecated since Be 12.4
			'size' 			=> 2,
			'full_width' 	=> '',
			
			'class' 		=> '',
			'rel' 			=> '',
			'download' 		=> '',	
			'onclick' 		=> '',
		), $attr));
		
		// target
		if( $target == 'lightbox' ){
			$target = false;
			$rel = 'prettyphoto '. $rel; // do not change order
		} elseif( $target ){
			$target = 'target="_blank"';
		}
		
		// download
		if( $download ){
			$download = 'download="'. $download .'"';
		}
		
		// onclick
		if( $onclick ){
			$onclick = 'onclick="'. $onclick .'"';
		}
		
		// icon_position
		if( $icon_position != 'left' ){
			$icon_position = 'right';
		}
		
		// FIX | prettyphoto
		if( strpos( $class, 'prettyphoto' ) !== false ){
			$class 	= str_replace( 'prettyphoto', '', $class );
			$rel = 'prettyphoto '. $rel;
		}
		
		// class
		if( $icon )			$class .= ' button_'. $icon_position;
		if( $full_width ) 	$class .= ' button_full_width';
		if( $large ){
			$class .= ' button_large';
		} else {
			if( $size ) $class .= ' button_size_'. $size;
		}
		
		// custom color
		$style 		= '';
		$style_icon	= '';
		if( $color ){
			if( strpos($color, '#') === 0 ){
				if( mfn_opts_get('button-style') == 'stroke' ){
					// Stroke | Border
					$style .= ' border-color:'. $color .' !important;';
					$class .= ' button_stroke_custom';
				} else {
					// Default | Background
					$style .= ' background-color:'. $color .' !important;';
				}
			} else {
				$class .= ' button_'. $color;
			}
		}
		if( $font_color ){
			$style 		.= ' color:'. $font_color .';';
			$style_icon .= ' color:'. $font_color .' !important;';
		}
		if( $style ){
			$style = ' style="'. $style .'"';
		}
		if( $style_icon ){
			$style_icon = ' style="'. $style_icon .'"';
		}
		
		// rel (do not move up)
		if( $rel ){
			$rel = 'rel="'. esc_attr( $rel ) .'"';
		}
		
		// link attributes
		$attributes = $target .' '. $rel .' '. $download .' '. $onclick .' '. $style;

		$output = '';
		
		if( $align ) $output .= '<div class="button_align align_'. $align .'">';
		
			$output .= '<a class="button '. esc_attr( $class ) .' button_js" href="'. $link .'" '. $attributes .'>';
				if( $icon )	$output .= '<span class="button_icon"><i class="'. $icon .'" '. $style_icon .'></i></span>';
				if( $title ) $output .= '<span class="button_label">'. $title .'</span>';
			$output .= '</a>';
		
		if( $align ) $output .= '</div>';
		
		$output .= "\n";
	
	    return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Icon Bar [icon_bar]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_icon_bar' ) )
{
	function sc_icon_bar( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'icon' 			=> 'icon-lamp',
			'link' 			=> '',
			'target' 		=> '',
			'size' 			=> '',
			'social' 		=> '',
		), $attr));
		
		// target
		if( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		// class
		$class = '';
		if( $social ) 	$class .= ' icon_bar_'. $social;
		if( $size ) 	$class .= ' icon_bar_'. $size;
		
		$output = '<a href="'. $link .'" class="icon_bar '. $class .'" '. $target .'>';
			$output .= '<span class="t"><i class="'. $icon .'"></i>';
			$output .= '</span><span class="b"><i class="'. $icon .'"></i></span>';
		$output .= '</a>'."\n";
	
	    return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Alert [alert] [/alert]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_alert' ) )
{
	function sc_alert( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'style'		=> 'warning',
		), $attr));

		switch( $style ){
			case 'error':
				$icon = 'icon-alert';
				break;
			case 'info':
				$icon = 'icon-help';
				break;
			case 'success':
				$icon = 'icon-check';
				break;
			default:
				$icon = 'icon-lamp';
				break;
		}
			
		$output  = '<div class="alert alert_'. $style .'">';
			$output  .= '<div class="alert_icon">';
				$output .= '<i class="'. $icon .'"></i>';
			$output .= '</div>';
			$output .= '<div class="alert_wrapper">';
				$output .= do_shortcode( $content );
			$output .= '</div>';
			$output .= '<a href="#" class="close"><i class="icon-cancel"></i></a>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Idea [idea] [/idea]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_idea' ) )
{
	function sc_idea( $attr, $content = null )
	{			
		$output  = '<div class="idea_box">';
			$output  .= '<div class="icon"><i class="icon-lamp"></i></div>';
			$output  .= '<div class="desc">'. do_shortcode( $content ) .'</div>';
		$output .= '</div>'."\n";		

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Dropcap [dropcap] [/dropcap]
* --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_dropcap' ) )
{
	function sc_dropcap( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'font' 			=> '',
			'size' 			=> 1, // 1-3, or custom size in px
			'background' 	=> '',
			'color' 		=> '',			
			'circle' 		=> '',
			'transparent' 	=> '',
		), $attr));

		$class = '';
		$style = '';
		
		// font family
		if( $font ){
			$style .= "font-family:'". $font ."',Arial,Tahoma,sans-serif;";
			$font_slug = str_replace( ' ', '+', $font );
			wp_enqueue_style( $font_slug, 'http'. mfn_ssl() .'://fonts.googleapis.com/css?family='. $font_slug );
		}
 		
		// circle
		if( $circle ) $class = ' dropcap_circle';
		
		// transparent
		if( $transparent ) $class = ' transparent';

		// background
		if( $background ) $style .= 'background-color:'. $background .';';
		
		// color
		if( $color ) $style .= ' color:'. $color .';';
		
		// size
		$size = intval( $size );	
		$sizeH = $size + 15;
		
		if( $size > 3 ){
			if( $transparent ){
				$style .= ' font-size:'. $size .'px;height:'. $size .'px;line-height:'. $size .'px;width:'. $size .'px;';
			} else {
				$style .= ' font-size:'. $size .'px;height:'. $sizeH .'px;line-height:'. $sizeH .'px;width:'. $sizeH .'px;';
			}		
		} else {
			$class .= ' size-'. $size;
		}
		
		if( $style ) $style = 'style="'. $style .'"';
			
		$output  = '<span class="dropcap'. $class .'" '. $style .'>';
			$output .= do_shortcode( $content );
		$output .= '</span>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Highlight [highlight] [/highlight]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_highlight' ) )
{
	function sc_highlight( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'background' 	=> '',
			'color' 		=> '',
		), $attr));

		// style
		$style = '';
		if( $background ) $style .= 'background-color:'. $background .';';
		if( $color ) $style .= ' color:'. $color .';';
		if( $style ) $style = 'style="'. $style .'"';
							
		$output  = '<span class="highlight" '. $style .'>';
			$output .= do_shortcode($content);
		$output .= '</span>'."\n";
	
	    return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Tooltip [tooltip] [/tooltip]
* --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_tooltip' ) )
{
	function sc_tooltip( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'hint' 			=> '',
		), $attr));

		$output = '';
		if( $hint ){
			$output .= '<span class="tooltip tooltip-txt" data-tooltip="'. $hint .'">';
				$output .= do_shortcode( $content );
			$output .= '</span>'."\n";
		}

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Tooltip [tooltip_image] [/tooltip_image]
* --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_tooltip_image' ) )
{
	function sc_tooltip_image( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'hint' 			=> '',
			'image' 		=> '',
		), $attr));

		$output = '';
		if( $hint || $image ){
			$output .= '<span class="tooltip tooltip-img">';
				$output .= '<span class="tooltip-content">';
					if( $image )	$output .= '<img src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
					if( $hint )		$output .= $hint;
				$output .= '</span>';
				$output .= do_shortcode( $content );
			$output .= '</span>'."\n";
		}

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Content Link [content_link]
* --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_content_link' ) )
{
	function sc_content_link( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title' 	=> '',
			'icon' 		=> '',
			'link' 		=> '',
			'target' 	=> '',
			'class' 	=> '',
			'download' 	=> '',
		), $attr));

		// target
		if( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		// download
		if( $download ){
			$download = 'download="'. $download .'"';
		} else {
			$download = false;
		}

		$output = '<a class="content_link '. $class .'" href="'. $link .'" '. $target .' '. $download .'>';
			if( $icon )	$output .= '<span class="icon"><i class="'. $icon .'"></i></span>';
			if( $title ) $output .= '<span class="title">'. $title .'</span>';
		$output .= '</a>';
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Fancy Link [fancy_link]
* --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_fancy_link' ) )
{
	function sc_fancy_link( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title' 	=> '',
			'link' 		=> '',
			'target' 	=> '',
			'style' 	=> '1',	// 1-8
			'class' 	=> '',
			'download' 	=> '',
		), $attr));

		// target
		if( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		// download
		if( $download ){
			$download = 'download="'. $download .'"';
		} else {
			$download = false;
		}

		$output = '<a class="mfn-link mfn-link-'. $style .' '. $class .'" href="'. $link .'" data-hover="'. $title .'" ontouchstart="this.classList.toggle(\'hover\');" '. $target .' '. $download .'>';
			$output .= '<span data-hover="'. $title .'">'. $title .'</span>';
		$output .= '</a>';
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Blockquote [blockquote] [/blockquote]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_blockquote' ) )
{
	function sc_blockquote( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'author'	=> '',
			'link'		=> '',
			'target'	=> '',
		), $attr));
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		$output = '<div class="blockquote">';
			$output .= '<blockquote>'. do_shortcode( $content ) .'</blockquote>';
			if( $author ){
				$output .= '<p class="author">';
					$output .= '<i class="icon-user"></i>';
					if( $link ){ 
						$output .= '<a href="'. $link .'" '. $target .'>'. $author .'</a>';
					} else {
						$output .= '<span>'. $author .'</span>';
					}
				$output .= '</p>';
			}
		$output .= '</div>'."\n";
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Clients [clients]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_clients' ) )
{
	function sc_clients( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'in_row' 	=> 6,
			'category' 	=> '',
			'orderby' 	=> 'menu_order',
			'order' 	=> 'ASC',
			'style' 	=> '',
			'greyscale' => '',
		), $attr));
		
		// class
		$class = '';
		if( $greyscale ) 	$class .= ' greyscale';
		if( $style ) 		$class .= ' clients_tiles';
	
		if( ! intval( $in_row ) ) $in_row = 6;
	
		$args = array(
			'post_type' 		=> 'client',
			'posts_per_page'	=> -1,
			'orderby' 			=> $orderby,
			'order' 			=> $order,
		);
		if( $category ) $args['client-types'] = $category;
	
		$clients_query = new WP_Query();
		$clients_query->query( $args );
	
		$output  = '<ul class="clients clearfix '. $class .'">';
		if ($clients_query->have_posts())
		{
			$i = 1;
			$width = round( (100 / $in_row), 3 );

			while ($clients_query->have_posts())
			{

				$clients_query->the_post();
				$output .= '<li style="width:'. $width .'%">';
					$output .= '<div class="client_wrapper">';
						$link = get_post_meta(get_the_ID(), 'mfn-post-link', true);
						if( $link ) $output .= '<a target="_blank" href="'. $link .'" title="'. the_title(false, false, false) .'">';
							$output .= '<div class="gs-wrapper">';
								$output .= get_the_post_thumbnail( null, 'clients-slider', array('class'=>'scale-with-grid') );
							$output .= '</div>';
						if( $link ) $output .= '</a>';
					$output .= '</div>';
				$output .= '</li>';
	
				$i++;
			}
		}
		wp_reset_query();
		$output .= '</ul>'."\n";
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Clients slider [clients_slider]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_clients_slider' ) )
{
	function sc_clients_slider( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title' 	=> '',
			'category' 	=> '',
			'orderby' 	=> 'menu_order',
			'order' 	=> 'ASC',
		), $attr));
		
		$args = array(
			'post_type' 		=> 'client',
			'posts_per_page'	=> -1,
			'orderby' 			=> $orderby,
			'order' 			=> $order,
		);
		if( $category ) $args['client-types'] = $category;
	
		$clients_query = new WP_Query();
		$clients_query->query( $args );

		if ($clients_query->have_posts())
		{
			$output  = '<div class="clients_slider">';
				
				$output .= '<div class="clients_slider_header">';
					if( $title ) $output .= '<h4 class="title">'. $title .'</h4>';
				$output .= '</div>';
			
				$output .= '<ul class="clients clients_slider_ul">';
				while ($clients_query->have_posts())
				{
					$clients_query->the_post();
			
					$output .= '<li>';
						$output .= '<div class="client_wrapper">';
							$link = get_post_meta(get_the_ID(), 'mfn-post-link', true);
							if( $link ) $output .= '<a target="_blank" href="'. $link .'" title="'. the_title(false, false, false) .'">';
								$output .= get_the_post_thumbnail( null, 'clients-slider', array('class'=>'scale-with-grid') );
							if( $link ) $output .= '</a>';
						$output .= '</div>';
					$output .= '</li>';
				}
				$output .= '</ul>';
				
			$output .= '</div>'."\n";
		}
		wp_reset_query();
		$output .= '</ul>'."\n";
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Fancy Heading [fancy_heading] [/fancy_heading]
* --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_fancy_heading' ) )
{
	function sc_fancy_heading( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title'		=> '',
			'h1'		=> '',
			'icon' 		=> '',
			'slogan' 	=> '',
			'style' 	=> 'icon',	// icon, line, arrows
			'animate' 	=> '',
		), $attr));
	
		$output = '<div class="fancy_heading fancy_heading_'. $style.'">';	
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
				
				if( $style == 'icon' && $icon  ) $output .= '<span class="icon_top"><i class="'. $icon .'"></i></span>';
				
				if( $style == 'line' && $slogan ) $output .= '<span class="slogan">'. $slogan .'</span>';
				
				if( $style =='arrows' ) $title = '<i class="icon-right-dir"></i>'. $title .'<i class="icon-left-dir"></i>';
				
				if( $title ){
					if( $h1 ){
						$output .= '<h1 class="title">'. $title .'</h1>';
					} else {
						$output .= '<h2 class="title">'. $title .'</h2>';
					}
				}
				if( $content ) $output .= '<div class="inside">'. do_shortcode( $content ) .'</div>';
			
			if( $animate ) $output .= '</div>';
		$output .= '</div>'."\n";
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Heading [heading] [/heading]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_heading' ) )
{
	function sc_heading( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'tag'		=> 'h2',
			'align'		=> 'left',
			'color' 	=> '',
			'style' 	=> '', // [none], lines
			'color2' 	=> '',
		), $attr));

		$before = $after = '';

		// inline_css	
		$inline_css = '';	
		if( $color ){
			$inline_css .= 'color:'. esc_attr( $color ) .';';
		}		
		if( $inline_css ){
			$inline_css = 'style="'. $inline_css .'"';
		}
		
		// inline_css2	
		$inline_css2 = '';	
		if( $color2 ){
			$inline_css2 .= 'background:'. esc_attr( $color2 ) .';';
		}		
		if( $inline_css2 ){
			$inline_css2 = 'style="'. $inline_css2 .'"';
		}
		
		// style
		if( $style == 'lines' ){
			$before	= '<span class="line line_l" '. $inline_css2 .'></span>';
			$after	= '<span class="line line_r" '. $inline_css2 .'></span>';
		}

		if( $style ){
			$style = 'heading_'. $style;
		}
		
			
		// output
		$output = '<div class="mfn_heading '. esc_attr( $style ) .' align_'. esc_attr( $align ).'">';	

			$output .= '<'. esc_attr( $tag ) .' class="title" '. $inline_css .'>';

				$output .= $before;
				
					$output .= do_shortcode( $content );
				
				$output .= $after;
			
			$output .= '</'. esc_attr( $tag ) .'>';
			
		$output .= '</div>'."\n";
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Icon Box [icon_box] [/icon_box]
* --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_icon_box' ) )
{
	function sc_icon_box( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title'			=> '',
			'title_tag' 	=> 'h4',
			
			'icon'			=> '',
			'image'			=> '',
			'icon_position'	=> 'top',
			'border'		=> '',
			
			'link'			=> '',
			'target'		=> '',
			'class'			=> '',
			
			'animate'		=> '',
		), $attr));
	
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// border
		if( $border ){
			$border = 'has_border';
		} else {
			$border = 'no_border';
		}
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		// FIX | prettyphoto
		if( strpos( $class, 'prettyphoto' ) !== false ){
			$class 	= str_replace( 'prettyphoto', '', $class );
			$rel 	= 'rel="prettyphoto"';
		} else {
			$rel 	= false;
		}
		
		$output = '';
		if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
			$output .= '<div class="icon_box icon_position_'. $icon_position .' '. $border .'">';
				if( $link ) $output .= '<a class="'. $class .'" href="'. $link .'" '. $target .' '. $rel .'>';
				
					if( $image ){
						
						$output .= '<div class="image_wrapper">';
							$output .= '<img src="'. $image .'" class="scale-with-grid" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
						$output .= '</div>';
						
					} else {
						
						$output .= '<div class="icon_wrapper">';
							$output .= '<div class="icon">';
								$output .= '<i class="'. $icon .'"></i>';
							$output .= '</div>';
						$output .= '</div>';
						
					}		
					
					$output .= '<div class="desc_wrapper">';
					
						if( $title ){
							$output .= '<'. $title_tag .' class="title">'. $title .'</'. $title_tag .'>';
						}
						if( $content )$output .= '<div class="desc">'. do_shortcode($content) .'</div>';
						
					$output .= '</div>';
					
				if( $link ) $output .= '</a>';
			$output .= '</div>'."\n";
		if( $animate ) $output .= '</div>'."\n";
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Our Team [our_team]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_our_team' ) )
{
	function sc_our_team( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'heading' 		=> '',	
			'image' 		=> '',	
			'title' 		=> '',
			'subtitle'		=> '',
			
			'phone' 		=> '',
			'email' 		=> '',

			'facebook' 		=> '',
			'twitter'		=> '',
			'linkedin'		=> '',
			'vcard'			=> '',
			
			'blockquote' 	=> '',
			'style' 		=> 'vertical',
			
			'link' 			=> '',
			'target' 		=> '',
			
			'animate' 		=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		$output = '<div class="team team_'. $style .'">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
		
				if( $heading ) $output .= '<h4 class="title">'. $heading .'</h4>';
			
				$output  .= '<div class="image_frame photo no_link scale-with-grid">';
					$output .= '<div class="image_wrapper">';
						
						if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
							$output .= '<img class="scale-with-grid" src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
						if( $link ) $output .= '</a>';
						
					$output .= '</div>';
				$output .= '</div>';
				
				$output .= '<div class="desc_wrapper">';
				
					if( $title ){
						$output .= '<h4>';
							if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
								$output .= $title;
							if( $link ) $output .= '</a>';
						$output .= '</h4>';
					}
					
					if( $subtitle ) $output .= '<p class="subtitle">'. $subtitle .'</p>';
					if( $phone ) 	$output .= '<p class="phone"><i class="icon-phone"></i> <a href="tel:'. $phone .'">'. $phone .'</a></p>';
					$output .= '<hr class="hr_color" />';
					
					$output .= '<div class="desc">'. do_shortcode($content) .'</div>';
					
					if( $email || $phone || $facebook || $twitter || $linkedin ){
						$output .= '<div class="links">';
							if( $email ) 	$output .= '<a href="mailto:'. $email .'" class="icon_bar icon_bar_small"><span class="t"><i class="icon-mail"></i></span><span class="b"><i class="icon-mail"></i></span></a>';
							if( $facebook ) $output .= '<a target="_blank" href="'. $facebook .'" class="icon_bar icon_bar_small"><span class="t"><i class="icon-facebook"></i></span><span class="b"><i class="icon-facebook"></i></span></a>';
							if( $twitter ) 	$output .= '<a target="_blank" href="'. $twitter .'" class="icon_bar icon_bar_small"><span class="t"><i class="icon-twitter"></i></span><span class="b"><i class="icon-twitter"></i></span></a>';
							if( $linkedin ) $output .= '<a target="_blank" href="'. $linkedin .'" class="icon_bar icon_bar_small"><span class="t"><i class="icon-linkedin"></i></span><span class="b"><i class="icon-linkedin"></i></span></a>';
							if( $vcard ) 	$output .= '<a href="'. $vcard .'" class="icon_bar icon_bar_small"><span class="t"><i class="icon-vcard"></i></span><span class="b"><i class="icon-vcard"></i></span></a>';
						$output .= '</div>';
					}
					
					if( $blockquote )  $output .= '<blockquote>'. $blockquote .'</blockquote>';				
					
				$output .= '</div>';

			if( $animate )  $output .= '</div>';	
		$output .= '</div>'."\n";	
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Our Team List [our_team_list]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_our_team_list' ) )
{
	function sc_our_team_list( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'image' 		=> '',	
			'title' 		=> '',
			'subtitle'		=> '',
			'blockquote'	=> '',
			'email' 		=> '',
			'phone' 		=> '',
			'facebook' 		=> '',
			'twitter'		=> '',
			'linkedin'		=> '',
			'vcard'			=> '',
			'link' 			=> '',
			'target' 		=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );

		// target
		if( $target == 'lightbox' ){
			$target = 'rel="prettyphoto"';
		} elseif( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		
		$output = '<div class="team team_list clearfix">';
		
			$output .= '<div class="column one-fourth">';
				$output .= '<div class="image_frame no_link scale-with-grid">';
					$output .= '<div class="image_wrapper">';
					
						if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
							$output .= '<img class="scale-with-grid" src="'. $image .'" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
						if( $link ) $output .= '</a>';
							
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
			
			$output .= '<div class="column one-second">';
				$output .= '<div class="desc_wrapper">';
				
					if( $title ){
						$output .= '<h4>';
							if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
								$output .= $title;
							if( $link ) $output .= '</a>';
						$output .= '</h4>';
					}
					
					if( $subtitle ) $output .= '<p class="subtitle">'. $subtitle .'</p>';
					if( $phone ) 	$output .= '<p class="phone"><i class="icon-phone"></i> <a href="tel:'. $phone .'">'. $phone .'</a></p>';
					$output .= '<hr class="hr_color" />';
					
					$output .= '<div class="desc">'. do_shortcode($content) .'</div>';
				$output .= '</div>';
			$output .= '</div>';
			
			$output .= '<div class="column one-fourth">';
				$output .= '<div class="bq_wrapper">';
					if( $blockquote ) $output .= '<blockquote>'. $blockquote .'</blockquote>';
					
					if( $email || $phone || $facebook || $twitter || $linkedin ){
						$output .= '<div class="links">';
							if( $email ) 	$output .= '<a href="mailto:'. $email .'" class="icon_bar icon_bar_small"><span class="t"><i class="icon-mail"></i></span><span class="b"><i class="icon-mail"></i></span></a>';
							if( $facebook ) $output .= '<a target="_blank" href="'. $facebook .'" class="icon_bar icon_bar_small"><span class="t"><i class="icon-facebook"></i></span><span class="b"><i class="icon-facebook"></i></span></a>';
							if( $twitter ) 	$output .= '<a target="_blank" href="'. $twitter .'" class="icon_bar icon_bar_small"><span class="t"><i class="icon-twitter"></i></span><span class="b"><i class="icon-twitter"></i></span></a>';
							if( $linkedin ) $output .= '<a target="_blank" href="'. $linkedin .'" class="icon_bar icon_bar_small"><span class="t"><i class="icon-linkedin"></i></span><span class="b"><i class="icon-linkedin"></i></span></a>';
							if( $vcard ) 	$output .= '<a href="'. $vcard .'" class="icon_bar icon_bar_small"><span class="t"><i class="icon-vcard"></i></span><span class="b"><i class="icon-vcard"></i></span></a>';
						$output .= '</div>';
					}
				$output .= '</div>';
			$output .= '</div>';

		$output .= '</div>'."\n";	
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Portfolio [portfolio]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_portfolio' ) )
{
	function sc_portfolio( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'count' 			=> 2,
			'category' 			=> '',
			'category_multi'	=> '',
			'exclude_id'		=> '',
			'orderby' 			=> 'date',
			'order' 			=> 'DESC',
			'style'				=> 'list',
			'columns'			=> 3,
			'greyscale'			=> '',
			'filters'			=> '',
			'pagination'		=> '',
			'load_more'			=> '',
			'related'			=> '',
		), $attr));
		
		$translate['all'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-item-all','All') : __('All','betheme');
		
		// class
		$class = '';
		if( $greyscale )	$class .= ' greyscale';
		
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
		$args = array(
			'post_type' 			=> 'portfolio',
			'posts_per_page' 		=> intval($count),
			'paged' 				=> $paged,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'ignore_sticky_posts' 	=> 1,
		);
		
		// categories
		if( $category_multi = trim( $category_multi ) ){	
			
			$category_multi = mfn_wpml_term_slug( $category_multi, 'portfolio-types', 1 );
			$args['portfolio-types'] = $category_multi;	
			
			$category_multi_array = explode( ',', str_replace( ' ', '', $category_multi ) );
					
		} elseif( $category ){
						
			$category = mfn_wpml_term_slug( $category, 'portfolio-types' );	
			$args['portfolio-types'] = $category;	
					
		}
	
		// exclude posts
		if( $exclude_id ){
			$exclude_id = str_replace( ' ', '', $exclude_id );
			$args['post__not_in'] = explode( ',', $exclude_id );
		}
		
		// related | exclude current
		if( $related ){
			$args['post__not_in'] = array( get_the_ID() );
		}

		$query_portfolio = new WP_Query( $args );
		
		$output = '<div class="column_filters">';
		
			// Echo | Filters
			if( $filters && ! $category ){
				$output .= '<div id="Filters" class="isotope-filters filters4portfolio" data-parent="column_filters">';
					$output .= '<div class="filters_wrapper">';
						$output .= '<ul class="categories">';
						
							$output .= '<li class="reset current-cat"><a class="all" data-rel="*" href="#">'. $translate['all'] .'</a></li>';
							if( $portfolio_categories = get_terms( 'portfolio-types' ) ){
								
								foreach( $portfolio_categories as $category ){
									
									if( $category_multi ){
										if( in_array( $category->slug, $category_multi_array ) ){
											$output .= '<li class="'. $category->slug .'"><a data-rel=".category-'. $category->slug .'" href="'. get_term_link( $category ) .'">'. $category->name .'</a></li>';
										}
									} else {
										$output .= '<li class="'. $category->slug .'"><a data-rel=".category-'. $category->slug .'" href="'. get_term_link( $category ) .'">'. $category->name .'</a></li>';
									}
		
								}
							}
						
						$output .= '</ul>';
					$output .= '</div>';
				$output .= '</div>'."\n";
			}
			
			
			// Echo | Main Content
			$output .= '<div class="portfolio_wrapper isotope_wrapper '. $class .'">';
			
				$output .= '<ul class="portfolio_group lm_wrapper isotope col-'. $columns .' '. $style .'">';
					$output .= mfn_content_portfolio( $query_portfolio, $style );
				$output .= '</ul>';
				
				if( $pagination ) $output .= mfn_pagination( $query_portfolio, $load_more );
			
			$output .= '</div>'."\n";
			
			
		$output .= '</div>'."\n";
		
		wp_reset_postdata();

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Portfolio Grid [portfolio_grid]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_portfolio_grid' ) )
{
	function sc_portfolio_grid( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'count' 			=> '4',
			'category' 			=> '',
			'category_multi' 	=> '',
			'orderby' 			=> 'date',
			'order' 			=> 'DESC',
			'greyscale' 		=> '',
		), $attr));
		
		// class
		$class = '';
		if( $greyscale )	$class .= ' greyscale';

		$args = array(
			'post_type' 			=> 'portfolio',
			'posts_per_page' 		=> intval($count),
			'paged' 				=> -1,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'ignore_sticky_posts' 	=> 1,
		);
		
		// categories
		if( $category_multi = trim( $category_multi ) ){
				
			$category_multi = mfn_wpml_term_slug( $category_multi, 'portfolio-types', 1 );
			$args['portfolio-types'] = $category_multi;
				
		} elseif( $category ){
		
			$category = mfn_wpml_term_slug( $category, 'portfolio-types' );
			$args['portfolio-types'] = $category;
				
		}

		$query = new WP_Query();
		$query->query( $args );
		$post_count = $query->post_count;
		
		$output = '';

		if ($query->have_posts())
		{
			$output  = '<ul class="portfolio_grid '. $class .'">';
				while ($query->have_posts())
				{
					$query->the_post();
	
					$output .= '<li>';
						$output .= '<div class="image_frame scale-with-grid">';
							$output .= '<div class="image_wrapper">';
								$output .= mfn_post_thumbnail( get_the_ID(), 'portfolio' );
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</li>';
				}
			$output .= '</ul>'."\n";
		}
		wp_reset_query();

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Portfolio Photo [portfolio_photo]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_portfolio_photo' ) )
{
	function sc_portfolio_photo( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'count' 			=> '5',
			'category' 			=> '',
			'category_multi' 	=> '',
			'orderby' 			=> 'date',
			'order' 			=> 'DESC',
			'target' 			=> '',
			'greyscale' 		=> '',
			'margin' 			=> '',
		), $attr));
		
		// class
		$class = '';
		if( $greyscale )	$class .= ' greyscale';
		if( $margin ) 		$class .= ' margin';
		
		$translate['readmore'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-readmore','Read more') : __('Read more','betheme');

		$args = array(
			'post_type' 			=> 'portfolio',
			'posts_per_page' 		=> intval($count),
			'paged' 				=> -1,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'ignore_sticky_posts' 	=> 1,
		);
		
		// categories
		if( $category_multi = trim( $category_multi ) ){	
			
			$category_multi = mfn_wpml_term_slug( $category_multi, 'portfolio-types', 1 );
			$args['portfolio-types'] = $category_multi;	
					
		} elseif( $category ){
						
			$category = mfn_wpml_term_slug( $category, 'portfolio-types' );	
			$args['portfolio-types'] = $category;	
					
		}
		
		// target
		if( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}

		$query = new WP_Query();
		$query->query( $args );
		
		$output = '';

		if ($query->have_posts())
		{
			$output  = '<div class="portfolio-photo '. $class .'">';
				while ($query->have_posts())
				{
					$query->the_post();
					
					// external link to project page
					if( get_post_meta( get_the_ID(), 'mfn-post-link', true ) ){
						$link = get_post_meta( get_the_ID(), 'mfn-post-link', true );
					} else {
						$link = get_permalink();
					}
					
					// portfolio categories
					$terms = get_the_terms( get_the_ID(), 'portfolio-types' );
					$categories = array();
					if( is_array( $terms ) ){
						foreach( $terms as $term ){
							$categories[] = $term->name;
						}
					}
					$categories = implode(', ', $categories);
					
					// image
					$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
	
					$output .= '<div class="portfolio-item">';
					
						$output .= '<a class="portfolio-item-bg" href="'. $link .'" '. $target .'>';
							$output .= get_the_post_thumbnail( get_the_ID(), 'full' );
							$output .= '<div class="mask"></div>';
						$output .= '</a>';

						$output .= '<a class="portfolio-details" href="'. $link .'" '. $target .'>';
						
							$output .= '<div class="details">';
								$output .= '<h3 class="title">'. get_the_title() .'</h3>';
								if( $categories ) $output .= '<div class="categories">'. $categories .'</div>';
							$output .= '</div>';

							$output .= '<span class="more"><h4>'. $translate['readmore'] .'</h4></span>';

						$output .= '</a>';
						
					$output .= '</div>';
				}
			$output .= '</div>'."\n";
		}
		wp_reset_query();

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Portfolio Slider [portfolio_slider]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_portfolio_slider' ) )
{
	function sc_portfolio_slider( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'count' 			=> '5',
			
			'category' 			=> '',
			'category_multi' 	=> '',
			'orderby' 			=> 'date',
			'order' 			=> 'DESC',
			
			'arrows'			=> '',			// [default], hover, always
			'size'				=> 'small',		// small, medium, large
			'scroll'			=> 'page',		// page, slide
		), $attr));
		
		$sizes = array(
			'small'		=> 380,	
			'medium'	=> 480,	
			'large'		=> 638,	
		);
		
		$scrolls = array(
			'page'		=> 5,
			'slide'		=> 1,	
		);
		
		$class = '';
		if( $arrows )	$class .= ' arrows arrows_' .$arrows;

		$args = array(
			'post_type' 			=> 'portfolio',
			'posts_per_page' 		=> intval($count),
			'paged' 				=> -1,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'ignore_sticky_posts' 	=> 1,
		);
		
		// categories
		if( $category_multi = trim( $category_multi ) ){	
			
			$category_multi = mfn_wpml_term_slug( $category_multi, 'portfolio-types', 1 );
			$args['portfolio-types'] = $category_multi;	
					
		} elseif( $category ){
						
			$category = mfn_wpml_term_slug( $category, 'portfolio-types' );	
			$args['portfolio-types'] = $category;	
					
		}

		$query = new WP_Query();
		$query->query( $args );
		
		$output = '';

		if ($query->have_posts())
		{
			$output  = '<div class="portfolio_slider'. esc_attr( $class ) .'" data-size="'. esc_attr( $sizes[ $size ] ) .'" data-scroll="'. esc_attr( $scrolls[ $scroll ] ) .'">';
				$output .= '<ul class="portfolio_slider_ul">';
				while( $query->have_posts() )
				{
					$query->the_post();
	
					$output .= '<li>';
						$output .= '<div class="image_frame scale-with-grid">';
							$output .= '<div class="image_wrapper">';
								$output .= mfn_post_thumbnail( get_the_ID(), 'portfolio' );
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</li>';
					
				}
				$output .= '</ul>';
			$output .= '</div>'."\n";
		}
		wp_reset_query();

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Slides [slides]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_slider' ) )
{
	function sc_slider( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			
			'category' 		=> '',
			'orderby' 		=> 'date',
			'order' 		=> 'DESC',
			'style' 		=> '',		// [default], img-text, flat, carousel
			'navigation'	=> '',
		), $attr));

		$args = array(
			'post_type' 			=> 'slide',
			'posts_per_page' 		=> -1,
			'paged' 				=> -1,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'ignore_sticky_posts' 	=> 1,
		);
		if( $category ) $args['slide-types'] = $category;

		$query = new WP_Query();
		$query->query( $args );
		$post_count = $query->post_count;
		
		// class
		$class = $style;
		if( $class == 'description' ) $class .= ' flat';
		if( $navigation )	$class .= ' '. $navigation;

		$output = '';
		if ($query->have_posts())
		{
			$output .= '<div class="content_slider '. $class .'">';
				$output .= '<ul class="content_slider_ul">';
					$i = 0;
					while ($query->have_posts())
					{
						$query->the_post();
						$i++;
		
						$output .= '<li class="content_slider_li_'. $i .'">';
							
							$link = get_post_meta(get_the_ID(), 'mfn-post-link', true);
							if( get_post_meta(get_the_ID(), 'mfn-post-target', true) ){
								$target = ' target="_blank"';
							} else {
								$target = false;
							}
								
							if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
							
								$output .= get_the_post_thumbnail( null, 'slider-content', array('class'=>'scale-with-grid' ) ); 
								
								if( $style == 'carousel' ) $output .= '<p class="title">'. get_the_title(get_the_ID()) .'</p>';
								
								if( $style == 'description' ){
									
									$output .= '<h3 class="title">'. get_the_title( get_the_ID() ) .'</h3>';
									if( $desc = get_post_meta(get_the_ID(), 'mfn-post-desc', true) ){
										$output .= '<div class="desc">'. do_shortcode( $desc ) .'</div>';
									}
															
								}
								
							if( $link ) $output .= '</a>';
							
						$output .= '</li>';
					}
				$output .= '</ul>';
				
				$output .= '<div class="slider_pager slider_pagination"></div>';
				
			$output .= '</div>'."\n";
		}
		wp_reset_query();

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Slider Plugin [slider_plugin]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_slider_plugin' ) )
{
	function sc_slider_plugin( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'rev' 		=> '',
			'layer' 	=> '',
		), $attr));

		$output = '';
		
		if( $rev ){
			
			// Revolution Slider
			$output .= '<div class="mfn-main-slider" id="mfn-rev-slider">';
				$output .= do_shortcode('[rev_slider '. $rev .']');
			$output .= '</div>';
			
		} elseif( $layer ){
			
			// Layer Slider
			$output .= '<div class="mfn-main-slider" id="mfn-layer-slider">';
				$output .= do_shortcode('[layerslider id="'. $layer .'"]');
			$output .= '</div>';
			
		}

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Offer Slider Full [offer]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_offer' ) )
{
	function sc_offer( $attr = false, $content = null )
	{
		extract(shortcode_atts(array(
			'category' 	=> '',
			'align' 	=> 'left',
		), $attr));
		
		$args = array(
			'post_type'				=> 'offer',
			'posts_per_page'		=> -1,
			'orderby'				=> 'menu_order',
			'order'					=> 'ASC',
			'ignore_sticky_posts'	=> 1,
		);
		if( $category ) $args['offer-types'] = $category;

		$offer_query = new WP_Query();
		$offer_query->query( $args );
		
		$output = '';
		if( $offer_query->have_posts() )
		{
			$output .= '<div class="offer">';
				$output .= '<ul class="offer_ul">';

					while( $offer_query->have_posts() )
					{
						$offer_query->the_post();
						$output .= '<li class="offer_li">';

							// link
							if( $link = get_post_meta( get_the_ID(), 'mfn-post-link', true) ){
								$class = 'has-link';
							} else {
								$class = 'no-link';
							}
								
							// target
							if( get_post_meta( get_the_ID(), 'mfn-post-target', true) ){
								$target = 'target="_blank"';
							} else {
								$target = false;
							}
						
							$output .= '<div class="image_wrapper">';
								$output .= get_the_post_thumbnail( get_the_ID(), 'full', array('class'=>'scale-with-grid' ) );
							$output .= '</div>';
							
							$output .= '<div class="desc_wrapper align_'. $align .' '. $class .'">';
							
								$output .= '<div class="title">';
									$output .= '<h3>'. get_the_title() .'</h3>';
									if( $link ) $output .= '<a href="'. $link .'" class="button button_js" '. $target .'><span class="button_icon"><i class="icon-layout"></i></span><span class="button_label">'. get_post_meta( get_the_ID(), 'mfn-post-link_title', true) .'</span></a>';
								$output .= '</div>';
								
								$output .= '<div class="desc">';
									$output .=  apply_filters( 'the_content', get_the_content() );
								$output .= '</div>';
								
							$output .= '</div>';
		
						$output .= '</li>';
					}

				$output .= '</ul>';
				
				// pagination
				$output .= '<div class="slider_pagination"><span class="current">1</span> / <span class="count">'. $offer_query->post_count .'</span></div>';
				
			$output .= '</div>'."\n";
		}
		wp_reset_query();
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Offer Slider Thumb [offer_thumb]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_offer_thumb' ) )
{
	function sc_offer_thumb( $attr = false, $content = null )
	{
		extract(shortcode_atts(array(
			'category' 	=> '',
			'style' 	=> '',
			'align' 	=> 'left',
		), $attr));
		
		$args = array(
			'post_type'				=> 'offer',
			'posts_per_page'		=> -1,
			'orderby'				=> 'menu_order',
			'order'					=> 'ASC',
			'ignore_sticky_posts'	=> 1,
		);
		if( $category ) $args['offer-types'] = $category;

		$offer_query = new WP_Query();
		$offer_query->query( $args );

		$output = '';
		if ($offer_query->have_posts())
		{
			$output .= '<div class="offer_thumb '. $style .'">';
				$output .= '<ul class="offer_thumb_ul">';
					$i = 1;

					while ($offer_query->have_posts())
					{
						$offer_query->the_post();
						$output .= '<li class="offer_thumb_li id_'. $i .'">';
						
							// the ID
							$id = get_the_ID();

							// link
							if( $link = get_post_meta( $id, 'mfn-post-link', true) ){
								$class = 'has-link';
							} else {
								$class = 'no-link';
							}
							
							// target
							if( get_post_meta( $id, 'mfn-post-target', true) ){
								$target = 'target="_blank"';
							} else {
								$target = false;
							}
						
							$output .= '<div class="image_wrapper">';
								$output .= get_the_post_thumbnail( $id, 'full', array( 'class' => 'scale-with-grid' ) );
							$output .= '</div>';

							$output .= '<div class="desc_wrapper align_'. $align .' '. $class .'">';
							
								if( trim(get_the_title()) || $link ){
									$output .= '<div class="title">';
										$output .= '<h3>'. get_the_title() .'</h3>';
										if( $link ) $output .= '<a href="'. $link .'" class="button button_js" '. $target .'><span class="button_icon"><i class="icon-layout"></i></span><span class="button_label">'. get_post_meta( get_the_ID(), 'mfn-post-link_title', true) .'</span></a>';
									$output .= '</div>';
								}
								
								$output .= '<div class="desc">';
									$output .=  apply_filters( 'the_content', get_the_content() );
								$output .= '</div>';
								
							$output .= '</div>';
							
							$output .= '<div class="thumbnail" style="display:none">';

								if( $thumbnail = get_post_meta( $id, 'mfn-post-thumbnail', true) ){
									$output .= '<img src="'. $thumbnail .'" class="scale-with-grid" alt="" />';
								} elseif( get_the_post_thumbnail( $id ) ){
									$output .= get_the_post_thumbnail( $id, 'testimonials', array( 'class' => 'scale-with-grid' ) );
								}
								
							$output .= '</div>';
		
						$output .= '</li>';
						
						$i++;
					}

				$output .= '</ul>';
				
				// pagination
				$output .= '<div class="slider_pagination"></div>';
				
			$output .= '</div>'."\n";
		}
		wp_reset_query();
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Map [map] [/map]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_map' ) )
{
	function sc_map( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'lat' 		=> '',
			'lng' 		=> '',
			'zoom' 		=> 13,
			'height' 	=> 200,
			
			'type' 		=> 'ROADMAP',
			'controls' 	=> '',
			'draggable' => '',
			'border' 	=> '',
			
			'icon' 		=> '',
			'color'		=> '',
			'styles'	=> '',
			'latlng' 	=> '',
			
			'title'		=> '',
			'telephone'	=> '',
			'email' 	=> '',
			'www' 		=> '',
			'style' 	=> 'box',
			
			'uid' 		=> uniqid(),
		), $attr));
		
		// image | visual composer fix
		$icon = mfn_vc_image( $icon );
		
		// border
		if( $border ){
			$class = 'has_border';
		} else {
			$class = 'no_border';
		}
		
		// controls
		$zoomControl = $mapTypeControl = $streetViewControl = 'false';
		if( ! $controls ) $zoomControl = 'true';	
		if( strpos( $controls , 'zoom' ) !== false ) 		$zoomControl = 'true';
		if( strpos( $controls , 'mapType' ) !== false ) 	$mapTypeControl = 'true';
		if( strpos( $controls , 'streetView' ) !== false ) 	$streetViewControl = 'true';

		if( $api_key = trim( mfn_opts_get( 'google-maps-api-key' ) ) ){
			$api_key = '?key='. $api_key;
		}
		
		wp_enqueue_script( 'google-maps', 'http'. mfn_ssl() .'://maps.google.com/maps/api/js'. $api_key, false, null, true );
	
		$output = '<script>';
			//<![CDATA[
			$output .= 'function google_maps_'. $uid .'(){';
			
				$output .= 'var latlng = new google.maps.LatLng('. $lat .','. $lng .');';
				
				
				// draggable
				
				if( $draggable == 'disable' ){
					$output .= 'var draggable = false;';
				} elseif( $draggable == 'disable-mobile' ){
					$output .= 'var draggable = jQuery(document).width() > 767 ? true : false;';
				} else {
					$output .= 'var draggable = true;';
				}
				
				
				// 1 click color adjustment
				
				if( $color && ! $styles ){
					$color = esc_attr( $color );
					
					if( mfn_brightness( $color ) == 'light' ){
						
						// light
						$styles = '[{featureType:"all",elementType:"labels",stylers:[{visibility:"on"}]},{featureType:"administrative",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"landscape",elementType:"all",stylers:[{color:"'. $color .'"},{visibility:"simplified"}]},{featureType:"poi",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"road",elementType:"all",stylers:[{visibility:"on"}]},{featureType:"road",elementType:"geometry",stylers:[{color:"'. $color .'"},{lightness:"50"}]},{featureType:"road",elementType:"labels.text",stylers:[{visibility:"on"}]},{featureType:"road",elementType:"labels.text.fill",stylers:[{color:"'. $color .'"},{lightness:"-60"}]},{featureType:"road",elementType:"labels.text.stroke",stylers:[{color:"'. $color .'"},{lightness:"50"}]},{featureType:"road",elementType:"labels.icon",stylers:[{visibility:"off"}]},{featureType:"transit",elementType:"all",stylers:[{visibility:"simplified"},{color:"'. $color .'"},{lightness:"50"}]},{featureType:"transit.station",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"water",elementType:"all",stylers:[{color:"'. $color .'"},{lightness:"-10"}]}]';
						
					} else {
	
						// dark
						$styles = '[{featureType:"all",elementType:"labels",stylers:[{visibility:"on"}]},{featureType:"administrative",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"landscape",elementType:"all",stylers:[{color:"'. $color .'"},{visibility:"simplified"}]},{featureType:"poi",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"road",elementType:"all",stylers:[{visibility:"on"}]},{featureType:"road",elementType:"geometry",stylers:[{color:"'. $color .'"},{lightness:"30"},{saturation:"-10"}]},{featureType:"road",elementType:"labels.text",stylers:[{visibility:"on"}]},{featureType:"road",elementType:"labels.text.fill",stylers:[{color:"'. $color .'"},{lightness:"80"}]},{featureType:"road",elementType:"labels.text.stroke",stylers:[{color:"'. $color .'"},{lightness:"0"}]},{featureType:"road",elementType:"labels.icon",stylers:[{visibility:"off"}]},{featureType:"transit",elementType:"all",stylers:[{visibility:"simplified"},{color:"'. $color .'"},{lightness:"50"}]},{featureType:"transit.station",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"water",elementType:"all",stylers:[{color:"'. $color .'"},{lightness:"-20"}]}]';
					
					}	

				}
				
				
				// OUTPUT
				
				$output .= 'var myOptions = {';
					$output .= 'zoom				: '. intval($zoom) .',';
					$output .= 'center				: latlng,';
					$output .= 'mapTypeId			: google.maps.MapTypeId.'. $type .',';
					if( $styles ) $output .= 'styles	: '. $styles .',';
					$output .= 'draggable			: draggable,';
					$output .= 'zoomControl			: '. $zoomControl .',';
					$output .= 'mapTypeControl		: '. $mapTypeControl .',';
					$output .= 'streetViewControl	: '. $streetViewControl .',';
					$output .= 'scrollwheel			: false';       
				$output .= '};';

				$output .= 'var map = new google.maps.Map(document.getElementById("google-map-area-'. $uid .'"), myOptions);';
				
				$output .= 'var marker = new google.maps.Marker({';
					$output .= 'position			: latlng,';
 					if( $icon ) $output .= 'icon	: "'. $icon .'",';
					$output .= 'map					: map';
				$output .= '});';
				
				
				// additional markers
				
				if( $latlng ){
					
					// remove white spaces
					$latlng = str_replace( ' ', '', $latlng );
					
					// explode array
					$latlng = explode( ';', $latlng );
					
					foreach( $latlng as $k=>$v ){
						
						$markerID = $k + 1;
						$markerID = 'marker'. $markerID;
						
						// custom marker icon
						$vEx = explode( ',', $v  );
						if( isset( $vEx[2] ) ){
							$customIcon = $vEx[2];
						} else {
							$customIcon = $icon;
						}
						
						$output .= 'var '. $markerID .' = new google.maps.Marker({';
							$output .= 'position			: new google.maps.LatLng('. $vEx[0] .','. $vEx[1] .'),';
							if( $customIcon ) $output .= 'icon	: "'. $customIcon .'",';
							$output .= 'map					: map';
						$output .= '});';
						
					}
					
				}
				
			
			$output .= '}';
		
			$output .= 'jQuery(document).ready(function($){';
				$output .= 'google_maps_'. $uid .'();';
			$output .= '});';	
			//]]>
		$output .= '</script>'."\n";
	
		$output .= '<div class="google-map-wrapper '. $class .'">';	
			
			if( $title || $content ){
				$output .= '<div class="google-map-contact-wrapper style-'. esc_attr( $style ) .'">';	
					$output .= '<div class="get_in_touch">';
						if( $title ) $output .= '<h3>'. $title .'</h3>';
						$output .= '<div class="get_in_touch_wrapper">';
							$output .= '<ul>';
								if( $content ){
									$output .= '<li class="address">';
										$output .= '<span class="icon"><i class="icon-location"></i></span>';
										$output .= '<span class="address_wrapper">'. do_shortcode($content) .'</span>';
									$output .= '</li>';
								}
								if( $telephone ){
									$output .= '<li class="phone">';
										$output .= '<span class="icon"><i class="icon-phone"></i></span>';
										$output .= '<p><a href="tel:'. str_replace(' ', '', $telephone) .'">'. $telephone .'</a></p>';
									$output .= '</li>';
								}
								if( $email ){
									$output .= '<li class="mail">';
										$output .= '<span class="icon"><i class="icon-mail"></i></span>';
										$output .= '<p><a href="mailto:'. $email .'">'. $email .'</a></p>';
									$output .= '</li>';
								}
								if( $www ){
									$output .= '<li class="www">';
										$output .= '<span class="icon"><i class="icon-link"></i></span>';
										$output .= '<p><a target="_blank" href="http'. mfn_ssl() .'://'. $www .'">'. $www .'</a></p>';
									$output .= '</li>';
								}
							$output .= '</ul>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			}	
			
			$output .= '<div class="google-map" id="google-map-area-'. $uid .'" style="width:100%; height:'. intval($height) .'px;">&nbsp;</div>';	
		
		$output .= '</div>'."\n";
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Tabs [tabs]
 * --------------------------------------------------------------------------- */
global $tabs_array, $tabs_count;
if( ! function_exists( 'sc_tabs' ) )
{
	function sc_tabs( $attr, $content = null )
	{
		global $tabs_array, $tabs_count;
		
		extract(shortcode_atts(array(
			'title'		=> '',
			'tabs'		=> '',
			'type'		=> '',
			'padding'	=> '',
			'uid'		=> '',
		), $attr));	
		
		do_shortcode( $content );
		
		// content builder
		if( $tabs ){
			$tabs_array = $tabs;
		}
		
		// uid
		if( ! $uid ){
			$uid = 'tab-'. uniqid();
		}
		
		// padding
		if( $padding || $padding === '0' ){
			$padding = 'style="padding:'. esc_attr( $padding ) .'"';
		}
		
		$output = '';
		if( is_array( $tabs_array ) )
		{
			if( $title ) $output .= '<h4 class="title">'. $title .'</h4>';
			$output .= '<div class="jq-tabs tabs_wrapper tabs_'. $type .'">';
				
				// contant
				$output .= '<ul>';
					$i = 1;
					$output_tabs = '';
					foreach( $tabs_array as $tab )
					{
						$output .= '<li><a href="#'. $uid .'-'. $i .'">'. $tab['title'] .'</a></li>';
						$output_tabs .= '<div id="'. $uid .'-'. $i .'" '. $padding .'>'. do_shortcode( $tab['content'] ) .'</div>';
						$i++;
					}
				$output .= '</ul>';
				
				// titles
				$output .= $output_tabs;
				
			$output .= '</div>';
			
			$tabs_array = '';
			$tabs_count = 0;	
		}
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * _Tab [tab] _private
 * --------------------------------------------------------------------------- */
$tabs_count = 0;
if( ! function_exists( 'sc_tab' ) )
{
	function sc_tab( $attr, $content = null )
	{
		global $tabs_array, $tabs_count;
		
		extract(shortcode_atts(array(
			'title' => 'Tab title',
		), $attr));
		
		$tabs_array[] = array(
			'title' => $title,
			'content' => do_shortcode( $content )
		);	
		$tabs_count++;
	
		return true;
	}
}


/* ---------------------------------------------------------------------------
 * Accordion [accordion][accordion_item]...[/accordion]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_accordion' ) )
{
	function sc_accordion( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title' 	=> '',
			'tabs' 		=> '',
			'open1st' 	=> '',
			'openall' 	=> '',
			'openAll' 	=> '',
			'style' 	=> 'accordion',
		), $attr));
		
		// class
		$class = '';	
		if( $open1st ) $class .= ' open1st';
		if( $openall || $openAll ) $class .= ' openAll';
		if( $style == 'toggle' ) $class .= ' toggle';
		
		$output  = '';
		
		$output .= '<div class="accordion">';
			if( $title ) $output .= '<h4 class="title">'. $title .'</h4>';
			$output .= '<div class="mfn-acc accordion_wrapper '. $class .'">';
						
				if( is_array( $tabs ) ){
					// content builder
					foreach( $tabs as $tab ){
						$output .= '<div class="question">';
							$output .= '<div class="title"><i class="icon-plus acc-icon-plus"></i><i class="icon-minus acc-icon-minus"></i>'. $tab['title'] .'</div>';
							$output .= '<div class="answer">';
								$output .= do_shortcode($tab['content']);	
							$output .= '</div>';
						$output .= '</div>'."\n";
					}
				} else {
					// shortcode
					$output .= do_shortcode($content);	
				}
				
			$output .= '</div>';
		$output .= '</div>'."\n";
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Accordion Item [accordion_item][/accordion_item]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_accordion_item' ) )
{
	function sc_accordion_item( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title' 	=> '',
		), $attr));

		$output = '<div class="question">';
			$output .= '<div class="title"><i class="icon-plus acc-icon-plus"></i><i class="icon-minus acc-icon-minus"></i>'. $title .'</div>';
			$output .= '<div class="answer">';
				$output .= do_shortcode( $content );	
			$output .= '</div>';
		$output .= '</div>'."\n";
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * FAQ [faq][faq_item]../[/faq]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_faq' ) )
{
	function sc_faq( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title' 	=> '',
			'tabs' 		=> '',
			'open1st' 	=> '',
			'openall' 	=> '',
			'openAll' 	=> '',
		), $attr));
		
		// class
		$class = '';	
		if( $open1st ) $class .= ' open1st';
		if( $openall || $openAll ) $class .= ' openAll';
		
		$output  = '';
		
		$output .= '<div class="faq">';
			if( $title ) $output .= '<h4 class="title">'. $title .'</h4>';
			$output .= '<div class="mfn-acc faq_wrapper '. $class .'">';
						
				if( is_array( $tabs ) ){
					// content builder
					$i = 0;
					foreach( $tabs as $tab ){
						$i++;
						$output .= '<div class="question">';
							$output .= '<div class="title"><span class="num">'. $i .'</span><i class="icon-plus acc-icon-plus"></i><i class="icon-minus acc-icon-minus"></i>'. $tab['title'] .'</div>';
							$output .= '<div class="answer">';
								$output .= do_shortcode($tab['content']);	
							$output .= '</div>';
						$output .= '</div>'."\n";
					}
				} else {
					// shortcode
					$output .= do_shortcode($content);	
				}
				
			$output .= '</div>';
		$output .= '</div>'."\n";
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * FAQ Item [faq_item][/faq_item]
* --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_faq_item' ) )
{
	function sc_faq_item( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title' 	=> '',
			'number' 	=> '1',
		), $attr));

		$output = '<div class="question">';
			$output .= '<div class="title"><span class="num">'. $number .'</span><i class="icon-plus acc-icon-plus"></i><i class="icon-minus acc-icon-minus"></i>'. $title .'</div>';
			$output .= '<div class="answer">';
				$output .= do_shortcode( $content );
			$output .= '</div>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Progress Icons [progress_icons]
* --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_progress_icons' ) )
{
	function sc_progress_icons( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'icon' 			=> 'icon-lamp',
			'image' 		=> '',
			'count' 		=> 5,
			'active' 		=> 0,
			'background' 	=> '',
		), $attr));
		
		$output = '<div class="progress_icons" data-active="'. $active .'" data-color="'. $background .'">';
			for ($i = 1; $i <= $count; $i++) {
				if( $image ){
					$output .= '<span class="progress_icon progress_image"><img src="'. $image .'" alt=""/></span>';
				} else {
					$output .= '<span class="progress_icon"><i class="'. $icon .'"></i></span>';
				}
			}
		$output .= '</div>'."\n";
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Progress Bars [progress_bars][bar][/progress_bars]
* --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_progress_bars' ) )
{
	function sc_progress_bars( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title' => '',
		), $attr));
	
		$output = '<div class="progress_bars">';
			if( $title ) $output .= '<h4 class="title">'. $title .'</h4>';
			$output .= '<ul class="bars_list">';
				$output .= do_shortcode( $content );
			$output .= '</ul>';
		$output .= '</div>'."\n";
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * _Bar [bar]
* --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_bar' ) )
{
	function sc_bar( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'title' 	=> '',
			'value' 	=> 0,
			'size' 		=> '',
		), $attr));
	
		if( $size ) $size = 'style="height:'. intval( $size ) .'px"';
		
		$output  = '<li>';
		
			$output .= '<h6>';
				$output .= $title;
				$output .= '<span class="label">'. intval( $value ) .'<em>%</em></span>';
			$output .= '</h6>';
			
			$output .= '<div class="bar" '. $size .'>';
				$output .= '<span class="progress" style="width:'. intval( $value ) .'%"></span>';
			$output .= '</div>';
			
		$output .= '</li>'."\n";
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Timeline [timeline] [/timeline]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_timeline' ) )
{
	function sc_timeline( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'count' => '',
			'tabs' => '',
		), $attr));
		
		$output  = '<ul class="timeline_items">';
		
		if( is_array( $tabs ) ){
			// content builder
			foreach( $tabs as $tab ){
				$output .= '<li>';
					$output .= '<h3>'. $tab['title'] .'</h3>';
					if( $tab['content'] ){
						$output .= '<div class="desc">';
							$output .= do_shortcode($tab['content']);
						$output .= '</div>';
					}
				$output .= '</li>';
			}
		} else {
			// shortcode
			$output .= do_shortcode($content);
		}
		
		$output .= '</ul>'."\n";
	
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Testimonials [testimonials]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_testimonials' ) )
{
	function sc_testimonials( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'category' 		=> '',
			'orderby' 		=> 'menu_order',
			'order' 		=> 'ASC',
			'style' 		=> '',
			'hide_photos' 	=> '',
		), $attr));
		
		$args = array(
			'post_type' 			=> 'testimonial',
			'posts_per_page' 		=> -1,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'ignore_sticky_posts' 	=> 1,
		);
		if( $category ) $args['testimonial-types'] = $category;
		
		$query_tm = new WP_Query();
		$query_tm->query( $args );
		
		// class
		$class = $style;
		
		if( $hide_photos ){
			$class .= ' hide-photos';
		}
		
		$output = '';
		if ($query_tm->have_posts())
		{
			$output .= '<div class="testimonials_slider '. $class .'">';
			
				// photos | pagination (style !== single-photo)
				if( $style != 'single-photo' && ! $hide_photos ){
					$output .= '<div class="slider_pager slider_images"></div>';
				}
		
				// testimonials | contant
				$output .= '<ul class="testimonials_slider_ul">';
					while ($query_tm->have_posts())
					{
						$query_tm->the_post();
						$output .= '<li>';
													
							$output .= '<div class="single-photo-img">';
								if( has_post_thumbnail() ){
									$output .= get_the_post_thumbnail( null, 'testimonials', array('class'=>'scale-with-grid' ) );
								} else {
									$output .= '<img class="scale-with-grid" src="'. THEME_URI .'/images/testimonials-placeholder.png" alt="'. get_post_meta(get_the_ID(), 'mfn-post-author', true) .'" />';
								}
							$output .= '</div>';

							$output .= '<div class="bq_wrapper">';	
								$output .= '<blockquote>'. get_the_content() .'</blockquote>';	
							$output .= '</div>';
								
							$output .= '<div class="hr_dots"><span></span><span></span><span></span></div>';	
							
							$output .= '<div class="author">';
								$output .= '<h5>';
									if( $link = get_post_meta(get_the_ID(), 'mfn-post-link', true) ) $output .= '<a target="_blank" href="'. $link .'">';
										$output .= get_post_meta(get_the_ID(), 'mfn-post-author', true);
									if( $link ) $output .= '</a>';
								$output .= '</h5>';
								$output .= '<span class="company">'. get_post_meta(get_the_ID(), 'mfn-post-company', true) .'</span>';
							$output .= '</div>';
							
						$output .= '</li>';
					}
					wp_reset_query();
				$output .= '</ul>';
				
				// photos | pagination (style == single-photo)
				if( $style == 'single-photo' ){
					$output .= '<div class="slider_pager slider_pagination"></div>';
				}
				
			$output .= '</div>'."\n";
		}
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Testimonials List [testimonials_list]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_testimonials_list' ) )
{
	function sc_testimonials_list( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'category' 	=> '',
			'orderby' 	=> 'menu_order',
			'order' 	=> 'ASC',
			'style' 	=> '',	// [default], quote
		), $attr));
		
		$args = array(
			'post_type' 			=> 'testimonial',
			'posts_per_page' 		=> -1,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'ignore_sticky_posts' 	=>1,
		);
		if( $category ) $args['testimonial-types'] = $category;
		
		$query_tm = new WP_Query();
		$query_tm->query( $args );
		
		// class
		if( $style ){
			$class = 'style_'. $style;
		} else {
			$class = '';
		}

		$output = '';
		if ($query_tm->have_posts())
		{
			$output .= '<div class="testimonials_list '. $class .'">';
			
			while ($query_tm->have_posts())
			{
				$query_tm->the_post();
				
				// classes
				$class = '';
				if( ! has_post_thumbnail() ) $class .= 'no-img';

				$output .= '<div class="item '. $class .'">';
				
					if( has_post_thumbnail() ){
						$output .= '<div class="photo">';
							$output .= '<div class="image_frame no_link scale-with-grid has_border">';
								$output .= '<div class="image_wrapper">';
									$output .= get_the_post_thumbnail( null, 'full', array('class'=>'scale-with-grid' ) );
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';
					}
					
					$output .= '<div class="desc">';
					
						if( $style == 'quote' ){
							$output .= '<div class="blockquote clearfix">';
								$output .= '<blockquote>'. get_the_content() .'</blockquote>';
							$output .= '</div>';
							$output .= '<hr class="hr_color" />';
						}
						
						$output .= '<h4>';
							if( $link = get_post_meta(get_the_ID(), 'mfn-post-link', true) ) $output .= '<a target="_blank" href="'. $link .'">';
								$output .= get_post_meta(get_the_ID(), 'mfn-post-author', true);
							if( $link ) $output .= '</a>';
						$output .= '</h4>';
	
						$output .= '<p class="subtitle">'. get_post_meta(get_the_ID(), 'mfn-post-company', true) .'</p>';

						if( $style != 'quote' ){
							$output .= '<hr class="hr_color" />';
							$output .= '<div class="blockquote">';
								$output .= '<blockquote>'. get_the_content() .'</blockquote>';
							$output .= '</div>';
						}
						
					$output .= '</div>';
					
				$output .= '</div>'."\n";
			}
			wp_reset_query();
				
			$output .= '</div>'."\n";
		}
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Vimeo [video]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_video' ) )
{
	function sc_video( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'video' 			=> '',
			'parameters' 		=> '',
			'mp4' 				=> '',
			'ogv'	 			=> '',
			'placeholder' 		=> '',
			'html5_parameters' 	=> '',
			'width' 			=> '700',
			'height' 			=> '400',
		), $attr));
		
		
		// parameters
		if( $parameters ) $parameters = '&'. $parameters; 
		
		
		// HTML5 parameters
		$html5_default = array(
			'autoplay'	=> 'autoplay="1"',
			'controls'	=> 'controls="1"',
			'loop'		=> 'loop="1"',
			'muted'		=> 'muted="1"',
		);
		
		if( $html5_parameters ){
			$html5_parameters = explode( ';', $html5_parameters );
			if( ! $html5_parameters[0] ) $html5_default['autoplay'] = false;
			if( ! $html5_parameters[1] ) $html5_default['controls'] = false;
			if( ! $html5_parameters[2] ) $html5_default['loop'] = false;
			if( ! $html5_parameters[3] ) $html5_default['muted'] = false;
		} 
		
		$html5_default = implode( ' ', $html5_default );

		
		// class
		$class = ( $video ) ? 'iframe' : '' ;

		if( $width && $height ){
			$class .= ' has-wh';
		} else {
			$class .= ' auto-wh';
		}
		
		$output  = '<div class="content_video '. $class .'">';
		
			if( $video ){
				
				// Embed
				if( is_numeric($video) ){
					// Vimeo
					$output .= '<iframe class="scale-with-grid" width="'. $width .'" height="'. $height .'" src="http'. mfn_ssl() .'://player.vimeo.com/video/'. $video .'?wmode=opaque'. $parameters .'" allowFullScreen></iframe>'."\n";
				} else {
					// YouTube
					$output .= '<iframe class="scale-with-grid" width="'. $width .'" height="'. $height .'" src="http'. mfn_ssl() .'://www.youtube.com/embed/'. $video .'?wmode=opaque'. $parameters .'" allowfullscreen></iframe>'."\n";
				}
				
			} elseif( $mp4 ){
				
				// HTML5
				$output .= '<div class="section_video">';
				
					$output .= '<div class="mask"></div>';
					$poster = ( $placeholder ) ? $placeholder : false;
					
					$output .= '<video poster="'. $poster .'" '. $html5_default .' style="max-width:100%;">';
						
						$output .= '<source type="video/mp4" src="'. $mp4 .'" />';	
						if( $ogv ) $output .= '<source type="video/ogg" src="'. $ogv .'" />';
						
					$output .= '</video>';
					
				$output .= '</div>';
				
			}
			
		$output .= '</div>'."\n";
		
		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * _Item [item]								[feature_list][item][/feature_list]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_item' ) )
{
	function sc_item( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'icon'		=> 'icon-picture',
			'title'		=> '',
			'link'		=> '',	
			'target'	=> '',	
			'animate'	=> '',
		), $attr));
		
		// target
		if( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}

		$output  = '<li>';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
				if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
			
					$output .= '<span class="icon">';
						$output .= '<i class="'. $icon .'"></i>';
					$output .= '</span>';
					$output .= '<p>'. $title .'</p>';
					
				if( $link ) $output .= '</a>';
			if( $animate )  $output .= '</div>';
		$output .= '</li>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Feature List [feature_list]				[feature_list][item][/feature_list]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_feature_list' ) )
{
	function sc_feature_list( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'columns'	=> 4,
		), $attr));
		
		$output = '<div class="feature_list" data-col="'. $columns .'">';
			$output .= '<ul>';
				$output .= do_shortcode( $content );	// [item]
			$output .= '</ul>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * List [list][/list]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_list' ) )
{
	function sc_list( $attr, $content = null )
	{
		extract(shortcode_atts(array(
			'icon'		=> 'icon-picture',
			'image'		=> '',
			'title'		=> '',
			'link'		=> '',
			'target'	=> '',
			'style'		=> 1,
			'animate'	=> '',
		), $attr));
		
		// image | visual composer fix
		$image = mfn_vc_image( $image );
		
		// target
		if( $target ){
			$target = 'target="_blank"';
		} else {
			$target = false;
		}
		
		$output = '<div class="list_item lists_'. $style .' clearfix">';
			if( $animate ) $output .= '<div class="animate" data-anim-type="'. $animate .'">';
				if( $link ) $output .= '<a href="'. $link .'" '. $target .'>';
			
					if( $style == 4 ){
						$output .= '<div class="circle">'. $title .'</div>';
					} elseif( $image ){
						$output .= '<div class="list_left list_image">';
							$output .= '<img src="'. $image .'" class="scale-with-grid" alt="'. mfn_get_attachment_data( $image, 'alt' ) .'" width="'. mfn_get_attachment_data( $image, 'width' ) .'" height="'. mfn_get_attachment_data( $image, 'height' ) .'"/>';
						$output .= '</div>';
					} else {
						$output .= '<div class="list_left list_icon">';
							$output .= '<i class="'. $icon .'"></i>';
						$output .= '</div>';
					}
					$output .= '<div class="list_right">';
						if( $title && $style != 4 ) $output .= '<h4>'. $title .'</h4>';
						$output .= '<div class="desc">'. do_shortcode( $content ) .'</div>';
					$output .= '</div>';
	
				if( $link ) $output .= '</a>';
			if( $animate )  $output .= '</div>';
		$output .= '</div>'."\n";

		return $output;
	}
}


/* ---------------------------------------------------------------------------
 * Gallery [gallery]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'sc_gallery' ) )
{
	function sc_gallery( $attr ) {
		$post = get_post();
	
		static $instance = 0;
		$instance++;
		
		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) ) {
				$attr['orderby'] = 'post__in';
			}
			$attr['include'] = $attr['ids'];
		}
	
		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( ! $attr['orderby'] ) {
				unset( $attr['orderby'] );
			}
		}
		
		$html5 = current_theme_supports( 'html5', 'gallery' );
		$atts = shortcode_atts( array(
			'order'			=> 'ASC',
			'orderby'    	=> 'menu_order ID',
			'id'         	=> $post  ? $post->ID : 0,
			'itemtag'    	=> $html5 ? 'figure'     : 'dl',
			'icontag'    	=> $html5 ? 'div'        : 'dt',
			'captiontag' 	=> $html5 ? 'figcaption' : 'dd',
			'columns'    	=> 3,
			'size'       	=> 'thumbnail',
			'include'    	=> '',
			'exclude'    	=> '',
			'link'       	=> '',
				
		// mfn custom ---------------------------
			'style'			=> '',	// [default], flat, fancy, masonry
			'greyscale'		=> '',	

		), $attr, 'gallery' );
		
		
		// Muffin | Custom Classes -----------------
		$class = $atts['link'];
		if( $atts['style'] ) $class .= ' '. $atts['style'];
		if( $atts['greyscale'] ) $class .= ' greyscale';
		if( $atts['greyscale'] ) $class .= ' greyscale';
		
	
		$id = intval( $atts['id'] );
		if ( 'RAND' == $atts['order'] ) {
			$atts['orderby'] = 'none';
		}
	
		if ( ! empty( $atts['include'] ) ) {
			$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	
			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( ! empty( $atts['exclude'] ) ) {
			$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		} else {
			$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		}
	
		if ( empty( $attachments ) ) {
			return '';
		}
	
		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
			}
			return $output;
		}
	
		$itemtag = tag_escape( $atts['itemtag'] );
		$captiontag = tag_escape( $atts['captiontag'] );
		$icontag = tag_escape( $atts['icontag'] );
		$valid_tags = wp_kses_allowed_html( 'post' );
		if ( ! isset( $valid_tags[ $itemtag ] ) ) {
			$itemtag = 'dl';
		}
		if ( ! isset( $valid_tags[ $captiontag ] ) ) {
			$captiontag = 'dd';
		}
		if ( ! isset( $valid_tags[ $icontag ] ) ) {
			$icontag = 'dt';
		}
	
		$columns = intval( $atts['columns'] );
		
// 		$itemwidth = $columns > 0 ? floor(100/$columns) : 100;

		$itemwidth = $columns > 0 ? ( ceil(100/$columns*100)/100 - 0.01 ) : 100;
		
		$float = is_rtl() ? 'right' : 'left';
	
		$selector = "gallery-{$instance}";
	
		$gallery_style = '';
	
		if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
			$gallery_style = "
			<style type='text/css'>
				#{$selector} {
					margin: auto;
				}
				#{$selector} .gallery-item {
					float: {$float};
					margin-top: 10px;
					text-align: center;
					width: {$itemwidth}%;
				}
				#{$selector} img {
					border: 2px solid #cfcfcf;
				}
				#{$selector} .gallery-caption {
					margin-left: 0;
				}
				/* see gallery_shortcode() in wp-includes/media.php */
			</style>\n\t\t";
		}

		$size_class = sanitize_html_class( $atts['size'] );
		$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} {$class}'>";
	
		$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
				$image_output = wp_get_attachment_link( $id, $atts['size'], false, false );
			} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
				$image_output = wp_get_attachment_image( $id, $atts['size'], false );
			} else {
				$image_output = wp_get_attachment_link( $id, $atts['size'], true, false );
			}
			$image_meta  = wp_get_attachment_metadata( $id );
	
			$orientation = '';
			if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
				$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
			}
			$output .= "<{$itemtag} class='gallery-item'>";
			$output .= "
				<{$icontag} class='gallery-icon {$orientation}'>
					$image_output
				</{$icontag}>";
			if ( $captiontag && trim($attachment->post_excerpt) ) {
				$output .= "
					<{$captiontag} class='wp-caption-text gallery-caption'>
					" . wptexturize($attachment->post_excerpt) . "
					</{$captiontag}>";
			}
			$output .= "</{$itemtag}>";
			if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
				$output .= '<br style="clear: both" />';
			}
		}
	
		if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
			$output .= "
				<br style='clear: both' />";
		}
	
		$output .= "
			</div>\n";
	
		return $output;
	}
}


// column shortcodes -----------------------
add_shortcode( 'one', 'sc_one' );
add_shortcode( 'one_second', 'sc_one_second' );
add_shortcode( 'one_third', 'sc_one_third' );
add_shortcode( 'two_third', 'sc_two_third' );

add_shortcode( 'one_fourth', 'sc_one_fourth' );
add_shortcode( 'two_fourth', 'sc_one_second' );
add_shortcode( 'three_fourth', 'sc_three_fourth' );

add_shortcode( 'one_fifth', 'sc_one_fifth' );
add_shortcode( 'two_fifth', 'sc_two_fifth' );
add_shortcode( 'three_fifth', 'sc_three_fifth' );
add_shortcode( 'four_fifth', 'sc_four_fifth' );

add_shortcode( 'one_sixth', 'sc_one_sixth' );
add_shortcode( 'two_sixth', 'sc_one_third' );
add_shortcode( 'three_sixth', 'sc_one_second' );
add_shortcode( 'four_sixth', 'sc_two_third' );
add_shortcode( 'five_sixth', 'sc_five_sixth' );

// content shortcodes ----------------------
add_shortcode( 'alert', 'sc_alert' );
add_shortcode( 'blockquote', 'sc_blockquote' );
add_shortcode( 'button', 'sc_button' );
add_shortcode( 'code', 'sc_code' );
add_shortcode( 'content_link', 'sc_content_link' );
add_shortcode( 'divider', 'sc_divider' );
add_shortcode( 'dropcap', 'sc_dropcap' );
add_shortcode( 'fancy_link', 'sc_fancy_link' );
add_shortcode( 'google_font', 'sc_google_font' );
add_shortcode( 'heading', 'sc_heading' );
add_shortcode( 'highlight', 'sc_highlight' );
add_shortcode( 'hr', 'sc_divider' );				// do not change, alias for [divider] shortcode
add_shortcode( 'icon', 'sc_icon' );
add_shortcode( 'icon_bar', 'sc_icon_bar' );
add_shortcode( 'icon_block', 'sc_icon_block' );
add_shortcode( 'idea', 'sc_idea' );
add_shortcode( 'image', 'sc_image' );
add_shortcode( 'popup', 'sc_popup' );
add_shortcode( 'progress_icons', 'sc_progress_icons' );
add_shortcode( 'share_box', 'sc_share_box' );
add_shortcode( 'tooltip', 'sc_tooltip' );
add_shortcode( 'tooltip_image', 'sc_tooltip_image' );
add_shortcode( 'video_embed', 'sc_video' ); 		// WordPress has default [video] shortcode

// builder shortcodes ----------------------
add_shortcode( 'accordion', 'sc_accordion' );
add_shortcode( 'accordion_item', 'sc_accordion_item' );
add_shortcode( 'article_box', 'sc_article_box' );
add_shortcode( 'before_after', 'sc_before_after' );
add_shortcode( 'blog', 'sc_blog' );
add_shortcode( 'blog_news', 'sc_blog_news' );
add_shortcode( 'blog_slider', 'sc_blog_slider' );
add_shortcode( 'blog_teaser', 'sc_blog_teaser' );
add_shortcode( 'call_to_action', 'sc_call_to_action' );
add_shortcode( 'chart', 'sc_chart' );
add_shortcode( 'clients', 'sc_clients' );
add_shortcode( 'clients_slider', 'sc_clients_slider' );
add_shortcode( 'contact_box', 'sc_contact_box' );
add_shortcode( 'countdown', 'sc_countdown' );
add_shortcode( 'counter', 'sc_counter' );
add_shortcode( 'fancy_divider', 'sc_fancy_divider' );
add_shortcode( 'fancy_heading', 'sc_fancy_heading' );
add_shortcode( 'faq', 'sc_faq' );
add_shortcode( 'faq_item', 'sc_faq_item' );
add_shortcode( 'feature_box', 'sc_feature_box' );
add_shortcode( 'feature_list', 'sc_feature_list' );
add_shortcode( 'flat_box', 'sc_flat_box' );
add_shortcode( 'helper', 'sc_helper' );
add_shortcode( 'hover_box', 'sc_hover_box' );
add_shortcode( 'hover_color', 'sc_hover_color' );
add_shortcode( 'how_it_works', 'sc_how_it_works' );
add_shortcode( 'icon_box', 'sc_icon_box' );
add_shortcode( 'info_box', 'sc_info_box' );
add_shortcode( 'list', 'sc_list' );
add_shortcode( 'map', 'sc_map' );
add_shortcode( 'offer', 'sc_offer' );
add_shortcode( 'offer_thumb', 'sc_offer_thumb' );
add_shortcode( 'opening_hours', 'sc_opening_hours' );
add_shortcode( 'our_team', 'sc_our_team' );
add_shortcode( 'our_team_list', 'sc_our_team_list' );
add_shortcode( 'photo_box', 'sc_photo_box' );
add_shortcode( 'portfolio', 'sc_portfolio' );
add_shortcode( 'portfolio_grid', 'sc_portfolio_grid' );
add_shortcode( 'portfolio_photo', 'sc_portfolio_photo' );
add_shortcode( 'portfolio_slider', 'sc_portfolio_slider' );
add_shortcode( 'pricing_item', 'sc_pricing_item' );
add_shortcode( 'progress_bars', 'sc_progress_bars' );
add_shortcode( 'promo_box', 'sc_promo_box' );
add_shortcode( 'quick_fact', 'sc_quick_fact' );
add_shortcode( 'shop_slider', 'sc_shop_slider' );
add_shortcode( 'slider', 'sc_slider' );
add_shortcode( 'sliding_box', 'sc_sliding_box' );
add_shortcode( 'story_box', 'sc_story_box' );
add_shortcode( 'tabs', 'sc_tabs' );
add_shortcode( 'tab', 'sc_tab' );
add_shortcode( 'testimonials', 'sc_testimonials' );
add_shortcode( 'testimonials_list', 'sc_testimonials_list' );
add_shortcode( 'trailer_box', 'sc_trailer_box' );
add_shortcode( 'zoom_box', 'sc_zoom_box' );

// private shortcodes ----------------------
add_shortcode( 'bar', 'sc_bar' );
add_shortcode( 'item', 'sc_item' );

// replace WP shortcode --------------------
if( ! mfn_opts_get( 'sc-gallery-disable' ) ){
	remove_shortcode( 'gallery' );
	add_shortcode( 'gallery' , 'sc_gallery' );
}
