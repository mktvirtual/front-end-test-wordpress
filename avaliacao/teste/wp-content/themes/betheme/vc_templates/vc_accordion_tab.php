<?php
$output = $title = '';

extract ( shortcode_atts ( array (
		'title' => __ ( "Section", "js_composer" ) 
), $atts ) );

$css_class = apply_filters ( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion_section group', $this->settings ['base'], $atts );

$output .= '<div class="question ' . $css_class . '">';
	$output .= '<div class="title"><i class="icon-plus acc-icon-plus"></i><i class="icon-minus acc-icon-minus"></i>'. $title .'</div>';
	$output .= '<div class="answer">';
		$output .= ($content == '' || $content == ' ') ? __ ( "Empty section. Edit page to add content here.", "js_composer" ) : wpb_js_remove_wpautop ( $content );
	$output .= '</div>';
$output .= '</div>';

echo $output;