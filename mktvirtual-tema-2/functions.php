<?php


/*** theme support **/

add_theme_support( 'post-thumbnails' ); 

add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

add_theme_support( 'post-formats', array(
	'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
) );

add_theme_support( 'html5', array( 'search-form' ) );

/*** criando menus gerenciaveis ***/

function register_my_menus() {
  register_nav_menus(
    array(
      'apoio-menu' => __( 'Apoio Menu' ),
      'nav-menu' => __( 'Nav Menu' ),
      'footer-links' => __( 'Footer Links' ),
      'footer-atalhos' => __( 'Footer Atalhos' )
    )
  );
}
add_action( 'init', 'register_my_menus' );


/*** Limita numero de posts na home ***/

function four_posts_on_homepage( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'posts_per_page', 4 );
    }
}

add_action( 'pre_get_posts', 'four_posts_on_homepage' );


?>