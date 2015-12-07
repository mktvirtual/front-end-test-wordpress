<?php

function teste_script_basic(){
	wp_enqueue_style( 'foundation',     get_template_directory_uri() . '/css/foundation.min.css');
	wp_enqueue_style( 'app',            get_template_directory_uri() . '/css/app.css');
	wp_enqueue_script( 'modernizr',  	get_template_directory_uri() . '/js/vendor/modernizr.js', array(), '1.0.0' );
    wp_enqueue_script( 'foundation',  	get_template_directory_uri() . '/js/foundation.min.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'tfoundation',  	get_template_directory_uri() . '/js/foundation/foundation.topbar.js', array(), '1.0.0', true );
    wp_enqueue_script( 'efoundation',  	get_template_directory_uri() . '/js/foundation/foundation.equalizer.js', array(), '1.0.0', true );
    wp_enqueue_script( 'scrollTo',  	get_template_directory_uri() . '/js/jquery.scrollTo.min.js', array(), '1.0.0', true ); 
    wp_enqueue_script( 'app',  	get_template_directory_uri() . '/js/app.js', array(), '1.0.0', true );

}
add_action( 'wp_enqueue_scripts', 'teste_script_basic');

add_theme_support( 'post-thumbnails' ); 

function criando_menus(){
  add_theme_support( 'menus' );   
  register_nav_menus(
    array(
      'menu-banner' => __( 'Menu sobre o banner' ),
      'barra-topo' => __( 'Topo laranja' ),
      'lojas-logo' => __( 'Menu rodapé' ),
      'lista-atalhos' => __( 'Lista de atalhos no rodapé' )
    )
  );
}
add_action('init','criando_menus');

add_filter( 'excerpt_more', 'custom_read_more' );

function custom_read_more( $more )  {
  if( in_category('promocoes') ) {
    return '... <a href="' . get_permalink() . '" class="more-link button" title="Continue lendo">Continue lendo</a>';
  }
  else {
    return '... <a href="' . get_permalink() . '" class="more-link button" title="Saiba mais">Saiba mais</a>';
  }
}

add_filter( 'the_excerpt', 'themeprefix_excerpt_read_more_link' );

function themeprefix_excerpt_read_more_link( $output ) {
  global $post;

  if( in_category('promocoes') ) {
    return $output . ' <a href="' . get_permalink( $post->ID ) . '" class="more-link button" title="Continue lendo">Continue lendo</a>';
  }
  else {
    return $output . ' <a href="' . get_permalink( $post->ID ) . '" class="more-link button" title="Saiba mais">Saiba mais</a>';
  }
}

?>