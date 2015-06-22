<?php 
/**
 * Proper way to enqueue scripts and styles.
 */
function enqueue_styles_and_scripts() {
    wp_enqueue_style( 'font', 'http://fonts.googleapis.com/css?family=Montserrat:400,700' );
    wp_enqueue_style( 'main', get_stylesheet_uri() );
    wp_enqueue_script('maps',  'https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=false');
    wp_enqueue_script('main',  get_template_directory_uri() . '/js/main.js');

}
add_action( 'wp_enqueue_styles_and_scripts', 'enqueue_styles_and_scripts' ); 

/*
 * Post thumbnail feature
 */
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 845, 845 );

