<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<title>
		<?php
			if ( is_category() ) {
				echo 'Categoria: '; single_cat_title(); echo '&quot; | '; bloginfo( 'name' );
			}
			elseif ( is_search() ) {
				echo 'Resultado da pesquisa por: '.wp_specialchars($s).'&quot; | '; bloginfo( 'name' );
			}
			elseif ( is_home() ) {
				bloginfo( 'name' ); echo ' | '; bloginfo( 'description' );
			}
			elseif ( is_404() ) {
				echo 'Página não encontrada | '; bloginfo( 'name' );
			}
			elseif ( is_single() ) {
				wp_title('');
			}
			else {
				echo wp_title(''); echo ' | '; bloginfo( 'name' );
			}
		?>
	</title>

	<meta name="description" content="<?php wp_title(''); echo ' | '; bloginfo( 'description' ); ?>" />
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="icon" href="<?php bloginfo('template_url'); ?>/favicon.png" type="image/png" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'atom_url' ); ?>" />

	<?php wp_enqueue_script("jquery"); ?>

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<?php wp_head(); ?>

	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Alegreya+Sans" rel="stylesheet">

	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/assets/css/reset.min.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/assets/css/main.min.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/assets/css/responsive.min.css" />

	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>


</head>

<body <?php body_class(); ?>>

	<main>

		<header>

			<div class="header-navigation-top">

				<div class="header-navigation-top-wrap wrap">

					<!-- Menu dinâmico Wordpress - Menu topo -->
					<?php
						wp_nav_menu(array(
							'menu' => 'top',
							'container' => 'nav',
							'container_id' => 'header-navigation-top-menu'
						));
					?>

					<!-- Pesquisa padrão do Wordpress -->
					<div class="header-search">

						<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
						    <input type="search" class="search-field" placeholder="Busca" value="<?php echo get_search_query() ?>" name="s" />
						    <input type="submit" class="search-submit" value="" />
						</form>

					</div>

				</div>

			</div>

			<div class="header-navigation">

				<div class="header-navigation-wrap wrap">

					<div class="logo">
						<a href="#" title="LOGO"><img src="<?php bloginfo('template_url') ?>/assets/images/logo.png" alt="LOGO"></a>
					</div>

					<!-- Menu dinâmico Wordpress - Menu padrão -->
					<?php
						wp_nav_menu(array(
							'menu' => 'default',
							'container' => 'nav',
							'container_id' => 'header-navigation-menu'
						));
					?>

					<!-- Botão de menu abre/fecha menu (responsivo) -->
					<div id="menu-toggle">
						<span></span>
					  	<span></span>
					  	<span></span>
					</div>

				</div>

			</div>

		</header>
