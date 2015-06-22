<?php
/**
 * @package WordPress
 * @subpackage Tema_mkt
 * @since Tema_mkt 1.0
 */
?><!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style.css">
	<link rel="stylesheet" type="text/css" media="screen and (min-width: 1260px) and (max-width: 1449px)" href="<?php echo get_template_directory_uri(); ?>/css/style_1450.css">
	<link rel="stylesheet" type="text/css" media="screen and (min-width: 980px) and (max-width: 1259px)" href="<?php echo get_template_directory_uri(); ?>/css/style_1250.css">
	<link rel="stylesheet" type="text/css" media="screen and (max-width: 980px)" href="<?php echo get_template_directory_uri(); ?>/css/style_mobile.css">
</head>

<body>	
	<!-- menu superior fixo com campo para pesquisar -->
	<div class="menu_fixo">
		<ul class="menu_superior">
			<li><a href="">Peça seu cartão de clinete</a></li>
			<li><a href="">Solicite 2ª via do boleto</a></li>
			<li><a href="">Encontre uma loja</a></li>
			<li><a href="">Assine a newsletter</a></li>
			<li><?php get_search_form(); ?></li>
		</ul>
	</div>
	<!-- topo do site com logo e menu dinamico -->
	<header class="topo clearfix">
		<!-- logo di site -->
		<div class="logo">
			<img src="<?php echo get_template_directory_uri(); ?>/images/logo/logo.png">
		</div>
		<!-- menu dinamico do site -->
		<div id="navbar" class="navbar">
			<nav class="menu">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'menu_id' => 'primary-menu' ) ); ?>
			</nav>
		</div>
	</header>
	
