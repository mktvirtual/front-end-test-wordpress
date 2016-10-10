<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">   
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=yes">
    <?php
	if ( ! function_exists( '_wp_render_title_tag' ) ) {
		function theme_slug_render_title() {
	?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php
		}
		add_action( 'wp_head', 'theme_slug_render_title' );
	}
	?>
    <meta name="theme-color" content="#f47d31">
    <link rel="icon" sizes="192x192" href="URL-IMAGE">
<?php wp_head(); ?>
</head>
<body>
<main>
	<header class="header">
		<div class="header__orange-bar">
			<div class="row">
				<div class="header__orange-bar__links">
					<button class="header__orange-bar__info"></button>
					<ul class="header__orange-bar__content">
						<?php if ( has_nav_menu( 'primary' ) ) {
				      		wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => false) ); 
						} ?>
					</ul>
				</div><!-- Orange-Bar Links -->
				<div class="header__orange-bar__search">
					<form role="search" method="get" id="searchform" action="<?php echo get_option('home'); ?>">
					    <input value="" name="s" id="s" type="text" placeholder="Busca" class="header__orange-bar__search__input">
					    <input id="searchsubmit" value="" type="submit" class="header__orange-bar__search__btn">
					</form>
				</div><!-- Orange-Bar Search -->
			</div><!-- Row -->
		</div><!-- Orange-Bar -->
		<div class="header__brand">
			<div class="row">
				<div class="header__brand__logo">
					<a href="<?php echo get_settings('home'); ?>" title="<?php echo get_bloginfo('name'); ?>">
						<img src="<?php bloginfo('template_directory'); ?>/images/brand/logo.png" alt="">
					</a>
				</div><!-- Logo -->

				<nav class="header__brand__navegation">
					<button class="header__brand__navegation__btn">
						<span></span>
						<span></span>
						<span></span>
					</button>
					<?php if ( has_nav_menu( 'primary' ) ) {
				      	wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false) ); 
					} ?>
				</nav><!-- Header Nagevation -->
			</div><!-- Row -->
		</div><!-- Brand -->
</header>