<?php
/**
 * @link       https://github.com/paulovitorwd/front-end-test-wordpress
 * @package    WordPress
 * @subpackage MKT_Virtual
 * @since      MKT Virtual 1.0.0
 */
?>

<header>
	<div class="top">
		<div class="container">
			<nav>

				<?php wp_nav_menu( array( 'theme_location' => 'header-menu-1' ) ); ?>

				<form action="">
					<input type="text" placeholder="Busca">
					<input type="submit" value="">
				</form>
			</nav>
			<button id="arrow"></button>
		</div>
	</div>
	<div class="middle">
		<div class="container">
			<h1>
				<a href="<?php echo get_home_url(); ?>">
					<img src="<?php bloginfo('template_directory'); ?>/imgs/logo.png" alt="Logo">
				</a>
			</h1>
			<button id="menu">
				<div class="bar"></div>
				<div class="bar"></div>
				<div class="bar"></div>
			</button>
			<menu>
				<nav class="container">

					<?php wp_nav_menu( array( 'theme_location' => 'header-menu-2' ) ); ?>

				</nav>
			</menu>
		</div>
		<div id="banners">
			<div>
				<img src="<?php bloginfo('template_directory'); ?>/imgs/banner-01.jpg" alt="">
			</div>
			<div>
				<img src="<?php bloginfo('template_directory'); ?>/imgs/banner-02.jpg" alt="">
			</div>
		</div>
	</div>
</header>