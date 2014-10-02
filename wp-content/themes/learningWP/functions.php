<?php 


function addingResources()
{
	wp_enqueue_style('style',get_stylesheet_uri());

}


 

 add_action('wp_enqueue_scripts','addingResources');


//Nav Menus
register_nav_menus(array(
	'primary'=> __('Primary Menu'),
	'footer'=> __('Footer Menu')
));
 ?>