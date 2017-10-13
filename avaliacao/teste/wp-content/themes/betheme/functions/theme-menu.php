<?php
/**
 * Menu functions.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */


/* ---------------------------------------------------------------------------
 * Registers a menu location to use with navigation menus.
 * --------------------------------------------------------------------------- */
register_nav_menu( 'main-menu',				__( 'Main Menu | depth 5 (Header Overlay 1)', 'mfn-opts' ) );
register_nav_menu( 'secondary-menu',		__( 'Secondary Menu | depth 2 (Header Split 5)', 'mfn-opts' ) );
register_nav_menu( 'lang-menu',				__( 'Languages Menu | depth 1', 'mfn-opts' ) );
register_nav_menu( 'social-menu',			__( 'Social Menu Top | depth 1', 'mfn-opts' ) );
register_nav_menu( 'social-menu-bottom',	__( 'Social Menu Bottom | depth 1', 'mfn-opts' ) );


/* ---------------------------------------------------------------------------
 * Main Menu
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_wp_nav_menu' ) )
{
	function mfn_wp_nav_menu() 
	{
		$args = array( 
			'container' 		=> 'nav',
			'container_id'		=> 'menu', 
			'menu_class'		=> 'menu', 
			'fallback_cb'		=> 'mfn_wp_page_menu', 
			'depth' 			=> 5,
			'link_before'     	=> '<span>',
			'link_after'      	=> '</span>',
		);
		
		// Mega Menu | Custom Walker
		$theme_disable = mfn_opts_get( 'theme-disable' );
		if( ! isset( $theme_disable['mega-menu'] ) ){
			$args['walker']		= new Walker_Nav_Menu_Mfn;
		}
		
		// Custom Menu
		if( mfn_ID() && is_single() && get_post_type() == 'post' && $custom_menu = mfn_opts_get( 'blog-single-menu' ) ){
			// Theme Options | Single Posts
			$args['menu']			= $custom_menu;
		} elseif( mfn_ID() && is_single() && get_post_type() == 'portfolio' && $custom_menu = mfn_opts_get( 'portfolio-single-menu' ) ){
			// Theme Options | Single Portfolio
			$args['menu']			= $custom_menu;
		} elseif( $custom_menu = get_post_meta( mfn_ID(), 'mfn-post-menu', true ) ){
			// Page Options | Page
			$args['menu']			= $custom_menu;
		} else {
			// Default
			$args['theme_location'] = 'main-menu';
		}
	
		wp_nav_menu( $args ); 
	}
}

if( ! function_exists( 'mfn_wp_page_menu' ) )
{
	function mfn_wp_page_menu() 
	{
		$args = array(
			'title_li' 		=> '0',
			'sort_column' 	=> 'menu_order',
			'depth' 		=> 5,
		);
	
		echo '<nav id="menu">'."\n";
			echo '<ul class="menu page-menu">'."\n";
				wp_list_pages($args); 
			echo '</ul>'."\n";
		echo '</nav>'."\n";
	}
}


/* ---------------------------------------------------------------------------
 * Split Menu
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_wp_split_menu' ) )
{
	function mfn_wp_split_menu() 
	{
		echo '<nav id="menu">';
		
			// Main Menu Left ----------------------------
			$args = array( 
				'container' 		=> false,
				'menu_id'         	=> false,
				'menu_class'		=> 'menu menu_left',
				'fallback_cb'		=> false, 
				'theme_location'	=> 'main-menu',
				'depth' 			=> 5,
				'link_before'     	=> '<span>',
				'link_after'      	=> '</span>',
			);
			
			// custom walker for mega menu
			$theme_disable = mfn_opts_get( 'theme-disable' );
			if( ! isset( $theme_disable['mega-menu'] ) ){
				$args['walker']		= new Walker_Nav_Menu_Mfn;
			}
			
			wp_nav_menu( $args ); 
			
			// Main Menu Right ----------------------------
			$args = array( 
				'container' 		=> false,
				'menu_id'         	=> false,
				'menu_class'		=> 'menu menu_right',
				'fallback_cb'		=> false, 
				'theme_location'	=> 'secondary-menu',
				'depth' 			=> 5,
				'link_before'     	=> '<span>',
				'link_after'      	=> '</span>',
			);
			
			// custom walker for mega menu
			$theme_disable = mfn_opts_get( 'theme-disable' );
			if( ! isset( $theme_disable['mega-menu'] ) ){
				$args['walker']		= new Walker_Nav_Menu_Mfn;
			}
			
			wp_nav_menu( $args ); 
		
		echo '</nav>';
	}
}


/* ---------------------------------------------------------------------------
 * Overlay menu
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_wp_overlay_menu' ) )
{
	function mfn_wp_overlay_menu()
	{
		$args = array(
			'container' 		=> 'nav',
			'container_id'		=> 'overlay-menu', 
			'menu_class'		=> 'overlay-menu', 
			'fallback_cb'		=> false,
			'theme_location' 	=> 'main-menu',
			'depth'				=> 1,
		);
		
		// Custom Menu
		if( mfn_ID() && is_single() && get_post_type() == 'post' && $custom_menu = mfn_opts_get( 'blog-single-menu' ) ){
			// Theme Options | Single Posts
			$args['menu']			= $custom_menu;
		} elseif( mfn_ID() && is_single() && get_post_type() == 'portfolio' && $custom_menu = mfn_opts_get( 'portfolio-single-menu' ) ){
			// Theme Options | Single Portfolio
			$args['menu']			= $custom_menu;
		} elseif( $custom_menu = get_post_meta( mfn_ID(), 'mfn-post-menu', true ) ){
			// Page Options | Page
			$args['menu']			= $custom_menu;
		} else {
			// Default
			$args['theme_location'] = 'main-menu';
		}
		
		wp_nav_menu( $args );
	}
}


/* ---------------------------------------------------------------------------
 * Secondary menu
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_wp_secondary_menu' ) )
{
	function mfn_wp_secondary_menu()
	{
		$args = array(
			'container' 		=> 'nav',
			'container_id'		=> 'secondary-menu', 
			'menu_class'		=> 'secondary-menu', 
			'fallback_cb'		=> false,
			'theme_location' 	=> 'secondary-menu',
			'depth'				=> 2,
		);
		wp_nav_menu( $args );
	}
}


/* ---------------------------------------------------------------------------
 * Languages menu
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_wp_lang_menu' ) )
{
	function mfn_wp_lang_menu()
	{
		$args = array(
			'container' 		=> false,
			'fallback_cb'		=> false,
			'menu_class'		=> 'wpml-lang-dropdown',
			'theme_location' 	=> 'lang-menu',
			'depth'				=> 1,
		);
		wp_nav_menu( $args );
	}
}


/* ---------------------------------------------------------------------------
 * Social menu
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_wp_social_menu' ) )
{
	function mfn_wp_social_menu()
	{
		$args = array(
			'container' 		=> 'nav',
			'container_id'		=> 'social-menu', 
			'menu_class'		=> 'social-menu', 
			'fallback_cb'		=> false,
			'theme_location' 	=> 'social-menu',
			'depth'				=> 1,
		);
		wp_nav_menu( $args );
	}
}

if( ! function_exists( 'mfn_wp_social_menu_bottom' ) )
{
	function mfn_wp_social_menu_bottom()
	{
		$args = array(
			'container' 		=> 'nav',
			'container_id'		=> 'social-menu', 
			'menu_class'		=> 'social-menu', 
			'fallback_cb'		=> false,
			'theme_location' 	=> 'social-menu-bottom',
			'depth'				=> 1,
		);
		wp_nav_menu( $args );
	}
}
