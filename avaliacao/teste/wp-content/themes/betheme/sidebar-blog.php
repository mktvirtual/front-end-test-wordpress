<?php
/**
 * The Blog Sidebar containing the widget area.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

$sidebar = false;

$posts_page_id = false;
if( get_option( 'page_for_posts' ) ){
	$posts_page_id = get_option( 'page_for_posts' );	// Setings / Reading
} elseif( mfn_opts_get( 'blog-page' ) ){
	$posts_page_id = mfn_opts_get( 'blog-page' );		// Theme Options / Getting Started / Blog
}

$sidebars = mfn_opts_get( 'sidebars' );


// Category -----------------------------------------------
$theme_disable = mfn_opts_get( 'theme-disable' );
if( ! isset( $theme_disable['categories-sidebars'] ) ){
	if( is_category() ){
	
		$category = get_query_var( 'cat' );
		$category = get_category( $category );
		
		$cat_sidebar = 'blog-cat-'. $category->slug;
		
		if( is_active_sidebar( $cat_sidebar ) ){
			$sidebar = $cat_sidebar;
		}
	}
}


// Blog ---------------------------------------------------
if( ! $sidebar ){
		
	$sidebar = get_post_meta( $posts_page_id, 'mfn-post-sidebar', true );
	$sidebar = $sidebars[$sidebar];
	
}

if( $_GET && key_exists('mfn-s', $_GET) ){
	$sidebar = esc_html( $_GET['mfn-s'] ); // demo
}


// sidebar 2 --------------------------------------------------------
$sidebar2 = get_post_meta( $posts_page_id, 'mfn-post-sidebar2', true);
if( $sidebar2 || $sidebar2 === '0' ) $sidebar2 = $sidebars[$sidebar2];

if( $_GET && key_exists('mfn-s2', $_GET) ){
	$sidebar2 = esc_html( $_GET['mfn-s2'] ); // demo
}


// echo -------------------------------------------------------------
if( mfn_sidebar_classes() ){

	echo '<div class="sidebar sidebar-1 four columns">';
		echo '<div class="widget-area clearfix '. mfn_opts_get('sidebar-lines') .'">';
			if ( ! dynamic_sidebar( $sidebar ) ) mfn_nosidebar();
		echo '</div>';
	echo '</div>';

	// both sidebars
	if( mfn_sidebar_classes( true ) ){
		echo '<div class="sidebar sidebar-2 four columns">';
			echo '<div class="widget-area clearfix '. mfn_opts_get('sidebar-lines') .'">';
				if ( ! dynamic_sidebar( $sidebar2 ) ) mfn_nosidebar();
			echo '</div>';
		echo '</div>';
	}
}
