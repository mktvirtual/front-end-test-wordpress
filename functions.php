<?php 
// Include ACF Plugin
include_once( get_stylesheet_directory() . '/plugins/acf/acf.php' );
// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');
 
function my_acf_settings_path( $path ) {
 
    // update path
    $path = get_stylesheet_directory() . '/plugins/acf/';
    
    // return
    return $path;
    
}
 

// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');
 
function my_acf_settings_dir( $dir ) {
 
    // update path
    $dir = get_stylesheet_directory_uri() . '/plugins/acf/';
    
    // return
    return $dir;
    
}
// Register Menus
register_nav_menus( array(
	'primary' => __( 'Navegação'),
	'secondary' => __( 'Informações Navegação'),
	'third' => __( 'Lojas Logo'),
	'fourth' => __('Lista de Atalhos')
));
function register__files() {
    wp_enqueue_style( 'css', get_stylesheet_uri() );
    wp_enqueue_style( 'fonts', 'https://fonts.googleapis.com/css?family=Alegreya+Sans|Montserrat:400,700' );
    wp_enqueue_script( 'googlemaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAw438cDd9LDKOZdD7VXxJKyCCRtzTZet4', array(), '1.0.0', true );
    wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true );    
}
add_action( 'wp_enqueue_scripts', 'register__files' );

add_theme_support( 'title-tag' );

add_action( 'widgets_init', 'theme_slug_widgets_init' );
function theme_slug_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Main Sidebar', 'theme-slug' ),
        'id' => 'sidebar-1',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
        'before_widget' => '<div id="%1$s" class="footer__nav %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<span class="widgettitle">',
    'after_title'   => '</span>',
    ) );
}

// Change Loho
//Custom WordPress Login Logo by WpTotal.com.br
function cutom_login_logo() {
    echo "<style type=\"text/css\">
    body.login div#login h1 a {
    background-image: url(".get_bloginfo('template_directory')."/images/brand/logo.png);
    -webkit-background-size: auto;
    background-size: auto;
    margin: 0 0 25px;
    width: 320px;
    height: 58px
    }
    body{
        background: #ff9a5a !important;
    }
    </style>";
}
add_action( 'login_enqueue_scripts', 'cutom_login_logo' );

?>