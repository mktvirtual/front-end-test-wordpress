<?php

function mktvirtual_setup() {
    function register_my_menu() {
      register_nav_menu('navmenu', 'Nav Menu' );
    }
            
    add_action( 'init', 'register_my_menu' );
    add_theme_support( 'post-thumbnails' );
}

add_action( 'after_setup_theme', 'mktvirtual_setup' );
