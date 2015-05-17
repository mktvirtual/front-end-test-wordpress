<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main div element.
 *
 * @package Odin
 * @since 2.2.0
 */
?>

			</div><!-- #main -->
	</div><!-- .container -->
		<footer id="footer" role="contentinfo">

			<div class="site-info">
				<div class="social_info">
					<ul>
						<a href="https://www.facebook.com/mktvirtual" target="_blank"><li><i class="fa fa-facebook"></i></li></a>
						<a href="https://twitter.com/mktvirtual" target="_blank"><li><i class="fa fa-twitter"></i></li></a>
						<a href="http://instagram.com/mktvirtual" target="_blank"><li><i class="fa fa-instagram"></i></li></a>
						<a href="http://youtube.com/mktvirtual" target="_blank"><li><i class="fa fa-youtube"></i></li></a>
						<a href="http://www.mktvirtual.com.br/novidades/feed/" target="_blank"><li><i class="fa fa-rss"></i></li></a>
					</ul>
				</div>
				<div class="author_info">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/assinatura.png" align="right">
				</div>
				
			</div><!-- .site-info -->
		</footer><!-- #footer -->
	

	<?php wp_footer(); ?>
</body>
</html>
