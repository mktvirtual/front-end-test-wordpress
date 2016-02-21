<?php
/**
 * @link       https://github.com/paulovitorwd/front-end-test-wordpress
 * @package    WordPress
 * @subpackage MKT_Virtual
 * @since      MKT Virtual 1.0.0
 */
 ?>

<?php

function register_my_menu() {
	register_nav_menu('header-menu-1',__('Header Menu 1'));
	register_nav_menu('header-menu-2',__('Header Menu 2'));
	register_nav_menu('footer-menu-1',__('Footer Menu 1'));
	register_nav_menu('footer-menu-2',__('Footer Menu 2'));
}

add_action('init', 'register_my_menu');
add_theme_support('post-thumbnails', array('post'));

set_post_thumbnail_size(412, 412, true);

?>