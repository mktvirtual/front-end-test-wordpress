<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access

class class_post_grid_shortcodes{
	
	
    public function __construct(){
		
		add_shortcode( 'post_grid', array( $this, 'post_grid_new_display' ) );
		

    }
	

	
	
	
	public function post_grid_new_display($atts, $content = null ){
		
		
			$atts = shortcode_atts(
				array(
					'id' => "",
					///'paging'=> 'pg'. $w4dev_custom_loop,
					), $atts);
	
				$html  = '';
				$post_id = $atts['id'];
		
				include post_grid_plugin_dir.'/grid-items/variables.php';
				include post_grid_plugin_dir.'/grid-items/query.php';
				include post_grid_plugin_dir.'/grid-items/custom-css.php';				
				include post_grid_plugin_dir.'/grid-items/lazy.php';					
				
				
				
				
				if($enable_multi_skin=='yes'){
					$skin_main  = $skin;
					}
		
		
		
				$html.='<div id="post-grid-'.$post_id.'" class="post-grid '.$grid_type.'">';
		
		
				if ( $wp_query->have_posts() ) :
				
				$html.='<div class="grid-nav-top">';	
				include post_grid_plugin_dir.'/grid-items/nav-top-new.php';							
				$html.='</div>';  // .grid-nav-top	
				
				
				if($grid_type=='slider'){
					
					$owl_carousel_class='owl-carousel';
					
					}
				else{
					$owl_carousel_class='';
					}
				
				$html.='<div class="grid-items '.$owl_carousel_class.'" id="">';
				
				
				$odd_even = 0;
				
				while ( $wp_query->have_posts() ) : $wp_query->the_post();

				$post_grid_post_settings = get_post_meta( get_the_ID(), 'post_grid_post_settings', true );
				
				
				//var_dump($post_grid_post_settings);
				
				if($enable_multi_skin=='yes'){
					
					if(!empty($post_grid_post_settings['post_skin'])){
					
						$skin = $post_grid_post_settings['post_skin'];
	
						}
					else{
						
						$skin = $skin_main;
						}
					
					}

				if($odd_even%2==0){
					$odd_even_calss = 'even';
					}
				else{
					$odd_even_calss = 'odd';
					}
				$odd_even++;
				
				$html.='<div  class="item mix skin '.$odd_even_calss.' '.$skin.' '.post_grid_term_slug_list(get_the_ID()).'">';

				include post_grid_plugin_dir.'/grid-items/layer-media.php';
				include post_grid_plugin_dir.'/grid-items/layer-content.php';
				include post_grid_plugin_dir.'/grid-items/layer-hover.php';	
				
				$html.='</div>';  // .item		
				
				
				
				
				$post_grid_ads_loop_meta_options = get_post_meta($post_id, 'post_grid_ads_loop_meta_options', true);
				
				
			//	var_dump($post_grid_ads_loop_meta_options['ads_positions']);
				
				if(!empty($post_grid_ads_loop_meta_options['ads_positions'])){
					
					$ads_positions = $post_grid_ads_loop_meta_options['ads_positions'];
					$ads_positions = explode(',',$ads_positions);
					
					$ads_positions_html = $post_grid_ads_loop_meta_options['ads_positions_html'];

					$post_grid_ads_positions = apply_filters('post_grid_filter_ads_positions', $ads_positions);

					foreach($post_grid_ads_positions as $position){
						
						if( $wp_query->current_post == $position ){
							
							if(!empty($ads_positions_html[$position]))
							$html .= apply_filters('post_grid_nth_item_html',$ads_positions_html[$position]); 
							
							}
						}
					
					}

				
				
				//do_action('post_grid_nth_item_html');
				
				
				endwhile;
				wp_reset_query();
				$html.='</div>';  // .grid-items	
				
				$html.='<div class="grid-nav-bottom">';	
				include post_grid_plugin_dir.'/grid-items/nav-bottom-new.php';
				$html.='</div>';  // .grid-nav-bottom	
				 
				//wp_reset_query();
				else:
				$html.='<div class="no-post-found">';
				$html.=__('No Post found',post_grid_textdomain);  // .item	
				$html.='</div>';  // .item					
				
				endif;
				
				include post_grid_plugin_dir.'/grid-items/scripts.php';	
				$html.='</div>';  // .post-grid
	
				if($masonry_enable=='yes'){
					$html .= '<script>jQuery(window).load(function(){jQuery("#post-grid-'.$post_id.' .grid-items").masonry({isFitWidth: true}); });</script>';	
					}

				


				return $html;
	
		
		
		
		
		}	
	



	
	
	
	}

new class_post_grid_shortcodes();