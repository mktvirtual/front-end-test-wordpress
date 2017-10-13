<?php
$output = $title = $el_class = $open = $css_animation = '';
extract(shortcode_atts(array(
    'title'			=> __("Click to toggle", "js_composer"),
    'el_class'		=> '',
    'open'			=> 'false',
    'css_animation' => ''
), $atts));

$el_class = $this->getExtraClass($el_class);
$open = ( $open == 'true' ) ? ' wpb_toggle_title_active' : '';
$el_class .= ( $open == ' wpb_toggle_title_active' ) ? ' wpb_toggle_open' : '';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_toggle' . $open, $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation($css_animation);

// $output .= apply_filters('wpb_toggle_heading', '<h4 class="'.$css_class.'">'.$title.'</h4>', array('title'=>$title, 'open'=>$open));
// $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_toggle_content' . $el_class, $this->settings['base'], $atts );
// $output .= '<div class="'.$css_class.'">'.wpb_js_remove_wpautop($content, true).'</div>'.$this->endBlockComment('toggle')."\n";


$output .= '<div class="faq">';
	$output .= '<div class="mfn-acc faq_wrapper">';

		$output .= '<div class="question">';
			$output .=  apply_filters('wpb_toggle_heading', '<div class="title '.$css_class.'"><i class="icon-plus acc-icon-plus"></i><i class="icon-minus acc-icon-minus"></i>'. $title .'</div>', array('title'=>$title, 'open'=>$open));
// 			$output .= '<div class="title"><span class="num"></span><i class="icon-plus acc-icon-plus"></i><i class="icon-minus acc-icon-minus"></i>'. $title .'</div>';

				$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_toggle_content answer' . $el_class, $this->settings['base'], $atts );
				$output .= '<div class="'.$css_class.'">'.wpb_js_remove_wpautop($content, true).'</div>'.$this->endBlockComment('toggle')."\n";

		$output .= '</div>'."\n";
	
	$output .= '</div>';
$output .= '</div>'."\n";


echo $output;