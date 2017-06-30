<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Palm Beach
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="page" class="hfeed site">

		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'palm-beach' ); ?></a>

		<div id="header-top" class="header-bar-wrap"><?php do_action( 'palm_beach_header_bar' ); ?></div>

		<div class="top-header">
			<div class="container">
				<div class="top-search">
					<input type="text" placeholder="buscar">
					<button class="search-button"><i class="fa fa-search"></i></button>
				</div>
				<?php
				wp_nav_menu( array(
				    'theme_location' => 'my-custom-menu',
				    'menu_class' => 'top-menu' ) );
				?>

			</div>
		</div>

		<header id="masthead" class="site-header clearfix" role="banner">

			<div class="header-main container clearfix">

				<div id="logo" class="site-branding clearfix">

					<?php palm_beach_site_logo(); ?>
					<?php palm_beach_site_title(); ?>

				</div><!-- .site-branding -->

				<nav id="main-navigation" class="primary-navigation navigation clearfix" role="navigation">
					<?php
						// Display Main Navigation.
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'container' => false,
							'menu_class' => 'main-navigation-menu',
							'echo' => true,
							'fallback_cb' => 'palm_beach_default_menu',
							)
						);
					?>
				</nav><!-- #main-navigation -->

			</div><!-- .header-main -->

		</header><!-- #masthead -->

		<?php // Display slider or header image on homepage.
		if ( is_home() or is_page_template( 'template-magazine.php' ) or is_page_template( 'template-slider.php' )   ) :

			palm_beach_slider();
			palm_beach_header_image();

		else :

			palm_beach_header_title();

		endif; ?>

		<?php palm_beach_breadcrumbs(); ?>

		<div id="content" class="site-content container clearfix">
