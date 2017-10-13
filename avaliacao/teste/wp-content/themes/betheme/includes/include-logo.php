<?php
/**
 * Logo
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

if( $logo_text = mfn_opts_get( 'logo-text' ) ){
	$logo_class = ' text-logo';
} else {
	$logo_class = false;
}

echo '<div class="logo'. $logo_class .'">';

	// Logo | Options
	$logo_options = mfn_opts_get( 'logo-link' ) ? mfn_opts_get( 'logo-link' ) : false;
	$logo_before = $logo_after = '';
	
	// Logo | Link
	if( isset( $logo_options['link'] ) ){
		$logo_before 	= '<a id="logo" href="'. get_home_url() .'" title="'. get_bloginfo( 'name' ) .'">';
		$logo_after 	= '</a>';
	} else {
		$logo_before 	= '<span id="logo">';
		$logo_after 	= '</span>';
	}
	
	// Logo | H1
	if( is_front_page() ){
		if( is_array( $logo_options ) && isset( $logo_options['h1-home'] )){
			$logo_before = '<h1>'. $logo_before;
			$logo_after .= '</h1>';
		}
	} else {
		if( is_array( $logo_options ) && isset( $logo_options['h1-all'] )){
			$logo_before = '<h1>'. $logo_before;
			$logo_after .= '</h1>';
		}
	}
	
	// Logo | Source
	if( $layoutID = mfn_layout_ID() ){
	
		$logo_src 			= get_post_meta( $layoutID, 'mfn-post-logo-img', true );
		$logo_sticky 		= get_post_meta( $layoutID, 'mfn-post-sticky-logo-img', true ) ? get_post_meta( $layoutID, 'mfn-post-sticky-logo-img', true ) : $logo_src;
		$logo_mobile 		= get_post_meta( $layoutID, 'mfn-post-responsive-logo-img', true ) ? get_post_meta( $layoutID, 'mfn-post-responsive-logo-img', true ) : $logo_src;
		$logo_mobile_sticky	= get_post_meta( $layoutID, 'mfn-post-responsive-sticky-logo-img', true ) ? get_post_meta( $layoutID, 'mfn-post-responsive-sticky-logo-img', true ) : $logo_src;
			
	} else {
	
		$logo_src 			= mfn_opts_get( 'logo-img', THEME_URI .'/images/logo/logo.png' );
		$logo_sticky 		= mfn_opts_get( 'sticky-logo-img' ) ? mfn_opts_get( 'sticky-logo-img' ) : $logo_src;
		$logo_mobile 		= mfn_opts_get( 'responsive-logo-img' ) ? mfn_opts_get( 'responsive-logo-img' ) : $logo_src;
		$logo_mobile_sticky = mfn_opts_get( 'responsive-sticky-logo-img' ) ? mfn_opts_get( 'responsive-sticky-logo-img' ) : $logo_src;
	
	}
	
	// Logo | SVG width
	if( $width = mfn_opts_get( 'logo-width' ) ){
		$svg 	= ' svg';
		$width 	= 'width="'. $width .'"';
		
	} else {
		$svg 	= false;
		$width 	= false;
	}
	
	// Logo | Print
	echo $logo_before;
	
	if( $logo_text ){
	
		echo $logo_text;
	
	} else {
	
		echo '<img class="logo-main scale-with-grid'. $svg .'" src="'. $logo_src .'" alt="'. mfn_get_attachment_data( $logo_src, 'alt' ) .'" '. $width .'/>';
		echo '<img class="logo-sticky scale-with-grid'. $svg .'" src="'. $logo_sticky .'" alt="'. mfn_get_attachment_data( $logo_sticky, 'alt' ) .'" '. $width .'/>';
		echo '<img class="logo-mobile scale-with-grid'. $svg .'" src="'. $logo_mobile .'" alt="'. mfn_get_attachment_data( $logo_mobile, 'alt' ) .'" '. $width .'/>';
		echo '<img class="logo-mobile-sticky scale-with-grid'. $svg .'" src="'. $logo_mobile_sticky .'" alt="'. mfn_get_attachment_data( $logo_mobile_sticky, 'alt' ) .'" '. $width .'/>';
	
	}
		
	echo $logo_after;

echo '</div>';
			