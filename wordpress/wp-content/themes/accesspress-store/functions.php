<?php
/**
 * AccessPress Store functions and definitions
 *
 * @package AccessPress Store
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'accesspress_store_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function accesspress_store_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on AccessPress Store, use a find and replace
	 * to change 'accesspress-store' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'accesspress-store', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
    
    add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
    
    add_image_size('accesspress-prod-cat-size', 562, 492, true);
    
    add_image_size('accesspress-service-thumbnail', 380, 252, true);
    
    add_image_size('accesspress-blog-big-thumbnail', 760, 300, true);

    add_image_size('accesspress-slider', 1350, 570, true);
    
    
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'accesspress-store' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'accesspress_store_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'accesspress_store_setup' );

/**
 * AccessPress Store Admin Enqueue Js
*/
function accesspress_store_wp_admin_section() {
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
    wp_enqueue_style( 'ap-admin-css', get_template_directory_uri() . '/inc/css/ap-admin.css' );

    if (function_exists('wp_enqueue_media'))
        wp_enqueue_media();
    wp_enqueue_script( 'accesspress-store-admin', get_template_directory_uri() . '/inc/js/ap-admin.js', array( 'jquery' ), '20130508', true );
    wp_localize_script('accesspress-store-admin', 'accesspress_store_l10n', array(
        'upload' => __('Upload', 'accesspress-store'),
        'remove' => __('Remove', 'accesspress-store')
    ));
    
}
add_action( 'admin_enqueue_scripts', 'accesspress_store_wp_admin_section' );

/**
 * Load Require init file.
*/
require $accesspress_store_file_directory_init_file_path = trailingslashit( get_template_directory() ).'inc/init.php';