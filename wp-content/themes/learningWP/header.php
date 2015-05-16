<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php bloginfo('name') ?></title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="container">

	<header class="site-header">
	<img class= "site-logo" src="http://localhost:8989/wp-content/uploads/2014/10/mkt_logo.png">
		
		<!-- navigation bar -->
		<nav class="site-nav">
			<?php 
				wp_nav_menu( array('theme_location'=>'primary'));
			 ?>
		</nav>
		<!-- navigation bar -->
	</header>