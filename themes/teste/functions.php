<?php

	// post thumbnail support
	add_theme_support( 'post-thumbnails' );

	// custom menu support
	add_theme_support( 'menus' );
	if ( function_exists( 'register_nav_menus' ) ) {
	  	register_nav_menus(
	  		array(
	  		  'header-top-menu' => 'Header Top Menu',
	  		  'header-menu' => 'Header Menu',
	  		  'footer-left-menu' => 'Footer Left Menu',
	  		  'footer-right-menu' => 'Footer Right Menu'
	  		)
	  	);
	}

	// removes detailed login error information for security
	add_filter('login_errors',create_function('$a', "return null;"));

	// removes the WordPress version from your header for security
	function wb_remove_version() {
		return '<!-- desenvolvido por MKT Virtual -->';
	}
	add_filter('the_generator', 'wb_remove_version');

?>
