

		</div>
		<!-- /wrapper -->			
		<!-- footer -->
			<footer class="footer" role="contentinfo">
				<div class="container">
					<div class="col-md-4">
						<?php html5blank_nav_footer(); ?>
					</div>
					<div class="col-md-4">
						<?php html5blank_nav_atalhos(); ?>
						
					</div>
					<div class="col-md-4">
						<!-- copyright -->
						<p class="copyright">
							&copy; <?php echo date('Y'); ?>, <?php bloginfo('name'); ?>. Todos os direitos reservados.
						</p>
						<!-- /copyright -->
					</div>
				</div>
			</footer>
			<!-- /footer -->

		<?php wp_footer(); ?>

		<!-- analytics -->
		<script>
		(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
		(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
		l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
		ga('send', 'pageview');
		</script>

		
    <!-- Bootstrap core JavaScript -->
		<script src="<?php echo get_template_directory_uri(); ?>/vendor/jquery/jquery.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/lib/jquery.easing.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/vendor/popper/popper.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/vendor/bootstrap/js/bootstrap.min.js"></script>

	</body>
</html>
