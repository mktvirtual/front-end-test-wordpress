<?php
/**
 * @link       https://github.com/paulovitorwd/front-end-test-wordpress
 * @package    WordPress
 * @subpackage MKT_Virtual
 * @since      MKT Virtual 1.0.0
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<title><?php wp_title(''); ?></title>

	<!--============================
	=            Styles            =
	=============================-->
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/libs/slick.css"/>
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>"/>
	<!--============================
	=            Styles            =
	=============================-->

	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
</head>
<body>
	<div id="base">

		<?php get_header(); ?>

		<main>
			<section>
				<div class="wrapper container">
					<div class="posts content">

						<?php

						while ( have_posts() ) : the_post();

						get_template_part('templates/posts', get_post_format());

						endwhile;

						?>

					</div>

					<?php get_sidebar(); ?>

				</div>
			</section>
			<section>
				<div class="location">
					<div class="container">
						<div class="search">
							<button id="auto-location">
								Achar minha localização automaticamente
							</button>
							<p>ou</p>
							<form class="sender">
								<label for="cep-field">Digite o CEP de onde você está</label>
								<fieldset>
									<input type="text" pattern="\d{5}-?\d{3}" placeholder="CEP" id="cep-field" required>
									<input type="button" value="Procurar" id="cep-button">
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</section>
			<section>
				<div class="follow container">
					<div class="newsletter half">
						<form action="" class="sender">
							<label for="newsletter">Assine a newsletter do logo</label>
							<fieldset>
								<input type="email" placeholder="Seu e-mail" id="newsletter">
								<input type="submit" value="Enviar">
							</fieldset>
						</form>
					</div>
					<div class="social-media half">
						<p>Siga lojas logo nas redes sociais</p>
						<ul>
							<li>
								<a href="#" target="_blank" class="facebook"></a>
							</li>
							<li>
								<a href="#" target="_blank" class="youtube"></a>
							</li>
							<li>
								<a href="#" target="_blank" class="instagram"></a>
							</li>
						</ul>
					</div>
				</div>
			</section>
		</main>

		<?php get_footer(); ?>

	</div>

	<!--============================
	=            Sripts            =
	=============================-->
	<script src="<?php bloginfo('template_directory'); ?>/libs/jquery.min.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/libs/slick.min.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/scripts/components/top.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/scripts/components/menu.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/scripts/components/location.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/scripts/components/banners.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/scripts/main.js"></script>
	<!--============================
	=            Sripts            =
	=============================-->
</body>
</html>
