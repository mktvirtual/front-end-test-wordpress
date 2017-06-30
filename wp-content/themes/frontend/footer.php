<?php
/**
 * The template for displaying the footer.
 *
 * Contains all content after the main content area and sidebar
 *
 * @package Palm Beach
 */

?>

	</div><!-- #content -->

	<div class="map-content">
		<!-- <div class="box-search"></div> -->
	</div>

	<section class="newsletter">
		<div class="site-content container clearfix pd-left-30">
			<div class="sidebar widget-area clearfix">
				<label for="">ASSINE A NEWSLETTER DO LOGO</label>
				<input type="text" placeholder="Seu e-mail">
				<button>ENVIAR</button>
			</div>

		<div class="content-archive content-area">
			<h3 class="title-social-icons">SIGA LOJAS LOGO NAS REDES SOCIAIS</h3>
			<ul class="social-icons">
				<li><a href="#"><i class="fa fa-facebook"></i></a></li>
				<li><a href="#"><i class="fa fa-play"></i></a></li>
				<li><a href="#"><i class="fa fa-instagram"></i></a></li>
			</ul>
		</div>
		</div>
	</section>

	<?php do_action( 'palm_beach_before_footer' ); ?>

	<div id="footer" class="footer-wrap">

		<footer id="colophon" class="site-footer container clearfix" role="contentinfo">

			<div id="footer-text" class="site-info">
				<h3>LOJAS LOGO</h3>
				<?php
				wp_nav_menu( array(
				    'theme_location' => 'atalhos-menu',
				    'menu_class' => 'footer-menu' ) );
				?>
				<p style="margin-top: 100px;"><?php do_action( 'palm_beach_footer_text' ); ?></p>
			</div><!-- .site-info -->

			<div id="footer-text" class="site-info">
				<h3>LISTA DE ATALHOS</h3>
				<?php
				wp_nav_menu( array(
				    'theme_location' => 'footer-menu',
				    'menu_class' => 'footer-menu' ) );
				?>
			</div><!-- .site-info -->


			<div id="footer-text"  class="site-info">
				<h3>SAC LOJA LOGO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0800-701-0316</h3>
				<a href="" class="button-boleto">
					<i class="fa fa-barcode" style="margin-top: 12px;float:left;border-right:1px solid #58595b;"></i>
					<p>SOLICITAR 2ª VIA DO BOLETO</p>
				</a>
			</div>

		</footer><!-- #colophon -->

	</div>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
