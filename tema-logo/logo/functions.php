<?php

add_theme_support( 'post-thumbnails' ); 

function register_my_menus() {
	register_nav_menus(
		array(
			'header-menu' => __( 'Header Menu' ),
			'footer-menu' => __( 'Footer Menu' )
		)
	);
}
add_action( 'init', 'register_my_menus' );

function themeslug_theme_customizer( $wp_customize ) {
    $wp_customize->add_section( 'themeslug_logo_section' , array(
	    'title'       => __( 'Logo', 'themeslug' ),
	    'priority'    => 30,
	    'description' => 'Upload a logo to replace the default site name and description in the header',
	) );

	$wp_customize->add_setting( 'themeslug_logo' );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_logo', array(
	    'label'    => __( 'Logo', 'themeslug' ),
	    'section'  => 'themeslug_logo_section',
	    'settings' => 'themeslug_logo',
	) ) );
}
add_action( 'customize_register', 'themeslug_theme_customizer' );

function logo_scripts() {
	wp_enqueue_style( 'style-logo', get_stylesheet_uri());
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery-2.1.4.min.js');
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js');
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'logo_scripts' );

function insert_slider_container( $atts, $content = null ) {
	return 
	'<div class="container-fluid slider">
		<div class="row">
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
			      <li data-slide-to="0" data-target="#myCarousel" class="active"></li>
			      <li data-slide-to="1" data-target="#myCarousel"></li>
			    </ol>
				<div class="carousel-inner" role="listbox">
					' . do_shortcode($content) . '
				</div>
				<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
				    <span class="slider-btn sprite-slider-left" aria-hidden="true"></span>
				    <span class="sr-only">Próximo</span>
				  </a>
				  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
				    <span class="slider-btn sprite-slider-right" aria-hidden="true"></span>
				    <span class="sr-only">Anterior</span>
				  </a>
			</div>
		</div>
	</div>';
}
add_shortcode( 'slider_container', 'insert_slider_container' );

function insert_slider( $atts ) {
    $a = shortcode_atts( array(
        'image' => '',
        'name' => '',
        'first' => ''
    ), $atts );

    if( $a['first'] == 'true'){
    	$out = '<div class="item active">';
    }else{
    	$out = '<div class="item">';
    }
		$out .= '<img src="'. get_bloginfo('url') . $a['image'] .'" alt="'. $a['name'] .'" class="fullscreen">
	</div>';
    return $out;
}
add_shortcode( 'slider', 'insert_slider' );

function insert_url_base( $atts, $content = null ) {
    return get_bloginfo('url');
}
add_shortcode( 'url_base', 'insert_url_base' );

function insert_container( $atts, $content = null ) {
	return 
	'<div class="container">
	  	<div class="row">
	  		' . do_shortcode($content) . '
	  	</div>
	</div>';

}
add_shortcode( 'container', 'insert_container' );




function insert_superbanner( $atts ) {
    $a = shortcode_atts( array(
        'link' => '#',
        'image' => '',
        'title' => ''
    ), $atts );

    return '<div class="col-md-4 col-sm-4 superbanner_box">
		    	<a href="'. $a['link'] .'">
		    		<img src="'. get_bloginfo('url') . $a['image'] .'" alt="'. $a['title'] .'">
		    		<div class="adesao">'. $a['title'] .'</div>
		    	</a>
		    </div>';
}
add_shortcode( 'superbanner', 'insert_superbanner' );

add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );
function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

function insert_postbox( $atts ) {
    $a = shortcode_atts( array(
        'post' => '',
        'read_more' => 'Saiba mais',
        'posx' => '10',
        'posy' => '10'
    ), $atts );

    $post = get_post( $a['post'] );
    $category = get_the_category($a['post']);
    $thumbnail = get_the_post_thumbnail($a['post'], 'full');
    $link = get_post_permalink( $a['post'] );
    $out =  
    	'<div class="col-md-4 col-sm-4 post_box">
    		'.$thumbnail.'
    		<div class="post_info" style="top: '. $a['posy'] .'%; left: '. $a['posx'] .'%;">';
    			if($category[0]->name != 'Sem categoria') $out .= '<span class="category">'. $category[0]->name .'</span>';
	    		$out .=
	    		'<span class="title">'. $post->post_title .'</span>
	    		<span class="excerpt">'. $post->post_excerpt .'</span>
	    		<a href="'. $link .'"><div class="read_more">'. $a['read_more'] .'</div></a>
    		</div>
    	</div>';
    return $out;
}
add_shortcode( 'postbox', 'insert_postbox' );

function insert_container_localizacao( $atts, $content = null ) {
	return 
	'<div class="container-fluid">
		<div class="row">
			<div class="localizacao">
				<div class="box col-md-6 col-sm-6 col-sm-offset-3 col-md-offset-3">
					<div class="box_left col-md-5">
						<div class="box_localizacao">
							<div class="col_icon_map col-md-2 col-sm-2 col-xs-2">
								<i class="fa fa-map-marker fa-2x"></i>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-10">
								<p>Achar minha localização automaticamente</p>
							</div>
						</div>
						<span class="ou">ou</span>
					</div>
					
					<div class="box_right col-md-7">
						<p>Digite o CEP de onde você está</p>
						<form action="#" class="cep-form" method="get">
							<label>
								<input type="search" title="CEP" value="" placeholder="CEP" class="cep-field">
							</label>
							<input type="submit" value="Procurar" class="cep-submit">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>';

}
add_shortcode( 'container_localizacao', 'insert_container_localizacao' );


function insert_container_social( $atts, $content = null ) {
	return 
	'<div class="container social">
	  	<div class="row">
			<div class="col-md-6 col-sm-6">
				<p>Assine a Newsletter do Logo</p>
				<form method="get" class="news-form" action="#">
					<label>
						<input type="search" class="news-field" placeholder="Seu e-mail" value="" title="news">
					</label>
					<input type="submit" class="news-submit" value="Enviar">
				</form>
			</div>
			<div class="col-md-6 col-sm-6">
				<p>Siga lojas Logo nas redes sociais</p>
				<ul class="list-inline">
					<li>
						<div class="rede"><a href="https://facebook.com" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></div>
					</li>
					<li>
						<div class="rede"><a href="https://youtube.com" target="_blank"><i class="fa fa-youtube-play fa-2x"></i></a></div>
					</li>
					<li>
						<div class="rede"><a href="https://instagram.com" target="_blank"><i class="fa fa-instagram fa-2x"></i></a></div>
					</li>
				</ul>
			</div>
		</div>
	</div>';

}
add_shortcode( 'container_social', 'insert_container_social' );


if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'name'=> 'Footer area 1',
		'id' => 'footer_area_1',
		'before_widget' => '<li id="%1$s" class="footer1 widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="footer_title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name'=> 'Footer area 2',
		'id' => 'footer_area_2',
		'before_widget' => '<li id="%1$s" class="footer2 widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="footer_title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name'=> 'Footer area 3',
		'id' => 'footer_area_3',
		'before_widget' => '<li id="%1$s" class="footer3 widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="footer_title">',
		'after_title' => '</h3>',
	));
}
