<?php
$output = $title = $interval = $el_class = $class = '';
extract( shortcode_atts( array(
	'title'		=> '',
	'interval'	=> 0,
	'el_class'	=> ''
), $atts ) );

$el_class = $this->getExtraClass( $el_class );

$element = 'wpb_tabs';
if ( 'vc_tour' == $this->shortcode ){
	$element = 'wpb_tour';
	$class = 'tabs_vertical';
}


// Extract tab titles ---------------------------
preg_match_all( '/vc_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();

if ( isset( $matches[1] ) ) {
	$tab_titles = $matches[1];
}
$tabs_nav = '';
$tabs_nav .= '<ul class="wpb_tabs_nav ui-tabs-nav vc_clearfix">';
foreach ( $tab_titles as $tab ) {
	$tab_atts = shortcode_parse_atts($tab[0]);
	if(isset($tab_atts['title'])) {
		$tabs_nav .= '<li><a href="#tab-' . ( isset( $tab_atts['tab_id'] ) ? $tab_atts['tab_id'] : sanitize_title( $tab_atts['title'] ) ) . '">' . $tab_atts['title'] . '</a></li>';
	}
}
$tabs_nav .= '</ul>' . "\n";


// content --------------------------------------
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim( $element . ' wpb_content_element ' . $el_class ), $this->settings['base'], $atts );

$output .= '<div class="' . $css_class . '" data-interval="' . $interval . '">';
	if( $title ) $output .= '<h4 class="title">'. $title .'</h4>';
	$output .= '<div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix '. $class .'">';
	
		$output .= $tabs_nav;
		$output .= wpb_js_remove_wpautop( $content );
	
	$output .= '</div>';
$output .= '</div>';


echo $output;