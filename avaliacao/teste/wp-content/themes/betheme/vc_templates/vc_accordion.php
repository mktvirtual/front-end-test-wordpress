<?php
$output = $title = $interval = $el_class = $collapsible = $active_tab = '';

extract(shortcode_atts(array(
    'title' 		=> '',
    'interval' 		=> 0,
    'el_class' 		=> '',
    'collapsible'	=> 'no',
    'active_tab'	=> '1'
), $atts));

$el_class = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'accordion wpb_content_element ' . $el_class . ' not-column-inherit', $this->settings['base'], $atts );

$class = '';
if( $collapsible == 'yes' ) $class .= ' toggle';

$output .= '<div class="'. $css_class .'">';
	if( $title ) $output .= '<h4 class="title">'. $title .'</h4>';
	$output .= '<div class="mfn-acc accordion_wrapper'. $class .'" data-active-tab="'. $active_tab .'">';
	
		$output .= wpb_js_remove_wpautop($content);
	
	$output .= '</div>';
$output .= '</div>';

echo $output;