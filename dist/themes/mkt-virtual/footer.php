<?php
/**
 * @link       https://github.com/paulovitorwd/front-end-test-wordpress
 * @package    WordPress
 * @subpackage MKT_Virtual
 * @since      MKT Virtual 1.0.0
 */
?>

<footer>
	<div class="container">
		<div class="useful half">
			<ul>
				<li>
					<p>Lojas logo</p>

					<?php wp_nav_menu( array( 'theme_location' => 'footer-menu-1' ) ); ?>

				</li>
				<li>
					<p>Lista de atalhos</p>

					<?php wp_nav_menu( array( 'theme_location' => 'footer-menu-2' ) ); ?>

				</li>
				<li>
					<p>Sac Loja Logo <span>0800-701-0316</span></p>
					<a href="#" class="bar-code">Solicitar 2ª via do boleto</a>
				</li>
			</ul>
			<small>2015. Lojas Logo. Todos os direitos reservados</small>
		</div>
		<div class="featured half">
			<img src="<?php bloginfo('template_directory'); ?>/imgs/featured.jpg" alt="">
			<small class="signature">mkt virtual</small>
		</div>
	</div>
</footer>
