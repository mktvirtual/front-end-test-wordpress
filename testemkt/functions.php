<?php 

// ADD IMAGEM DESTACADA AOS POSTS
add_theme_support( 'post-thumbnails' );

//Load the CSS
function theme_styles(){
	wp_enqueue_style('principal', get_template_directory_uri().'/css/style.css' );
	// wp_enqueue_style('icones', get_template_directory_uri().'/css/icons.css' );
	wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900');
	wp_enqueue_style( 'googleFonts');
}

//Load the Theme js
// function theme_js(){
// 	wp_enqueue_script('geral.js', get_template_directory_uri().'/js/geral.js',array('jquery'),'',true ) ;
// 	wp_enqueue_script('prettyPhoto-init.js', 'http://192.168.0.147/Mariplast/wp-content/plugins/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto.min.js?ver=3.1.5',array('jquery'),'',true ) ;
// 	wp_enqueue_script('prettyPhoto-min.js', 'http://192.168.0.147/Mariplast/wp-content/plugins/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto.init.min.js?ver=2.1.11',array('jquery'),'',true ) ;

// }

// add_action('wp_enqueue_scripts', 'theme_js');
add_action('wp_enqueue_scripts', 'theme_styles');

//enable custom menus
add_theme_support('menus');	

//	COMO TIRAR A BARRA DE ADMIN		
add_filter('show_admin_bar', '__return_false');

// Limite de Caracteres do Título do Post
function titulo_pequeno() {
	$titulo_original = get_the_title();
	$titulo = html_entity_decode($titulo_original, ENT_QUOTES, "UTF-8"); 

	$limite = "15";

	if(strlen($titulo) >= ($limite+3)) {
	$titulo = mb_substr($titulo, 0, $limite); }
	echo $titulo;
}

function conteudo_pequeno() {
	$conteudo_original = get_the_content();
	$conteudo = html_entity_decode($conteudo_original, ENT_QUOTES, "UTF-8"); 

	$limite = "50";

	if(strlen($conteudo) >= ($limite+3)) {
	$conteudo = mb_substr($conteudo, 0, $limite); }
	echo $conteudo;
}
?>