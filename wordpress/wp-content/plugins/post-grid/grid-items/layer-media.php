<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


		
		$html_media = '';

		$is_image = false;
		foreach($media_source as $source_info){
		 
			$media = post_grid_get_media($source_info['id'], $featured_img_size, $thumb_linked);
			
			//var_dump($media);
			
			if ( $is_image ) continue;
		
			if(!empty($source_info['checked'])){
				if(!empty($media)){
			
					$html_media = post_grid_get_media($source_info['id'], $featured_img_size, $thumb_linked);
					$is_image = true;
				}
			   else{
				   $html_media = '';
				   }
			}
		}



	$html_media = apply_filters('post_grid_filter_html_media', $html_media);
	
	$html.='<div class="layer-media">'.$html_media.'</div>';	
	//$html.='<div class="layer-title">'.get_the_title().'</div>';