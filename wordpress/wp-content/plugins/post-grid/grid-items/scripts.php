<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


		$html .='<script>
		jQuery(document).ready(function($)
		{
			$("#post-grid-'.$post_id.' .layer-media .gallery").owlCarousel({
				
				items : 1,

				navText : ["",""],
				autoplay: true,
				loop: true,
				autoHeight : true,	
				nav : false,	
				dots : false,					
											
								
				';

		$html .='});
		
		});';
		$html .= '</script>';
		
		

		
		
		
		
		
		
		